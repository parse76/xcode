<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Home
*/
class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		//instantiate the Facebook library with the APP ID and APP SECRET
		$config = array(
			'appId' => '277835292335638',
			'secret' => 'd3368aba56f8af88697b24b3fea344c0',
			'cookie' => true
		);

		// loads the facebook library
		$this->load->library('facebook', $config);
	}

	public function index()
	{
		$data['page'] = 'home_view';
		$this->load->view('template', $data);
	}

	public function facebook_login()
	{
		//Get the FB UID of the currently logged in user
		$user = $this->facebook->getUser();

		//if the user has already allowed the application, you'll be able to get his/her FB UID
		if($user) {
			//start the session if needed
			if( session_id() ) {
				
			} else {
				session_start();
			}
			
			//do stuff when already logged in
			
			//get the user's access token
			$access_token = $this->facebook->getAccessToken();
			//check permissions list
			$permissions_list = $this->facebook->api(
				'/me/permissions',
				'GET',
				array(
					'access_token' => $access_token
				)
			);
			
			//check if the permissions we need have been allowed by the user
			//if not then redirect them again to facebook's permissions page
			$permissions_needed = array('publish_stream', 'read_stream', 'manage_pages');
			foreach($permissions_needed as $perm) {
				if( !isset($permissions_list['data'][0][$perm]) || $permissions_list['data'][0][$perm] != 1 ) {
					$login_url_params = array(
						'scope' => 'publish_stream,read_stream,manage_pages',
						'fbconnect' =>  1,
						'display'   =>  "page",
						'next' => 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']
					);
					$login_url = $this->facebook->getLoginUrl($login_url_params);
					header("Location: {$login_url}");
					exit();
				}
			}
			
			//if the user has allowed all the permissions we need,
			//get the information about the pages that he or she managers
			$accounts = $this->facebook->api(
				'/me/accounts',
				'GET',
				array(
					'access_token' => $access_token
				)
			);
			
			//save the information inside the session
			$_SESSION['access_token'] = $access_token;
			$_SESSION['accounts'] = $accounts['data'];
			//save the first page as the default active page
			$_SESSION['active'] = $accounts['data'][0];
			
			//redirect to manage.php
			//header('Location: manage.php');
			redirect('home/profile');
		} else {
			//if not, let's redirect to the ALLOW page so we can get access
			//Create a login URL using the Facebook library's getLoginUrl() method
			$login_url_params = array(
				'scope' => 'publish_stream,read_stream,manage_pages',
				'fbconnect' =>  1,
				'display'   =>  "page",
				'next' => 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']
			);
			$login_url = $this->facebook->getLoginUrl($login_url_params);
			
			//redirect to the login URL on facebook
			header("Location: {$login_url}");
			exit();
		}
	}

	public function profile()
	{
		$data['user'] = $this->facebook->api('/me');
		$this->load->view('profile_view', $data);
	}

	public function logout()
	{
		session_destroy();
		redirect($this->facebook->getLogoutUrl());
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