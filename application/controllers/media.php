<?php if (! defined('BASEPATH')) exit('No direct script access');

class Media extends MY_Controller {
	
	//php 5 constructor
	function __construct() 
 	{
		parent::__construct();
	}
	// --------------------------------------------------------------------
	/**
	 * index
	 *
	 * @description	directs calls
	 * 
	 */
	function index( $method = null )
	{
		$this->direct_call(strtolower(get_class($this)), $method);
	}
	// --------------------------------------------------------------------
	/**
	 * show
	 *
	 * @description	show media content
	 * 
	 */
	function show( $method )
	{
		view('default', $this->data);
	}
// end of class	
}
/* End of file media.php */