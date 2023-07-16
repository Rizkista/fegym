<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Menu extends CI_Controller {
        
    function __construct(){
        parent::__construct();
		$this->load->model('M_main', 'm_main');
		$this->load->model('M_auth', 'm_auth');
		define('U_VERSI', '01.01.05'); //Setiap edit program wajib di ganti untuk clear chace!
		define('EMAIL',$this->session->userdata('email'));
		define('ID_ACCOUNT',$this->session->userdata('id_account'));
		define('ID_POSISI',$this->session->userdata('id_posisi'));
		define('ID_OFFICE',$this->session->userdata('id_office'));
		define('ID_LOKASI',$this->session->userdata('id_lokasi'));
    }

	public function error_404(){
		header("Location:".base_url());
	}
	
	public function dashboard(){
		if(EMAIL){
			$data['vrs'] = U_VERSI;
			$data['title'] = 'Dashboard';
			$data['account'] = $this->m_main->getRow('db_account','id_account',ID_ACCOUNT);
			$data['office'] = $this->m_main->getRow('db_office','id_office',ID_OFFICE);
			$data['lokasi'] = $this->m_main->getRow('db_lokasi','id_lokasi',ID_LOKASI);
			$data['data_lokasi'] = $this->m_main->getResultData('db_lokasi','status = 1 AND id_office = '.ID_OFFICE,'nama_lokasi asc');
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
			$data['account'] = $this->m_main->getRow('db_account','id_account',ID_ACCOUNT);
			$data['office'] = $this->m_main->getRow('db_office','id_office',ID_OFFICE);
			$data['lokasi'] = $this->m_main->getRow('db_lokasi','id_lokasi',ID_LOKASI);
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
			$data['account'] = $this->m_main->getRow('db_account','id_account',ID_ACCOUNT);
			$data['office'] = $this->m_main->getRow('db_office','id_office',ID_OFFICE);
			$data['lokasi'] = $this->m_main->getRow('db_lokasi','id_lokasi',ID_LOKASI);
			$data['data_lokasi'] = $this->m_main->getResultData('db_lokasi','status = 1 AND id_office = '.ID_OFFICE,'nama_lokasi asc');
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
			$data['account'] = $this->m_main->getRow('db_account','id_account',ID_ACCOUNT);
			$data['office'] = $this->m_main->getRow('db_office','id_office',ID_OFFICE);
			$data['lokasi'] = $this->m_main->getRow('db_lokasi','id_lokasi',ID_LOKASI);
			$data['data_lokasi'] = $this->m_main->getResultData('db_lokasi','status = 1 AND id_office = '.ID_OFFICE,'nama_lokasi asc');
			$data['data_payment'] = $this->m_main->getResultData('db_tipe_bayar','status = 1','id_tipe_bayar asc');
			$this->load->view('layout/header', $data);
			$this->load->view('transaksi/pembayaran');
			$this->load->view('layout/footer');
		}else{
			redirect('logout');
		}
    }

	public function penjualan(){
		if(EMAIL){
			$data['vrs'] = U_VERSI; 
			$data['title'] = 'Penjualan';
			$data['account'] = $this->m_main->getRow('db_account','id_account',ID_ACCOUNT);
			$data['office'] = $this->m_main->getRow('db_office','id_office',ID_OFFICE);
			$data['lokasi'] = $this->m_main->getRow('db_lokasi','id_lokasi',ID_LOKASI);
			$data['data_lokasi'] = $this->m_main->getResultData('db_lokasi','status = 1 AND id_office = '.ID_OFFICE,'nama_lokasi asc');
			$data['data_payment'] = $this->m_main->getResultData('db_tipe_bayar','status = 1','id_tipe_bayar asc');
			$this->load->view('layout/header', $data);
			$this->load->view('transaksi/penjualan');
			$this->load->view('layout/footer');
		}else{
			redirect('logout');
		}
    }

	public function produk(){
		if(EMAIL){
			$data['vrs'] = U_VERSI; 
			$data['title'] = 'Produk';
			$data['account'] = $this->m_main->getRow('db_account','id_account',ID_ACCOUNT);
			$data['office'] = $this->m_main->getRow('db_office','id_office',ID_OFFICE);
			$data['lokasi'] = $this->m_main->getRow('db_lokasi','id_lokasi',ID_LOKASI);
			$data['data_lokasi'] = $this->m_main->getResultData('db_lokasi','status = 1 AND id_office = '.ID_OFFICE,'nama_lokasi asc');
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
			$data['account'] = $this->m_main->getRow('db_account','id_account',ID_ACCOUNT);
			$data['office'] = $this->m_main->getRow('db_office','id_office',ID_OFFICE);
			$data['lokasi'] = $this->m_main->getRow('db_lokasi','id_lokasi',ID_LOKASI);
			$data['data_lokasi'] = $this->m_main->getResultData('db_lokasi','status = 1 AND id_office = '.ID_OFFICE,'nama_lokasi asc');
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
			$data['account'] = $this->m_main->getRow('db_account','id_account',ID_ACCOUNT);
			$data['office'] = $this->m_main->getRow('db_office','id_office',ID_OFFICE);
			$data['lokasi'] = $this->m_main->getRow('db_lokasi','id_lokasi',ID_LOKASI);
			$data['data_lokasi'] = $this->m_main->getResultData('db_lokasi','status = 1 AND id_office = '.ID_OFFICE,'nama_lokasi asc');
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
			$data['account'] = $this->m_main->getRow('db_account','id_account',ID_ACCOUNT);
			$data['office'] = $this->m_main->getRow('db_office','id_office',ID_OFFICE);
			$data['lokasi'] = $this->m_main->getRow('db_lokasi','id_lokasi',ID_LOKASI);
			$data['data_lokasi'] = $this->m_main->getResultData('db_lokasi','status = 1 AND id_office = '.ID_OFFICE,'nama_lokasi asc');
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
			$data['account'] = $this->m_main->getRow('db_account','id_account',ID_ACCOUNT);
			$data['office'] = $this->m_main->getRow('db_office','id_office',ID_OFFICE);
			$data['lokasi'] = $this->m_main->getRow('db_lokasi','id_lokasi',ID_LOKASI);
			$data['data_lokasi'] = $this->m_main->getResultData('db_lokasi','status = 1 AND id_office = '.ID_OFFICE,'nama_lokasi asc');
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
			$data['account'] = $this->m_main->getRow('db_account','id_account',ID_ACCOUNT);
			$data['office'] = $this->m_main->getRow('db_office','id_office',ID_OFFICE);
			$data['lokasi'] = $this->m_main->getRow('db_lokasi','id_lokasi',ID_LOKASI);
			$data['data_lokasi'] = $this->m_main->getResultData('db_lokasi','status = 1 AND id_office = '.ID_OFFICE,'nama_lokasi asc');
			$this->load->view('layout/header', $data);
			$this->load->view('master/paket_gym');
			$this->load->view('layout/footer');
		}else{
			redirect('logout');
		}
    }

	public function lokasi_gym(){
		if(EMAIL){
			$data['vrs'] = U_VERSI; 
			$data['title'] = 'Lokasi Gym';
			$data['account'] = $this->m_main->getRow('db_account','id_account',ID_ACCOUNT);
			$data['office'] = $this->m_main->getRow('db_office','id_office',ID_OFFICE);
			$data['lokasi'] = $this->m_main->getRow('db_lokasi','id_lokasi',ID_LOKASI);
			$this->load->view('layout/header', $data);
			$this->load->view('master/lokasi_gym');
			$this->load->view('layout/footer');
		}else{
			redirect('logout');
		}
    }

	public function akun_saya(){
		if(EMAIL){
			$data['vrs'] = U_VERSI; 
			$data['title'] = 'Akun Saya';
			$data['account'] = $this->m_main->getRow('db_account','id_account',ID_ACCOUNT);
			$data['office'] = $this->m_main->getRow('db_office','id_office',ID_OFFICE);
			$data['lokasi'] = $this->m_main->getRow('db_lokasi','id_lokasi',ID_LOKASI);
			$data['office'] = $this->m_main->getRow('db_office','id_office',ID_OFFICE);
			$data['lokasi'] = $this->m_main->getRow('db_lokasi','id_lokasi',ID_LOKASI);
			$this->load->view('layout/header', $data);
			$this->load->view('pengaturan/akun_saya');
			$this->load->view('layout/footer');
		}else{
			redirect('logout');
		}
    }

	public function konfigurasi(){
		if(EMAIL){
			$data['vrs'] = U_VERSI; 
			$data['title'] = 'Konfigurasi';
			$data['account'] = $this->m_main->getRow('db_account','id_account',ID_ACCOUNT);
			$data['office'] = $this->m_main->getRow('db_office','id_office',ID_OFFICE);
			$data['lokasi'] = $this->m_main->getRow('db_lokasi','id_lokasi',ID_LOKASI);
			$data['office'] = $this->m_main->getRow('db_office','id_office',ID_OFFICE);
			$data['lokasi'] = $this->m_main->getRow('db_lokasi','id_lokasi',ID_LOKASI);
			$data['account_online'] = $this->m_auth->getAccountOnline(ID_OFFICE);
			$this->load->view('layout/header', $data);
			$this->load->view('pengaturan/konfigurasi');
			$this->load->view('layout/footer');
		}else{
			redirect('logout');
		}
    }

	public function pembayaran_paket(){
		if(EMAIL){
			$data['vrs'] = U_VERSI; 
			$data['title'] = 'Pembayaran Paket';
			$data['account'] = $this->m_main->getRow('db_account','id_account',ID_ACCOUNT);
			$data['office'] = $this->m_main->getRow('db_office','id_office',ID_OFFICE);
			$data['lokasi'] = $this->m_main->getRow('db_lokasi','id_lokasi',ID_LOKASI);
			$data['data_lokasi'] = $this->m_main->getResultData('db_lokasi','status = 1 AND id_office = '.ID_OFFICE,'nama_lokasi asc');
			$this->load->view('layout/header', $data);
			$this->load->view('laporan/pembayaran/pembayaran_paket');
			$this->load->view('layout/footer');
		}else{
			redirect('logout');
		}
	}

	public function rekap_total_paket(){
		if(EMAIL){
			$data['vrs'] = U_VERSI; 
			$data['title'] = 'Rekap Total Paket';
			$data['account'] = $this->m_main->getRow('db_account','id_account',ID_ACCOUNT);
			$data['office'] = $this->m_main->getRow('db_office','id_office',ID_OFFICE);
			$data['lokasi'] = $this->m_main->getRow('db_lokasi','id_lokasi',ID_LOKASI);
			$data['data_lokasi'] = $this->m_main->getResultData('db_lokasi','status = 1 AND id_office = '.ID_OFFICE,'nama_lokasi asc');
			$this->load->view('layout/header', $data);
			$this->load->view('laporan/pembayaran/rekap_total_paket');
			$this->load->view('layout/footer');
		}else{
			redirect('logout');
		}
	}

	public function laporan_kasir_paket(){
		if(EMAIL){
			$data['vrs'] = U_VERSI; 
			$data['title'] = 'Laporan Kasir Paket';
			$data['account'] = $this->m_main->getRow('db_account','id_account',ID_ACCOUNT);
			$data['office'] = $this->m_main->getRow('db_office','id_office',ID_OFFICE);
			$data['lokasi'] = $this->m_main->getRow('db_lokasi','id_lokasi',ID_LOKASI);
			$data['data_lokasi'] = $this->m_main->getResultData('db_lokasi','status = 1 AND id_office = '.ID_OFFICE,'nama_lokasi asc');
			$this->load->view('layout/header', $data);
			$this->load->view('laporan/pembayaran/laporan_kasir_paket');
			$this->load->view('layout/footer');
		}else{
			redirect('logout');
		}
	}

	public function rugi_laba_paket(){
		if(EMAIL){
			$data['vrs'] = U_VERSI; 
			$data['title'] = 'Rugi Laba Paket';
			$data['account'] = $this->m_main->getRow('db_account','id_account',ID_ACCOUNT);
			$data['office'] = $this->m_main->getRow('db_office','id_office',ID_OFFICE);
			$data['lokasi'] = $this->m_main->getRow('db_lokasi','id_lokasi',ID_LOKASI);
			$data['data_lokasi'] = $this->m_main->getResultData('db_lokasi','status = 1 AND id_office = '.ID_OFFICE,'nama_lokasi asc');
			$this->load->view('layout/header', $data);
			$this->load->view('laporan/pembayaran/rugi_laba_paket');
			$this->load->view('layout/footer');
		}else{
			redirect('logout');
		}
	}
	
	public function penjualan_produk(){
		if(EMAIL){
			$data['vrs'] = U_VERSI; 
			$data['title'] = 'Penjualan Produk';
			$data['account'] = $this->m_main->getRow('db_account','id_account',ID_ACCOUNT);
			$data['office'] = $this->m_main->getRow('db_office','id_office',ID_OFFICE);
			$data['lokasi'] = $this->m_main->getRow('db_lokasi','id_lokasi',ID_LOKASI);
			$data['data_lokasi'] = $this->m_main->getResultData('db_lokasi','status = 1 AND id_office = '.ID_OFFICE,'nama_lokasi asc');
			$this->load->view('layout/header', $data);
			$this->load->view('laporan/penjualan/penjualan_produk');
			$this->load->view('layout/footer');
		}else{
			redirect('logout');
		}
	}

	public function rekap_total_produk(){
		if(EMAIL){
			$data['vrs'] = U_VERSI; 
			$data['title'] = 'Rekap Total Produk';
			$data['account'] = $this->m_main->getRow('db_account','id_account',ID_ACCOUNT);
			$data['office'] = $this->m_main->getRow('db_office','id_office',ID_OFFICE);
			$data['lokasi'] = $this->m_main->getRow('db_lokasi','id_lokasi',ID_LOKASI);
			$data['data_lokasi'] = $this->m_main->getResultData('db_lokasi','status = 1 AND id_office = '.ID_OFFICE,'nama_lokasi asc');
			$this->load->view('layout/header', $data);
			$this->load->view('laporan/penjualan/rekap_total_produk');
			$this->load->view('layout/footer');
		}else{
			redirect('logout');
		}
	}

	public function laporan_kasir_produk(){
		if(EMAIL){
			$data['vrs'] = U_VERSI; 
			$data['title'] = 'Laporan Kasir Produk';
			$data['account'] = $this->m_main->getRow('db_account','id_account',ID_ACCOUNT);
			$data['office'] = $this->m_main->getRow('db_office','id_office',ID_OFFICE);
			$data['lokasi'] = $this->m_main->getRow('db_lokasi','id_lokasi',ID_LOKASI);
			$data['data_lokasi'] = $this->m_main->getResultData('db_lokasi','status = 1 AND id_office = '.ID_OFFICE,'nama_lokasi asc');
			$this->load->view('layout/header', $data);
			$this->load->view('laporan/penjualan/laporan_kasir_produk');
			$this->load->view('layout/footer');
		}else{
			redirect('logout');
		}
	}

	public function rugi_laba_produk(){
		if(EMAIL){
			$data['vrs'] = U_VERSI; 
			$data['title'] = 'Rugi Laba Produk';
			$data['account'] = $this->m_main->getRow('db_account','id_account',ID_ACCOUNT);
			$data['office'] = $this->m_main->getRow('db_office','id_office',ID_OFFICE);
			$data['lokasi'] = $this->m_main->getRow('db_lokasi','id_lokasi',ID_LOKASI);
			$data['data_lokasi'] = $this->m_main->getResultData('db_lokasi','status = 1 AND id_office = '.ID_OFFICE,'nama_lokasi asc');
			$this->load->view('layout/header', $data);
			$this->load->view('laporan/penjualan/rugi_laba_produk');
			$this->load->view('layout/footer');
		}else{
			redirect('logout');
		}
	}
}