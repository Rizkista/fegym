<?php

class M_auth extends CI_Model {

    public function GetAllAnggota($id_office){
        $query = $this->db->query("
            SELECT a.*, b.id_cabang, b.nama_cabang
            FROM db_anggota a
            JOIN db_cabang b ON a.id_cabang = b.id_cabang
            WHERE a.id_office = ".$id_office."
            GROUP BY a.tgl_edit
        ")->result();
        return $query;
    }
    
    public function getDataCabang($id_office){
        $query = $this->db->query("
            SELECT a.status, a.nama_cabang, a.alamat_cabang, a.id_cabang, b.id_account, b.nama, b.email, b.telp, b.pass_view
            FROM db_cabang a
            JOIN db_account b ON a.id_account = b.id_account
            WHERE a.id_office = ".$id_office."
            GROUP BY a.tgl_edit desc
        ")->result();
        return $query;
    }
    
    public function getDataProduk($id_office){
        $query = $this->db->query("
            SELECT a.*, b.nama_kat_produk, b.id_kat_produk
            FROM db_produk a
            JOIN db_kat_produk b ON a.id_kat_produk = b.id_kat_produk
            WHERE a.id_office = ".$id_office."
            GROUP BY a.tgl_edit desc
        ")->result();
        return $query;
    }

}
