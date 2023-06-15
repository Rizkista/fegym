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
    }

	public function error_404(){
		header("Location:".base_url());
	}
	
	public function dashboard(){
		if(EMAIL){
			$data['vrs'] = U_VERSI;
			$data['title'] = 'Dashboard';
			$data['account'] = $this->m_main->getRow('db_account','email',EMAIL);
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

}