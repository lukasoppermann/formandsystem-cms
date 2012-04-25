<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter MY_date Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Lukas Oppermann - veare.net
 * @link		http://doc.formandsystem.com/helpers/date
 */

function time_convert( $time = null, $output = 'hours', $input = 'seconds')
{
	// formats for converting
	$formats['seconds'] = 1;
	$formats['minutes'] = 60;
	$formats['hours'] 	= 3600;
	$formats['days'] 	= 86400;
	$formats['month'] 	= 2592000;	
	$formats['years'] 	= 31536000;
	// convert time to seconds
	$time = $time * $formats[$input];
	// convert time to output
	return $time / $formats[$output];
}

/* End of file MY_date_helper.php */
/* Location: ./application/helpers/MY_date_helper.php */