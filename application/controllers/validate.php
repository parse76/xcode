<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Validate extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		//Load Dependencies
	}

	public function verify()
	{
		if (!$this->input->post()) {
			redirect('home');
		}

		if ($this->form_validation->run('login') === false) {
			$data['page'] = 'account_view';
			$this->load->view('template', $data);
		} else {
			$user_info = array(
				'username'  => $this->input->post('email'),
				'authenticator' => 'default',
				'logged_in' => true
			);

			$this->session->set_userdata($user_info);

			// redirect('account/profile');
			redirect($this->input->post('email'));
		}
	}

	// Private functions for verifications
}

/* End of file validate.php */
/* Location: ./application/controllers/validate.php */
