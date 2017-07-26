<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use LinkPreview\LinkPreview;
use LinkPreview\Model\VideoLink;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use \Illuminate\Database\Eloquent\Model;
use App\Post, App\User, Auth;

class PostController extends Controller
{
    public function __construct(Request $request)
    {
        $this->user = $request->user('api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Adding reply_count, likes_count and dislikes_count
        $query = $this->startQuery();

        // Only get original posts with relations
        $query->original()->with(['user']);

        // Paginate using query params
        return $this->finishQuery($query, $request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Request\StorePostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request, LinkPreview $linkPreview)
    {
        $post = new Post;
        $post->fill($request->all());
        $user = Auth::user();

        if ($request->input('attachment') == "drawing")
            self::addDrawing($request, $post);
        if ($request->input('attachment') == "url")        
            self::addLink($request, $post, $linkPreview);

        $post->user()->associate($user)->save();

        return response($post, 201);
    }

    /**
     * Parses url and adds information to the post.
     */
    private static function addLink($request, $post, $linkPreview)
    {
        # URL's have to be parsed and previewed
        $resource = new \App\Resource;
        $linkPreview = new LinkPreview($request->input('url'));
        $parsed = $linkPreview->getParsed();

        foreach ($parsed as $parserName => $link) {
            $resource->realurl = $link->getUrl();
            $resource->title = utf8_decode($link->getTitle());
            $resource->description = utf8_decode($link->getDescription());

            # If a image is given, otherwise a default is set
            if ($image = $link->getImage()) {
                if (substr($image, 0, 4) !== "http") {
                    $realurl = $link->getRealUrl();
                    $image = $realurl->getScheme() . '://' . $realurl->getHost() . $image;
                }
                $image = preg_replace('"\.jpg:large$"', '.jpg', $image);
                $filepath = $resource->uploadImagePath($image, 522, 294, true);
            } else {
                $filepath = $resource->uploadImagePath(asset('img/no-image.webp'), 522, 294, true);
            }
            
            # Adds youtube embed
            if ($link instanceof VideoLink) {
                $resource->embed = $link->getVideoId();
            }
        }

        # Persist
        $resource->save();
        $post->resource()->associate($resource);
    }

    /**
     * Stores drawing and adds url to post.
     */
    private static function addDrawing($request, $post)
    {
        # Drawings have to be uploaded
        $drawing = $request->input('drawing');
        $uri = substr($drawing, strpos($drawing,",") + 1);
        $resource = new \App\Resource;
        $filepath = $resource->uploadImagePath($uri, 522, 294);

        # Persist if uploaded succesfully
        if (\Storage::exists($filepath)) {
            $resource->save();
            $post->resource()->associate($resource);
        }
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
    public function slug($slug, $id = null, Request $request)
    {
        if ($id) {
            return $this->show($slug, $id, $request);
        }

        // Adding reply_count, likes_count and dislikes_count
        $query = $this->startQuery();

        // Only get original posts with relations
        $query->where('slug', $slug)->with('user');

        // Paginate using query params
        return $this->finishQuery($query, $request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug, $id, Request $request)
    {
        $query = Post::with(['user', 'replies', 'resource'])
            ->where('slug', $slug)
            ->withCount('replies')
            ->withLikes($this->user->id)
            ->findOrFail($id);
            
        $amount = $request->input('amount');
        $skip = $request->input('skip');

        if (!$amount)
            return $query;
        
        return $this->finishQuery($query->replies()->skip($skip)->take($amount), $request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(StorePostRequest $request, $id)
    // {
    //     $post = Post::findOrFail($id);
    //     $post->update($request->all());

    //     return $post;
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->user->id == 1) abort(403);

        $post = Post::findOrFail($id);
        if ($this->user->id != $post->user_id) abort(403);
        $post->delete();
        
        return response("Deleted", 200);
    }

    /**
     * User likes a post.
     *
     * @return \Illuminate\Http\Response
     */
    public function like($id)
    {
        if ($this->user->id == 1) abort(403);
        
        return $this->likeOrDislike($id, 1);
    }

    /**
     * User dislikes a post.
     *
     * @return \Illuminate\Http\Response
     */
    public function dislike($id)
    {
        if ($this->user->id == 1) abort(403);
        
        return $this->likeOrDislike($id, 0);
    }

    /**
     * Query setting the like or dislike on a post.
     */
    private function likeOrDislike($id, $like)
    {
        $user = $this->user->load(['likes' => function($query) use ($id) {
            $query->find($id);
        }]);

        if ($user->likes->count() < 1) {
            $user->likes()->attach($id, ['type' => $like]);
        } else if ($user->likes[0]->pivot->type == $like) {
            $user->likes()->detach($id);
        } else {
            $user->likes()->updateExistingPivot($id, ['type' => $like]);            
        }

        $post = Post::withLikes($this->user->id)->findOrFail($id);

        if (count($user->likes))
            return response($post, 201);
        return response($post, 200);
    }

    /**
     * Generic setup querying post resources.
     */
    private function startQuery()
    {
        return Post::orderBy('id', 'desc')
            ->original()
            ->withCount('replies')
            ->withLikes($this->user->id);
    }

    /**
     * Generic pagination for post resources.
     */
    private function finishQuery($query, Request $request)
    {
        if ($after = $request->input('after'))
        $query->where('id', '<', $after);
        else if ($before = $request->input('before'))
        $query->where('id', '>', $before);
        if ($amount = $request->input('amount'))
        return $query->take($amount)->get();
        return $query->take(7)->get();
    }
}
