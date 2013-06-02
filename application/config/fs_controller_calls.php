<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Define Methods
|--------------------------------------------------------------------------
*/
$config['methods'] 	= array(
	'dashboard' 	=> array(
	),
	'content' 		=> array(
		'default' 		=> 'view'
	),
	'media' 		=> array(
		'default' 		=> 'show'
	),
	'user' 			=> array(
		'default' 		=> 'view'
	),
	'settings' 		=> array(
		'default' 		=> 'general',
		'general' 		=> 'general',
		'languages' 	=> 'languages',
		'seo' 			=> 'seo',
		'search' 		=> 'search',
		'cms' 			=> 'cms'
	),
	'profile' 		=> array(
		'default' 		=> 'profile',
		'general' 		=> 'profile',
		'settings' 		=> 'settings',
		'messages' 		=> 'messages',
		'calendar' 		=> 'calendar',
		'public-profile'=> 'public_profile'
	)
);