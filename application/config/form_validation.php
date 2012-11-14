<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config = array(
    'login' => array(
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'required|trim|min_length[4]'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required|trim|min_length[4]'
        )
    )                       
);

/* End of file form_validation.php */
/* Location: ./application/config/form_validation.php */