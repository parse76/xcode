<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "recaptcha/base_recaptcha.php";

/**
* Modified for Codeigniter compatibility
* Author: Bryan Estrito
*/
class Recaptcha extends BaseRecaptcha
{
    // For recatcha_get_html method
    protected $pubkey;
    
    public $error = null;
    public $use_ssl = null;

    // For recaptcha_check_answer method
    protected $privkey;
    
    public $remoteip;
    public $challenge;
    public $response;
    public $extra_params = array();


    public function __construct($config='')
    {
        if (!$config) { // Fetch config from app_keys.php if parameter is null
            $this->ci =& get_instance();
            $this->ci->config->load('app_keys', TRUE);
            $config = $this->ci->config->item('recaptcha', 'app_keys'); 
        }

        $this->server_data();
        $this->post_data();

        $this->pubkey = $config['pubkey'];
        $this->privkey = $config['privkey'];
    }

    public function server_data()
    {
        $this->remoteip = $_SERVER["REMOTE_ADDR"];
    }

    public function post_data()
    {
        if (!isset($_POST["recaptcha_challenge_field"]) || !isset($_POST["recaptcha_response_field"])) {
            $this->challenge = '';
            $this->response = '';
        } else {
            $this->challenge = $_POST["recaptcha_challenge_field"];
            $this->response = $_POST["recaptcha_response_field"];
        }
    }

    /**
     * Gets the challenge HTML (javascript and non-javascript version).
     * This is called from the browser, and the resulting reCAPTCHA HTML widget
     * is embedded within the HTML form it was called from.
     * @return string - The HTML to be embedded in the user's form.
     */
    public function recaptcha_get_html ()
    {
        if ($this->pubkey == null || $this->pubkey == '') {
            die ("To use reCAPTCHA you must get an API key from <a href='https://www.google.com/recaptcha/admin/create'>https://www.google.com/recaptcha/admin/create</a>");
        }
        
        if ($this->use_ssl) {
                    $server = RECAPTCHA_API_SECURE_SERVER;
            } else {
                    $server = RECAPTCHA_API_SERVER;
            }

            $errorpart = "";
            if ($this->error) {
               $errorpart = "&amp;error=" . $this->error;
            }
            return '<script type="text/javascript" src="'. $server . '/challenge?k=' . $this->pubkey . $errorpart . '"></script>

        <noscript>
            <iframe src="'. $server . '/noscript?k=' . $this->pubkey . $errorpart . '" height="300" width="500" frameborder="0"></iframe><br/>
            <textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
            <input type="hidden" name="recaptcha_response_field" value="manual_challenge"/>
        </noscript>';
    }

    /**
      * Calls an HTTP POST function to verify if the user's guess was correct
      * @return ReCaptchaResponse
      */
    public function recaptcha_check_answer ()
    {
        if ($this->privkey == null || $this->privkey == '') {
            die ("To use reCAPTCHA you must get an API key from <a href='https://www.google.com/recaptcha/admin/create'>https://www.google.com/recaptcha/admin/create</a>");
        }

        if ($this->remoteip == null || $this->remoteip == '') {
            die ("For security reasons, you must pass the remote ip to reCAPTCHA");
        }

        
        
            //discard spam submissions
            if ($this->challenge == null || strlen($this->challenge) == 0 || $this->response == null || strlen($this->response) == 0) {
                    $recaptcha_response = new ReCaptchaResponse();
                    $recaptcha_response->is_valid = false;
                    $recaptcha_response->error = 'incorrect-captcha-sol';
                    return $recaptcha_response;
            }

            $this->response = $this->_recaptcha_http_post (RECAPTCHA_VERIFY_SERVER, "/recaptcha/api/verify",
                                              array (
                                                     'privatekey' => $this->privkey,
                                                     'remoteip' => $this->remoteip,
                                                     'challenge' => $this->challenge,
                                                     'response' => $this->response
                                                     ) + $this->extra_params
                                              );

            $answers = explode ("\n", $this->response [1]);
            $recaptcha_response = new ReCaptchaResponse();

            if (trim ($answers [0]) == 'true') {
                    $recaptcha_response->is_valid = true;
            }
            else {
                    $recaptcha_response->is_valid = false;
                    $recaptcha_response->error = $answers [1];
            }
            return $recaptcha_response;

    }
}