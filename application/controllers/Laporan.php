<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Laporan extends CI_Controller {

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

	//================= PEMBAYARAN
	public function read_pendapatan_paket(){
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];
		$id_lokasi = $_POST['id_lokasi'];

		$laporan = $this->m_main->runQueryResult('
			SELECT a.*, b.nama_paket, c.nama_lokasi, e.nama_anggota, d.tipe_bayar,
			DATE_FORMAT(a.tgl_pembayaran,"%d\%m\%Y %H:%i:%s") as tanggal
			FROM db_pembayaran a
			JOIN db_paket_gym b ON a.id_paket_gym = b.id_paket_gym
			JOIN db_lokasi c ON a.id_lokasi = c.id_lokasi
			JOIN db_tipe_bayar d ON a.id_tipe_bayar = d.id_tipe_bayar
			JOIN db_anggota e ON a.id_anggota = e.id_anggota
			WHERE a.status = 1
			AND a.id_office = '.ID_OFFICE.'
            '.($id_lokasi != null ? 'AND a.id_lokasi = '.$id_lokasi : '').'
            AND DATE_FORMAT(a.tgl_pembayaran,"%Y-%m-%d") >= "'.$start_date.'" 
            AND DATE_FORMAT(a.tgl_pembayaran,"%Y-%m-%d") <= "'.$end_date.'"
			ORDER BY a.id_lokasi ASC, a.nonota DESC
		');
		$data = [];
		$bylok = [];
		$no = 0;
		foreach ($laporan as $list) {
			$no++;
			$row = [];
			$row['no'] = $no;
			$row['nama_lokasi'] = $list->nama_lokasi;
			$row['nonota'] = $list->nonota;
			$row['tanggal'] = $list->tanggal;
			$row['nama_anggota'] = $list->nama_anggota;
			$row['nama_paket'] = $list->nama_paket;
			$row['tipe_bayar'] = $list->tipe_bayar;
			$row['tarif'] = 'Rp '.number_format(intval($list->total_harga),0,',','.');
			$row['diskon'] = 'Rp '.number_format(intval($list->diskon_nominal),0,',','.');
			$row['ppn'] = 'Rp '.number_format(intval($list->ppn_nominal),0,',','.');
			$row['charge'] = 'Rp '.number_format(intval($list->charge_nominal),0,',','.');
			$row['total'] = 'Rp '.number_format(intval($list->total_transaksi),0,',','.');
			$data[] = $row;
			
			if(!array_key_exists($list->id_lokasi, $bylok)){
				$bylok[$list->id_lokasi]['nama_lokasi'] = $list->nama_lokasi;
				$bylok[$list->id_lokasi]['jumlah'] = 1;
				$bylok[$list->id_lokasi]['tarif'] = $list->total_harga;
				$bylok[$list->id_lokasi]['diskon'] = $list->diskon_nominal;
				$bylok[$list->id_lokasi]['ppn'] = $list->ppn_nominal;
				$bylok[$list->id_lokasi]['charge'] = $list->charge_nominal;
				$bylok[$list->id_lokasi]['total'] = $list->total_transaksi;
			}else{
				$bylok[$list->id_lokasi]['jumlah'] += 1;
				$bylok[$list->id_lokasi]['tarif'] += $list->total_harga;
				$bylok[$list->id_lokasi]['diskon'] += $list->diskon_nominal;
				$bylok[$list->id_lokasi]['ppn'] += $list->ppn_nominal;
				$bylok[$list->id_lokasi]['charge'] += $list->charge_nominal;
				$bylok[$list->id_lokasi]['total'] += $list->total_transaksi;
			}
		}

		$summary = [];
		$cek_lok = 0;
		$t_jumlah = 0;
		$t_tarif = 0;
		$t_diskon = 0;
		$t_ppn = 0;
		$t_charge = 0;
		$t_total = 0;
		foreach($bylok as $list){
			$cek_lok++;
			$sum = [];
			$sum['nama_lokasi'] = $list['nama_lokasi'];
			$sum['jumlah'] = number_format(intval($list['jumlah']),0,',','.');
			$sum['tarif'] = 'Rp '.number_format(intval($list['tarif']),0,',','.');
			$sum['diskon'] = 'Rp '.number_format(intval($list['diskon']),0,',','.');
			$sum['ppn'] = 'Rp '.number_format(intval($list['ppn']),0,',','.');
			$sum['charge'] = 'Rp '.number_format(intval($list['charge']),0,',','.');
			$sum['total'] = 'Rp '.number_format(intval($list['total']),0,',','.');
			$summary[] = $sum;

			$t_jumlah += $list['jumlah'];
			$t_tarif += $list['tarif'];
			$t_diskon += $list['diskon'];
			$t_ppn += $list['ppn'];
			$t_charge += $list['charge'];
			$t_total += $list['total'];
		}
		if($cek_lok > 1){
			$sum = [];
			$sum['nama_lokasi'] = "Total Seluruh Lokasi";
			$sum['jumlah'] = number_format(intval($t_jumlah),0,',','.');
			$sum['tarif'] = 'Rp '.number_format(intval($t_tarif),0,',','.');
			$sum['diskon'] = 'Rp '.number_format(intval($t_diskon),0,',','.');
			$sum['ppn'] = 'Rp '.number_format(intval($t_ppn),0,',','.');
			$sum['charge'] = 'Rp '.number_format(intval($t_charge),0,',','.');
			$sum['total'] = 'Rp '.number_format(intval($t_total),0,',','.');
			$summary[] = $sum;
		}
		
		$output = [
			"data" => $data,
			"summary" => $summary,
			"tanggal" => date_format(date_create($start_date),"d F Y").' - '.date_format(date_create($end_date),"d F Y"),
		];
		echo json_encode($output);
	}

	public function read_rekap_total_paket(){
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];
		$id_lokasi = $_POST['id_lokasi'];

		$laporan = $this->m_main->runQueryResult('
			SELECT a.id_lokasi, b.nama_paket, c.nama_lokasi,
			COUNT(*) as jumlah, 
			SUM(a.total_harga) as tarif, 
			SUM(a.total_transaksi) as total, 
			SUM(a.diskon_nominal) as diskon,
			SUM(a.ppn_nominal) as ppn,
			SUM(a.charge_nominal) as charge
			FROM db_pembayaran a
			JOIN db_paket_gym b ON a.id_paket_gym = b.id_paket_gym
			JOIN db_lokasi c ON a.id_lokasi = c.id_lokasi
			WHERE a.status = 1
			AND a.id_office = '.ID_OFFICE.'
            '.($id_lokasi != null ? 'AND a.id_lokasi = '.$id_lokasi : '').'
            AND DATE_FORMAT(a.tgl_pembayaran,"%Y-%m-%d") >= "'.$start_date.'" 
            AND DATE_FORMAT(a.tgl_pembayaran,"%Y-%m-%d") <= "'.$end_date.'"
			GROUP BY a.id_lokasi, b.id_paket_gym
			ORDER BY a.id_lokasi ASC, jumlah DESC, b.nama_paket ASC
		');
		$data = [];
		$bylok = [];
		$no = 0;
		foreach ($laporan as $list) {
			$no++;
			$row = [];
			$row['no'] = $no;
			$row['nama_lokasi'] = $list->nama_lokasi;
			$row['nama_paket'] = $list->nama_paket;
			$row['jumlah'] = number_format(intval($list->jumlah),0,',','.');
			$row['tarif'] = 'Rp '.number_format(intval($list->tarif),0,',','.');
			$row['diskon'] = 'Rp '.number_format(intval($list->diskon),0,',','.');
			$row['ppn'] = 'Rp '.number_format(intval($list->ppn),0,',','.');
			$row['charge'] = 'Rp '.number_format(intval($list->charge),0,',','.');
			$row['total'] = 'Rp '.number_format(intval($list->total),0,',','.');
			$data[] = $row;
			
			if(!array_key_exists($list->id_lokasi, $bylok)){
				$bylok[$list->id_lokasi]['nama_lokasi'] = $list->nama_lokasi;
				$bylok[$list->id_lokasi]['jumlah'] = $list->jumlah;
				$bylok[$list->id_lokasi]['tarif'] = $list->tarif;
				$bylok[$list->id_lokasi]['diskon'] = $list->diskon;
				$bylok[$list->id_lokasi]['ppn'] = $list->ppn;
				$bylok[$list->id_lokasi]['charge'] = $list->charge;
				$bylok[$list->id_lokasi]['total'] = $list->total;
			}else{
				$bylok[$list->id_lokasi]['jumlah'] += $list->jumlah;
				$bylok[$list->id_lokasi]['tarif'] += $list->tarif;
				$bylok[$list->id_lokasi]['diskon'] += $list->diskon;
				$bylok[$list->id_lokasi]['ppn'] += $list->ppn;
				$bylok[$list->id_lokasi]['charge'] += $list->charge;
				$bylok[$list->id_lokasi]['total'] += $list->total;
			}
		}

		$summary = [];
		$cek_lok = 0;
		$t_jumlah = 0;
		$t_tarif = 0;
		$t_diskon = 0;
		$t_ppn = 0;
		$t_charge = 0;
		$t_total = 0;
		foreach($bylok as $list){
			$cek_lok++;
			$sum = [];
			$sum['nama_lokasi'] = $list['nama_lokasi'];
			$sum['jumlah'] = number_format(intval($list['jumlah']),0,',','.');
			$sum['tarif'] = 'Rp '.number_format(intval($list['tarif']),0,',','.');
			$sum['diskon'] = 'Rp '.number_format(intval($list['diskon']),0,',','.');
			$sum['ppn'] = 'Rp '.number_format(intval($list['ppn']),0,',','.');
			$sum['charge'] = 'Rp '.number_format(intval($list['charge']),0,',','.');
			$sum['total'] = 'Rp '.number_format(intval($list['total']),0,',','.');
			$summary[] = $sum;

			$t_jumlah += $list['jumlah'];
			$t_tarif += $list['tarif'];
			$t_diskon += $list['diskon'];
			$t_ppn += $list['ppn'];
			$t_charge += $list['charge'];
			$t_total += $list['total'];
		}
		if($cek_lok > 1){
			$sum = [];
			$sum['nama_lokasi'] = "Total Seluruh Lokasi";
			$sum['jumlah'] = number_format(intval($t_jumlah),0,',','.');
			$sum['tarif'] = 'Rp '.number_format(intval($t_tarif),0,',','.');
			$sum['diskon'] = 'Rp '.number_format(intval($t_diskon),0,',','.');
			$sum['ppn'] = 'Rp '.number_format(intval($t_ppn),0,',','.');
			$sum['charge'] = 'Rp '.number_format(intval($t_charge),0,',','.');
			$sum['total'] = 'Rp '.number_format(intval($t_total),0,',','.');
			$summary[] = $sum;
		}
		
		$output = [
			"data" => $data,
			"summary" => $summary,
			"tanggal" => date_format(date_create($start_date),"d F Y").' - '.date_format(date_create($end_date),"d F Y"),
		];
		echo json_encode($output);
	}

	public function read_rekap_kasir_paket(){
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];
		$id_lokasi = $_POST['id_lokasi'];
		
		$transaksi = $this->m_main->runQueryRow('
			SELECT 
				SUM(total_harga) as tarif, 
				SUM(total_transaksi) as total, 
				SUM(diskon_nominal) as diskon,
				SUM(ppn_nominal) as ppn,
				SUM(charge_nominal) as charge
			FROM db_pembayaran
			WHERE status = 1
			AND id_office = '.ID_OFFICE.'
            '.($id_lokasi != null ? 'AND id_lokasi = '.$id_lokasi : '').'
            AND DATE_FORMAT(tgl_pembayaran,"%Y-%m-%d") >= "'.$start_date.'" 
            AND DATE_FORMAT(tgl_pembayaran,"%Y-%m-%d") <= "'.$end_date.'"
		');
		
		$batal_nota = $this->m_main->runQueryRow('
			SELECT SUM(total_transaksi) as batal_nota
			FROM db_pembayaran
			WHERE status = 0
			AND id_office = '.ID_OFFICE.'
			'.($id_lokasi != null ? 'AND id_lokasi = '.$id_lokasi : '').'
			AND DATE_FORMAT(tgl_pembayaran,"%Y-%m-%d") >= "'.$start_date.'" 
			AND DATE_FORMAT(tgl_pembayaran,"%Y-%m-%d") <= "'.$end_date.'"
		');
		
		$data = [];
		$row = [];
		$row['deskripsi'] = 'Total Harga';
		$row['amount'] = 'Rp '.number_format(intval($transaksi ? $transaksi['tarif'] : 0),0,',','.');
		$data[] = $row;
		$row['deskripsi'] = 'Total Diskon';
		$row['amount'] = 'Rp '.number_format(intval($transaksi ? $transaksi['diskon'] : 0),0,',','.');
		$data[] = $row;
		$row['deskripsi'] = 'Total PPN';
		$row['amount'] = 'Rp '.number_format(intval($transaksi ? $transaksi['ppn'] : 0),0,',','.');
		$data[] = $row;
		$row['deskripsi'] = 'Total Charge';
		$row['amount'] = 'Rp '.number_format(intval($transaksi ? $transaksi['charge'] : 0),0,',','.');
		$data[] = $row;
		$row['deskripsi'] = '<b>Total Transaksi Bersih</b>';
		$row['amount'] = '<b>Rp '.number_format(intval($transaksi ? $transaksi['total'] : 0),0,',','.').'</b>';
		$data[] = $row;
		$jenis_bayar = $this->m_main->getResult('db_tipe_bayar','status','1');
		foreach ($jenis_bayar as $list) {
			$tipe = $this->m_main->runQueryRow('
				SELECT SUM(total_transaksi) as total
				FROM db_pembayaran
				WHERE status = 1
				AND id_office = '.ID_OFFICE.'
				AND id_tipe_bayar = '.$list->id_tipe_bayar.'
				'.($id_lokasi != null ? 'AND id_lokasi = '.$id_lokasi : '').'
				AND DATE_FORMAT(tgl_pembayaran,"%Y-%m-%d") >= "'.$start_date.'" 
				AND DATE_FORMAT(tgl_pembayaran,"%Y-%m-%d") <= "'.$end_date.'"
			');
			$row['deskripsi'] = 'Total '.$list->tipe_bayar;
			$row['amount'] = 'Rp '.number_format(intval($tipe ? $tipe['total'] : 0),0,',','.');
			$data[] = $row;
		}
		$row['deskripsi'] = 'Total Batal Nota';
		$row['amount'] = 'Rp '.number_format(intval($batal_nota ? $batal_nota['batal_nota'] : 0),0,',','.');
		$data[] = $row;


		echo json_encode($data);
	}

	//================= PENJUALAN
	public function read_pendapatan_produk(){
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];
		$id_lokasi = $_POST['id_lokasi'];

		$laporan = $this->m_main->runQueryResult('
			SELECT c.nama_lokasi, d.tipe_bayar, b.nonota, b.id_lokasi,
			(b.total_harga + SUM(a.diskon_nominal_item)) as total_harga, 
			SUM(a.diskon_nominal_item) as diskon_produk, 
			b.diskon_nominal as diskon_transaksi, 
			b.ppn_nominal, b.charge_nominal, b.total_transaksi,
			DATE_FORMAT(b.tgl_penjualan,"%d\%m\%Y %H:%i:%s") as tanggal
			FROM db_penjualan_item a
			JOIN db_penjualan b ON a.id_penjualan = b.id_penjualan
			JOIN db_lokasi c ON b.id_lokasi = c.id_lokasi
			JOIN db_tipe_bayar d ON b.id_tipe_bayar = d.id_tipe_bayar
			WHERE a.status = 1
			AND b.status = 1
			AND b.id_office = '.ID_OFFICE.'
            '.($id_lokasi != null ? 'AND b.id_lokasi = '.$id_lokasi : '').'
            AND DATE_FORMAT(b.tgl_penjualan,"%Y-%m-%d") >= "'.$start_date.'" 
            AND DATE_FORMAT(b.tgl_penjualan,"%Y-%m-%d") <= "'.$end_date.'"
			GROUP BY a.id_penjualan
			ORDER BY b.id_lokasi ASC, b.nonota DESC
		');
		$data = [];
		$bylok = [];
		$no = 0;
		foreach ($laporan as $list) {
			$no++;
			$row = [];
			$row['no'] = $no;
			$row['nama_lokasi'] = $list->nama_lokasi;
			$row['nonota'] = $list->nonota;
			$row['tanggal'] = $list->tanggal;
			$row['tipe_bayar'] = $list->tipe_bayar;
			$row['harga'] = 'Rp '.number_format(intval($list->total_harga),0,',','.');
			$row['diskon_produk'] = 'Rp '.number_format(intval($list->diskon_produk),0,',','.');
			$row['diskon_transaksi'] = 'Rp '.number_format(intval($list->diskon_transaksi),0,',','.');
			$row['ppn'] = 'Rp '.number_format(intval($list->ppn_nominal),0,',','.');
			$row['charge'] = 'Rp '.number_format(intval($list->charge_nominal),0,',','.');
			$row['total'] = 'Rp '.number_format(intval($list->total_transaksi),0,',','.');
			$data[] = $row;
			
			if(!array_key_exists($list->id_lokasi, $bylok)){
				$bylok[$list->id_lokasi]['nama_lokasi'] = $list->nama_lokasi;
				$bylok[$list->id_lokasi]['jumlah'] = 1;
				$bylok[$list->id_lokasi]['harga'] = $list->total_harga;
				$bylok[$list->id_lokasi]['diskon_produk'] = $list->diskon_produk;
				$bylok[$list->id_lokasi]['diskon_transaksi'] = $list->diskon_transaksi;
				$bylok[$list->id_lokasi]['ppn'] = $list->ppn_nominal;
				$bylok[$list->id_lokasi]['charge'] = $list->charge_nominal;
				$bylok[$list->id_lokasi]['total'] = $list->total_transaksi;
			}else{
				$bylok[$list->id_lokasi]['jumlah'] += 1;
				$bylok[$list->id_lokasi]['harga'] += $list->total_harga;
				$bylok[$list->id_lokasi]['diskon_produk'] += $list->diskon_produk;
				$bylok[$list->id_lokasi]['diskon_transaksi'] += $list->diskon_transaksi;
				$bylok[$list->id_lokasi]['ppn'] += $list->ppn_nominal;
				$bylok[$list->id_lokasi]['charge'] += $list->charge_nominal;
				$bylok[$list->id_lokasi]['total'] += $list->total_transaksi;
			}
		}

		$summary = [];
		$cek_lok = 0;
		$t_jumlah = 0;
		$t_harga = 0;
		$t_diskon_produk = 0;
		$t_diskon_transaksi = 0;
		$t_ppn = 0;
		$t_charge = 0;
		$t_total = 0;
		foreach($bylok as $list){
			$cek_lok++;
			$sum = [];
			$sum['nama_lokasi'] = $list['nama_lokasi'];
			$sum['jumlah'] = number_format(intval($list['jumlah']),0,',','.');
			$sum['harga'] = 'Rp '.number_format(intval($list['harga']),0,',','.');
			$sum['diskon_produk'] = 'Rp '.number_format(intval($list['diskon_produk']),0,',','.');
			$sum['diskon_transaksi'] = 'Rp '.number_format(intval($list['diskon_transaksi']),0,',','.');
			$sum['ppn'] = 'Rp '.number_format(intval($list['ppn']),0,',','.');
			$sum['charge'] = 'Rp '.number_format(intval($list['charge']),0,',','.');
			$sum['total'] = 'Rp '.number_format(intval($list['total']),0,',','.');
			$summary[] = $sum;

			$t_jumlah += $list['jumlah'];
			$t_harga += $list['harga'];
			$t_diskon_produk += $list['diskon_produk'];
			$t_diskon_transaksi += $list['diskon_transaksi'];
			$t_ppn += $list['ppn'];
			$t_charge += $list['charge'];
			$t_total += $list['total'];
		}
		if($cek_lok > 1){
			$sum = [];
			$sum['nama_lokasi'] = "Total Seluruh Lokasi";
			$sum['jumlah'] = number_format(intval($t_jumlah),0,',','.');
			$sum['harga'] = 'Rp '.number_format(intval($t_harga),0,',','.');
			$sum['diskon_produk'] = 'Rp '.number_format(intval($t_diskon_produk),0,',','.');
			$sum['diskon_transaksi'] = 'Rp '.number_format(intval($t_diskon_transaksi),0,',','.');
			$sum['ppn'] = 'Rp '.number_format(intval($t_ppn),0,',','.');
			$sum['charge'] = 'Rp '.number_format(intval($t_charge),0,',','.');
			$sum['total'] = 'Rp '.number_format(intval($t_total),0,',','.');
			$summary[] = $sum;
		}
		
		$output = [
			"data" => $data,
			"summary" => $summary,
			"tanggal" => date_format(date_create($start_date),"d F Y").' - '.date_format(date_create($end_date),"d F Y"),
		];
		echo json_encode($output);
	}

	public function read_rekap_total_produk(){
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];
		$id_lokasi = $_POST['id_lokasi'];

		$laporan = $this->m_main->runQueryResult('
			SELECT b.id_lokasi, c.nama_lokasi, d.nama_produk,
			SUM(a.jml_produk_item) as jumlah,
			SUM(a.subtotal_harga_item + a.diskon_nominal_item) as harga,
			SUM(a.diskon_nominal_item) as diskon_produk,
			SUM(a.subtotal_harga_item * b.diskon_persen / 100) as diskon_transaksi,
			SUM(a.subtotal_harga_item * b.ppn_persen / 100) as ppn,
			SUM(a.subtotal_harga_item * b.charge_persen / 100) as charge,
			SUM(a.subtotal_harga_item - 
				(a.subtotal_harga_item * b.diskon_persen / 100) + 
				(a.subtotal_harga_item * b.ppn_persen / 100) + 
				(a.subtotal_harga_item * b.charge_persen / 100)) as total
			FROM db_penjualan_item a
			JOIN db_penjualan b ON a.id_penjualan = b.id_penjualan
			JOIN db_lokasi c ON b.id_lokasi = c.id_lokasi
			JOIN db_produk d ON a.id_produk = d.id_produk
			WHERE a.status = 1
			AND b.status = 1
			AND b.id_office = '.ID_OFFICE.'
			'.($id_lokasi != null ? 'AND b.id_lokasi = '.$id_lokasi : '').'
			AND DATE_FORMAT(b.tgl_penjualan,"%Y-%m-%d") >= "'.$start_date.'" 
			AND DATE_FORMAT(b.tgl_penjualan,"%Y-%m-%d") <= "'.$end_date.'"
			GROUP BY b.id_lokasi, a.id_produk 
			ORDER BY b.id_lokasi ASC, jumlah DESC, d.nama_produk ASC
		');
		$data = [];
		$bylok = [];
		$no = 0;
		foreach ($laporan as $list) {
			$no++;
			$row = [];
			$row['no'] = $no;
			$row['nama_lokasi'] = $list->nama_lokasi;
			$row['nama_produk'] = $list->nama_produk;
			$row['jumlah'] = number_format(intval($list->jumlah),0,',','.');
			$row['harga'] = 'Rp '.number_format(intval($list->harga),0,',','.');
			$row['diskon_produk'] = 'Rp '.number_format(intval($list->diskon_produk),0,',','.');
			$row['diskon_transaksi'] = 'Rp '.number_format(intval($list->diskon_transaksi),0,',','.');
			$row['ppn'] = 'Rp '.number_format(intval($list->ppn),0,',','.');
			$row['charge'] = 'Rp '.number_format(intval($list->charge),0,',','.');
			$row['total'] = 'Rp '.number_format(intval($list->total),0,',','.');
			$data[] = $row;
			
			if(!array_key_exists($list->id_lokasi, $bylok)){
				$bylok[$list->id_lokasi]['nama_lokasi'] = $list->nama_lokasi;
				$bylok[$list->id_lokasi]['jumlah'] = $list->jumlah;
				$bylok[$list->id_lokasi]['harga'] = $list->harga;
				$bylok[$list->id_lokasi]['diskon_produk'] = $list->diskon_produk;
				$bylok[$list->id_lokasi]['diskon_transaksi'] = $list->diskon_transaksi;
				$bylok[$list->id_lokasi]['ppn'] = $list->ppn;
				$bylok[$list->id_lokasi]['charge'] = $list->charge;
				$bylok[$list->id_lokasi]['total'] = $list->total;
			}else{
				$bylok[$list->id_lokasi]['jumlah'] += $list->jumlah;
				$bylok[$list->id_lokasi]['harga'] += $list->harga;
				$bylok[$list->id_lokasi]['diskon_produk'] += $list->diskon_produk;
				$bylok[$list->id_lokasi]['diskon_transaksi'] += $list->diskon_transaksi;
				$bylok[$list->id_lokasi]['ppn'] += $list->ppn;
				$bylok[$list->id_lokasi]['charge'] += $list->charge;
				$bylok[$list->id_lokasi]['total'] += $list->total;
			}
		}

		$summary = [];
		$cek_lok = 0;
		$t_jumlah = 0;
		$t_harga = 0;
		$t_diskon_produk = 0;
		$t_diskon_transaksi = 0;
		$t_ppn = 0;
		$t_charge = 0;
		$t_total = 0;
		foreach($bylok as $list){
			$cek_lok++;
			$sum = [];
			$sum['nama_lokasi'] = $list['nama_lokasi'];
			$sum['jumlah'] = number_format(intval($list['jumlah']),0,',','.');
			$sum['harga'] = 'Rp '.number_format(intval($list['harga']),0,',','.');
			$sum['diskon_produk'] = 'Rp '.number_format(intval($list['diskon_produk']),0,',','.');
			$sum['diskon_transaksi'] = 'Rp '.number_format(intval($list['diskon_transaksi']),0,',','.');
			$sum['ppn'] = 'Rp '.number_format(intval($list['ppn']),0,',','.');
			$sum['charge'] = 'Rp '.number_format(intval($list['charge']),0,',','.');
			$sum['total'] = 'Rp '.number_format(intval($list['total']),0,',','.');
			$summary[] = $sum;

			$t_jumlah += $list['jumlah'];
			$t_harga += $list['harga'];
			$t_diskon_produk += $list['diskon_produk'];
			$t_diskon_transaksi += $list['diskon_transaksi'];
			$t_ppn += $list['ppn'];
			$t_charge += $list['charge'];
			$t_total += $list['total'];
		}
		if($cek_lok > 1){
			$sum = [];
			$sum['nama_lokasi'] = "Total Seluruh Lokasi";
			$sum['jumlah'] = number_format(intval($t_jumlah),0,',','.');
			$sum['harga'] = 'Rp '.number_format(intval($t_harga),0,',','.');
			$sum['diskon_produk'] = 'Rp '.number_format(intval($t_diskon_produk),0,',','.');
			$sum['diskon_transaksi'] = 'Rp '.number_format(intval($t_diskon_transaksi),0,',','.');
			$sum['ppn'] = 'Rp '.number_format(intval($t_ppn),0,',','.');
			$sum['charge'] = 'Rp '.number_format(intval($t_charge),0,',','.');
			$sum['total'] = 'Rp '.number_format(intval($t_total),0,',','.');
			$summary[] = $sum;
		}
		
		$output = [
			"data" => $data,
			"summary" => $summary,
			"tanggal" => date_format(date_create($start_date),"d F Y").' - '.date_format(date_create($end_date),"d F Y"),
		];
		echo json_encode($output);
	}

	public function read_rekap_kasir_produk(){
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];
		$id_lokasi = $_POST['id_lokasi'];
		
		$transaksi = $this->m_main->runQueryRow('
			SELECT 
			SUM(x.total_harga) as total_harga, 
			SUM(x.diskon_produk) as diskon_produk, 
			SUM(x.diskon_transaksi) as diskon_transaksi, 
			SUM(x.ppn_nominal) as ppn_nominal, 
			SUM(x.charge_nominal) as charge_nominal, 
			SUM(x.total_transaksi) as total_transaksi
			FROM (
				SELECT 
				(b.total_harga + SUM(a.diskon_nominal_item)) as total_harga, 
				SUM(a.diskon_nominal_item) as diskon_produk, 
				b.diskon_nominal as diskon_transaksi, 
				b.ppn_nominal, b.charge_nominal, b.total_transaksi
				FROM db_penjualan_item a
				JOIN db_penjualan b ON a.id_penjualan = b.id_penjualan
				WHERE a.status = 1
				AND b.status = 1
				AND b.id_office = '.ID_OFFICE.'
				'.($id_lokasi != null ? 'AND b.id_lokasi = '.$id_lokasi : '').'
				AND DATE_FORMAT(b.tgl_penjualan,"%Y-%m-%d") >= "'.$start_date.'" 
				AND DATE_FORMAT(b.tgl_penjualan,"%Y-%m-%d") <= "'.$end_date.'"
				GROUP BY b.id_penjualan
			) x;
		');
		
		$batal_nota = $this->m_main->runQueryRow('
			SELECT SUM(total_transaksi) as batal_nota
			FROM db_penjualan
			WHERE status = 0
			AND id_office = '.ID_OFFICE.'
			'.($id_lokasi != null ? 'AND id_lokasi = '.$id_lokasi : '').'
			AND DATE_FORMAT(tgl_penjualan,"%Y-%m-%d") >= "'.$start_date.'" 
			AND DATE_FORMAT(tgl_penjualan,"%Y-%m-%d") <= "'.$end_date.'"
		');
		
		$data = [];
		$row = [];
		$row['deskripsi'] = 'Total Harga';
		$row['amount'] = 'Rp '.number_format(intval($transaksi ? $transaksi['total_harga'] : 0),0,',','.');
		$data[] = $row;
		$row['deskripsi'] = 'Total Diskon Produk';
		$row['amount'] = 'Rp '.number_format(intval($transaksi ? $transaksi['diskon_produk'] : 0),0,',','.');
		$data[] = $row;
		$row['deskripsi'] = 'Total Diskon Transaksi';
		$row['amount'] = 'Rp '.number_format(intval($transaksi ? $transaksi['diskon_transaksi'] : 0),0,',','.');
		$data[] = $row;
		$row['deskripsi'] = 'Total PPN';
		$row['amount'] = 'Rp '.number_format(intval($transaksi ? $transaksi['ppn_nominal'] : 0),0,',','.');
		$data[] = $row;
		$row['deskripsi'] = 'Total Charge';
		$row['amount'] = 'Rp '.number_format(intval($transaksi ? $transaksi['charge_nominal'] : 0),0,',','.');
		$data[] = $row;
		$row['deskripsi'] = '<b>Total Transaksi Bersih</b>';
		$row['amount'] = '<b>Rp '.number_format(intval($transaksi ? $transaksi['total_transaksi'] : 0),0,',','.').'</b>';
		$data[] = $row;
		$jenis_bayar = $this->m_main->getResult('db_tipe_bayar','status','1');
		foreach ($jenis_bayar as $list) {
			$tipe = $this->m_main->runQueryRow('
				SELECT SUM(total_transaksi) as total
				FROM db_penjualan
				WHERE status = 1
				AND id_office = '.ID_OFFICE.'
				AND id_tipe_bayar = '.$list->id_tipe_bayar.'
				'.($id_lokasi != null ? 'AND id_lokasi = '.$id_lokasi : '').'
				AND DATE_FORMAT(tgl_penjualan,"%Y-%m-%d") >= "'.$start_date.'" 
				AND DATE_FORMAT(tgl_penjualan,"%Y-%m-%d") <= "'.$end_date.'"
			');
			$row['deskripsi'] = 'Total '.$list->tipe_bayar;
			$row['amount'] = 'Rp '.number_format(intval($tipe ? $tipe['total'] : 0),0,',','.');
			$data[] = $row;
		}
		$row['deskripsi'] = 'Total Batal Nota';
		$row['amount'] = 'Rp '.number_format(intval($batal_nota ? $batal_nota['batal_nota'] : 0),0,',','.');
		$data[] = $row;


		echo json_encode($data);
	}

}