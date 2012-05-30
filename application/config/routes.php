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
$route['default_controller'] = "content";
$route['404_override'] = '';

if( !file_exists(APPPATH.'config/fs_dynamic_routes.php'))
{
	$myFile = APPPATH."config/fs_dynamic_routes.php";
	$fh = fopen($myFile, 'w');
	$stringData = '<?php  if ( ! defined(\'BASEPATH\')) exit(\'No direct script access allowed\');'."\n";
	$stringData .= '$route[\'(\w+)/(\w{2})/dashboard/?(.*)?\'] = "dashboard";';
	fwrite($fh, $stringData);
	fclose($fh);
}
include('fs_dynamic_routes.php');
// Ajax
$route['(\w+)/(\w{2})/ajax/?(.*)?'] = 'ajax/$3';
// Dashboard
// $route['(\w+)/(\w{2})/dashboard/?(.*)?'] = 'dashboard';
// Menu
$route['(\w+)/(\w{2})/navigation/?(.*)?'] = "menu/index/$3";
// Content
$route['(\w+)/(\w{2})/content/?(.*)?/?(.*)?'] = "content/index/$3";
// Media
$route['(\w+)/(\w{2})/media/?(.*)?'] = 'media/index/$3';
// User
$route['(\w+)/(\w{2})/user/?(.*)?'] = "user/index/$3";
// Settings
$route['(\w+)/(\w{2})/settings/?(.*)?'] = 'settings/index/$3';
// Profile
$route['(\w+)/(\w{2})/profile/?(.*)?'] = 'profile/index/$3';
// if nothing else works
$route['(\w+)/(\w{2})/?(.*)?'] = $route['default_controller']."/index/$3";
$route['(.*)'] = $route['default_controller']."/index/$1";
// -------------------------------------------------------------------------
/* End of file routes.php */
/* Location: ./application/config/routes.php */