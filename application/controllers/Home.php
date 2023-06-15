<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Home extends CI_Controller {
        
    function __construct(){
        parent::__construct();
		$this->load->model('M_main', 'm_main');
		$this->load->model('M_auth', 'm_auth');
    }

	public function index(){
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

		if($this->session->userdata('email')){
			redirect('dashboard');
		}else {
			$this->load->view('home/login');
		}
	}

	public function login(){
		if($_POST['email']){
			$email = $_POST['email'];
			$password = $_POST['password'];
			$account = $this->m_main->getRow('db_account','email',$email);
			if($account){
				if($account['status'] == 1){
					if(password_verify($password, $account['password'])){
						$data = [
							'id_account' => $account['id_account'],
							'id_posisi' => $account['id_posisi'],
							'nama' => $account['nama'],
							'email' => $account['email'],
							'login' => true,
						];
						$this->session->sess_expiration = '86400';
						$this->session->set_userdata($data);

						$output['message'] = base_url();
						$output['result'] = $data;
					}else{
						$output['message'] = "Password salah, coba kembali!";
						$output['result'] = "error";
					}
				}else{
					$output['message'] = "Mohon maaf, akun anda sudah terhapus!";
					$output['result'] = "error";
				}
			}else{
				$output['message'] = "Akun anda tidak terdaftar!";
				$output['result'] = "error";
			}
	
			echo json_encode($output);
			exit();
		}else{
			redirect('home');
		}
	}

	public function logout(){
		$data = [
			'id_account',
			'id_posisi',
			'nama',
			'email',
			'login',
		];
		$this->session->unset_userdata($data);
		redirect('login');
	}
}