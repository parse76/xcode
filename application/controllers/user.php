<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		//Load Dependencies
	}

	public function index()
	{
		//Load Dependencies
	}

	public function profile()
	{
		$value =  $this->uri->segment(1);

		$username = $this->session->userdata('username');
		$authenticator = $this->session->userdata('authenticator');
		$logged_in = $this->session->userdata('logged_in');

		if ($username == $value && $logged_in == true) {
			echo 'your profile';
		} else if ($username != $value && $logged_in === true) {
			echo 'not ur profile';
		} else {
			echo 'guest!';

			print_r($_COOKIE);
		}
	}

	public function account_settings()
	{
		echo 'TODO: Account settings';
	}
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */
