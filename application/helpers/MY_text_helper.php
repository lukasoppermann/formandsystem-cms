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
		$text = closetags($text);
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
	// collect open tags into an array
	preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
	$opened_tags = $result[1];
	// collect close tags into an array
	preg_match_all('#</([a-z]+)>#iU', $html, $result);
	$closed_tags = $result[1];
	// count open tags
	$count_open = count($opened_tags);
	// if all tags are closed
	if( count($closed_tags) == $count_open ) 
	{
		return $html;
	}
	// if open tags remain
	$opened_tags = array_reverse($opened_tags);
	// loop through tags
	for( $i=0; $i < $count_open; $i++ ) 
	{
		// if tag is not closed
		if( !in_array($opened_tags[$i], $closed_tags) )
		{
			// close
			$html .= '</'.$opened_tags[$i].'>';
		} 
		else 
		{
			// unset from array
			unset($closed_tags[array_search($opened_tags[$i], $closed_tags)]);
		}
	}
	// return html
	return $html;
}
// ------------------------------------------------------------------------
/**
 * close all open xhtml tags at the end of the string
 *
 * @param string
 * @param string
 * @return string
 */
function to_alphanum( $text, $add_chars = array(null) )
{
	// strip tags
	$text = strip_tags($text);
	// if additional characters are given
	if( count($add_chars) > 0 )
	{
		// loop through additional chars
		foreach($add_chars as $find => $replace)
		{
			// check if replace already in chars
			if( !isset($chars) || !in_array($replace, $chars) )
			{
				$chars[] = $replace;
			}
			// add to find & replace arrays
			$finds[] 	= $find;
			$replaces[] = $replace;
		}
		// replace characters
		$text = str_replace($finds, $replaces, $text);
	}
	// make alphanumplus
	return preg_replace("/[^a-zA-Z0-9".implode('\\', $chars)."]/", "", $text);
}
/* End of file MY_text_helper.php */
/* Location: ./application/helpers/MY_text_helper.php */