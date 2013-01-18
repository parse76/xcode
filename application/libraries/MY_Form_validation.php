<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Executes the Validation routines on a var instead of _POST
     *
     * @access    public
     * @param    mixed        Single value or array of values to validate.
     * @param    string        String of cascading rules.
     * @param    function    Callback function with error string as parameter.
     * @return    boolean        True on success, false on fail.
     */
    public function validate($var, $label = '', $rules = '', $callback = NULL)
    {
        // Load the language file containing error messages
        $this->CI->lang->load('form_validation');
    
        // Let's fake the required variables
        $is_array = FALSE;
        if(is_array($var))
        {
            // If an array was passed via the first parameter instead of indidual string
			// values we cycle through it and recursively call this function.
			// if (is_array($var))
			// {
			// 	foreach ($var as $row)
			// 	{
			// 		// Houston, we have a problem...
			// 		if ( ! isset($row['field']) OR ! isset($row['rules']))
			// 		{
			// 			continue;
			// 		}

			// 		// If the field label wasn't passed we use the field name
			// 		$label = ( ! isset($row['label'])) ? $row['field'] : $row['label'];

			// 		// Here we go!
			// 		$this->validate($row['field'], $label, $row['rules']);
			// 	}
			// 	return $this;
			// }

			$is_array = TRUE;
        }

        $label = ($label == '') ? 'Data' : $label;
        
        $row = array(
        	'field' => 'var',
        	'label' => $label,
        	'rules' => $rules,
        	'is_array' => $is_array,
        	'keys' => array(),
        	'postdata' => NULL,
        	'error' => ''
        );                
        
        $this->_field_data['var']['postdata'] = $var;
        
        // Test for errors exactly like run() does...
        $this->_execute($row, explode('|', $row['rules']), $this->_field_data['var']['postdata']);
        
        // We have an error!
        if (isset($this->_field_data['var']['error']))
        {
            // Slightly reformat the default error messages
            $error = ucfirst(str_replace('field' , 'variable' ,  $this->_field_data['var']['error']));
            
            // Callback func
            if (is_callable($callback))
            {
                call_user_func($callback, $error);
            }

            return FALSE;
        }

        return TRUE;
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