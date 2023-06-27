<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';
$route['404_override'] = 'menu/error_404';
$route['translate_uri_dashes'] = FALSE;

$route['login'] = 'home/login';
$route['logout'] = 'home/logout';
$route['forgot'] = 'home/forgot';
$route['newpassword'] = 'home/newpassword';

$route['dashboard'] = 'menu/dashboard';

$route['users'] = 'menu/users';
$route['konfigurasi'] = 'menu/konfigurasi';