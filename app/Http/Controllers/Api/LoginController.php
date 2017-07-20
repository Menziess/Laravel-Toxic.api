<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Helpers\FacebookLogin;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      	$this->middleware('guest')->except('logout');
    }

    /**
     * Attempt to log user in. 
     *
     * @return User
     */
    public function login(LoginUserRequest $request) 
    {
        if(\Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ], true)) {
            return \Auth::user();
        } else {
            return response([
                "message" => ["Something went wrong during authentication."]
            ], 401);
        }
    }

    /**
     * Log user out.
     */
    public function logout(Request $request) {
        \Auth::logout();
    }

    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return Response
     */
    public function redirectToFacebook()
    {
        return FacebookLogin::redirectToFacebook();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return Response
     */
    public function handleFacebookCallback()
    {
		FacebookLogin::handleFacebookCallback();
	}
}
