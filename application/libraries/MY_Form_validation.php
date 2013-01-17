<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* From: http://ellislab.com/forums/viewthread/70437/
*/
class MY_Form_validation extends CI_Form_validation
{
    public function __construct()
    {
        parent::__construct();
    }

    // --------------------------------------------------------------------

	/**
	 * Set Rules
	 *
	 * This function takes an array of field names and validation
	 * rules as input, validates the info, and stores it
	 *
	 * @access	public
	 * @param	mixed
	 * @param	string
	 * @return	void
	 */
	public function set_verifier($var, $label = '', $rules = '')
	{
		// If an array was passed via the first parameter instead of indidual string
		// values we cycle through it and recursively call this function.
		if (is_array($var))
		{
			foreach ($var as $row)
			{
				// Houston, we have a problem...
				if ( ! isset($row['var']) OR ! isset($row['rules']))
				{
					continue;
				}

				// If the field label wasn't passed we use the field name
				$label = ( ! isset($row['label'])) ? $row['var'] : $row['label'];

				// Here we go!
				$this->set_rules($row['var'], $label, $row['rules']);
			}
			return $this;
		}

		// No fields? Nothing to do...
		if ( ! is_string($var) OR  ! is_string($rules) OR $var == '')
		{
			return $this;
		}

		// If the field label wasn't passed we use the field name
		$label = ($label == '') ? $var : $label;

		// Build our master array
		$this->_field_data[$var] = array(
			'var'				=> $var,
			'label'				=> $label,
			'rules'				=> $rules,
			'keys'				=> $indexes,
			'vardata'			=> NULL,
			'error'				=> ''
		);

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Run the Validator
	 *
	 * This function does all the work.
	 *
	 * @access	public
	 * @return	bool
	 */
	public function verify($group = '')
	{
		// Does the _field_data array containing the validation rules exist?
		// If not, we look to see if they were assigned via a config file
		if (count($this->_field_data) == 0)
		{
			// No validation rules?  We're done...
			if (count($this->_config_rules) == 0)
			{
				return FALSE;
			}

			// Is there a validation rule for the particular URI being accessed?
			$uri = ($group == '') ? trim($this->CI->uri->ruri_string(), '/') : $group;

			if ($uri != '' AND isset($this->_config_rules[$uri]))
			{
				$this->set_rules($this->_config_rules[$uri]);
			}
			else
			{
				$this->set_rules($this->_config_rules);
			}

			// We're we able to set the rules correctly?
			if (count($this->_field_data) == 0)
			{
				log_message('debug', "Unable to find validation rules");
				return FALSE;
			}
		}

		// Load the language file containing error messages
		$this->CI->lang->load('form_validation');

		// Cycle through the rules for each field, match the
		// corresponding $_POST item and test for errors
		foreach ($this->_field_data as $var => $row)
		{
			// Fetch the data from the corresponding $_POST array and cache it in the _field_data array.
			// Depending on whether the field name is an array or a string will determine where we get it from.

			if (isset($_POST[$var]) AND $_POST[$var] != "")
			{
				$this->_field_data[$var]['vardata'] = $row['var'];
			}

			$this->_execute($row, explode('|', $row['rules']), $this->_field_data[$var]['vardata']);
		}

		// Did we end up with any errors?
		$total_errors = count($this->_error_array);

		if ($total_errors > 0)
		{
			$this->_safe_form_data = TRUE;
		}

		// Now we need to re-set the POST data with the new, processed data
		$this->_reset_post_array();

		// No errors, validation passes!
		if ($total_errors == 0)
		{
			return TRUE;
		}

		// Validation fails
		return FALSE;
	}

//     public function valid_date()
// 	{
// 		$month = $this->input->post('month');
// 		$day = $this->input->post('day');
// 		$year = $this->input->post('year');

//     	if (!checkdate($month, $day, $year))
//     	{
//         	$this->validation->set_message('valid_date', 'The %s field is invalid.');
        	
//         	return FALSE;
//      	}
// 	} 
}

/* End of file MY_Form_validation.php */
/* Location: ./application/libraries/MY_Form_validation.php */