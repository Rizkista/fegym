<?php

class M_akses extends CI_Model {

    public function GetLevelMenu(){
        $query = $this->db->select('*')
            ->from('db_level_menu')
            ->where('status','1')
            ->order_by('urutan','asc')
            ->get()->result();
        return $query;
    }

    public function cekMenu($id_posisi,$id_menu){
        $query = $this->db->select('*')
            ->from('db_level_akses a')
            ->join('db_level_submenu b','a.id_level_submenu = b.id_level_submenu')
            ->join('db_level_menu c','b.id_level_menu = c.id_level_menu')
            ->join('db_level_aksi d','a.id_level_aksi = d.id_level_aksi')
            ->where('c.id_level_menu',$id_menu)
            ->where('a.id_posisi',$id_posisi)
            ->where('a.id_level_aksi',1)
            ->where('a.status',1)
            ->limit(1)
            ->get()->row_array();
            
        if($query != null){
            return true;
        }else{
            return false;
        }
    }

    public function GetLevelSubmenu(){
        $query = $this->db->select('*')
            ->from('db_level_submenu')
            ->where('status','1')
            ->order_by('urutan','asc')
            ->get()->result();
        return $query;
    }
    
    public function cekSubmenu($id_posisi,$uri_submenu){
        $query = $this->db->select('*')
            ->from('db_level_akses a')
            ->join('db_level_submenu b','a.id_level_submenu = b.id_level_submenu')
            ->join('db_level_menu c','b.id_level_menu = c.id_level_menu')
            ->join('db_level_aksi d','a.id_level_aksi = d.id_level_aksi')
            ->where('b.uri_submenu',$uri_submenu)
            ->where('a.id_posisi',$id_posisi)
            ->where('a.id_level_aksi',1)
            ->where('a.status',1)
            ->limit(1)
            ->get()->row_array();
            
        if($query != null){
            return true;
        }else{
            return false;
        }
    }

    public function cekAksi($id_posisi,$uri_submenu,$id_aksi){
        $query = $this->db->select('*')
            ->from('db_level_akses a')
            ->join('db_level_submenu b','a.id_level_submenu = b.id_level_submenu')
            ->join('db_level_menu c','b.id_level_menu = c.id_level_menu')
            ->join('db_level_aksi d','a.id_level_aksi = d.id_level_aksi')
            ->where('b.uri_submenu',$uri_submenu)
            ->where('a.id_posisi',$id_posisi)
            ->where('a.id_level_aksi',$id_aksi)
            ->where('a.status',1)
            ->limit(1)
            ->get()->row_array();
            
        if($query != null){
            return true;
        }else{
            return false;
        }
    }

    public function cekLevel($id_posisi,$id_level_submenu,$id_level_aksi){
        $query = $this->db->select('id_level_akses')
            ->from('db_level_akses')
            ->where('id_posisi',$id_posisi)
            ->where('id_level_submenu',$id_level_submenu)
            ->where('id_level_aksi',$id_level_aksi)
            ->limit(1)
            ->get()->row_array();
            
        if($query != null){
            return $query;
        }else{
            return false;
        }
    }
    
    public function GetLevelSubmenuList($id_level_menu){
        $query = $this->db->select('*')
            ->from('db_level_submenu')
            ->where('id_level_menu',$id_level_menu)
            ->where('status','1')
            ->order_by('urutan','asc')
            ->get()->result();
        return $query;
    }
    
    public function GetLevelAksi(){
        $query = $this->db->select('*')
            ->from('db_level_aksi')
            ->where('status','1')
            ->order_by('urutan','asc')
            ->get()->result();
        return $query;
    }

    public function CekHakAkses($id_level_submenu,$id_level_aksi,$id_level){
        $query = $this->db->select('*')
            ->from('db_level_akses')
            ->where('id_posisi',$id_level)
            ->where('id_level_submenu',$id_level_submenu)
            ->where('id_level_aksi',$id_level_aksi)
            ->limit(1)
            ->get()->row_array();
        if($query != null){
            return $query;
        }else{
            return false;
        }
    }

}
