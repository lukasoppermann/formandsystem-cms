<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/', 'Dashboard@index');
Route::get('/pages', 'Pages@index');
Route::get('/collections', 'Collections@index');

// Settings
Route::group(['namespace' => 'Settings'], function() {

    $user = \App\Models\User::where('email','oppermann.lukas@gmail.com')->first();
    Auth::login($user);
    // Developers
    Route::get('/settings/developers/{item?}', 'Developers@show');
        // Developers / Client
        Route::post('/settings/developers/api-access', 'ApiAccess@store');
        Route::delete('/settings/developers/api-access', 'ApiAccess@delete');
        // Developers / Database
        Route::post('/settings/developers/database', 'Database@store');
        Route::delete('/settings/developers/database', 'Database@delete');

    // Site
    Route::get('/settings/{site?}', 'Site@show');
});


Route::get('/users', 'Users@index');
Route::get('/users/{user}', 'Users@show');
