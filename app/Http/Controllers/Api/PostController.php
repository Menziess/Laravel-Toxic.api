<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use \Illuminate\Database\Eloquent\Model;

use App\Post, App\User, Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Post::orderBy('id', 'desc')->original()
            ->with(['user', 'replies'])
            ->withCount('replies')
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Request\StorePostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $post = new Post;
        $user = Auth::user();
        $removed = [];

        switch ($request->input('attachment')) {
            case 'text':
                $removed = ['drawing', 'url'];
                break;
            case 'drawing':
                $removed = ['text', 'url'];
                break;
            case 'url':
                $removed = ['drawing', 'text'];
                break;
        }
        
        $post->fill($request->except($removed));
        $post->user()->associate($user)->save();

        return response($post, 201);
    }

    /**
     * Manages ancestral tree and other related data.
     *
     * @param  \Illuminate\Database\Eloquent\Model $parent
     * @param  \Illuminate\Database\Eloquent\Model $child
     */
    // private function setMetaData(Model $parent, Model $child)
    // {
    //     // Get ancestral data of parent, increment amount of children
    //     $nrChildren = (int) $parent->getData('nr_of_children');
    //     $ancestors = $parent->getData('ancestor_ids');
    //     $parent->setData('nr_of_children', $nrChildren++)->save();

    //     // Pass along ancestral tree
    //     if ($ancestors) {
    //         $child->setData('ancestor_ids', array_push($ancestors, $parent->id));            
    //     } else {
    //         $child->setData('ancestor_ids', array($parent->id));
    //     }
    // }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function slug($slug, $id = null)
    {
        if ($id) {
            return $this->show($id);
        }

        return Post::whereNull('post_id')->where('slug', $slug)
            ->with(['user', 'replies'])
            ->withCount('replies')
            ->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Post::with(['user', 'replies'])
            ->withCount('replies')
            ->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->update($request->all());

        return $post;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id)->delete();
        
        return response("Deleted", 200);
    }

    /**
     * Adds action on post by user, for example like.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function like($id, Request $request)
    {
        Post::findOrFail($id);

        $type = $request->input['type'];

        $result = User::findOrFail(Auth::id())
            ->likesPosts()
            ->toggle([$id, ['type' => $type]]);

        return response($result, 201);
    }
}
