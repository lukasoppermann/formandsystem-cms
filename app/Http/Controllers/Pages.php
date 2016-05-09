<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class Pages extends Controller
{
    public function index(){
        $data = [
            'navigation' => [
                'header' => [
                    'title' => 'Pages',
                    'link' => '/',
                ],
                'lists' => [
                    [
                        'title' => 'test',
                        'slug'  => 'slug',
                        'items' => [
                            [
                                'label' => 'Page 1',
                                'link'  => '/pages',
                                'icon'  => 'page',
                            ],
                            [
                                'label' => 'Page 2',
                                'link'  => '/page-2',
                                'icon'  => 'page',
                                'is_active' => true,
                            ],
                            [
                                'label' => 'Page 3',
                                'link'  => '/page-3',
                                'icon'  => 'page-2',
                            ],
                        ]
                    ]
                ]
            ]
        ];
        return view('dashboard.welcome', $data);
    }
}
