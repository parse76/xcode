<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config = array(
    'login' => array(
        array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'required|trim|min_length[4]'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required|trim|min_length[4]'
        )
    ),
    'registration' => array(
        array(
            'field' => 'first_name',
            'label' => 'First Name',
            'rules' => 'required|trim|max_length[32]|xss_clean'
        ),
        array(
            'field' => 'last_name',
            'label' => 'Last Name',
            'rules' => 'required|trim|max_length[32]|xss_clean'
        ),
        array(
            'field' => 'email',
            'label' => 'Email Address',
            'rules' => 'required|trim|max_length[32]|xss_clean'
        ),
        array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'required|trim|max_length[32]|xss_clean'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required|trim|max_length[32]|xss_clean'
        )
    )
);

/* End of file form_validation.php */
/* Location: ./application/config/form_validation.php */