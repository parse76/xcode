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
                $this->validate_register();
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

    private function validate_register()
    {
        $params = array();

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

        if ($this->form_validation->run('register') === false) {
            $data['page'] = 'page/register_view';

            // Reload captcha
            $params['recaptcha'] = $this->recaptcha->recaptcha_get_html();
            
            // Re-populate the form with submitted values
            $params['firstname'] = set_value('firstname');
            $params['lastname'] = set_value('lastname');
            $params['email'] = set_value('email');
            $params['username'] = set_value('username');

            // Set error messages
            $params['firstname_error'] = form_error('firstname');
            $params['lastname_error'] = form_error('lastname');
            $params['email_error'] = form_error('email');
            $params['username_error'] = form_error('username');
            $params['password_error'] = form_error('password');
            $params['password2_error'] = form_error('password2');
            $params['gender_error'] = form_error('gender');
        }

        if (!$response->is_valid) {
            $this->recaptcha->error = $response->error;

            $params['recaptcha'] = $this->recaptcha->recaptcha_get_html();
        }

        $data['data'] = $params;

        $this->load->view('template', $data);
    }

    private function default_login()
    {
        if (!$this->input->post()) {
            redirect('home');
        }

        if ($this->form_validation->run('login') === false) {
            $data['page'] = 'page/login_view';
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
        session_start();
        // echo 'TODO: Twitter Login';
        // unset($_SESSION['access_token']);
        unset($_SESSION['access_token']);
    }

    private function google_login()
    {
        $this->load->library('google');

        if (isset($_GET['code'])) {
            $this->google->authenticate($_GET['code']);
            $_SESSION['access_token'] = $this->google->getAccessToken();
            // header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
        }

        if (isset($_SESSION['access_token'])) {
            $this->google->setAccessToken($_SESSION['access_token']);
        }

        if ($this->google->getAccessToken()) {
            $plus_response = $this->google->plus->people->get('me');
            $oauth2_response = $this->google->oauth2->userinfo->get();

            // // These fields are currently filtered through the PHP sanitize filters.
            // // See http://www.php.net/manual/en/filter.filters.sanitize.php
            // $url = filter_var($user['url'], FILTER_VALIDATE_URL);
            // $img = filter_var($user['image']['url'], FILTER_VALIDATE_URL);
            // $name = filter_var($user['displayName'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
            // $personMarkup = "<a rel='me' href='$url'>$name</a><div><img src='$img'></div>";

            // $optParams = array('maxResults' => 100);
            // $activities = $this->google->plus->activities->listActivities('me', 'public', $optParams);
            // $activityMarkup = '';
            
            // foreach($activities['items'] as $activity) {
            //     // These fields are currently filtered through the PHP sanitize filters.
            //     // See http://www.php.net/manual/en/filter.filters.sanitize.php
            //     $url = filter_var($activity['url'], FILTER_VALIDATE_URL);
            //     $title = filter_var($activity['title'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
            //     $content = filter_var($activity['object']['content'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
            //     $activityMarkup .= "<div class='activity'><a href='$url'>$title</a><div>$content</div></div>";
            // }

            // The access token may have been updated lazily.
            // $_SESSION['access_token'] = $this->google->getAccessToken();

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
                $_POST['firstname'] = $oauth2_response['given_name'];
                $_POST['lastname'] = $oauth2_response['family_name'];
                $_POST['email'] = $oauth2_response['email'];
                $_POST['gender'] = $oauth2_response['gender'];

                if ($this->form_validation->run('register') === false) {
                    $data['page'] = 'pages/register';
                    $this->load->view('template', $data);
                }
            // }

            

            var_dump($plus_response);
            foreach ($plus_response as $key => $value) {
                echo $key.' => '.$value.'<br>';
            }
            echo '<hr>';
            var_dump($oauth2_response);
            foreach ($oauth2_response as $key => $value) {
                echo $key.' => '.$value.'<br>';
            }
            // print_r($_SESSION);
            // print_r($_GET);
        } else {
            // $authUrl = $this->google->createAuthUrl();
            $authUrl = $this->google->createAuthUrl();
            redirect($authUrl);
        }
    }
}

/* End of file validate.php */
/* Location: ./application/controllers/validate.php */
