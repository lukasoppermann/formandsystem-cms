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
	)
);
// default tags DO NOT DELETE 
$config['js']['tags']['default']	= '<script type="text/javascript" src="[file]"></script>'; 
$config['js']['tags']['lines'] 		= '<script type="text/javascript">'."\n".'[file]'."\n".'</script>';
// define your own tags