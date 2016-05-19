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
    // Develoepr
    Route::get('/settings/developers', 'Developers@show');
    Route::post('/settings/developers/database', 'Database@store');
    Route::post('/settings/developers/{item}', 'Developers@store');
    Route::delete('/settings/developers/{item}', 'Developers@delete');

    Route::get('/settings/{site?}', 'Site@show');
});


Route::get('/users', 'Users@index');
Route::get('/users/{user}', 'Users@show');
