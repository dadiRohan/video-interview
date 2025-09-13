<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Interview;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $user = Auth::user();

        if ($user->role === 'admin' || $user->role === 'reviewer') {
            // Show interviews created or all, depending on your needs
            $interviews = Interview::latest()->get();
            return view('dashboard.admin', compact('interviews'));
        }

        if ($user->role === 'candidate') {
            $interviews = Interview::latest()->get();
            return view('dashboard.candidate', compact('interviews'));
        }

        return view('home');
    }
}
