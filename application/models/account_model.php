<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();

		// Normal CI Transaction
		// $this->db->trans_begin();

		// $this->db->query('AN SQL QUERY...');
		// $this->db->query('ANOTHER QUERY...');
		// $this->db->query('AND YET ANOTHER QUERY...');

		// if ($this->db->trans_status() === FALSE)
		// {
		//     $this->db->trans_rollback();
		// }
		// else
		// {
		//     $this->db->trans_commit();
		// }
	}

	public function register_user()
	{
		$this->db->trans_start();

		

		$this->db->trans_complete();

		if ($this->db->trans_status() === TRUE)
		{
			// asd
		}
		else
		{
			// ddd
		}
	}

	public function third_party_login($authenticator, $authenticator_id)
	{
		$this->db->trans_start();
		
		$this->db->select($authenticator);
		$this->db->from('users');
		$this->db->where($authenticator, $authenticator_id);
		$this->db->limit(1);
		$query = $this->db->get()->num_rows();;
		
		$this->db->trans_complete(); 

		if ($this->db->trans_status() === TRUE)
		{
			return $query;
		}
		else
		{
			// generate an error... or use the log_message() function to log your error
			return FALSE;
		}
	}
}

/* End of file account_model.php */
/* Location: ./application/models/account_model.php */
