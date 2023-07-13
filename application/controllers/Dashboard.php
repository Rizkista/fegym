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

}