<?php
/**
* Utility FN
*/
function variable( &$var = null )
{
	if( isset($var) )
	{
		return $var;
	}
	return false;
}

class BaseController extends Controller {

	/**
	 * Basic Setup
	 *
	 * @return void
	 */
	function __construct()
	{
		// set charset
		Header("Content-type: text/html;charset=UTF-8");
		// set header for browser to not cache stuff
		Header("Last-Modified: ". gmdate( "D, j M Y H:i:s" ) ." GMT");
		Header("Expires: ". gmdate( "D, j M Y H:i:s", time() ). " GMT");
		Header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
		Header("Cache-Control: post-check=0, pre-check=0", FALSE);
		Header("Pragma: no-cache" ); // HTTP/1.0
		// add css resources
		Optimization::css(array('reset', 'layout', 'nav', 'icons', 'contentediting'));
		// add js resources
		// TODO: Fix Optimization js
		Optimization::js(array('mark', 'content'));
		// google analytics
		// Optimization::add_lines('js',"var _gaq = _gaq || [];_gaq.push(['_setAccount', 'UA-7074034-1']);_gaq.push(['_trackPageview']);(function() {var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);})();");
	}
	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout)->with('nav', $this->navigation() );
		}
	}

	protected function navigation()
	{
		$cont = new Content;
		$content = $cont->getArray();
		$contentByMenu = $cont->byMenu();

		$navi = new Navigation;
		$nav = $navi->getArray( $cont->byMenu() );

		// echo("<pre>");print_r($nav);echo("</pre>");

		$language = 'en';

		// foreach($nav as $key => $item)
		// {
		// 	if( isset($contentByMenu[$key]) && isset($contentByMenu[$key]['language'][$language]) )
		// 	{
		// 		$nav[$key]['content'] = $contentByMenu[$key]['language'][$language];
		// 	}
		// }
		//
		return $nav;
	}

}
