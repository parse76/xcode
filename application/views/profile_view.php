<?php 

// var_dump($user);

preprint($_SESSION);
print_r($_SESSION);

preprint($_COOKIE);
print_r($_COOKIE);

preprint($access_token);
print_r($access_token);

preprint($user);
print_r($user);
//session_destroy();

//echo anchor($this->facebook->getLogoutUrl(), 'Logout');

echo anchor('logout', 'Logout');

?>