<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Dashboard extends CI_Controller {
        
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

	public function informasi_anggota(){
		$total_anggota = $this->m_main->countData('db_anggota','status=1 AND id_office='.ID_OFFICE)['count'];
		$total_member = $this->m_main->countData('db_anggota','status=1 AND status_member=1 AND id_office='.ID_OFFICE)['count'];
		$member_baru = $this->m_main->countData('db_anggota','status=1 AND status_member=1 AND id_office='.ID_OFFICE.' AND DATE_FORMAT(tgl_member,"%Y-%m-%d")=CURDATE()')['count'];
		$member_expired = $this->m_main->countData('db_anggota','status=1 AND status_member=1 AND id_office='.ID_OFFICE.' AND DATE_FORMAT(tgl_expired,"%Y-%m-%d")<CURDATE()')['count'];
		
		$persen_total_anggota = $this->m_main->runQueryRow('
			SELECT TRUNCATE((((day.today-day.yesterday)/day.yesterday)*100),1) as persen
			FROM (
				SELECT 
				(
					SELECT COUNT(*) 
					FROM db_anggota 
					WHERE status = 1
					AND id_office = '.ID_OFFICE.'
					AND DATE_FORMAT(tgl_input,"%Y-%m-%d") = (CURDATE() - INTERVAL 1 DAY)
				) as yesterday, 
				(
					SELECT COUNT(*) 
					FROM db_anggota 
					WHERE status = 1
					AND id_office = '.ID_OFFICE.'
					AND DATE_FORMAT(tgl_input,"%Y-%m-%d") = CURDATE()
				) as today
			) day
		')['persen'];
		$persen_total_member = $this->m_main->runQueryRow('
			SELECT TRUNCATE((((day.today-day.yesterday)/day.yesterday)*100),1) as persen
			FROM (
				SELECT 
				(
					SELECT COUNT(*) 
					FROM db_anggota 
					WHERE status = 1
					AND status_member = 1
					AND id_office = '.ID_OFFICE.'
					AND DATE_FORMAT(tgl_input,"%Y-%m-%d") = (CURDATE() - INTERVAL 1 DAY)
				) as yesterday, 
				(
					SELECT COUNT(*) 
					FROM db_anggota 
					WHERE status = 1
					AND status_member = 1
					AND id_office = '.ID_OFFICE.'
					AND DATE_FORMAT(tgl_input,"%Y-%m-%d") = CURDATE()
				) as today
			) day
		')['persen'];
		$persen_member_baru = $this->m_main->runQueryRow('
			SELECT TRUNCATE((((day.today-day.yesterday)/day.yesterday)*100),1) as persen
			FROM (
				SELECT 
				(
					SELECT COUNT(*) 
					FROM db_anggota 
					WHERE status = 1
					AND status_member = 1
					AND id_office = '.ID_OFFICE.'
					AND DATE_FORMAT(tgl_member,"%Y-%m-%d") = (CURDATE() - INTERVAL 1 DAY)
				) as yesterday, 
				(
					SELECT COUNT(*) 
					FROM db_anggota 
					WHERE status = 1
					AND status_member = 1
					AND id_office = '.ID_OFFICE.'
					AND DATE_FORMAT(tgl_member,"%Y-%m-%d") = CURDATE()
				) as today
			) day
		')['persen'];
		$persen_member_expired = $this->m_main->runQueryRow('
			SELECT TRUNCATE((((day.today-day.yesterday)/day.yesterday)*100),1) as persen
			FROM (
				SELECT 
				(
					SELECT COUNT(*) 
					FROM db_anggota 
					WHERE status = 1
					AND status_member = 1
					AND id_office = '.ID_OFFICE.'
					AND DATE_FORMAT(tgl_expired,"%Y-%m-%d") < (CURDATE() - INTERVAL 1 DAY)
				) as yesterday, 
				(
					SELECT COUNT(*) 
					FROM db_anggota 
					WHERE status = 1
					AND status_member = 1
					AND id_office = '.ID_OFFICE.'
					AND DATE_FORMAT(tgl_expired,"%Y-%m-%d") < CURDATE()
				) as today
			) day
		')['persen'];

		$output = array(
			"total_anggota" => number_format($total_anggota,0,',','.'),
			"total_member" => number_format($total_member,0,',','.'),
			"member_baru" => number_format($member_baru,0,',','.'),
			"member_expired" => number_format($member_expired,0,',','.'),
			"persen_total_anggota" => floatval($persen_total_anggota),
			"persen_total_member" => floatval($persen_total_member),
			"persen_member_baru" => floatval($persen_member_baru),
			"persen_member_expired" => floatval($persen_member_expired),
		);
		echo json_encode($output);
		exit();
	}

	public function grafik_statistik_pendaftaran(){
		$month = $_POST['month'];
		$years = $_POST['year'];
		$jumtanggal = cal_days_in_month(CAL_GREGORIAN,$month,$years);
		$data_morris = array();
		for($i=1; $i <= $jumtanggal; $i++){
			$tanggal = date('Y-m-d', mktime(0,0,0,$month,$i,$years));
			$rows = [];
			$rows['TGL'] = date('d M Y', mktime(0,0,0,$month,$i,$years));
			$rows['L'] = $this->m_main->countData('db_anggota','status=1 AND gender_anggota="L" AND id_office='.ID_OFFICE.' AND DATE_FORMAT(tgl_input,"%Y-%m-%d")= '.'"'.$tanggal.'"')['count'];
			$rows['P'] = $this->m_main->countData('db_anggota','status=1 AND gender_anggota="P" AND id_office='.ID_OFFICE.' AND DATE_FORMAT(tgl_input,"%Y-%m-%d")= '.'"'.$tanggal.'"')['count'];
			$data_morris[] =  $rows;
		}
		echo json_encode($data_morris);
		exit();
	}

	public function grafik_pembayaran(){
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];
		$id_lokasi = $_POST['lokasi'];
		$tipe = $_POST['tipe'];

		$pembayaran = $this->m_auth->detailPembayaran($start_date,$end_date,ID_OFFICE,$id_lokasi);
		if($tipe == 1){
			$month = date("m",strtotime($start_date));
			$years = date("Y",strtotime($start_date));
			$jumtanggal = cal_days_in_month(CAL_GREGORIAN,$month,$years);
			$rata_rata = intval($pembayaran['pembayaran'])/$jumtanggal;
			$data_morris = array();
			for($i=1; $i <= $jumtanggal; $i++){
				$tanggal= date('Y-m-d', mktime(0,0,0,$month,$i,$years));
				$rows = [];
				$rows['tanggal'] = $tanggal;
				$data = $this->m_auth->morrisPembayaran($tanggal,ID_OFFICE,$id_lokasi,'harian');
				if($data['total'] > 0){
					$rows['value'] = intval($data['total']);
				}else{
					$rows['value'] = 0;
				}
				$data_morris[] =  $rows;
			}
		}else if($tipe == 2){
			$years = date("Y",strtotime($start_date));
			$rata_rata = intval($pembayaran['pembayaran'])/12;
			$data_morris = array();
			for($i=1; $i<=12; $i++){
				$tanggal= date('Y-m', mktime(0,0,0,$i,1,$years));
				$rows = [];
				$rows['tanggal'] = $tanggal;
				$data = $this->m_auth->morrisPembayaran($tanggal,ID_OFFICE,$id_lokasi,'bulanan');
				if($data['total'] > 0){
					$rows['value'] = intval($data['total']);
				}else{
					$rows['value'] = 0;
				}
				$data_morris[] =  $rows;
			}
		}

		$output = array(
			"transaksi" => number_format($pembayaran['transaksi'],0,',','.'),
			"pembayaran" => '<sup><font color="#F3545D">Rp</font></sup> '.number_format($pembayaran['pembayaran'],0,',','.'),
			"rata_rata" => '<sup><font color="#F3545D">Rp</font></sup> '.number_format(intval($rata_rata),0,',','.'),
			"morris" => $data_morris,
		);
		echo json_encode($output);
		exit();
	}

	public function grafik_penjualan(){
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];
		$id_lokasi = $_POST['lokasi'];
		$tipe = $_POST['tipe'];

		$penjualan = $this->m_auth->detailPenjualan($start_date,$end_date,ID_OFFICE,$id_lokasi);
		if($tipe == 1){
			$month = date("m",strtotime($start_date));
			$years = date("Y",strtotime($start_date));
			$jumtanggal = cal_days_in_month(CAL_GREGORIAN,$month,$years);
			$rata_rata = intval($penjualan['penjualan'])/$jumtanggal;
			$data_morris = array();
			for($i=1; $i <= $jumtanggal; $i++){
				$tanggal= date('Y-m-d', mktime(0,0,0,$month,$i,$years));
				$rows = [];
				$rows['tanggal'] = $tanggal;
				$data = $this->m_auth->morrisPenjualan($tanggal,ID_OFFICE,$id_lokasi,'harian');
				if($data['total'] > 0){
					$rows['value'] = intval($data['total']);
				}else{
					$rows['value'] = 0;
				}
				$data_morris[] =  $rows;
			}
		}else if($tipe == 2){
			$years = date("Y",strtotime($start_date));
			$rata_rata = intval($penjualan['penjualan'])/12;
			$data_morris = array();
			for($i=1; $i<=12; $i++){
				$tanggal= date('Y-m', mktime(0,0,0,$i,1,$years));
				$rows = [];
				$rows['tanggal'] = $tanggal;
				$data = $this->m_auth->morrisPenjualan($tanggal,ID_OFFICE,$id_lokasi,'bulanan');
				if($data['total'] > 0){
					$rows['value'] = intval($data['total']);
				}else{
					$rows['value'] = 0;
				}
				$data_morris[] =  $rows;
			}
		}

		$output = array(
			"transaksi" => number_format($penjualan['transaksi'],0,',','.'),
			"penjualan" => '<sup><font color="#F3545D">Rp</font></sup> '.number_format($penjualan['penjualan'],0,',','.'),
			"rata_rata" => '<sup><font color="#F3545D">Rp</font></sup> '.number_format(intval($rata_rata),0,',','.'),
			"morris" => $data_morris,
		);
		echo json_encode($output);
		exit();
	}

}