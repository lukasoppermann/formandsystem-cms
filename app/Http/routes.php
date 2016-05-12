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
    Route::get('/settings/site', 'Site@show');
    Route::get('/settings/developers', 'Developers@show');
    Route::get('/settings/api-access', 'ApiAccess@show');
});


Route::get('/users', 'Users@index');
Route::get('/users/{user}', 'Users@show');
