<?php

namespace App;

use App\Helpers\JsonAble;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends Model
{
    use JsonAble, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug', 'subject',
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
     * Get related posts.
     */
    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    /*
	 * Scope where popular.
	 */
	public function scopePopular($query)
	{
        $yesterday = \Carbon\Carbon::now()->subDays(1);

		return $query->whereHas('posts', function($query) use ($yesterday) {
            $query->where('created_at', '>=', $yesterday);
        })->withCount('posts')
          ->orderBy('posts_count', 'desc'); 
	}

    /*
	 * Scope where popular all time.
	 */
    public function scopeTop($query)
    {
        return $query->has('posts')
            ->withCount('posts')
            ->orderBy('posts_count', 'desc');
    }

    /*
	 * Scope where slug is like.
	 */
	public function scopeSearch($query, string $search = null)
	{
		if (!$search) {
			return $query;
		}
		return $query->where('subject', 'like', '%' . $search . '%');
	}
}
