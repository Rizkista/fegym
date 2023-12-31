<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Anggota extends CI_Controller {

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

	//================= Anggota
	public function read_anggota(){
		$anggota = $this->m_auth->getAllAnggota(ID_OFFICE);
		$data = [];
		$no = 0;
		foreach ($anggota as $list) {
			$sisa = date_diff(date_create(date('Y-m-d H:i:s')),date_create($list->tgl_expired))->format('%R%a');
			if($list->status_member == 1){
				$member = 
				'<span class="text-12px"><i>'.
				$list->paket_gym.
				' <sup><b><font color="#F3545D">'.
				($list->tgl_expired < date('Y-m-d H:i:s') ? 'EXPIRED' : 'AKTIF').
				'</font></b></sup><br>'.
				date_format(date_create($list->tgl_member),"d-m-Y").
				' s/d '.
				date_format(date_create($list->tgl_expired),"d-m-Y").
				' (Sisa: '.($sisa > 0 ? $sisa : 0).' Hari)</i></span>';
			}else{
				$member = 'TIDAK';
			}
            $no++;
            $row = [];
            $row['No'] = $no;
            $row['kode_anggota'] = $list->kode_anggota;
            $row['nama_anggota'] = $list->nama_anggota;
            $row['gender_anggota'] = $list->gender_anggota;
            $row['telp_anggota'] = $list->telp_anggota;
            $row['email_anggota'] = $list->email_anggota;
            $row['alamat_anggota'] = $list->alamat_anggota;
            $row['status_member'] = $member;
            $row['nama_lokasi'] = $list->nama_lokasi;
            $row['id_lokasi'] = $list->id_lokasi;
            $row['status'] = $list->status == 1 ? 'aktif-' : 'hapus-';
            $row['Aksi'] = $list->id_anggota;
            $row['IDlokasi'] = '-'.$list->id_lokasi.'-';
            $data[] = $row;
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}

	public function add_anggota(){
		$cekData = $this->m_main->cekData('db_anggota','telp_anggota',$_POST['telp_anggota']);
		if(!$cekData){
			$kode_office = $this->m_main->getRow('db_office','id_office',ID_OFFICE)['kode_office'];
			$cek_kode = $this->m_main->runQueryRow('
				SELECT * 
				FROM db_anggota 
				WHERE kode_anggota LIKE "'.$kode_office.'%" 
				AND id_office = '.ID_OFFICE.' 
				ORDER BY kode_anggota DESC
			');
			$last_kode = $cek_kode ? intval(str_replace($kode_office,'',$cek_kode['kode_anggota'])) : 0;
			$kode_anggota = $kode_office.sprintf("%06d", ($last_kode+1));
			$data = [
				'id_office' => ID_OFFICE,
				'id_lokasi' => $_POST['id_lokasi'] ? $_POST['id_lokasi'] : (ID_LOKASI != '' ? ID_LOKASI : 1),
				'kode_anggota' => $kode_anggota,
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

	public function list_anggota(){
		$anggota = $this->m_main->getResultData('db_anggota','status = 1 AND id_office = '.ID_OFFICE,'nama_anggota asc');
		$data = [];
		foreach ($anggota as $list) {
            $row = [];
            $row['id_anggota'] = $list->id_anggota;
            $row['kode_anggota'] = $list->kode_anggota;
            $row['nama_anggota'] = $list->nama_anggota;
            $row['gender_anggota'] = $list->gender_anggota;
            $row['telp_anggota'] = $list->telp_anggota;
            $row['email_anggota'] = $list->email_anggota;
            $row['alamat_anggota'] = $list->alamat_anggota;
            $row['status_member'] = $list->status_member;
            $row['id_lokasi'] = $list->id_lokasi;
            $data[] = $row;
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}
    
}