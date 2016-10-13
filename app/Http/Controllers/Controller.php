<?php

namespace App\Http\Controllers;
// FROM OLD CONTENT
use Formandsystem\Content\Entities\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $user;

    public function __construct(Request $request){
       $this->middleware(function ($request, $next) {
           // setup in here
            // config(['app.user' => new User(Auth::user())]);
            // config(['app.active_account' => config('app.user')->currentTeam()->id]);
            // dd(config('app.user')->account());
            // config(['app.account' => config('app.user')->account()]);
            // if($client = config('app.user')->account()->details('type','cms_client',true)){
            //     config(['app.user_client' => $client->get('data')]);
            // }
            // \Config::set('site_url', config('app.user')->account()->metadetails('type','site_url', true)->get('data'));
            // \Config::set('img_dir', config('app.user')->account()->metadetails('type','dir_images', true)->get('data'));
            // // GRID
            // \Config::set('custom.fragments', config('app.user')->account()->details()->where('type','fragment')->keyBy('name'));
            // GRID
            \Config::set('user.grid-sm',2);
            \Config::set('user.grid-md',12);
            \Config::set('user.grid-lg',16);

            return $next($request);
        });
       // get current user
    //    dd($this->user);

   }
}
