<?php

namespace App;

use App\Helpers\JsonAble;
use App\Helpers\SlugAble;
use App\Notifications\ResetPassword;
use App\Notifications\VerifyAccount;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements SlugAble
{
    use Notifiable, JsonAble, SoftDeletes;

		const ANIMALS = ['bird-icon.png', 'duck-icon.png', 'rabbit-icon.png', 'black-cat-icon.png', 'seal-icon.png', 'bulldog-icon.png', 'fish-icon.png', 'shark-icon.png', 'bunny-icon.png', 'frog-icon.png', 'sheep-icon.png', 'cardinal-icon.png', 'hamster-icon.png', 'squid-icon.png', 'chicken-icon.png', 'jellyfish-icon.png', 'squirrel-icon.png', 'cow-icon.png', 'kitten-icon.png', 'tropical-fish-icon.png', 'crab-icon.png', 'lobster-icon.png', 'tuna-icon.png', 'dachshund-icon.png', 'mouse-icon.png', 'turkey-icon.png', 'dog-icon.png', 'octopus-icon.png', 'turtle-icon.png', 'dolphin-icon.png', 'pig-icon.png', 'whale-icon.png', 'donkey-icon.png', 'puppy-icon.png'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'facebook_id', 'first_name', 'last_name', 'slug', 'email', 'password', 'api_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'confirmation_code', 'remember_token', 'api_token', 'email', 'latitude', 'longitude',
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
        'picture',
		'name',
    ];

	/**
	 * Cast dates to Carbon instance.
	 *
	 * @var array
	 */
	protected $dates = [
		'date_of_birth',
	];

	/**
 	 * Automatically included relations.
  	 *
  	 * @var array
 	 */
	protected $with = [
		//
	];

	/**
     * User posts.
     */
    public function posts()
    {
        return $this->hasMany('App\Post')
			->with('user');
    }

	/**
     * User topics.
     */
    public function topics()
    {
        return $this->hasMany('App\Topic');
    }

	/*
	 * User profile picture.
	 */
	public function resource()
	{
		return $this->belongsTo('App\Resource');
	}

	/*
	 * User resources.
	 */
	public function resources($type = null)
	{
		return $this->hasMany('App\Resource')
			->where('type', $type);
	}

	/**
	 * Uses likes on posts.
	 */
	public function likes(int $type = null)
	{
		$query = $this->belongsToMany('App\Post');
		if ($type) $query->wherePivot('type', $type);
		return $query->withTimestamps()->withPivot('type');
	}

	/**
	 * Users relation.
	 */
	public function follows(int $type = null)
	{
		$query = $this->belongsToMany('App\User', 'user_user', 'user_id', 'related_id');

		if ($type) return $query->wherePivot('type', $type);
		
		return $query->withTimestamps();
	}

    /*
	 * Users liked profiles.
	 */
	public function followedBy(int $type = null)
	{
		$query = $this->belongsToMany('App\User', 'user_user', 'related_id', 'user_id');

		if ($type) return $query->wherePivot('type', $type);
		
		return $query->withTimestamps();
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
	public function getNameAttribute()
	{
		return $this->first_name . ' ' . $this->last_name;
	}

	/*
	 * Get profile picture.
	 */
	public function getPictureAttribute()
	{
		$image = null;
		if ($this->resource) 
			$image = 'storage/images/' . $this->resource->url . $this->resource->extension;
		else if ($this->id == 1)
			$image = 'img/default.png';
		else
			$image = 'img/animals/' . static::ANIMALS[$this->id % count(static::ANIMALS)];
		if ($image) 
			return asset($image);
			return asset('img/toxic.png');
	}

	/*
	 * Make slug to access user profile.
	 */
	public function makeSlug() 
	{
		$slug = strtolower($this->first_name . '-' . $this->last_name);
		$ext = null;
		while (self::where('slug', $slug . $ext)->exists()) {
			if (!$ext) {
				$ext = '.' . rand(1, 999);
			}
		}
		$this->slug = $slug . $ext;
	}

	/*
	 * Called when a user is deleted.
	 */
	public function deletePersonalData()
	{
		$this->confirmed = false;
		$this->save();
		
		if ($this->resource) {
            $this->resource->removeFromStorage();
			$this->resource->delete();
        }
	}

	/**
	 * Send the password reset notification.
	 *
	 * @param  string  $token
	 * @return void
	 */
	public function sendPasswordResetNotification($token)
	{
		$this->notify(new ResetPassword($token));
	}

	/**
	 * Send the account verification notification.
	 *
	 * @param  string  $token
	 * @return void
	 */
	public function sendPasswordVerificationNotification($token)
	{
		$this->notify(new VerifyAccount($token));
	}
}
