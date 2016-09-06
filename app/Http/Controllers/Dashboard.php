<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('dashboard.index');
    }
}
