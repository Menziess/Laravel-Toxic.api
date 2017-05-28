<?php

namespace App\Http\Controllers;

use Socialite;

class LoginController extends Controller
{
    const FACEBOOK_SCOPES = ['public_profile', 'email', 'user_birthday', 'user_location'];
    const FACEBOOK_FIELDS = ['first_name', 'last_name', 'email', 'location', 'birthday', 'gender', 'updated_time'];

    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return Response
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->scopes(self::FACEBOOK_SCOPES)->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return Response
     */
    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->fields(self::FACEBOOK_FIELDS)->user();

        dd($user);

    }
}