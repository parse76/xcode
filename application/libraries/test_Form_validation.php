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