<?php

namespace App\Http\Controllers\Teamwork;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function show($section = null)
    {
        if($section === null){
            return redirect()->route('teams.settings', 'site');
        }
        return view('teamwork.settings.site');
    }
}
