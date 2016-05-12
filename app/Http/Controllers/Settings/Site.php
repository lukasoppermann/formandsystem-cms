<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Requests;

class Site extends Controller
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
        // generate page data
        $data = $this->{'generate'.ucfirst(camel_case($page))}();
        // get navigation
        $data['navigation'] = $this->buildNavigation('/settings/'.$page);

        return view('settings.'.$page, $data);
    }

    public function generateSite(){

    }

    public function generateDevelopers(){

    }

    public function generateApiAccess(){
        return $this->api()->get('/images');
    }
}
