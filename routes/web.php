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
    $user = App\User::findOrFail(2);
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

/*
|--------------------------------------------------------------------------
| Secure Routes
|--------------------------------------------------------------------------
|
| After logging in, the authentication routes should be accessible for
| registered users. 
|
*/

// Route::middleware('auth')->group(function () {
//     Route::get('/logs', 'HomeController@getLogs');
//     Route::delete('/logs', 'HomeController@deleteLogs');
// });

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

Route::middleware(['web', 'guest'])->group(function() {
    Route::namespace('Auth')->group(function() {
        Route::post('/login', 'LoginController@login')->name('login');    
        Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('/password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('/password/reset', 'ResetPasswordController@reset');
        Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
        Route::get('/register', 'RegisterController@showRegistrationForm')->name('register');
        Route::post('/register', 'RegisterController@register');
    });
});

Route::middleware(['web'])->group(function() {
    
    Route::namespace('Auth')->group(function() {
        Route::group(['prefix' => 'login'], function() {
            Route::get('/facebook', 'LoginController@redirectToFacebook')->name('facebooklogin');
            Route::get('/facebook/callback', 'LoginController@handleFacebookCallback');
        });
        Route::get('/verify/{token}', 'VerificationController@verify')->name('verify.token');
        Route::post('/logout', 'LoginController@logout')->name('logout');
    });

    Route::get('/{vue_capture?}', 'HomeController@index')
        ->where('vue_capture', '[\/\w\.-]*')
        ->name('home');

    Route::get('{catchall}', 'HomeController@index')
        ->name('home');
});