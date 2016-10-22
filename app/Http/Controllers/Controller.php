<?php

namespace App\Http\Controllers;
// FROM OLD CONTENT
use App\Entities\User;
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
            config(['app.user' => Auth::user()]);
            config(['app.active_account' => config('app.user')->currentTeam->id]);
            config(['app.account' => config('app.user')->getProjectEntity()]);
            if($cms_id = config('app.user')->getProjectEntity()->cms_client_id){
                config(['app.user_client' => [
                    'client_id'        => $cms_id,
                    'client_secret'    => config('app.user')->getProjectEntity()->cms_client_secret,
                ]]);
            }
            dd(config('app.user')->getProjectEntity()->collections()->sortBy('position'));
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
