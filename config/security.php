<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Content Security Policies
    |--------------------------------------------------------------------------
    */

    'content' => [
        'default' => 'global',
        'profiles' => [
            'global' => [
                'base-uri' => "'self'",
                'default-src' => "'self'",
                'font-src' => [
                    "'self'",
                    'fonts.gstatic.com'
                ],
                'img-src' => "'self'",
                'script-src' => "'self'",
                'style-src' => [
                    "'self'",
                    "'unsafe-inline'",
                    'fonts.googleapis.com'
                ],
                'object-src' => "'none'",
            ],
        ],
    ],
];
