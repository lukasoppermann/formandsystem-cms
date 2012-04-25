<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter MY_url Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Lukas Oppermann - veare.net
 * @link		http://doc.formandsystem.com/helpers/url
 */

// ------------------------------------------------------------------------
/**
 * base_url - returns the base_url with the current language part
 *
 * @param boolean 
 * @return string
 */
function base_url($slash = TRUE)
{
	$CI =& get_instance();
	
	if($slash == TRUE)
	{
		return $CI->config->slash_item('base_url');
	}
	else
	{
		return $CI->config->unslash_item('base_url');		
	}
}
// ------------------------------------------------------------------------
/**
 * active_url - returns the base_url with the default parts
 *
 * @param boolean
 * @return string
 */
function active_url($slash = TRUE)
{
	$CI =& get_instance();
	if($slash == TRUE)
	{
		return $CI->config->slash_item('base_url').variable($CI->config->slash_item('url_parts'));
	}
	else
	{
		return $CI->config->slash_item('base_url').variable($CI->config->slash_item('url_parts'));
	}
}
// ------------------------------------------------------------------------
/**
 * page_url - returns the url to current page without variables
 *
 * @param boolean
 * @return string
 */
function page_url($slash = TRUE)
{
	$CI =& get_instance();
	$CI->load->library('fs_navigation');
	
	if($slash == TRUE)
	{
		return $CI->config->slash_item('base_url').variable($CI->config->unslash_item('url_parts')).$CI->fs_navigation->current('path').'/';
	}
	else
	{
		return $CI->config->slash_item('base_url').variable($CI->config->unslash_item('url_parts')).$CI->fs_navigation->current('path');
	}
}
// ------------------------------------------------------------------------
/**
 * media - returns the given file with the media url
 *
 * @param string 
 * @param string 
 * @return string
 */
function media($file = null, $dir = null, $base = TRUE)
{
	$CI =& get_instance();
	// check for base
	$base_url = '';
	if($base == TRUE)
	{
		$base_url = $CI->config->slash_item('base_url');
	}
	// return url
	if( $dir != null && $CI->config->slash_item('dir_'.$dir) != null)
	{
		return $base_url.$CI->config->slash_item('dir_'.$dir).$file;	
	}
	else
	{
		return $base_url.$CI->config->slash_item('dir_media').$file;	
	}
}
// ------------------------------------------------------------------------
/**
 * last_segment - returns the last segment of the url
 *
 * @return string
 */
function last_segment()
{
	$CI =& get_instance();
	// get url segments
	$segments = $CI->uri->segment_array();
	// set array to last item
	end($segments);
	// return last item
	return $segments[key($segments)];
}
// --------------------------------------------------------------------
/**
 * safe_mailto - encrypts email addresses with javascript 
 *
 * @param string 
 * @param string 
 * @param array 
 * @return string
 */
function safe_mailto($email, $name = null, $opt = array(null))
{
	$opt = array_merge(
		array(
			'link' 		=> TRUE,
			'subject' 	=> '',
			'name' 		=> $name,
			'bcc' 		=> '',
			'cc' 		=> '',
			'class' 	=> 'email',
			'id' 		=> ''
		), 
	$opt);
	
	$opt['subject']	= !empty($opt['subject'])	? 'subject='.$opt['subject'] : '';
	$opt['cc'] 		= !empty($opt['cc']) ? '&cc='.$opt['cc'] : '';	
	$opt['bcc'] 	= !empty($opt['bcc']) ? '&bcc='.$opt['bcc'] : '';
	$opt['class'] 	= !empty($opt['class'])	? ' class="'.$opt['class'].'"' : '';
	$opt['id'] 		= !empty($opt['id'])	? ' id="'.$opt['id'].'"' : '';
	
	if($opt['link'] == TRUE)
	{
		$email = '<a href="mailto:'.$email.'?'.$opt['subject'].$opt['cc'].$opt['bcc'].'"'.$opt['class'].$opt['id'].'>'.$opt['name'].'</a>';
	}

	$email = str_replace(array('"','@','.','/'),array('\"','\100','\56','\057'),$email);
	$email = str_rot13($email);
	
	return '<script type="text/javascript">document.write("'.$email.'".replace(/[a-zA-Z]/g, function(c){return String.fromCharCode((c<="Z"?90:122)>=(c=c.charCodeAt(0)+13)?c:c-26);}));</script>';
}

/* End of file MY_url_helper.php */
/* Location: ./application/helpers/MY_url_helper.php */