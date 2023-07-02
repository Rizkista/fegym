<?php

class M_auth extends CI_Model {

    public function GetAllAnggota(){
        $query = $this->db->query("
            SELECT a.*, b.id_cabang, b.nama_cabang
            FROM db_anggota a
            JOIN db_cabang b ON a.id_cabang = b.id_cabang
            GROUP BY a.tgl_edit
        ")->result();
        return $query;
    }
    
    public function getDataCabang(){
        $query = $this->db->query("
            SELECT a.status, a.nama_cabang, a.alamat_cabang, a.id_cabang, b.id_account, b.nama, b.email, b.telp, b.pass_view
            FROM db_cabang a
            JOIN db_account b ON a.id_account = b.id_account
            GROUP BY a.tgl_edit desc
        ")->result();
        return $query;
    }
}
