<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Template Class
* Handles all the view being processed
*/
class Template
{
	public function header_profile()
	{
		$username = $this->session->userdata('username');
		$authenticator = $this->session->userdata('authenticator');
		$logged_in = $this->session->userdata('logged_in');
	}
}

$data['base_url'] = base_url();

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