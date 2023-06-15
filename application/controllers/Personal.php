<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Personal extends CI_Controller {
        
    function __construct(){
        parent::__construct();
		$this->load->model('M_main', 'm_main');
		$this->load->model('M_auth', 'm_auth');
		define('EMAIL',$this->session->userdata('email'));
		define('ID_ACCOUNT',$this->session->userdata('id_account'));
		define('ID_JABATAN',$this->session->userdata('id_jabatan'));
		define('ID_CABANG',$this->session->userdata('id_cabang'));
    }

    //================= PROFIL SAYA
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
	
    public function ganti_foto(){
		$uploadDIR = './assets/img/photo/';
		$config['upload_path']      = $uploadDIR;
		$config['allowed_types']    = 'jpg|png|jpeg';
		$config['max_size'] 		= 1024*2; //2Mb
		$config['file_name']        = 'foto-' . date('ymd') . '-' . substr(md5(rand()), 0, 10);

		$this->load->library('upload', $config);
		if (!empty($_FILES['profile_image']['name'])) {
			if ($this->upload->do_upload('profile_image')) {
				$uploadData = $this->upload->data();

				$config['image_library'] = 'gd2';
				$config['source_image'] = $uploadDIR . $uploadData['file_name'];
				$config['create_thumb'] = FALSE;
				$config['maintain_ratio'] = TRUE;
				$config['quality'] = '100%';
				$config['new_image'] = $uploadDIR . $uploadData['file_name'];
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();

                $account = $this->m_main->getRow('db_account','email',EMAIL);
				if ($account['foto'] != "profile.jpg" && $account['foto'] != NULL || $account['foto'] != '') {
					$target_file = $uploadDIR . $account['foto'];
					if(file_exists($target_file)){
						unlink($target_file);
					}
				}
				
				$data['foto'] = $uploadData['file_name'];
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
}