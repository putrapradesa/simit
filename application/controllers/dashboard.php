<?php
    defined('BASEPATH') OR exit('No direct script access allowed'); 
    
    class dashboard extends CI_Controller
    {
        function __construct()
        {
            parent::__construct(); 
 
            if($this->session->userdata('status') != "logged")
            {   
                redirect(base_url().'login?alert=belum_login');  
            }

            $this->load->model('transaksi/m_barangkeluar');
        }

        public function index()
        {
            $data['Judul'] = 'Dashboard';
            $data['content'] = 'dashboard/content';
            $data['menu'] = '';
            $data['submenu'] = '';
            $data['ses_level'] = $this->session->userdata('level');
            $data['garment'] = $this->m_barangkeluar->getdata2('SELECT SUM(Qty) AS Quantity FROM barang_keluar WHERE TipePengeluaran = "INVENTARIS" AND DIVISI = "Garment" AND NamaBarang = "Komputer" GROUP BY DIVISI')->row();

            if(isset($data['garment'])){
                $data['garment'] = (object)array('Quantity' => 0 );
            }
            $data['textile'] = $this->m_barangkeluar->getdata2('SELECT SUM(Qty) AS Quantity FROM barang_keluar WHERE TipePengeluaran = "INVENTARIS" AND DIVISI = "Textile" AND NamaBarang = "Komputer" GROUP BY DIVISI')->row();

            if(isset($data['textile'])){
                $data['textile'] = (object)array('Quantity' => 0 );
            }
            // var_dump($data);
            //echo($this->session->userdata('status'));
            $this->load->view('index', $data);
        }
    }
?>