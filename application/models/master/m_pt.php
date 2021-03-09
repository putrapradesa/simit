<?php  
 
class m_pt extends CI_Model
{    
    function getdata($table)
    {   
        return $this->db->query("SELECT * FROM pt where isDeleted = 0");  
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
        $this->db->update($table, $data, array('Id' => $data['Id']));

        return $this->db->affected_rows();
    }

    public function save_batch($data){
        $this->db->insert_batch('pt', $data);

        return $this->db->affected_rows();
    }
 
} 
 
?> 