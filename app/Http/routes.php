<?php

Debugbar::startMeasure('routes','Routing');
Route::group(['prefix' => env('APP_PREFIX')], function () {
    // login
    Route::get('/login','Auth\AuthController@showLoginForm');
    Route::post('/login','Auth\AuthController@login');
    Route::get('/logout','Auth\AuthController@logout');
    // Reset password
    Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
    Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\PasswordController@reset');
    // CMS
    Route::group(['middleware' => ['auth','isSetup']], function(){

        Route::get('/','Dashboard@index');

        Route::group(['namespace' => 'Collections'], function() {
            // Route::get('/collections', 'Collections@index');
            Route::post('/collections', 'Collections@store');
            Route::patch('/collections/{id}', 'Collections@update');
            Route::delete('/collections/{id}', 'Collections@delete');

            Route::get('/collections/delete/{id}', 'Collections@delete');

            Route::get('/collections/{collection}/{page?}', 'Collections@show');
        });
        // Images
        Route::put('/images', 'Images@upload');
        Route::post('/images', 'Images@upload');
        Route::delete('/images/{id}', 'Images@delete');
        // Pages
        Route::group(['namespace' => 'Pages'], function() {
            Route::get('/pages', 'Pages@index');
            Route::delete('/pages/{id}', 'Pages@delete');

            Route::get('/pages/{page}', 'Pages@show');

            Route::post('/pages', 'Pages@store');

            Route::patch('/pages/{id}', 'Pages@update');
        });
        // Fragments
        Route::group(['namespace' => 'Fragments'], function() {

            Route::post('/fragments', 'Fragments@store');
            Route::patch('/fragments/{id}', 'Fragments@update');
            Route::delete('/fragments/{id}', 'Fragments@delete');

        });
        // Settings
        Route::group(['namespace' => 'Settings'], function() {
            Route::get('/settings', function(){
                return redirect('/settings/site');
            });
            // Site
            Route::get('/settings/site', 'Site@show');
            Route::post('/settings/site', 'Site@update');
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
                // Developers / Cache
                Route::post('/settings/developers/cache-code', 'Cache@store');
                Route::post('/settings/developers/bust-cache', 'Cache@bust');
        });

        Route::get('/help', 'Help@index');

        Route::get('/users', 'Users@index');
        Route::get('/users/{user}', 'Users@show');

        Route::get('/dialog/{type}', function(Illuminate\Http\Request $request, $type){
            return (new \App\Services\DialogService)->show($request, $type);
        });
    });
});
