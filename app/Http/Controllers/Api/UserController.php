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
            return User::where('slug', $slug)
                ->with(['posts' => function($query) {
                    $query->orderBy('id', 'desc')->take(7);
                }])
                ->withCount('posts')
                ->firstOrFail();

        return User::findOrFail($this->id);
    }

    /**
     * Retrieve user followers.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function followers(Request $request)
    {
        $type = (int) $request->input('type');
        
        return User::findOrFail($this->id)->followedByUsers($type)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function following(Request $request)
    {
        $type = (int) $request->input('type');

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

        $type = (int) $request->input('type');

        $result = User::findOrFail(Auth::id())
            ->followsUsers()
            ->toggle([$id, ['type' => $type ?? 0]]);

        return response($result, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (Auth::id() !== $id) abort(403);

        $user = User::findOrFail($id)->delete();
        
        return response("Deleted", 200);
    }
}
