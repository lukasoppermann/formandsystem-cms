<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Requests;

class Site extends Settings
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

    public function show(){
        // overwrite $page with site
        $page = 'site';
        // get navigation
        $data['navigation'] = $this->buildNavigation('/settings/'.$page);

        return view('settings.'.$page, $data);
    }
}
