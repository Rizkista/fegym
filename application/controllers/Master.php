<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Master extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('M_main', 'm_main');
		$this->load->model('M_auth', 'm_auth');
		define('EMAIL',$this->session->userdata('email'));
		define('ID_ACCOUNT',$this->session->userdata('id_account'));
		define('ID_POSISI',$this->session->userdata('id_posisi'));
		define('ID_OFFICE',$this->session->userdata('id_office'));
		define('ID_CABANG',$this->session->userdata('id_cabang'));
    }

	//================= CABANG
	public function read_cabang(){
		$cabang = $this->m_auth->getDataCabang();
		$data = [];
		$no = 0;
		foreach ($cabang as $list) {
			$no++;
			$row = [];
			$row['no'] = $no;
			$row['nama_cabang'] = $list->nama_cabang;
			$row['alamat_cabang'] = $list->alamat_cabang;
			$row['nama'] = $list->nama;
			$row['email'] = $list->email;
			$row['telp'] = $list->telp;
			$row['password'] = $list->pass_view;
			$row['id_cabang'] = $list->id_cabang;
			$row['id_account'] = $list->id_account;
			$row['admin'] = null;
			$row['aksi'] = null;
			$row['status'] = $list->status == 1 ? 'aktif-' : 'hapus-';
			$data[] = $row; 
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}

	public function add_cabang(){
		if(!empty($_POST['nama_cabang'])){
			$admin = [
				'id_posisi' => 3,
				'id_office' => ID_OFFICE,
				'nama' => $_POST['nama'],
				'email' => $_POST['email'],
				'telp' => $_POST['telp'],
				'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
				'pass_view' => $_POST['password'],
				'tgl_input' => date("Y-m-d H:i:s"),
				'tgl_edit' => date("Y-m-d H:i:s"),
				'status' => 1,
			];
			$id_account = $this->m_main->createIN('db_account',$admin)['result'];
			$cabang = [
				'id_office' => ID_OFFICE,
				'id_account' => $id_account,
				'nama_cabang' => $_POST['nama_cabang'],
				'alamat_cabang' => $_POST['alamat_cabang'],
				'tgl_input' => date("Y-m-d H:i:s"),
				'tgl_edit' => date("Y-m-d H:i:s"),
				'status' => 1,
			];
			$this->m_main->createIN('db_cabang',$cabang);
			$output['message'] = "Data cabang dan admin berhasil ditambah!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Nama cabang tidak boleh kosong!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}

	public function edit_cabang(){
		if(!empty($_POST['id_cabang'])){
			$cabang = [
				'nama_cabang' => $_POST['nama_cabang'],
				'alamat_cabang' => $_POST['alamat_cabang'],
				'tgl_edit' => date("Y-m-d H:i:s"),
			];
			$this->m_main->updateIN('db_cabang','id_cabang',$_POST['id_cabang'],$cabang);
			$admin = [
				'nama' => $_POST['nama'],
				'email' => $_POST['email'],
				'telp' => $_POST['telp'],
				'tgl_edit' => date("Y-m-d H:i:s"),
			];
			if($_POST['password']){
				$admin = [
					'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
					'pass_view' => $_POST['password'],
				];
			}
			$this->m_main->updateIN('db_account','id_account',$_POST['id_account'],$admin);

			$output['message'] = "Data cabang dan admin berhasil di ubah!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id cabang tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function remove_cabang(){
		if(!empty($_POST['id_cabang'])){
			$cabang = [
				'status' => 0,
				'tgl_edit' => date("Y-m-d H:i:s"),
			];
			$this->m_main->updateIN('db_cabang','id_cabang',$_POST['id_cabang'],$cabang);
			$admin = [
				'status' => 0,
				'tgl_edit' => date("Y-m-d H:i:s"),
			];
			$this->m_main->updateIN('db_account','id_account',$_POST['id_account'],$admin);

			$output['message'] = "Cabang berhasil di hapus!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id cabang tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function restore_cabang(){
		if(!empty($_POST['id_cabang'])){
			$cabang = [
				'status' => 1,
				'tgl_edit' => date("Y-m-d H:i:s"),
			];
			$this->m_main->updateIN('db_cabang','id_cabang',$_POST['id_cabang'],$cabang);
			$admin = [
				'status' => 1,
				'tgl_edit' => date("Y-m-d H:i:s"),
			];
			$this->m_main->updateIN('db_account','id_account',$_POST['id_account'],$admin);

			$output['message'] = "Cabang berhasil di pulihkan!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id cabang tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}

}