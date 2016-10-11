<?php

namespace App\Http\Controllers;
// FROM OLD CONTENT
use Formandsystem\Content\Entities\User;
use Illuminate\Http\Request;
//
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(Request $request){
       \Debugbar::startMeasure('user','Get Current User');
       // get current user
       config(['app.user' => new User(auth()->user())]);
   }
}
