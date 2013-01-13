<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('account_model');

        $this->load->library('recaptcha');
        $this->load->library('encrypt');
        $this->load->library('email');
    }

    // public function index()
    // {
    //     $data['page'] = 'account/account_view';
    //     $this->load->view('template', $data);
    // }

    public function user_login()
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

        // $data['content'] = $params;
        // $data['layout'] = 'default';
        // $data['page'] = 'account/login_view';

        $data = array(
            'content' => $params,
            'layout' => 'default',
            'page' => 'account/login_view'
        );

        $this->load->view('template', $data);
    }

    public function register_user()
    {
        // Check if referred by third part accounts
        $authenticator = $this->session->flashdata('authenticator');
        $authenticator_id = $this->session->flashdata('authenticator_id');

        // if ($this->account_model->third_party_login($authenticator, $authenticator_id))
        // {
        //     echo 'REDIRECT TO PROFILE';
        // }

        if ($this->input->post())
        {
            $validator = $this->form_validation->run('register');
            $response = $this->recaptcha->recaptcha_check_answer();
            
            if ($validator === TRUE && $response->is_valid)
            {
                $register_data = array_slice($this->input->post(NULL, TRUE),0, 5);
                
                if ($authenticator && $authenticator_id)
                {
                    $register_data[$authenticator] = $authenticator_id;
                }

                $register_data['password'] = md5($this->encrypt->encode($register_data['password']));
                $register_data['token'] = sha1($this->encrypt->encode($register_data['username']));
                $register_data['date_registered'] = date("Y-m-d H:i:s", time());

                if ($this->account_model->register_user($register_data))
                {
                    // Send confirmation email
                    $this->send_email_confirmation($register_data['email'], $register_data['token']);

                    $data['content'] = $params;
                    $data['layout'] = 'default';
                    $data['page'] = 'account/register_view';

                    $this->load->view('template', $data);
                }
                else
                {
                    throw new Exception("Cannot register at the moment", 1);
                }
                
                // var_dump($register_data);
                // var_dump($this->input->post(NULL, TRUE));
            }
            else
            {
                // Preserve authentication if registration fails
                if ($authenticator)
                {
                    $this->session->keep_flashdata('authenticator');
                    $this->session->keep_flashdata('authenticator_id');
                }

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
                $params['authenticator'] = $this->session->flashdata('authenticator');
                $params['firstname'] = $this->session->flashdata('firstname');
                $params['lastname'] = $this->session->flashdata('lastname');
                $params['email'] = $this->session->flashdata('email');
                $params['username'] = $this->session->flashdata('username');

                $this->session->keep_flashdata('authenticator');
                $this->session->keep_flashdata('authenticator_id');
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
        $data['layout'] = 'default';
        $data['page'] = 'account/register_view';

        $this->load->view('template', $data);
    }

    public function facebook_login()
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

            if ($this->account_model->third_party_login('facebook', $facebook_id))
            {
                echo "redirect to profile";
            }
            else
            {
                $open_graph = $this->facebook->api('me');

                $facebook_data['authenticator'] = 'facebook';
                $facebook_data['authenticator_id'] =  $open_graph['id'];
                $facebook_data['firstname'] =  $open_graph['first_name'];
                $facebook_data['lastname'] =  $open_graph['last_name'];
                $facebook_data['email'] =  $open_graph['email'];
                $facebook_data['username'] =  $open_graph['username'];

                $this->session->set_flashdata($facebook_data);

                redirect('account/register');
            }
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

    public function twitter_login()
    {
        echo 'TODO: twitter connect app';
    }

    public function google_plus_login()
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

            $gmail = $oauth2_response['email'];
            $oauth2_response['username'] = substr($gmail, 0, strpos($gmail, '@'));
            
            if ($this->account_model->third_party_login('google', $google_id))
            {
                echo "redirect to profile";
            }
            else
            {
                $google_data['authenticator'] = 'google';
                $google_data['authenticator_id'] = $oauth2_response['id'];
                $google_data['firstname'] = $oauth2_response['given_name'];
                $google_data['lastname'] = $oauth2_response['family_name'];
                $google_data['email'] = $oauth2_response['email'];
                $google_data['username'] = $oauth2_response['username'];

                $this->session->set_flashdata($google_data);

                redirect('account/register');
            }
        }
        else
        {
            // $authUrl = $this->google->createAuthUrl();
            redirect($this->google->createAuthUrl());
        }
    }

    public function send_email_confirmation($email='', $token='')
    {
        // Send confirmation email
        $this->email->set_newline("\r\n");
        
        $this->email->from('xcode.test.project@gmail.com', 'Xcode Project');
        $this->email->to($email);     
        $this->email->subject('Xcode Verify Registration');

        $verify_segments = array('verify', $token);
        $verify_url = site_url($verify_segments);

        $msg = "Thank you and welcome to Xcode Test Project!\n\n";
        $msg .= "Please click the link to activate your account:\n".$verify_url;

        $this->email->message($msg);

        $this->email->send();

        // if($this->email->send())
        // {
        //     return TRUE;
        // }
        // else
        // {
        //     // show_error($this->email->print_debugger());
        //     return FALSE;
        // }
    }

    public function verify_token($token='')
    {
        if ($token)
        {
            if ($this->account_model->verify_token($token))
            {
                $user_data = array(
                    'date_verified' => date("Y-m-d H:i:s", time())
                );

                if ($this->account_model->update_verified_date($token, $user_data));
                {
                    echo "YOHOHO REDIRECT TO PROFILE";
                }
            }
            else
            {
                echo "WALA KAMING GANYANG TOKEN!";
            }
        }
        else
        {
            redirect('home');
        }
    }

    public function resend_email_confirmation($email='')
    {
        if ($this->input->post())
        {
            if ($this->form_validation->run('email'))
            {
                $email = $this->input->post('email');

                $username = $this->account_model->get_username($email);

                var_dump($username);

                // if ($username)
                // {
                //     $token = sha1($this->encrypt->encode($username));

                //     $user_data = array(
                //         'token' => $token
                //     );

                //     if ($this->account_model->update_token($email, $user_data))
                //     {
                //         echo "token updated";
                //     }
                //     else
                //     {
                //         throw new Exception("Fail resending", 1);
                //     }
                // }

                $params = array();
            }
            else
            {
                throw new Exception("Invalid Email", 1);
            }
        }
        else
        {
            $params['email'] = '';

            $params['email_error'] = form_error('email');
        }

        $data['content'] = $params;
        $data['layout'] = 'default';
        $data['page'] = 'account/resend_view.php';

        $this->load->view('template', $data);
    }

    public function user_logout()
    {
        // session_destroy();

        $user_data = array(
            'username' => '',
            'authenticator' => '',
            'logged_in' => FALSE
        );

        $this->session->unset_userdata($user_data);

        redirect('home');
    }
}

/* End of file account.php */
/* Location: ./application/controllers/account.php */
