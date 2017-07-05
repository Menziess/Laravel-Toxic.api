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
        // Set Json-API spec header
        $response = $next($request);
        $response->headers->set('Content-Type', 'application/vnd.api+json');
        
        // Contains the response content
        $content = [];

        // Extract content
        $data = isset($response->original)
            ? self::transform($response->original) 
            : $response;
        
        // If data is object
        $content['data'] = is_object($data) ? $this->finalizeData($data) : $data;
        $content['links'] = $this->finalizeLinks($data, $request);

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
     * Extracts data from transformed content.
     */
    private function finalizeData($data)
    {
        switch ($data) {
            case $data instanceof Paginator:
                return $data->getCollection();
                break;
            case $data instanceof Model:
                return [$data];
                break;
            default:
                return $data;
                break;
        }
    }

    /**
     * Extracts links from paginator.
     */
    private function finalizeLinks($data, Request $request)
    {
        if (!$data instanceof Paginator)
            return ['self' => $request->url()];
        return [
            'self' => $data->currentPage(),
            'first' => null,
            'prev' => $data->previousPageUrl(),
            'next' => $data->nextPageUrl(),
            'last' => null,
        ];
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
        $collection = $paginator->map(function($item, $key) {
            return self::transformModel($item);
        });

        $paginator->setCollection($collection);

        return $paginator;
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
