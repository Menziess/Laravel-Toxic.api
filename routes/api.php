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

Route::middleware('web')->namespace('Api')->group(function() {
    Route::post('/logout', 'LoginController@logout');
    Route::get('/login', 'LoginController@redirectToFacebook');
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
    Route::resource('post', 'PostController', ['except' => ['create', 'edit']]);
    Route::get('t/{slug}', 'TopicController@slug');
    Route::get('u/{slug}', 'UserController@slug');
});
