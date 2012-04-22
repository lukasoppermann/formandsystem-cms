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
    function add_message($error_message, $field = 'manual')
    {
		if(!isset($this->_error_array[$field]))
		{
			$this->_error_array[$field] = $error_message;
			$this->_field_data[$field]['error'] = $error_message;
		}
    }
// end of Class
}
