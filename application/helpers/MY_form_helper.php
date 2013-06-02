<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter MY_form Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Lukas Oppermann - veare.net
 * @link		http://doc.formandsystem.com/helpers/form
 */

// ------------------------------------------------------------------------

/**
 * Form Error
 *
 * Returns the error for a specific form field.  This is a helper for the
 * form validation class.
 *
 * @access	public
 * @param	string
 * @param	string
 * @param	string
 * @return	string
 */
function form_data($item = '')
{
	if (FALSE === ($OBJ =& _get_validation_object()))
	{
		return '';
	}

	return $OBJ->form_data($item);
}
/* End of file form_helper.php */
/* Location: ./system/helpers/form_helper.php */