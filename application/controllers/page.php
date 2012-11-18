<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page'] = 'pages/home_view';
        $this->load->view('template', $data);
    }

    public function about_us()
    {
        $data['page'] = 'pages/about_us_view';
        $this->load->view('template', $data);
    }

    public function contact_us()
    {
        $data['page'] = 'pages/contact_us_view';
        $this->load->view('template', $data);
    }

    public function site_map()
    {
        $data['page'] = 'pages/site_map_view';
        $this->load->view('template', $data);
    }

    public function login()
    {
        $data['page'] = 'pages/login_view';
        $this->load->view('template', $data);
    }

    public function register()
    {
        $this->load->library('recaptcha');

        $data['data'] = array(
            'recaptcha' => $this->recaptcha->recaptcha_get_html()
        );

        $data['page'] = 'pages/register_view';
        $this->load->view('template', $data);
    }

    public function logout()
    {
        // session_destroy();

        $user_info = array(
            'username'  => '',
            'authenticator' => '',
            'logged_in' => false
        );

        $this->session->unset_userdata($user_info);

        redirect('home');

        // redirect($this->facebook->getLogoutUrl());
    }

    public function page_missing()
    {
        $this->load->view('page_missing');
    }
}

/* End of file page.php */
/* Location: ./application/controllers/page.php */
