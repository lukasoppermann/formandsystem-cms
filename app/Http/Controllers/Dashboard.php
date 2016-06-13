<?php

namespace App\Http\Controllers;

use App\Services\Api\CollectionService;
use Illuminate\Http\Request;

use App\Http\Requests;

class Dashboard extends Controller
{
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
    /**
     * main navigation array
     *
     * @var array
     */
    public function getMenu()
    {
        $this->navigation = [
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
                    ]
                ],
                [
                    'title' => 'Collections',
                    'items' => (new CollectionService)->find('type', 'posts',[
                            'includes' => false
                        ])->map(function($item){
                            return $item->put('link', 'collections/'.$item->slug)
                            ->put('label', $item->name)
                            ->put('icon', 'collection');
                        })->toArray()
                ],
                [
                    'items' => [
                        [
                            'label' => 'Media',
                            'link'  => '/media',
                        ],
                        [
                            'label' => 'Fragments',
                            'link'  => '/fragments',
                        ],
                        [
                            'label' => 'Settings',
                            'link'  => '/settings/site',
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
        ];
    }
}
