<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config = array(
    'login' => array(
        array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'trim|required|min_length[4]|max_length[32]|xss_clean'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required|min_length[4]|max_length[32]|xss_clean'
        )
    ),
    'register' => array(
        array(
            'field' => 'firstname',
            'label' => 'First Name',
            'rules' => 'trim|required|max_length[32]|xss_clean'
        ),
        array(
            'field' => 'lastname',
            'label' => 'Last Name',
            'rules' => 'trim|required|max_length[32]|xss_clean'
        ),
        array(
            'field' => 'email',
            'label' => 'Email Address',
            'rules' => 'trim|required|valid_email|max_length[254]|xss_clean'
        ),
        array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'trim|required|min_length[4]|max_length[32]|xss_clean'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required|min_length[4]|max_length[32]|xss_clean'
        ),
        array(
            'field' => 'password2',
            'label' => 'Password Confirmation',
            'rules' => 'trim|required|min_length[4]|max_length[32]|xss_clean|matches[password]'
        )
    )
);

/* End of file form_validation.php */
/* Location: ./application/config/form_validation.php */