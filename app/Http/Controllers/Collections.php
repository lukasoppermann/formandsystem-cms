<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class Collections extends Controller
{

    /**
     * main navigation array
     *
     * @var array
     */
    protected $navigation = [
        'header' => [
            'title' => 'Collections',
            'link' => '/',
        ],
    ];

    public function index(){
        $data['navigation'] = $this->buildNavigation('/collections');

        return view('dashboard.welcome', $data);
    }

}
