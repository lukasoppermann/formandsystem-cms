<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter MY_string Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Lukas Oppermann - veare.net
 * @link		http://doc.formandsystem.com/helpers/string
 */

// ------------------------------------------------------------------------
/**
 * replace_accents - replaces accent special characters with normal latin characters
 *
 * @param string
 * @return string
 */
function replace_accents($string, $find = array(NULL), $replace = array(NULL)) 
{ 
	// merge finds
	$find = array_merge(array('à','á','â','ã','ä','æ','å', 'ç', 'è','é','ê','ë', 'ì','í','î','ï', 'ñ', 'ò','ó','ô','õ','ö','ø', 'ù','ú','û','ü', 'ý','ÿ', 'À','Á','Â','Ã','Ä','Æ','Å', 'Ç', 'È','É','Ê','Ë', 'Ì','Í','Î','Ï', 'Ñ', 'Ò','Ó','Ô','Õ','Ö','Ø', 'Ù','Ú','Û','Ü', 'Ý'), $find);
	// merge replace
	$replace = array_merge(array('a','a','a','a','ae','ae','aa', 'c', 'e','e','e','e', 'i','i','i','i', 'n', 'o','o','o','o','oe','oe', 'u','u','u','u', 'y','y', 'A','A','A','A','AE','AE','AA', 'C', 'E','E','E','E', 'I','I','I','I', 'N', 'O','O','O','O','OE','OE', 'U','U','U','U', 'Y'), $replace);
	// replace and return
	return str_replace( $find, $replace, $string); 
}
// ------------------------------------------------------------------------
/**
 * trim_text - trims text after $count characters
 *
 * @param string
 * @return string
 */
function trim_text($text, $count, $params = array())
{
	$CI = &get_instance();
	$CI->load->helper('fs_variable');
	// merge params
	$params = array_merge(array('end' => '', 'tags' => TRUE),$params);
	// strip tags if needed
	if( boolean($params['tags']) == false )
	{
		$text = strip_tags($text);
	}
	// check if text is to long & trim
	if (strlen($text) > $count) 
	{
		$text = str_replace("\n", ' ', $text);
	    $text = wordwrap($text, $count);
	    $text = substr($text, 0, strpos($text, "\n"));
	}
	// check for ending
	if(isset($params['end']) && ($params['end'] == 'dots' || $params['end'] == '...') )
	{
		// remove all this characters from the end
		$chars = array(',',';',':','.','?','!','&','%','$','§','-');
		foreach($chars as $char)
		{
			$text = rtrim($text, $char);
		}
		$text .= '...';
	}
	else
	{
		// end last sentence ending
		$chars = array('.','?','!');
		foreach($chars as $char)
		{
			$_p = strpos($text, $char)+1;
			if($_p > 1)
			{
				$punctuation[] = $_p;
			}
		}
		if(isset($punctuation) && count($punctuation) > 0)
		{
			$text = substr($text, 0, max($punctuation));
		}
	}
	// if tags are not striped, close open tags
	if( boolean($params['tags']) == TRUE)
	{
		closetags($text);
	}
	// return $text
	return $text;
}
// ------------------------------------------------------------------------
/**
 * close all open xhtml tags at the end of the string
 *
 * @param string $html
 * @return string
 */
function closetags($html) 
{
	// put all opened tags into an array
	preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
	$openedtags = $result[1];

	// put all closed tags into an array
	preg_match_all('#</([a-z]+)>#iU', $html, $result);
	$closedtags = $result[1];
	$len_opened = count($openedtags);
	// all tags are closed
	if (count($closedtags) == $len_opened) 
	{
		return $html;
	}
	$openedtags = array_reverse($openedtags);
	// close tags
	for ($i=0; $i < $len_opened; $i++) 
	{
		if (!in_array($openedtags[$i], $closedtags))
		{
			$html .= '</'.$openedtags[$i].'>';
		} 
		else 
		{
			unset($closedtags[array_search($openedtags[$i], $closedtags)]);
		}
	}
	return $html;
}
/* End of file MY_string_helper.php */
/* Location: ./application/helpers/MY_string_helper.php */