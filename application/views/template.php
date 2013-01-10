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
    $content['header_link'] = 'account';
}


if ($layout === "default")
{

}
else if ($layout === 'profile')
{
	$this->parser->parse('header', $content);

	$this->parser->parse('home/header_view', $content);

	$this->parser->parse($page, $content);

	$this->parser->parse('footer', $content);
}



// $this->parser->parse('home/header_view', $content);

// $this->parser->parse('home/banner_view', $content);

// $this->parser->parse('home/navbar_view', $content);

// $this->parser->parse($page, $content);

// $this->parser->parse('home/footer_view', $content);

/* End of file template.php */
/* Location: ./application/views/template.php */
