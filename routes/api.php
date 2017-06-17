<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/tokencheck', function(Request $request) {
    dd($request->request);
});

Route::group(['middleware' => 'auth:api', 'namespace' => 'Api'], function() {
    Route::resource('post', 'PostController', ['except' => ['create', 'edit']]);
});
