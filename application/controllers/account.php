<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Account
*/
class Account extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['page'] = 'account_view';
		$this->load->view('template', $data);
	}

	public function login()
	{
		if ($this->form_validation->run('login') == false) {
   			$data['page'] = 'account_view';
			$this->load->view('template', $data);
		} else {
   			redirect('home/profile');
		}
	}

	public function register()
	{
		$data['page'] = 'account_view';
		$this->load->view('template', $data);
	}
}
