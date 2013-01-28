<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation
{
    /**
     * Executes the Validation routines on normal Variables
     *
     * @access   public
     * @param    mixed      Single value or array of values to validate.
     * @param    string     field/label/name for warning message.
     * @param    string     String of cascading rules.
     * @param    function   Callback function with error string as parameter.
     * @return   boolean    True on success, false on fail.
     */
    public function validate($var, $field='', $rules = '', $callback = NULL)
    {
        // Load the language file containing error messages
        $this->CI->lang->load('form_validation');

        // Main parameter gone? nah...
        if (!isset($var))
        {
            return FALSE;
        }

        if (is_array($var))
        {
            // If array but blank..
            if (count($var) == 0)
            {
                return FALSE;
            }

            // Do recursive call..
            foreach ($var as $val)
            {
                // Houston, we have a problem...
                if (!isset($val['var']) || !isset($val['field']) || !isset($val['rules']))
                {
                    continue;
                }

                $this->validate($val['var'], $val['field'], $val['rules']);
            }
        }
        else
        {
            // If not an array but with empty parameters..
            if ($field == '' || $rules == '')
            {
                return FALSE;
            }
        }
        
        $row = array(
        	'field' => $field,
        	'label' => ucfirst($field),
        	'rules' => $rules,
        	'is_array' => FALSE,
        	'keys' => array(),
        	'postdata' => NULL,
        	'error' => ''
        );                
        
        $this->_field_data[$field]['postdata'] = $var;
        
        // Test for errors exactly like run() does...
        $this->_execute($row, explode('|', $row['rules']), $this->_field_data[$field]['postdata']);
        
        // We have an error!
        if (isset($this->_field_data[$field]['error']))
        {
            // Slightly reformat the default error messages
            $error = ucfirst(str_replace('field' , 'variable' ,  $this->_field_data[$field]['error']));
            
            // Callback func
            if (is_callable($callback))
            {
                call_user_func($callback, $error);
            }

            return FALSE;
        }

        // Did we end up with any errors?
        $total_errors = count($this->_error_array);

        // No errors, validation passes!
        if ($total_errors == 0)
        {
            return TRUE;
        }

        // Validation fails
        return FALSE;
    }

    /**
     * Validate Date
     *
     * Check if a valid Date
     *
     * @access  public
     * @param   string  date
     * @return  boolean
     */
    public function valid_date($date='')
    {
        list($year, $month, $day) = explode("-", $date); 
        
        if (is_numeric($year) && is_numeric($month) && is_numeric($day)) 
        {
            if (checkdate($month, $day, $year))
            {
                return TRUE;
            }
        }

        $this->set_message('valid_date', 'The %s field is not a valid date.');
        
        return FALSE;
    }

    /**
     * Validate Datetime
     *
     * Check if a valid Datetime
     *
     * @access  public
     * @param   string  datetime
     * @return  boolean
     */
    public function valid_datetime($datetime='')
    {
        if (date('Y-m-d H:i:s', strtotime($datetime)) == $datetime)
        {
            return TRUE;
        }

        $this->set_message('valid_datetime', 'The %s field is not a valid datetime.');

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