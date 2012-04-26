<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation
{
	var $form_data;
	
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
		// check if message is not set yet
		if(!isset($this->_error_array[$field]))
		{
			// set message to field and in error data
			$this->_error_array[$field] = $error_message;
			$this->_field_data[$field]['error'] = $error_message;
		}
    }
	// --------------------------------------------------------------------
	/**
	 * Add form_data
	 *
	 * Adds form data to array
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	function add_form_data( $item = null, $value = null )
	{
		// check if item is string
		if( !is_array($item) )
		{
			// set item
			$this->form_data[$item] = $value;
		}
		// if item is array
		else
		{
			// loop through array
			foreach($item as $key => $value)
			{
				// set item
				$this->form_data[$key] = $value;
			}
		}
	}
	// --------------------------------------------------------------------
	/**
	 * form_data
	 *
	 * Get form data from array
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	function delete_form_data( $item = null )
	{
		// check if item is string
		if( !is_array($item) )
		{
			// unset item
			unset($this->form_data[$item]);
		}
		// if item is array
		else
		{
			// loop through array values
			foreach($item as $key)
			{
				// unset item
				unset($this->form_data[$key]);
			}
		}
	}
	// --------------------------------------------------------------------
	/**
	 * form_data
	 *
	 * Get form data from array
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	function form_data( $item = '' )
	{
		// return item or FALSE
		return isset($this->form_data[$item]) ? $this->form_data[$item] : FALSE;
	}
// end of Class
}
