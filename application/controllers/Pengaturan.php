<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Pengaturan extends CI_Controller {
        
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
	
    public function ganti_foto(){
		$uploadDIR = './assets/img/photo/';
		$config['upload_path']          = $uploadDIR;
		$config['allowed_types']        = 'jpg|png|jpeg';
		$config['file_name']            = 'foto-'.date('ymd').'-'.substr(md5(rand()), 0, 10);

		$this->load->library('upload', $config);
		if (!empty($_FILES['profile_image']['name'])) {
			if ($this->upload->do_upload('profile_image')) {
				$uploadData = $this->upload->data();
				$config['image_library'] 	= 'gd2';
				$config['source_image'] 	= $uploadDIR . $uploadData['file_name'];
				$config['new_image'] 		= $uploadDIR . $uploadData['file_name'];
				$config['maintain_ratio'] 	= TRUE;
				if(getimagesize($_FILES['profile_image']['tmp_name'])[0] >= 500){
					$config['width'] = 500;
				}
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();

                $account = $this->m_main->getRow('db_account','id_account',ID_ACCOUNT);
				if ($account['photo'] != "profile.jpg" && $account['photo'] != NULL || $account['photo'] != '') {
					$target_file = $uploadDIR . $account['photo'];
					if(file_exists($target_file)){
						unlink($target_file);
					}
				}
				
				$data['photo'] = $uploadData['file_name'];
				$this->m_main->updateIN('db_account','id_account',ID_ACCOUNT,$data);
				$output['message'] = "Foto profil berhasil di ganti!";
				$output['result'] = "success";
			}
		}else{
			$output['message'] = "Foto profil gagal di ganti!";
			$output['result'] = "error";
		}
		echo json_encode($output);
		exit();
	}

	public function ganti_password(){
		$data = [
			'password' => password_hash($_POST['pass1'], PASSWORD_DEFAULT)
		];
		$this->m_main->updateIN('db_account','id_account',ID_ACCOUNT,$data);

		$output['message'] = "Password Berhasil di Simpan!";
		$output['result'] = "success";
		echo json_encode($output);
		exit();
	}
	
    public function update_profile(){ 
		$data = [
			'nama' => $_POST['nama'],
			'email' => $_POST['email'],
			'telp' => $_POST['telp'],
			'alamat' => $_POST['alamat'],
		];
		$this->m_main->updateIN('db_account','id_account',ID_ACCOUNT,$data);
		$sess = [
			'nama' => $_POST['nama'],
			'email' => $_POST['email'],
		];
		$this->session->set_userdata($sess);
		$output['message'] = "Data profile berhasil diganti!";
		$output['result'] = "success";

        echo json_encode($output);
        exit();
	}
	
    public function update_office(){ 
		$data = [
			'nama_office' => $_POST['nama_office'],
			'email_office' => $_POST['email_office'],
			'telp_office' => $_POST['telp_office'],
			'alamat_office' => $_POST['alamat_office'],
			'nota_header' => $_POST['nota_header'],
			'nota_footer' => $_POST['nota_footer'],
		];
		
		if(!empty($_FILES['logo_nota']['name'])) {
			$uploadDIR = './assets/img/logo_nota/';
			$config['upload_path']		= $uploadDIR;
			$config['allowed_types']	= 'png';
			$config['file_name']		= 'nota-'.date('ymd').'-'.substr(md5(rand()), 0, 10);
			$this->load->library('upload', $config);
			if($this->upload->do_upload('logo_nota')) {
				$uploadData = $this->upload->data();
				$config['image_library'] 	= 'gd2';
				$config['source_image'] 	= $uploadDIR . $uploadData['file_name'];
				$config['new_image'] 		= $uploadDIR . $uploadData['file_name'];
				$config['maintain_ratio'] 	= TRUE;
				$config['master_dim'] 		= 'auto';
				$config['quality'] 			= '80%';
				if(getimagesize($_FILES['logo_nota']['tmp_name'])[0] >= 350){
					$config['width'] = 350;
				}
				if(getimagesize($_FILES['logo_nota']['tmp_name'])[1] >= 350){
					$config['height'] = 350;
				}
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();
                $office = $this->m_main->getRow('db_office','id_office',ID_OFFICE);
				if ($office['nota_logo'] != NULL || $office['nota_logo'] != '') {
					$target_file = $uploadDIR . $office['nota_logo'];
					if(file_exists($target_file)){
						unlink($target_file);
					}
				}
				$data['nota_logo'] = $uploadData['file_name'];
			}
		}
		$this->m_main->updateIN('db_office','id_office',ID_OFFICE,$data);
		$output['message'] = "Data perusahaan berhasil diganti!";
		$output['result'] = "success";

        echo json_encode($output);
        exit();
	}

}