<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		//Load Dependencies
	}

	public function index($login_name='')
	{
		$username = $this->session->userdata('username');
		$authenticator = $this->session->userdata('authenticator');
		$logged_in = $this->session->userdata('logged_in');

		if ($username == $login_name && $logged_in === true)
		{
			$this->private_profile($username);
		}
		else if ($username != $login_name && $logged_in === true)
		{
			$this->protected_profile($username);
		}
		else
		{
			$this->public_profile($username);
		}
	}

	public function private_profile($username='')
	{
		echo "Logged In, Your profile!";
	}

	public function protected_profile($username='')
	{
		echo "Logged In, Someone's profile!";
	}

	public function public_profile($username='')
	{
		// echo "Logged Out, Your profile or maybe someone's profile!";

		$data['layout'] = 'profile';
		$data['page'] = 'user/public_profile_view';
		$this->load->view('template', $data);
	}

	public function settings()
	{
		echo 'TODO: Account settings';
	}
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */
