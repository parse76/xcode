<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|   example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|   http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|   $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|   $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = 'main';
$route['404_override'] = '';

// Main Routes (Static Pages)
$route['home'] = 'main/index';
$route['about'] = 'main/about';
$route['contact'] = 'main/contact';
$route['site_map'] = 'main/site_map';

// Account Routes
$route['login'] = 'account/user_login';
$route['register'] = 'account/register_user';
$route['logout'] = 'account/user_logout';
$route['facebook'] = 'account/facebook_login';
$route['twitter'] = 'account/twitter_login';
$route['google'] = 'account/google_plus_login';
$route['verify/(:any)'] = 'account/verify_token/$1';
$route['resend'] = 'account/resend_email_confirmation';
$route['available/(:any)'] =  'account/available_email/$1';
$route['existing/(:any)'] =  'account/existing_email/$1';

// Test Routes
$route['test/(:any)'] = 'test/$1';

$route['test'] = 'test';

// Profile route
$route['(:any)'] = 'user/index/$1';

/* End of file routes.php */
/* Location: ./application/config/routes.php */
