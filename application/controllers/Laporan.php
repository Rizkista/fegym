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

	//================= REKAP TOTAL PAKET
	public function read_rekap_total_paket(){
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];
		$id_lokasi = $_POST['id_lokasi'];

		$laporan = $this->m_main->runQueryResult('
			SELECT a.id_lokasi, b.nama_paket, c.nama_lokasi,
			COUNT(*) as jumlah, 
			SUM(a.total_harga) as tarif, 
			SUM(a.total_transaksi) as total, 
			SUM(diskon_nominal) as diskon,
			SUM(ppn_nominal) as ppn,
			SUM(charge_nominal) as charge
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

}