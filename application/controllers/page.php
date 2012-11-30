<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller
{
    private $params;

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page'] = 'page/home_view';
        $this->load->view('template', $data);
    }

    public function about_us()
    {
        $data['page'] = 'page/about_us_view';
        $this->load->view('template', $data);
    }

    public function contact_us()
    {
        $data['page'] = 'page/contact_us_view';
        $this->load->view('template', $data);
    }

    public function site_map()
    {
        $data['page'] = 'page/site_map_view';
        $this->load->view('template', $data);
    }

    public function login()
    {
        $params = array();

        $params['username'] = '';
        $params['login_error'] = '';

        $data['content'] = $params;
        $data['page'] = 'page/login_view';
        $this->load->view('template', $data);
    }

    public function register()
    {
        $params = array();

        $this->load->library('recaptcha');

        $params['recaptcha'] = $this->recaptcha->recaptcha_get_html();
        
        // Declaring blank set values
        $params['firstname'] = '';
        $params['lastname'] = '';
        $params['email'] = '';
        $params['username'] = '';

        // Declaring blank error messages
        $params['firstname_error'] = '';
        $params['lastname_error'] = '';
        $params['email_error'] = '';
        $params['username_error'] = '';
        $params['password_error'] = '';
        $params['password2_error'] = '';

        $data['content'] = $params;

        $data['page'] = 'page/register_view';
        $this->load->view('template', $data);
    }

    public function logout()
    {
        // session_destroy();

        $user_info = array(
            'username' => '',
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
