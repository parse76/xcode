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
        $this->load->library('template');
    }

    // public function index()
    // {
    //     // Option for loading the data

    //     // Option 1
    //     $data['content'] = $params;
    //     $data['layout'] = 'none';
    //     $data['page'] = 'account/login_view';

    //     // Option 2
    //     $data = array(
    //         'content' => $params,
    //         'layout' => 'none',
    //         'page' => 'account/login_view'
    //     );

    //     // Option 3
    //     $data->content = $params;
    //     $data->layout = 'none';
    //     $data->page = 'account/login_view';

    //     $this->load->view('template', $data);
    // }

    // public function user_login()
    // {
    //     if ($this->input->post())
    //     {

    //         var_dump($this->form_validation->run('login'));
    //         exit();

    //         $username = $this->input->post('username');
    //         $password = $this->input->post('password');

    //         $form_validation = $this->form_validation->run('login');
    //         $database_validation = $this->account_model->user_login($username, $password);

    //         if ($form_validation === TRUE && $database_validation)
    //         {
    //             $login_data['username'] = $this->input->post('username');
    //             $login_data['authenticator'] = 'default';
    //             $login_data['logged_in'] = TRUE;

    //             $this->session->set_userdata($login_data);

    //             echo "GOOD";
    //         }
    //         else
    //         {
    //             $params['username'] = $this->input->post('username');
    //             $params['login_error'] = 'Either Username or Password is incorrect';
    //         }
    //     }
    //     else
    //     {
    //         $params['username'] = '';
    //         $params['login_error'] = '';
    //     }

    //     $data['content'] = $params;
    //     $data['layout'] = 'none';
    //     $data['page'] = 'account/login_view';

    //     $this->load->view('template', $data);
    // }

    public function user_login()
    {
        if ($this->input->post())
        {
            $params = $this->_check_user_login();
        }
        else
        {
            $params['username'] = NULL;
            $params['login_error'] = NULL;
        }

        $data = array(
            'content' => $params,
            'layout' => "none",
            'page' => "account/login_view"
        );

        $this->template->load($data);
    }

    protected function _check_user_login()
    {
        try
        {
            if (!$this->form_validation->run('login'))
            {
                throw new Exception("Validation failed.");
            }

            $username = $this->input->post('username');
            $password = $this->mycrypt($this->input->post('password'));
            $database_validation = $this->account_model->user_login($username, $password);

            if (!$database_validation)
            {
                throw new Exception("Record not found.");
            }

            $login_data = array(
                'user_id' => $database_validation['id'],
                'authenticator' => "default",
                'logged_in' => TRUE
            );

            $this->session->set_userdata($login_data);

            redirect($username);
        }
        catch (Exception $e)
        {
            $params['username'] = $this->input->post('username');
            $params['login_error'] = "Either Username or Password is incorrect";
        }

        return $params;
    }

    // public function register_user()
    // {
    //     // Check if referred by third part accounts
    //     $authenticator = $this->session->flashdata('authenticator');
    //     $authenticator_id = $this->session->flashdata('authenticator_id');

    //     // if ($this->account_model->third_party_login($authenticator, $authenticator_id))
    //     // {
    //     //     echo 'REDIRECT TO PROFILE';
    //     // }

    //     if ($this->input->post())
    //     {
    //         $validator = $this->form_validation->run('register');
    //         $response = $this->recaptcha->recaptcha_check_answer();
            
    //         if ($validator === TRUE && $response->is_valid)
    //         {
    //             $register_data = array_slice($this->input->post(NULL, TRUE),0, 5);
                
    //             if ($authenticator && $authenticator_id)
    //             {
    //                 $register_data[$authenticator] = $authenticator_id;
    //             }

    //             $register_data['password'] = md5($this->encrypt->encode($register_data['password']));
    //             $register_data['token'] = sha1($this->encrypt->encode($register_data['username']));
    //             $register_data['date_registered'] = date("Y-m-d H:i:s", time());

    //             if ($this->account_model->register_user($register_data))
    //             {
    //                 // Send confirmation email
    //                 $this->send_email_confirmation($register_data['email'], $register_data['token']);

    //                 $data['content'] = $params;
    //                 $data['layout'] = 'default';
    //                 $data['page'] = 'account/register_view';

    //                 $this->load->view('template', $data);
    //             }
    //             else
    //             {
    //                 throw new Exception("Cannot register at the moment", 1);
    //             }
                
    //             // var_dump($register_data);
    //             // var_dump($this->input->post(NULL, TRUE));
    //         }
    //         else
    //         {
    //             // Preserve authentication if registration fails
    //             if ($authenticator)
    //             {
    //                 $this->session->keep_flashdata('authenticator');
    //                 $this->session->keep_flashdata('authenticator_id');
    //             }

    //             // Get recaptcha error
    //             $this->recaptcha->error = $response->error;

    //             // Return submitted values
    //             $params['firstname'] = set_value('firstname');
    //             $params['lastname'] = set_value('lastname');
    //             $params['email'] = set_value('email');
    //             $params['username'] = set_value('username');
    //         }
    //     }
    //     else
    //     {
    //         if ($authenticator)
    //         {
    //             $params['authenticator'] = $this->session->flashdata('authenticator');
    //             $params['firstname'] = $this->session->flashdata('firstname');
    //             $params['lastname'] = $this->session->flashdata('lastname');
    //             $params['email'] = $this->session->flashdata('email');
    //             $params['username'] = $this->session->flashdata('username');

    //             $this->session->keep_flashdata('authenticator');
    //             $this->session->keep_flashdata('authenticator_id');
    //         }
    //         else
    //         {
    //             // Set blank values
    //             $params['firstname'] = '';
    //             $params['lastname'] = '';
    //             $params['email'] = '';
    //             $params['username'] = '';
    //         }
    //     }

    //     // Set error messages, returns blank if no error
    //     $params['firstname_error'] = form_error('firstname');
    //     $params['lastname_error'] = form_error('lastname');
    //     $params['email_error'] = form_error('email');
    //     $params['username_error'] = form_error('username');
    //     $params['password_error'] = form_error('password');
    //     $params['password2_error'] = form_error('password2');

    //     $params['recaptcha'] = $this->recaptcha->recaptcha_get_html();

    //     $data['content'] = $params;
    //     $data['layout'] = 'none';
    //     $data['page'] = 'account/register_view';

    //     $this->load->view('template', $data);
    // }

    public function register_user()
    {
        if ($this->input->post())
        {
            $params = $this->_check_register_user();
        }
        else if ($this->session->flashdata('authenticator'))
        {
            $params['firstname'] = $this->session->flashdata('firstname');
            $params['lastname'] = $this->session->flashdata('lastname');
            $params['email'] = $this->session->flashdata('email');
            $params['username'] = $this->session->flashdata('username');
        }
        else
        {
            // Set blank values
            $params['firstname'] = NULL;
            $params['lastname'] = NULL;
            $params['email'] = NULL;
            $params['username'] = NULL;
        }

        // Set error messages, returns blank if no error
        $params['firstname_error'] = form_error('firstname');
        $params['lastname_error'] = form_error('lastname');
        $params['email_error'] = form_error('email');
        $params['username_error'] = form_error('username');
        $params['password_error'] = form_error('password');
        $params['password2_error'] = form_error('password2');
        $params['birthdate_error'] = form_error('birthdate');
        $params['recaptcha'] = $this->recaptcha->recaptcha_get_html();

        var_dump($params['error']);

        var_dump(form_error('birthdate'));

        $data = array(
            'content' => $params,
            'layout' => 'none',
            'page' => 'account/register_view'
        );

        $this->template->load($data);
    }

    protected function _check_register_user()
    {
        try
        {
            if (!$this->form_validation->run('register'))
            {
                throw new Exception("Registration validation failed.");
            }

            if (!$this->recaptcha->recaptcha_check_answer()->is_valid)
            {
                throw new Exception("Captcha failed.");
            }

            $register_data = array_slice($this->input->post(NULL, TRUE), 0, 5);

            $authenticator = $this->session->flashdata('authenticator');
            $authenticator_id = $this->session->flashdata('authenticator_id');

            if ($authenticator && $authenticator_id)
            {
                $register_data[$authenticator] = $authenticator_id;
            }

            // if (!$this->check_email_exist($register_data['email']))
            // {
            //     throw new Exception("Email already exists");
            // }

            if (!$this->form_validation->run('date')) 
            {
                throw new Exception("Invalid date.");
            }
            else
            {
                $year = $this->input->post('year');
                $month = $this->input->post('month');
                $day = $this->input->post('day');

                if (!$this->form_validation->valid_birthdate($year, $month, $day))
                {
                    throw new Exception("Invalid birthdate.");    
                }
            }

            $register_data['password'] = $this->mycrypt($register_data['password']);
            $register_data['token'] = $this->mycrypt($register_data['username']);
            $register_data['date_registered'] = date("Y-m-d H:i:s", time());

            if ($this->account_model->register_user($register_data))
            {
                $this->send_email_confirmation($register_data['email'], $register_data['token']);
            }
            else
            {
                throw new Exception("Ohh snap! something went wrong. :(");
            }
        }
        catch (Exception $e)
        {
            // Keep the flashdata for failed registrations
            $this->session->keep_flashdata('authenticator');
            $this->session->keep_flashdata('authenticator_id');

            // Repopulate the form with submitted values
            $params['firstname'] = set_value('firstname');
            $params['lastname'] = set_value('lastname');
            $params['email'] = set_value('email');
            $params['username'] = set_value('username');
            $params['month'] = set_value('month');
            $params['day'] = set_value('day');
            $params['year'] = set_value('year');
            $params['error'] = $e->getMessage();

            // Get recaptcha error
            $this->recaptcha->error = $this->recaptcha->recaptcha_check_answer()->error;
        }

        return $params;
    }

    public function available_email($email = '')
    {
        $email = "bryan.estrito@gmail.com";

        if ($email == '')
        {
            return FALSE;
        }

        var_dump($this->check_email($email));
    }

    public function existing_email($email = '')
    {
        if ($email == '')
        {
            return FALSE;
        }

        var_dump($this->check_email($email));   
    }

    private function check_email($email = '')
    {
        try
        {
            if ($this->input->post('email'))
            {
                if ($this->form_validation->run('email'))
                {
                    $email = $this->input->post('email');
                }
                else
                {
                    throw new Exception("Email validation failed.");
                }
            }
            else
            {
                if ($email == '')
                {
                    throw new Exception("No email passed");
                }

                $rules = 'trim|required|valid_email|max_length[254]|xss_clean';
                
                if (!$this->form_validation->validate($email, 'Email Address', $rules))
                {
                    throw new Exception("Email validation failed.");
                }
            }

            if ($this->account_model->check_email($email))
            {
                return TRUE;
            }
            else
            {
                return FALSE; // Valid and available email
            }
        }
        catch (Exception $e)
        {
            return $e->getMessage(); // Email validation failed or already exist
        }
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
        if ($this->form_validation->validate($token, 'token', 'required|exact_length[40]|alpha_numeric'))
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
                $params['token_error'] = "Invalid token.";
            }
        }
        else
        {
            $params['token_error'] = var_error('token');
        }
        

        $data->content = $params;
        $data->layout = 'none';
        $data->page = 'account/verify_view';

        $this->load->view('template', $data);
    }

    public function resend_email_confirmation($email='')
    {
        if ($this->form_validation->run('email'))
        {
            $email = $this->input->post('email');

            $query_data = $this->account_model->get_username($email);

            if ($query_data)
            {
                $username = $query_data['username'];
                $date_validated = $query_data['date_verified'];
                $token_data['token'] = sha1($this->encrypt->encode($username));

                // Account hasn't been validated
                if (!$this->form_validation->valid_datetime($date_validated))
                {
                    if ($this->account_model->update_token($email, $token_data))
                    {
                        $this->send_email_confirmation($email, $token);

                        echo "resend sent";
                    }
                    else
                    {
                        throw new Exception("Fail resending", 1);
                    }    
                }
                else
                {
                    $params['email'] = set_value('email');
                    $params['email_error'] = "Account is already validated.";
                }
            }
            else
            {
                $params['email'] = set_value('email');       
                $params['email_error'] = "Email Address is not affiliated with Xcode";
            }
        }
        else
        {
            $params['email'] = set_value('email');
            $params['email_error'] = form_error('email');
        }

        $data['content'] = $params;
        $data['layout'] = 'none';
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

    private function mycrypt($key)
    {
        return md5(sha1($this->encrypt->encode($key)));
    }
}

/* End of file account.php */
/* Location: ./application/controllers/account.php */
