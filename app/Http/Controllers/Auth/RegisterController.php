<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if ($data['g-recaptcha-response']) {
            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $ch = curl_init($url);
            $xml = "secret=" . \Config::get('services.google.captcha_client_secret') . "&response=" . $data['g-recaptcha-response'];

            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            $response = json_decode($response);
            curl_close($ch);
        } 

        $success = isset($response) ? $response->success : false;
        $data['g-recaptcha-response'] = $success;

        return Validator::make($data, [
            'g-recaptcha-response' => 'bail|required|accepted',
            'first_name' => 'required|string|max:100|regex:/^[(a-zA-Z\s-)]+$/u',
            'last_name' => 'required|string|max:100|regex:/^[(a-zA-Z\s-)]+$/u',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'first_name' => ucwords(strtolower($data['first_name'])),
            'last_name' => ucwords(strtolower($data['last_name'])),
            'email' => ucwords(strtolower($data['email'])),
            'password' => bcrypt($data['password']),
        ]);
    }
}
