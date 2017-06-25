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
        if (!$request->cookie('laravel_session')) 
            return redirect('landing');
        
        return view('home');
    }

    /**
     * Show landing page.
     *
     * @return \Illuminate\Http\Response
     */
    public function landing()
    {
        return view('welcome');
    }

    // /**
    //  * Show posts of a particular topic.
    //  *
    //  * @param  \Illuminate\Http\Request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function topic(String $slug, TopicController $topicController, Request $request) 
    // {
    //     if (!$request->cookie('laravel_session')) 
    //         return redirect('landing')->with('destination', $request->fullUrl());
        
    //     return view('home', [
    //         'posts' => $topicController->slug($slug)
    //     ]);
    // }

    // /**
    //  * Show profile of a particular user.
    //  *
    //  * @param  \Illuminate\Http\Request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function user(String $slug, UserController $userController, Request $request) 
    // {
    //     if (!$request->cookie('laravel_session')) 
    //         return redirect('landing')->with('destination', $request->fullUrl());

    //     return view('user', [
    //         'users' => $userController->slug($slug)
    //     ]);
    // }
}
