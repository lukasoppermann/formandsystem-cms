<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class Users extends Controller
{
    public function index(){
        return view('dashboard.welcome');
    }
    public function show(){
        $data = [
            'navigation' => [
                'header' => [
                    'title' => 'Users',
                    'link' => '/',
                ],
                'lists' => [
                    [
                        'items' => [
                            [
                                'label' => 'Profile',
                                'link'  => '/users/me',
                                'icon'  => 'stack',
                            ],
                        ]
                    ]
                ]
            ]
        ];
        return view('dashboard.welcome', $data);
    }
}
