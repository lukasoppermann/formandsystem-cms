<?php if (! defined('BASEPATH')) exit('No direct script access');
/**
 * CodeIgniter MY_Loader Libraries
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Loader
 * @author		Lukas Oppermann - veare.net
 * @link		http://doc.formandsystem.com/core/loader
**/
class MY_Loader extends CI_Loader {
	
	//php 5 constructor
	function __construct() 
 	{
		parent::__construct();
	}
	
	/*
	 * Load View
	 *
	 * Extend view, to work with not existing variables
	 *
	 */
	// --------------------------------------------------------------------
	/**
	 * Load View
	 *
	 * Extend view, to work with not existing variables
	 *
	 * @access	public
	 * @param	string
	 * @param	array
	 * @param	string		
	 * @return	string
	 */
	public function view($view, &$vars = array(), $return = FALSE)
	{
		return $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $this->_ci_object_to_array($vars), '_ci_return' => $return));
	}
// end of class
}