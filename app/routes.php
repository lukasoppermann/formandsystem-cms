<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'ContentController@index'); // replace with dashboard

Route::get('/content/{lang?}/{link?}', 'ContentController@index');

Route::get('users', function()
{
    $users = User::all();
    
    return View::make('users')->with('users', $users);
});

Route::get('/{lang?}/{link?}', 'ContentController@index');