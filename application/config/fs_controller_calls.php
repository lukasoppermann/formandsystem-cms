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
		'default' 		=> 'general',
		'general' 		=> 'general',
	),
	'media' 		=> array(
		'default' 		=> 'show'
	),
	'user' 			=> array(
		'default' 		=> 'profile',
		'general' 		=> 'profile',
		'settings' 		=> 'settings',
		'messages' 		=> 'messages',
		'calendar' 		=> 'calendar',
		'public-profile'=> 'public_profile'
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
		'default' 		=> 'general',
		'general' 		=> 'general',
		'languages' 	=> 'languages',
		'seo' 			=> 'seo',
		'search' 		=> 'search',
		'cms' 			=> 'cms'
	)
);