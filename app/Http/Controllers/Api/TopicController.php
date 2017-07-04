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
     * Retrieve popular topics.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = Topic::popular()->take(7)->get();

        if ($topics->isEmpty()) $topics = Topic::top()->take(7)->get();

        return $topics;
    }

    /**
     * Retrieve topic information.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function slug(String $slug = null)
    {
        if (!$slug) return self::index();

        return Topic::where('slug', $slug)
            ->withCount('posts')
            ->with('user')
            ->first();
    }
}
