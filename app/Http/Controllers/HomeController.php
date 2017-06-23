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
     * Show landing page.
     *
     * @return \Illuminate\Http\Response
     */
    public function landing()
    {
        $goodQuotes = [
            ["If freedom of speech is taken away, then dumb and silent we may be led, like sheep to the slaughter.", "George Washington"],
        ];

        $badQuotes = [
            ["You take the blue pill, the story ends. You wake up in your bed and believe whatever you want to believe.", "Hollywood Actor"],
        ];

        return view('welcome', [
            "goodQuote" => $goodQuotes[rand(0, count($goodQuotes) - 1)],
            "badQuote" => $badQuotes[rand(0, count($badQuotes) - 1)],
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
