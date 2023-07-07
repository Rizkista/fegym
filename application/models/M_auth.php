<?php

class M_auth extends CI_Model {

    public function GetAllAnggota($id_office){
        $query = $this->db->query("
            SELECT a.*, b.id_lokasi, b.nama_lokasi
            FROM db_anggota a
            JOIN db_lokasi b ON a.id_lokasi = b.id_lokasi
            WHERE a.id_office = ".$id_office."
            ORDER BY a.tgl_edit DESC
        ")->result();
        return $query;
    }
    
    public function getDataLokasi($id_office){
        $query = $this->db->query("
            SELECT a.*, b.id_account, b.nama, b.email, b.telp, b.pass_view
            FROM db_lokasi a
            JOIN db_account b ON a.id_account = b.id_account
            WHERE a.id_office = ".$id_office."
            ORDER BY a.tgl_edit DESC
        ")->result();
        return $query;
    }
    
    public function getDataKategoriProduk($id_office,$id_lokasi){
        $query = $this->db->query("
            SELECT a.*, b.nama_lokasi
            FROM db_kat_produk a
            JOIN db_lokasi b ON a.id_lokasi = b.id_lokasi
            WHERE a.id_office = ".$id_office."
            ".($id_lokasi != '' ? 'AND a.id_lokasi = '.$id_lokasi : '')."
            ORDER BY a.tgl_edit DESC
        ")->result();
        return $query;
    }

    public function getDataProduk($id_office,$id_lokasi){
        $query = $this->db->query("
            SELECT a.*, b.nama_kat_produk, c.nama_lokasi
            FROM db_produk a
            JOIN db_kat_produk b ON a.id_kat_produk = b.id_kat_produk
            JOIN db_lokasi c ON a.id_lokasi = c.id_lokasi
            WHERE a.id_office = ".$id_office."
            ".($id_lokasi != '' ? 'AND a.id_lokasi = '.$id_lokasi : '')."
            ORDER BY a.tgl_edit DESC
        ")->result();
        return $query;
    }

    public function getListProduk($id_office,$id_lokasi){
        $query = $this->db->query("
            SELECT * FROM db_produk
            WHERE status = 1
            AND id_office = ".$id_office."
            AND id_lokasi = ".$id_lokasi."
            ORDER BY nama_produk ASC
        ")->result();
        return $query;
    }

    public function getPaketGym($id_office,$id_lokasi){
        $query = $this->db->query("
            SELECT a.*, b.nama_lokasi
            FROM db_paket_gym a
            JOIN db_lokasi b ON a.id_lokasi = b.id_lokasi
            WHERE a.id_office = ".$id_office."
            ".($id_lokasi != '' ? 'AND a.id_lokasi = '.$id_lokasi : '')."
            ORDER BY a.tgl_edit DESC
        ")->result();
        return $query;
    }

    public function getDataStokMasuk($start_date,$end_date,$status,$id_lokasi,$id_office){
        $this->db->simple_query('SET SESSION group_concat_max_len = 15000');
        $query = $this->db->query("
            SELECT a.*, d.nama_lokasi,
                group_concat(c.nama_produk, '   ' order by id_stok_masuk_detail asc) as produk, 
                group_concat(b.jml_produk order by id_stok_masuk_detail asc) as jumlah
            FROM db_stok_masuk a
            JOIN db_stok_masuk_detail b ON a.id_stok_masuk = b.id_stok_masuk
            JOIN db_produk c ON b.id_produk = c.id_produk
            JOIN db_lokasi d ON a.id_lokasi = d.id_lokasi
            WHERE a.status = ".$status."
            AND a.id_office = ".$id_office."
            AND DATE_FORMAT(a.tgl_masuk,'%Y-%m-%d') >= '".$start_date."' 
            AND DATE_FORMAT(a.tgl_masuk,'%Y-%m-%d') <= '".$end_date."'
            ".($id_lokasi != null ? 'AND a.id_lokasi = '.$id_lokasi : '')."
            GROUP BY a.id_stok_masuk
            ORDER BY a.tgl_edit DESC
        ")->result();
        return $query;
    }

    public function getDataStokKeluar($start_date,$end_date,$status,$id_lokasi,$id_office){
        $this->db->simple_query('SET SESSION group_concat_max_len = 15000');
        $query = $this->db->query("
            SELECT a.*, d.nama_lokasi,
                group_concat(c.nama_produk, '   ' order by id_stok_keluar_detail asc) as produk, 
                group_concat(b.jml_produk order by id_stok_keluar_detail asc) as jumlah
            FROM db_stok_keluar a
            JOIN db_stok_keluar_detail b ON a.id_stok_keluar = b.id_stok_keluar
            JOIN db_produk c ON b.id_produk = c.id_produk
            JOIN db_lokasi d ON a.id_lokasi = d.id_lokasi
            WHERE a.status = ".$status."
            AND a.id_office = ".$id_office."
            AND DATE_FORMAT(a.tgl_keluar,'%Y-%m-%d') >= '".$start_date."' 
            AND DATE_FORMAT(a.tgl_keluar,'%Y-%m-%d') <= '".$end_date."'
            ".($id_lokasi != null ? 'AND a.id_lokasi = '.$id_lokasi : '')."
            GROUP BY a.id_stok_keluar
            ORDER BY a.tgl_edit DESC
        ")->result();
        return $query;
    }

    public function getDataStokOpname($start_date,$end_date,$status,$id_lokasi,$id_office){
        $this->db->simple_query('SET SESSION group_concat_max_len = 15000');
        $query = $this->db->query("
            SELECT a.*, d.nama_lokasi,
                group_concat(c.nama_produk, '   ' order by id_stok_opname_detail asc) as produk, 
                group_concat(b.jml_produk order by id_stok_opname_detail asc) as jumlah
            FROM db_stok_opname a
            JOIN db_stok_opname_detail b ON a.id_stok_opname = b.id_stok_opname
            JOIN db_produk c ON b.id_produk = c.id_produk
            JOIN db_lokasi d ON a.id_lokasi = d.id_lokasi
            WHERE a.status = ".$status."
            AND a.id_office = ".$id_office."
            AND DATE_FORMAT(a.tgl_opname,'%Y-%m-%d') >= '".$start_date."' 
            AND DATE_FORMAT(a.tgl_opname,'%Y-%m-%d') <= '".$end_date."'
            ".($id_lokasi != null ? 'AND a.id_lokasi = '.$id_lokasi : '')."
            GROUP BY a.id_stok_opname
            ORDER BY a.tgl_edit DESC
        ")->result();
        return $query;
    }


}
