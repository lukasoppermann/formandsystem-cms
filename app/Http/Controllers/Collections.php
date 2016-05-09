<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class Collections extends Controller
{
    public function index(){
        $data = [
            'navigation' => [
                'header' => [
                    'title' => 'Collections',
                    'link' => '/',
                ],
                'lists' => [
                    [
                        'title' => 'test',
                        'slug'  => 'slug',
                        'items' => [
                            [
                                'label' => 'News',
                                'link'  => '/pages',
                                'icon'  => 'stack',
                            ],
                            [
                                'label' => 'Blog',
                                'link'  => '/page-2',
                                'icon'  => 'page',
                                'is_active' => true,
                            ],
                            [
                                'label' => 'Gallery',
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
