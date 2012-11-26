<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

		// if (!isset($last_activity)) {
  //   		$_SESSION['CREATED'] = time();
		// } else if (time() - $_SESSION['CREATED'] > 1800) {
  //   		// session started more than 30 minates ago
  //   		session_regenerate_id(true);    // change session ID for the current session an invalidate old session ID
  //   		$_SESSION['CREATED'] = time();  // update creation time
		// }

$data['base_url'] = base_url();
// $data['base_url'] = 'http://10.3.10.214/xcode/';

$username = $this->session->userdata('username');

if ($username) {
    $data['header_name'] = $username;
    $data['header_link'] = $username;
} else {
    $data['header_name'] = '( Sign In! )';
    $data['header_link'] = 'login';
}

$this->parser->parse('header', $data);

$this->parser->parse('banner', $data);

$this->parser->parse('navbar', $data);

$this->parser->parse($page, $data);

$this->parser->parse('footer', $data);

/* End of file template.php */
/* Location: ./application/views/template.php */