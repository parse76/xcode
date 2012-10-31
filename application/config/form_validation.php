<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config = array(
    'signup' => array(
        array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'required'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required'
        )
    ),
    'email' => array(
        array(
            'field' => 'emailaddress',
            'label' => 'EmailAddress',
            'rules' => 'required|valid_email'
        ),
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'required|alpha'
        )
    ),
    'newsletter' => array(
        array(
            'field' => 'email',
            'label' => 'Email Address',
            'rules' => 'trim|required|valid_email'
        )
    )                          
);