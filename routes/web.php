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
