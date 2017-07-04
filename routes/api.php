<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
|
| Auth routes are overridden by manual logout and login routes ensuring
| that the default login and register page are not accessible, while
| still keeping the same route names for the uncommenting of:
|
|
*/

Route::namespace('Api')->group(function() {
    Route::post('/log', 'ErrorController@log');
    Route::post('/logout', 'LoginController@logout');
    Route::get('/login', 'LoginController@redirectToFacebook');
    
    Route::get('post', 'PostController@index');
    Route::get('post/{id}', 'PostController@show')->where('id', '[0-9]+');
    Route::get('post/{slug}/{id?}', 'PostController@slug')->where('id', '[0-9]+');

    Route::get('t/{slug?}', 'TopicController@slug');

    Route::get('u/{slug?}', 'UserController@slug');
    Route::get('u/{slug}/followers', 'UserController@followers');
    Route::get('u/{slug}/following', 'UserController@following');
});

/*
|--------------------------------------------------------------------------
| Secure API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->namespace('Api')->group(function() {
    Route::post('post', 'PostController@store');
    Route::put('post/{id}', 'PostController@update');
    Route::delete('post/{id}', 'PostController@destroy');
});
