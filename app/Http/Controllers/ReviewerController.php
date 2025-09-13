<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;

class ReviewerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show all submissions for reviewer/admin.
     */
    public function index()
    {
        $user = Auth::user();
        if (!in_array($user->role, ['admin', 'reviewer'])) {
            abort(403, 'Unauthorized');
        }

        $submissions = Submission::with(['question', 'candidate', 'interview'])
            ->latest()
            ->get();

        return view('reviewer.submissions', compact('submissions'));
    }

    /**
     * Save reviewer score and comment.
     */
    public function review(Request $request, Submission $submission)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['admin', 'reviewer'])) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'score'   => 'nullable|integer|min:0|max:100',
            'comment' => 'nullable|string|max:1000',
        ]);

        $submission->update([
            'score'   => $request->score,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Review saved successfully.');
    }
}
