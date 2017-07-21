<?php

namespace App\Http\Middleware;

use App, Closure;
use App\Helpers\JsonSpec as JsonSpecification;

class JsonSpec
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return JsonSpecification::handleRequest($request, $next);
    }
}
