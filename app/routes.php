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

/*
* Login Form
*/
Route::get('/login', function()
{
		Optimization::css(array('reset', 'layout'));
		return View::make('user.login'); //, array('title' => "Please login")
});
/*
* Login request
*/
Route::post('/login', function()
{
	if (Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password'))))
	{
	  return Redirect::intended('dashboard');
	}
	else
	{
		return Redirect::to('/login')->with(array('error' => 'Wrong email address or password', 'email' => Input::get('email')));
	}
});
/*
* Logout route
*/
Route::get('/logout', function()
{
	Auth::logout();
	return Redirect::to('/');
});

Route::group(array('before' => 'auth'), function()
{
	Route::get('/', 'DashboardController@index'); // replace with dashboard
	Route::get('/dashboard', 'DashboardController@index'); // replace with dashboard
	//
	// Content Controller
	Route::resource('/content', 'contentController', 
					array( 'except' => array('edit') ) 
	);
	
	// Route::get('/content/{lang?}/{link?}', 'ContentController@index');
	// 
	// Route::post('/content/{lang?}/{link?}', 'ContentController@store');

	Route::controller('users', 'UsersController');

	// Route::get('/{lang?}/{link?}', 'ContentController@index');
});

Route::group(array('prefix' => 'api/v1', 'before' => 'auth.basic'), function()
{
    Route::resource('stream', 'ApiController');
});


