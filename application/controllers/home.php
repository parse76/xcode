<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		//Load Dependencies
	}

	public function index()
	{
		$data['page'] = 'home_view';
		$this->load->view('template', $data);
	}

	public function profile()
	{
		$this->load->library('facebook');
		$this->load->helper('common_helper');
		$data['access_token'] = $this->facebook->getAccessToken();
		$data['user'] = $this->facebook->api('/me');
		$this->load->view('profile_view', $data);
	}

	public function newsletter()
	{
		// loads the form_validation library
		$this->load->library('form_validation');

		// field name, error message, validation rules
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');

		if ($this->form_validation->run('newsletter') == false) {
			// Error in name or email
		} else {
			$email = $this->input->post('email');

			$this->load->library('email');
			$this->email->set_newline("\r\n");

			$this->email->from('xcode.test.project@gmail.com', 'Xcode');
			$this->email->to($email);		
			$this->email->subject('Xcode Newsletter Signup Confirmation');		
			$this->email->message('You\'ve now signed up, fool!');

			// $path = $this->config->system_url();
			// $path = $this->config->item('server_root');
			// $file = $path . '/ci_day4/attachments/newsletter1.txt';

			// $this->email->attach($file);

			if ($this->email->send()) {
				// Load a view somekinda subscribing?
			} else {
				// Load a view somekinda error?
			}
		}
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
