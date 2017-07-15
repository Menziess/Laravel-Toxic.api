<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        
        if ($topics->isEmpty()) $topics = \App\Topic::top()->take(7)->get();

        return view('home')->with('topics', $topics);
    }

    // /*
 	//  * Show logs.
 	//  */
	// public function getLogs(Request $request)
	// {
    //     if (\Auth::id() != 1) redirect('/'); 
	// 	$url = '../storage/logs/laravel.log';
	// 	$lines = null;
	// 	$file = [];
	// 	if (file_exists($url)) {
	// 		$file = file($url);
	// 		$length = count($file);
	// 		for ($i = 0; $i < 1000; $i++) {
	// 			$lines[$i] = $file[$length - ($i + 1)] . "\n";
	// 			if (preg_match("/Stack trace:/", $lines[$i])) {
	// 				break;
	// 			}
	// 		}
	// 		$lines = array_reverse($lines);
	// 	}

	// 	return view('errors.logs', compact('lines'));
	// }

	// /**
	//  * Delete logs.
	//  */
	// public function deleteLogs(Request $request)
	// {
	// 	if (\Auth::id() != 1) return;
	// 	$url = '../storage/logs/laravel.log';
	// 	$msg = 'No log file.';
	// 	if (file_exists($url)) {
	// 		unlink($url);
	// 		$msg = 'Logs cleared!';
	// 	}
	// 	return redirect('/logs')->with('message', $msg);		
	// }
}
