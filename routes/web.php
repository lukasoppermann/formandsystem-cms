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
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

Auth::routes();

Route::group(['middleware' => ['guest'/*'role:see'*/]], function () {
    Route::get('/', function () {
        return redirect('/login');
    });
});

Route::group([
        'prefix'     => 'settings',
        'namespace'  => 'Settings',
        'middleware' => ['auth'/*,'role:see'*/],
    ], function () {
    Route::get('/', 'Settings@index')->name('settings.index');
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



Route::get('verification/error', 'Auth\RegisterController@getVerificationError');
Route::get('verification/{token}', 'Auth\RegisterController@getVerification');

Route::group(['middleware' => ['auth'/*'role:see'*/]], function () {
    // UserVerification::generate(Auth::user());


    Route::get('/', 'Dashboard@index')->name('dashboard.index');

});


/**
 * Teamwork routes
 */
Route::group(['prefix' => 'teams', 'namespace' => 'Teamwork', 'middleware' => ['auth','role:teams']], function()
{
    Route::get('/', 'TeamController@index')->name('teams.index');
    Route::get('create', 'TeamController@create')->name('teams.create');
    Route::post('teams', 'TeamController@store')->name('teams.store');
    Route::get('edit/{id}', 'TeamController@edit')->name('teams.edit');
    Route::put('edit/{id}', 'TeamController@update')->name('teams.update');
    Route::delete('destroy/{id}', 'TeamController@destroy')->name('teams.destroy');
    Route::get('switch/{id}', 'TeamController@switchTeam')->name('teams.switch');

    Route::get('members/{id}', 'TeamMemberController@show')->name('teams.members.show');
    Route::get('members/resend/{invite_id}', 'TeamMemberController@resendInvite')->name('teams.members.resend_invite');
    Route::post('members/{id}', 'TeamMemberController@invite')->name('teams.members.invite');
    Route::delete('members/{id}/{user_id}', 'TeamMemberController@destroy')->name('teams.members.destroy');

    Route::get('accept/{token}', 'AuthController@acceptInvite')->name('teams.accept_invite');
});
