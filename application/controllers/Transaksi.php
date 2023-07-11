<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Transaksi extends CI_Controller {

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

	public function read_penjualan(){
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];
		$status = $_POST['status'];
		$id_lokasi = ID_POSISI == 3 ? ID_LOKASI : $_POST['id_lokasi'];
		$penjualan = $this->m_auth->getDataPenjualan($start_date,$end_date,$status,$id_lokasi,ID_OFFICE);
		$data = [];
		$no = 0;
		foreach ($penjualan as $list) {
			$no++;
			$row = [];
			$row['no'] = $no;
			$row['date_format'] = date('d-m-Y H:i:s',strtotime($list->tgl_penjualan));
			$row['nonota'] = $list->nonota;
			$row['diskon'] = $list->diskon_nominal;
			$row['ppn'] = $list->ppn_nominal;
			$row['charge'] = $list->charge_nominal;
			$row['total_transaksi'] = $list->total_transaksi;
			$row['alasan_hapus'] = $list->alasan_hapus;
			$row['nama_item'] = str_replace('   ,','<br>',$list->nama_item);
			$row['jml_item'] = str_replace(',','<br>',$list->jml_item);
			$row['diskon_item'] = str_replace(',','<br>',$list->diskon_item);
			$row['harga_item'] = str_replace(',','<br>',$list->harga_item);
			$row['aksi'] = $list->id_penjualan;
			$data[] = $row; 
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}
	
	public function list_penjualan(){
		$id_penjualan = $_POST['id_penjualan'];
		$output = [ 
			"db_penjualan" =>  $this->m_main->runQueryRow("
				SELECT a.*, b.nama as operator, c.tipe_bayar,
				d.nota_logo, d.nota_header, d.nota_footer,
				DATE_FORMAT(a.tgl_penjualan,'%d-%m-%Y') as tanggal, 
				DATE_FORMAT(a.tgl_penjualan,'%H:%i:%s') as waktu
				FROM db_penjualan a 
				JOIN db_account b ON a.id_account = b.id_account
				JOIN db_tipe_bayar c ON a.id_tipe_bayar = c.id_tipe_bayar
				JOIN db_office d ON a.id_office = d.id_office
				WHERE a.id_penjualan = ".$id_penjualan."
			"),
			"db_penjualan_item" =>  $this->m_main->runQueryResult("
				SELECT a.*, b.nama_produk
				FROM db_penjualan_item a 
				JOIN db_produk b ON a.id_produk = b.id_produk
				WHERE a.id_penjualan = ".$id_penjualan."
			"),
		];
		echo json_encode($output);

	}

	public function simpan_penjualan(){
		if(!empty($_POST['data_item'])){
			$id_lokasi = ID_POSISI == 3 ? ID_LOKASI : ($_POST['id_lokasi'] == 0 ? 1 : $_POST['id_lokasi']);
			$kode_lokasi = $this->m_main->getRow('db_lokasi','id_lokasi',$id_lokasi)['kode_lokasi'];
			$kode_nota = 'L'.$kode_lokasi.date('ymd').'-';
			$cek_nota = $this->m_main->runQueryRow('
				SELECT * 
				FROM db_penjualan 
				WHERE nonota LIKE "%'.$kode_nota.'%" 
				AND id_office = '.ID_OFFICE.' 
				ORDER BY nonota DESC
			');
			$last_nota = $cek_nota ? intval(str_replace($kode_nota,'',$cek_nota['nonota'])) : 0;
			$nonota = $kode_nota.($last_nota+1);
			$data = [
				'id_office' => ID_OFFICE,
				'id_lokasi' => $id_lokasi,
				'id_tipe_bayar' => $_POST['id_tipe_bayar'],
				'nonota' => $nonota,
				'total_harga' => $_POST['total_harga'],
				'diskon_persen' => $_POST['diskon_persen'],
				'diskon_nominal' => $_POST['diskon_nominal'],
				'ppn_persen' => $_POST['ppn_persen'],
				'ppn_nominal' => $_POST['ppn_nominal'],
				'charge_persen' => $_POST['charge_persen'],
				'charge_nominal' => $_POST['charge_nominal'],
				'total_transaksi' => $_POST['total_transaksi'],
				'dibayar' => $_POST['dibayar'],
				'kembalian' => $_POST['kembalian'],
				'tgl_penjualan' => date("Y-m-d H:i:s"),
				'tgl_input' => date("Y-m-d H:i:s"),
				'tgl_edit' => date("Y-m-d H:i:s"),
				'status' => 1,
				'id_account' => ID_ACCOUNT,
			];
			$id_penjualan  = $this->m_main->createIN('db_penjualan',$data)['result'];	
			$list_item = $_POST['data_item'];
			for($i=0; $i<count($list_item); $i++){
				$list = [
					'id_penjualan' => $id_penjualan,
					'id_produk' => $list_item[$i]['id_produk'],
					'harga_beli_item' => $list_item[$i]['harga_beli_item'],
					'harga_jual_item' => $list_item[$i]['harga_jual_item'],
					'jml_produk_item' => $list_item[$i]['jml_produk_item'],
					'diskon_persen_item' => $list_item[$i]['diskon_persen_item'],
					'diskon_nominal_item' => $list_item[$i]['diskon_nominal_item'],
					'subtotal_harga_item' => $list_item[$i]['subtotal_harga_item'],
					'status' => 1,
				];
				$this->m_main->createIN('db_penjualan_item',$list);
				
				$data_produk = $this->m_main->getRow('db_produk','id_produk',$list_item[$i]['id_produk']);
				$datup = [
					'stok_produk ' => floatval($data_produk['stok_produk']) - floatval($list_item[$i]['jml_produk_item']),
					'tgl_edit' => date("Y-m-d H:i:s"),
				];
				$this->m_main->updateIN('db_produk','id_produk',$list_item[$i]['id_produk'],$datup);
			}
			$output['detail'] = [
				'id_penjualan' => $id_penjualan,
				'nonota' => $nonota,
				'tanggal' => date("Y-m-d H:i:s"),
				'operator' => $this->m_main->getRow('db_account','id_account',ID_ACCOUNT)['nama'],
			];
			$output['message'] = "Data penjualan berhasil disimpan!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data produk tidak boleh kosong!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function remove_penjualan(){
		if(!empty($_POST['id_penjualan'])){
			$data = [
				'alasan_hapus' => $_POST['alasan_hapus'],
				'status' => 0,
				'tgl_edit' => date("Y-m-d H:i:s"),
			];
			$this->m_main->updateIN('db_penjualan','id_penjualan',$_POST['id_penjualan'],$data);
			$list = [
				'status' => 0,
			];
			$this->m_main->updateIN('db_penjualan_item','id_penjualan',$_POST['id_penjualan'],$list);
			$DTlist = $this->m_main->getResult('db_penjualan_item','id_penjualan',$_POST['id_penjualan']);
			foreach ($DTlist as $list) {
				$data_produk = $this->m_main->getRow('db_produk','id_produk',$list->id_produk);
				$datup = [
					'stok_produk ' => floatval($data_produk['stok_produk']) + floatval($list->jml_produk_item),
					'tgl_edit' => date("Y-m-d H:i:s"),
				];
				$this->m_main->updateIN('db_produk','id_produk',$list->id_produk,$datup);
			}
			$output['message'] = "Transaksi penjualan berhasil di hapus!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id transaksi tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}

}