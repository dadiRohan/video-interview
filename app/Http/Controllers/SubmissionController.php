<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Interview;
use App\Models\Submission;
use Auth;
use Storage;

class SubmissionController extends Controller {
    public function __construct(){ $this->middleware('auth'); }

    // candidate: upload recorded video for question
    public function store(Request $r){
        $r->validate([
            'interview_id'=>'required|exists:interviews,id',
            'question_id'=>'required|exists:questions,id',
            'video'=>'required|file|mimetypes:video/webm,video/mp4|max:51200' // max 50MB
        ]);

        $candidate = Auth::id();
        $path = $r->file('video')->store('submissions','public');

        $submission = Submission::create([
            'interview_id'=>$r->interview_id,
            'question_id'=>$r->question_id,
            'candidate_id'=>$candidate,
            'video_path'=>$path
        ]);

        return back()->with('success','Uploaded');
    }

    // reviewer: list submissions
    public function index(){
        $user = Auth::user();
        if(!in_array($user->role, ['admin','reviewer'])) abort(403);
        $submissions = Submission::with(['question','candidate','interview'])->latest()->get();
        return view('reviewer.submissions', compact('submissions'));
    }

    // reviewer: update score/comment
    public function review(Request $r, Submission $submission){
        $this->authorize('review',$submission); // optional
        $r->validate(['score'=>'nullable|integer|min:0|max:100','comment'=>'nullable|string']);
        $submission->update(['score'=>$r->score,'comment'=>$r->comment]);
        return back()->with('success','Saved');
    }
}
