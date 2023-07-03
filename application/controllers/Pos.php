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
		define('ID_LOKASI',$this->session->userdata('id_lokasi'));
    }

    //================= KATEGORI PRODUK
	public function read_katproduk(){
		$katproduk = $this->m_auth->getDataKategoriProduk(ID_OFFICE,ID_LOKASI);
		$data = [];
		$no = 0;
		foreach ($katproduk as $list) {
			$no++;
			$row = [];
			$row['no'] = $no;
			$row['nama_kat_produk'] = $list->nama_kat_produk;
			$row['nama_lokasi'] = $list->nama_lokasi;
			$row['id_lokasi'] = $list->id_lokasi;
			$row['id_lokasi_filter'] = '-'.$list->id_lokasi.'-';
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
				'id_lokasi' => $_POST['id_lokasi'] ? $_POST['id_lokasi'] : (ID_LOKASI != '' ? ID_LOKASI : 1),
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

    //================= PRODUK
	public function read_produk(){
		$produk = $this->m_auth->getDataProduk(ID_OFFICE,ID_LOKASI);
		$data = [];
		$no = 0;
		foreach ($produk as $list) {
			$no++;
			$row = [];
			$row['no'] = $no;
			$row['barcode_produk'] = $list->barcode_produk;
			$row['nama_produk'] = $list->nama_produk;
			$row['qty_produk'] = $list->qty_produk;
			$row['harga_beli'] = $list->harga_beli;
			$row['harga_jual'] = $list->harga_jual;
			$row['satuan_produk'] = $list->satuan_produk;
			$row['nama_kat_produk'] = $list->nama_kat_produk;
			$row['nama_lokasi'] = $list->nama_lokasi;
			$row['id_kat_produk'] = $list->id_kat_produk;
			$row['id_lokasi'] = $list->id_lokasi;
			$row['id_lokasi_filter'] = '-'.$list->id_lokasi.'-';
			$row['aksi'] = $list->id_produk;
			$row['status'] = $list->status == 1 ? 'aktif-' : 'hapus-';
			$data[] = $row; 
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}

	public function get_kat_produk(){
		$id_lok = $_POST['id_lokasi'];
		if($id_lok != null){
			$id_lokasi = $id_lok;
		}else{
			$id_lokasi = ID_LOKASI;
		}
		$kategori = $this->m_main->getResultData('db_kat_produk','status = 1 AND id_office = '.ID_OFFICE.' AND id_lokasi = '.$id_lokasi,'nama_kat_produk asc');
		echo json_encode($kategori);
	}

	public function add_produk(){
		if(!empty($_POST['nama_produk'])){
			$data = [
				'id_office' => ID_OFFICE,
				'id_lokasi' => $_POST['id_lokasi'] ? $_POST['id_lokasi'] : (ID_LOKASI != '' ? ID_LOKASI : 1),
				'id_kat_produk' => $_POST['id_kat_produk'],
				'barcode_produk' => $_POST['barcode_produk'],
				'nama_produk' => $_POST['nama_produk'],
				'harga_beli' => str_replace(".","",$_POST['harga_beli']),
				'harga_jual' => str_replace(".","",$_POST['harga_jual']),
				'satuan_produk' => $_POST['satuan_produk'],
				'qty_produk' => 0,
				'tgl_input' => date("Y-m-d H:i:s"),
				'tgl_edit' => date("Y-m-d H:i:s"),
				'status' => 1,
			];
			$this->m_main->createIN('db_produk',$data);
			$output['message'] = "Data produk berhasil ditambah!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Nama produk tidak boleh kosong!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}

	public function edit_produk(){
		if(!empty($_POST['id_produk'])){
			$data = [
				'id_kat_produk' => $_POST['id_kat_produk'],
				'barcode_produk' => $_POST['barcode_produk'],
				'nama_produk' => $_POST['nama_produk'],
				'harga_beli' => str_replace(".","",$_POST['harga_beli']),
				'harga_jual' => str_replace(".","",$_POST['harga_jual']),
				'satuan_produk' => $_POST['satuan_produk'],
				'tgl_edit' => date("Y-m-d H:i:s"),
			];
			$this->m_main->updateIN('db_produk','id_produk',$_POST['id_produk'],$data);
			$output['message'] = "Data produk berhasil di ubah!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id produk tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function remove_produk(){
		if(!empty($_POST['id_produk'])){
			$data = [
				'status' => 0,
				'tgl_edit' => date("Y-m-d H:i:s"),
			];
			$this->m_main->updateIN('db_produk','id_produk',$_POST['id_produk'],$data);
			$output['message'] = "Produk berhasil di hapus!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id produk tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function restore_produk(){
		if(!empty($_POST['id_produk'])){
			$data = [
				'status' => 1,
				'tgl_edit' => date("Y-m-d H:i:s"),
			];
			$this->m_main->updateIN('db_produk','id_produk',$_POST['id_produk'],$data);
			$output['message'] = "Produk berhasil di pulihkan!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id produk tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	

}