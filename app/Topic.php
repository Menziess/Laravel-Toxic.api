<?php

namespace App;

use App\Helpers\SlugAble;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model implements SlugAble
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
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

    /*
	 * Make slug to access original topic.
	 */
	public function makeSlug() {
		$slug = strtolower($this->first_name . '-' . $this->last_name);
		$ext = null;
		while (self::where('slug', $slug . $ext)->exists()) {
			if (!$ext) {
				$ext = '.' . rand(1, 999);
			}
		}
		$this->slug = $slug . $ext;
	}
}
