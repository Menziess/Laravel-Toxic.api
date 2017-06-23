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
    public function index(Request $request)
    {
        // At first visit to this website, the landing page is presented
        if (!$request->cookie('laravel_session')) return redirect('landing');

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
            ["Hypocrites get offended by the truth.", "Jess C. Scott, Bad Romance: Seven Deadly Sins Anthology"],
            ["Everyone has the right to freedom of opinion and expression; this right includes freedom to hold opinions without interference and to seek, receive and impart information and ideas through any media and regardless of frontiers.", "United Nations, Universal Declaration of Human Rights"],
            ["Whoever would overthrow the liberty of a nation must begin by subduing the freeness of speech.", "Benjamin Franklin, Silence Dogood, The Busy-Body, and Early Writings"],
            ["My own opinion is enough for me, and I claim the right to have it defended against any consensus, any majority, anywhere, any place, any time. And anyone who disagrees with this can pick a number, get in line, and kiss my ass.", "Christopher Hitchens"],
            ["Once a government is committed to the principle of silencing the voice of opposition, it has only one way to go, and that is down the path of increasingly repressive measures, until it becomes a source of terror to all its citizens and creates a country where everyone lives in fear.", "Harry Truman"],
            ["Censorship is to art as lynching is to justice.", " Henry Louis Gates Jr."],
            ["I may not agree with you, but I will defend to the death your right to make an ass of yourself.", "Oscar Wilde"],
            ["If liberty means anything at all, it means the right to tell people what they do not want to hear.", "George Orwell"],
            ["A country without a border is like a person in a house without a front door. Anybody can enter and you cannot ask anybody to leave.", "Geert Wilders"],
            ["Where there is no freedom of speech, there is no conscience.", "Ayaan Hirsi Ali"],
            ["If you try to discuss multiculturalism in the UK you're labelled a racist. But here we're still free to talk, and I say multicultural society doesn't work. We're not living closer, we're living apart.", "Pim Fortuyn"],
            ["You take the red pill, you stay in Wonderland, and I show you how deep the rabbit hole goes.", "Morpheus"],
        ];

        $badQuotes = [
            ["You take the blue pill, the story ends. You wake up in your bed and believe whatever you want to believe.", "Laurence Fishburne"],
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
