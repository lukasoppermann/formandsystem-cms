<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GrahamCampbell\Binput\Facades\Binput;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $user = new \App\Models\User([
        //     'name' => 'jo',
        //     'email' => 'Test',
        //     'password' => 'yo'
        // ]);
        //
        // $user = \App\Models\User::find(5);
        // $user->new_Test = 'Test';
        // $user->save();
        // return $user->getMetaAttributes();
        return view('home');
    }
}
