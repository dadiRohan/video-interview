<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\ReviewerController;

Auth::routes();

Route::get('/', function(){ return redirect('/home'); });
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/* Interviews */
Route::get('/interviews', [InterviewController::class,'index'])->name('interviews.index');
Route::get('/interviews/create', [InterviewController::class,'create'])->name('interviews.create');
Route::post('/interviews', [InterviewController::class,'store'])->name('interviews.store');
Route::get('/interviews/{interview}', [InterviewController::class,'show'])->name('interviews.show');

/* Submissions */
Route::post('/submissions', [SubmissionController::class,'store'])->name('submissions.store');

/* Reviewer */
Route::get('/reviewer/submissions', [ReviewerController::class, 'index'])
    ->name('reviewer.submissions');

Route::post('/reviewer/submissions/{submission}/review', [ReviewerController::class, 'review'])
    ->name('reviewer.submissions.review');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
