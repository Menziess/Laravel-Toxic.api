<?php

namespace App\Http;

use Auth;
use App\Helpers\JsonSpec;

class Helpers 
{
    /**
     * Return api token.
     */
    static function api_token() {
        return Auth::user() ? Auth::user()->api_token : null;
    }

    /**
     * Convert input to JSON spec.
     */
    static function jsonify($model) {
        return json_encode(JsonSpec::transform($model));
    }
}