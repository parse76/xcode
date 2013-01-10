<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		//Load Dependencies
	}

	public function index()
	{
		$value =  $this->uri->segment(1);

		$username = $this->session->userdata('username');
		$authenticator = $this->session->userdata('authenticator');
		$logged_in = $this->session->userdata('logged_in');

		if ($username == $value && $logged_in == true) {
			redirect('home');
		} else if ($username != $value && $logged_in === true) {
			echo 'not ur profile';
		} else {
			echo 'guest!';

			print_r($_COOKIE);
		}
	}
}

/* End of file profile.php */
/* Location: ./application/controllers/profile.php */
