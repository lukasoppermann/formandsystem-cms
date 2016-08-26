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

Route::get('/', function () {
    return view('welcome');
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
    // $team->owner_id = App\Models\User::first()->getKey();
    // $team->name = 'My awesome team';
    // $team->save();
    // App\Models\User::first()->attachTeam(App\Models\Team::first());
    // dd(App\Models\User::first()->currentTeam);
});



Route::get('verification/error', 'Auth\RegisterController@getVerificationError');
Route::get('verification/{token}', 'Auth\RegisterController@getVerification');

Route::group(['middleware' => ['auth'/*'role:see'*/]], function () {
    // UserVerification::generate(Auth::user());


    Route::get('/home', 'HomeController@index');

});


/**
 * Teamwork routes
 */
Route::group(['prefix' => 'teams', 'namespace' => 'Teamwork'], function()
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
