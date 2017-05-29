<?php

namespace App;

use App\Helpers\JsonAble;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, JsonAble, SoftDeletes;

	const PLACEHOLDER_PICTURE = 'img/Toxic-logo.png';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'facebook_id', 'first_name', 'last_name', 'slug', 'email', 'password', 'data',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
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
		'date_of_birth',
	];

    /*
	 * User resources.
	 */
	public function resources($type = null)
	{
		return $this->hasMany(Resource::class)
			->where('type', $type);
	}

    /*
	 * User profile picture.
	 */
	public function resource()
	{
		return $this->belongsTo(Resource::class);
	}

    /*
	 * Scope where name is like
	 */
	public function scopeSearch($query, string $search = null)
	{
		if (!$search) {
			return $query;
		}
		return $query->where('first_name', 'like', '%' . $search . '%')
			->orWhere('last_name', 'like', '%' . $search . '%');
	}

	/*
	 * Get full user name.
	 */
	public function getName()
	{
		return $this->first_name . ' ' . $this->last_name;
	}

    /*
	 * Get profile picture.
	 */
	public function getPicture()
	{
		$image = $this->resource
			? 'storage/images/' . $this->resource->url . $this->resource->extension
			: self::PLACEHOLDER_PICTURE;
		return $image;
	}

	/*
	 * Make slug to access user profile.
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
