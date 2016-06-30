<?php

return [
  /*
  |--------------------------------------------------------------------------
  | Api Config
  |--------------------------------------------------------------------------
  |
  | configuration for the api
  |
  */
    'url'           => 'http://formandsystem-api.dev',
    'version'       => '1',
    'client_id'     => $_ENV['FS_API_CLIENT_ID'],
    'client_secret' => $_ENV['FS_API_CLIENT_SECRET'],
    'cache'         => true,
];
