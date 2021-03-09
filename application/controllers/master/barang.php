<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class barang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if($this->session->userdata('status') != "logged")
        {   
            redirect(base_url().'login?alert=belum_login');  
        } 
        $this->load->model('master/m_barang');
        $this->load->model('master/m_kategori');
    }

    public function index()
    {
        $data['Judul'] = 'Barang';
        $data['content'] = 'master/barang/home';

        $where = array(
            "IsDeleted" => 0
        );

        $whereuom = array(
            "IsDelete" => 0
        );

        $databarang = $this->m_barang->cek('barang',$where)->result();
        $data['databarang'] = $databarang;
        $data['kategori'] = $this->m_kategori->cek('kategori',$where)->result();
        $data['uom'] = $this->m_kategori->cek('uom',$whereuom)->result();
        $data['modal_tambah_barang'] = show_my_modal('master/barang/modal/add', 'tambah-barang', $data);
        $data['menu'] = 'master';
        $data['submenu'] = 'barang';
        $data['ses_level'] = $this->session->userdata('level');
        // $this->template->view('master/pt/home', $data);
        $this->load->view('index', $data);
    }

    public function tampil(){
        $where = array(
            "IsDeleted" => 0
        );
        $whereuom = array(
            "IsDelete" => 0
        );

        $data['databarang'] = $this->m_barang->cek('barang',$where)->result();
        $data['kategori'] = $this->m_kategori->cek('kategori',$where)->result();
        $data['uom'] = $this->m_kategori->cek('uom',$whereuom)->result();
        $this->load->view('master/barang/list', $data);
    }

    

    public function add(){
        $this->form_validation->set_rules('nama_barang[]', 'Nama Barang', 'trim|required', 'callback_pt_check');
        $this->form_validation->set_rules('kategori[]', 'Kategori', 'trim|required', 'callback_pt_check');
        $this->form_validation->set_rules('id_pt[]', 'ID PT', 'trim|required', 'callback_pt_check');
        $this->form_validation->set_rules('id_it[]', 'ID IT', 'trim|required', 'callback_pt_check');

        $data = $this->input->post();
        $kategori = $data['kategori'];
        // $idPt = $data['id_pt'];
        // $idIT = $data['id_it'];
        $uom = $data['uom'];
        // var_dump($data);
        $input = array();
        $index = 0;
        
        $strvalidation = "";
        $barang = "";
        // if ($this->form_validation->run() == TRUE) {

                foreach($data["nama_barang"] as $row){
                    
                    $delimitedkategori = $kategori[$index];
                    
                    $rowpt = explode(',',$delimitedkategori);
                    $IdKate = $rowpt[0];
                    $Kate = $rowpt[1];
                    $deliminiteduom = $uom[$index];
                    $rowuom = explode(',',$deliminiteduom);
                    $IdKUom = $rowuom[0];
                    $Uom= $rowuom[1];

                    $where = array(
                        'Nama'      => strtoupper($row),
                        'IdKategori'=> strtoupper($IdKate),
                        'IsDeleted' => 0
                    );

                    $wherebarcode = array(
                        'Nama'      => strtoupper($row),
                        'IdKategori'=> strtoupper($IdKate),
                    );

                    $cek = $this->m_barang->cek('barang',$where)->num_rows();
                    $counter = $this->m_barang->cek('barang',$wherebarcode)->num_rows();
                    $NoBarang = str_pad($counter + 1 + $index, 5, 0, STR_PAD_LEFT);
                    $Barcode = $Kate.$NoBarang;
        
                    if($cek > 0 )
                    {
                        $barang = $barang . $row . ",";
                        // $strvalidation = $strvalidation."Divisi ". $row . " di PT " . $PT . " Sudah Ada \r\n";
                        // $out['status'] = 'form';
                        // $out['msg'] = show_err_msg($strvalidation, '20px');
        
                    }else{
                        array_push($input, array(
                            'NoBarang'  => $Barcode,
                            'Nama'      => strtoupper($row),
                            'IdKategori'=> strtoupper($IdKate),
                            'Kategori'  => strtoupper($Kate),
                            'Uom'       => strtoupper($Uom),
                            'IdUom'     => $IdKUom,
                            'CreatedBy' => $this->session->userdata('nama'),
                            'CreatedUtc'=> date("Y-m-d H:i:s"),
                            'IsDeleted' => 0
                        ));
                    }
                    $index++;
                }

                if($barang != ""){
                    $divisi = substr($barang, 0, -1);
                    $out['status'] = 'form';
                    $out['msg'] = show_err_msg("Barang ".  $barang . " Sudah Ada ", '20px');
                }


                if(!empty($out)){
                    echo json_encode($out);
                }else{

                    if(!empty($input)){
                        $result = $this->m_barang->save_batch($input);
                        if ($result > 0) {
                            $out['status'] = 'form';
                            $out['msg'] = show_succ_msg('Data Barang Berhasil ditambahkan', '20px');
                        } else {
                            $out['status'] = 'form';
                            $out['msg'] = show_err_msg('Data Barang Gagal ditambahkan', '20px');
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
    public function update(){
        $id = trim($_POST['id']);

        $where = array(
            'Id' => $id
        );

        $wherept = array(
            "IsDeleted" => 0
        );

        $data['kategori'] = $this->m_kategori->cek('kategori',$wherept)->result();
        $data['databarang'] = $this->m_barang->cek('barang',$where)->row();

		echo show_my_modal('master/barang/modal/update', 'update-barang', $data);
    }


    public function edit()
    {
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'trim|required');
        $this->form_validation->set_rules('kategori', 'Kategori', 'trim|required');
        $this->form_validation->set_rules('id_pt', 'ID PT', 'trim|required');
        $this->form_validation->set_rules('id_it', 'ID IT', 'trim|required');
        $data = $this->input->post();
        $delimitedkategori = $data['kategori'];
        $rowpt = explode(',',$delimitedkategori);
        $IdKate = $rowpt[0];
        $Kate = $rowpt[1];
        $deliminiteduom =  $data['uom'];
        $rowuom = explode(',',$deliminiteduom);
        $IdKUom = $rowuom[0];
        $Uom= $rowuom[1];

        $where = array(
            'Id' => $data["Id"]
        );

            $wherecek = array(
                'Nama'      => strtoupper($data['nama_barang']),
                'IdKategori'=> strtoupper($IdKate),
                'IsDeleted' => 0
            );

            $cek = $this->m_barang->cek('barang',$wherecek)->num_rows();

            if($cek > 0){
                $out['status'] = 'form';
                $out['msg'] = show_err_msg("Barang ". $data['nama_barang'] . " Sudah Ada \r\n", '20px');
                echo json_encode($out);
            }else{
                $cek = $this->m_barang->cek('barang',$where)->row();
                $data = array(
                    'NoBarang'      => $cek->NoBarang,
                    'Nama'          => strtoupper($data['nama_barang']),
                    'IdKategori'    => strtoupper($IdKate),
                    'Kategori'          => strtoupper($Kate),
                    'Uom'           =>strtoupper($Uom),
                    'IdUom'          =>$IdKUom,
                    'CreatedBy'      => $cek->CreatedBy,
                    'CreatedUtc'     => $cek->CreatedUtc,
                    'UpdatedBy'      => $this->session->userdata('nama'),
                    'UpdateUtc'     => date("Y-m-d H:i:s"),
                    'Id'            => $cek->Id,
                    'IsDeleted'     => 0
                );

                $result = $this->m_barang->update('barang',$data);

                if ($result > 0) {
                    $out['status'] = 'form';
                    $out['msg'] = show_succ_msg('Data Barang Berhasil diupdate', '20px');
                } else {
                    $out['status'] = 'form';
                    $out['msg'] = show_succ_msg('Data Barang Gagal diupdate', '20px');
                }

                echo json_encode($out);
            }
        // if ($this->form_validation->run() == TRUE) {

            
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

        $cek = $this->m_barang->cek('barang',$where)->row();

        $data = array(
            'Id'            => $id,
            'IsDeleted'     => 1
        );

        
        $result = $this->m_barang->update('barang',$data);

        if ($result > 0) {
			echo show_succ_msg('Data Barang Berhasil dihapus', '20px');
		} else {
			echo show_err_msg('Data Barang Gagal dihapus', '20px');
		}
    }

    public function excel(){
        $where = array(
            "IsDeleted" => 0
        );

        $datadivisi = $this->m_barang->cek('barang',$where)->result();

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
                  $excel->setActiveSheetIndex(0)->setCellValue('A1', "Data Barang"); // Set kolom A1 dengan tulisan "DATA SISWA"
                  $excel->getActiveSheet()->mergeCells('A1:F1'); // Set Merge Cell pada kolom A1 sampai E1
                  $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
                  $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
                  $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
                  // Buat header tabel nya pada baris ke 3
                  $excel->setActiveSheetIndex(0)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
                  $excel->setActiveSheetIndex(0)->setCellValue('B3', "Id"); // Set kolom B3 dengan tulisan "NIS"
                  $excel->setActiveSheetIndex(0)->setCellValue('C3', "Nama Barang"); // Set kolom C3 dengan tulisan "NAMA"
                  $excel->setActiveSheetIndex(0)->setCellValue('D3', "Kategori"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
                  $excel->setActiveSheetIndex(0)->setCellValue('E3', "ID PT"); // Set kolom E3 dengan tulisan "ALAMAT"
                  $excel->setActiveSheetIndex(0)->setCellValue('F3', "ID IT"); // Set kolom E3 dengan tulisan "ALAMAT"
                  // Apply style header yang telah kita buat tadi ke masing-masing kolom header
                  $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
                  $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
                  $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
                  $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
                  $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
                  $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
                  // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
                  //$siswa = $this->SiswaModel->view();
                  $no = 1; // Untuk penomoran tabel, di awal set dengan 1
                  $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
                  foreach($datadivisi as $data){ // Lakukan looping pada variabel siswa
                    $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
                    $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->Id);
                    $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->Nama);
                    $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data->Kategori);
                    $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data->IdPT);
                    $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data->IdIT);
                    
                    // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                    $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
                    
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
                  
                  // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
                  $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
                  // Set orientasi kertas jadi LANDSCAPE
                  $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                  // Set judul file excel nya
                  $excel->getActiveSheet(0)->setTitle("Laporan Data Divisi");
                  $excel->setActiveSheetIndex(0);
                  // Proses file excel

                  //$objWriter = new PHPExcel_Writer_Excel2007($excel);
                  $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
                  ob_end_clean();
                  header('Content-Type: application/vnd.ms-excel');
                  header('Content-Disposition: attachment;filename="Barang.xlsx"'); // Set nama file excel nya
                  //header('Cache-Control: max-age=0');
                  
                  $write->save('php://output');
              
    }

    // public function PDF(){
    //     $where = array(
    //         "IsDeleted" => 0
    //     );

    //     $datakategori = $this->m_divisi->cek('divisi',$where)->result();

    //     $tanggal = date('d-m-Y');

    //     include APPPATH.'third_party/fpdf/fpdf.php';

    //     $pdf = new FPDF();
    //     $pdf->AddPage();
    //     $pdf->SetFont('Arial', 'B', 20);
    //     $pdf->Cell(115, 0, "Data Divisi Per ".$tanggal, 0, 1, 'L');
    //     $pdf->SetAutoPageBreak(true, 0);

    //     $pdf->Ln(10);
    //     $pdf->SetFont('Arial', 'B', 12);
    //     $pdf->Cell(10, 8, "No", 1, 0, 'C');
    //     $pdf->Cell(10, 8, "ID", 1, 0, 'C');
    //     $pdf->Cell(35, 8, "Nama Divisi", 1, 0, 'C');
    //     $pdf->Cell(20, 8, "PT", 1, 0, 'C');
    //     // $pdf->Cell(40, 8, "No Telp", 1, 1, 'C');
    //     $pdf->SetFont('', '', 12);

    //     foreach($datakategori as $k => $kategori) {
    //         $this->addRow($pdf, $k+1, $kategori);
    //     }
        
    //     $tanggal = date('d-m-Y');
    //     $pdf->Output(''); 
    // }

    // private function addRow($pdf, $no, $order) {
    //     $pdf->Ln();
    //     $pdf->Cell(10, 8, $no, 1, 0, 'C');
    //     $pdf->Cell(10, 8, $order->Id, 1, 0, 'C');
    //     $pdf->Cell(35, 8, $order->Nama, 1, 0, 'C');
    //     $pdf->Cell(20, 8, $order->PT, 1, 0, 'C');
    //     // $pdf->Cell(40, 8, $order->NoTelp, 1, 0, '');
    //     // $pdf->Cell(35, 8, date('d-m-Y', strtotime($order['tanggal'])), 1, 0, 'C');
    //     // $pdf->Cell(35, 8, $order['jumlah'], 1, 0, 'C');
    //     // $pdf->Cell(50, 8, "Rp. ".number_format($order['total'], 2, ',' , '.'), 1, 1, 'L');
    // }

    // public function upload(){

    //     if ( isset($_POST['import'])) {

    //         $file = $_FILES['divisi']['tmp_name'];

	// 		$ekstensi  = explode('.', $_FILES['divisi']['name']);

	// 		if (empty($file)) {

    //             $this->session->set_flashdata('message', 'File tidak boleh kosong!');
	// 		} else {
	// 			if (strtolower(end($ekstensi)) === 'csv' && $_FILES["divisi"]["size"] > 0) {
    //                 $header = array("Nama", "PT");
	// 				$i = 0;
	// 				$handle = fopen($file, "r");
	// 				while (($row = fgetcsv($handle, 2048))) {
    //                     $i++;
    //                     //echo ($i);
    //                     if ($i == 1) 
    //                     {
    //                         $arr = array($row[0],$row[1]);
    //                         //$validheader = ($header === $row);
    //                         // if($row[0] != "Nama" || $row[1] != "PT"){
    //                         //     $this->session->set_flashdata('message', 'Urutan Kolom Csv Tidak Benar, Silahkan Downliad Template Dahulu');
    //                         //     break;
    //                         // }
    //                         continue;
    //                     } 
    //                     $idPt = 0;
    //                     $where = array(
    //                         'Nama'      => strtoupper($row[0]),
    //                         'PT'        => strtoupper($row[1])
    //                     );
                        
    //                     $wherept = array(
    //                         'Nama'      => strtoupper($row[1]) 
    //                     );
                
    //                     $cek = $this->m_divisi->cek('divisi',$where)->num_rows();
    //                     $counter = $this->m_divisi->getdata('divisi')->num_rows();

    //                     $pt = $this->m_pt->cek('pt',$wherept)->num_rows();
    //                     $counterpt = $this->m_pt->getdata('pt')->num_rows();
    //                     $NoPt = str_pad($counterpt + 1, 5, 0, STR_PAD_LEFT);
    //                     $NoDivisi = str_pad($counter + 1, 5, 0, STR_PAD_LEFT);
                        
    //                     if($pt == 0)
    //                     {
    //                         $data = array(
    //                             'NoPT'      => $NoPt,
    //                             'Nama'      => strtoupper($row[1]),
    //                             'CreateBy'  => $this->session->userdata('nama'),
    //                             'CreateUtc' => date("Y-m-d H:i:s"),
    //                             'IsDeleted' => 0
    //                         );

    //                         $idPt = $this->m_pt->add('pt',$data);

    //                     }

    //                     if($cek > 0 )
    //                     {
    //                         $this->session->set_flashdata('message', 'Gagal Disimpan Data Sudah Ada');

    //                     }
    //                     else 
    //                     {
    //                         $data = array(
    //                             'NoDivisi'  => $NoDivisi,
    //                             'Nama'      => strtoupper($row[0]),
    //                             'PT'        => strtoupper($row[1]),
    //                             'IdPT'      => $idPt,
    //                             'CreateBy'  => $this->session->userdata('nama'),
    //                             'CreateUtc' => date("Y-m-d H:i:s"),
    //                             'IsDeleted' => 0
    //                         );
                
    //                         $this->m_divisi->add('divisi',$data);
    //                         $this->session->set_flashdata('message', 'Berhasil Disimpan');
                
                
    //                     }
	// 				}

	// 				fclose($handle);
	// 				redirect('master/divisi');

	// 			} else {
	// 				echo 'Format file tidak valid!';
	// 			}
	// 		}
    //     }
    // }

    // public function downloadFormat(){

    //     $filename = 'Divisi.csv';
    //     header("Content-Description: File Transfer"); 
    //     header("Content-Disposition: attachment; filename=$filename"); 
    //     header("Content-Type: application/csv; ");

    //     $file = fopen('php://output', 'w');
    //     $header = array("Nama","PT");
    //     fputcsv($file, $header);

    //     fclose($file); 
    //     exit; 
    
    // }
}

?>