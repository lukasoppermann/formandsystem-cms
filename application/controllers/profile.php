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
		$this->direct_call(strtolower(get_class($this)), $method);
	}
	// --------------------------------------------------------------------
	/**
	 * profile
	 *
	 * @description	user profile
	 * 
	 */
	function profile()
	{
		view('default', $this->data);
	}
	// --------------------------------------------------------------------
	/**
	 * settings
	 *
	 * @description	user specific settings
	 * 
	 */
	function settings()
	{
		view('default', $this->data);
	}
	// --------------------------------------------------------------------
	/**
	 * messages
	 *
	 * @description	sending and receiving messages
	 * 
	 */
	function messages()
	{
		view('default', $this->data);
	}
	// --------------------------------------------------------------------
	/**
	 * calendar
	 *
	 * @description	user specific calendar
	 * 
	 */
	function calendar()
	{
		view('default', $this->data);
	}			
	// --------------------------------------------------------------------
	/**
	 * public profile
	 *
	 * @description	view and edit public profile
	 * 
	 */
	function public_profile()
	{
		view('default', $this->data);
	}
// end of class	
}
/* End of file profile.php */