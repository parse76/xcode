<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// if (!isset($last_activity)) {
//     $_SESSION['CREATED'] = time();
//     } else if (time() - $_SESSION['CREATED'] > 1800) {
//     // session started more than 30 minates ago
//     session_regenerate_id(true);    // change session ID for the current session an invalidate old session ID
//   	$_SESSION['CREATED'] = time();  // update creation time
// }

$content['base_url'] = base_url();

$username = $this->session->userdata('username');

if ($username) {
    $content['header_name'] = $username;
    $content['header_link'] = $username;
} else {
    $content['header_name'] = '( Sign In! )';
    $content['header_link'] = 'login';
}


if ($layout === 'default')
{
	$this->parser->parse('header', $content);
	$this->parser->parse('main/header_view', $content);
	$this->parser->parse('main/banner_view', $content);
	$this->parser->parse('main/navbar_view', $content);
	$this->parser->parse($page, $content);
	$this->parser->parse('main/footer_view', $content);
	$this->parser->parse('footer', $content);
}
else if ($layout === 'profile')
{
	$this->parser->parse('header', $content);
	$this->parser->parse($page, $content);
	$this->parser->parse('footer', $content);
}
else if ($layout === 'none')
{
	$this->parser->parse('header', $content);
	$this->parser->parse($page, $content);
	$this->parser->parse('footer', $content);
}

var_dump($content);

/* End of file template.php */
/* Location: ./application/views/template.php */
