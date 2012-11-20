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
		$this->header_setters();
	}

	private function header_setters()
	{
		$this->data['base_url'] = base_url();
		// $this->$username = $this->session->userdata('username');
		// $this->$authenticator = $this->session->userdata('authenticator');
		// $this->$logged_in = $this->session->userdata('logged_in');
	}

	public function preprint($data, $return = false) {
		$data = "<pre>";
		$data .= print_r($data, 1);
		$data .= "</pre>";
		if ($return) return $data;
		else print $data;
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

/* End of file template.php */
/* Location: ./application/views/template.php */