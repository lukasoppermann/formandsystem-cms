<?php

class BaseController extends Controller {
	
	function __construct()
	{

		Config::set("database.connections.user", array(
	    'driver'    => 'mysql',
	    'host'      => 'localhost',
	    'database'  => Auth::user()->service_name,
	    'username'  => Auth::user()->service_user,
	    'password'  => Auth::user()->service_key,
	    'charset'   => 'utf8',
	    'collation' => 'utf8_unicode_ci',
	    'prefix'    => '',
		));
	
	}	
}