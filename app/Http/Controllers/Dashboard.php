<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }
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
