<?php

namespace App\Http\Middleware;

use App, Closure;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use \Illuminate\Pagination\Paginator;
use \Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Collection;

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
        // Sets up Json-API spec response
        $response = $next($request);
        $response->headers->set('Content-Type', 'application/vnd.api+json');
        $content = [];

        $inputData = $response->original;

        // Extract content from request and tranforms it
        $links = self::extractLinksFromPaginator($inputData)
            ?? ['self' => $request->url()];
        $data = isset($inputData)
            ? self::transform($inputData) 
            : $response;
        $data = $inputData instanceof Model
            ? [$data] : $data;
        
        // Sets up keys for data and links
        $content['data'] = $data;
        $content['links'] = $links;

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
     * Extracts links from paginator.
     */
    private static function extractLinksFromPaginator($paginator)
    {
        if ($paginator instanceof Paginator)
        return [
            'self' => $paginator->url($paginator->currentPage()),
            'first' => $paginator->url(1),
            'prev' => $paginator->previousPageUrl(),
            'next' => $paginator->nextPageUrl(),
            'last' => null,
        ];
    }

    /**
     * Transform content.
     */
    private static function transform($content) 
    {
        switch ($content) {
            case $content instanceof Model:
                return self::transformModel($content);
                break;
            case $content instanceof Paginator:
                return self::transformPaginator($content);
                break;
            case $content instanceof Collection:
                return self::transformCollection($content);
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
     * 
     * @return Array
     */
    private static function transformPaginator(Paginator $paginator, $recursive = true)
    {
        $collection = $paginator->map(function($item, $key) use ($recursive) {
            return self::transformModel($item, $recursive);
        });

        return $collection;
    }

    /**
     * Transform collection.
     *
     * @return Array
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
     * 
     * @return Array
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
                if (!$relation) return;
                return self::transform($relation, false);
            }, $model->getRelations());

            $relations = array_filter($relations, function($relation) {
                return ($relation);
            });

            if (!$relations) return $array;
            return array_merge($array, [
                'relationships' => $relations
            ]);
        }
    }
}
