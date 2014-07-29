<?php

class BaseController extends Controller {
	
	function __construct()
	{
		
		// header('Access-Control-Allow-Origin: '.Auth::user()->service_url);
		// header('Access-Control-Allow-Origin: http://cms.formandsystem.com');
	  // Allow from any origin
		header('content-type: application/json; charset=utf-8');
		header('Access-Control-Allow-Origin: http://cms.formandsystem.com');
		header('Access-Control-Allow-Credentials: true');
		header('Access-Control-Max-Age: 86400');    // cache for 1 day
		header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT, OPTIONS");

    // Access-Control headers are received during OPTIONS requests
    // if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    //
    //     if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
    //         header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT, OPTIONS");
    //
    //     if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
    //         header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    //
    //     exit(0);
    // }
		
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