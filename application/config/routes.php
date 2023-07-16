<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';
$route['404_override'] = 'menu/error_404';
$route['translate_uri_dashes'] = FALSE;

$route['login'] = 'home/login';
$route['logout'] = 'home/logout';
$route['register'] = 'home/register';
$route['lupa-password'] = 'home/lupa_password';

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
$route['akun-saya'] = 'menu/akun_saya';
$route['konfigurasi'] = 'menu/konfigurasi';

$route['pendapatan-paket'] = 'menu/pendapatan_paket';
$route['rekap-total-paket'] = 'menu/rekap_total_paket';
$route['laporan-kasir-paket'] = 'menu/laporan_kasir_paket';
$route['rugi-laba-paket'] = 'menu/rugi_laba_paket';
$route['pendapatan-produk'] = 'menu/pendapatan_produk';
$route['rekap-total-produk'] = 'menu/rekap_total_produk';
$route['laporan-kasir-produk'] = 'menu/laporan_kasir_produk';
$route['rugi-laba-produk'] = 'menu/rugi_laba_produk';



$route['account'] = 'menu/account';