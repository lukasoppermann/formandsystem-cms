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

Route::filter('basic.once', function()
{
    return Auth::onceBasic();
});

Route::get('/', function()
{
	return Response::json("This url does not exist.", 404);
});

Route::group(array('prefix' => 'v1', 'before' => array('basic.once')), function()
{
	// invalid url
	Route::get('/', function()
	{
		return Response::json("This url does not exist.", 404);
	});

	// stream api for content
	Route::resource('stream', 'StreamapiController');
});
