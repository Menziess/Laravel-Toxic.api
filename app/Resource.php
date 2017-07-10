<?php

namespace App;

use Image;
use Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
	use SoftDeletes;

	const TYPES = [
		0 => 'image',
		1 => 'video',
		2 => 'audio',
	];

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'resources';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'url',
		'type',
		'mime',
		'extension',
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
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = [
		'updated_at',
		'created_at',
		'deleted_at',
	];

	/*
	 * Relation with user.
	 */
	public function user()
	{
		return $this->belongsTo('App\User');
	}

	/*
	 * Relation with post.
	 */
	public function post()
	{
		return $this->belongsTo('App\Post');
	}

	/*
	 * Scope where type is.
	 */
	public function scopeWhereType($query, string $type)
	{
		return $query->where('type', $type);
	}

	/**
	 * Create new image from file.
	 *
	 * @param  File    $file
	 * @param  integer $width
	 * @param  integer $height
	 * @return string  $filepath
	 */
	public function uploadImageFile($file, $width = 256, $height = 256)
	{
		$image = Image::make($file)->orientate()->fit($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });

		$this->url = self::generateName();
		$this->type = self::TYPES[0];
		$this->mime = $file->getClientMimeType();
		$this->extension = '.' . $file->getClientOriginalExtension();
		return self::storeImage($image);
	}

	/**
	 * Create new image from path.
	 *
	 * @param  string  $path
	 * @param  integer $width
	 * @param  integer $height
	 * @return string  $filepath
	 */
	public function uploadImagePath($path, $width = 256, $height = 256, $aspectratio = false)
	{
		if ($aspectratio)
		$image = Image::make($path)->orientate()->fit($width, $height, function ($constraint) {
			$constraint->aspectRatio();
		});
		else 
		$image = Image::make($path)->orientate()->resize($width, $height);

		$this->url = self::generateName();
		$this->type = self::TYPES[0];
		$this->mime = $image->mime();
		$this->extension = '.' . pathinfo($path, PATHINFO_EXTENSION)
			?: $this->getExtension($this->mime);
		return self::storeImage($image);
	}

	/**
	 * Check if images folder exists.
	 */
	private function checkImagesFolderExists()
	{
		if (!file_exists(storage_path('app/public/images'))) {
			mkdir(storage_path('app/public/images'), 0777, true);
		}
	}

	/**
	 * Store image in storage.
	 *
	 * @param  Image 	$image
	 * @return string 	$filepath
	 */
	private function storeImage($image)
	{
		$this->checkImagesFolderExists();
		$filepath = 'public/images/' . $this->url . $this->extension;
		$image->interlace();
		$image->save(storage_path('app/' . $filepath));

		return $filepath;
	}

	/**
	 * Remove from storage.
	 *
	 * @param  string $file url + extension
	 * @return void
	 */
	public function removeFromStorage()
	{
		$filepath = 'public/images/' . $this->url . $this->extension;
		Storage::delete($filepath);
		$this->delete();
	}

	/**
	 * Generate a new name, that can be used as file/resource name.
	 *
	 * @return string
	 */
	public static function generateName()
	{
		return md5(uniqid(rand(), true));
	}

	/**
	 * Use mime type to get a guessed extension.
	 *
	 * @param  string $mime_type
	 * @return string $extension
	 */
	private static function getExtension ($mime_type) {
		$extensions = [
			'image/jpeg' => '.jpeg',
			"image/png" => '.png',
			"image/gif" => '.gif',
			'text/xml' => '.xml',
			"image/x-ms-bmp" => '.bmp',
		];
		return $extensions[$mime_type];
	}
}