<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use \Config;

abstract class Controller extends BaseController {

	use ValidatesRequests;

	function __construct()
	{
		// TODO: change language logic to
		Config::set('content.languages', array('de','en','fr'));
		// set local if not defined
		if( !Config::get('content.locale') )
		{
			Config::set('content.locale', array_values(Config::get('content.languages'))[0] );
		}
	}
}
