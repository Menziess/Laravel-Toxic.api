<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VerificationController extends Controller 
{
  	/**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/';

  	/**
     * Verifies user account.
     *
     * @return Response
     */
    public function verify(string $token)
    {
        User::where('confirmation_code', $token)->update(['confirmed' => true]);
		
        return redirect($this->redirectTo);
    }

    /**
     * Resends verification email.
     */
    public function newToken(Request $request)
    {
        $user = $request->user('api');
        $user->sendPasswordVerificationNotification($user->confirmation_code);

        return response("New verification email sent.", 200);
    }
}