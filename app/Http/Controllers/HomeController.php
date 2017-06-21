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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = \App\Post::orderBy('id', 'desc')->take(10)->get();

        return view('home', [
            'posts' => $posts
        ]);
    }

    /**
     * Show posts of a particular topic.
     *
     * @return \Illuminate\Http\Response
     */
    public function topic(String $slug, TopicController $topicController) 
    {
        return view('home', [
            'posts' => $topicController->slug($slug)
        ]);
    }

    /**
     * Show profile of a particular user.
     *
     * @return \Illuminate\Http\Response
     */
    public function user(String $slug, UserController $userController) 
    {
        return view('user', [
            'users' => $userController->slug($slug)
        ]);
    }
}
