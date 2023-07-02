<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Menu extends CI_Controller {
        
    function __construct(){
        parent::__construct();
		$this->load->model('M_main', 'm_main');
		$this->load->model('M_akses', 'm_akses');
		$this->load->model('M_auth', 'm_auth');
		define('U_VERSI', '01.01.05'); //Setiap edit program wajib di ganti untuk clear chace!
		define('EMAIL',$this->session->userdata('email'));
		define('ID_ACCOUNT',$this->session->userdata('id_account'));
		define('ID_POSISI',$this->session->userdata('id_posisi'));
		define('ID_OFFICE',$this->session->userdata('id_office'));
    }

	public function error_404(){
		header("Location:".base_url());
	}
	
	private function DataLevel(){
		$menu = $this->m_akses->GetLevelMenu();
		foreach ($menu as $list) {
			$data[$list->uri_menu] = $this->m_akses->cekMenu(ID_POSISI,$list->id_level_menu);
		}
		$submenu = $this->m_akses->GetLevelSubmenu();
		foreach ($submenu as $list) {
			$data[$list->uri_submenu] = $this->m_akses->cekSubmenu(ID_POSISI,$list->uri_submenu);
		}
		return $data;
	}
	
	public function dashboard(){
		if(EMAIL){
			$data['vrs'] = U_VERSI;
			$data['title'] = 'Dashboard';
			$data['account'] = $this->m_main->getRow('db_account','email',EMAIL);
			$data['cekmenu'] = $this->DataLevel();
			$this->load->view('layout/header', $data);
			$this->load->view('dashboard/dashboard_'.ID_POSISI);
			$this->load->view('layout/footer');
		}else{
			redirect('logout');
		}
	}
	
	public function account(){
		if(EMAIL){
			$data['vrs'] = U_VERSI; 
			$data['title'] = 'Account';
			$data['account'] = $this->m_main->getRow('db_account','email',EMAIL);
			$data['cekmenu'] = $this->DataLevel();
			$this->load->view('layout/header', $data);
			$this->load->view('developer/account');
			$this->load->view('layout/footer');
		}else{
			redirect('logout');
		}
    }

	public function anggota(){
		if(EMAIL){
			$data['vrs'] = U_VERSI; 
			$data['title'] = 'Anggota';
			$data['account'] = $this->m_main->getRow('db_account','email',EMAIL);
			$data['cekmenu'] = $this->DataLevel();
			$this->load->view('layout/header', $data);
			$this->load->view('anggota/anggota');
			$this->load->view('layout/footer');
		}else{
			redirect('logout');
		}
    }

	public function pembayaran(){
		if(EMAIL){
			$data['vrs'] = U_VERSI; 
			$data['title'] = 'Pembayaran';
			$data['account'] = $this->m_main->getRow('db_account','email',EMAIL);
			$data['cekmenu'] = $this->DataLevel();
			$this->load->view('layout/header', $data);
			$this->load->view('transaksi/pembayaran');
			$this->load->view('layout/footer');
		}else{
			redirect('logout');
		}
    }

	public function point_of_sale(){
		if(EMAIL){
			$data['vrs'] = U_VERSI; 
			$data['title'] = 'Point Of Sale';
			$data['account'] = $this->m_main->getRow('db_account','email',EMAIL);
			$data['cekmenu'] = $this->DataLevel();
			$this->load->view('layout/header', $data);
			$this->load->view('transaksi/point_of_sale');
			$this->load->view('layout/footer');
		}else{
			redirect('logout');
		}
    }

	public function produk(){
		if(EMAIL){
			$data['vrs'] = U_VERSI; 
			$data['title'] = 'Produk';
			$data['account'] = $this->m_main->getRow('db_account','email',EMAIL);
			$data['cekmenu'] = $this->DataLevel();
			$this->load->view('layout/header', $data);
			$this->load->view('pos/produk');
			$this->load->view('layout/footer');
		}else{
			redirect('logout');
		}
    }

	public function kategori_produk(){
		if(EMAIL){
			$data['vrs'] = U_VERSI; 
			$data['title'] = 'Kategori Produk';
			$data['account'] = $this->m_main->getRow('db_account','email',EMAIL);
			$data['cekmenu'] = $this->DataLevel();
			$this->load->view('layout/header', $data);
			$this->load->view('pos/kategori_produk');
			$this->load->view('layout/footer');
		}else{
			redirect('logout');
		}
    }

	public function stok_masuk(){
		if(EMAIL){
			$data['vrs'] = U_VERSI; 
			$data['title'] = 'Stok Masuk';
			$data['account'] = $this->m_main->getRow('db_account','email',EMAIL);
			$data['cekmenu'] = $this->DataLevel();
			$this->load->view('layout/header', $data);
			$this->load->view('pos/stok_masuk');
			$this->load->view('layout/footer');
		}else{
			redirect('logout');
		}
    }

	public function stok_keluar(){
		if(EMAIL){
			$data['vrs'] = U_VERSI; 
			$data['title'] = 'Stok Keluar';
			$data['account'] = $this->m_main->getRow('db_account','email',EMAIL);
			$data['cekmenu'] = $this->DataLevel();
			$this->load->view('layout/header', $data);
			$this->load->view('pos/stok_keluar');
			$this->load->view('layout/footer');
		}else{
			redirect('logout');
		}
    }

	public function stok_opname(){
		if(EMAIL){
			$data['vrs'] = U_VERSI; 
			$data['title'] = 'Stok Opname';
			$data['account'] = $this->m_main->getRow('db_account','email',EMAIL);
			$data['cekmenu'] = $this->DataLevel();
			$this->load->view('layout/header', $data);
			$this->load->view('pos/stok_opname');
			$this->load->view('layout/footer');
		}else{
			redirect('logout');
		}
    }

	public function paket_gym(){
		if(EMAIL){
			$data['vrs'] = U_VERSI; 
			$data['title'] = 'Paket Gym';
			$data['account'] = $this->m_main->getRow('db_account','email',EMAIL);
			$data['cekmenu'] = $this->DataLevel();
			$this->load->view('layout/header', $data);
			$this->load->view('master/paket_gym');
			$this->load->view('layout/footer');
		}else{
			redirect('logout');
		}
    }

	public function cabang_gym(){
		if(EMAIL){
			$data['vrs'] = U_VERSI; 
			$data['title'] = 'Cabang Gym';
			$data['account'] = $this->m_main->getRow('db_account','email',EMAIL);
			$data['cekmenu'] = $this->DataLevel();
			$this->load->view('layout/header', $data);
			$this->load->view('master/cabang_gym');
			$this->load->view('layout/footer');
		}else{
			redirect('logout');
		}
    }

	public function konfigurasi(){
		if(EMAIL){
			$data['vrs'] = U_VERSI; 
			$data['title'] = 'Konfigurasi';
			$data['account'] = $this->m_main->getRow('db_account','email',EMAIL);
			$data['cekmenu'] = $this->DataLevel();
			$this->load->view('layout/header', $data);
			$this->load->view('pengaturan/konfigurasi');
			$this->load->view('layout/footer');
		}else{
			redirect('logout');
		}
    }

	public function akun_saya(){
		if(EMAIL){
			$data['vrs'] = U_VERSI; 
			$data['title'] = 'Akun Saya';
			$data['account'] = $this->m_main->getRow('db_account','email',EMAIL);
			$data['cekmenu'] = $this->DataLevel();
			$this->load->view('layout/header', $data);
			$this->load->view('pengaturan/akun_saya');
			$this->load->view('layout/footer');
		}else{
			redirect('logout');
		}
    }
}