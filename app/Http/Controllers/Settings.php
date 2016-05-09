<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

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
                        'label' => 'API Access',
                        'link'  => '/settings/api-access',
                    ],
                ]
            ]
        ]
    ];

    public function show($page = 'site'){
        // get navigation
        $data['navigation'] = $this->buildNavigation('/settings/'.$page);

        return view('settings.'.$page, $data);
    }
}
