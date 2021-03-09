<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class barang_keluar extends CI_Controller{
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
        $data['Judul'] = 'Barang Keluar';
        $data['content'] = 'transaksi/keluar/home';

        $where = array(
            "IsDeleted" => 0
        );

        $wheredata = array(
            "IsDelete" => 0
        );

        // $datapt = $this->m_bagian->cek('bagian',$where)->result();
        // $data['databagian'] = $datapt;
        $data['datakeluar'] = $this->m_barangkeluar->getdata()->result();
        $data['barang'] = $this->m_barangkeluar->cek('barang',$where)->result();
        $data['uom'] = $this->m_barangkeluar->cek('uom',$wheredata)->result();
        $data['divisi'] = $this->m_barangkeluar->cek('divisi',$where)->result();
        $data['permintaan'] = $this->m_barangkeluar->getdata2('SELECT * FROM daftar_permintaan WHERE IsDeleted = 0 AND (Status = "SUDAH DITERIMA" OR Status = "DITERIMA SEBAGIAN") GROUP BY Nama, IdDivisi, IdBagian, IdPT')->result();
        $data['modal_tambah_barang_keluar'] = show_my_modal('transaksi/keluar/modal/add', 'tambah-barangkeluar', $data);
        $data['menu'] = 'transaksi';
        $data['submenu'] = 'barang_keluar';
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

        $data['datakeluar'] = $this->m_barangkeluar->getdata()->result();
        $data['permintaan'] = $this->m_barangkeluar->getdata2('SELECT * FROM daftar_permintaan WHERE IsDeleted = 0 AND (Status = "SUDAH DITERIMA" OR Status = "DITERIMA SEBAGIAN") GROUP BY Nama, IdDivisi, IdBagian, IdPT')->result();
        $this->load->view('transaksi/keluar/list', $data);
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

    function get_detail_permintaan(){
        $data = $this->input->post('id',TRUE);
        $rowsp = explode(',',$data);
        $IdSP= $rowsp[0];
        $Nama = $rowsp[1];
        $IdPT = $rowsp[2];
        $IdBagian = $rowsp[3];
        $IdDivisi = $rowsp[4];
        $Keterangan = $rowsp[5];
        $where1 = array(
            "IsDeleted" => 0,
        );
        $wheredata = array(
            "IsDelete" => 0
        );
        $databarang = $this->m_barangkeluar->cek('barang',$where1)->result();
        $datauom = $this->m_barangkeluar->cek('uom',$wheredata)->result();

        $where = array(
            "Nama" => $Nama,
            "IdPT" => $IdPT,
            "IdBagian" => $IdBagian,
            "IdDivisi" => $IdDivisi,
            "Keterangan" => $Keterangan,
        );

         $result = $this->m_barangkeluar->cek('daftar_permintaan',$where)->result();

        $optionbarang = '';
        $optionuom = '';
        $output = '';
        $index=0;
        foreach($result as $sp){
            if($sp->Qty > 0){
                foreach($databarang as $row){
                    if($row->Id == $sp->IdBarang ){
                        $optionbarang .= '<option value="'.$row->Id.','.$row->Nama.','.$row->NoBarang.','.$row->Kategori.'" selected>'.$row->Nama.' - '.$row->Kategori.'</option>';
                    }else{
                        $optionbarang .= '<option value="'.$row->Id.','.$row->Nama.','.$row->NoBarang.','.$row->Kategori.'">'.$row->Nama.' - '.$row->Kategori.'</option>';
                    }
                }
        
                foreach($datauom as $row){
                    if( $row->Nama == $sp->Uom ){
                        $optionuom .= '<option value="'.$row->Nama.'" selected>'.$row->Nama.'</option>';
                    }else{
                        $optionuom .= '<option value="'.$row->Nama.'">'.$row->Nama.'</option>';
                    }
                }
                $Qty = $sp->Qty - $sp->RemainingQty;
                $output .= '<tr id="inputmany">
                    <td><input type="checkbox" id="ig_checkbox'.$index.'" name="save[]" value="isSave'.$index.'" checked>
                    <label for="ig_checkbox'.$index.'"></label></td>
                    <td><select class="selectpicker form-control" data-live-search="true" name="nama_barang[]" id="nama_barang'.$index.'" disabled readonly>
                    '.$optionbarang.'</select></td>
                    <td><input type="number" name="qty[]" class="form-control" placeholder="Enter Quantity" value='.$Qty. ' id="Quantity'.$index.'" max="'.$Qty.'" required></td>
                    <td><select class="selectpicker form-control" data-live-search="true" name="uom[]" id="uom'.$index.'" required disabled>'.$optionuom.'</select></td>
                    <td><input type="text" name="idpt[]" class="form-control" id="IdPt'.$index.'" placeholder="Enter No Identitas PT" required ></td>
                    <td><input type="text" name="ip[]" class="form-control" id="ip'.$index.'" placeholder="Enter IP Address" required ></td>
                    <td><select class="selectpicker form-control" name="outBy[]" id="outBy'.$index.'">
                                    <option value="">Pilih Tujuan Pengeluaran</option>
                                    <option value="REPLACE">Replace</option>
                                    <option value="UPGRADE">Upgrade</option>
                                    <option value="CANIBAL">Kanibal</option>
                    </select></td>
                    <td class="hidden"><input type="hidden" name="IdSP[]" class="form-control" placeholder="Enter Quantity" value='.$sp->Id. ' required></td>
                    <td class="hidden"><input type="text" name="index[]" value='.$index.'></td>
                    </tr>';
            }
            $index++;
        }

        $datajson = array(
            'data' => $output,
            'total' => $index
        );
        // var_dump(json_encode($datajson));
        echo json_encode($datajson);

    }

    function add_sp(){
        $data = $this->input->post();
        $input = array();
        $index = 0;
        $deliminiteddivisi = $data['divisi'];
        $deliminitedbagian = $data['bagian'];
        $deliminitedpermintaan = $data['sp'];
        $qty = $data['qty'];
        $uom = $data['uom'];
        $idPT = $data['idpt'];
        $ip = $data['ip'];
        $Outfor = $data['outBy'];
        $barangdeliminited = $data['nama_barang'];
        $idminta = $data['IdSP'];
        $rowdivisi = explode(',',$deliminiteddivisi);
        $rowbagian = explode(',',$deliminitedbagian);
        $rowsp = explode(',',$deliminitedpermintaan);
        $divisi = $rowdivisi[1];
        $Iddivisi = $rowdivisi[0];
        $bagian = $rowbagian[1];
        $Idbagian = $rowbagian[0];
        $sp = ''.$rowsp[5].' - ' .$rowsp[1];
        $Idsp = $rowsp[0];
        $strvalidation = "";

        foreach($data["save"] as $row){
            $index = substr($row,-1);
            $rowbarang = explode(',',$barangdeliminited[$index]);
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

            $whereminta = array(
                'Id' => $idminta[$index]
            );

            $cekpermintaan = $this->m_barangkeluar->cek('daftar_permintaan',$whereminta)->row();

            if($cekpermintaan->Qty - $qty[$index] == 0 && $cekpermintaan->RemainingQty == 0 ){
                $datapermintaan = array(
                    'RemainingQty'  => $cekpermintaan->Qty - $qty[$index],
                    'Id' => $Idsp[$index]
                );

                $this->m_barangkeluar->update('daftar_permintaan',$datapermintaan);
            }else{
                $datapermintaan = array(
                    'RemainingQty'  => $cekpermintaan->Qty - $qty[$index],
                    'Id' => $idminta[$index]
                );
                $this->m_barangkeluar->update('daftar_permintaan',$datapermintaan);
            }

            //GENERATE IT ID
            $countarray = count(array_keys($input, $Kategori));
            $it = array(
                'Kategori' => $Kategori
            );
            $countdb = $this->m_barangkeluar->cek('barang_keluar',$it)->num_rows();
            $IDIT = "DL/IT/".str_replace(" ","",$Kategori)."/".str_pad($countarray + 1 + $countdb, 3, 0, STR_PAD_LEFT);
            

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
                'IdSP'          => $Idsp,
                'SP'            => $sp,
                'NoPT'          => strtoupper($idPT[$index]),
                'NoIT'          => $IDIT,
                'IPAddress'     => $ip[$index],
                'Outfor'        => $Outfor[$index],
                'TipePengeluaran'   => 'INVENTARIS'
            ));
           
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
            'Kategori'      => $cek->Kategori,  
        );

        $inven = $this->m_barangkeluar->cek('inven_barang',$whereinven)->row();

        $data = array(
            'Id'            => $id,
            'IsDelete'      => 1,
        );

        $datainven = array(
            'Quantity'          => $inven->Quantity + $cek->Qty,
            'RemainingQuantity' => $inven->RemainingQuantity + $cek->Qty,
            'Id'                => $inven->Id
        );

        
        $resutinven = $this->m_barangkeluar->update('inven_barang',$datainven);

        
        $result = $this->m_barangkeluar->update('barang_masuk',$data);

        if ($result > 0 && $resutinven > 0) {
			echo show_succ_msg('Data Berhasil dihapus', '20px');
		} else {
			echo show_err_msg('Data Gagal dihapus', '20px');
        }
    }
}

    
?>