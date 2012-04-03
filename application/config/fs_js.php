<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| JS Class
|--------------------------------------------------------------------------
*/
// regex
$config['js']['regex'] = array(
						'replace' => array(
							// '#\/\*.+?\*\/|\/\/.*(?=[\n\r])#' => '',
							// '#[\r\n|\r|\n|\t|\f]#' => ' ',
							// 	'#(\,|\;|\:|\{|\}|\s)[ ]+#' => '$1',
							// 	'#[ ]+(\,|\;|\:|\{|\}|px|\%)#' => '$1',
							// 	'#url\(\'[^http://||data:](\.?\.\/)*(.*?)\'\)#is' =>'url(\''.base_url().'$2\')'
						),
						// 'variables' => '#\[\$(.*)\]#' // produces an error
);
// define groups
$config['js']['groups'] = array('default', 'uncompressed');
// define tags
$config['js']['tags']['default'] = '<script type="text/javascript" src="[file]"></script>';
$config['js']['tags']['uncompressed'] = '<script type="text/javascript" src="[file]"></script>';
$config['js']['tags']['lines'] = 	'<script type="text/javascript">'."\n".'[file]'."\n".'</script>';
