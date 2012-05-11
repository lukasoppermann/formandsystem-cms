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
// ------------------------------------------------------------------------
/**
 * Converts time in milliseconds to given output, rounds to int on default
 *
 * @access	public
 * @param	integer
 * @param	string
 * @param	string
 * @param	boolean
 * @return	int / float
 */
function time_convert( $time = null, $output = 'hours', $input = 'seconds', $int = TRUE)
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
	// return as int or float
	if( $int === TRUE )
	{
		// convert time to output
		return ceil($time / $formats[$output]);
	}
	else
	{
		// convert time to output
		return $time / $formats[$output];		
	}
}
/**
 * Converts unix timestamp to time ago
 *
 * @access	public
 * @param	integer
 * @param	string
 * @return	int / float
 */
function time_ago( $time )
{
	// get time difference
	$ago = time() - $time;
	// if one minute ago
	if( $ago < 100 )
	{
		return sprintf(lang('minute_ago'), time_convert($ago, 'minutes'));
	}
	// minutes ago
	elseif( $ago > 100 && $ago < 3600)
	{
		return sprintf(lang('minutes_ago'), time_convert($ago, 'minutes'));
	}
	// one hour ago
	elseif( $ago > 3600 && $ago < 7200)
	{
		return sprintf(lang('hour_ago'), time_convert($ago, 'hours'));
	}
	// hours ago
	elseif( $ago > 7200 && $ago < 86000)
	{
		return sprintf(lang('hours_ago'), time_convert($ago, 'hours'));
	}
	// one day ago
	elseif( $ago > 86000 && $ago < 170000)
	{
		return sprintf(lang('day_ago'), time_convert($ago, 'days'));
	}
	// days ago
	elseif( $ago > 170000 && $ago < 2592000)
	{
		return sprintf(lang('days_ago'), time_convert($ago, 'days'));
	}
	// one month ago
	elseif( $ago > 2592000 && $ago < 5180000 )
	{
		return sprintf(lang('one_month_ago'), time_convert($ago, 'month'));
	}
	// month ago
	elseif( $ago > 5180000 && $ago < 31530000 )
	{
		return sprintf(lang('month_ago'), time_convert($ago, 'month'));
	}
	// one year ago
	elseif( $ago > 31530000 && $ago < 63060000 )
	{
		return sprintf(lang('year_ago'), time_convert($ago, 'years'));
	}
	// years ago
	elseif( $ago > 63060000 )
	{
		return sprintf(lang('years_ago'), time_convert($ago, 'years'));
	}
}

/* End of file MY_date_helper.php */
/* Location: ./application/helpers/MY_date_helper.php */