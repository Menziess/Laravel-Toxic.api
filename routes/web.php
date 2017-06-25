<?php

/*
|--------------------------------------------------------------------------
| Helper routes
|--------------------------------------------------------------------------
|
| These routes should be deleted before going into production.
|
*/

Route::get('/templogin', function() {
    $user = App\User::first();
    $loggedin = Auth::check() ? 'true' : 'false';
    $api_token = null;
    if ($user) {
        $api_token = $user->api_token;
        Auth::login($user);
    }
    return [
        "logged_in" => $loggedin,
        "logged_user" => $user,
        "api_token" => $api_token,
    ];
});
Route::get('/templogout', function() {
    $user = Auth::user();
    Auth::logout($user);
    $loggedin = Auth::check() ? 'true' : 'false';
    return [
        "logged_in" => $loggedin,
        "logged_user" => $user, 
    ];
});

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

Route::namespace('Auth')->group(function() {
    Route::get('/login', 'LoginController@redirectToFacebook')->name('login');
    Route::post('/logout', 'LoginController@logout')->name('logout');

    Route::group(['prefix' => 'login'], function() {
        Route::get('/facebook', 'LoginController@redirectToFacebook')->name('login.facebook');
        Route::get('/facebook/callback', 'LoginController@handleFacebookCallback');
    });

});

Route::middleware('web')->group(function() {
    Route::get('/landing', 'HomeController@landing')->name('landing');
    Route::get('/t/{slug}', 'HomeController@topic');
    Route::get('/u/{slug}', 'HomeController@user');
    Route::get('/{vue_capture?}', 'HomeController@index')
        ->where('vue_capture', '[\/\w\.-]*')
        ->name('home');
});

/*
|--------------------------------------------------------------------------
| Secure Routes
|--------------------------------------------------------------------------
|
| After logging in, the authentication routes should be accessible for
| registered users. 
|
*/

Route::middleware('auth')->group(function () {
    //
});
