<?php

namespace App\Http\Controllers;

use Spatie\Menu\Laravel\MenuFacade as Menu;
use Illuminate\Http\Request;
use Spatie\Menu\Html;

class Dashboard extends Controller
{
    /**
     * index
     *
     * @method index
     *
     * @return View
     */
    public function index(){
        return view('dashboard.welcome');
    }
}
