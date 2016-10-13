<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    public function show()
    {
        return view('teamwork.settings.project');
    }
}
