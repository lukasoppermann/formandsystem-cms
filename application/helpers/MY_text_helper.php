<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter MY_Text Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Lukas Oppermann - veare.net
 * @link		http://doc.formandsystem.com/helpers/text
 */

// ------------------------------------------------------------------------
/**
 * text_limiter - trims text after $count characters
 *
 * @param string
 * @param int
 * @param boolean
 * @param string
 * @return string
 */
function text_limiter($text = null, $count = 150, $strip_tags = false, $end = '&#8230;')
{
	$CI = &get_instance();
	// strip tags if needed
	if( $strip_tags == TRUE )
	{
		$text = strip_tags($text);
	}
	// if text is shorter than count -> return
	if( strlen($text) < $count ) 
	{
		return $text;
	}
	// remove words longer that the rest
    $text = wordwrap($text, $count, "[break]", TRUE);
	$text = substr($text, 0, strpos($text, "[break]"));
	// remove all this characters from the end
	if( $end != null )
	{
		$chars = array(',',';',':','.','?','!','-');
		foreach($chars as $char)
		{
			$text = rtrim($text, $char);
		}
		$text .= $end;
	}
	// if tags are not striped, close open tags
	if( $strip_tags != TRUE )
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
/* End of file MY_text_helper.php */
/* Location: ./application/helpers/MY_text_helper.php */