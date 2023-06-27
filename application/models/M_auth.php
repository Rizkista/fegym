<?php

class M_auth extends CI_Model {

    public function GetAllUsers(){
        $query = $this->db->query("
            SELECT a.*, b.id_cabang, b.nama_cabang
            FROM db_user a
            JOIN db_cabang b ON a.id_cabang = b.id_cabang
            GROUP BY a.tgl_edit
        ")->result();
        return $query;
    }

}
