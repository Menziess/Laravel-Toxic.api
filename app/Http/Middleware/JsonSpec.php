<?php

namespace App\Http\Middleware;

use App, Closure;
use Illuminate\Http\Response;
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
        $data = isset($response->original)
            ? self::transform($response->original) 
            : $response;  
        $content['data'] = $data;

        // When an exception is included
        if (isset($response->exception)) {
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
            case is_array($content):
                return $content;
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
    private static function transformCollection(Collection $collection, $recursive = true)
    {
        $array = [];
        foreach ($collection as $model) {
            $array[] = self::transformModel($model, $recursive);
        }

        return $array;
    }

    /**
     * Transform model.
     */
    private static function transformModel(Model $model, $recursive = true)
    {
        $path = explode('\\', get_class($model));
        $classname = strtolower(end($path)) . 's';
        $attributes = $model->attributesToArray();

        unset($attributes['id']);
        
        $array = [
            'id' => $model->id,
            'type' => $classname,
            'attributes' => $attributes,
        ];

        if (!$recursive) {
          
            return $array;

        } else {
            $relations = array_map(function($relation) {
                // return $relation;
                return self::transform($relation, false);
            }, $model->getRelations());

            return array_merge($array, [
                'relationships' => $relations
            ]);
        }
    }
}
