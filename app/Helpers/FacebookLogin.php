<?php

namespace App\Helpers;

use \App\User;
use \App\Resource;
use Illuminate\Http\Request;

class FacebookLogin
{
	const FACEBOOK_SCOPES = ['public_profile', 'email', 'user_birthday', 'user_location'];
	const FACEBOOK_FIELDS = ['first_name', 'last_name', 'email', 'location', 'birthday', 'gender', 'updated_time'];

	/**
	 * Redirect the user to the Facebook authentication page.
	 *
	 * @return Response
	 */
	public static function redirectToFacebook()
	{
		return \Socialite::driver('facebook')->scopes(self::FACEBOOK_SCOPES)->redirect();
	}

	/**
	 * Obtain the user information from Facebook.
	 *
	 * @return Response
	 */
	public static function handleFacebookCallback()
	{
		try {
			$fb = \Socialite::driver('facebook')->fields(self::FACEBOOK_FIELDS)->user();
		} catch (\Exception $e) {
			return redirect('/');
		}
		
		$user = User::withTrashed()->where('facebook_id', $fb->id)->first();
				
		# Get user or create new user
		if ($user) {
			self::fillUser($user, $fb);
		} else if ($user = self::checkExistingEmail($fb)) {
			$user->facebook_id = $fb->id;
			self::fillUser($user, $fb);			
		} else {
			$user = User::firstOrNew(['facebook_id' => $fb->id]);
			self::fillUser($user, $fb);
		}

		# Logs user in with remember me set on true
		\Auth::login($user, true);
	}

	/**
	* Fills user attributes from fb socialite instance.
	*
	* @return void
	*/
	private static function fillUser($user, $fb)
	{
		# Restore trashed users.
		if ($user->trashed()) $user->restore();

		# Check if user needs to be updated
		if ($user->updated_at && !\Carbon\Carbon::parse($fb->user['updated_time'])->gt($user->updated_at)) {
			$user->save();
			return;
		}

		# Name, email and gender
		$user->first_name = isset($fb->user['first_name']) ? $fb->user['first_name'] : null;
		$user->last_name = isset($fb->user['last_name']) ? $fb->user['last_name'] : null;
		$user->email = isset($fb->user['email']) ? $fb->user['email'] : null;
		$user->gender = isset($fb->user['gender']) ? $fb->user['gender'] : null;
		$user->save();		

		# Birthday
		if (isset($fb->user['birthday'])) {
			$user->date_of_birth =
				\Carbon\Carbon::parse($fb->user['birthday'])->toDateTimeString();
		};

		# Avatar
		if (isset($fb->avatar_original) || isset($fb->avatar)) {
			if (!$user->resource) {
				self::uploadAvatar($user, $fb);
			}
		}

		# Location
		if (isset($fb->user['location'])) {
			self::setLocation($user, $fb);
		}

		$user->save();
	}

	/**
	* Checks if user has avatar, then uploads new.
	*
	* @return void
	*/
	private static function uploadAvatar($user, $fb)
	{
		$path =  $fb->avatar_original ?: $path =  $fb->avatar;

		$resource = new Resource;
		$filepath = $resource->uploadImagePath($path, 522, 522);

		# Persist if uploaded succesfully
		if (\Storage::exists($filepath)) {
			$resource->user()->associate($user)->save();
			$user->resource()->associate($resource)->save();
		}
	}

	/**
		* Sets users latitude and longitude.
		*
		* @return  void
		*/
	private static function setLocation($user, $fb)
	{
		$url = 'https://maps.googleapis.com/maps/api/geocode/json'
				. '?address=' . urlencode($fb->user['location']['name'])
				. '&key=' . \Config::get('services.google.key');
		$response = json_decode(file_get_contents($url),true);
		if (isset($response['results'][0]['geometry']['location'])) {
			$user->latitude = $response['results'][0]['geometry']['location']['lat'];
			$user->longitude = $response['results'][0]['geometry']['location']['lng'];
		}
	}

	/**
	* Email exists in database.
	*
	* @return App\User
	*/
	private static function checkExistingEmail($fb)
	{
		if (!isset($fb->user['email'])) {
			return;
		}

		$user = User::where('email', $fb->user['email'])->whereNull('facebook_id')->first();
		return $user;
	}
}
