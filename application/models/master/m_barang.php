<?php  
 
class m_barang extends CI_Model
{    
    function getdata($table)
    {   
        return $this->db->get($table);  
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
        $this->db->insert_batch('barang', $data);

        return $this->db->affected_rows();
    }
 
} 
 
?> 