<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config = array(
    'login' => array(
        array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'trim|required|xss_clean'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required|xss_clean'
        )
    ),
    'register' => array(
        array(
            'field' => 'firstname',
            'label' => 'First Name',
            'rules' => 'trim|required|alpha|max_length[35]|xss_clean'
        ),
        array(
            'field' => 'lastname',
            'label' => 'Last Name',
            'rules' => 'trim|required|alpha|max_length[35]|xss_clean'
        ),
        array(
            'field' => 'email',
            'label' => 'Email Address',
            'rules' => 'trim|required|valid_email|is_unique[users.username]|max_length[254]|xss_clean'
        ),
        array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'trim|required|is_unique[users.email]|min_length[4]|max_length[15]|xss_clean'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required|min_length[8]|xss_clean'
        ),
        array(
            'field' => 'password2',
            'label' => 'Password Confirmation',
            'rules' => 'trim|required|matches[password]|xss_clean'
        ),
        array(
            'field' => 'year',
            'label' => 'Year',
            'rules' => 'trim|required|numeric|xss_clean'
        ),
        array(
            'field' => 'month',
            'label' => 'Month',
            'rules' => 'trim|required|numeric|xss_clean'
        ),
        array(
            'field' => 'day',
            'label' => 'Day',
            'rules' => 'trim|required|numeric|xss_clean'
        ),
        array(
            'field' => 'gender',
            'label' => 'Gender',
            'rules' => 'trim|required|alpha|max_length[6]|min_length[4]|xss_clean'
        )
    ),
    'email' => array(
        array(
            'field' => 'email',
            'label' => 'Email Address',
            'rules' => 'trim|required|valid_email|is_unique[users.username]|max_length[254]|xss_clean'
        )
    ),
    'date' => array(
        array(
            'field' => 'year',
            'label' => 'Year',
            'rules' => 'trim|required|numeric|xss_clean'
        ),
        array(
            'field' => 'month',
            'label' => 'Month',
            'rules' => 'trim|required|numeric|xss_clean'
        ),
        array(
            'field' => 'day',
            'label' => 'Day',
            'rules' => 'trim|required|numeric|xss_clean'
        )
    ),
    'datetime' => array(
        array(
            'field' => 'year',
            'label' => 'Year',
            'rules' => 'trim|required|numeric|xss_clean'
        ),
        array(
            'field' => 'month',
            'label' => 'Month',
            'rules' => 'trim|required|numeric|xss_clean'
        ),
        array(
            'field' => 'day',
            'label' => 'Day',
            'rules' => 'trim|required|numeric|xss_clean'
        ),
        array(
            'field' => 'hour',
            'label' => 'Hour',
            'rules' => 'trim|required|numeric|xss_clean'
        ),
        array(
            'field' => 'minute',
            'label' => 'Minute',
            'rules' => 'trim|required|numeric|xss_clean'
        ),
        array(
            'field' => 'second',
            'label' => 'Second',
            'rules' => 'trim|required|numeric|xss_clean'
        )
    ),
    'birthdate' => array(
        array(
            'field' => 'month',
            'label' => 'Birthdate',
            'rules' => 'valid_birthdate'
        )
    )
);

/* End of file form_validation.php */
/* Location: ./application/config/form_validation.php */