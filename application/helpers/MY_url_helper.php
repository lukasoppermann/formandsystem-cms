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
		return $CI->config->slash_item('base_url').variable($CI->config->slash_item('url_parts')).$CI->config->slash_item('lang_abbr');
	}
	else
	{
		return $CI->config->slash_item('base_url').variable($CI->config->slash_item('url_parts')).$CI->config->unslash_item('lang_abbr');
	}
}
// ------------------------------------------------------------------------
/**
 * active_parts - returns the default parts
 *
 * @param boolean
 * @return string
 */
function active_parts($slash = TRUE)
{
	$CI =& get_instance();
	
	if($slash == TRUE)
	{
		return variable($CI->config->slash_item('url_parts')).$CI->config->slash_item('lang_abbr');
	}
	else
	{
		return variable($CI->config->slash_item('url_parts')).$CI->config->unslash_item('lang_abbr');
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
		return $CI->config->slash_item('base_url').variable($CI->config->slash_item('url_parts')).$CI->config->unslash_item('lang_abbr').$CI->fs_navigation->current('path').'/';
	}
	else
	{
		return $CI->config->slash_item('base_url').variable($CI->config->slash_item('url_parts')).$CI->config->unslash_item('lang_abbr').$CI->fs_navigation->current('path');
	}
}
// ------------------------------------------------------------------------
/**
 * lang_url - returns the base_url with the current language part
 *
 * @param array to be sortet
 * @param string key to be sorted by
 * @return array (sorted)
 */
function lang_url($slash = TRUE)
{
	$CI =& get_instance();
	
	if($slash == TRUE)
	{
		return $CI->config->slash_item('base_url').$CI->config->slash_item('lang_abbr');
	}
	else
	{
		return $CI->config->slash_item('base_url').$CI->config->unslash_item('lang_abbr');
	}
}

// ------------------------------------------------------------------------
/**
 * strip_lang - returns the given url without the language part
 *
 * @param string 
 * @return string
 */
function strip_lang($url)
{
	$CI =& get_instance();
	
	return preg_replace('/^'.$CI->config->unslash_item('lang_abbr').'\//', '', ltrim($url, '/'));

}
// ------------------------------------------------------------------------
/**
 * strip_defaults - returns the given url without the language, system and base url
 *
 * @param string 
 * @return string
 */
function strip_defaults($url)
{
	$CI =& get_instance();
	
	return preg_replace('/(.*)'.$CI->config->unslash_item('lang_abbr').'\//', '', ltrim($url, '/'));

}
// ------------------------------------------------------------------------
/**
 * media - returns the given file with the media url
 *
 * @param string 
 * @param string 
 * @return string
 */
function media($dir, $file)
{
	$CI =& get_instance();
	
	$args = func_get_args();
	//
	if(count($args) > 1)
	{
		foreach($args as $arg)
		{
			if(substr($arg,-4,1) == '.' || substr($arg,-5,1) == '.')
			{
				$file = trim($arg,"/");
			}
			else
			{
				$dir = $CI->config->slash_item('dir_'.$arg);
			}
		}
		return $CI->config->slash_item('base_url').$dir.$file;	
	}
	else
	{
		return $CI->config->slash_item('base_url').$CI->config->slash_item('dir_media').$file;	
	}
}
// ------------------------------------------------------------------------
/**
 * prep_url - returns the given url with protocol or internal path
 *
 * @param string 
 * @return string
 */
function prep_url($string = null)
{
	$CI =& get_instance();
	$languages = $CI->config->item('languages');
	
	if( preg_match("[http://|http:|www.|ww.|.*\.]", $string, $match) )
	{
		if($match[0] == 'http://' || $match[0] == 'http:')
		{
			return 'http://'.str_replace($match[0], '', $string);
		}
		elseif($match[0] == 'www.' || $match[0] == 'ww.')
		{
			return 'http://www.'.str_replace($match[0], '', $string);
		}
		else
		{
			return 'http://'.$string;
		}
	}
	else
	{
		if( in_array(substr( ltrim($string, '/'), 0, 2 ), $languages['abbr']) )
		{
			return base_url().ltrim($string, '/');
		}
		else
		{
			return lang_url().ltrim($string, '/');	
		}	
	}
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