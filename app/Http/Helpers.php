<?php

namespace App\Http;

use Auth;

class Helpers 
{
    /**
     * Return api token.
     */
    static function api_token() {
        return Auth::user() ? Auth::user()->api_token : null;
    }
}