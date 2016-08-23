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
        'pages' => [
            'title' => 'Pages',
            'link'  => '/',
        ],
        'users' => [
            'title' => 'Users',
            'link'  => '/',
        ],
        'Help' => [
            'title' => 'Help',
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
            // [
            //     'items' => [
            //         [
            //             'label'     => 'Pages',
            //             'link'      => '/pages',
            //         ],
            //     ]
            // ],
            [
                'title'     => 'Collections',
                'items'     => '$collections',
                'classes'   => 'c-navigation__list--dark',
                'template'  => 'navigation.item-collection'
            ],
            [
                'items' => [
                    // [
                    //     'label' => 'Media',
                    //     'link'  => '/media',
                    // ],
                    // [
                    //     'label' => 'Fragments',
                    //     'link'  => '/fragments',
                    // ],
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
                    [
                        'label' => 'Help',
                        'link'  => '/help',
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
