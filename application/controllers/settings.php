<?php if (! defined('BASEPATH')) exit('No direct script access');

class Settings extends MY_Controller {
	
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
	 * @description	general settings for the website
	 * 
	 */
	function general()
	{
		view('default', $this->data);
	}
	// --------------------------------------------------------------------
	/**
	 * languages
	 *
	 * @description	language settings, add, edit and delete languages
	 * 
	 */
	function languages()
	{
		view('default', $this->data);
	}
	// --------------------------------------------------------------------
	/**
	 * seo
	 *
	 * @description	options that effect seo as well as google analytics settings
	 * 
	 */
	function seo()
	{
		view('default', $this->data);
	}
	// --------------------------------------------------------------------
	/**
	 * search
	 *
	 * @description	settings for search implementation of website
	 * 
	 */
	function search()
	{
		view('default', $this->data);
	}			
	// --------------------------------------------------------------------
	/**
	 * cms
	 *
	 * @description	settings for the cms, like editing systems, etc.
	 * 
	 */
	function cms()
	{
		view('default', $this->data);
	}
// end of class	
}
/* End of file settings.php */