<?php

namespace App;

use App\Helpers\JsonAble;
use App\Helpers\SlugAble;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model implements SlugAble
{
    use JsonAble, SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id', 'attachment', 'subject', 'text', 'drawing', 'url',
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

    /**
	 * Users that liked post.
	 */
	public function likedByUsers(int $type = null)
	{
		$query = $this->belongsToMany('App\User');

		if ($type) return $query->wherePivot('type', $type);
		
		return $query->withTimestamps();
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
     * Scope original posts. 
     */
    public function scopeOriginal($query)
    {
        return $query->whereNull('post_id');
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
}
