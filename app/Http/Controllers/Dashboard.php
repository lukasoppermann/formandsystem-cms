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
                        'title' => 'test',
                        'slug'  => 'slug',
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
