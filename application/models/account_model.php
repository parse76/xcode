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

	public function register_user($register_data=array())
	{
		$this->db->trans_start();

		$this->db->insert('users', $register_data);

		$this->db->trans_complete();

		if ($this->db->trans_status() === TRUE)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function third_party_login($authenticator, $authenticator_id)
	{
		$this->db->trans_start();
		
		$this->db->select($authenticator);
		$this->db->from('users');
		$this->db->where($authenticator, $authenticator_id);
		$this->db->limit(1);
		
		$this->db->trans_complete(); 

		if ($this->db->trans_status() === TRUE)
		{
			return $this->db->get()->num_rows();
		}
		else
		{
			// generate an error... or use the log_message() function to log your error
			return FALSE;
		}
	}

	public function verify_token($token='')
	{
		$this->db->trans_start();

		$this->db->select('token');
		$this->db->from('users');
		$this->db->where('token', $token);
		$this->db->limit(1);

		$this->db->trans_complete();

		if ($this->db->trans_status() === TRUE)
		{
			return $this->db->get()->num_rows();
		}
		else
		{
			return FALSE;
		}
	}

	public function verify_date($token='', $user_data=array())
	{
		$this->db->trans_start();

		$this->db->where('token', $token);
		$this->db->update('users', $user_data);

		$this->db->trans_complete();

		if ($this->db->trans_status() === TRUE)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function get_username($email='')
	{
		$this->db->trans_start();

		$this->db->select('username');
		$this->db->from('users');
		$this->db->where('email', $email);
		$this->db->limit(1);

		$this->db->trans_complete();

		if ($this->db->trans_status() === TRUE)
		{
			if ($this->db->get()->num_rows() > 0)
			{
				return $this->db->get();	
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
	}

	public function update_token($email='', $user_data=array())
	{
		$this->db->trans_start();

		$this->db->where('email', $email);
		$this->db->update('users', $user_data);

		$this->db->trans_complete();

		if ($this->db->trans_status() === TRUE)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}

/* End of file account_model.php */
/* Location: ./application/models/account_model.php */
