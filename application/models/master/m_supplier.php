<?php  
 
class m_supplier extends CI_Model
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
        $this->db->insert_batch('supplier', $data);

        return $this->db->affected_rows();
    }
 
} 
 
?> 