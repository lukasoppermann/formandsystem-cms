<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "dashboard";
$route['404_override'] = '';
// Ajax
$route['(\w+)/(\w{2})/ajax/?(.*)?'] = 'ajax/$3';
// Dashboard
$route['(\w+)/(\w{2})/dashboard/?(.*)?'] = 'dashboard';
// Menu
$route['(\w+)/(\w{2})/navigation/?(.*)?'] = "menu";
// Content
$route['(\w+)/(\w{2})/content/?(.*)?/?(.*)?'] = "content/index/$3";
// Media
$route['(\w+)/(\w{2})/media/?(.*)?'] = 'media';
// User
$route['(\w+)/(\w{2})/user/?(.*)?'] = 'user/$3';
// Settings
$route['(\w+)/(\w{2})/settings/?(.*)?'] = 'settings';
// Profile
$route['(\w+)/(\w{2})/profile/?(.*)?'] = 'profile';
// if nothing else works
$route['(\w+)/(\w{2})/?(.*)?'] = $route['default_controller']."/index/$3";
$route['(.*)'] = $route['default_controller']."/index/$1";
// -------------------------------------------------------------------------
/* End of file routes.php */
/* Location: ./application/config/routes.php */