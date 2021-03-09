<?php

class m_permintaan extends CI_Model
{    
    function query($query)
    {   
        // return $this->db->query('SELECT * FROM daftar_permintaan WHERE IsDelete = 0 ORDER BY CreateUtc DESC'); 
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
        $this->db->insert_batch('daftar_permintaan', $data);

        return $this->db->affected_rows();
    }


    function search_autocomplete($title){
        $this->db->like('Nama', $title , 'both');
        $this->db->order_by('Nama', 'ASC');
        $this->db->limit(10);
        return $this->db->get('barang')->result();
    }

    function get_all_data($postData=null)  
    {  
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page
        // $columnIndex = $postData['order'][0]['column']; // Column index
        // $columnName = $postData['columns'][$columnIndex]['data']; // Column name
        // $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value
        $searchStatus = $postData['searchStatus'];
        $searchValue = $postData['search']['value'];

        $search_arr = array();
        $searchQuery = "";

        if($searchValue != '' ){
            $search_arr[] = "(Nama like '%".$searchValue."%' or 
                                Divisi like '%".$searchValue."%' or 
                                Bagian like'%".$searchValue."%' or
                                Barang like'%".$searchValue."%' or 
                                Status like'%".$searchValue."%' or
                                Qty like'%".$searchValue."%') ";
            // $search_arr[] = "(Nama like '%".$searchValue."%')";
        }

        if($searchStatus != '' and $searchStatus == 'Sudah'){
            $search_arr[] = "Status like '%".$searchStatus."%' or Status like '%Sebagian%'";
        }else if($searchStatus != '' and $searchStatus == 'Belum'){
            $search_arr[] = "Status like '%".$searchStatus."%'";
        }
        // var_dump($search_arr);
        if(count($search_arr) > 0){
            $searchQuery = implode(" and ",$search_arr);
        }

        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $records = $this->db->get('daftar_permintaan')->result();
        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        if($searchQuery != '')
        $this->db->where($searchQuery);
        $records = $this->db->get('daftar_permintaan')->result();
        $totalRecordwithFilter = $records[0]->allcount;

        if($searchQuery != ''){
            $records =  $this->db->get_where("daftar_permintaan",$searchQuery)->result();
            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordwithFilter,
                "aaData" => $records
              );
        }else{
            $records = $this->db->get('daftar_permintaan')->result();
            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordwithFilter,
                "aaData" => $records
            );
        }
        return $response; 
 
    } 
 
}

?>