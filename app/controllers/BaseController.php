<?php
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
		Optimization::css(array('reset','grid', 'layout', 'nav', 'icons', 'contentediting','../js/bower_components/codemirror/lib/codemirror', '../js/dev/mark/mark'));
		// add js resources
		// TODO: Fix Optimization js
    // Optimization::js(array('codemirror','xml','markdown','gfm','javascript','css','htmlmixed','xml-fold','continuelist',
    // 'matchbracket', 'closebrackets','matchtags','trailingspace','closetag','placeholder','overlay','mark', 'content'));
		// prepare local
		Config::set('content.languages', array('en','de','fr'));
		// set local if not defined
		if( !Config::get('content.locale') )
		{
			Config::set('content.locale', array_values(Config::get('content.languages'))[0] );
		}
		
		// needs to be set
		Api::config(['url' => 'http://api.formandsystem.com/v1/stream', 'auth' => ['lukas@vea.re', 'lukas'] ]);
		
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
			$this->layout = View::make($this->layout);
		}
	}
}
