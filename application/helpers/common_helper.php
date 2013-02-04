<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Preprint
 *
 * Print the data inside the pre tag
 *
 * @access	public
 * @param	array or json format	
 * @param	boolean
 * @return	printed data
 */
if ( ! function_exists('template'))
{
	function load_template()
	{
		echo "Unfinished.";
	}
}

/**
 * Preprint
 *
 * Print the data inside the pre tag
 *
 * @access	public
 * @param	array or json format	
 * @param	boolean
 * @return	printed data
 */
if ( ! function_exists('preprint'))
{
	function preprint($data, $return = false)
	{
		$data = "<pre>";
		$data .= print_r($data, 1);
		$data .= "</pre>";
		
		if ($return)
		{
			return $data;
		}
		else
		{
			print $data;
		}
	}
}

/* End of file common_helper.php */
/* Location: ./application/helpers/common_helper.php */