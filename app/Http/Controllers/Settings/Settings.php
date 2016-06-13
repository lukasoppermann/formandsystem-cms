<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Http\Controllers\Controller;

class Settings extends Controller
{

    protected $navigation = [
        'header' => [
            'title' => 'Settings',
            'link' => '/',
        ],
        
    ];
}
