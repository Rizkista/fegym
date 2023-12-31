<?php

class M_auth extends CI_Model {

    public function getAccountOnline($id_office){
        $query = $this->db->query("
            SELECT a.*, b.kode_lokasi
            FROM db_account a
            JOIN db_lokasi b ON a.id_account = b.id_account 
            WHERE a.status = 1
            AND a.tgl_login > a.tgl_logout 
            AND DATE(a.tgl_login) = '".date("Y-m-d")."'
            AND a.id_office = ".$id_office." 
            ORDER BY a.tgl_login desc
        ")->result();
        return $query;
    }

    public function getAllAnggota($id_office){
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

    public function getListPaket($id_office,$id_lokasi){
        $query = $this->db->query("
            SELECT * FROM db_paket_gym
            WHERE status = 1
            AND id_office = ".$id_office."
            AND id_lokasi = ".$id_lokasi."
            ORDER BY nama_paket ASC
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

    public function getDataPenjualan($start_date,$end_date,$status,$id_lokasi,$id_office){
        $this->db->simple_query('SET SESSION group_concat_max_len = 15000');
        $query = $this->db->query("
            SELECT a.*, d.nama_lokasi,
                group_concat(c.nama_produk, '   ' order by id_penjualan_item asc) as nama_item, 
                group_concat(FORMAT(b.jml_produk_item, 0, 'de_DE') order by id_penjualan_item asc) as jml_item,
                group_concat(concat('Rp ',FORMAT(b.diskon_nominal_item, 0, 'de_DE')) order by id_penjualan_item asc) as diskon_item,
                group_concat(concat('Rp ',FORMAT(b.subtotal_harga_item, 0, 'de_DE')) order by id_penjualan_item asc) as harga_item
            FROM db_penjualan a
            JOIN db_penjualan_item b ON a.id_penjualan = b.id_penjualan
            JOIN db_produk c ON b.id_produk = c.id_produk
            JOIN db_lokasi d ON a.id_lokasi = d.id_lokasi
            WHERE a.status = ".$status."
            AND a.id_office = ".$id_office."
            AND DATE_FORMAT(a.tgl_penjualan,'%Y-%m-%d') >= '".$start_date."' 
            AND DATE_FORMAT(a.tgl_penjualan,'%Y-%m-%d') <= '".$end_date."'
            ".($id_lokasi != null ? 'AND a.id_lokasi = '.$id_lokasi : '')."
            GROUP BY a.id_penjualan
            ORDER BY a.tgl_edit DESC
        ")->result();
        return $query;
    }

    public function getDataPembayaran($start_date,$end_date,$status,$id_lokasi,$id_office){
        $query = $this->db->query("
            SELECT a.*, d.nama_lokasi, b.nama_anggota, c.nama_paket
            FROM db_pembayaran a
            JOIN db_anggota b ON a.id_anggota = b.id_anggota
            JOIN db_paket_gym c ON a.id_paket_gym = c.id_paket_gym
            JOIN db_lokasi d ON a.id_lokasi = d.id_lokasi
            WHERE a.status = ".$status."
            AND a.id_office = ".$id_office."
            AND DATE_FORMAT(a.tgl_pembayaran,'%Y-%m-%d') >= '".$start_date."' 
            AND DATE_FORMAT(a.tgl_pembayaran,'%Y-%m-%d') <= '".$end_date."'
            ".($id_lokasi != null ? 'AND a.id_lokasi = '.$id_lokasi : '')."
            ORDER BY a.tgl_edit DESC
        ")->result();
        return $query;
    }
    
    public function detailPembayaran($start_date,$end_date,$id_office,$id_lokasi){
        $query = $this->db->query("
            SELECT COUNT(*) as transaksi, SUM(total_transaksi) as pembayaran
            FROM db_pembayaran
            WHERE status = 1
            AND id_office = ".$id_office."
            AND DATE_FORMAT(tgl_pembayaran,'%Y-%m-%d') >= '".$start_date."' 
            AND DATE_FORMAT(tgl_pembayaran,'%Y-%m-%d') <= '".$end_date."'
            ".($id_lokasi != null ? 'AND id_lokasi = '.$id_lokasi : '')."
        ")->row_array();
        return $query;
    }

    public function morrisPembayaran($tanggal,$id_office,$id_lokasi,$filter){
        if($filter == 'harian'){
            $whereDate = 'AND DATE_FORMAT(tgl_pembayaran,"%Y-%m-%d") = "'.$tanggal.'"';
        }else if($filter == 'bulanan'){
            $whereDate = 'AND DATE_FORMAT(tgl_pembayaran,"%Y-%m-%d") LIKE "'.$tanggal.'%"';
        }

        $query = $this->db->query("
            SELECT SUM(total_transaksi) as total
            FROM db_pembayaran
            WHERE status = 1
            AND id_office = ".$id_office."
            ".$whereDate."
            ".($id_lokasi != null ? 'AND id_lokasi = '.$id_lokasi : '')."
        ")->row_array();
        return $query;
    }
    
    public function detailPenjualan($start_date,$end_date,$id_office,$id_lokasi){
        $query = $this->db->query("
            SELECT COUNT(*) as transaksi, SUM(total_transaksi) as penjualan
            FROM db_penjualan
            WHERE status = 1
            AND id_office = ".$id_office."
            AND DATE_FORMAT(tgl_penjualan,'%Y-%m-%d') >= '".$start_date."' 
            AND DATE_FORMAT(tgl_penjualan,'%Y-%m-%d') <= '".$end_date."'
            ".($id_lokasi != null ? 'AND id_lokasi = '.$id_lokasi : '')."
        ")->row_array();
        return $query;
    }

    public function morrisPenjualan($tanggal,$id_office,$id_lokasi,$filter){
        if($filter == 'harian'){
            $whereDate = 'AND DATE_FORMAT(tgl_penjualan,"%Y-%m-%d") = "'.$tanggal.'"';
        }else if($filter == 'bulanan'){
            $whereDate = 'AND DATE_FORMAT(tgl_penjualan,"%Y-%m-%d") LIKE "'.$tanggal.'%"';
        }

        $query = $this->db->query("
            SELECT SUM(total_transaksi) as total
            FROM db_penjualan
            WHERE status = 1
            AND id_office = ".$id_office."
            ".$whereDate."
            ".($id_lokasi != null ? 'AND id_lokasi = '.$id_lokasi : '')."
        ")->row_array();
        return $query;
    }

}
