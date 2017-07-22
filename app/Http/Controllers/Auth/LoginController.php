<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Helpers\FacebookLogin;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
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
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      	// $this->middleware('guest')->except('logout');
    }

    /**
     * Overrides default login method.
     *
     * @return Response
     */
    public function login(LoginUserRequest $request) 
    {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            $request->session()->regenerate();

            $this->clearLoginAttempts($request);

            if ($request->ajax())
            return \Auth::user();
            return $this->authenticated($request, $this->guard()->user())
                    ?: redirect()->intended($this->redirectPath());
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
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
		return redirect($this->redirectTo);
	}
}
