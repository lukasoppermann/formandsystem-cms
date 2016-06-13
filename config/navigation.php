<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Navigation
    |--------------------------------------------------------------------------
    |
    | Header
    |
    */
    'header' => [
        'dashboard' => [
            'title' => 'Form&System',
        ],
        'settings' => [
            'title' => 'Settings',
            'link'  => '/',
        ],
        'users' => [
            'title' => 'Users',
            'link'  => '/',
        ],
    ],
    /*
    |
    | Lists
    |
    */
    'lists' => [
        /*
        | Dashboard
         */
        'dashboard' => [
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
                'items' => 'collections',
                'item'  => 'navigation.collection-item'
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
        ],
        /*
        | Settings
         */
        'settings' => [
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
        ],
    ]
];
