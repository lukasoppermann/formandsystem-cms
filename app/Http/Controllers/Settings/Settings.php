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
        'lists' => [
            [
                'items' => [
                    [
                        'label' => 'Site',
                        'link'  => '/settings/site',
                    ],
                    [
                        'label' => 'Developers',
                        'link'  => '/settings/developers',
                    ],
                    [
                        'label' => 'Logout',
                        'link'  => '/logout',
                    ],
                ]
            ]
        ]
    ];
}
