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
    }
	
    public function ganti_foto(){
		$uploadDIR = './assets/img/photo/';
		$config['upload_path']          = $uploadDIR;
		$config['allowed_types']        = 'jpg|png|jpeg';
		$config['file_name']            = 'foto-' . date('ymd') . '-' . substr(md5(rand()), 0, 10);

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

                $member = $this->m_auth->getRow('jd_member','email',EMAIL);
				if ($member['foto_diri'] != "profile.png" && $member['foto_diri'] != NULL || $member['foto_diri'] != '') {
					$target_file = $uploadDIR . $member['foto_diri'];
					if(file_exists($target_file)){
						unlink($target_file);
					}
				}
				
				$data['foto_diri'] = $uploadData['file_name'];
				$qry = $this->m_auth->updateIN('jd_member','id_member',ID_MEMBER,$data);
				$this->update_log($qry['string'],'Change Foto oleh '.MEMBER);

				$output['message'] ="Foto profil berhasil di ganti!";
				$output['result'] = "success";
			}
		}else{
			$output['message'] ="Foto profil gagal di ganti!";
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
		$output['message'] ="Data profile berhasil diganti!";
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
		];
		$this->m_main->updateIN('db_office','id_office',ID_OFFICE,$data);
		$output['message'] ="Data perusahaan berhasil diganti!";
		$output['result'] = "success";

        echo json_encode($output);
        exit();
	}

}