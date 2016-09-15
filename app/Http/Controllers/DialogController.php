<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Services\DialogService;
use App\Http\Requests;

class DialogController extends Controller
{
    function show(Request $request, $type){
        return (new DialogService)->show($request, $type);
    }
}
