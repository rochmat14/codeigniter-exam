<?php
defined('BASEPATH') OR exit('No direct script access allowed');


// $route['url-nya'] = 'controller-nya'
$route['default_controller'] = 'user';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['register'] = 'user/register';
$route['login'] = 'user/login';
$route['forgot-password'] = 'user/forgotPassword';
$route['new-forgot-password'] = 'user/newPasswordForgot';
$route['home'] = 'user/home';
$route['user-view'] = 'user/userView';
$route['user-edit'] = 'user/userEdit';
$route['user-guide'] = 'user/userGuide';
$route['about'] = 'user/about';


// url
// 'user/register';
// 'user/dataUser';
// 'user/tampilUser';