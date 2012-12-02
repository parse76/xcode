<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login()
    {
        $params = array();

        if ($this->input->post())
        {
            if ($this->form_validation->run('login') === TRUE)
            {
                // Database validation here

                $login_data = array(
                    'username' = $this->input->post('username'),
                    'authenticator' = 'default',
                    'logged_in' = TRUE
                );

                $this->session->set_userdata($login_data);

                redirect('home');
            }
            else
            {
                $params['username'] = $this->input->post('username');
                $params['login_error'] = 'Either Username or Password is incorrect';
            }
        }
        else
        {
            $params['username'] = '';
            $params['login_error'] = '';
        }

        $data['content'] = $params;
        $data['page'] = 'login';

        $this->load->view('template', $data);
    }

    public function register()
    {
        $params = array();

        $this->load->library('recaptcha');

        $authenticator = $this->sesseion->userdata('authenticator');

        if ($this->input->post())
        {
            $validator = $this->form_validation->run('register');
            $response = $this->recaptcha->recaptcha_check_answer();
            
            if ($validator === TRUE && $response->is_valid)
            {
                echo "TODO: Redirect to home or profile page";
            }
            else
            {
                // Get recaptcha error
                $this->recaptcha->error = $response->error;

                // Return submitted values
                $params['firstname'] = set_value('firstname');
                $params['lastname'] = set_value('lastname');
                $params['email'] = set_value('email');
                $params['username'] = set_value('username');
            }
        }
        else
        {
            if ($authenticator)
            {
                $register_data = $this->session->all_userdata();

                $params['firstname'] = $register_data['firstname'];
                $params['lastname'] = $register_data['lastname'];
                $params['email'] = $register_data['email'];
                $params['username'] = $register_data['username'];
            }
            else
            {
                // Set blank values
                $params['firstname'] = '';
                $params['lastname'] = '';
                $params['email'] = '';
                $params['username'] = '';
            }
        }

        // Set error messages
        $params['firstname_error'] = form_error('firstname');
        $params['lastname_error'] = form_error('lastname');
        $params['email_error'] = form_error('email');
        $params['username_error'] = form_error('username');
        $params['password_error'] = form_error('password');
        $params['password2_error'] = form_error('password2');

        $params['recaptcha'] = $this->recaptcha->recaptcha_get_html();

        $data['content'] = $params;
        $data['page'] = 'register';

        $this->load->view('template', $data);
    }

    public function google()
    {
        $params = array();

        $this->load->library('google');

        if (isset($_GET['code'])) {
            $this->google->authenticate($_GET['code']);
            $_SESSION['access_token'] = $this->google->getAccessToken();
        }

        if (isset($_SESSION['access_token'])) {
            $this->google->setAccessToken($_SESSION['access_token']);
        }

        if ($this->google->getAccessToken()) {
            $plus_response = $this->google->plus->people->get('me');
            $oauth2_response = $this->google->oauth2->userinfo->get();

            if ($plus_response['isPlusUser'] != true) {
                // must activate google+ first
            }

            if ($oauth2_response['verified_email'] != true) {
                // must verify email first
            }

            $google_id = $oauth2_response['id'];
            // select from user where google_id = $google_id
            // if (true) {
            //     redirect to profile
            // } else {
            //     redirect to register

                // Set error messages

                $gmail = $oauth2_response['email'];
                $google_username = substr($gmail, 0, strpos($gmail, '@'));

                $params['authenticator'] = 'google';
                $params['google_id'] = $oauth2_response['id'];
                $params['firstname'] = $oauth2_response['given_name'];
                $params['lastname'] = $oauth2_response['family_name'];
                $params['email'] = $oauth2_response['email'];
                $params['username'] = $google_username;

                $this->session->set_userdata($params);

                redirect('register');
            // }

            

            // var_dump($plus_response);
            // foreach ($plus_response as $key => $value) {
            //     echo $key.' => '.$value.'<br>';
            // }
            // echo '<hr>';
            // var_dump($oauth2_response);
            // foreach ($oauth2_response as $key => $value) {
            //     echo $key.' => '.$value.'<br>';
            // }
            // print_r($_SESSION);
            // print_r($_GET);
        }
    }
}           

/* End of file account.php */
/* Location: ./application/controllers/account.php */
