<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    private $id;

    public function __construct(Request $request)
    {
        $this->id = $request->user('api')->id;
    }

    /**
     * Retrieve user by slug.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function slug(String $slug = null)
    {
        if ($slug)
            return User::where('slug', $slug)->firstOrFail();

        return User::findOrFail($this->id);
    }

    /**
     * Retrieve user followers.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function followers(String $type = null)
    {
        return User::findOrFail($this->id)->followers($type)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function following(String $type = null)
    {
        return User::findOrFail($this->id)->following($type)->get();
    }
}
