<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * My Form Error
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
if ( ! function_exists('my_form_error'))
{
	function my_form_error($field = '', $prefix = '', $suffix = '')
	{
		if (FALSE === ($OBJ =& _get_validation_object()))
		{
			return '';
		}

		$my_error = str_replace('field', 'variable', $OBJ->error($field, $prefix, $suffix));

		return $my_error;
	}
}

/* End of file MY_form_helper.php */
/* Location: ./application/helpers/MY_form_helper.php */