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
    'url'           => 'http://api.formandsystem.app',
    'version'       => '1',
    'client_id'     => $_ENV['FS_API_CLIENT_ID'],
    'client_secret' => $_ENV['FS_API_CLIENT_SECRET'],
    'cache'         => true,
];
