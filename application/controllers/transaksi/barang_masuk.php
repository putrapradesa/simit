<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class barang_masuk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if($this->session->userdata('status') != "logged")
        {   
            redirect(base_url().'login?alert=belum_login');  
        } 
        $this->load->model('master/m_supplier');
        $this->load->model('transaksi/m_barangmasuk');
        $this->load->model('master/m_barang');
    }

    public function index()
    {
        $data['Judul'] = 'Barang Masuk';
        $data['content'] = 'transaksi/masuk/home';

        $where = array(
            "IsDeleted" => 0
        );

        $wheredata = array(
            "IsDelete" => 0
        );

        // $datapt = $this->m_bagian->cek('bagian',$where)->result();
        // $data['databagian'] = $datapt;
        $data['datamasuk'] = $this->m_barangmasuk->getdata()->result();
        $data['supplier'] = $this->m_supplier->cek('supplier',$where)->result();
        $data['barang'] = $this->m_barangmasuk->cek('barang',$where)->result();
        $data['uom'] = $this->m_barangmasuk->cek('uom',$wheredata)->result();
        $data['permintaan'] = $this->m_barangmasuk->getdata2('SELECT * FROM daftar_permintaan WHERE IsDeleted = 0 AND (Status = "BELUM DITERIMA" OR Status = "DITERIMA SEBAGIAN" ) GROUP BY Nama, IdDivisi, IdBagian, IdPT')->result();
        $data['modal_tambah_barang_masuk'] = show_my_modal('transaksi/masuk/modal/add', 'tambah-barangmasuk', $data);
        $data['menu'] = 'transaksi';
        $data['submenu'] = 'barang_masuk';
        $data['ses_level'] = $this->session->userdata('level');
        
        // $this->template->view('master/pt/home', $data);
        $this->load->view('index', $data);
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
        $databarang = $this->m_barangmasuk->cek('barang',$where1)->result();
        $datauom = $this->m_barangmasuk->cek('uom',$wheredata)->result();

        $where = array(
            "Nama" => $Nama,
            "IdPT" => $IdPT,
            "IdBagian" => $IdBagian,
            "IdDivisi" => $IdDivisi,
            "Keterangan" => $Keterangan,
        );

        $result = $this->m_barangmasuk->cek('daftar_permintaan',$where)->result();

        $optionbarang = '';
        $optionuom = '';
        $output = '';
        $index=0;
        foreach($result as $sp){

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
    
            $output .= '<tr id="inputmany">
                <td><input type="checkbox" id="ig_checkbox'.$index.'" name="save[]" value="isSave'.$index.'" checked>
                <label for="ig_checkbox'.$index.'"></label></td>
                <td><select class="selectpicker form-control" data-live-search="true" name="nama_barang[]" id="nama_barang'.$index.'" disabled readonly>
                '.$optionbarang.'</select></td>
                <td><input type="number" name="qty[]" class="form-control" placeholder="Enter Quantity" value='.$sp->RemainingQty. ' id="Quantity'.$index.'" max="'.$sp->RemainingQty.'" required></td>
                <td><select class="selectpicker form-control" data-live-search="true" name="uom[]" required >'.$optionuom.'</select></td>
                <td class="hidden"><input type="hidden" name="IdSP[]" class="form-control" placeholder="Enter Quantity" value='.$sp->Id. ' required></td>
                <td class="hidden"><input type="text" name="index[]" value='.$index.'>
                </tr>';

            $index++;
        }
        
        $datajson = array(
            'data' => $output,
            'total' => $index
        );
        // var_dump(json_encode($datajson));
        echo json_encode($datajson);

    }

    function get_detail_update(){
        $data = $this->input->post();
        $deliminitedsp = $data['id'];
        $deliminitedbarang = $data['barang'];
        $Qty = $data['Qty'];
        $rowbarang =  explode(',',$deliminitedbarang);
        $barang = $rowbarang[0];
        $IdBarang = $rowbarang[1];
        $Kategori = $rowbarang[3]; 
        $rowsp = explode(',',$deliminitedsp);
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
        $databarang = $this->m_barangmasuk->cek('barang',$where1)->result();
        $datauom = $this->m_barangmasuk->cek('uom',$wheredata)->result();

        $where = array(
            "Nama" => $Nama,
            "IdPT" => $IdPT,
            "IdBagian" => $IdBagian,
            "IdDivisi" => $IdDivisi,
            "Keterangan" => $Keterangan,
            "IdBarang" => $IdBarang,
            "NamaBarang" => $barang,
            "Kategori"  => $Kategori
        );

        $result = $this->m_barangmasuk->cek('daftar_permintaan',$where)->result();

        $optionbarang = '';
        $optionuom = '';
        $output = '';
        $index=0;
        foreach($result as $sp){

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
    
            $output .= '<tr id="inputmany">
                <td class = "hidden"><input type="checkbox" id="ig_checkbox" name="save" value="isSave" checked>
                <label for="ig_checkbox"></label></td>
                <td><select class="selectpicker form-control" data-live-search="true" name="nama_barang" id="nama_barang" disabled readonly>
                '.$optionbarang.'</select></td>
                <td><input type="number" name="qty" class="form-control" placeholder="Enter Quantity" value='.$sp->RemainingQty. ' id="Quantity" max="'.$sp->RemainingQty.'" required></td>
                <td><select class="selectpicker form-control" data-live-search="true" name="uom" required >'.$optionuom.'</select></td>
                <td class="hidden"><input type="hidden" name="IdSP" class="form-control" placeholder="Enter Quantity" value='.$sp->Id. ' required></td>
                <td class="hidden"><input type="text" name="qtybefore" value='.$Qty.'>
                </tr>';

            $index++;
        }
        
        $datajson = array(
            'data' => $output,
            'total' => $index
        );
        // var_dump(json_encode($datajson));
        echo json_encode($datajson);

    }

    public function tampil(){
        $where = array(
            "IsDeleted" => 0
        );

        $wheredata = array(
            "IsDelete" => 0
        );

        $data['datamasuk'] = $this->m_barangmasuk->getdata()->result();
        $data['supplier'] = $this->m_supplier->cek('supplier',$where)->result();
        $data['barang'] = $this->m_barangmasuk->cek('barang',$where)->result();
        $data['uom'] = $this->m_barangmasuk->cek('uom',$wheredata)->result();
        $data['permintaan'] = $this->m_barangmasuk->getdata2('SELECT * FROM daftar_permintaan WHERE IsDeleted = 0 AND Status = "BELUM DITERIMA" OR Status = "DITERIMA SEBAGIAN" GROUP BY Nama, IdDivisi, IdBagian, IdPT')->result();
        $this->load->view('transaksi/masuk/list', $data);
    }

    function add(){

        $this->form_validation->set_rules('nama_barang[]', 'Nama Barang', 'trim|required');
        $this->form_validation->set_rules('qty[]', 'Quantity', 'trim|required');
        $this->form_validation->set_rules('uom[]', 'Satuan', 'trim|required');
        $this->form_validation->set_rules('no_sj', 'Surat Jalan', 'trim|required');
        $this->form_validation->set_rules('supplier', 'Supplier', 'trim|required');
        $this->form_validation->set_rules('tgl_SJ', 'Tanggal Surat Jalan', 'trim|required');
        $this->form_validation->set_rules('no_pr', 'No PR', 'trim|required');


        $data = $this->input->post();
        $input = array();
        $index = 0;
        $deliminitedsupp = $data['supplier'];
        $qty = $data['qty'];
        $uom = $data['uom'];
        $rowsupp = explode(',',$deliminitedsupp);
        $supplier = $rowsupp[1];
        $Idsupplier = $rowsupp[0];
        $strvalidation = "";
        $bagian = "";
        if($data['tipe'] == 'INVENTARIS'){
            $deliminitedpermintaan = $data['sp'];
            $rowsp = explode(',',$deliminitedpermintaan);
            $sp = ''.$rowsp[5].' - ' .$rowsp[1];
            $Idsp = $rowsp[0];
            $barangdeliminited = $data['nama_barang'];
            $idminta = $data['IdSP'];
            foreach($data["save"] as $row){
                $index = substr($row,-1);
                $rowbarang = explode(',',$barangdeliminited[$index]);
                $barang = $rowbarang[1];
                $Idbarang = $rowbarang[0];
                $NoBarang = $rowbarang[2];
                $Kategori = $rowbarang[3]; 

                $where = array(
                    'IdBarang'      => strtoupper($Idbarang),
                    'NamaBarang'        => strtoupper($barang),
                    'NoBarang'    => strtoupper($NoBarang),
                    'Kategori'   => strtoupper($Kategori),  
                );

                $cek = $this->m_barangmasuk->cek('inven_barang',$where)->num_rows();

                if( $cek > 0){
                    $inven = $this->m_barangmasuk->cek('inven_barang',$where)->row();
                    $datainven = array(
                        'Quantity'          => $inven->Quantity + $qty[$index],
                        'RemainingQuantity' => $inven->RemainingQuantity + $qty[$index],
                        'Id'                => $inven->Id
                    );

                    $this->m_barangmasuk->update('inven_barang',$datainven);

                }else{

                    $datainven = array(
                        'IdBarang'          => $Idbarang,
                        'NamaBarang'        => $barang,
                        'Quantity'          => $qty[$index],
                        'Kategori'          => $Kategori,
                        'RemainingQuantity' => $qty[$index],
                        'IsDelete'          => 0,
                        'CreateBy'          => $this->session->userdata('nama'),
                        'CreateUtc'         => date("Y-m-d H:i:s"),
                        'Uom'               => $uom[$index],
                        'NoBarang'          => $NoBarang
                    );

                    $this->m_barangmasuk->add('inven_barang',$datainven);
                }

                $whereminta = array(
                    'Id' => $idminta[$index]
                );
    
                $cekpermintaan = $this->m_barangmasuk->cek('daftar_permintaan',$whereminta)->row();
    
                if($cekpermintaan->RemainingQty - $qty[$index] == 0 ){
                    $datapermintaan = array(
                        'RemainingQty'  => $cekpermintaan->RemainingQty - $qty[$index],
                        'Status'        => 'SUDAH DITERIMA',
                        'Id' => $Idsp[$index]
                    );
    
                    $this->m_barangmasuk->update('daftar_permintaan',$datapermintaan);
                }else{
                    $datapermintaan = array(
                        'Status'           => 'DITERIMA SEBAGIAN',
                        'RemainingQty'  => $cekpermintaan->RemainingQty - $qty[$index],
                        'Id' => $idminta[$index]
                    );
                    $this->m_barangmasuk->update('daftar_permintaan',$datapermintaan);
                }
    
                array_push($input, array(
                    'IdBarang'      => $Idbarang,
                    'NamaBarang'    => strtoupper($barang),
                    'Quantity'      => strtoupper($qty[$index]),
                    'Uom'           => strtoupper($uom[$index]),
                    'IdSupplier'    => strtoupper($Idsupplier),
                    'Kategori'      => strtoupper($Kategori),
                    'NamaSupplier'  => strtoupper($supplier),
                    'TglSJ'         => $data['tgl_sj'],
                    'CreateBy'      => $this->session->userdata('nama'),
                    'CreateUtc'     => date("Y-m-d H:i:s"),
                    'IsDelete'      => 0,
                    'NoSJ'          => $data['no_sj'],
                    'IdSP'          => $Idsp,
                    'SP'            => $sp,
                    'byUsers'       => 0,
                    'TipeTransaksi' => 'PERMINTAAN'
                ));
            }
            
        }else if($data['tipe'] == 'RUTIN'){
            if(isset($data["nama_barang"])){
                foreach($data["nama_barang"] as $row){
                    $rowbarang = explode(',',$row);
                    $barang = $rowbarang[1];
                    $Idbarang = $rowbarang[0];
                    $NoBarang = $rowbarang[2];
                    $Kategori = $rowbarang[3];

                    $where = array(
                        'IdBarang'      => strtoupper($Idbarang),
                        'NamaBarang'        => strtoupper($barang),
                        'NoBarang'    => strtoupper($NoBarang),
                        'Kategori'   => strtoupper($Kategori),  
                    );

                    $cek = $this->m_barangmasuk->cek('inven_barang',$where)->num_rows();

                    if( $cek > 0){
                        $inven = $this->m_barangmasuk->cek('inven_barang',$where)->row();
                        $datainven = array(
                            'Quantity'          => $inven->Quantity + $qty[$index],
                            'RemainingQuantity' => $inven->RemainingQuantity + $qty[$index],
                            'Id'                => $inven->Id
                        );


                        $this->m_barangmasuk->update('inven_barang',$datainven);

                    }else{

                        $datainven = array(
                            'IdBarang'          => $Idbarang,
                            'NamaBarang'        => $barang,
                            'Quantity'          => $qty[$index],
                            'Kategori'          => $Kategori,
                            'RemainingQuantity' => $qty[$index],
                            'IsDelete'          => 0,
                            'CreateBy'          => $this->session->userdata('nama'),
                            'CreateUtc'         => date("Y-m-d H:i:s"),
                            'Uom'               => $uom[$index],
                            'NoBarang'          => $NoBarang
                        );

                        $this->m_barangmasuk->add('inven_barang',$datainven);
                    }

                    array_push($input, array(
                        'IdBarang'      => $Idbarang,
                        'NamaBarang'    => strtoupper($barang),
                        'Quantity'      => strtoupper($qty[$index]),
                        'Uom'           => strtoupper($uom[$index]),
                        'IdSupplier'    => strtoupper($Idsupplier),
                        'Kategori'      => strtoupper($Kategori),
                        'NamaSupplier'  => strtoupper($supplier),
                        'TglSJ'         => $data['tgl_sj'],
                        'CreateBy'      => $this->session->userdata('nama'),
                        'CreateUtc'     => date("Y-m-d H:i:s"),
                        'IsDelete'      => 0,
                        'NoPR'          => $data['no_pr'],
                        'NoSJ'          => $data['no_sj'],
                        'TipeTransaksi' => 'RUTIN',
                        'byUsers'       => 0
                    ));
                }
            }else{
                $out['status'] = 'form';
                $out['msg'] = show_err_msg("Barang Harus Diisi Dahulu \r\n", '20px');
        
            }
            
        }
        if(!empty($out)){
            echo json_encode($out);
        }else{

            if(!empty($input)){
                $result = $this->m_barangmasuk->save_batch($input);
                if ($result > 0) {
                    $out['status'] = 'form';
                    $out['msg'] = show_succ_msg('Barang Masuk Berhasil ditambahkan', '20px');
                } else {
                    $out['status'] = 'form';
                    $out['msg'] = show_err_msg('Barang Masuk Gagal ditambahkan', '20px');
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

        $cek = $this->m_barangmasuk->cek('barang_masuk',$where)->row();

        $whereinven = array(
            'IdBarang'      => $cek->IdBarang,
            'NamaBarang'    => $cek->NamaBarang,
            'Kategori'      => $cek->Kategori,  
        );

        $inven = $this->m_barangmasuk->cek('inven_barang',$whereinven)->row();

        $data = array(
            'Id'            => $id,
            'IsDelete'      => 1,
        );

        $datainven = array(
            'Quantity'          => $inven->Quantity + $cek->Quantity,
            'RemainingQuantity' => $inven->RemainingQuantity + $cek->Quantity,
            'Id'                => $inven->Id
        );

        
        $resutinven = $this->m_barangmasuk->update('inven_barang',$datainven);

        
        $result = $this->m_barangmasuk->update('barang_masuk',$data);

        if ($result > 0 && $resutinven > 0) {
			echo show_succ_msg('Data Berhasil dihapus', '20px');
		} else {
			echo show_err_msg('Data Gagal dihapus', '20px');
		}
    }

    public function update(){
        $id = trim($_POST['id']);

        $where = array(
            'Id' => $id,
            "IsDelete" => 0
        );

        $wherept = array(
            "IsDeleted" => 0
        );

        $wheredata = array(
            "IsDelete" => 0
        );


        $data['datamasuk'] = $this->m_barangmasuk->cek('barang_masuk',$where)->row();
        $data['supplier'] = $this->m_supplier->cek('supplier',$wherept)->result();
        $data['barang'] = $this->m_barangmasuk->cek('barang',$wherept)->result();
        $data['uom'] = $this->m_barangmasuk->cek('uom',$wheredata)->result();
        $data['permintaan'] = $this->m_barangmasuk->getdata2('SELECT * FROM daftar_permintaan WHERE IsDeleted = 0 AND (Status = "BELUM DITERIMA" OR Status = "DITERIMA SEBAGIAN") GROUP BY Nama, IdDivisi, IdBagian, IdPT')->result();

		echo show_my_modal('transaksi/masuk/modal/update', 'update-barang-masuk', $data);
    }

    public function excel()
    {
        $where = array(
            "IsDelete" => 0
        );

        $datadivisi = $this->m_barangmasuk->cek('barang_masuk',$where)->result();

        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
        
        $excel = new PHPExcel();
        
        $excel->getProperties()->setCreator($this->session->userdata('Nama'))
                 ->setLastModifiedBy($this->session->userdata('Nama'))
                 ->setTitle("Data Divisi")
                 ->setSubject("Divisi")
                //  ->setDescridivisiion("Laporan Semua Data Division")
                 ->setKeywords("Data Divisi");
        $style_col = array(
                    'font' => array('bold' => true), // Set font nya jadi bold
                    'alignment' => array(
                      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                    ),
                    'borders' => array(
                      'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                      'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                      'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                      'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
                    )
                  );
                  $style_row = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                    ),
                    'borders' => array(
                      'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                      'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                      'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                      'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
                    )
                  );
                  $excel->setActiveSheetIndex(0)->setCellValue('A1', "Data Barang Masuk"); // Set kolom A1 dengan tulisan "DATA SISWA"
                  $excel->getActiveSheet()->mergeCells('A1:F1'); // Set Merge Cell pada kolom A1 sampai E1
                  $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
                  $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
                  $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
                  // Buat header tabel nya pada baris ke 3
                  $excel->setActiveSheetIndex(0)->setCellValue('A3', "No"); // Set kolom A3 dengan tulisan "NO"
                  $excel->setActiveSheetIndex(0)->setCellValue('B3', "No PR"); // Set kolom B3 dengan tulisan "NIS"
                  $excel->setActiveSheetIndex(0)->setCellValue('C3', "No SJ"); // Set kolom C3 dengan tulisan "NAMA"
                  $excel->setActiveSheetIndex(0)->setCellValue('D3', "Nama Barang"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
                  $excel->setActiveSheetIndex(0)->setCellValue('E3', "Supplier"); // Set kolom E3 dengan tulisan "ALAMAT"
                  $excel->setActiveSheetIndex(0)->setCellValue('F3', "Tanggal Terima"); // Set kolom E3 dengan tulisan "ALAMAT"
                  $excel->setActiveSheetIndex(0)->setCellValue('G3', "Jumlah");
                  $excel->setActiveSheetIndex(0)->setCellValue('H3', "Penerima");
                  // Apply style header yang telah kita buat tadi ke masing-masing kolom header
                  $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
                  $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
                  $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
                  $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
                  $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
                  $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
                  $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
                  $excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
                  // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
                  //$siswa = $this->SiswaModel->view();
                  $no = 1; // Untuk penomoran tabel, di awal set dengan 1
                  $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
                  foreach($datadivisi as $data){ // Lakukan looping pada variabel siswa
                    $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
                    $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->NoPR);
                    $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->NoSJ);
                    $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data->NamaBarang);
                    $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data->NamaSupplier);
                    $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, dateFormat($data->CreateUtc));
                    $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data->Quantity);
                    $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $data->CreateBy);
                    
                    // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                    $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
                    
                    $no++; // Tambah 1 setiap kali looping
                    $numrow++; // Tambah 1 setiap kali looping
                  }
                  // Set width kolom
                  $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
                  $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
                  $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
                  $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
                  $excel->getActiveSheet()->getColumnDimension('E')->setWidth(30); // Set width kolom E
                  $excel->getActiveSheet()->getColumnDimension('F')->setWidth(30); // Set width kolom E
                  $excel->getActiveSheet()->getColumnDimension('G')->setWidth(30); // Set width kolom E
                  $excel->getActiveSheet()->getColumnDimension('H')->setWidth(30); // Set width kolom E
                  
                  // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
                  $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
                  // Set orientasi kertas jadi LANDSCAPE
                  $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                  // Set judul file excel nya
                  $excel->getActiveSheet(0)->setTitle("Laporan Data Barang Masuk");
                  $excel->setActiveSheetIndex(0);
                  // Proses file excel

                  //$objWriter = new PHPExcel_Writer_Excel2007($excel);
                  $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
                  ob_end_clean();
                  header('Content-Type: application/vnd.ms-excel');
                  header('Content-Disposition: attachment;filename="Barang_Masuk.xlsx"'); // Set nama file excel nya
                  //header('Cache-Control: max-age=0');
                  
                  $write->save('php://output');
              
    }

    // public function getReport(){
    //     $data = $this->input->post();
    //     $report = $this->m_barangmasuk->getdata2('SELECT * FROM barang_masuk WHERE CreateUtc BETWEEN "'.$data['start_date']'" AND "'$data['date_to']'"')->result();

    //     $out = ''
    //     $index = 1;
    //     foreach ($report as $row) {
    //         $out .= '<td>"'.$index.'"</td>
    //                  <td>"'.dateFormat($row->CreateUtc).'"</td>
    //                  <td>"'.$row->NamaBarang.'"</td>
    //                  <td>"'.$row->Quantity.'"</td>'

    //         $index++
    //     };

    //     echo json_encode($out);
    // }

}
?>