<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test_library
{
    public function __construct($config='')
    {
        // $this->CI =& get_instance();

        // if (!$config) {
        //  $this->CI->config->load('third_party_login', TRUE);
        //  $config = $this->CI->config->item('facebook', 'third_party_login'); 
        // }

        // return $config;
    }

    public function sample($config='')
    {
        if (!$config) {
            $this->CI =& get_instance();
            $this->CI->config->load('third_party_login', TRUE);
            $config = $this->CI->config->item('facebook', 'third_party_login'); 
        }

        return $config;
    }
}

/* End of file test_library.php */
/* Location: ./application/libraries/test_library.php */