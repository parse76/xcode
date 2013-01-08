<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function insert_date($data)
	{
		$this->db->insert('test', $data);
	}
}

/* End of file test_model.php */
/* Location: ./application/models/test_model.php */
