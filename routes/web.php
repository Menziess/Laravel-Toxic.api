<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Login Routes
|--------------------------------------------------------------------------
|
| Auth routes are overridden by manual logout and login routes ensuring
| that the default login and register page are not accessible, while
| still keeping the same route names for the uncommenting of:
|
|
*/

Route::group(['namespace' => 'Auth'], function() {

    Route::post('/logout', 'LoginController@logout')->name('logout');
    Route::get('/login', 'LoginController@redirectToFacebook')->name('login');
    
    Route::group(['prefix' => 'login'], function() {
        Route::get('/facebook', 'LoginController@redirectToFacebook')->name('login/facebook');
        Route::get('/facebook/callback', 'LoginController@handleFacebookCallback');
    });
});

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
|
| After logging in, the authentication routes should be accessible for
| registered users. 
|
*/

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
});
