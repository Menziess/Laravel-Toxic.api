<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ErrorController extends Controller
{
    /**
     * Persist error logging in log.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function log(Request $request) {
        \Log::error("Error log was sent by a browser.", [
            "data" => $request
        ]);

        return response("Error logged", 200);
    }
}
