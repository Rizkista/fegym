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

	//================= Anggota
	public function read_anggota(){
		$anggota = $this->m_auth->GetAllAnggota();
		$data = [];
		$no = 0;
		foreach ($anggota as $list) {
            $no++;
            $row = [];
            $row['No'] = $no;
            $row['nama_anggota'] = $list->nama_anggota;
            $row['gender_anggota'] = $list->gender_anggota;
            $row['telp_anggota'] = $list->telp_anggota;
            $row['email_anggota'] = $list->email_anggota;
            $row['alamat_anggota'] = $list->alamat_anggota;
            $row['status_member'] = $list->status_member == 1 ? 'Ya' : 'Tidak';
            $row['id_cabang'] = $list->id_cabang;
            $row['status'] = $list->status == 1 ? 'aktif-' : 'hapus-';
            $row['Aksi'] = $list->id_anggota;
            $row['IDcabang'] = '-'.$list->id_cabang.'-';
            $data[] = $row;
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}

	public function add_anggota(){
		$cekData = $this->m_main->cekData('db_anggota','telp_anggota',$_POST['telp_anggota']);
		if(!$cekData){
			$data = [
				'id_office' => ID_OFFICE,
				'id_cabang' => ID_CABANG != '' ? ID_CABANG : 1,
				'nama_anggota' => $_POST['nama_anggota'],
				'gender_anggota' => $_POST['gender_anggota'],
				'telp_anggota' => $_POST['telp_anggota'],
				'email_anggota' => $_POST['email_anggota'],
				'alamat_anggota' => $_POST['alamat_anggota'],
				'tgl_input' => date("Y-m-d H:i:s"),
				'tgl_edit' => date("Y-m-d H:i:s"),
				'status' => 1,
			];
			$this->m_main->createIN('db_anggota',$data);
		
			$output['message'] = "Data anggota berhasil ditambah!";
			$output['result'] = "success";
		}else{
			$output['message'] = "No.hp sudah di gunakan, coba dengan yang lain!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function edit_anggota(){
		if(!empty($_POST['id_anggota'])){
			$cekData = $this->m_main->cekData('db_anggota','telp_anggota',$_POST['telp_anggota']);
			$getData = $this->m_main->getRow('db_anggota','id_anggota',$_POST['id_anggota']);
			if(!$cekData || ($_POST['telp_anggota']==$getData['telp_anggota'])){
				$data = [
                    'nama_anggota' => $_POST['nama_anggota'],
                    'gender_anggota' => $_POST['gender_anggota'],
                    'telp_anggota' => $_POST['telp_anggota'],
                    'email_anggota' => $_POST['email_anggota'],
                    'alamat_anggota' => $_POST['alamat_anggota'],
					'tgl_edit' => date("Y-m-d H:i:s"),
				];
				$this->m_main->updateIN('db_anggota','id_anggota',$_POST['id_anggota'],$data);
				$output['message'] = "Data anggota berhasil di ubah!";
				$output['result'] = "success";
			}else{
				$output['message'] = "No.Hp sudah di gunakan, coba dengan yang lain!";
				$output['result'] = "error";
			}
		}else{
			$output['message'] = "Data id anggota tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function remove_anggota(){
		if(!empty($_POST['id_anggota'])){
			$data = [
				'status' => 0,
				'tgl_edit' => date("Y-m-d H:i:s"),
			];
			$this->m_main->updateIN('db_anggota','id_anggota',$_POST['id_anggota'],$data);
			$output['message'] = "Anggota berhasil di hapus!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id anggota tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function restore_anggota(){
		if(!empty($_POST['id_anggota'])){
			$data = [
				'status' => 1,
				'tgl_edit' => date("Y-m-d H:i:s"),
			];
			$this->m_main->updateIN('db_anggota','id_anggota',$_POST['id_anggota'],$data);
			$output['message'] = "Anggota berhasil di pulihkan!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id anggota tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function delete_anggota(){
		if(!empty($_POST['id_anggota'])){
			$this->m_main->deleteIN('db_anggota','id_anggota',$_POST['id_anggota']);
			$output['message'] = "Anggota berhasil di hapus permanen!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id anggota tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}

	public function level_anggota(){
		$output['tambah'] = $this->m_akses->cekAksi(ID_JABATAN,'anggota',2);
		$output['ubah'] = $this->m_akses->cekAksi(ID_JABATAN,'anggota',3);
		$output['hapus'] = $this->m_akses->cekAksi(ID_JABATAN,'anggota',4);
		echo json_encode($output);
	}
    
}