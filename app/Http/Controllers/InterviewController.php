<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Interview;
use App\Models\Question;
use Auth;

class InterviewController extends Controller {
    public function __construct(){ $this->middleware('auth'); }

    public function index(){
        $user = Auth::user();
        if($user->role === 'candidate'){
            // show available interviews
            $interviews = Interview::with('questions')->latest()->get();
        } else {
            $interviews = Interview::with('questions')->where('created_by',$user->id)->get();
        }
        return view('interviews.index', compact('interviews'));
    }

    public function create(){
        // $this->authorize('create', Interview::class); // optional
        return view('interviews.create');
    }

    public function store(Request $r){
        $r->validate([
            'title'=>'required|string|max:255',
            'description'=>'nullable|string',
            'questions'=>'required|array|min:1',
            'questions.*'=>'required|string'
        ]);
        $interview = Interview::create([
            'title'=>$r->title,
            'description'=>$r->description,
            'created_by'=>Auth::id()
        ]);
        foreach($r->questions as $i => $q){
            Question::create(['interview_id'=>$interview->id, 'text'=>$q, 'order'=>$i]);
        }
        return redirect()->route('interviews.index')->with('success','Interview created');
    }

    public function show(Interview $interview){
        $interview->load('questions');
        return view('interviews.show', compact('interview'));
    }
}
