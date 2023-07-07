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
$route['anggota'] = 'menu/anggota';
$route['pembayaran'] = 'menu/pembayaran';
$route['penjualan'] = 'menu/penjualan';
$route['produk'] = 'menu/produk';
$route['kategori-produk'] = 'menu/kategori_produk';
$route['stok-masuk'] = 'menu/stok_masuk';
$route['stok-keluar'] = 'menu/stok_keluar';
$route['stok-opname'] = 'menu/stok_opname';
$route['paket-gym'] = 'menu/paket_gym';
$route['lokasi-gym'] = 'menu/lokasi_gym';
$route['laporan-pembayaran-gym'] = 'menu/laporan_pembayaran_gym';
$route['laporan-penjualan-produk'] = 'menu/laporan_penjualan_produk';
$route['akun-saya'] = 'menu/akun_saya';


$route['account'] = 'menu/account';