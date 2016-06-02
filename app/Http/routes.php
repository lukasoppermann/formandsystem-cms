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
// login
Route::get('/login','Auth\AuthController@showLoginForm');
Route::post('/login','Auth\AuthController@login');
Route::get('/logout','Auth\AuthController@logout');
// Reset password
Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
Route::post('password/reset', 'Auth\PasswordController@reset');
// CMS
Route::group(['middleware' => ['auth']], function(){

    Route::get('/','Dashboard@index');
    Route::get('/collections', 'Collections@index');
    // Images
    Route::put('/images', 'Images@upload');
    // Settings
    Route::group(['namespace' => 'Pages'], function() {
        Route::get('/pages', 'Pages@index');
        Route::get('/pages/{page}', 'Pages@show');
        Route::get('/pages/create', 'Pages@store');
        Route::get('/pages/delete/{id}', 'Pages@delete');

        Route::patch('/pages', 'Pages@update');
    });
    // Fragments
    Route::group(['namespace' => 'Fragments'], function() {
        Route::get('/fragments/{type}', 'Fragments@store')->where('type', 'section|text|image');
        Route::get('/fragments/delete/{id}', 'Fragments@delete');

        Route::patch('/fragments/{id}', 'Fragments@update');
    });
    // Settings
    Route::group(['namespace' => 'Settings'], function() {
        // Developers
        Route::get('/settings/developers/{item?}', 'Developers@show');
            // Developers / Client
            Route::post('/settings/developers/api-access', 'ApiAccess@store');
            Route::delete('/settings/developers/api-access', 'ApiAccess@delete');
            // Developers / Database
            Route::post('/settings/developers/database', 'Database@store');
            Route::delete('/settings/developers/database', 'Database@delete');
            // Developers / Database
            Route::post('/settings/developers/ftp', 'Ftp@store');
            Route::delete('/settings/developers/ftp', 'Ftp@delete');

        // Site
        Route::get('/settings/{site?}', 'Site@show');
        Route::post('/settings/site', 'Site@update');
    });


    Route::get('/users', 'Users@index');
    Route::get('/users/{user}', 'Users@show');
});
