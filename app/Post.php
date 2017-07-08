<?php

namespace App;

use App\Helpers\JsonAble;
use App\Helpers\SlugAble;
use Illuminate\Database\Eloquent\Model;

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
        'drawing',
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
	 * Post drawing.
	 */
	public function resource()
	{
		return $this->belongsTo('App\Resource');
	}

    /**
     * Get the owner.
     */
    public function parent()
    {
        return $this->belongsTo('App\Post');
    }

    /**
     * Get the owner.
     */
    public function replies()
    {
        return $this->hasMany('App\Post')->with('user');
    }

    /**
     * Get the owner.
     */
    public function topic()
    {
        return $this->belongsTo('App\Topic');
    }

    /**
	 * Post liked by user.
	 */
	public function likes(int $type = null)
	{
		$query = $this->belongsToMany('App\User');
		if ($type) $query->wherePivot('type', $type);
		return $query->withTimestamps();
	}

    public function scopeWithLikes($query, int $userId = null)
    {
        $query->withCount(['likes', 'likes AS dislikes' => function($query) {
                $query->where('type', 0);
            }])
            ->withCount(['likes', 'likes AS likes' => function($query) {
                $query->where('type', 1);
            }]);
        if ($userId)
            $query->with(['likes' => function($query) use ($userId) {
                $query->where('id', $userId)->withPivot('type');
            }]);
        return $query;
    }

    /**
     * Scope original posts. 
     */
    public function scopeOriginal($query)
    {
        return $query->whereNull('post_id');
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
