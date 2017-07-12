<?php

namespace App;

use Illuminate\Http\Request;
use App\Helpers\JsonAble;
use App\Helpers\SlugAble;
use Illuminate\Database\Eloquent\Model;

use Auth;

class Post extends Model implements SlugAble
{
    use JsonAble;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id', 'attachment', 'subject', 'text', 'url',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

	/**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
    ];

    /**
     * The attributes that are mutated with the model.
     *
     * @var array
     */
    protected $appends = [
        'drawing', 'replies_count',
    ];

	/**
	 * Cast dates to Carbon instance.
	 *
	 * @var array
	 */
	protected $dates = [
		//
	];

    /**
     * Get the owner.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /*
	 * Post drawing or attachment.
	 */
	public function resource()
	{
		return $this->belongsTo('App\Resource');
	}

    /**
     * Get post that has been replied to.
     */
    public function parent()
    {
        return $this->belongsTo('App\Post');
    }

    /**
     * Get related topic.
     */
    public function topic()
    {
        return $this->belongsTo('App\Topic');
    }

    /**
     * Get replies on post.
     */
    public function replies()
    {
        return $this->hasMany('App\Post')
            ->withCount('likes')
            ->orderBy('likes_count', 'desc')
            ->with('user')
            ->withConversations(4)
            ->withLikes();
    }

    /**
     * Get replies in the form of a conversation on post.
     */
    public function conversation()
    {
        return $this->hasMany('App\Post');
    }

    /**
	 * Users who liked post.
	 */
	public function likes(int $type = null)
	{
		$query = $this->belongsToMany('App\User');
		if ($type) $query->wherePivot('type', $type);
		return $query->withTimestamps();
	}

    /**
     * Scope original posts. 
     */
    public function scopeOriginal($query)
    {
        return $query->whereNull('post_id');
    }

    /**
     * Loads conversation replies.
     */
    public function scopeWithConversations($query, int $depth = 4)
    {
        if ($depth < 1) return $query; // Prevent endless depth of conversations
        return $query->with(['conversation' => function($query) use ($depth) {
            $query->withCount('likes')
                ->orderBy('likes_count', 'desc')
                ->with('user')
                ->withCount('replies')
                ->withConversations(--$depth)
                ->withLikes()
                ->get();
        }]);
    }

    /**
	 * Add like and dislike counts, as well as authenticated user like.
	 */
    public function scopeWithLikes($query)
    {
        $query->withCount(['likes', 'likes AS dislikes' => function($query) {
                $query->where('type', 0);
            }])
            ->withCount(['likes', 'likes AS likes' => function($query) {
                $query->where('type', 1);
            }]);
        if (auth('api')->id())
            $query->with(['likes' => function($query) {
                $query->where('id', auth('api')->id())->withPivot('type');
            }]);
        return $query;
    }

    /**
     * Get reply count.
     */
    public function getRepliesCountAttribute()
    {
        return $this->replies()->count();
    }

    /*
	 * Get drawing.
	 */
	public function getDrawingAttribute()
	{
        if (!count($this->resource)) return null;
		$image = $this->resource
			? 'storage/images/' . $this->resource->url . $this->resource->extension
			: self::PLACEHOLDER_PICTURE;
		return asset($image);
	}

    /**
     * Mutator for subject attribute.
     */
    public function setSubjectAttribute($value)
    {
        $this->attributes['subject'] = ucwords($value);
    }

    /*
	 * Make slug to access original topic.
	 */
	public function makeSlug() {
        //Lower case everything
        $string = strtolower($this->subject);
        //Make alphanumeric (removes all other characters)
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        //Clean up multiple dashes or whitespaces
        $string = preg_replace("/[\s-]+/", " ", $string);
        //Convert whitespaces and underscore to dash
        $string = preg_replace("/[\s_]/", "-", $string);
        
		return $this->slug = $string;
	}

    /*
	 * Called when a post is deleted.
	 */
    public function deletePersonalData()
    {
        if ($this->resource) {
            $this->resource->removeFromStorage();
            $this->resource->delete();
        }
    }
}
