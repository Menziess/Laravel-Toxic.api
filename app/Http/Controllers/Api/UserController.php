<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function slug(String $slug = null, Request $request)
    {
        if ($slug)
            return User::where('slug', $slug)->firstOrFail();

        return User::findOrFail($request->user('api')->id);
    }

    public function myFollowers(String $type = null)
    {
        return User::followedBy()->get();
    }
}
