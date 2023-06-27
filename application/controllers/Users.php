<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Users extends CI_Controller {
        
    function __construct(){
        parent::__construct();
		$this->load->model('M_main', 'm_main');
		$this->load->model('M_akses', 'm_akses');
		$this->load->model('M_auth', 'm_auth');
		define('EMAIL',$this->session->userdata('email'));
		define('ID_ACCOUNT',$this->session->userdata('id_account'));
		define('ID_POSISI',$this->session->userdata('id_posisi'));
		define('ID_OFFICE',$this->session->userdata('id_office'));
		define('ID_CABANG',$this->session->userdata('id_cabang'));
    }

	//================= USER
	public function read_user(){
		$user = $this->m_auth->GetAllUsers();
		$data = [];
		$no = 0;
		foreach ($user as $list) {
            $no++;
            $row = [];
            $row['No'] = $no;
            $row['nama_user'] = $list->nama_user;
            $row['gender_user'] = $list->gender_user;
            $row['telp_user'] = $list->telp_user;
            $row['email_user'] = $list->email_user;
            $row['alamat_user'] = $list->alamat_user;
            $row['status_member'] = $list->status_member == 1 ? 'Ya' : 'Tidak';
            $row['id_cabang'] = $list->id_cabang;
            $row['status'] = $list->status == 1 ? 'aktif-' : 'hapus-';
            $row['Aksi'] = $list->id_user;
            $row['IDcabang'] = '-'.$list->id_cabang.'-';
            $data[] = $row;
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}

	public function add_user(){
		$cekData = $this->m_main->cekData('db_user','telp_user',$_POST['telp_user']);
		if(!$cekData){
			$data = [
				'id_office' => ID_OFFICE,
				'id_cabang' => ID_CABANG != '' ? ID_CABANG : 1,
				'nama_user' => $_POST['nama_user'],
				'gender_user' => $_POST['gender_user'],
				'telp_user' => $_POST['telp_user'],
				'email_user' => $_POST['email_user'],
				'alamat_user' => $_POST['alamat_user'],
				'tgl_input' => date("Y-m-d H:i:s"),
				'tgl_edit' => date("Y-m-d H:i:s"),
				'status' => 1,
			];
			$this->m_main->createIN('db_user',$data);
		
			$output['message'] = "Data user berhasil ditambah!";
			$output['result'] = "success";
		}else{
			$output['message'] = "No.hp sudah di gunakan, coba dengan yang lain!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function edit_user(){
		if(!empty($_POST['id_user'])){
			$cekData = $this->m_main->cekData('db_user','telp_user',$_POST['telp_user']);
			$getData = $this->m_main->getRow('db_user','id_user',$_POST['id_user']);
			if(!$cekData || ($_POST['telp_user']==$getData['telp_user'])){
				$data = [
                    'nama_user' => $_POST['nama_user'],
                    'gender_user' => $_POST['gender_user'],
                    'telp_user' => $_POST['telp_user'],
                    'email_user' => $_POST['email_user'],
                    'alamat_user' => $_POST['alamat_user'],
					'tgl_edit' => date("Y-m-d H:i:s"),
				];
				$this->m_main->updateIN('db_user','id_user',$_POST['id_user'],$data);
				$output['message'] = "Data user berhasil di ubah!";
				$output['result'] = "success";
			}else{
				$output['message'] = "No.Hp sudah di gunakan, coba dengan yang lain!";
				$output['result'] = "error";
			}
		}else{
			$output['message'] = "Data id user tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function remove_user(){
		if(!empty($_POST['id_user'])){
			$data = [
				'status' => 0,
				'tgl_edit' => date("Y-m-d H:i:s"),
			];
			$this->m_main->updateIN('db_user','id_user',$_POST['id_user'],$data);
			$output['message'] = "User berhasil di hapus!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id user tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function restore_user(){
		if(!empty($_POST['id_user'])){
			$data = [
				'status' => 1,
				'tgl_edit' => date("Y-m-d H:i:s"),
			];
			$this->m_main->updateIN('db_user','id_user',$_POST['id_user'],$data);
			$output['message'] = "User berhasil di pulihkan!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id user tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function delete_user(){
		if(!empty($_POST['id_user'])){
			$this->m_main->deleteIN('db_user','id_user',$_POST['id_user']);
			$output['message'] = "User berhasil di hapus permanen!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id user tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}

	public function level_user(){
		$output['tambah'] = $this->m_akses->cekAksi(ID_JABATAN,'user',2);
		$output['ubah'] = $this->m_akses->cekAksi(ID_JABATAN,'user',3);
		$output['hapus'] = $this->m_akses->cekAksi(ID_JABATAN,'user',4);
		echo json_encode($output);
	}
    
}