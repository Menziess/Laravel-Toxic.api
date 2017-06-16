<?php

namespace App\Http\Middleware;

use App, Closure;
use \Illuminate\Pagination\Paginator;
use \Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Collection;

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

        
        // Contains the response content
        $content = [];


        // Adds links
        $links = [
            'self' => $request->url(),
            // 'first' => '',
            // 'prev' => '',
            // 'next' => '',
            // 'last' => '',
        ];
        $content['links'] = $links;
        
        
        // Extract content
        $data = self::transform($response->original);  
        $content['data'] = $data;


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

            $content['errors'] = $errors;
        }


        // Manually arranges content
        $response->setContent(json_encode($content));
        return $response;
    }

    /**
     * Transform content.
     */
    private static function transform($content) 
    {
        switch ($content) {
            case $content instanceof Paginator:
                return self::transformPaginator($content);
                break;
            case $content instanceof Collection:
                return self::transformCollection($content);
                break;
            case $content instanceof Model:
                return self::transformModel($content);
                break;
            default:
                return json_decode($content);
                break;
        }
    }

    /**
     * Transform paginator.
     */
    private static function transformPaginator(Paginator $paginator)
    {
        dd("This is a paginator");
    }

    /**
     * Transform collection.
     */
    private static function transformCollection(Collection $collection)
    {
        $array = [];
        foreach ($collection as $model) {
            $array[] = self::transformModel($model);
        }

        return $array;
    }

    /**
     * Transform model.
     */
    private static function transformModel(Model $model)
    {
        $path = explode('\\', get_class($model));
        $classname = strtolower(end($path)) . 's';
        $attributes = $model->getAttributes();
        unset($attributes['id']);

        return [
            'id' => $model->id,
            'type' => $classname,
            'attributes' => $attributes,
        ];
    }
}
