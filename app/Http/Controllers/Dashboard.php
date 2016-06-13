<?php

namespace App\Http\Controllers;

use App\Services\Api\CollectionService;
use Illuminate\Http\Request;

use App\Http\Requests;

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
