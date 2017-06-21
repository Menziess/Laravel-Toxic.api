<?php

namespace App\Http\Controllers\Api;

use App\Topic;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;

class TopicController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function slug(String $slug)
    {
        $topic = Topic::where('slug', $slug)->with('posts')->first();
        if (!isset($topic->posts))
            return new Collection();
        return $topic->posts;
    }
}
