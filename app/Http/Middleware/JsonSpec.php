<?php

namespace App\Http\Middleware;

use App, Closure;
use \Illuminate\Support\Collection;

class JsonSpec
{
    const APPLICATION_JSON = 'application/json';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Set Json-API spec header
        $response = $next($request);
        $response->headers->set('Content-Type', 'application/vnd.api+json');

        
        // Contains the content
        $content = [];


        // Extract content
        $data = json_decode($response->getContent());
        $content['data'] = $data ?: [];


        // When an exception is included
        if ($response->exception) {
            $private = [
                'source' => [
                    'file' => $response->exception->getFile(),
                    'line' => $response->exception->getLine(),
                ],
                'detail' => $response->exception->getTrace(),
            ];
            $public = [
                'status' => $response->status(),
                'title' => $response->exception->getMessage(),
            ];
            App::environment('production') ? 
                $errors = $public :
                $errors = array_merge($public, $private);

            $content['errors'] = $public;
        }


        // Adds links
        $links = [
            'self' => $request->url(),
            // 'first' => ,
            // 'prev' => ,
            // 'next' => ,
            // 'last' => '
        ];
        $content['links'] = $links;


        // Manually arranges content
        $response->setContent(json_encode($content));
        return $response;
    }

    private static function transformCollection(Collection $collection)
    {

    }

    private static function transformPaginator($paginator)
    {

    }

    private static function transformModel($model)
    {

    }
}
