<?php if (! defined('BASEPATH')) exit('No direct script access');

class Profile extends MY_Controller {
	
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
		$this->direct_call('settings', $method);
	}
	// --------------------------------------------------------------------
	/**
	 * general
	 *
	 * @description	ajax request for user
	 * 
	 */
	function general()
	{
		view('default', $this->data);
	}
	// --------------------------------------------------------------------
	/**
	 * user
	 *
	 * @description	ajax request for user
	 * 
	 */
	function languages()
	{
		view('default', $this->data);
	}
	// --------------------------------------------------------------------
	/**
	 * user
	 *
	 * @description	ajax request for user
	 * 
	 */
	function seo()
	{
		view('default', $this->data);
	}
	// --------------------------------------------------------------------
	/**
	 * user
	 *
	 * @description	ajax request for user
	 * 
	 */
	function search()
	{
		view('default', $this->data);
	}			
	// --------------------------------------------------------------------
	/**
	 * user
	 *
	 * @description	ajax request for user
	 * 
	 */
	function cms()
	{
		view('default', $this->data);
	}
// end of class	
}
/* End of file profile.php */