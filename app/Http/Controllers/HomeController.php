<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TopicController;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // At first visit to this website, the landing page is presented
        if (!$request->cookie(env('session.cookie'))) 
            $request->session()->flash('destination', $request->path());
        
        $topics = \App\Topic::popular()->take(7)->get();

        return view('home')->with('topics', $topics);
    }
}
