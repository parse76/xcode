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
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = 'pages';
$route['404_override'] = 'pages/page_missing';

// Pages routes
$route['home'] = 'pages/index';
$route['site_map'] = 'pages/site_map';
$route['about_us'] = 'pages/about_us';
$route['contact_us'] = 'pages/contact_us';
$route['404'] = 'pages/page_missing';

// Account routes
$route['login'] = 'account/login';
$route['logout'] = 'account/logout';
$route['register'] = 'account/register';
$route['settings'] = 'account/settings';
$route['account/debugger'] = 'account/debugger';
// $route['account/(:any)'] = 'account/$1';
// $route['account'] = 'pages/page_missing';
// $route['account/(:any)'] = 'pages/page_missing';

// Dynamic routes
$route['(:any)'] = 'customer/profile/$1';


/* End of file routes.php */
/* Location: ./application/config/routes.php */
