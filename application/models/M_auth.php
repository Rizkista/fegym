<?php

class M_auth extends CI_Model {

    public function GetAllAnggota($id_office){
        $query = $this->db->query("
            SELECT a.*, b.id_lokasi, b.nama_lokasi
            FROM db_anggota a
            JOIN db_lokasi b ON a.id_lokasi = b.id_lokasi
            WHERE a.id_office = ".$id_office."
            GROUP BY a.tgl_edit
        ")->result();
        return $query;
    }
    
    public function getDataLokasi($id_office){
        $query = $this->db->query("
            SELECT a.status, a.nama_lokasi, a.alamat_lokasi, a.id_lokasi, b.id_account, b.nama, b.email, b.telp, b.pass_view
            FROM db_lokasi a
            JOIN db_account b ON a.id_account = b.id_account
            WHERE a.id_office = ".$id_office."
            GROUP BY a.tgl_edit desc
        ")->result();
        return $query;
    }
    
    public function getDataKategoriProduk($id_office,$id_lokasi){
        $id_lokasi = $id_lokasi != '' ? 'AND a.id_lokasi = '.$id_lokasi : '';
        $query = $this->db->query("
            SELECT a.*, b.nama_lokasi
            FROM db_kat_produk a
            JOIN db_lokasi b ON a.id_lokasi = b.id_lokasi
            WHERE a.id_office = ".$id_office."
            ".$id_lokasi."
            GROUP BY a.tgl_edit desc
        ")->result();
        return $query;
    }

    public function getDataProduk($id_office,$id_lokasi){
        $id_lokasi = $id_lokasi != '' ? 'AND a.id_lokasi = '.$id_lokasi : '';
        $query = $this->db->query("
            SELECT a.*, b.nama_kat_produk, c.nama_lokasi
            FROM db_produk a
            JOIN db_kat_produk b ON a.id_kat_produk = b.id_kat_produk
            JOIN db_lokasi c ON a.id_lokasi = c.id_lokasi
            WHERE a.id_office = ".$id_office."
            ".$id_lokasi."
            GROUP BY a.tgl_edit desc
        ")->result();
        return $query;
    }


}
