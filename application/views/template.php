<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Template loader

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

if (isset($content)) {
    $content['base_url'] = base_url();
    $this->parser->parse($page, $content);  
} else {
    $this->parser->parse($page, $data); 
}

$this->parser->parse('footer', $data);

/* End of file template.php */
/* Location: ./application/views/template.php */