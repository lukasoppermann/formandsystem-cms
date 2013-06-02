<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// Dynamic Routes created via Form&System 

	// Routes to dashboard
	$route['(\w+)/(\w{2})/content/?(.*)?'] = "dashboard";
	$route['(\w+)/(\w{2})/dashboard/?(.*)?'] = "dashboard";