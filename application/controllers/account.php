<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		//Load Dependencies

		//instantiate the Facebook library with the APP ID and APP SECRET
		// $config = array(
		// 	'appId' => '277835292335638',
		// 	'secret' => 'd3368aba56f8af88697b24b3fea344c0',
		// 	'cookie' => true
		// );

		// loads the facebook library
		// $this->load->library('facebook', $config);
	}

	// public function index()
	// {
	// 	$data['page'] = 'account_view';
	// 	$this->load->view('template', $data);
	// }

	// public function _remap($value='index') // CI's default method when a controller is called
	// {
	// 	if ($value == 'index') {
	// 		// $data['page'] = 'account_view';
	// 		// $this->load->view('template', $data);

	// 		redirect('404');
	// 	} else {
	// 		if (method_exists($this, $value)) {
	// 			$this->$value();
	// 		} else {
	// 			// Database verification here
	// 			$x = 1;

	// 			if ($x == 1) {
	// 				$this->profile();
	// 			} else {
	// 				redirect('404');
	// 				// show_404();
	// 			}
	// 		}
	// 	}
	// }

	private function test()
	{
		echo 'private method';
	}

	private function validate_registration()
	{
		$routes = $this->router->routes;

		foreach ($routes as $key => $value) {
			if ($username == $key) {
				echo 'Unauthorized username!';
			}
		}

		if ($preg_match_condition) {
			echo 'Invalid username!';
		}

		if ($match == true) {
			echo 'Username already taken';
		}
	}

	private function default_login()
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
			// redirect($this->input->post('email'));
			redirect('home');
		}
	}

	private function facebook_login()
	{
		$this->load->library('facebook');

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
			$permissions_needed = array('publish_stream');
			foreach($permissions_needed as $perm) {
				if( !isset($permissions_list['data'][0][$perm]) || $permissions_list['data'][0][$perm] != 1 ) {
					$login_url_params = array(
						'scope' => 'publish_stream',
						'fbconnect' =>  1,
						'display'   =>  "page",
						'next' => 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']
					);
					$login_url = $this->facebook->getLoginUrl($login_url_params);
					header("Location: {$login_url}");
					exit();
				}
			}
			
			//save the information inside the session
			$_SESSION['access_token'] = $access_token;
			
			//redirect to manage.php
			//header('Location: manage.php');
			redirect('home/profile');
		} else {
			//if not, let's redirect to the ALLOW page so we can get access
			//Create a login URL using the Facebook library's getLoginUrl() method
			$login_url_params = array(
				'scope' => 'publish_stream',
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

	private function twitter_login()
	{
		echo 'TODO: Twitter Login';
	}
}

/* End of file account.php */
/* Location: ./application/controllers/account.php */
