<?php

namespace App\Http\Controllers\Api;

use Auth;
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
    public function followers(int $type = null)
    {
        return User::findOrFail($this->id)->followedByUsers($type)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function following(int $type = null)
    {
        return User::findOrFail($this->id)->followsUsers($type)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function follow($id, Request $request)
    {
        User::findOrFail($id);

        $type = $request->input['type'];

        $result = User::findOrFail(Auth::id())
            ->followsUsers()
            ->toggle([$id, ['type' => $type]]);

        return response($result, 201);
    }
}
