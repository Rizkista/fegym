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
			$row['stok_produk'] = floatval($list->stok_produk);
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
			$new_kategori = $_POST['new_id_kat_produk'];
			if($new_kategori){
				$kate = [
					'id_office' => ID_OFFICE,
					'id_lokasi' => $_POST['id_lokasi'] ? $_POST['id_lokasi'] : (ID_LOKASI != '' ? ID_LOKASI : 1),
					'nama_kat_produk' => $new_kategori,
					'tgl_input' => date("Y-m-d H:i:s"),
					'tgl_edit' => date("Y-m-d H:i:s"),
					'status' => 1,
				];
				$id_kat_produk = $this->m_main->createIN('db_kat_produk',$kate)['result'];
			}else{
				$id_kat_produk = $_POST['id_kat_produk'];
			}
			$data = [
				'id_office' => ID_OFFICE,
				'id_kat_produk' => $id_kat_produk,
				'id_lokasi' => $_POST['id_lokasi'] ? $_POST['id_lokasi'] : (ID_LOKASI != '' ? ID_LOKASI : 1),
				'barcode_produk' => $_POST['barcode_produk'],
				'nama_produk' => $_POST['nama_produk'],
				'harga_beli' => str_replace(".","",$_POST['harga_beli']),
				'harga_jual' => str_replace(".","",$_POST['harga_jual']),
				'satuan_produk' => $_POST['satuan_produk'],
				'stok_produk' => 0,
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
			$new_kategori = $_POST['new_id_kat_produk'];
			if($new_kategori){
				$kate = [
					'id_office' => ID_OFFICE,
					'id_lokasi' => $_POST['id_lokasi'] ? $_POST['id_lokasi'] : (ID_LOKASI != '' ? ID_LOKASI : 1),
					'nama_kat_produk' => $new_kategori,
					'tgl_input' => date("Y-m-d H:i:s"),
					'tgl_edit' => date("Y-m-d H:i:s"),
					'status' => 1,
				];
				$id_kat_produk = $this->m_main->createIN('db_kat_produk',$kate)['result'];
			}else{
				$id_kat_produk = $_POST['id_kat_produk'];
			}
			$data = [
				'id_kat_produk' => $id_kat_produk,
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

	public function list_produk(){
		$id_lokasi = ID_POSISI == 3 ? ID_LOKASI : $_POST['id_lokasi'];
		$produk = $this->m_auth->getListProduk(ID_OFFICE,$id_lokasi);
		$data = [];
		foreach ($produk as $list) {
			$row = [];
			$row['id_produk'] = $list->id_produk;
			$row['barcode_produk'] = $list->barcode_produk;
			$row['nama_produk'] = $list->nama_produk;
			$row['stok_produk'] = floatval($list->stok_produk);
			$row['satuan_produk'] = $list->satuan_produk;
			$data[] = $row; 
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}
	
    //================= STOK MASUK
	public function read_stok_masuk(){
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];
		$status = $_POST['status'];
		$id_lokasi = ID_POSISI == 3 ? ID_LOKASI : $_POST['id_lokasi'];
		$stok_masuk = $this->m_auth->getDataStokMasuk($start_date,$end_date,$status,$id_lokasi,ID_OFFICE);
		$data = [];
		$no = 0;
		foreach ($stok_masuk as $list) {
			$no++;
			$row = [];
			$row['no'] = $no;
			$row['date_format'] = date('d-m-Y H:i:s',strtotime($list->tgl_masuk));
			$row['nofaktur'] = $list->nofaktur;
			$row['supplier'] = $list->supplier;
			$row['nama_lokasi'] = $list->nama_lokasi;
			$row['alasan_hapus'] = $list->alasan_hapus;
			$row['produk'] = str_replace('   ,','<br>',$list->produk);
			$row['jumlah'] = str_replace(',','<br>',$list->jumlah);
			$row['aksi'] = $list->id_stok_masuk ;
			$row['tgl_masuk'] = $list->tgl_masuk;
			$data[] = $row; 
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}

	public function add_stok_masuk(){
		if(!empty($_POST['data_produk'])){
			$id_lokasi = ID_POSISI == 3 ? ID_LOKASI : ($_POST['id_lokasi'] == 0 ? 1 : $_POST['id_lokasi']);
			$data = [
				'id_office' => ID_OFFICE,
				'id_lokasi' => $id_lokasi,
				'nofaktur' => $_POST['nofaktur'],
				'supplier' => $_POST['supplier'],
				'tgl_masuk' => date("Y-m-d", strtotime($_POST['tgl_masuk'])).' '.date("H:i:s"),
				'tgl_input' => date("Y-m-d H:i:s"),
				'tgl_edit' => date("Y-m-d H:i:s"),
				'status' => 1,
			];
			$id_stok_masuk  = $this->m_main->createIN('db_stok_masuk',$data)['result'];	
			$listProduk = $_POST['data_produk'];
			for($i=0; $i<count($listProduk); $i++){
				$list = [
					'id_stok_masuk ' => $id_stok_masuk,
					'id_produk ' => $listProduk[$i]['id_produk'],
					'jml_produk' => $listProduk[$i]['jml_produk'],
					'status' => 1,
				];
				$this->m_main->createIN('db_stok_masuk_detail',$list);
				
				$data_produk = $this->m_main->getRow('db_produk','id_produk',$listProduk[$i]['id_produk']);
				$datup = [
					'stok_produk ' => floatval($data_produk['stok_produk']) + floatval($listProduk[$i]['jml_produk']),
					'tgl_edit' => date("Y-m-d H:i:s"),
				];
				$this->m_main->updateIN('db_produk','id_produk',$listProduk[$i]['id_produk'],$datup);
			}
			$output['message'] ="Stok masuk produk berhasil ditambah!";
			$output['result'] = "success";
		}else{
			$output['message'] ="Data produk tidak boleh kosong!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function remove_stok_masuk(){
		if(!empty($_POST['id_stok_masuk'])){
			$data = [
				'alasan_hapus' => $_POST['alasan_hapus'],
				'status' => 0,
				'tgl_edit' => date("Y-m-d H:i:s"),
			];
			$this->m_main->updateIN('db_stok_masuk','id_stok_masuk',$_POST['id_stok_masuk'],$data);
			$list = [
				'status' => 0,
			];
			$this->m_main->updateIN('db_stok_masuk_detail','id_stok_masuk',$_POST['id_stok_masuk'],$list);
			$DTlist = $this->m_main->getResult('db_stok_masuk_detail','id_stok_masuk',$_POST['id_stok_masuk']);
			foreach ($DTlist as $list) {
				$data_produk = $this->m_main->getRow('db_produk','id_produk',$list->id_produk);
				$datup = [
					'stok_produk ' => floatval($data_produk['stok_produk']) - floatval($list->jml_produk),
					'tgl_edit' => date("Y-m-d H:i:s"),
				];
				$this->m_main->updateIN('db_produk','id_produk',$list->id_produk,$datup);
			}
			$output['message'] = "Stok masuk berhasil di hapus!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id transaksi tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
    //================= STOK KELUAR
	public function read_stok_keluar(){
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];
		$status = $_POST['status'];
		$id_lokasi = ID_POSISI == 3 ? ID_LOKASI : $_POST['id_lokasi'];
		$stok_keluar = $this->m_auth->getDataStokKeluar($start_date,$end_date,$status,$id_lokasi,ID_OFFICE);
		$data = [];
		$no = 0;
		foreach ($stok_keluar as $list) {
			$no++;
			$row = [];
			$row['no'] = $no;
			$row['date_format'] = date('d-m-Y H:i:s',strtotime($list->tgl_keluar));
			$row['nokeluar'] = $list->nokeluar;
			$row['keterangan'] = $list->keterangan;
			$row['nama_lokasi'] = $list->nama_lokasi;
			$row['alasan_hapus'] = $list->alasan_hapus;
			$row['produk'] = str_replace('   ,','<br>',$list->produk);
			$row['jumlah'] = str_replace(',','<br>',$list->jumlah);
			$row['aksi'] = $list->id_stok_keluar ;
			$row['tgl_keluar'] = $list->tgl_keluar;
			$data[] = $row; 
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}

	public function add_stok_keluar(){
		if(!empty($_POST['data_produk'])){
			$id_lokasi = ID_POSISI == 3 ? ID_LOKASI : ($_POST['id_lokasi'] == 0 ? 1 : $_POST['id_lokasi']);
			$kode_lokasi = $this->m_main->getRow('db_lokasi','id_lokasi',$id_lokasi)['kode_lokasi'];
			$data = [
				'id_office' => ID_OFFICE,
				'id_lokasi' => $id_lokasi,
				'nokeluar' => "KL".$kode_lokasi.date('YmdHis'),
				'keterangan' => $_POST['keterangan'],
				'tgl_keluar' => date("Y-m-d", strtotime($_POST['tgl_keluar'])).' '.date("H:i:s"),
				'tgl_input' => date("Y-m-d H:i:s"),
				'tgl_edit' => date("Y-m-d H:i:s"),
				'status' => 1,
			];
			$id_stok_keluar  = $this->m_main->createIN('db_stok_keluar',$data)['result'];	
			$listProduk = $_POST['data_produk'];
			for($i=0; $i<count($listProduk); $i++){
				$list = [
					'id_stok_keluar ' => $id_stok_keluar,
					'id_produk ' => $listProduk[$i]['id_produk'],
					'jml_produk' => $listProduk[$i]['jml_produk'],
					'status' => 1,
				];
				$this->m_main->createIN('db_stok_keluar_detail',$list);
				
				$data_produk = $this->m_main->getRow('db_produk','id_produk',$listProduk[$i]['id_produk']);
				$datup = [
					'stok_produk ' => floatval($data_produk['stok_produk']) - floatval($listProduk[$i]['jml_produk']),
					'tgl_edit' => date("Y-m-d H:i:s"),
				];
				$this->m_main->updateIN('db_produk','id_produk',$listProduk[$i]['id_produk'],$datup);
			}
			$output['message'] ="Stok keluar produk berhasil ditambah!";
			$output['result'] = "success";
		}else{
			$output['message'] ="Data produk tidak boleh kosong!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function remove_stok_keluar(){
		if(!empty($_POST['id_stok_keluar'])){
			$data = [
				'alasan_hapus' => $_POST['alasan_hapus'],
				'status' => 0,
				'tgl_edit' => date("Y-m-d H:i:s"),
			];
			$this->m_main->updateIN('db_stok_keluar','id_stok_keluar',$_POST['id_stok_keluar'],$data);
			$list = [
				'status' => 0,
			];
			$this->m_main->updateIN('db_stok_keluar_detail','id_stok_keluar',$_POST['id_stok_keluar'],$list);
			$DTlist = $this->m_main->getResult('db_stok_keluar_detail','id_stok_keluar',$_POST['id_stok_keluar']);
			foreach ($DTlist as $list) {
				$data_produk = $this->m_main->getRow('db_produk','id_produk',$list->id_produk);
				$datup = [
					'stok_produk ' => floatval($data_produk['stok_produk']) + floatval($list->jml_produk),
					'tgl_edit' => date("Y-m-d H:i:s"),
				];
				$this->m_main->updateIN('db_produk','id_produk',$list->id_produk,$datup);
			}
			$output['message'] = "Stok keluar berhasil di hapus!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id transaksi tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
    //================= STOK OPNAME
	public function read_stok_opname(){
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];
		$status = $_POST['status'];
		$id_lokasi = ID_POSISI == 3 ? ID_LOKASI : $_POST['id_lokasi'];
		$stok_opname = $this->m_auth->getDataStokOpname($start_date,$end_date,$status,$id_lokasi,ID_OFFICE);
		$data = [];
		$no = 0;
		foreach ($stok_opname as $list) {
			$no++;
			$row = [];
			$row['no'] = $no;
			$row['date_format'] = date('d-m-Y H:i:s',strtotime($list->tgl_opname));
			$row['noopname'] = $list->noopname;
			$row['keterangan'] = $list->keterangan;
			$row['nama_lokasi'] = $list->nama_lokasi;
			$row['alasan_hapus'] = $list->alasan_hapus;
			$row['produk'] = str_replace('   ,','<br>',$list->produk);
			$row['jumlah'] = str_replace(',','<br>',$list->jumlah);
			$row['aksi'] = $list->id_stok_opname ;
			$row['tgl_opname'] = $list->tgl_opname;
			$data[] = $row; 
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}

	public function add_stok_opname(){
		if(!empty($_POST['data_produk'])){
			$id_lokasi = ID_POSISI == 3 ? ID_LOKASI : ($_POST['id_lokasi'] == 0 ? 1 : $_POST['id_lokasi']);
			$kode_lokasi = $this->m_main->getRow('db_lokasi','id_lokasi',$id_lokasi)['kode_lokasi'];
			$data = [
				'id_office' => ID_OFFICE,
				'id_lokasi' => $id_lokasi,
				'noopname' => "OP".$kode_lokasi.date('YmdHis'),
				'keterangan' => $_POST['keterangan'],
				'tgl_opname' => date("Y-m-d", strtotime($_POST['tgl_opname'])).' '.date("H:i:s"),
				'tgl_input' => date("Y-m-d H:i:s"),
				'tgl_edit' => date("Y-m-d H:i:s"),
				'status' => 1,
			];
			$id_stok_opname  = $this->m_main->createIN('db_stok_opname',$data)['result'];	
			$listProduk = $_POST['data_produk'];
			for($i=0; $i<count($listProduk); $i++){
				$list = [
					'id_stok_opname ' => $id_stok_opname,
					'id_produk ' => $listProduk[$i]['id_produk'],
					'jml_produk' => $listProduk[$i]['jml_produk'],
					'status' => 1,
				];
				$this->m_main->createIN('db_stok_opname_detail',$list);
				
				$data_produk = $this->m_main->getRow('db_produk','id_produk',$listProduk[$i]['id_produk']);
				$datup = [
					'stok_produk ' => floatval($data_produk['stok_produk']) + floatval($listProduk[$i]['jml_produk']),
					'tgl_edit' => date("Y-m-d H:i:s"),
				];
				$this->m_main->updateIN('db_produk','id_produk',$listProduk[$i]['id_produk'],$datup);
			}
			$output['message'] ="Stok opname produk berhasil ditambah!";
			$output['result'] = "success";
		}else{
			$output['message'] ="Data produk tidak boleh kosong!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function remove_stok_opname(){
		if(!empty($_POST['id_stok_opname'])){
			$data = [
				'alasan_hapus' => $_POST['alasan_hapus'],
				'status' => 0,
				'tgl_edit' => date("Y-m-d H:i:s"),
			];
			$this->m_main->updateIN('db_stok_opname','id_stok_opname',$_POST['id_stok_opname'],$data);
			$list = [
				'status' => 0,
			];
			$this->m_main->updateIN('db_stok_opname_detail','id_stok_opname',$_POST['id_stok_opname'],$list);
			$DTlist = $this->m_main->getResult('db_stok_opname_detail','id_stok_opname',$_POST['id_stok_opname']);
			foreach ($DTlist as $list) {
				$data_produk = $this->m_main->getRow('db_produk','id_produk',$list->id_produk);
				$datup = [
					'stok_produk ' => floatval($data_produk['stok_produk']) - floatval($list->jml_produk),
					'tgl_edit' => date("Y-m-d H:i:s"),
				];
				$this->m_main->updateIN('db_produk','id_produk',$list->id_produk,$datup);
			}
			$output['message'] = "Stok opname berhasil di hapus!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id transaksi tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}

}