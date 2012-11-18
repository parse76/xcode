<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Validate extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //Load Dependencies

        //instantiate the Facebook library with the APP ID and APP SECRET
        // $config = array(
        //  'appId' => '277835292335638',
        //  'secret' => 'd3368aba56f8af88697b24b3fea344c0',
        //  'cookie' => true
        // );

        // loads the facebook library
        // $this->load->library('facebook', $config);
    }

    public function _remap($value='index') // CI's default method when a controller is called
    {
        // if (method_exists($this, $value)) {
        //  // Something here..
        // }

        // Data sanitize

        switch ($value) {
            case 'register':
                $this->validate_registration();
                break;

            case 'login':
                $this->default_login();
                break;

            case 'facebook':
                $this->facebook_login();
                break;

            case 'twitter':
                $this->twitter_login();
                break;

            case 'google':
                $this->google_login();
                break;
            
            default:
                redirect('404');
                break;
        }
    }

    private function validate_registration()
    {
        $this->load->library('recaptcha');

        // $routes = $this->router->routes;

        // // Avoiding username conflicts to routes
        // foreach ($routes as $key => $value) {
        //  if ($username == $key) {
        //      echo 'Unauthorized username!';
        //  }
        // }

        // if ($preg_match_condition) {
        //  echo 'Invalid username!';
        // }

        // if ($match == true) {
        //  echo 'Username already taken';
        // }

        $response = $this->recaptcha->recaptcha_check_answer();

        if (!$response->is_valid) {
            $this->recaptcha->error = $response->error;
            echo $this->recaptcha->recaptcha_get_html();

            // echo "The reCAPTCHA wasn't entered correctly. Go back and try it again." . "(reCAPTCHA said: " . $response->error . ")";
        } else {
            echo 'Good nagawa mo rin pogi!';
        }
    }

    private function default_login()
    {
        if (!$this->input->post()) {
            redirect('home');
        }

        if ($this->form_validation->run('login') === false) {
            $data['page'] = 'pages/login_view';
            $this->load->view('template', $data);
        } else {
            $user_info = array(
                'username'  => $this->input->post('username'),
                'authenticator' => 'default',
                'logged_in' => true
            );

            $this->session->set_userdata($user_info);

            redirect('home');
        }
    }

    private function facebook_login()
    {
        $this->load->library('facebook');

        //Get the FB UID of the currently logged in user
        $user = $this->facebook->getUser();

        //if the user has already allowed the application, you'll be able to get his/her FB UID
        if($user) {
            //start the session if needed
            if( session_id() ) {
                
            } else {
                session_start();
            }
            
            //do stuff when already logged in
            
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
            $permissions_needed = array('publish_stream');
            foreach($permissions_needed as $perm) {
                if( !isset($permissions_list['data'][0][$perm]) || $permissions_list['data'][0][$perm] != 1 ) {
                    $login_url_params = array(
                        'scope' => 'publish_stream',
                        'fbconnect' =>  1,
                        'display'   =>  "page",
                        'next' => 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']
                    );
                    $login_url = $this->facebook->getLoginUrl($login_url_params);
                    header("Location: {$login_url}");
                    exit();
                }
            }
            
            //save the information inside the session
            $_SESSION['access_token'] = $access_token;
            
            //redirect to manage.php
            //header('Location: manage.php');
            redirect('home/profile');
        } else {
            //if not, let's redirect to the ALLOW page so we can get access
            //Create a login URL using the Facebook library's getLoginUrl() method
            $login_url_params = array(
                'scope' => 'publish_stream',
                'fbconnect' =>  1,
                'display'   =>  "page",
                'next' => 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']
            );
            $login_url = $this->facebook->getLoginUrl($login_url_params);
            
            //redirect to the login URL on facebook
            header("Location: {$login_url}");
            exit();
        }
    }

    private function twitter_login()
    {
        echo 'TODO: Twitter Login';
    }

    private function google_login()
    {
        echo 'TODO: Google+ Login';
    }
}

/* End of file validate.php */
/* Location: ./application/controllers/validate.php */
