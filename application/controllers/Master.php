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
		define('ID_LOKASI',$this->session->userdata('id_lokasi'));
    }

	//================= LOKASI
	public function read_lokasi(){
		$lokasi = $this->m_auth->getDataLokasi(ID_OFFICE);
		$data = [];
		$no = 0;
		foreach ($lokasi as $list) {
			$no++;
			$row = [];
			$row['no'] = $no;
			$row['kode_lokasi'] = $list->kode_lokasi;
			$row['nama_lokasi'] = $list->nama_lokasi;
			$row['alamat_lokasi'] = $list->alamat_lokasi;
			$row['nama'] = $list->nama;
			$row['email'] = $list->email;
			$row['telp'] = $list->telp;
			$row['password'] = $list->pass_view;
			$row['id_lokasi'] = $list->id_lokasi;
			$row['id_account'] = $list->id_account;
			$row['admin'] = null;
			$row['aksi'] = null;
			$row['status'] = $list->status == 1 ? 'aktif-' : 'hapus-';
			$data[] = $row; 
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}

	public function add_lokasi(){
		if(!empty($_POST['nama_lokasi'])){
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
				'tgl_login' => date("Y-m-d H:i:s"),
				'tgl_logout' => date("Y-m-d H:i:s"),
				'status' => 1,
			];
			$id_account = $this->m_main->createIN('db_account',$admin)['result'];
			$lokasi = [
				'id_office' => ID_OFFICE,
				'id_account' => $id_account,
				'kode_lokasi' => $_POST['kode_lokasi'],
				'nama_lokasi' => $_POST['nama_lokasi'],
				'alamat_lokasi' => $_POST['alamat_lokasi'],
				'tgl_input' => date("Y-m-d H:i:s"),
				'tgl_edit' => date("Y-m-d H:i:s"),
				'status' => 1,
			];
			$this->m_main->createIN('db_lokasi',$lokasi);
			$output['message'] = "Data lokasi dan admin berhasil ditambah!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Nama lokasi tidak boleh kosong!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}

	public function edit_lokasi(){
		if(!empty($_POST['id_lokasi'])){
			$lokasi = [
				'kode_lokasi' => $_POST['kode_lokasi'],
				'nama_lokasi' => $_POST['nama_lokasi'],
				'alamat_lokasi' => $_POST['alamat_lokasi'],
				'tgl_edit' => date("Y-m-d H:i:s"),
			];
			$this->m_main->updateIN('db_lokasi','id_lokasi',$_POST['id_lokasi'],$lokasi);
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

			$output['message'] = "Data lokasi dan admin berhasil di ubah!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id lokasi tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function remove_lokasi(){
		if(!empty($_POST['id_lokasi'])){
			$lokasi = [
				'status' => 0,
				'tgl_edit' => date("Y-m-d H:i:s"),
			];
			$this->m_main->updateIN('db_lokasi','id_lokasi',$_POST['id_lokasi'],$lokasi);
			$admin = [
				'status' => 0,
				'tgl_edit' => date("Y-m-d H:i:s"),
			];
			$this->m_main->updateIN('db_account','id_account',$_POST['id_account'],$admin);

			$output['message'] = "Lokasi berhasil di hapus!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id lokasi tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function restore_lokasi(){
		if(!empty($_POST['id_lokasi'])){
			$lokasi = [
				'status' => 1,
				'tgl_edit' => date("Y-m-d H:i:s"),
			];
			$this->m_main->updateIN('db_lokasi','id_lokasi',$_POST['id_lokasi'],$lokasi);
			$admin = [
				'status' => 1,
				'tgl_edit' => date("Y-m-d H:i:s"),
			];
			$this->m_main->updateIN('db_account','id_account',$_POST['id_account'],$admin);

			$output['message'] = "Lokasi berhasil di pulihkan!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id lokasi tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}

    //================= PAKET
	public function read_paket(){
		$paket = $this->m_auth->getPaketGym(ID_OFFICE,ID_LOKASI);
		$data = [];
		$no = 0;
		foreach ($paket as $list) {
			$no++;
			$row = [];
			$row['no'] = $no;
			$row['nama_paket'] = $list->nama_paket;
			$row['durasi_paket'] = $list->durasi_paket;
			$row['lama_durasi'] = $list->lama_durasi;
			$row['harga_paket'] = $list->harga_paket;
			$row['status_member'] = $list->status_member;
			$row['nama_lokasi'] = $list->nama_lokasi;
			$row['id_lokasi'] = $list->id_lokasi;
			$row['id_lokasi_filter'] = '-'.$list->id_lokasi.'-';
			$row['durasi'] = null;
			$row['aksi'] = $list->id_paket_gym;
			$row['status'] = $list->status == 1 ? 'aktif-' : 'hapus-';
			$data[] = $row; 
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}

	public function add_paket(){
		if(!empty($_POST['nama_paket'])){
			$data = [
				'id_office' => ID_OFFICE,
				'id_lokasi' => $_POST['id_lokasi'] ? $_POST['id_lokasi'] : (ID_LOKASI != '' ? ID_LOKASI : 1),
				'nama_paket' => $_POST['nama_paket'],
				'durasi_paket' => $_POST['durasi_paket'],
				'lama_durasi' => $_POST['lama_durasi'],
				'harga_paket' => str_replace(".","",$_POST['harga_paket']),
				'status_member' => $_POST['status_member'],
				'tgl_input' => date("Y-m-d H:i:s"),
				'tgl_edit' => date("Y-m-d H:i:s"),
				'status' => 1,
				'id_account' => ID_ACCOUNT,
			];
			$this->m_main->createIN('db_paket_gym',$data);
			$output['message'] = "Data paket gym berhasil ditambah!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Nama paket gym tidak boleh kosong!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}

	public function edit_paket(){
		if(!empty($_POST['nama_paket'])){
			$data = [
				'nama_paket' => $_POST['nama_paket'],
				'durasi_paket' => $_POST['durasi_paket'],
				'lama_durasi' => $_POST['lama_durasi'],
				'harga_paket' => str_replace(".","",$_POST['harga_paket']),
				'status_member' => $_POST['status_member'],
				'tgl_edit' => date("Y-m-d H:i:s"),
			];
			$this->m_main->updateIN('db_paket_gym','id_paket_gym',$_POST['id_paket'],$data);
			$output['message'] = "Data paket gym berhasil di ubah!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id paket gym tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function remove_kegiatan(){
		if(!empty($_POST['id_paket'])){
			$data = [
				'status' => 0,
				'tgl_edit' => date("Y-m-d H:i:s"),
			];
			$this->m_main->updateIN('db_paket_gym','id_paket_gym',$_POST['id_paket'],$data);
			$output['message'] = "Paket gym berhasil di hapus!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id paket gym tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function restore_kegiatan(){
		if(!empty($_POST['id_paket'])){
			$data = [
				'status' => 1,
				'tgl_edit' => date("Y-m-d H:i:s"),
			];
			$this->m_main->updateIN('db_paket_gym','id_paket_gym',$_POST['id_paket'],$data);
			$output['message'] = "Paket gym berhasil di pulihkan!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id paket gym tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}

	public function list_paket(){
		$id_lokasi = ID_POSISI == 3 ? ID_LOKASI : $_POST['id_lokasi'];
		$paket = $this->m_auth->getListPaket(ID_OFFICE,$id_lokasi);
		$data = [];
		foreach ($paket as $list) {
			$row = [];
			$row['id_paket_gym'] = $list->id_paket_gym;
			$row['nama_paket'] = $list->nama_paket;
			$row['durasi_paket'] = $list->durasi_paket;
			$row['lama_durasi'] = $list->lama_durasi;
			$row['harga_paket'] = $list->harga_paket;
			$row['status_member'] = $list->status_member;
			$row['durasi'] = null;
			$data[] = $row; 
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}

	public function durasi_paket(){
		$durasi = [null, 'minute', 'day', 'week', 'month', 'year'];
		$paket_gym = $this->m_main->getRow('db_paket_gym','id_paket_gym',$_POST['id_paket_gym']);
		$tanggal = date_format(date_create($_POST['tanggal']),"Y-m-d H:i:s");
		if($paket_gym){
			$output = [
				"result" => "success",
				"tgl_mulai" => $tanggal,
				"tgl_akhir" => date("Y-m-d H:i:s",strtotime($tanggal." +".$paket_gym['lama_durasi']." ".$durasi[$paket_gym['durasi_paket']])),
				"tgl_paket" => 
					(
						$paket_gym['durasi_paket'] == 1 ? 
						'Aktif '.date_format(date_create($_POST['tanggal']),"H:i").' s/d '.date("H:i",strtotime($tanggal." +".$paket_gym['lama_durasi']." ".$durasi[$paket_gym['durasi_paket']])): 
						'Aktif '.date_format(date_create($_POST['tanggal']),"d-m-Y").' s/d '.date("d-m-Y",strtotime($tanggal." +".$paket_gym['lama_durasi']." ".$durasi[$paket_gym['durasi_paket']]))
					)

			];
		}else{
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
}