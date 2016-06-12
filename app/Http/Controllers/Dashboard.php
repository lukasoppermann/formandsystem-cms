<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class Dashboard extends Controller
{
    /**
     * main navigation array
     *
     * @var array
     */
    protected $navigation = [
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
                        'link'  => '/settings/site',
                    ],
                    // [
                    //     'label' => 'Users',
                    //     'link'  => '/users',
                    // ],
                    // [
                    //     'label' => 'Profile',
                    //     'link'  => '/users/me',
                    // ],
                ]
            ]
        ]
    ];
    /**
     * index
     *
     * @method index
     *
     * @return View
     */
    public function index(){
        return view('dashboard.welcome');
    }
}
