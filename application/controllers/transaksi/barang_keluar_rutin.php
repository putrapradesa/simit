<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class barang_keluar_rutin extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        if($this->session->userdata('status') != "logged")
        {   
            redirect(base_url().'login?alert=belum_login');  
        } 
        $this->load->model('master/m_divisi');
        $this->load->model('transaksi/m_barangkeluar');
        $this->load->model('master/m_barang');
    }

    public function index()
    {
        $data['Judul'] = 'Barang Keluar Rutin';
        $data['content'] = 'transaksi/keluar_rutin/home';

        $where = array(
            "IsDeleted" => 0
        );

        $wheredata = array(
            "IsDelete" => 0
        );
        

        // $datapt = $this->m_bagian->cek('bagian',$where)->result();
        // $data['databagian'] = $datapt;
        $data['datakeluar'] = $this->m_barangkeluar->getdata2('SELECT * FROM barang_keluar WHERE IsDeleted = 0 AND (IdSP is null OR IdSP = 0)')->result();
        // $data['barang'] = $this->m_barangkeluar->cek('barang',$where)->result();
        $data['barang'] = $this->m_barangkeluar->getdata2('SELECT B.* FROM inven_barang A JOIN barang B ON A.`IdBarang` = B.`Id` WHERE A.`RemainingQuantity` > 0')->result();
        // var_dump($data['barang']);
        $data['uom'] = $this->m_barangkeluar->cek('uom',$wheredata)->result();
        $data['divisi'] = $this->m_barangkeluar->cek('divisi',$where)->result();
        // $data['permintaan'] = $this->m_barangkeluar->getdata2('SELECT * FROM daftar_permintaan WHERE IsDeleted = 0 AND (Status = "SUDAH DITERIMA" OR Status = "DITERIMA SEBAGIAN") GROUP BY Nama, IdDivisi, IdBagian, IdPT')->result();
        $data['modal_tambah_barang_keluar'] = show_my_modal('transaksi/keluar_rutin/modal/add', 'tambah-barangkeluar', $data);
        $data['menu'] = 'barang_keluar_rutin';
        $data['submenu'] = '';
        $data['ses_level'] = $this->session->userdata('level');
        
        // $this->template->view('master/pt/home', $data);
        $this->load->view('index', $data);
    }

    public function tampil(){
        $where = array(
            "IsDeleted" => 0
        );

        $wheredata = array(
            "IsDelete" => 0
        );

        $data['datakeluar'] = $this->m_barangkeluar->getdata2('SELECT * FROM barang_keluar WHERE Isdeleted = 0 AND (IdSP IS NULL OR IdSP = 0)')->result();
        // $data['permintaan'] = $this->m_barangkeluar->getdata2('SELECT * FROM daftar_permintaan WHERE IsDeleted = 0 AND (Status = "SUDAH DITERIMA" OR Status = "DITERIMA SEBAGIAN") GROUP BY Nama, IdDivisi, IdBagian, IdPT')->result();
        // var_dump($data);
        $this->load->view('transaksi/keluar_rutin/list', $data);
    }

    public function get_bagian(){
        $data = $this->input->post('id',TRUE);
        $rowpt = explode(',',$data);
        $divisi = $rowpt[1];
        $IdDivisi = $rowpt[0];
        $IdPt = $rowpt[2];
        $where = array(
            "IdDivisi" => $IdDivisi,
            "IdPT" => $IdPt
        );
        $result = $this->m_barangkeluar->cek('bagian',$where)->result();
        $output = '<option value="">--Pilih Bagian--</option>';
        foreach($result as $row){
            $output .= '<option value="'.$row->Id.','.$row->Nama.'">'.$row->Nama.'</option>';
        }
        echo json_encode($output);
    }

    function add(){
        $data = $this->input->post();
        $input = array();
        $index = 0;
        $deliminiteddivisi = $data['divisi'];
        $deliminitedbagian = $data['bagian'];
        
        $rowdivisi = explode(',',$deliminiteddivisi);
        $rowbagian = explode(',',$deliminitedbagian);
        $divisi = $rowdivisi[1];
        $Iddivisi = $rowdivisi[0];
        $bagian = $rowbagian[1];
        $Idbagian = $rowbagian[0];
        $strvalidation = "";
        if(isset($data["nama_barang"])){
            $qty = $data['qty'];
            $uom = $data['uom'];
            foreach($data["nama_barang"] as $row){
                $rowbarang = explode(',',$row);
                $barang = $rowbarang[1];
                $Idbarang = $rowbarang[0];
                $NoBarang = $rowbarang[2];
                $Kategori = $rowbarang[3];
                $where = array(
                    'IdBarang'      => strtoupper($Idbarang),
                    'NamaBarang'    => strtoupper($barang),
                    'NoBarang'      => strtoupper($NoBarang),
                    'Kategori'      => strtoupper($Kategori),  
                );
                $cek = $this->m_barangkeluar->cek('inven_barang',$where)->num_rows();
                if($cek > 0){
                    $inven = $this->m_barangkeluar->cek('inven_barang',$where)->row();
                    $datainven = array(
                        'Quantity'          => $inven->Quantity - $qty[$index],
                        'RemainingQuantity' => $inven->RemainingQuantity - $qty[$index],
                        'Id'                => $inven->Id
                    );
        
                    $this->m_barangkeluar->update('inven_barang',$datainven);
                }else{
                    $out['status'] = 'form';
                    $out['msg'] = show_err_msg("Barang ". $barang ." Belum Masuk \r\n", '20px');
                }
    
                array_push($input, array(
                    'IdBarang'      => $Idbarang,
                    'IdDivisi'      => strtoupper($Iddivisi),
                    'Divisi'        => strtoupper($divisi),
                    'IdBagian'      => strtoupper($Idbagian),
                    'Bagian'        => strtoupper($bagian),
                    'NamaBarang'    => strtoupper($barang),
                    'Qty'           => strtoupper($qty[$index]),
                    'Uom'           => strtoupper($uom[$index]),
                    'TglKeluar'     => date("Y-m-d H:i:s"),
                    'CreatedBy'     => $this->session->userdata('nama'),
                    'CreatedUtc'    => date("Y-m-d H:i:s"),
                    'TakenBy'       => $data['nama'],
                    'IsDeleted'     => 0,
                    'Kategori'      => strtoupper($Kategori),
                    'TipePengeluaran'   => 'RUTIN'
                ));
               
            }
        }else{
            $out['status'] = 'form';
            $out['msg'] = show_err_msg("Barang Harus Diisi Dahulu \r\n", '20px');
        }
        
        if(!empty($out)){
            echo json_encode($out);
        }else{

            if(!empty($input)){
                $result = $this->m_barangkeluar->save_batch($input);
                if ($result > 0) {
                    $out['status'] = 'form';
                    $out['msg'] = show_succ_msg('Barang Keluar Berhasil ditambahkan', '20px');
                } else {
                    $out['status'] = 'form';
                    $out['msg'] = show_err_msg('Barang Keluar Gagal ditambahkan', '20px');
                }
            }

            echo json_encode($out);
        }
    }

    public function delete()
    {
        $id = $_POST['id'];
        $where = array(
            'Id' => $id
        );

        $cek = $this->m_barangkeluar->cek('barang_keluar',$where)->row();

        $whereinven = array(
            'IdBarang'      => $cek->IdBarang,
            'NamaBarang'    => $cek->NamaBarang,
        );

        $inven = $this->m_barangkeluar->cek('inven_barang',$whereinven)->row();
        $data = array(
            'Id'            => $id,
            'IsDeleted'      => 1,
        );

        $datainven = array(
            'Quantity'          => $inven->Quantity + $cek->Qty,
            'RemainingQuantity' => $inven->RemainingQuantity + $cek->Qty,
            'Id'                => $inven->Id
        );
        
        $resutinven = $this->m_barangkeluar->update('inven_barang',$datainven);

        $result = $this->m_barangkeluar->update('barang_keluar',$data);

        if ($result > 0 && $resutinven > 0) {
			echo show_succ_msg('Data Berhasil dihapus', '20px');
		} else {
			echo show_err_msg('Data Gagal dihapus', '20px');
        }
    }
}

    
?>