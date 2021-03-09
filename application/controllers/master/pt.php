<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class pt extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if($this->session->userdata('status') != "logged")
        {   
            redirect(base_url().'login?alert=belum_login');  
        } 
        $this->load->model('master/m_pt');
    }

    public function index()
    {
        $data['Judul'] = 'PT.';
        $data['content'] = 'master/pt/home';

        $where = array(
            "IsDeleted" => 0
        );

        $datapt = $this->m_pt->cek('pt',$where)->result();
        $data['datapt'] = $datapt;
        $data['modal_tambah_pt'] = show_my_modal('master/pt/modal/add', 'tambah-pt', $data);
        $data['menu'] = 'master';
        $data['submenu'] = 'pt';
        $data['ses_level'] = $this->session->userdata('level');
        // $this->template->view('master/pt/home', $data);
        $this->load->view('index', $data);
    }

    public function tampil(){
        $where = array(
            "IsDeleted" => 0
        );
        $data['datapt'] = $this->m_pt->cek('pt',$where)->result();
        $this->load->view('master/pt/list', $data);
    }

    public function pt_check() {
        $pt =  $this->input->post('nama_pt');

        $where = array(
            'Nama'      => strtoupper($pt),
        );
        $cek = $this->m_pt->cek('pt',$where)->num_rows();
        if($cek > 0 ){
            return TRUE;
        }else{
            return FALSE;
        }

    }

    public function add(){
        $this->form_validation->set_rules('nama_pt[]', 'Nama PT', 'trim|required', 'callback_pt_check');

        $data = $this->input->post();
        // var_dump($data);
        $input = array();
        $index = 0;
        
        if ($this->form_validation->run() == TRUE) {

                
                    $where = array(
                        'Nama'      => strtoupper($data["nama_pt"]),
                        'IsDeleted' => 0
                    );
        
                    $cek = $this->m_pt->cek('pt',$where)->num_rows();
                    $counter = $this->m_pt->getdata('pt')->num_rows();
                    $NoPt = str_pad($counter + 1, 5, 0, STR_PAD_LEFT);
        
                    if($cek > 0 )
                    {
                        $out['status'] = 'form';
                        $out['msg'] = show_err_msg('PT '. $data["nama_pt"] . ' Sudah Ada', '20px');
        
                    }else{
                        array_push($input, array(
                            'NoPT'      => $NoPt,
                            'Nama'      => strtoupper($data["nama_pt"]),
                            'CreateBy'  => $this->session->userdata('nama'),
                            'CreateUtc' => date("Y-m-d H:i:s"),
                            'IsDeleted' => 0  // Ambil dan set data alamat sesuai index array dari $index
                        ));
                    }
                    // $index++;
                
                // var_dump($input);

                if(!empty($input)){
                    $result = $this->m_pt->save_batch($input);
                    if ($result > 0) {
                        $out['status'] = 'form';
                        $out['msg'] = show_succ_msg('Data PT Berhasil ditambahkan', '20px');
                    } else {
                        $out['status'] = 'form';
                        $out['msg'] = show_err_msg('Data PT Gagal ditambahkan', '20px');
                    }
                }
		} else {
			$out['status'] = 'form';
			$out['msg'] = show_err_msg(validation_errors());
        }
        echo json_encode($out);
    }
    public function update(){
        $id = trim($_POST['id']);

        $where = array(
            'Id' => $id
        );

		$data['datapt'] = $this->m_pt->cek('pt',$where)->row();

		echo show_my_modal('master/pt/modal/update', 'update-pt', $data);
    }


    public function edit()
    {
        $this->form_validation->set_rules('nama_pt', 'Nama PT', 'trim|required');
        $data = $this->input->post();

        $where = array(
            'Id' => $data["Id"]
        );

        if ($this->form_validation->run() == TRUE) {

            $cek = $this->m_pt->cek('pt',$where)->row();
            $data = array(
                'NoPT'=> $cek->NoPT,
                'Nama'      => strtoupper($data["nama_pt"]),
                'CreateBy'  => $cek->CreateBy,
                'CreateUtc' => $cek->CreateUtc,
                'UpdateBy'  => $this->session->userdata('nama'),
                'UpdateUtc' => date("Y-m-d H:i:s"),
                'Id'        => $data["Id"],
                'IsDeleted' => 0
            );

			$result = $this->m_pt->update('pt',$data);

			if ($result > 0) {
				$out['status'] = '';
				$out['msg'] = show_succ_msg('Data PT Berhasil diupdate', '20px');
			} else {
				$out['status'] = '';
				$out['msg'] = show_succ_msg('Data PT Gagal diupdate', '20px');
			}
		} else {
			$out['status'] = 'form';
			$out['msg'] = show_err_msg(validation_errors());
		}

		echo json_encode($out);
    }

    public function delete()
    {
        $id = $_POST['id'];
        $where = array(
            'Id' => $id
        );

        $cek = $this->m_pt->cek('pt',$where)->row();

        $data = array(
            'NoPT'=> $cek->NoPT,
            'Nama'      => $cek->Nama,
            'CreateBy'  => $cek->CreatedBy,
            'CreateUtc' => $cek->CreatedUtc,
            'UpdateBy'  => $cek->UpdateBy,
            'UpdateUtc' => $cek->UpdateUtc,
            'Id'        => $cek->Id,
            'IsDeleted' => 1
        );

        
        $result = $this->m_pt->update('pt',$data);

        if ($result > 0) {
			echo show_succ_msg('Data PT Berhasil dihapus', '20px');
		} else {
			echo show_err_msg('Data PT Gagal dihapus', '20px');
		}
    }

    public function excel(){
        $where = array(
            "IsDeleted" => 0
        );

        $datakategori = $this->m_pt->cek('pt',$where)->result();

        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
        
        $excel = new PHPExcel();
        
        $excel->getProperties()->setCreator($this->session->userdata('Nama'))
                 ->setLastModifiedBy($this->session->userdata('Nama'))
                 ->setTitle("Data PT")
                 ->setSubject("PT")
                 ->setDescription("Laporan Semua Data PT")
                 ->setKeywords("Data PT");
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
                  // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
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
                  $excel->setActiveSheetIndex(0)->setCellValue('A1', "Data PT"); // Set kolom A1 dengan tulisan "DATA SISWA"
                  $excel->getActiveSheet()->mergeCells('A1:C1'); // Set Merge Cell pada kolom A1 sampai E1
                  $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
                  $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
                  $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
                  // Buat header tabel nya pada baris ke 3
                  $excel->setActiveSheetIndex(0)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
                  $excel->setActiveSheetIndex(0)->setCellValue('B3', "Id"); // Set kolom B3 dengan tulisan "NIS"
                  $excel->setActiveSheetIndex(0)->setCellValue('C3', "Nama PT"); // Set kolom C3 dengan tulisan "NAMA"
                //   $excel->setActiveSheetIndex(0)->setCellValue('D3', "Alamat"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
                //   $excel->setActiveSheetIndex(0)->setCellValue('E3', "No Telp"); // Set kolom E3 dengan tulisan "ALAMAT"
                  // Apply style header yang telah kita buat tadi ke masing-masing kolom header
                  $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
                  $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
                  $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
                //   $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
                //   $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
                  // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
                  //$siswa = $this->SiswaModel->view();
                  $no = 1; // Untuk penomoran tabel, di awal set dengan 1
                  $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
                  foreach($datakategori as $data){ // Lakukan looping pada variabel siswa
                    $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
                    $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->Id);
                    $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->Nama);
                    // $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data->Alamat);
                    // $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data->NoTelp);
                    
                    // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                    $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
                    // $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
                    // $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
                    
                    $no++; // Tambah 1 setiap kali looping
                    $numrow++; // Tambah 1 setiap kali looping
                  }
                  // Set width kolom
                  $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
                  $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
                  $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
                //   $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
                //   $excel->getActiveSheet()->getColumnDimension('E')->setWidth(30); // Set width kolom E
                  
                  // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
                  $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
                  // Set orientasi kertas jadi LANDSCAPE
                  $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                  // Set judul file excel nya
                  $excel->getActiveSheet(0)->setTitle("Laporan Data PT");
                  $excel->setActiveSheetIndex(0);
                  // Proses file excel

                  //$objWriter = new PHPExcel_Writer_Excel2007($excel);
                  $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
                  ob_end_clean();
                  header('Content-Type: application/vnd.ms-excel');
                  header('Content-Disposition: attachment;filename="PT.xlsx"'); // Set nama file excel nya
                  //header('Cache-Control: max-age=0');
                  
                  $write->save('php://output');
              
    }

    // public function PDF(){
    //     $where = array(
    //         "IsDeleted" => 0
    //     );

    //     $datakategori = $this->m_pt->cek('pt',$where)->result();

    //     $tanggal = date('d-m-Y');

    //     include APPPATH.'third_party/fpdf/fpdf.php';

    //     $pdf = new FPDF();
    //     $pdf->AddPage();
    //     $pdf->SetFont('Arial', 'B', 20);
    //     $pdf->Cell(115, 0, "Data PT Per ".$tanggal, 0, 1, 'L');
    //     $pdf->SetAutoPageBreak(true, 0);

    //     $pdf->Ln(10);
    //     $pdf->SetFont('Arial', 'B', 12);
    //     $pdf->Cell(10, 8, "No", 1, 0, 'C');
    //     $pdf->Cell(10, 8, "ID", 1, 0, 'C');
    //     $pdf->Cell(35, 8, "Nama", 1, 0, 'C');
    //     // $pdf->Cell(55, 8, "Alamat", 1, 0, 'C');
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
    //     // $pdf->Cell(55, 8, $order->Alamat, 1, 0, '');
    //     // $pdf->Cell(40, 8, $order->NoTelp, 1, 0, '');
    //     // $pdf->Cell(35, 8, date('d-m-Y', strtotime($order['tanggal'])), 1, 0, 'C');
    //     // $pdf->Cell(35, 8, $order['jumlah'], 1, 0, 'C');
    //     // $pdf->Cell(50, 8, "Rp. ".number_format($order['total'], 2, ',' , '.'), 1, 1, 'L');
    // }

    // public function upload(){

    //     if ( isset($_POST['import'])) {

    //         $file = $_FILES['pt']['tmp_name'];

	// 		// Medapatkan ekstensi file csv yang akan diimport.
	// 		$ekstensi  = explode('.', $_FILES['pt']['name']);

	// 		// Tampilkan peringatan jika submit tanpa memilih menambahkan file.
	// 		if (empty($file)) {

    //             $this->session->set_flashdata('message', 'File tidak boleh kosong!');
	// 			// echo 'File tidak boleh kosong!';
	// 		} else {
	// 			// Validasi apakah file yang diupload benar-benar file csv.
	// 			if (strtolower(end($ekstensi)) === 'csv' && $_FILES["pt"]["size"] > 0) {
    //                 $header = array("Nama PT");
	// 				$i = 0;
	// 				$handle = fopen($file, "r");
	// 				while (($row = fgetcsv($handle, 2048))) {
    //                     $i++;
    //                     //echo ($i);
    //                     if ($i == 1) 
    //                     {
    //                         // $validheader = ($header === $row);
    //                         // if($row[0] == "Nama PT"){
    //                         //     $this->session->set_flashdata('message', 'Urutan Kolom Csv Tidak Benar, Silahkan Downliad Template Dahulu');
    //                         //     break;
    //                         // }
    //                         continue;
    //                     } 
                        
    //                     $where = array(
    //                         'Nama'      => strtoupper($row[0]),
    //                     );  
                
    //                     $cek = $this->m_pt->cek('pt',$where)->num_rows();
    //                     $counter = $this->m_pt->getdata('pt')->num_rows();
    //                     $NoPt = str_pad($counter + 1, 5, 0, STR_PAD_LEFT);
                
    //                     if($cek > 0 )
    //                     {
    //                         $this->session->set_flashdata('message', 'Gagal Disimpan Data Sudah Ada');
    //                         // redirect(base_url().'/master/pt?alert=gagal');
                
    //                     }else
    //                     {
    //                         $data = array(
    //                             'NoPT'      => $NoPt,
    //                             'Nama'      => strtoupper($row[0]),
    //                             'CreateBy'  => $this->session->userdata('nama'),
    //                             'CreateUtc' => date("Y-m-d H:i:s"),
    //                             'IsDeleted' => 0
    //                         );
                
    //                         $this->m_pt->add('pt',$data);
    //                         $this->session->set_flashdata('message', 'Berhasil Disimpan');
    //                         // redirect('master/pt');
                
                
    //                     }
	// 				}

	// 				fclose($handle);
	// 				redirect('master/pt');

	// 			} else {
	// 				echo 'Format file tidak valid!';
	// 			}
	// 		}
    //     }
    // }

    // public function downloadFormat(){
        
    //     include APPPATH.'third_party/PHPExcel/PHPExcel.php';

    //     $csv = new PHPExcel();

    //     $csv->getProperties()->setCreator('PT')
    //              ->setLastModifiedBy('PT')
    //              ->setTitle("PT")
    //              ->setSubject("PT")
    //              ->setDescription("PT")
    //              ->setKeywords("PT");

    //     $csv->setActiveSheetIndex(0)->setCellValue('A1', "Nama PT"); // Set kolom A1 dengan tulisan "NO"
    //     // $csv->setActiveSheetIndex(0)->setCellValue('B1', "Alamat"); // Set kolom B1 dengan tulisan "NIS"
    //     // $csv->setActiveSheetIndex(0)->setCellValue('C1', "No Telp"); // Set kolom C1 dengan tulisan "NAMA"

    //     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //     header('Content-Disposition: attachment; filename="PT.csv"'); // Set nama file excel nya
    //     header('Cache-Control: max-age=0');
    //     $write = new PHPExcel_Writer_CSV($csv);
    //     $write->save('php://output');
    // }
}

?>