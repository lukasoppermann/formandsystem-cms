<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


class Pages extends Controller
{
    protected $navigation = [
        'header' => [
            'title' => 'Pages',
            'link' => '/',
        ],
    ];

    public function navigation(){
        return $this->api()->get('/pages');
    }

    public function index(){
        return $this->navigation();
        $data['navigation'] = $this->buildNavigation('/pages');
        return view('dashboard.welcome', $data);
    }

    public function show(){

    }

}
