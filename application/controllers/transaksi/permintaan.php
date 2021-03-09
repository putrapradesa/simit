<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class permintaan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if($this->session->userdata('status') != "logged")
        {   
            redirect(base_url().'login?alert=belum_login');  
        } 
        $this->load->model('transaksi/m_permintaan');
    }

    public function index()
    {
        $data['Judul'] = 'Daftar Permintaan';
        $data['content'] = 'transaksi/daftar_permintaan/home';

        $where = array(
            "IsDeleted" => 0
        );

        $wheredata = array(
            "IsDelete" => 0
        );

        // $datapt = $this->m_bagian->cek('bagian',$where)->result();
        // $data['databagian'] = $datapt;
        $data['datapermintaan'] = $this->m_permintaan->query('SELECT * FROM daftar_permintaan WHERE IsDeleted = 0 ORDER BY CreatedUtc DESC')->result();
        $data['pt'] = $this->m_permintaan->cek('pt',$where)->result();
        $data['barang'] = $this->m_permintaan->cek('barang',$where)->result();
        $data['uom'] = $this->m_permintaan->cek('uom',$wheredata)->result();
        $data['modal_tambah_daftar_permintaan'] = show_my_modal('transaksi/daftar_permintaan/modal/add', 'tambah-permintaan', $data);
        $data['menu'] = 'transaksi';
        $data['submenu'] = 'daftar_permintaan';
        $data['ses_level'] = $this->session->userdata('level');
        // $this->template->view('master/pt/home', $data);
        $this->load->view('index', $data);
    }

    public function tampil(){

        $postData = $this->input->post();
        // var_dump($postData);
        $where = array(
            "IsDeleted" => 0
        );

        $wheredata = array(
            "IsDelete" => 0
        );

        $fetch_data = $this->m_permintaan->get_all_data($postData);
        $data = array();
        $no = 1;
        foreach($fetch_data['aaData'] as $row){
            $sub_array = array();
            $sub_array[] = '<td style="width:5%">'.$no.'</td>';
            $sub_array[] = '<td style="width:5%">'.dateFormat($row->TglPermintaan).'</td>';
            $sub_array[] = '<td style="width:5%">'.$row->Nama.'</td>';
            $sub_array[] = '<td style="width:5%">'.$row->PT.'</td>';
            $sub_array[] = '<td style="width:5%">'.$row->Divisi.'</td>';
            $sub_array[] = '<td style="width:5%">'.$row->Bagian.'</td>';
            $sub_array[] = '<td style="width:5%">'.$row->Keterangan.'</td>';
            $sub_array[] = '<td style="width:5%">'.$row->Barang.'</td>';
            $sub_array[] = '<td style="width:5%">'.$row->Qty.'</td>';
            $sub_array[] = '<td style="width:5%">'.$row->Status.'</td>';
            $sub_array[] = '<td style="width:10%"><button class="btn btn-danger waves-effect btn-sm konfirmasiHapus-daftarpermintaan" data-id="'.$row->Id.'" data-toggle="modal" data-target="#konfirmasiHapus"><i class="material-icons">close</i><span>Hapus</span></button></td>';
            $data[] = $sub_array;
            $no++;
        };

        $output = array(  
            "draw"                    =>     intval($_POST["draw"]),  
            "recordsTotal"            =>     $fetch_data['iTotalRecords'],  
            "recordsFiltered"         =>     $fetch_data['iTotalDisplayRecords'],  
            "data"                    =>     $data  
       );  
       echo json_encode($output);  
        //var_dump($data['datapermintaan']);
        // $data['supplier'] = $this->m_permintaan->cek('pt',$where)->result();
        // $data['barang'] = $this->m_permintaan->cek('barang',$where)->result();
        // $data['uom'] = $this->m_permintaan->cek('uom',$wheredata)->result();


        // $this->load->view('transaksi/daftar_permintaan/list', $data);
    }

    public function get_divisi(){
        $data = $this->input->post('id',TRUE);
        $rowpt = explode(',',$data);
        $PT = $rowpt[1];
        $IdPt = $rowpt[0];

        $where = array(
            "IdPT" => $IdPt
        );

        $result = $this->m_permintaan->cek('divisi',$where)->result();

        $output = '<option value="">--Pilih Divisi--</option>';

        foreach($result as $row){
            $output .= '<option value="'.$row->Id.','.$row->Nama.','.$row->IdPT.'">'.$row->Nama.'</option>';
        }

        echo json_encode($output);

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



        $result = $this->m_permintaan->cek('bagian',$where)->result();

        $output = '<option value="">--Pilih Divisi--</option>';

        foreach($result as $row){
            $output .= '<option value="'.$row->Id.','.$row->Nama.'">'.$row->Nama.'</option>';
        }

        echo json_encode($output);

    }
    function add(){

        $this->form_validation->set_rules('nama_barang[]', 'Nama Barang', 'trim|required');
        $this->form_validation->set_rules('qty[]', 'Quantity', 'trim|required');
        $this->form_validation->set_rules('uom[]', 'Satuan', 'trim|required');
        $this->form_validation->set_rules('nama_pemohon', 'Nama Pemohon', 'trim|required');
        $this->form_validation->set_rules('tgl_permintaan', 'Tanggal Permintaan', 'trim|required');
        $this->form_validation->set_rules('pt', 'PT', 'trim|required');
        $this->form_validation->set_rules('divisi', 'Divisi', 'trim|required');
        $this->form_validation->set_rules('bagian', 'Bagian', 'trim|required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');


        $data = $this->input->post();
        $input = array();
        $index = 0;
        $deliminitedpt = $data['pt'];
        $deliminiteddivisi = $data['divisi'];
        $deliminitedbagian = $data['bagian'];
        $qty = $data['qty'];
        $uom = $data['uom'];
        $rowpt = explode(',',$deliminitedpt);
        $rowdivisi = explode(',',$deliminiteddivisi);
        $rowbagian = explode(',',$deliminitedbagian);
        $pt = $rowpt[1];
        $Idpt = $rowpt[0];
        $divisi = $rowdivisi[1];
        $Iddivisi = $rowdivisi[0];
        $bagian = $rowbagian[1];
        $Idbagian = $rowbagian[0];
        $strvalidation = "";

        if(isset($data["nama_barang"])){
            foreach($data["nama_barang"] as $row){
                    $rowbarang = explode(',',$row);
                    $barang = $rowbarang[1];
                    $Idbarang = $rowbarang[0];
                    $NoBarang = $rowbarang[2];
                    $Kategori = $rowbarang[3];

                    array_push($input, array(
                        'Nama'          => $data['nama_pemohon'],
                        'IdDivisi'      => $Iddivisi,
                        'Divisi'        => strtoupper($divisi),
                        'IdBagian'      => $Idbagian,
                        'Bagian'        => strtoupper($bagian),
                        'Keterangan'    => $data['keterangan'],
                        'TglPermintaan' => $data['tgl_permintaan'],
                        'IdBarang'      => $Idbarang,
                        'Barang'        => $barang,
                        'Qty'           => $qty[$index],
                        'Uom'           => $uom[$index],
                        'Status'        => 'BELUM DITERIMA',
                        'IsDeleted'     => 0,
                        'CreatedBy'     => $this->session->userdata('nama'),
                        'CreatedUtc'    => date("Y-m-d H:i:s"),
                        'IdPT'          => $Idpt,
                        'PT'            => $pt,
                        'NoBarang'      => $NoBarang,
                        'Kategori'      => $Kategori,
                        'RemainingQty'  => $qty[$index]
                    ));
                $index++;
            }
        }else
        {
            $out['status'] = 'form';
            $out['msg'] = show_err_msg("Barang Harus Diisi Dahulu \r\n", '20px');
        }

        // if($bagian != ""){
        //     $bagian = substr($bagian, 0, -1);
        //     $out['status'] = 'form';
        //     $out['msg'] = show_err_msg("Bagian ".  $bagian . " di PT " . $PT . " di Divisi " . $Divisi .  " Sudah Ada ", '20px');
        // }


        if(!empty($out)){
            echo json_encode($out);
        }else{

            if(!empty($input)){
                $result = $this->m_permintaan->save_batch($input);
                if ($result > 0) {
                    $out['status'] = 'form';
                    $out['msg'] = show_succ_msg('Daftar Permintaan Berhasil ditambahkan', '20px');
                } else {
                    $out['status'] = 'form';
                    $out['msg'] = show_err_msg('Daftar Permintaan Gagal ditambahkan', '20px');
                }
            }

            echo json_encode($out);
        }
                // var_dump($input);

               
		// } else {
		// 	$out['status'] = 'form';
		// 	$out['msg'] = show_err_msg(validation_errors());
        // }
        
    }

    public function delete()
    {
        $id = $_POST['id'];
        $where = array(
            'Id' => $id
        );

        $result = $this->m_permintaan->cek('daftar_permintaan',$where)->row();

        $data = array(
                'IsDeleted'     => 1,
                'Id'            => $id
        );

        
        $resultdelete = $this->m_permintaan->update('daftar_permintaan',$data);

        if ($resultdelete > 0) {
			echo show_succ_msg('Data Berhasil dihapus', '20px');
		} else {
			echo show_err_msg('Data Gagal dihapus', '20px');
		}
    }

    public function excel(){
        $where = array(
            "IsDelete" => 0
        );

        $datadivisi = $this->m_permintaan->query('SELECT * FROM daftar_permintaan WHERE IsDeleted = 0 ORDER BY CreatedUtc DESC')->result();
        
        var_dump($datadivisi);

        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
        
        $excel = new PHPExcel();
        
        $excel->getProperties()->setCreator($this->session->userdata('Nama'))
                 ->setLastModifiedBy($this->session->userdata('Nama'))
                 ->setTitle("Data Permintaan")
                 ->setSubject("Permintaan")
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
                  $excel->setActiveSheetIndex(0)->setCellValue('A1', "Data Permintaan"); // Set kolom A1 dengan tulisan "DATA SISWA"
                  $excel->getActiveSheet()->mergeCells('A1:F1'); // Set Merge Cell pada kolom A1 sampai E1
                  $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
                  $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
                  $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
                  // Buat header tabel nya pada baris ke 3
                  $excel->setActiveSheetIndex(0)->setCellValue('A3', "No"); // Set kolom A3 dengan tulisan "NO"
                  $excel->setActiveSheetIndex(0)->setCellValue('B3', "Tanggal Permintaan"); // Set kolom B3 dengan tulisan "NIS"
                  $excel->setActiveSheetIndex(0)->setCellValue('C3', "Nama Pemohon"); // Set kolom C3 dengan tulisan "NAMA"
                  $excel->setActiveSheetIndex(0)->setCellValue('D3', "PT"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
                  $excel->setActiveSheetIndex(0)->setCellValue('E3', "Divisi"); // Set kolom E3 dengan tulisan "ALAMAT"
                  $excel->setActiveSheetIndex(0)->setCellValue('F3', "Bagian"); // Set kolom E3 dengan tulisan "ALAMAT"
                  $excel->setActiveSheetIndex(0)->setCellValue('G3', "Keterangan");
                  $excel->setActiveSheetIndex(0)->setCellValue('H3', "Nama Barang");
                  $excel->setActiveSheetIndex(0)->setCellValue('I3', "Jumlah");
                  $excel->setActiveSheetIndex(0)->setCellValue('J3', "Status");
                  // Apply style header yang telah kita buat tadi ke masing-masing kolom header
                  $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
                  $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
                  $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
                  $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
                  $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
                  $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
                  $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
                  $excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
                  $excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
                  $excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
                  // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
                  //$siswa = $this->SiswaModel->view();
                  $no = 1; // Untuk penomoran tabel, di awal set dengan 1
                  $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
                  foreach($datadivisi as $data){ // Lakukan looping pada variabel siswa
                    $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
                    $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, dateFormat($data->TglPermintaan));
                    $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->Nama);
                    $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data->PT);
                    $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data->Divisi);
                    $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data->Bagian);
                    $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data->Keterangan);
                    $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $data->Barang);
                    $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $data->Qty);
                    if($row->IsReceived == 0){
                        $excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, 'Belum Diterima'); 
                    }else{
                        $excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, 'Sudah Diterima');
                    }
                    
                    // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                    $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
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
                  $excel->getActiveSheet()->getColumnDimension('I')->setWidth(30); // Set width kolom E
                  $excel->getActiveSheet()->getColumnDimension('J')->setWidth(30); // Set width kolom E
                  
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
                  header('Content-Disposition: attachment;filename="Daftar_Permintaan.xlsx"'); // Set nama file excel nya
                  //header('Cache-Control: max-age=0');
                  
                  $write->save('php://output');
              
    }


    

}
?>