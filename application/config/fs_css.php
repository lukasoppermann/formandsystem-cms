<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| CSS Class
|--------------------------------------------------------------------------
|
*/
// compression settings
$config['css']['offset'] = 3600;
$config['css']['gzip'] = TRUE;
// regex
$config['css']['regex'] = array(
					'replace' => array(
						'#\s0px#' => ' 0 ',
						'#[\r\n|\r|\n|\t|\f]#' => ' ',
						'#/\*(.*?)\*/#s' => '',
						'#(\,|\;|\:|\{|\}|\s)[ ]+#' => '$1',
						'#[ ]+(\,|\;|\:|\{|\}|px|\%)#' => '$1',
						'#url\([\'||"]?[^http://||data:](\.?\.\/)*(.*?)[\'||"]?\)#is' =>'url(\''.base_url().'$2\')',
					),
					'variables' => '#\[\$(.*)\]#'
					// 'gradiants' => '',
					// 'transition' => '',
);
// define groups
$config['css']['groups'] = array('print','screen');
// define tags
$config['css']['tags']['print']		= 	'<link rel="stylesheet" href="[file]" type="text/css" media="print" />';
$config['css']['tags']['screen']	= 	'<link rel="stylesheet" href="[file]" type="text/css" media="screen" />';
$config['css']['tags']['lines'] 	= 	'<style type="text/css">'."\n".'[file]'."\n".'</style>';
