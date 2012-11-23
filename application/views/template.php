<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Template Class
* Handles all the view being processed
*/
class Template
{
	public $data;

	protected $username;
	protected $authenticator;
	protected $logged_in;

	public function __construct()
	{
		// Extending the Codeigniter system instance
      	$this->ci =& get_instance();

		$this->header_setters();
	}

	public function session_get()
	{
		// $userdata = $this->ci->session->all_userdata();

		$logged_in = $this->ci->session->userdata('logged_in');

		if (isset($logged_in) && $logged_in === true) {
			return 'true';
		} else {
			return 'false';
		}

		// if (!isset($last_activity)) {
  //   		$_SESSION['CREATED'] = time();
		// } else if (time() - $_SESSION['CREATED'] > 1800) {
  //   		// session started more than 30 minates ago
  //   		session_regenerate_id(true);    // change session ID for the current session an invalidate old session ID
  //   		$_SESSION['CREATED'] = time();  // update creation time
		// }

		// $last_activity = date('Y-m-d H:i:s', $last_activity);

		// $last_activity2 = date('Y-m-d H:i:s', time());

		// return $last_activity.' - '.$last_activity2;
	}

	private function header_setters()
	{
		$this->data['base_url'] = base_url();
		// $this->$username = $this->session->userdata('username');
		// $this->$authenticator = $this->session->userdata('authenticator');
		// $this->$logged_in = $this->session->userdata('logged_in');
	}
}


$data['base_url'] = base_url();
// $data['base_url'] = 'http://10.3.10.214/xcode/';

$username = $this->session->userdata('username');

if ($username) {
    $data['username'] = $username;
    $data['link'] = $username;
} else {
    $data['username'] = '( Sign In! )';
    $data['link'] = 'login';
}

$this->parser->parse('header', $data);

$this->parser->parse('banner', $data);

$this->parser->parse('navbar', $data);

$this->parser->parse($page, $data);  

$this->parser->parse('footer', $data);


$template = new Template();

print_r($template->session_get());

// date_default_timezone_set('Asia/Manila');

// echo ini_get('date.timezone');

// echo date('Y-m-d H:i:s', time());

// echo date_default_timezone_get();

/* End of file template.php */
/* Location: ./application/views/template.php */