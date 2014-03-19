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
		Optimization::css(array('reset', 'layout', 'nav', 'icons', 'contentediting','../js/codemirror/lib/codemirror', '../js/mark/mark'));
		// add js resources
		// TODO: Fix Optimization js
		Optimization::js(array('codemirror','xml','markdown','gfm','overlay','mark', 'content'));
	// 	<script src="./codemirror/mode/xml/xml.js"></script>
	// <script src="./codemirror/mode/markdown/markdown.js"></script>
	// <script src="./codemirror/mode/gfm/gfm.js"></script>
	// <script src="./codemirror/mode/javascript/javascript.js"></script>
	// <script src="./codemirror/mode/css/css.js"></script>
	// <script src="./codemirror/mode/htmlmixed/htmlmixed.js"></script>
	// <script src="./codemirror/addon/fold/xml-fold.js"></script>
	// <script src="./codemirror/addon/edit/continuelist.js"></script>
	// <script src="./codemirror/addon/edit/matchbrackets.js"></script>
	// <script src="./codemirror/addon/edit/closebrackets.js"></script>
	// <script src="./codemirror/addon/edit/matchtags.js"></script>
	// <script src="./codemirror/addon/edit/trailingspace.js"></script>
	// <script src="./codemirror/addon/edit/closetag.js"></script>
	// <script src="./codemirror/addon/selection/active-line.js"></script>
	// <script src="./codemirror/addon/display/placeholder.js"></script>
	// <script src="./codemirror/addon/mode/overlay.js"></script>
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
