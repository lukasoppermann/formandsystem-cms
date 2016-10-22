<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/



Route::group(['middleware' => ['web']], function () {

    Auth::routes();
    // needed to avoid post
    Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

    Route::get('/users/me', function(){
        return 'not implements';
    })->name('users.me');

    Route::group(['middleware' => ['guest'/*'role:see'*/]], function () {
        Route::get('/', function () {
            return redirect('/login');
        });
    });

    Route::get('/', function () {
        return redirect()->route('dashboard.index');
    });

    Route::group([
            'prefix'     => 'support',
            'namespace'  => 'Support',
            'middleware' => ['auth'/*,'role:see'*/],
        ], function () {
        Route::get('/', 'Support@index')->name('support.index');
    });


    Route::get('/roles', function () {
        // dd(Auth::user());
        // UserVerification::generate(Auth::user());
        // UserVerification::send(Auth::user(), 'My Custom E-mail Subject');
        // $role = Role::create(['name' => 'admin']);
        // $permission = Permission::create(['name' => 'edit articles']);
        // $permission = Permission::create(['name' => 'see']);
        // $role = Role::first();
        // $role->givePermissionTo('edit articles');
        // $role->givePermissionTo('see');
        // Auth::user()->givePermissionTo('see');
        // Auth::user()->assignRole('admin');
        // $team   = new App\Models\Team();
        // $team->owner_id = Auth::user()->getKey();
        // $team->name = 'Copra';
        // $team->save();
        // Auth::user()->attachTeam(App\Models\Team::first());
    });

    // Route::get('email-verification/error', 'Auth\RegisterController@getVerificationError');
    // Route::get('email-verification/{token}', 'Auth\RegisterController@getVerification')->name('email-verification.check');
    Route::get('email-verification-resend', function(){
        UserVerification::generate(Auth::user());
        UserVerification::send(Auth::user());
        session('email-verification.wasResend', \Carbon\Carbon::now());
        return back()->with([
            'email-verification.resend' => true
        ]);
    })->name('email-verification.resend');

    Route::group(['middleware' => ['auth'/*'role:see'*/]], function () {

        Route::get('/dashboard', 'Dashboard@index')->name('dashboard.index');
        Route::get('/test', 'Dashboard@index');
        Route::get('/news', 'Dashboard@index');

    });


    /**
     * Teamwork routes
     */
    Route::group(['prefix' => 'projects', 'namespace' => 'Teamwork', 'middleware' => ['auth']], function()
    {
        Route::get('/', 'TeamController@index')->name('teams.index');
        Route::get('create', 'TeamController@create')->name('teams.create');
        Route::post('teams', 'TeamController@store')->name('teams.store');
        Route::get('edit/{id}', 'TeamController@edit')->name('teams.edit');
        Route::put('edit/{id}', 'TeamController@update')->name('teams.update');
        Route::delete('destroy/{id}', 'TeamController@destroy')->name('teams.destroy');
        Route::get('switch/{id}', 'TeamController@switchTeam')->name('teams.switch');

        Route::get('/settings/team/{id}', 'TeamMemberController@show')->name('teams.members.show');
        Route::get('/settings/team/resend/{invite_id}', 'TeamMemberController@resendInvite')->name('teams.members.resend_invite');
        Route::post('/settings/team/{id}', 'TeamMemberController@invite')->name('teams.members.invite');
        Route::delete('/settings/team/{id}/{user_id}', 'TeamMemberController@destroy')->name('teams.members.destroy');

        Route::get('accept/{token}', 'AuthController@acceptInvite')->name('teams.accept_invite');
    });
    /**
     * Settings routes
     */
    Route::group(['prefix' => 'projects', 'namespace' => 'Settings', 'middleware' => ['auth']], function()
    {
        Route::get('/settings', 'ProjectController@show')->name('teams.settings');

        Route::get('/settings/project', 'ProjectController@show')->name('teams.settings.project');
        Route::put('/settings/project', 'ProjectController@update')->name('teams.settings.project.put');

        Route::get('/settings/seo', 'SiteController@show')->name('teams.settings.seo');
        Route::get('/settings/developers', 'SiteController@show')->name('teams.settings.developers');
    });
}); // <- close web middle group
