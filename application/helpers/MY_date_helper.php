<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Validate Date
 *
 * Check if a valid Date
 *
 * @access	public
 * @param	string  date
 * @return	boolean
 */
if ( ! function_exists('validate_date'))
{
	function validate_date($date='')
	{
		list($year, $month, $day) = explode("-", $mydate); 
		
		if (is_numeric($year) && is_numeric($month) && is_numeric($day)) 
		{
			return checkdate($month, $day, $year); 
		}
		
		return FALSE;
	}
}

/**
 * Validate Datetime
 *
 * Check if a valid Datetime
 *
 * @access	public
 * @param	string  datetime
 * @return	boolean
 */
if ( ! function_exists('validate_datetime'))
{
	function validate_datetime($datetime='')
	{
		if (date('Y-m-d H:i:s', strtotime($datetime)) == $datetime)
		{
			return TRUE;
		}

		return FALSE;
	}
}

/* End of file MY_date_helper.php */
/* Location: ./application/helpers/MY_date_helper.php */