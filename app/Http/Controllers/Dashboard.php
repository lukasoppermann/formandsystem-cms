<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class Dashboard extends Controller
{
    public function index(){
        $data = [
            'navigation' => [
                'header' => [
                    'title' => 'Form&System',
                ],
                'lists' => [
                    [
                        'items' => [
                            [
                                'label' => 'Pages',
                                'link'  => '/pages',
                            ],
                            [
                                'label' => 'Collections',
                                'link'  => '/collections',
                            ],
                            [
                                'label' => 'Settings',
                                'link'  => '/settings',
                            ],
                            [
                                'label' => 'Users',
                                'link'  => '/users',
                            ],
                            [
                                'label' => 'Profile',
                                'link'  => '/users/me',
                            ],
                        ]
                    ]
                ]
            ]
        ];
        return view('dashboard.welcome', $data);
    }
}
