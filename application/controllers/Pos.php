<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Pos extends CI_Controller {

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

    //================= KATEGORI PRODUK
	public function read_katproduk(){
		$katproduk = $this->m_main->getResultData('db_kat_produk','id_office = '.ID_OFFICE,'tgl_edit desc');
		$data = [];
		$no = 0;
		foreach ($katproduk as $list) {
			$no++;
			$row = [];
			$row['no'] = $no;
			$row['nama_kat_produk'] = $list->nama_kat_produk;
			$row['aksi'] = $list->id_kat_produk;
			$row['status'] = $list->status == 1 ? 'aktif-' : 'hapus-';
			$data[] = $row; 
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}

	public function add_katproduk(){
		if(!empty($_POST['nama_kat_produk'])){
			$data = [
				'id_office' => ID_OFFICE,
				'nama_kat_produk' => $_POST['nama_kat_produk'],
				'tgl_input' => date("Y-m-d H:i:s"),
				'tgl_edit' => date("Y-m-d H:i:s"),
				'status' => 1,
			];
			$this->m_main->createIN('db_kat_produk',$data);
			$output['message'] = "Data kategori produk berhasil ditambah!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Nama kategori produk tidak boleh kosong!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}

	public function edit_katproduk(){
		if(!empty($_POST['id_katproduk'])){
			$data = [
				'nama_kat_produk' => $_POST['nama_kat_produk'],
				'tgl_edit' => date("Y-m-d H:i:s"),
			];
			$this->m_main->updateIN('db_kat_produk','id_kat_produk',$_POST['id_katproduk'],$data);
			$output['message'] = "Data kategori produk berhasil di ubah!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id kategori produk tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function remove_katproduk(){
		if(!empty($_POST['id_katproduk'])){
			$data = [
				'status' => 0,
				'tgl_edit' => date("Y-m-d H:i:s"),
			];
			$this->m_main->updateIN('db_kat_produk','id_kat_produk',$_POST['id_katproduk'],$data);
			$output['message'] = "Kategori produk berhasil di hapus!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id kategori produk tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function restore_katproduk(){
		if(!empty($_POST['id_katproduk'])){
			$data = [
				'status' => 1,
				'tgl_edit' => date("Y-m-d H:i:s"),
			];
			$this->m_main->updateIN('db_kat_produk','id_kat_produk',$_POST['id_katproduk'],$data);
			$output['message'] = "Kategori produk berhasil di pulihkan!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id kategori produk tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}


}