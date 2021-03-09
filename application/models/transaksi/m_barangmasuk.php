<?php

class m_barangmasuk extends CI_Model
{    
    function getdata()
    {   
        return $this->db->query('SELECT * FROM barang_masuk WHERE IsDelete = 0 ORDER BY CreateUtc DESC');  
    }

    function getdata2($query)
    {   
        return $this->db->query($query);  
    }
    
    function cek($table, $where){
        return $this->db->get_where($table, $where);
    }

    function add($table, $data){
        $this->db->insert($table, $data);

        return $this->db->insert_id();
    }

    public function update($table, $data)
    {
        return $this->db->update($table, $data, array('Id' => $data['Id']));
    }

    public function save_batch($data){
        $this->db->insert_batch('barang_masuk', $data);

        return $this->db->affected_rows();
    }


    function search_autocomplete($title){
        $this->db->like('Nama', $title , 'both');
        $this->db->order_by('Nama', 'ASC');
        $this->db->limit(10);
        return $this->db->get('barang')->result();
    }
 
}

?>