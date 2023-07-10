<?php

class M_main extends CI_Model {

    public function runQueryRow($query){
        $query = $this->db->query($query)->row_array();
        return $query;
    }
    
    public function runQueryResult($query){
        $query = $this->db->query($query)->result();
        return $query;
    }

    public function readIN($in){
        return $this->db->select('*')->from($in)->get()->result();
    }

    public function createIN($in,$data){
		$this->db->insert($in, $data);
        $id = $this->db->insert_id();
        return array(
            'result' => $id,
            'string' => $this->db->last_query(),
        );
	}
    
    public function updateIN($in,$wr,$id,$data){
        $query = $this->db->where($wr, $id)->update($in, $data);
        return array(
            'result' => $query,
            'string' => $this->db->last_query(),
        );
    }

    public function updateALL($in,$data){
        $query = $this->db->update($in, $data);
        return array(
            'result' => $query,
            'string' => $this->db->last_query(),
        );
    } 

    public function deleteIN($in,$wr,$id){
        return $this->db->delete($in, array($wr => $id)); 
    }

    public function getRow($in,$wr,$val){
        return $this->db->get_where($in,[$wr => $val])->row_array();
    }
    
    public function getResult($in,$wr,$val){
        return $this->db->get_where($in,[$wr => $val])->result();
    }
    
    public function getResultData($in,$wr,$by){
        $query = $this->db->select('*')
            ->from($in)
            ->where($wr)
            ->order_by($by)
            ->get()->result();
        return $query;
    }

    public function getData($in,$wr){
        return $this->db->select('*')
        ->from($in)
        ->where($wr)
        ->limit(1)
        ->get()->row_array();
    }

    public function countData($in,$wr){
        return $this->db->select('COUNT(*) as count')
        ->from($in)
        ->where($wr)
        ->limit(1)
        ->get()->row_array();
    }

    public function sumData($in,$wr,$sum){
        return $this->db->select('SUM('.$sum.') as sum')
        ->from($in)
        ->where($wr)
        ->limit(1)
        ->get()->row_array();
    }

    public function cekData($in,$wr,$val){
        $query = $this->db->select('*')
            ->from($in)
            ->where($wr,$val)
            ->limit(1)
            ->get()->row_array();
            
        if($query != null){
            return true;
        }else{
            return false;
        }
    }
}