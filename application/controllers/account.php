<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login()
    {
        if ($this->input->post())
        {
            if ($this->form_validation->run('login') === TRUE)
            {
                // Database validation here

                $login_data['username'] = $this->input->post('username');
                $login_data['authenticator'] = 'default';
                $login_data['logged_in'] = TRUE;

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
        $this->load->library('recaptcha');

        // Check if referred by third part accounts
        $authenticator = $this->session->flashdata('authenticator');

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
                // $register_data = $this->session->all_userdata();
                $params['authenticator'] = $this->session->flashdata('authenticator');
                $params['firstname'] = $this->session->flashdata('firstname');
                $params['lastname'] = $this->session->flashdata('lastname');
                $params['email'] = $this->session->flashdata('email');
                $params['username'] = $this->session->flashdata('username');
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

        // Set error messages, returns blank if no error
        $params['firstname_error'] = form_error('firstname');
        $params['lastname_error'] = form_error('lastname');
        $params['email_error'] = form_error('email');
        $params['username_error'] = form_error('username');
        $params['password_error'] = form_error('password');
        $params['password2_error'] = form_error('password2');

        $params['recaptcha'] = $this->recaptcha->recaptcha_get_html();

        $data['content'] = $params;
        $data['page'] = 'register_view';

        $this->load->view('template', $data);
    }

    public function facebook()
    {
        $this->load->library('facebook');

        //Get the FB UID of the currently logged in user
        $facebook_id = $this->facebook->getUser();

        //if the user has already allowed the application, you'll be able to get his/her FB UID
        if ($facebook_id)
        {                        
            //get the user's access token
            $access_token = $this->facebook->getAccessToken();
            //check permissions list
            $permissions_list = $this->facebook->api(
                '/me/permissions',
                'GET',
                array(
                    'access_token' => $access_token
                )
            );
            
            //check if the permissions we need have been allowed by the user
            //if not then redirect them again to facebook's permissions page
            $permissions_needed = array('publish_stream', 'email');

            foreach($permissions_needed as $perm)
            {
                if( !isset($permissions_list['data'][0][$perm]) || $permissions_list['data'][0][$perm] != 1 )
                {
                    $login_url_params = array(
                        'scope' => 'publish_stream, email',
                        'fbconnect' =>  1,
                        'display'   =>  "page",
                        'next' => 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']
                    );
                    
                    $login_url = $this->facebook->getLoginUrl($login_url_params);
                    // header("Location: {$login_url}");
                    redirect($login_url);
                    exit();
                }
            }
            
            //save the information inside the session
            $_SESSION['access_token'] = $access_token;

            // select from user where facebook_id = $facebook_id
            // if (true) {
            //     redirect to profile
            // } else {
            
                $open_graph = $this->facebook->api('me');

                $facebook_data['authenticator'] = 'facebook';
                $facebook_data['facebook_id'] =  $open_graph['id'];
                $facebook_data['firstname'] =  $open_graph['first_name'];
                $facebook_data['lastname'] =  $open_graph['last_name'];
                $facebook_data['email'] =  $open_graph['email'];
                $facebook_data['username'] =  $open_graph['username'];

                $this->session->set_flashdata($facebook_data);

                redirect('account/register');
            // }
        }
        else
        {
            //if not, let's redirect to the ALLOW page so we can get access
            //Create a login URL using the Facebook library's getLoginUrl() method
            $login_url_params = array(
                'scope' => 'publish_stream, email',
                'fbconnect' =>  1,
                'display'   =>  "page",
                'next' => 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']
            );

            $login_url = $this->facebook->getLoginUrl($login_url_params);
            
            //redirect to the login URL on facebook
            // header("Location: {$login_url}");
            redirect($login_url);
            exit();
        }
    }

    public function twitter()
    {
        echo 'TODO: twitter connect app';
    }

    public function google()
    {
        $this->load->library('google');

        if (isset($_GET['code']))
        {
            $this->google->authenticate($_GET['code']);
            $_SESSION['access_token'] = $this->google->getAccessToken();
        }

        if (isset($_SESSION['access_token']))
        {
            $this->google->setAccessToken($_SESSION['access_token']);
        }

        if ($this->google->getAccessToken())
        {
            $plus_response = $this->google->plus->people->get('me');
            $oauth2_response = $this->google->oauth2->userinfo->get();

            if ($plus_response['isPlusUser'] != TRUE)
            {
                // must activate google+ first
            }

            if ($oauth2_response['verified_email'] != TRUE)
            {
                // must verify email first
            }

            $google_id = $oauth2_response['id'];
            // select from user where google_id = $google_id
            // if (true) {
            //     redirect to profile
            // } else {

                $gmail = $oauth2_response['email'];
                $google_username = substr($gmail, 0, strpos($gmail, '@'));

                $google_data['authenticator'] = 'google';
                $google_data['google_id'] = $oauth2_response['id'];
                $google_data['firstname'] = $oauth2_response['given_name'];
                $google_data['lastname'] = $oauth2_response['family_name'];
                $google_data['email'] = $oauth2_response['email'];
                $google_data['username'] = $google_username;

                $this->session->set_flashdata($google_data);

                redirect('account/register');
            // }
        }
        else
        {
            // $authUrl = $this->google->createAuthUrl();
            redirect($this->google->createAuthUrl());
        }
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
    }
}

/* End of file account.php */
/* Location: ./application/controllers/account.php */
