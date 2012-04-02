<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation
{
     function __construct($config = array())
     {
          parent::__construct($config);
     }
	// --------------------------------------------------------------------
	/**
	 * Add Error Message
	 *
	 * Adds error messages to error array
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
    function add_message($message)
    {
		if(!isset($this->_error_array['manual']))
		{
			$this->_error_array['manual'] ='<p>'.$message.'</p>';
		}
		else
		{
			$this->_error_array['manual'] .='<p>'.$message.'</p>';
		}
    }
// end of Class
}
