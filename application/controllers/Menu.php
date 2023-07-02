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

	public function profil(){
		if(EMAIL){
			$data['vrs'] = U_VERSI; 
			$data['title'] = 'Profil Saya';
			$data['account'] = $this->m_main->getRow('db_account','email',EMAIL);
			$data['account_cabang'] = $this->m_main->getRow('db_cabang','id_cabang',$data['account']['id_cabang']);
			$data['cekmenu'] = $this->DataLevel();
			$this->load->view('layout/header', $data);
			$this->load->view('personal/profil');
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
			$this->load->view('users/anggota');
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
}