<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Helpers\FacebookLogin;
use App\Http\Controllers\Controller;
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
      	$this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return Response
     */
    public function redirectToFacebook(Request $request)
    {
        return FacebookLogin::redirectToFacebook();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return Response
     */
    public function handleFacebookCallback(Request $request)
    {
        $destination = self::getDestination($request);

		FacebookLogin::handleFacebookCallback();
		return redirect($this->redirectTo)->with('destination', $destination);
	}

    /**
     * Get destination from request referer.
     */
    private static function getDestination(Request $request) 
    {
        $referer = $request->header('referer');
        $server_name = \Config::get('services.server.name');
        $php_self = \Config::get('services.server.php_self');

        $remove_all_before = $server_name . $php_self . '/';
        $exploded = explode($remove_all_before, $referer);
        $end = end($exploded);

        return $end == "" ? null : $end;
    }
}
