<?php

namespace App\Http\Controllers\Auth;

use App\User;
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
        $user = User::where('confirmation_code', $token)->firstOrFail();

        if ($user) 
            $user->update(['confirmed' => true])->save();
        else
            return "Not Verified, the code is not valid.";

        return redirect($this->redirectTo);
    }
}