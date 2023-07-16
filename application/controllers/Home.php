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
		$this->load->view('home/beranda');
	}
	
	public function login(){
		if($this->session->userdata('email')){
			redirect('dashboard');
		}else {
			$this->load->view('home/login');
		}
	}
	
	public function register(){
		$this->load->view('home/register');
	}
	
	public function lupa_password(){
		$this->load->view('home/lupa_password');
	}

	public function logout(){
		if($this->session->userdata('id_account')){
			$this->m_main->updateIN('db_account','id_account',$this->session->userdata('id_account'),['tgl_logout' => date("Y-m-d H:i:s")]);
		}
		$data = [
			'id_account',
			'id_posisi',
			'id_office',
			'id_lokasi',
			'nama',
			'email',
			'login',
		];
		$this->session->unset_userdata($data);
		redirect('login');
	}

	public function aksi_login(){
		if($_POST['email']){
			$email = $_POST['email'];
			$password = $_POST['password'];
			$account = $this->m_main->getRow('db_account','email',$email);
			if($account){
				if($account['status'] == 1){
					if(password_verify($password, $account['password'])){
						$this->m_main->updateIN('db_account','id_account',$account['id_account'],['tgl_login' => date("Y-m-d H:i:s")]);
						$lokasi = $this->m_main->getRow('db_lokasi','id_account',$account['id_account']);
						$data = [
							'id_account' => $account['id_account'],
							'id_posisi' => $account['id_posisi'],
							'id_office' => $account['id_office'],
							'id_lokasi' => $lokasi ? $lokasi['id_lokasi'] : null,
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

	public function aksi_register(){
		$email_owner = $this->m_main->getRow('db_account','email',$_POST['email']);
		$telp_owner = $this->m_main->getRow('db_account','telp',$_POST['telp']);
		$email_admin = $this->m_main->getRow('db_account','email',$_POST['email_admin']);
		$email_office = $this->m_main->getRow('db_office','email_office',$_POST['email_office']);
		$telp_office = $this->m_main->getRow('db_office','telp_office',$_POST['telp_office']);
		if(!$email_owner){
			if(!$telp_owner){
				if(!$email_office){
					if(!$telp_office){
						if(!$email_admin){
							$office = [
								'id_kategori' => 3,
								'kode_office' => strtoupper(substr($_POST['nama_office'], 0, 3)),
								'nama_office' => $_POST['nama_office'],
								'email_office' => $_POST['email_office'],
								'telp_office' => $_POST['telp_office'],
								'alamat_office' => $_POST['alamat_office'],
								'tgl_expired' => date("Y-m-d", strtotime("+1 month")),
								'tgl_input' => date("Y-m-d H:i:s"),
								'tgl_edit' => date("Y-m-d H:i:s"),
								'status' => 1,
							];
							$id_office = $this->m_main->createIN('db_office',$office)['result'];
							$owner = [
								'id_posisi' => 2,
								'id_office' => $id_office,
								'nama' => $_POST['nama'],
								'email' => $_POST['email'],
								'telp' => $_POST['telp'],
								'alamat' => $_POST['alamat'],
								'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
								'tgl_input' => date("Y-m-d H:i:s"),
								'tgl_edit' => date("Y-m-d H:i:s"),
								'tgl_login' => date("Y-m-d H:i:s"),
								'tgl_logout' => date("Y-m-d H:i:s"),
								'status' => 1,
							];
							$id_owner = $this->m_main->createIN('db_account',$owner)['result'];
							$admin = [
								'id_posisi' => 3,
								'id_office' => $id_office,
								'nama' => $_POST['nama_admin'],
								'email' => $_POST['email_admin'],
								'password' => password_hash($_POST['password_admin'], PASSWORD_DEFAULT),
								'pass_view' => $_POST['password_admin'],
								'tgl_input' => date("Y-m-d H:i:s"),
								'tgl_edit' => date("Y-m-d H:i:s"),
								'tgl_login' => date("Y-m-d H:i:s"),
								'tgl_logout' => date("Y-m-d H:i:s"),
								'status' => 1,
							];
							$id_admin = $this->m_main->createIN('db_account',$admin)['result'];
							$lokasi = [
								'id_office' => $id_office,
								'id_account' => $id_admin,
								'kode_lokasi' => $_POST['kode_lokasi'],
								'nama_lokasi' => $_POST['nama_lokasi'],
								'alamat_lokasi' => $_POST['alamat_lokasi'],
								'tgl_input' => date("Y-m-d H:i:s"),
								'tgl_edit' => date("Y-m-d H:i:s"),
								'status' => 1,
							];
							$id_lokasi = $this->m_main->createIN('db_lokasi',$lokasi)['result'];
							if($id_office && $id_owner && $id_admin && $id_lokasi){
								$data = [
									'id_account' => $id_owner,
									'id_posisi' => 2,
									'id_office' => $id_office,
									'id_lokasi' => null,
									'nama' => $_POST['nama'],
									'email' => $_POST['email'],
									'login' => true,
								];
								$this->session->sess_expiration = '86400';
								$this->session->set_userdata($data);
					
								$output['message'] = base_url();
								$output['result'] = $data;
							}else{
								$output['message'] = "Terjadi kesalahan harap hubungi pengembang!";
								$output['result'] = "error";
							}
						}else{
							$output['message'] = "Email admin sudah digunakan, coba lagi dengan yang lain!";
							$output['result'] = "error";
						}
					}else{
						$output['message'] = "No Hp perusahaan sudah digunakan, coba lagi dengan yang lain!";
						$output['result'] = "error";
					}
				}else{
					$output['message'] = "Email perusahaan sudah digunakan, coba lagi dengan yang lain!";
					$output['result'] = "error";
				}
			}else{
				$output['message'] = "No Hp owner sudah digunakan, coba lagi dengan yang lain!";
				$output['result'] = "error";
			}
		}else{
			$output['message'] = "Email owner sudah digunakan, coba lagi dengan yang lain!";
			$output['result'] = "error";
		}
		echo json_encode($output);
		exit();
	}

	public function aksi_lupa_password(){
		$account = $this->m_main->getRow('db_account','email',$_POST['email']);
		if($account){
			if($account['id_posisi'] != 3){
				//Aksi kirim email ubah password
				$output['message'] = "Pemulihan password berhasil dikirm, cek pesan masuk atau spam pada email ".$_POST['email'];
				$output['result'] = "success";
			}else{
				$output['message'] = "Hubungi owner perusahaan untuk me-reset password akun admin Anda!";
				$output['result'] = "error";
			}
		}else{
			$output['message'] = "Email Anda tidak terdaftar!";
			$output['result'] = "error";
		}
		echo json_encode($output);
	}
}