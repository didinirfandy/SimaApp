<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Print_excel extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Laporan_model');
        $this->load->model('Kib_model');
        $this->load->model('Pemeliharaan_aset_model');
    }

    public function export_kib_a()
    {
        if (isset($_POST['cetak_a'])) {

            $tgl_awal  = $this->input->post('tgl_awal');
            $tgl_akhir = $this->input->post('tgl_akhir');
            $kategori  = $this->input->post('kategori');
            $thn_beli  = $this->input->post('thn_beli');
            
            $dt_kib_a  = $this->Kib_model->get_data_kib_a_ctk($tgl_awal, $tgl_akhir, $kategori, $thn_beli);

            if ($dt_kib_a != "0") {

                // Load plugin PHPExcel nya
                include APPPATH . 'third_party/PHPExcel.php';

                // Panggil class PHPExcel nya
                $excel = new PHPExcel();

                date_default_timezone_set('Asia/Jakarta');
                $date   =   date("mY");

                // Settingan awal fil excel
                $excel->getProperties()->setCreator('Wakasek SIMA SMAN 3 Cimahi (' . $this->session->userdata('username') . ')')
                    ->setLastModifiedBy('Wakasek SIMA SMAN 3 Cimahi (' . $this->session->userdata('username') . ')')
                    ->setTitle("Data Laporan KIB A " . $date)
                    ->setSubject("Laporan KIB A " . $date)
                    ->setDescription("Data Laporan KIB A " . $date)
                    ->setKeywords("Data Laporan KIB A " . $date);

                // Buat sebuah variabel untuk menampung pengaturan style dari TITLE tabel
                $style_tit = array(
                    'font' => array('bold' => true), // Set font nya jadi bold
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                    )
                );

                // Buat sebuah variabel untuk menampung pengaturan style dari TITLE tabel
                $style_ket = array(
                    'font' => array('bold' => true), // Set font nya jadi bold
                    'alignment' => array(
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                    )
                );

                // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
                $style_col = array(
                    'font' => array('bold' => true), // Set font nya jadi bold
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                        'wrap' => true
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
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                        'wrap' => true
                    ),
                    'borders' => array(
                        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
                    )
                );

                // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
                $style_row_center = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                        'wrap' => true
                    ),
                    'borders' => array(
                        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
                    )
                );

                // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
                $style_row_nm = array(
                    'font' => array(
                        'bold' => true, // Set font nya jadi bold
                        'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE,
                        'strike'    => false
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                        'wrap' => true
                    )
                );

                // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
                $style_row_ttd = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                        'wrap' => true
                    )
                );

                $tgl_indo = tgl_indo_bsr(date("Y-m-d"));

                // Buat header tabel nya pada baris ke 1
                $excel->setActiveSheetIndex(0)->mergeCells('A1:W1');
                $excel->setActiveSheetIndex(0)->setCellValue('A1', "PEMERINTAH KOTA CIMAHI");
                $excel->setActiveSheetIndex(0)->mergeCells('A2:W2');
                $excel->setActiveSheetIndex(0)->setCellValue('A2', "KARTU INVENTARIS BARANG ( KIB A )");
                $excel->setActiveSheetIndex(0)->mergeCells('A3:W3');
                $excel->setActiveSheetIndex(0)->setCellValue('A3', "TANAH");
                $excel->setActiveSheetIndex(0)->mergeCells('A4:W4');
                $excel->setActiveSheetIndex(0)->setCellValue('A4', "PER " . $tgl_indo);

                // Apply style header yang telah kita buat tadi ke masing-masing kolom header
                $excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('A2')->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                // Buat Keterangan 
                $excel->setActiveSheetIndex(0)->setCellValue('A5', "PROVINSI");
                $excel->setActiveSheetIndex(0)->setCellValue('D5', ": JAWA BARAT");
                $excel->setActiveSheetIndex(0)->setCellValue('A6', "KABUPATEN/KOTA");
                $excel->setActiveSheetIndex(0)->setCellValue('D6', ": CIMAHI");
                $excel->setActiveSheetIndex(0)->setCellValue('A7', "BIDANG");
                $excel->setActiveSheetIndex(0)->setCellValue('D7', ": PENDIDIKAN");
                $excel->setActiveSheetIndex(0)->setCellValue('A8', "UNIT ORGANISASI");
                $excel->setActiveSheetIndex(0)->setCellValue('D8', ": DINAS PENDIDIKAN PEMUDA DAN OLAH RAGA");
                $excel->setActiveSheetIndex(0)->setCellValue('A9', "SUB UNUT ORGANISASI");
                $excel->setActiveSheetIndex(0)->setCellValue('D9', ": DINAS PENDIDIKAN PEMUDA DAN OLAH RAGA");
                $excel->setActiveSheetIndex(0)->setCellValue('A10', "UPB");
                $excel->setActiveSheetIndex(0)->setCellValue('D10', ": SAMAN 3 CIMAHI");
                $excel->setActiveSheetIndex(0)->setCellValue('A11', "NO KODE LOKASI");
                $excel->setActiveSheetIndex(0)->setCellValue('D11', ": ");

                // Apply style Keterangan yang telah kita buat tadi ke masing-masing kolom Keterangan
                $excel->getActiveSheet()->getStyle('A5')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D5')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('A6')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D6')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('A7')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D7')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('A8')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D8')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('A9')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D9')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('A10')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D10')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('A11')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D11')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                // Buat Table Head
                $excel->setActiveSheetIndex(0)->mergeCells('A13:A16');
                $excel->setActiveSheetIndex(0)->setCellValue('A13', "No");
                $excel->setActiveSheetIndex(0)->mergeCells('B13:B16');
                $excel->setActiveSheetIndex(0)->setCellValue('B13', "Jenis Barang / Nama Barang");
                $excel->setActiveSheetIndex(0)->mergeCells('C13:D13');
                $excel->setActiveSheetIndex(0)->setCellValue('C13', "Nomor");
                $excel->setActiveSheetIndex(0)->mergeCells('C14:C16');
                $excel->setActiveSheetIndex(0)->setCellValue('C14', "Kode Barang");
                $excel->setActiveSheetIndex(0)->mergeCells('D14:D16');
                $excel->setActiveSheetIndex(0)->setCellValue('D14', "Register");
                $excel->setActiveSheetIndex(0)->mergeCells('E13:E16');
                $excel->setActiveSheetIndex(0)->setCellValue('E13', "Luas (m2)");
                $excel->setActiveSheetIndex(0)->mergeCells('F13:F16');
                $excel->setActiveSheetIndex(0)->setCellValue('F13', "Tahun Pengadaan");
                $excel->setActiveSheetIndex(0)->mergeCells('G13:G16');
                $excel->setActiveSheetIndex(0)->setCellValue('G13', "Letak/Alamat");
                $excel->setActiveSheetIndex(0)->mergeCells('H13:J13');
                $excel->setActiveSheetIndex(0)->setCellValue('H13', "Status Tanah");
                $excel->setActiveSheetIndex(0)->mergeCells('H14:H16');
                $excel->setActiveSheetIndex(0)->setCellValue('H14', "Hak");
                $excel->setActiveSheetIndex(0)->mergeCells('I14:J14');
                $excel->setActiveSheetIndex(0)->setCellValue('I14', "Sertifikat");
                $excel->setActiveSheetIndex(0)->mergeCells('I15:I16');
                $excel->setActiveSheetIndex(0)->setCellValue('I15', "Tanggal");
                $excel->setActiveSheetIndex(0)->mergeCells('J15:J16');
                $excel->setActiveSheetIndex(0)->setCellValue('J15', "Nomor");
                $excel->setActiveSheetIndex(0)->mergeCells('K13:K16');
                $excel->setActiveSheetIndex(0)->setCellValue('K13', "Penggunaan");
                $excel->setActiveSheetIndex(0)->mergeCells('L13:L16');
                $excel->setActiveSheetIndex(0)->setCellValue('L13', "Asal - Usul");
                $excel->setActiveSheetIndex(0)->mergeCells('M13:M16');
                $excel->setActiveSheetIndex(0)->setCellValue('M13', "Harga (Rp)");
                $excel->setActiveSheetIndex(0)->mergeCells('N13:T13');
                $excel->setActiveSheetIndex(0)->setCellValue('N13', "HASIL INVENTARISASI");
                $excel->setActiveSheetIndex(0)->mergeCells('N14:P14');
                $excel->setActiveSheetIndex(0)->setCellValue('N14', "Keberadaan fisik");
                $excel->setActiveSheetIndex(0)->mergeCells('Q14:R14');
                $excel->setActiveSheetIndex(0)->setCellValue('Q14', "Dokumentasi Kepemilikan");
                $excel->setActiveSheetIndex(0)->mergeCells('S14:T14');
                $excel->setActiveSheetIndex(0)->setCellValue('S14', "Penguasaan");
                $excel->setActiveSheetIndex(0)->mergeCells('N15:N16');
                $excel->setActiveSheetIndex(0)->setCellValue('N15', "Ada");
                $excel->setActiveSheetIndex(0)->mergeCells('O15:O16');
                $excel->setActiveSheetIndex(0)->setCellValue('O15', "Tidak Ada");
                $excel->setActiveSheetIndex(0)->mergeCells('P15:P16');
                $excel->setActiveSheetIndex(0)->setCellValue('P15', "Belum Tercatat");
                $excel->setActiveSheetIndex(0)->mergeCells('Q15:Q16');
                $excel->setActiveSheetIndex(0)->setCellValue('Q15', "Ada");
                $excel->setActiveSheetIndex(0)->mergeCells('R15:R16');
                $excel->setActiveSheetIndex(0)->setCellValue('R15', "Tidak Ada");
                $excel->setActiveSheetIndex(0)->mergeCells('S15:S16');
                $excel->setActiveSheetIndex(0)->setCellValue('S15', "Sendiri");
                $excel->setActiveSheetIndex(0)->mergeCells('T15:T16');
                $excel->setActiveSheetIndex(0)->setCellValue('T15', "Pihak Lain");
                $excel->setActiveSheetIndex(0)->mergeCells('U13:U16');
                $excel->setActiveSheetIndex(0)->setCellValue('U13', "Harga Satuan");
                $excel->setActiveSheetIndex(0)->mergeCells('V13:V16');
                $excel->setActiveSheetIndex(0)->setCellValue('V13', "Jumlah");
                $excel->setActiveSheetIndex(0)->mergeCells('W13:W16');
                $excel->setActiveSheetIndex(0)->setCellValue('W13', "Keterangan");

                // Apply style Table Head yang telah kita buat tadi ke masing-masing kolom Table Head
                $excel->getActiveSheet()->getStyle('A13')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('A14')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('A15')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('A16')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B13')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B14')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B15')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B16')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('C13')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('C14')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('C15')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D13')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D14')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D15')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D16')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('E13')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('E14')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('E15')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('E16')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('F13')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('F14')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('F15')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('F16')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('G13')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('G14')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('G15')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('G16')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('H13')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('H14')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('H15')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('H16')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('I13')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('I14')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('I15')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('I16')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('J13')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('J14')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('J15')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('J16')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('K13')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('K14')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('K15')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('K16')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('L13')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('L14')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('L15')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('L16')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('M13')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('M14')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('M15')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('M16')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('N13')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('N14')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('N15')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('N16')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('O13')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('O14')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('O15')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('O16')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('P13')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('P14')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('P15')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('P16')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('Q13')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('Q14')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('Q15')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('Q16')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('R13')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('R14')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('R15')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('R16')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('S13')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('S14')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('S15')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('S16')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('T13')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('T14')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('T15')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('T16')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('U13')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('U14')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('U15')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('U16')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('V13')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('V14')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('V15')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('V16')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('W13')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('W14')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('W15')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('W16')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);


                $no = 17;
                // Buat Numbering
                $excel->setActiveSheetIndex(0)->setCellValue('A' . $no, "1");
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $no, "2");
                $excel->setActiveSheetIndex(0)->setCellValue('C' . $no, "3");
                $excel->setActiveSheetIndex(0)->setCellValue('D' . $no, "4");
                $excel->setActiveSheetIndex(0)->setCellValue('E' . $no, "5");
                $excel->setActiveSheetIndex(0)->setCellValue('F' . $no, "6");
                $excel->setActiveSheetIndex(0)->setCellValue('G' . $no, "7");
                $excel->setActiveSheetIndex(0)->setCellValue('H' . $no, "8");
                $excel->setActiveSheetIndex(0)->setCellValue('I' . $no, "9");
                $excel->setActiveSheetIndex(0)->setCellValue('J' . $no, "10");
                $excel->setActiveSheetIndex(0)->setCellValue('K' . $no, "11");
                $excel->setActiveSheetIndex(0)->setCellValue('L' . $no, "12");
                $excel->setActiveSheetIndex(0)->setCellValue('M' . $no, "13");
                $excel->setActiveSheetIndex(0)->setCellValue('N' . $no, "14");
                $excel->setActiveSheetIndex(0)->setCellValue('O' . $no, "15");
                $excel->setActiveSheetIndex(0)->setCellValue('P' . $no, "16");
                $excel->setActiveSheetIndex(0)->setCellValue('Q' . $no, "17");
                $excel->setActiveSheetIndex(0)->setCellValue('R' . $no, "18");
                $excel->setActiveSheetIndex(0)->setCellValue('S' . $no, "19");
                $excel->setActiveSheetIndex(0)->setCellValue('T' . $no, "20");
                $excel->setActiveSheetIndex(0)->setCellValue('U' . $no, "21");
                $excel->setActiveSheetIndex(0)->setCellValue('V' . $no, "22");
                $excel->setActiveSheetIndex(0)->setCellValue('W' . $no, "23");

                // Apply style header yang telah kita buat tadi ke masing-masing kolom header
                $excel->getActiveSheet()->getStyle('A' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('C' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('E' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('F' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('G' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('H' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('I' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('J' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('K' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('L' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('M' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('N' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('O' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('P' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('Q' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('R' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('S' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('T' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('U' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('V' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('W' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                // Menampilkan data
                $numrow = 18; // Set baris pertama untuk isi tabel adalah baris ke 9
                $p = 1;
                $totrow = 0;

                foreach ($dt_kib_a as $i) { // Lakukan looping pada variabel
                    if ($i['st_stfkt_tgl'] == "0000-00-00") {
                        $st_stfkt_tgl = "";
                    } else {
                        $st_stfkt_tgl = $i['st_stfkt_tgl'];
                    }

                    if ($i['thn_pengadaan'] == "0") {
                        $thn_pengadaan = "";
                    } else {
                        $thn_pengadaan = $i['thn_pengadaan'];
                    }

                    if ($i['luas'] == "0") {
                        $luas = "";
                    } else {
                        $luas = $i['luas'];
                    }

                    if ($i['hi_dk_a'] != "Ada") {
                        $hi_dk_a = "";
                    } else {
                        $hi_dk_a = "√";
                    }

                    if ($i['hi_dk_ta'] != "Tidak Ada") {
                        $hi_dk_ta = "";
                    } else {
                        $hi_dk_ta = "√";
                    }

                    if ($i['hi_p_s'] != "Sendiri") {
                        $hi_p_s = "";
                    } else {
                        $hi_p_s = "√";
                    }

                    if ($i['hi_p_pl'] != "Pihak Lain") {
                        $hi_p_pl = "";
                    } else {
                        $hi_p_pl = "√";
                    }

                    $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $p);
                    $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $i['nm_brg']);
                    $excel->setActiveSheetIndex(0)->setCellValueExplicit('C' . $numrow, $i['kd_brg'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $excel->setActiveSheetIndex(0)->setCellValueExplicit('D' . $numrow, $i['no_reg'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $luas);
                    $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $thn_pengadaan);
                    $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $i['letak_lokasi']);
                    $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $i['st_hak']);
                    $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $st_stfkt_tgl);
                    $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $i['st_stfkt_no']);
                    $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, "SMAN 3 CIMAHI");
                    $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $i['perolehan']);
                    $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, number_format("$i[harga]", 2, ",", "."));
                    $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, $i['hi_kf_a']);
                    $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, $i['hi_kf_ta']);
                    $excel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, $i['hi_kf_bt']);
                    $excel->setActiveSheetIndex(0)->setCellValue('Q' . $numrow, $hi_dk_a);
                    $excel->setActiveSheetIndex(0)->setCellValue('R' . $numrow, $hi_dk_ta);
                    $excel->setActiveSheetIndex(0)->setCellValue('S' . $numrow, $hi_p_s);
                    $excel->setActiveSheetIndex(0)->setCellValue('T' . $numrow, $hi_p_pl);
                    $excel->setActiveSheetIndex(0)->setCellValue('U' . $numrow, number_format("$i[harga]", 2, ",", "."));
                    $excel->setActiveSheetIndex(0)->setCellValue('V' . $numrow, number_format("$i[harga]", 2, ",", "."));
                    $excel->setActiveSheetIndex(0)->setCellValue('W' . $numrow, $i['ket']);

                    // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                    $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row_center)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('M' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('N' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('O' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('P' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('Q' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('R' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('S' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('T' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('U' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('V' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('W' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                    $totrow = $numrow++; // Tambah 1 setiap kali looping
                    $p++;
                }

                $row1 = $totrow + 2;
                $row2 = $totrow + 3;
                $row3 = $totrow + 8;
                $row4 = $totrow + 9;
                $row5 = $totrow + 10;
                $row6 = $totrow + 14;
                $row7 = $totrow + 19;

                // Buat Kolom Tanda tanggan
                $excel->setActiveSheetIndex(0)->mergeCells('B' . $row1 . ':C' . $row1);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $row1, "Mengetahui");
                $excel->setActiveSheetIndex(0)->mergeCells('B' . $row2 . ':C' . $row2);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $row2, "Kepala SMA Negeri 3 Cimahi");
                $excel->setActiveSheetIndex(0)->mergeCells('B' . $row3 . ':C' . $row3);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $row3, "Dra, Hj. Mimin Hermiati, MM");
                $excel->setActiveSheetIndex(0)->mergeCells('B' . $row4 . ':C' . $row4);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $row4, "Pembina Utama Muda");
                $excel->setActiveSheetIndex(0)->mergeCells('B' . $row5 . ':C' . $row5);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $row5, "NIP. 195611181980032004");

                $excel->setActiveSheetIndex(0)->mergeCells('K' . $row2 . ':L' . $row2);
                $excel->setActiveSheetIndex(0)->setCellValue('K' . $row2, "Wakasek Sarana");
                $excel->setActiveSheetIndex(0)->mergeCells('K' . $row3 . ':L' . $row3);
                $excel->setActiveSheetIndex(0)->setCellValue('K' . $row3, "Sri Purwanti, SE. MM");
                $excel->setActiveSheetIndex(0)->mergeCells('K' . $row4 . ':L' . $row4);
                $excel->setActiveSheetIndex(0)->setCellValue('K' . $row4, "NIP. 196412161987032005");

                $excel->setActiveSheetIndex(0)->mergeCells('K' . $row6 . ':L' . $row6);
                $excel->setActiveSheetIndex(0)->setCellValue('K' . $row6, "Ketua Komite");
                $excel->setActiveSheetIndex(0)->mergeCells('K' . $row7 . ':L' . $row7);
                $excel->setActiveSheetIndex(0)->setCellValue('K' . $row7, "Dr. Ir. Handoyo Harjdo. M, Eng");

                $excel->setActiveSheetIndex(0)->mergeCells('U' . $row2 . ':V' . $row2);
                $excel->setActiveSheetIndex(0)->setCellValue('U' . $row2, "Pengurus Barang");
                $excel->setActiveSheetIndex(0)->mergeCells('U' . $row3 . ':V' . $row3);
                $excel->setActiveSheetIndex(0)->setCellValue('U' . $row3, "Dadang Yana Suryana");
                $excel->setActiveSheetIndex(0)->mergeCells('U' . $row4 . ':V' . $row4);
                $excel->setActiveSheetIndex(0)->setCellValue('U' . $row4, "NIP. 197004102010011004");


                // Apply style tanda tangan yang telah kita buat tadi ke masing-masing kolom tanda tangan
                $excel->getActiveSheet()->getStyle('B' . $row1)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B' . $row2)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B' . $row3)->applyFromArray($style_row_nm)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B' . $row4)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B' . $row5)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                $excel->getActiveSheet()->getStyle('K' . $row2)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('K' . $row3)->applyFromArray($style_row_nm)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('K' . $row4)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                $excel->getActiveSheet()->getStyle('K' . $row6)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('K' . $row7)->applyFromArray($style_row_nm)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                $excel->getActiveSheet()->getStyle('U' . $row2)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('U' . $row3)->applyFromArray($style_row_nm)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('U' . $row4)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                // Set width kolom
                $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('Q')->setWidth(13);
                $excel->getActiveSheet()->getColumnDimension('R')->setWidth(13);
                $excel->getActiveSheet()->getColumnDimension('S')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('T')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('U')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('V')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('W')->setWidth(20);

                // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
                $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

                // Set orientasi kertas jadi LANDSCAPE
                $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

                date_default_timezone_set('Asia/Jakarta');
                $date   =   date("mY");

                // Set judul file excel nya
                $excel->getActiveSheet(0)->setTitle("Data Laporan KIB A");
                $excel->setActiveSheetIndex(0);

                // Proses file excel
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment; filename="Data Laporan KIB A ' . $date . '.xlsx"'); // Set nama file excel nya
                header('Cache-Control: max-age=0');

                header('Content-Transfer-Encoding: binary');
                header('Accept-Ranges: bytes');
                header('Cache-control: no-cache, pre-check=0, post-check=0');
                header('Cache-control: private');
                header('Pragma: private');
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // any date in the past

                $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
                $write->save('php://output');
            } else {
                $this->session->set_flashdata('statusgagal', 'Membuat Laporan!!!');
                redirect('Lp_kib/lp_kib_a');
            }
        }
    }

    public function export_kib_b()
    {
        if (isset($_POST['cetak_b'])) {
            $tgl_awal  = $this->input->post('tgl_awal');
            $tgl_akhir = $this->input->post('tgl_akhir');
            $kategori  = $this->input->post('kategori');
            $thn_beli  = $this->input->post('thn_beli');

            $dt_kib_b  = $this->Kib_model->get_data_kib_b_ctk($tgl_awal, $tgl_akhir, $kategori, $thn_beli);

            if ($dt_kib_b != "0") {

                // Load plugin PHPExcel nya
                include APPPATH . 'third_party/PHPExcel.php';

                // Panggil class PHPExcel nya
                $excel = new PHPExcel();

                date_default_timezone_set('Asia/Jakarta');
                $date   =   date("mY");

                // Settingan awal fil excel
                $excel->getProperties()->setCreator('Wakasek SIMA SMAN 3 Cimahi (' . $this->session->userdata('username') . ')')
                    ->setLastModifiedBy('Wakasek SIMA SMAN 3 Cimahi (' . $this->session->userdata('username') . ')')
                    ->setTitle("Data Laporan KIB B " . $date)
                    ->setSubject("Laporan KIB B " . $date)
                    ->setDescription("Data Laporan KIB B " . $date)
                    ->setKeywords("Data Laporan KIB B " . $date);

                // Buat sebuah variabel untuk menampung pengaturan style dari TITLE tabel
                $style_tit = array(
                    'font' => array('bold' => true), // Set font nya jadi bold
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                    )
                );

                // Buat sebuah variabel untuk menampung pengaturan style dari ket tabel
                $style_ket = array(
                    'font' => array('bold' => true), // Set font nya jadi bold
                    'alignment' => array(
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                    )
                );

                // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
                $style_col = array(
                    'font' => array('bold' => true), // Set font nya jadi bold
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                        'wrap' => true
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
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                        'wrap' => true
                    ),
                    'borders' => array(
                        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
                    )
                );

                // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
                $style_row_center = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                        'wrap' => true
                    ),
                    'borders' => array(
                        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
                    )
                );

                // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
                $style_row_nm = array(
                    'font' => array(
                        'bold' => true, // Set font nya jadi bold
                        'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE,
                        'strike'    => false
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                        'wrap' => true
                    )
                );

                // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
                $style_row_ttd = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                        'wrap' => true
                    )
                );

                $tgl_indo = tgl_indo_bsr(date("Y-m-d"));

                // Buat header tabel nya pada baris ke 1
                $excel->setActiveSheetIndex(0)->mergeCells('A1:S1');
                $excel->setActiveSheetIndex(0)->setCellValue('A1', "PEMERINTAH KOTA CIMAHI");
                $excel->setActiveSheetIndex(0)->mergeCells('A2:S2');
                $excel->setActiveSheetIndex(0)->setCellValue('A2', "KARTU INVENTARIS BARANG ( KIB B )");
                $excel->setActiveSheetIndex(0)->mergeCells('A3:S3');
                $excel->setActiveSheetIndex(0)->setCellValue('A3', "PERALATAN DAN MESIN");
                $excel->setActiveSheetIndex(0)->mergeCells('A4:S4');
                $excel->setActiveSheetIndex(0)->setCellValue('A4', "PER " . $tgl_indo);

                // Stayle untuk header
                $excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('A2')->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                // Buat Keterangn
                $excel->setActiveSheetIndex(0)->setCellValue('B5', "SKPD");
                $excel->setActiveSheetIndex(0)->setCellValue('D5', ": 1.01.01.115.SMUN 3 CIMAHI");
                $excel->setActiveSheetIndex(0)->setCellValue('B6', "KABUPATEN/KOTA");
                $excel->setActiveSheetIndex(0)->setCellValue('D6', ": KOTA CIMAHI");
                $excel->setActiveSheetIndex(0)->setCellValue('B7', "PROVINSI");
                $excel->setActiveSheetIndex(0)->setCellValue('D7', ": JAWA BARAT");
                $excel->setActiveSheetIndex(0)->setCellValue('B8', "NO KODE LOKASI");
                $excel->setActiveSheetIndex(0)->setCellValue('D8', ": ");

                // Style Untuk keterangan
                $excel->getActiveSheet()->getStyle('B5')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D5')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B6')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D6')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B7')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D7')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B8')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D8')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                // Buat Table head
                $excel->setActiveSheetIndex(0)->mergeCells('A10:A11');
                $excel->setActiveSheetIndex(0)->setCellValue('A10', "No");
                $excel->setActiveSheetIndex(0)->mergeCells('B10:B11');
                $excel->setActiveSheetIndex(0)->setCellValue('B10', "Kode Barang");
                $excel->setActiveSheetIndex(0)->mergeCells('C10:C11');
                $excel->setActiveSheetIndex(0)->setCellValue('C10', "Jenis Barang / Nama Barang");
                $excel->setActiveSheetIndex(0)->mergeCells('D10:D11');
                $excel->setActiveSheetIndex(0)->setCellValue('D10', "Kode Register");
                $excel->setActiveSheetIndex(0)->mergeCells('E10:E11');
                $excel->setActiveSheetIndex(0)->setCellValue('E10', "Merk/Type");
                $excel->setActiveSheetIndex(0)->mergeCells('F10:F11');
                $excel->setActiveSheetIndex(0)->setCellValue('F10', "Ukuran / CC");
                $excel->setActiveSheetIndex(0)->mergeCells('G10:G11');
                $excel->setActiveSheetIndex(0)->setCellValue('G10', "Bahan");
                $excel->setActiveSheetIndex(0)->mergeCells('H10:H11');
                $excel->setActiveSheetIndex(0)->setCellValue('H10', "Tahun Beli");
                $excel->setActiveSheetIndex(0)->mergeCells('I10:M10');
                $excel->setActiveSheetIndex(0)->setCellValue('I10', "Nomor");
                $excel->setActiveSheetIndex(0)->setCellValue('I11', "Pabrik");
                $excel->setActiveSheetIndex(0)->setCellValue('J11', "Rangka");
                $excel->setActiveSheetIndex(0)->setCellValue('K11', "Mesin");
                $excel->setActiveSheetIndex(0)->setCellValue('L11', "Polisi");
                $excel->setActiveSheetIndex(0)->setCellValue('M11', "BPKB");
                $excel->setActiveSheetIndex(0)->mergeCells('N10:N11');
                $excel->setActiveSheetIndex(0)->setCellValue('N10', "Asal - Usul / Cara Perolehan");
                $excel->setActiveSheetIndex(0)->mergeCells('O10:O11');
                $excel->setActiveSheetIndex(0)->setCellValue('O10', "Kondisi");
                $excel->setActiveSheetIndex(0)->mergeCells('P10:P11');
                $excel->setActiveSheetIndex(0)->setCellValue('P10', "Harga");
                $excel->setActiveSheetIndex(0)->mergeCells('Q10:Q11');
                $excel->setActiveSheetIndex(0)->setCellValue('Q10', "Umur Ekonomis");
                $excel->setActiveSheetIndex(0)->mergeCells('R10:R11');
                $excel->setActiveSheetIndex(0)->setCellValue('R10', "Nilai Sisa");
                $excel->setActiveSheetIndex(0)->mergeCells('S10:S11');
                $excel->setActiveSheetIndex(0)->setCellValue('S10', "Keterangan");

                // Style untuk table head
                $excel->getActiveSheet()->getStyle('A10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('A11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('C10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('C11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('E10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('E11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('F10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('F11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('G10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('G11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('H10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('H11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('I10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('I11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('J10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('J11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('K10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('K11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('L10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('L11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('M10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('M11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('N10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('N11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('O10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('O11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('P10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('P11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('Q10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('Q11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('R10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('R11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('S10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('S11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                $no = 12;
                // Buat Numbering
                $excel->setActiveSheetIndex(0)->setCellValue('A' . $no, "1");
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $no, "2");
                $excel->setActiveSheetIndex(0)->setCellValue('C' . $no, "3");
                $excel->setActiveSheetIndex(0)->setCellValue('D' . $no, "4");
                $excel->setActiveSheetIndex(0)->setCellValue('E' . $no, "5");
                $excel->setActiveSheetIndex(0)->setCellValue('F' . $no, "6");
                $excel->setActiveSheetIndex(0)->setCellValue('G' . $no, "7");
                $excel->setActiveSheetIndex(0)->setCellValue('H' . $no, "8");
                $excel->setActiveSheetIndex(0)->setCellValue('I' . $no, "9");
                $excel->setActiveSheetIndex(0)->setCellValue('J' . $no, "10");
                $excel->setActiveSheetIndex(0)->setCellValue('K' . $no, "11");
                $excel->setActiveSheetIndex(0)->setCellValue('L' . $no, "12");
                $excel->setActiveSheetIndex(0)->setCellValue('M' . $no, "13");
                $excel->setActiveSheetIndex(0)->setCellValue('N' . $no, "14");
                $excel->setActiveSheetIndex(0)->setCellValue('O' . $no, "15");
                $excel->setActiveSheetIndex(0)->setCellValue('P' . $no, "16");
                $excel->setActiveSheetIndex(0)->setCellValue('Q' . $no, "17");
                $excel->setActiveSheetIndex(0)->setCellValue('R' . $no, "18");
                $excel->setActiveSheetIndex(0)->setCellValue('S' . $no, "19");

                // Apply style numbering yang telah kita buat tadi ke masing-masing kolom numbering
                $excel->getActiveSheet()->getStyle('A' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('C' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('E' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('F' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('G' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('H' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('I' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('J' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('K' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('L' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('M' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('N' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('O' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('P' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('Q' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('R' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('S' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                // Menampilkan data
                $numrow = 13; // Set baris pertama untuk isi tabel adalah baris ke 9
                $p = 1;
                $totrow = 0;

                foreach ($dt_kib_b as $i) { // Lakukan looping pada variabel
                    if ($i['ukuran_cc'] == "0") {
                        $ukuran_cc = "";
                    } else {
                        $ukuran_cc = $i['ukuran_cc'];
                    }

                    if ($i['kondisi'] == 1) {
                        $kondisi = "Baik";
                    } elseif ($i['kondisi'] == 2) {
                        $kondisi = "Rusak Ringan";
                    } elseif ($i['kondisi'] == 3) {
                        $kondisi = "Rusak Berat";
                    } else {
                        $kondisi = "";
                    }

                    $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $p);
                    $excel->setActiveSheetIndex(0)->setCellValueExplicit('B' . $numrow, $i['kd_brg'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $i['nm_brg']);
                    $excel->setActiveSheetIndex(0)->setCellValueExplicit('D' . $numrow, $i['no_reg'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $i['merk_type']);
                    $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $ukuran_cc);
                    $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $i['bahan']);
                    $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $i['thn_beli']);
                    $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, "");
                    $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, "");
                    $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, "");
                    $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, "");
                    $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, "");
                    $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, $i['perolehan']);
                    $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, $kondisi);
                    $excel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, number_format("$i[harga]", 2, ",", "."));
                    $excel->setActiveSheetIndex(0)->setCellValue('Q' . $numrow, $i['umr_ekonomis']);
                    $excel->setActiveSheetIndex(0)->setCellValue('R' . $numrow, number_format("$i[nli_sisa]", 2, ",", "."));
                    $excel->setActiveSheetIndex(0)->setCellValue('S' . $numrow, $i['ket']);

                    // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                    $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row_center)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('M' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('N' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('O' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('P' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('Q' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('R' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('S' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                    $totrow = $numrow++; // Tambah 1 setiap kali looping
                    $p++;
                }

                $row1 = $totrow + 2;
                $row2 = $totrow + 3;
                $row3 = $totrow + 8;
                $row4 = $totrow + 9;
                $row5 = $totrow + 10;

                // Buat Kolom Tanda tanggan
                $excel->setActiveSheetIndex(0)->mergeCells('B' . $row1 . ':C' . $row1);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $row1, "Mengetahui");
                $excel->setActiveSheetIndex(0)->mergeCells('B' . $row2 . ':C' . $row2);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $row2, "Kepala SMA Negeri 3 Cimahi");
                $excel->setActiveSheetIndex(0)->mergeCells('B' . $row3 . ':C' . $row3);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $row3, "Dra, Hj. Mimin Hermiati, MM");
                $excel->setActiveSheetIndex(0)->mergeCells('B' . $row4 . ':C' . $row4);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $row4, "Pembina Utama Muda");
                $excel->setActiveSheetIndex(0)->mergeCells('B' . $row5 . ':C' . $row5);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $row5, "NIP. 195611181980032004");

                $excel->setActiveSheetIndex(0)->mergeCells('I' . $row2 . ':K' . $row2);
                $excel->setActiveSheetIndex(0)->setCellValue('I' . $row2, "Wakasek Sarana");
                $excel->setActiveSheetIndex(0)->mergeCells('I' . $row3 . ':K' . $row3);
                $excel->setActiveSheetIndex(0)->setCellValue('I' . $row3, "Sri Purwanti, SE. MM");
                $excel->setActiveSheetIndex(0)->mergeCells('I' . $row4 . ':K' . $row4);
                $excel->setActiveSheetIndex(0)->setCellValue('I' . $row4, "NIP. 196412161987032005");

                $excel->setActiveSheetIndex(0)->mergeCells('Q' . $row2 . ':R' . $row2);
                $excel->setActiveSheetIndex(0)->setCellValue('Q' . $row2, "Pengurus Barang");
                $excel->setActiveSheetIndex(0)->mergeCells('Q' . $row3 . ':R' . $row3);
                $excel->setActiveSheetIndex(0)->setCellValue('Q' . $row3, "Dadang Yana Suryana");
                $excel->setActiveSheetIndex(0)->mergeCells('Q' . $row4 . ':R' . $row4);
                $excel->setActiveSheetIndex(0)->setCellValue('Q' . $row4, "NIP. 197004102010011004");


                // Apply style tanda tangan yang telah kita buat tadi ke masing-masing kolom tanda tangan
                $excel->getActiveSheet()->getStyle('B' . $row1)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B' . $row2)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B' . $row3)->applyFromArray($style_row_nm)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B' . $row4)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B' . $row5)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                $excel->getActiveSheet()->getStyle('I' . $row2)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('I' . $row3)->applyFromArray($style_row_nm)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('I' . $row4)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                $excel->getActiveSheet()->getStyle('Q' . $row2)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('Q' . $row3)->applyFromArray($style_row_nm)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('Q' . $row4)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);


                // Set width kolom
                $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('R')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('S')->setWidth(25);

                // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
                $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

                // Set orientasi kertas jadi LANDSCAPE
                $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

                date_default_timezone_set('Asia/Jakarta');
                $date   =   date("mY");

                // Set judul file excel nya
                $excel->getActiveSheet(0)->setTitle("Data Laporan KIB B");
                $excel->setActiveSheetIndex(0);

                // Proses file excel
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment; filename="Data Laporan KIB B ' . $date . '.xlsx"'); // Set nama file excel nya
                header('Cache-Control: max-age=0');

                header('Content-Transfer-Encoding: binary');
                header('Accept-Ranges: bytes');
                header('Cache-control: no-cache, pre-check=0, post-check=0');
                header('Cache-control: private');
                header('Pragma: private');
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // any date in the past

                $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
                $write->save('php://output');
            } else {
                $this->session->set_flashdata('statusgagal', 'Membuat Laporan!!!');
                redirect('Lp_kib/lp_kib_b');
            }
        }
    }

    public function export_kib_c()
    {
        if (isset($_POST['cetak_c'])) {
            $tgl_awal  = $this->input->post('tgl_awal');
            $tgl_akhir = $this->input->post('tgl_akhir');
            $kategori  = $this->input->post('kategori');
            $thn_beli  = $this->input->post('thn_beli');

            $dt_kib_c  = $this->Kib_model->get_data_kib_c_ctk($tgl_awal, $tgl_akhir, $kategori, $thn_beli);

            if ($dt_kib_c != "0") {
                // Load plugin PHPExcel nya
                include APPPATH . 'third_party/PHPExcel.php';

                // Panggil class PHPExcel nya
                $excel = new PHPExcel();

                date_default_timezone_set('Asia/Jakarta');
                $date   =   date("mY");

                // Settingan awal fil excel
                $excel->getProperties()->setCreator('Wakasek SIMA SMAN 3 Cimahi (' . $this->session->userdata('username') . ')')
                    ->setLastModifiedBy('Wakasek SIMA SMAN 3 Cimahi (' . $this->session->userdata('username') . ')')
                    ->setTitle("Data Laporan KIB C " . $date)
                    ->setSubject("Laporan KIB C " . $date)
                    ->setDescription("Data Laporan KIB C " . $date)
                    ->setKeywords("Data Laporan KIB C " . $date);

                // Buat sebuah variabel untuk menampung pengaturan style dari TITLE tabel
                $style_tit = array(
                    'font' => array('bold' => true), // Set font nya jadi bold
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                    )
                );

                // Buat sebuah variabel untuk menampung pengaturan style dari ket tabel
                $style_ket = array(
                    'font' => array('bold' => true), // Set font nya jadi bold
                    'alignment' => array(
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                    )
                );

                // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
                $style_col = array(
                    'font' => array('bold' => true), // Set font nya jadi bold
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                        'wrap' => true
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
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                        'wrap' => true
                    ),
                    'borders' => array(
                        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
                    )
                );

                // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
                $style_row_center = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                        'wrap' => true
                    ),
                    'borders' => array(
                        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
                    )
                );

                // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
                $style_row_nm = array(
                    'font' => array(
                        'bold' => true, // Set font nya jadi bold
                        'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE,
                        'strike'    => false
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                        'wrap' => true
                    )
                );

                // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
                $style_row_ttd = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                        'wrap' => true
                    )
                );

                $tgl_indo = tgl_indo_bsr(date("Y-m-d"));

                // Buat header tabel nya pada baris ke 1
                $excel->setActiveSheetIndex(0)->mergeCells('A1:Q1');
                $excel->setActiveSheetIndex(0)->setCellValue('A1', "PEMERINTAH KOTA CIMAHI");
                $excel->setActiveSheetIndex(0)->mergeCells('A2:Q2');
                $excel->setActiveSheetIndex(0)->setCellValue('A2', "KARTU INVENTARIS BARANG ( KIB C )");
                $excel->setActiveSheetIndex(0)->mergeCells('A3:Q3');
                $excel->setActiveSheetIndex(0)->setCellValue('A3', "GEDUNG DAN BANGUNAN");
                $excel->setActiveSheetIndex(0)->mergeCells('A4:Q4');
                $excel->setActiveSheetIndex(0)->setCellValue('A4', "PER " . $tgl_indo);

                // Syle Unutk Header
                $excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('A2')->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                // Buat Keterangan
                $excel->setActiveSheetIndex(0)->setCellValue('A5', "SKPD");
                $excel->setActiveSheetIndex(0)->setCellValue('D5', ": 1.01.01.115.SMUN 3 CIMAHI");
                $excel->setActiveSheetIndex(0)->setCellValue('A6', "KABUPATEN/KOTA");
                $excel->setActiveSheetIndex(0)->setCellValue('D6', ": KOTA CIMAHI");
                $excel->setActiveSheetIndex(0)->setCellValue('A7', "PROVINSI");
                $excel->setActiveSheetIndex(0)->setCellValue('D7', ": JAWA BARAT");
                $excel->setActiveSheetIndex(0)->setCellValue('A8', "NO KODE LOKASI");
                $excel->setActiveSheetIndex(0)->setCellValue('D8', ": 12.10.22.1.01.0");

                // Style Unutk Keterangan
                $excel->getActiveSheet()->getStyle('A5')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D5')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('A6')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D6')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('A7')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D7')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('A8')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D8')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                // Buat Table head
                $excel->setActiveSheetIndex(0)->mergeCells('A10:A11');
                $excel->setActiveSheetIndex(0)->setCellValue('A10', "No");
                $excel->setActiveSheetIndex(0)->mergeCells('B10:B11');
                $excel->setActiveSheetIndex(0)->setCellValue('B10', "Jenis Barang / Nama Barang");
                $excel->setActiveSheetIndex(0)->mergeCells('C10:D10');
                $excel->setActiveSheetIndex(0)->setCellValue('C10', "Nomor");
                $excel->setActiveSheetIndex(0)->setCellValue('C11', "Kode Barang");
                $excel->setActiveSheetIndex(0)->setCellValue('D11', "Kode Register");
                $excel->setActiveSheetIndex(0)->mergeCells('E10:E11');
                $excel->setActiveSheetIndex(0)->setCellValue('E10', "Kondisi Bangunan (B, RR, RB)");
                $excel->setActiveSheetIndex(0)->mergeCells('F10:G10');
                $excel->setActiveSheetIndex(0)->setCellValue('F10', "Konstruksi Bangunan");
                $excel->setActiveSheetIndex(0)->setCellValue('F11', "Bertingkat / Tidak");
                $excel->setActiveSheetIndex(0)->setCellValue('G11', "Beton / Tidak");
                $excel->setActiveSheetIndex(0)->mergeCells('H10:H11');
                $excel->setActiveSheetIndex(0)->setCellValue('H10', "Luas Lantai (m2)");
                $excel->setActiveSheetIndex(0)->mergeCells('I10:I11');
                $excel->setActiveSheetIndex(0)->setCellValue('I10', "Letak/Lokasi Alamat");
                $excel->setActiveSheetIndex(0)->mergeCells('J10:K10');
                $excel->setActiveSheetIndex(0)->setCellValue('J10', "Dokumen Gedung");
                $excel->setActiveSheetIndex(0)->setCellValue('J11', "Tanggal");
                $excel->setActiveSheetIndex(0)->setCellValue('K11', "Nomor");
                $excel->setActiveSheetIndex(0)->mergeCells('L10:L11');
                $excel->setActiveSheetIndex(0)->setCellValue('L10', "Luas (m2)");
                $excel->setActiveSheetIndex(0)->mergeCells('M10:M11');
                $excel->setActiveSheetIndex(0)->setCellValue('M10', "Status Tanah");
                $excel->setActiveSheetIndex(0)->mergeCells('N10:N11');
                $excel->setActiveSheetIndex(0)->setCellValue('N10', "Harga");
                $excel->setActiveSheetIndex(0)->mergeCells('O10:O11');
                $excel->setActiveSheetIndex(0)->setCellValue('O10', "Nomor Kode Tanah");
                $excel->setActiveSheetIndex(0)->mergeCells('P10:P11');
                $excel->setActiveSheetIndex(0)->setCellValue('P10', "Asal - Usul");
                $excel->setActiveSheetIndex(0)->mergeCells('Q10:Q11');
                $excel->setActiveSheetIndex(0)->setCellValue('Q10', "Keterangan");

                // Syle Untuk table head
                $excel->getActiveSheet()->getStyle('A10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('A11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('C10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('C11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('E10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('E11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('F10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('F11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('G10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('G11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('H10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('H11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('I10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('I11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('J10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('J11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('K10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('K11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('L10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('L11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('M10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('M11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('N10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('N11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('O10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('O11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('P10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('P11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('Q10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('Q11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                $no = 12;
                // Buat Numbering
                $excel->setActiveSheetIndex(0)->setCellValue('A' . $no, "1");
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $no, "2");
                $excel->setActiveSheetIndex(0)->setCellValue('C' . $no, "3");
                $excel->setActiveSheetIndex(0)->setCellValue('D' . $no, "4");
                $excel->setActiveSheetIndex(0)->setCellValue('E' . $no, "5");
                $excel->setActiveSheetIndex(0)->setCellValue('F' . $no, "6");
                $excel->setActiveSheetIndex(0)->setCellValue('G' . $no, "7");
                $excel->setActiveSheetIndex(0)->setCellValue('H' . $no, "8");
                $excel->setActiveSheetIndex(0)->setCellValue('I' . $no, "9");
                $excel->setActiveSheetIndex(0)->setCellValue('J' . $no, "10");
                $excel->setActiveSheetIndex(0)->setCellValue('K' . $no, "11");
                $excel->setActiveSheetIndex(0)->setCellValue('L' . $no, "12");
                $excel->setActiveSheetIndex(0)->setCellValue('M' . $no, "13");
                $excel->setActiveSheetIndex(0)->setCellValue('N' . $no, "14");
                $excel->setActiveSheetIndex(0)->setCellValue('O' . $no, "15");
                $excel->setActiveSheetIndex(0)->setCellValue('P' . $no, "16");
                $excel->setActiveSheetIndex(0)->setCellValue('Q' . $no, "17");

                // Apply style numbering yang telah kita buat tadi ke masing-masing kolom numbering
                $excel->getActiveSheet()->getStyle('A' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('C' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('E' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('F' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('G' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('H' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('I' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('J' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('K' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('L' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('M' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('N' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('O' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('P' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('Q' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                // Menampilkan Data
                $numrow = 13; // Set baris pertama untuk isi tabel adalah baris ke 9
                $p = 1;
                $totrow = 0;

                foreach ($dt_kib_c as $i) { // Lakukan looping pada variabel
                    if ($i['dg_tgl'] == "0000-00-00") {
                        $dg_tgl = "";
                    } else {
                        $dg_tgl = $i['dg_tgl'];
                    }

                    if ($i['dg_no'] == "0") {
                        $dg_no = "";
                    } else {
                        $dg_no = $i['dg_no'];
                    }

                    if ($i['bertingkat'] == 1) {
                        $bertingkat = "Ya";
                    } elseif ($i['bertingkat'] == 2) {
                        $bertingkat = "Tidak";
                    } else {
                        $bertingkat = "";
                    }

                    if ($i['beton'] == 1) {
                        $beton = "Ya";
                    } elseif ($i['beton'] == 2) {
                        $beton = "Tidak";
                    } else {
                        $beton = "";
                    }

                    if ($i['kondisi'] == 1) {
                        $kondisi = "Baik";
                    } elseif ($i['kondisi'] == 2) {
                        $kondisi = "Rusak Ringan";
                    } elseif ($i['kondisi'] == 3) {
                        $kondisi = "Rusak Berat";
                    } else {
                        $kondisi = "";
                    }

                    $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $p);
                    $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $i['nm_brg']);
                    $excel->setActiveSheetIndex(0)->setCellValueExplicit('C' . $numrow, $i['kd_brg'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $excel->setActiveSheetIndex(0)->setCellValueExplicit('D' . $numrow, $i['no_reg'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $kondisi);
                    $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $bertingkat);
                    $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $beton);
                    $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $i['luas']);
                    $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $i['letak_lokasi']);
                    $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $dg_tgl);
                    $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $dg_no);
                    $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $i['luas']);
                    $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $i['stts_tanah']);
                    $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, number_format("$i[harga]", 2, ",", "."));
                    $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, $i['no_kd_tanah']);
                    $excel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, $i['perolehan']);
                    $excel->setActiveSheetIndex(0)->setCellValue('Q' . $numrow, $i['ket']);

                    // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                    $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('M' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('N' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('O' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('P' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('Q' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                    $totrow = $numrow++; // Tambah 1 setiap kali looping
                    $p++;
                }

                $row1 = $totrow + 2;
                $row2 = $totrow + 3;
                $row3 = $totrow + 8;
                $row4 = $totrow + 9;
                $row5 = $totrow + 10;

                // Buat Kolom Tanda tanggan
                $excel->setActiveSheetIndex(0)->mergeCells('B' . $row1 . ':C' . $row1);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $row1, "Mengetahui");
                $excel->setActiveSheetIndex(0)->mergeCells('B' . $row2 . ':C' . $row2);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $row2, "Kepala SMA Negeri 3 Cimahi");
                $excel->setActiveSheetIndex(0)->mergeCells('B' . $row3 . ':C' . $row3);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $row3, "Dra, Hj. Mimin Hermiati, MM");
                $excel->setActiveSheetIndex(0)->mergeCells('B' . $row4 . ':C' . $row4);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $row4, "Pembina Utama Muda");
                $excel->setActiveSheetIndex(0)->mergeCells('B' . $row5 . ':C' . $row5);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $row5, "NIP. 195611181980032004");

                $excel->setActiveSheetIndex(0)->mergeCells('H' . $row2 . ':J' . $row2);
                $excel->setActiveSheetIndex(0)->setCellValue('H' . $row2, "Wakasek Sarana");
                $excel->setActiveSheetIndex(0)->mergeCells('H' . $row3 . ':J' . $row3);
                $excel->setActiveSheetIndex(0)->setCellValue('H' . $row3, "Sri Purwanti, SE. MM");
                $excel->setActiveSheetIndex(0)->mergeCells('H' . $row4 . ':J' . $row4);
                $excel->setActiveSheetIndex(0)->setCellValue('H' . $row4, "NIP. 196412161987032005");

                $excel->setActiveSheetIndex(0)->mergeCells('O' . $row2 . ':P' . $row2);
                $excel->setActiveSheetIndex(0)->setCellValue('O' . $row2, "Pengurus Barang");
                $excel->setActiveSheetIndex(0)->mergeCells('O' . $row3 . ':P' . $row3);
                $excel->setActiveSheetIndex(0)->setCellValue('O' . $row3, "Dadang Yana Suryana");
                $excel->setActiveSheetIndex(0)->mergeCells('O' . $row4 . ':P' . $row4);
                $excel->setActiveSheetIndex(0)->setCellValue('O' . $row4, "NIP. 197004102010011004");

                // Apply style tanda tangan yang telah kita buat tadi ke masing-masing kolom tanda tangan
                $excel->getActiveSheet()->getStyle('B' . $row1)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B' . $row2)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B' . $row3)->applyFromArray($style_row_nm)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B' . $row4)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B' . $row5)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                $excel->getActiveSheet()->getStyle('H' . $row2)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('H' . $row3)->applyFromArray($style_row_nm)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('H' . $row4)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                $excel->getActiveSheet()->getStyle('O' . $row2)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('O' . $row3)->applyFromArray($style_row_nm)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('O' . $row4)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                // Set width kolom
                $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth(13);
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
                $excel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);

                // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
                $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

                // Set orientasi kertas jadi LANDSCAPE
                $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

                date_default_timezone_set('Asia/Jakarta');
                $date   =   date("mY");

                // Set judul file excel nya
                $excel->getActiveSheet(0)->setTitle("Data Laporan KIB C");
                $excel->setActiveSheetIndex(0);

                // Proses file excel
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment; filename="Data Laporan KIB C ' . $date . '.xlsx"'); // Set nama file excel nya
                header('Cache-Control: max-age=0');

                header('Content-Transfer-Encoding: binary');
                header('Accept-Ranges: bytes');
                header('Cache-control: no-cache, pre-check=0, post-check=0');
                header('Cache-control: private');
                header('Pragma: private');
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // any date in the past

                $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
                $write->save('php://output');
            } else {
                $this->session->set_flashdata('statusgagal', 'Membuat Laporan!!!');
                redirect('Lp_kib/lp_kib_c');
            }
        }
    }

    public function export_kib_e()
    {
        if (isset($_POST['cetak_e'])) {
            $tgl_awal  = $this->input->post('tgl_awal');
            $tgl_akhir = $this->input->post('tgl_akhir');
            $kategori  = $this->input->post('kategori');
            $thn_beli  = $this->input->post('thn_beli');

            $dt_kib_e  = $this->Kib_model->get_data_kib_e_ctk($tgl_awal, $tgl_akhir, $kategori, $thn_beli);

            if ($dt_kib_e != "0") {
                // Load plugin PHPExcel nya
                include APPPATH . 'third_party/PHPExcel.php';

                // Panggil class PHPExcel nya
                $excel = new PHPExcel();

                date_default_timezone_set('Asia/Jakarta');
                $date   =   date("mY");

                // Settingan awal fil excel
                $excel->getProperties()->setCreator('Wakasek SIMA SMAN 3 Cimahi (' . $this->session->userdata('username') . ')')
                    ->setLastModifiedBy('Wakasek SIMA SMAN 3 Cimahi (' . $this->session->userdata('username') . ')')
                    ->setTitle("Data Laporan KIB E" . $date)
                    ->setSubject("Laporan KIB E " . $date)
                    ->setDescription("Data Laporan KIB E " . $date)
                    ->setKeywords("Data Laporan KIB E " . $date);

                // Buat sebuah variabel untuk menampung pengaturan style dari TITLE tabel
                $style_tit = array(
                    'font' => array('bold' => true), // Set font nya jadi bold
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                    )
                );

                // Buat sebuah variabel untuk menampung pengaturan style dari ket tabel
                $style_ket = array(
                    'font' => array('bold' => true), // Set font nya jadi bold
                    'alignment' => array(
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                    )
                );

                // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
                $style_col = array(
                    'font' => array('bold' => true), // Set font nya jadi bold
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                        'wrap' => true
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
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                        'wrap' => true
                    ),
                    'borders' => array(
                        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
                    )
                );

                // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
                $style_row_center = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                        'wrap' => true
                    ),
                    'borders' => array(
                        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
                    )
                );

                // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
                $style_row_nm = array(
                    'font' => array(
                        'bold' => true, // Set font nya jadi bold
                        'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE,
                        'strike'    => false
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                        'wrap' => true
                    )
                );

                // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
                $style_row_ttd = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                        'wrap' => true
                    )
                );

                $tgl_indo = tgl_indo_bsr(date("Y-m-d"));

                // Buat header tabel nya pada baris ke 1
                $excel->setActiveSheetIndex(0)->mergeCells('A1:R1');
                $excel->setActiveSheetIndex(0)->setCellValue('A1', "PEMERINTAH KOTA CIMAHI");
                $excel->setActiveSheetIndex(0)->mergeCells('A2:R2');
                $excel->setActiveSheetIndex(0)->setCellValue('A2', "KARTU INVENTARIS BARANG ( KIB E )");
                $excel->setActiveSheetIndex(0)->mergeCells('A3:R3');
                $excel->setActiveSheetIndex(0)->setCellValue('A3', "ASET TETAP LAINNYA");
                $excel->setActiveSheetIndex(0)->mergeCells('A4:R4');
                $excel->setActiveSheetIndex(0)->setCellValue('A4', "PER " . $tgl_indo);

                // Style Untuk header
                $excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('A2')->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                // Buat Keterangan
                $excel->setActiveSheetIndex(0)->setCellValue('A5', "SKPD");
                $excel->setActiveSheetIndex(0)->setCellValue('D5', ": 1.01.01.115.SMUN 3 CIMAHI");
                $excel->setActiveSheetIndex(0)->setCellValue('A6', "KABUPATEN/KOTA");
                $excel->setActiveSheetIndex(0)->setCellValue('D6', ": KOTA CIMAHI");
                $excel->setActiveSheetIndex(0)->setCellValue('A7', "PROVINSI");
                $excel->setActiveSheetIndex(0)->setCellValue('D7', ": JAWA BARAT");
                $excel->setActiveSheetIndex(0)->setCellValue('A8', "NO KODE LOKASI");
                $excel->setActiveSheetIndex(0)->setCellValue('D8', ": 12.10.22.1.01.0");

                //  Style Untuk Keterangan
                $excel->getActiveSheet()->getStyle('A5')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D5')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('A6')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D6')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('A7')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D7')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('A8')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D8')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                // Buat table head
                $excel->setActiveSheetIndex(0)->mergeCells('A10:A11');
                $excel->setActiveSheetIndex(0)->setCellValue('A10', "No");
                $excel->setActiveSheetIndex(0)->mergeCells('B10:B11');
                $excel->setActiveSheetIndex(0)->setCellValue('B10', "Jenis Barang / Nama Barang");
                $excel->setActiveSheetIndex(0)->mergeCells('C10:D10');
                $excel->setActiveSheetIndex(0)->setCellValue('C10', "Nomor");
                $excel->setActiveSheetIndex(0)->setCellValue('C11', "Kode Barang");
                $excel->setActiveSheetIndex(0)->setCellValue('D11', "Kode Register");
                $excel->setActiveSheetIndex(0)->mergeCells('E10:F10');
                $excel->setActiveSheetIndex(0)->setCellValue('E10', "Buku/Perpustakaan");
                $excel->setActiveSheetIndex(0)->setCellValue('E11', "Judul/Pencipta");
                $excel->setActiveSheetIndex(0)->setCellValue('F11', "Spesifikasi");
                $excel->setActiveSheetIndex(0)->mergeCells('G10:I10');
                $excel->setActiveSheetIndex(0)->setCellValue('G10', "Barang Bercorak Kesenian/Kebudayaan");
                $excel->setActiveSheetIndex(0)->setCellValue('G11', "Asal Daerah");
                $excel->setActiveSheetIndex(0)->setCellValue('H11', "Pencipta");
                $excel->setActiveSheetIndex(0)->setCellValue('I11', "Bahan");
                $excel->setActiveSheetIndex(0)->mergeCells('J10:K10');
                $excel->setActiveSheetIndex(0)->setCellValue('J10', "Hewan/Ternak dan Tumbuhan");
                $excel->setActiveSheetIndex(0)->setCellValue('J11', "Jenis");
                $excel->setActiveSheetIndex(0)->setCellValue('K11', "Ukuran");
                $excel->setActiveSheetIndex(0)->mergeCells('L10:L11');
                $excel->setActiveSheetIndex(0)->setCellValue('L10', "Jumlah");
                $excel->setActiveSheetIndex(0)->mergeCells('M10:M11');
                $excel->setActiveSheetIndex(0)->setCellValue('M10', "Tahun Cetak/Pembeli");
                $excel->setActiveSheetIndex(0)->mergeCells('N10:N11');
                $excel->setActiveSheetIndex(0)->setCellValue('N10', "Asal-usul Cara Peroleha");
                $excel->setActiveSheetIndex(0)->mergeCells('O10:O11');
                $excel->setActiveSheetIndex(0)->setCellValue('O10', "Harga");
                $excel->setActiveSheetIndex(0)->mergeCells('P10:P11');
                $excel->setActiveSheetIndex(0)->setCellValue('P10', "Umur Ekonomis");
                $excel->setActiveSheetIndex(0)->mergeCells('Q10:Q11');
                $excel->setActiveSheetIndex(0)->setCellValue('Q10', "Nilai Sisa");
                $excel->setActiveSheetIndex(0)->mergeCells('R10:R11');
                $excel->setActiveSheetIndex(0)->setCellValue('R10', "Keterangan");

                // Style untuk table head
                $excel->getActiveSheet()->getStyle('A10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('A11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('C10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('C11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('E10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('E11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('F10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('F11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('G10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('G11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('H10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('H11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('I10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('I11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('J10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('J11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('K10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('K11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('L10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('L11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('M10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('M11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('N10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('N11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('O10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('O11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('P10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('P11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('Q10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('Q11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('R10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('R11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                $no = 12;
                // Buat numbering
                $excel->setActiveSheetIndex(0)->setCellValue('A' . $no, "1");
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $no, "2");
                $excel->setActiveSheetIndex(0)->setCellValue('C' . $no, "3");
                $excel->setActiveSheetIndex(0)->setCellValue('D' . $no, "4");
                $excel->setActiveSheetIndex(0)->setCellValue('E' . $no, "5");
                $excel->setActiveSheetIndex(0)->setCellValue('F' . $no, "6");
                $excel->setActiveSheetIndex(0)->setCellValue('G' . $no, "7");
                $excel->setActiveSheetIndex(0)->setCellValue('H' . $no, "8");
                $excel->setActiveSheetIndex(0)->setCellValue('I' . $no, "9");
                $excel->setActiveSheetIndex(0)->setCellValue('J' . $no, "10");
                $excel->setActiveSheetIndex(0)->setCellValue('K' . $no, "11");
                $excel->setActiveSheetIndex(0)->setCellValue('L' . $no, "12");
                $excel->setActiveSheetIndex(0)->setCellValue('M' . $no, "13");
                $excel->setActiveSheetIndex(0)->setCellValue('N' . $no, "14");
                $excel->setActiveSheetIndex(0)->setCellValue('O' . $no, "15");
                $excel->setActiveSheetIndex(0)->setCellValue('P' . $no, "16");
                $excel->setActiveSheetIndex(0)->setCellValue('Q' . $no, "17");
                $excel->setActiveSheetIndex(0)->setCellValue('R' . $no, "18");

                // Apply style numbering yang telah kita buat tadi ke masing-masing kolom numbering
                $excel->getActiveSheet()->getStyle('A' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('C' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('E' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('F' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('G' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('H' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('I' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('J' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('K' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('L' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('M' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('N' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('O' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('P' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('Q' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('R' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                // Menampilkan data
                $numrow = 13; // Set baris pertama untuk isi tabel adalah baris ke 9
                $p = 1;
                $totrow = 0;

                foreach ($dt_kib_e as $i) { // Lakukan looping pada variabel
                    if ($i['jmlh_brg'] == "0") {
                        $jmlh_brg = "";
                    } else {
                        $jmlh_brg = $i['jmlh_brg'];
                    }

                    $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $p);
                    $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $i['nm_brg']);
                    $excel->setActiveSheetIndex(0)->setCellValueExplicit('C' . $numrow, $i['kd_brg'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $excel->setActiveSheetIndex(0)->setCellValueExplicit('D' . $numrow, $i['no_reg'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $i['bp_jp']);
                    $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $i['bp_s']);
                    $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $i['bbkk_ad']);
                    $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $i['bbkk_p']);
                    $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $i['bbkk_b']);
                    $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $i['htt_j']);
                    $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $i['htt_u']);
                    $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $jmlh_brg);
                    $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $i['thn_beli']);
                    $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, $i['perolehan']);
                    $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, number_format("$i[harga]", 2, ",", "."));
                    $excel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, $i['umr_ekonomis']);
                    $excel->setActiveSheetIndex(0)->setCellValue('Q' . $numrow, number_format("$i[nli_sisa]", 2, ",", "."));
                    $excel->setActiveSheetIndex(0)->setCellValue('R' . $numrow, $i['ket']);

                    // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                    $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row_center)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('M' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('N' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('O' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('P' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('Q' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('R' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                    $totrow = $numrow++; // Tambah 1 setiap kali looping
                    $p++;
                }

                $row1 = $totrow + 2;
                $row2 = $totrow + 3;
                $row3 = $totrow + 8;
                $row4 = $totrow + 9;
                $row5 = $totrow + 10;

                // Buat Kolom Tanda tanggan
                $excel->setActiveSheetIndex(0)->mergeCells('B' . $row1 . ':C' . $row1);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $row1, "Mengetahui");
                $excel->setActiveSheetIndex(0)->mergeCells('B' . $row2 . ':C' . $row2);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $row2, "Kepala SMA Negeri 3 Cimahi");
                $excel->setActiveSheetIndex(0)->mergeCells('B' . $row3 . ':C' . $row3);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $row3, "Dra, Hj. Mimin Hermiati, MM");
                $excel->setActiveSheetIndex(0)->mergeCells('B' . $row4 . ':C' . $row4);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $row4, "Pembina Utama Muda");
                $excel->setActiveSheetIndex(0)->mergeCells('B' . $row5 . ':C' . $row5);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $row5, "NIP. 195611181980032004");

                $excel->setActiveSheetIndex(0)->mergeCells('I' . $row2 . ':J' . $row2);
                $excel->setActiveSheetIndex(0)->setCellValue('I' . $row2, "Wakasek Sarana");
                $excel->setActiveSheetIndex(0)->mergeCells('I' . $row3 . ':J' . $row3);
                $excel->setActiveSheetIndex(0)->setCellValue('I' . $row3, "Sri Purwanti, SE. MM");
                $excel->setActiveSheetIndex(0)->mergeCells('I' . $row4 . ':J' . $row4);
                $excel->setActiveSheetIndex(0)->setCellValue('I' . $row4, "NIP. 196412161987032005");

                $excel->setActiveSheetIndex(0)->mergeCells('P' . $row2 . ':Q' . $row2);
                $excel->setActiveSheetIndex(0)->setCellValue('P' . $row2, "Pengurus Barang");
                $excel->setActiveSheetIndex(0)->mergeCells('P' . $row3 . ':Q' . $row3);
                $excel->setActiveSheetIndex(0)->setCellValue('P' . $row3, "Dadang Yana Suryana");
                $excel->setActiveSheetIndex(0)->mergeCells('P' . $row4 . ':Q' . $row4);
                $excel->setActiveSheetIndex(0)->setCellValue('P' . $row4, "NIP. 197004102010011004");

                // Apply style tanda tangan yang telah kita buat tadi ke masing-masing kolom tanda tangan
                $excel->getActiveSheet()->getStyle('B' . $row1)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B' . $row2)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B' . $row3)->applyFromArray($style_row_nm)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B' . $row4)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B' . $row5)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                $excel->getActiveSheet()->getStyle('I' . $row2)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('I' . $row3)->applyFromArray($style_row_nm)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('I' . $row4)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                $excel->getActiveSheet()->getStyle('P' . $row2)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('P' . $row3)->applyFromArray($style_row_nm)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('P' . $row4)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);


                // Set width kolom
                $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth(13);
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
                $excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('L')->setWidth(8);
                $excel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('R')->setWidth(25);

                // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
                $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

                // Set orientasi kertas jadi LANDSCAPE
                $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

                date_default_timezone_set('Asia/Jakarta');
                $date   =   date("mY");

                // Set judul file excel nya
                $excel->getActiveSheet(0)->setTitle("Data Laporan KIB E");
                $excel->setActiveSheetIndex(0);

                // Proses file excel
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment; filename="Data Laporan KIB E ' . $date . '.xlsx"'); // Set nama file excel nya
                header('Cache-Control: max-age=0');

                header('Content-Transfer-Encoding: binary');
                header('Accept-Ranges: bytes');
                header('Cache-control: no-cache, pre-check=0, post-check=0');
                header('Cache-control: private');
                header('Pragma: private');
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // any date in the past

                $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
                $write->save('php://output');
            } else {
                $this->session->set_flashdata('statusgagal', 'Membuat Laporan!!!');
                redirect('Lp_kib/lp_kib_e');
            }
        }
    }

    public function export_pelihara()
    {
        if (isset($_POST['cetak'])) {
            $tgl_awal   = $this->input->post('tgl_awal');
            $tgl_akhir  = $this->input->post('tgl_akhir');
            $kategori = $this->input->post('kategori');
            $dt_pemeliharaan = $this->Pemeliharaan_aset_model->print_pemeliharaan_aset_ex($tgl_awal, $tgl_akhir, $kategori);

            if ($dt_pemeliharaan != "0") {
                if ($kategori == 1 or $kategori == 2) {
                    // Load plugin PHPExcel nya
                    include APPPATH . 'third_party/PHPExcel.php';

                    // Panggil class PHPExcel nya
                    $excel = new PHPExcel();

                    date_default_timezone_set('Asia/Jakarta');
                    $date   =   date("mY");

                    // Settingan awal fil excel
                    $excel->getProperties()->setCreator('Wakasek SIMA SMAN 3 Cimahi (' . $this->session->userdata('username') . ')')
                        ->setLastModifiedBy('Wakasek SIMA SMAN 3 Cimahi (' . $this->session->userdata('username') . ')')
                        ->setTitle("Data Laporan Pemeliharaan Aset " . $date)
                        ->setSubject("Laporan Pemeliharaan Aset " . $date)
                        ->setDescription("Data Laporan Pemeliharaan Aset " . $date)
                        ->setKeywords("Data Laporan Pemeliharaan Aset " . $date);

                    // Buat sebuah variabel untuk menampung pengaturan style dari TITLE tabel
                    $style_tit = array(
                        'font' => array('bold' => true), // Set font nya jadi bold
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                        )
                    );

                    // Buat sebuah variabel untuk menampung pengaturan style dari TITLE tabel
                    $style_ket = array(
                        'font' => array('bold' => true), // Set font nya jadi bold
                        'alignment' => array(
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                        )
                    );

                    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
                    $style_col = array(
                        'font' => array('bold' => true), // Set font nya jadi bold
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                            'wrap' => true
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
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                            'wrap' => true
                        ),
                        'borders' => array(
                            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
                        )
                    );

                    // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
                    $style_row_center = array(
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                            'wrap' => true
                        ),
                        'borders' => array(
                            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
                        )
                    );

                    // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
                    $style_row_nm = array(
                        'font' => array(
                            'bold' => true, // Set font nya jadi bold
                            'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE,
                            'strike'    => false,
                        ),
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                            'wrap' => true
                        )
                    );

                    // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
                    $style_row_ttd = array(
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                            'wrap' => true
                        )
                    );

                    $tahun = date("Y");

                    // Buat header tabel nya pada baris ke 1
                    $excel->setActiveSheetIndex(0)->mergeCells('A2:N2');
                    $excel->setActiveSheetIndex(0)->setCellValue('A2', "LAPORAN PEMELIHARAAN");
                    $excel->setActiveSheetIndex(0)->mergeCells('A3:N3');
                    $excel->setActiveSheetIndex(0)->setCellValue('A3', "PENGGUNA BARANG SMA NEGERI 3 CIMAHI");
                    $excel->setActiveSheetIndex(0)->mergeCells('A4:N4');
                    $excel->setActiveSheetIndex(0)->setCellValue('A4', "TAHUN " . $tahun);
                    $excel->setActiveSheetIndex(0)->setCellValue('B6', "PEMERINTAH DAERAH");
                    $excel->setActiveSheetIndex(0)->setCellValue('C6', ": PROVINSI JAWA BARAT");
                    $excel->setActiveSheetIndex(0)->setCellValue('B7', "PENGGUNA BARANG");
                    $excel->setActiveSheetIndex(0)->setCellValue('C7', ": SMA NEGERI 3 CIMAHI");

                    // Apply style header yang telah kita buat tadi ke masing-masing kolom header
                    $excel->getActiveSheet()->getStyle('A2')->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('B6')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('C6')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('B7')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('C7')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                    // Buat table head
                    $excel->setActiveSheetIndex(0)->mergeCells('A10:A12');
                    $excel->setActiveSheetIndex(0)->setCellValue('A10', "NO");
                    $excel->setActiveSheetIndex(0)->mergeCells('B10:B12');
                    $excel->setActiveSheetIndex(0)->setCellValue('B10', "PROGRAM/KEGIATAN/OUTPUT");
                    $excel->setActiveSheetIndex(0)->mergeCells('C10:J10');
                    $excel->setActiveSheetIndex(0)->setCellValue('C10', "BARANG YANG DIPELIHARA");
                    $excel->setActiveSheetIndex(0)->mergeCells('C11:C12');
                    $excel->setActiveSheetIndex(0)->setCellValue('C11', "KODE BARANG");
                    $excel->setActiveSheetIndex(0)->mergeCells('D11:D12');
                    $excel->setActiveSheetIndex(0)->setCellValue('D11', "NAMA BARANG");
                    $excel->setActiveSheetIndex(0)->mergeCells('E11:E12');
                    $excel->setActiveSheetIndex(0)->setCellValue('E11', "JUMLAH");
                    $excel->setActiveSheetIndex(0)->mergeCells('F11:F12');
                    $excel->setActiveSheetIndex(0)->setCellValue('F11', "SATUAN");
                    $excel->setActiveSheetIndex(0)->mergeCells('G11:G12');
                    $excel->setActiveSheetIndex(0)->setCellValue('G11', "SATUAN BARANG");
                    $excel->setActiveSheetIndex(0)->mergeCells('H11:J11');
                    $excel->setActiveSheetIndex(0)->setCellValue('H11', "KONDISI BARANG");
                    $excel->setActiveSheetIndex(0)->setCellValue('H12', "B");
                    $excel->setActiveSheetIndex(0)->setCellValue('I12', "RR");
                    $excel->setActiveSheetIndex(0)->setCellValue('J12', "RR");
                    $excel->setActiveSheetIndex(0)->mergeCells('K10:M10');
                    $excel->setActiveSheetIndex(0)->setCellValue('K10', "USULAN KEBUTUHAN PEMELIHARAAN");
                    $excel->setActiveSheetIndex(0)->mergeCells('K11:K12');
                    $excel->setActiveSheetIndex(0)->setCellValue('K11', "NAMA PEMELIHARAAN");
                    $excel->setActiveSheetIndex(0)->mergeCells('L11:L12');
                    $excel->setActiveSheetIndex(0)->setCellValue('L11', "JUMLAH");
                    $excel->setActiveSheetIndex(0)->mergeCells('M11:M12');
                    $excel->setActiveSheetIndex(0)->setCellValue('M11', "SATUAN");
                    $excel->setActiveSheetIndex(0)->mergeCells('N10:N12');
                    $excel->setActiveSheetIndex(0)->setCellValue('N10', "KETERANGAN");

                    // style tale head
                    $excel->getActiveSheet()->getStyle('A10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('A11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('A12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('B10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('B11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('B12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('C10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('C11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('C12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('D10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('D11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('D12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('E10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('E11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('E12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('F10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('F11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('F12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('G10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('G11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('G12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('H10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('H11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('H12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('I10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('I11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('I12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('J10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('J11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('J12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('K10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('K11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('K12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('L10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('L11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('L12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('M10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('M11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('M12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('N10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('N11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('N12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                    $no = 13;
                    // Buat numbering
                    $excel->setActiveSheetIndex(0)->setCellValue('A' . $no, "1");
                    $excel->setActiveSheetIndex(0)->setCellValue('B' . $no, "2");
                    $excel->setActiveSheetIndex(0)->setCellValue('C' . $no, "3");
                    $excel->setActiveSheetIndex(0)->setCellValue('D' . $no, "4");
                    $excel->setActiveSheetIndex(0)->setCellValue('E' . $no, "5");
                    $excel->setActiveSheetIndex(0)->setCellValue('F' . $no, "6");
                    $excel->setActiveSheetIndex(0)->setCellValue('G' . $no, "7");
                    $excel->setActiveSheetIndex(0)->setCellValue('H' . $no, "8");
                    $excel->setActiveSheetIndex(0)->setCellValue('I' . $no, "9");
                    $excel->setActiveSheetIndex(0)->setCellValue('J' . $no, "10");
                    $excel->setActiveSheetIndex(0)->setCellValue('K' . $no, "11");
                    $excel->setActiveSheetIndex(0)->setCellValue('L' . $no, "12");
                    $excel->setActiveSheetIndex(0)->setCellValue('M' . $no, "13");
                    $excel->setActiveSheetIndex(0)->setCellValue('N' . $no, "14");

                    // Apply style numbering yang telah kita buat tadi ke masing-masing kolom numbering
                    $excel->getActiveSheet()->getStyle('A' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('B' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('C' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('D' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('E' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('F' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('G' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('H' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('I' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('J' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('K' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('L' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('M' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('N' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                    // Menampilkan data
                    $numrow = 14; // Set baris pertama untuk isi tabel adalah baris ke 13
                    $p = 1;
                    $totrow = 0;
                    foreach ($dt_pemeliharaan as $i) { // Lakukan looping pada variabel

                        if ($i['satuan_brg'] == 1) {
                            $satuan_brg = "Buah";
                        } else if ($i['satuan_brg'] == 2) {
                            $satuan_brg = "Unit";
                        } else if ($i['satuan_brg'] == 3) {
                            $satuan_brg = "Set";
                        } else {
                            $satuan_brg = "";
                        }

                        if ($i['jmlh_brg'] == 0) {
                            $jmlh_brg = "";
                        } else {
                            $jmlh_brg = $i['jmlh_brg'];
                        }

                        if ($i['kondisi_brg'] == 1) {
                            $kondisi = "Baik";
                        } else if ($i['kondisi_brg'] == 2) {
                            $kondisi = "Rusak Ringan";
                        } else if ($i['kondisi_brg'] == 3) {
                            $kondisi = "Rusak Berat";
                        } else {
                            $kondisi = "";
                        }

                        if ($i['kondisi_brg'] == 1) {

                            $kondisi1 = "√";
                        } else {
                            $kondisi1 = "";
                        }

                        if ($i['kondisi_brg'] == 2) {
                            $kondisi2 = "√";
                        } else {
                            $kondisi2 = "";
                        }

                        if ($i['kondisi_brg'] == 3) {
                            $kondisi3 = "√";
                        } else {
                            $kondisi3 = "";
                        }

                        $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $p);
                        $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, "");
                        $excel->setActiveSheetIndex(0)->setCellValueExplicit('C' . $numrow, $i['kd_brg'], PHPExcel_Cell_DataType::TYPE_STRING);
                        $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $i['nm_brg']);
                        $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $jmlh_brg);
                        $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $satuan_brg);
                        $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $kondisi);
                        $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $kondisi1);
                        $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $kondisi2);
                        $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $kondisi3);
                        $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $i['nm_brg']);
                        $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $jmlh_brg);
                        $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $satuan_brg);
                        $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, $i['ket']);

                        // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                        $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row_center)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                        $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                        $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                        $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                        $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                        $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                        $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                        $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row_center)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                        $excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row_center)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                        $excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row_center)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                        $excel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                        $excel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                        $excel->getActiveSheet()->getStyle('M' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                        $excel->getActiveSheet()->getStyle('N' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                        // $numrow++; // Tambah 1 setiap kali looping
                        $p++;
                        $totrow = $numrow++;
                    }

                    $tgl = tgl_indo(date('Y-m-d'));
                    $row1 = $totrow + 2;
                    $row2 = $totrow + 3;
                    $row3 = $totrow + 4;
                    $row7 = $totrow + 8;
                    $row8 = $totrow + 9;

                    // Buat Kolom Tanda tanggan
                    $excel->setActiveSheetIndex(0)->mergeCells('L' . $row1 . ':N' . $row1);
                    $excel->setActiveSheetIndex(0)->setCellValue('L' . $row1, "Bandung, " . $tgl);
                    $excel->setActiveSheetIndex(0)->mergeCells('L' . $row2 . ':N' . $row2);
                    $excel->setActiveSheetIndex(0)->setCellValue('L' . $row2, "Kuasa Pengguna Barang");
                    $excel->setActiveSheetIndex(0)->mergeCells('L' . $row3 . ':N' . $row3);
                    $excel->setActiveSheetIndex(0)->setCellValue('L' . $row3, "SMA Negeri 3 Cimahi");
                    $excel->setActiveSheetIndex(0)->mergeCells('L' . $row7 . ':N' . $row7);
                    $excel->setActiveSheetIndex(0)->setCellValue('L' . $row7, "Dra, Hj, Nelly Krisdiyana, MM");
                    $excel->setActiveSheetIndex(0)->mergeCells('L' . $row8 . ':N' . $row8);
                    $excel->setActiveSheetIndex(0)->setCellValue('L' . $row8, "NIP. 195912121983022003");

                    // Apply style tanda tangan yang telah kita buat tadi ke masing-masing kolom tanda tangan
                    $excel->getActiveSheet()->getStyle('L' . $row1)->applyFromArray($style_row_ttd)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('L' . $row2)->applyFromArray($style_row_ttd)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('L' . $row3)->applyFromArray($style_row_ttd)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('L' . $row7)->applyFromArray($style_row_nm)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('L' . $row8)->applyFromArray($style_row_ttd)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                    // Set width kolom
                    $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                    $excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
                    $excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                    $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                    $excel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
                    $excel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
                    $excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
                    $excel->getActiveSheet()->getColumnDimension('H')->setWidth(7);
                    $excel->getActiveSheet()->getColumnDimension('I')->setWidth(7);
                    $excel->getActiveSheet()->getColumnDimension('J')->setWidth(7);
                    $excel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
                    $excel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
                    $excel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
                    $excel->getActiveSheet()->getColumnDimension('N')->setWidth(20);

                    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
                    $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

                    // Set orientasi kertas jadi LANDSCAPE
                    $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

                    date_default_timezone_set('Asia/Jakarta');
                    $date   =   date("mY");

                    // Set judul file excel nya
                    $excel->getActiveSheet(0)->setTitle("Data Laporan Pemeliharaan Aset");
                    $excel->setActiveSheetIndex(0);

                    // Proses file excel
                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header('Content-Disposition: attachment; filename="Data Laporan Pemeliharaan Aset ' . $date . '.xlsx"'); // Set nama file excel nya
                    header('Cache-Control: max-age=0');

                    header('Content-Transfer-Encoding: binary');
                    header('Accept-Ranges: bytes');
                    header('Cache-control: no-cache, pre-check=0, post-check=0');
                    header('Cache-control: private');
                    header('Pragma: private');
                    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // any date in the past

                    $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
                    $write->save('php://output');
                } else {

                    // Load plugin PHPExcel nya
                    include APPPATH . 'third_party/PHPExcel.php';

                    // Panggil class PHPExcel nya
                    $excel = new PHPExcel();

                    date_default_timezone_set('Asia/Jakarta');
                    $date   =   date("mY");

                    // Settingan awal fil excel
                    $excel->getProperties()->setCreator('Wakasek SIMA SMAN 3 Cimahi (' . $this->session->userdata('username') . ')')
                        ->setLastModifiedBy('Wakasek SIMA SMAN 3 Cimahi (' . $this->session->userdata('username') . ')')
                        ->setTitle("Data Laporan Pemeliharaan Aset External " . $date)
                        ->setSubject("Laporan Pemeliharaan Aset External " . $date)
                        ->setDescription("Data Laporan Pemeliharaan Aset External " . $date)
                        ->setKeywords("Data Laporan Pemeliharaan Aset External " . $date);

                    // Buat sebuah variabel untuk menampung pengaturan style dari TITLE tabel
                    $style_tit = array(
                        'font' => array('bold' => true), // Set font nya jadi bold
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                        )
                    );

                    // Buat sebuah variabel untuk menampung pengaturan style dari TITLE tabel
                    $style_ket = array(
                        'font' => array('bold' => true), // Set font nya jadi bold
                        'alignment' => array(
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                        )
                    );

                    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
                    $style_col = array(
                        'font' => array('bold' => true), // Set font nya jadi bold
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                            'wrap' => true
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
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                            'wrap' => true
                        ),
                        'borders' => array(
                            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
                        )
                    );

                    // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
                    $style_row_center = array(
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                            'wrap' => true
                        ),
                        'borders' => array(
                            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
                        )
                    );

                    // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
                    $style_row_nm = array(
                        'font' => array(
                            'bold' => true, // Set font nya jadi bold
                            'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE,
                            'strike'    => false,
                        ),
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                            'wrap' => true
                        )
                    );

                    // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
                    $style_row_ttd = array(
                        'alignment' => array(
                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                            'wrap' => true
                        )
                    );

                    $tahun = date("Y");

                    // Buat header tabel nya pada baris ke 1
                    $excel->setActiveSheetIndex(0)->mergeCells('A1:N1');
                    $excel->setActiveSheetIndex(0)->setCellValue('A1', "USULAN RENCANA KEBUTUHAN PEMELIHARAAN BARANG MILIK DAERAH");
                    $excel->setActiveSheetIndex(0)->mergeCells('A2:N2');
                    $excel->setActiveSheetIndex(0)->setCellValue('A2', "(RENCANA PEMELIHARAAN)");
                    $excel->setActiveSheetIndex(0)->mergeCells('A3:N3');
                    $excel->setActiveSheetIndex(0)->setCellValue('A3', "KUASA PENGGUNA BARANG SMA NEGERI 3 CIMAHI");
                    $excel->setActiveSheetIndex(0)->mergeCells('A4:N4');
                    $excel->setActiveSheetIndex(0)->setCellValue('A4', "TAHUN " . $tahun);
                    $excel->setActiveSheetIndex(0)->setCellValue('B6', "PEMERINTAH DAERAH");
                    $excel->setActiveSheetIndex(0)->setCellValue('C6', ": PROVINSI JAWA BARAT");
                    $excel->setActiveSheetIndex(0)->setCellValue('B7', "PENGGUNA BARANG");
                    $excel->setActiveSheetIndex(0)->setCellValue('C7', ": SMA NEGERI 3 CIMAHI");

                    // Apply style header yang telah kita buat tadi ke masing-masing kolom header
                    $excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('A2')->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('B6')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('C6')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('B7')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('C7')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                    // Buat table head
                    $excel->setActiveSheetIndex(0)->mergeCells('A10:A12');
                    $excel->setActiveSheetIndex(0)->setCellValue('A10', "NO");
                    $excel->setActiveSheetIndex(0)->mergeCells('B10:B12');
                    $excel->setActiveSheetIndex(0)->setCellValue('B10', "PROGRAM/KEGIATAN/OUTPUT");
                    $excel->setActiveSheetIndex(0)->mergeCells('C10:J10');
                    $excel->setActiveSheetIndex(0)->setCellValue('C10', "BARANG YANG DIPELIHARA");
                    $excel->setActiveSheetIndex(0)->mergeCells('C11:C12');
                    $excel->setActiveSheetIndex(0)->setCellValue('C11', "KODE BARANG");
                    $excel->setActiveSheetIndex(0)->mergeCells('D11:D12');
                    $excel->setActiveSheetIndex(0)->setCellValue('D11', "NAMA BARANG");
                    $excel->setActiveSheetIndex(0)->mergeCells('E11:E12');
                    $excel->setActiveSheetIndex(0)->setCellValue('E11', "JUMLAH");
                    $excel->setActiveSheetIndex(0)->mergeCells('F11:F12');
                    $excel->setActiveSheetIndex(0)->setCellValue('F11', "SATUAN");
                    $excel->setActiveSheetIndex(0)->mergeCells('G11:G12');
                    $excel->setActiveSheetIndex(0)->setCellValue('G11', "SATUAN BARANG");
                    $excel->setActiveSheetIndex(0)->mergeCells('H11:J11');
                    $excel->setActiveSheetIndex(0)->setCellValue('H11', "KONDISI BARANG");
                    $excel->setActiveSheetIndex(0)->setCellValue('H12', "B");
                    $excel->setActiveSheetIndex(0)->setCellValue('I12', "RR");
                    $excel->setActiveSheetIndex(0)->setCellValue('J12', "RR");
                    $excel->setActiveSheetIndex(0)->mergeCells('K10:M10');
                    $excel->setActiveSheetIndex(0)->setCellValue('K10', "USULAN KEBUTUHAN PEMELIHARAAN");
                    $excel->setActiveSheetIndex(0)->mergeCells('K11:K12');
                    $excel->setActiveSheetIndex(0)->setCellValue('K11', "NAMA PEMELIHARAAN");
                    $excel->setActiveSheetIndex(0)->mergeCells('L11:L12');
                    $excel->setActiveSheetIndex(0)->setCellValue('L11', "JUMLAH");
                    $excel->setActiveSheetIndex(0)->mergeCells('M11:M12');
                    $excel->setActiveSheetIndex(0)->setCellValue('M11', "SATUAN");
                    $excel->setActiveSheetIndex(0)->mergeCells('N10:N12');
                    $excel->setActiveSheetIndex(0)->setCellValue('N10', "KETERANGAN");

                    // style tale head
                    $excel->getActiveSheet()->getStyle('A10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('A11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('A12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('B10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('B11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('B12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('C10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('C11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('C12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('D10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('D11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('D12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('E10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('E11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('E12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('F10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('F11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('F12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('G10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('G11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('G12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('H10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('H11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('H12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('I10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('I11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('I12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('J10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('J11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('J12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('K10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('K11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('K12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('L10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('L11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('L12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('M10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('M11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('M12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('N10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('N11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('N12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                    $no = 13;
                    // Buat numbering
                    $excel->setActiveSheetIndex(0)->setCellValue('A' . $no, "1");
                    $excel->setActiveSheetIndex(0)->setCellValue('B' . $no, "2");
                    $excel->setActiveSheetIndex(0)->setCellValue('C' . $no, "3");
                    $excel->setActiveSheetIndex(0)->setCellValue('D' . $no, "4");
                    $excel->setActiveSheetIndex(0)->setCellValue('E' . $no, "5");
                    $excel->setActiveSheetIndex(0)->setCellValue('F' . $no, "6");
                    $excel->setActiveSheetIndex(0)->setCellValue('G' . $no, "7");
                    $excel->setActiveSheetIndex(0)->setCellValue('H' . $no, "8");
                    $excel->setActiveSheetIndex(0)->setCellValue('I' . $no, "9");
                    $excel->setActiveSheetIndex(0)->setCellValue('J' . $no, "10");
                    $excel->setActiveSheetIndex(0)->setCellValue('K' . $no, "11");
                    $excel->setActiveSheetIndex(0)->setCellValue('L' . $no, "12");
                    $excel->setActiveSheetIndex(0)->setCellValue('M' . $no, "13");
                    $excel->setActiveSheetIndex(0)->setCellValue('N' . $no, "14");

                    // Apply style numbering yang telah kita buat tadi ke masing-masing kolom numbering
                    $excel->getActiveSheet()->getStyle('A' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('B' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('C' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('D' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('E' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('F' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('G' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('H' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('I' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('J' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('K' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('L' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('M' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('N' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                    // Menampilkan data
                    $numrow = 14; // Set baris pertama untuk isi tabel adalah baris ke 13
                    $p = 1;
                    $totrow = 0;
                    foreach ($dt_pemeliharaan as $i) { // Lakukan looping pada variabel

                        if ($i['satuan_brg'] == 1) {
                            $satuan_brg = "Buah";
                        } else if ($i['satuan_brg'] == 2) {
                            $satuan_brg = "Unit";
                        } else if ($i['satuan_brg'] == 3) {
                            $satuan_brg = "Set";
                        } else {
                            $satuan_brg = "";
                        }

                        if ($i['jmlh_brg'] == 0) {
                            $jmlh_brg = "";
                        } else {
                            $jmlh_brg = $i['jmlh_brg'];
                        }

                        if ($i['kondisi_brg'] == 1) {
                            $kondisi = "Baik";
                        } else if ($i['kondisi_brg'] == 2) {
                            $kondisi = "Rusak Ringan";
                        } else if ($i['kondisi_brg'] == 3) {
                            $kondisi = "Rusak Berat";
                        } else {
                            $kondisi = "";
                        }

                        if ($i['kondisi_brg'] == 1) {

                            $kondisi1 = "√";
                        } else {
                            $kondisi1 = "";
                        }

                        if ($i['kondisi_brg'] == 2) {
                            $kondisi2 = "√";
                        } else {
                            $kondisi2 = "";
                        }

                        if ($i['kondisi_brg'] == 3) {
                            $kondisi3 = "√";
                        } else {
                            $kondisi3 = "";
                        }

                        $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $p);
                        $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, "");
                        $excel->setActiveSheetIndex(0)->setCellValueExplicit('C' . $numrow, $i['kd_brg'], PHPExcel_Cell_DataType::TYPE_STRING);
                        $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $i['nm_brg']);
                        $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $jmlh_brg);
                        $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $satuan_brg);
                        $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $kondisi);
                        $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $kondisi1);
                        $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $kondisi2);
                        $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $kondisi3);
                        $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $i['nm_brg']);
                        $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $jmlh_brg);
                        $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $satuan_brg);
                        $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, $i['ket']);

                        // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                        $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row_center)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                        $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                        $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                        $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                        $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                        $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                        $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                        $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row_center)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                        $excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row_center)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                        $excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row_center)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                        $excel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                        $excel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                        $excel->getActiveSheet()->getStyle('M' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                        $excel->getActiveSheet()->getStyle('N' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                        // $numrow++; // Tambah 1 setiap kali looping
                        $p++;
                        $totrow = $numrow++;
                    }

                    $tgl = tgl_indo(date('Y-m-d'));
                    $row1 = $totrow + 2;
                    $row2 = $totrow + 3;
                    $row3 = $totrow + 4;
                    $row7 = $totrow + 8;
                    $row8 = $totrow + 9;

                    // Buat Kolom Tanda tanggan
                    $excel->setActiveSheetIndex(0)->mergeCells('J' . $row1 . ':N' . $row1);
                    $excel->setActiveSheetIndex(0)->setCellValue('J' . $row1, "Bandung, " . $tgl);
                    $excel->setActiveSheetIndex(0)->mergeCells('J' . $row2 . ':N' . $row2);
                    $excel->setActiveSheetIndex(0)->setCellValue('J' . $row2, "Kuasa Pengguna Barang");
                    $excel->setActiveSheetIndex(0)->mergeCells('J' . $row3 . ':N' . $row3);
                    $excel->setActiveSheetIndex(0)->setCellValue('J' . $row3, "SMA Negeri 3 Cimahi");
                    $excel->setActiveSheetIndex(0)->mergeCells('J' . $row7 . ':N' . $row7);
                    $excel->setActiveSheetIndex(0)->setCellValue('J' . $row7, "Dra, Hj, Nelly Krisdiyana, MM");
                    $excel->setActiveSheetIndex(0)->mergeCells('J' . $row8 . ':N' . $row8);
                    $excel->setActiveSheetIndex(0)->setCellValue('J' . $row8, "NIP. 195912121983022003");

                    // Apply style tanda tangan yang telah kita buat tadi ke masing-masing kolom tanda tangan
                    $excel->getActiveSheet()->getStyle('J' . $row1)->applyFromArray($style_row_ttd)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('J' . $row2)->applyFromArray($style_row_ttd)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('J' . $row3)->applyFromArray($style_row_ttd)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('J' . $row7)->applyFromArray($style_row_nm)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('J' . $row8)->applyFromArray($style_row_ttd)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                    // Set width kolom
                    $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                    $excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
                    $excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                    $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                    $excel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
                    $excel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
                    $excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
                    $excel->getActiveSheet()->getColumnDimension('H')->setWidth(7);
                    $excel->getActiveSheet()->getColumnDimension('I')->setWidth(7);
                    $excel->getActiveSheet()->getColumnDimension('J')->setWidth(7);
                    $excel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
                    $excel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
                    $excel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
                    $excel->getActiveSheet()->getColumnDimension('N')->setWidth(20);

                    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
                    $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

                    // Set orientasi kertas jadi LANDSCAPE
                    $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

                    date_default_timezone_set('Asia/Jakarta');
                    $date   =   date("mY");

                    // Set judul file excel nya
                    $excel->getActiveSheet(0)->setTitle("Data Laporan Pemeliharaan Aset External");
                    $excel->setActiveSheetIndex(0);

                    // Proses file excel
                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header('Content-Disposition: attachment; filename="Data Laporan Pemeliharaan Aset External ' . $date . '.xlsx"'); // Set nama file excel nya
                    header('Cache-Control: max-age=0');

                    header('Content-Transfer-Encoding: binary');
                    header('Accept-Ranges: bytes');
                    header('Cache-control: no-cache, pre-check=0, post-check=0');
                    header('Cache-control: private');
                    header('Pragma: private');
                    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // any date in the past

                    $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
                    $write->save('php://output');
                }
            } else {
                $this->session->set_flashdata('statusgagal', 'Membuat Laporan!!!');
                redirect('Laporan/lp_pemeliharaan');
            }
        }
    }

    public function export_usul_pengadaan()
    {
        if (isset($_POST['cetak'])) {
            $tgl_awal   = $this->input->post('tgl_awal');
            $tgl_akhir  = $this->input->post('tgl_akhir');
            $kategori   = $this->input->post('kategori');
            $dt_usul_pengadaan = $this->Laporan_model->print_usul_pengadaan($tgl_awal, $tgl_akhir, $kategori);

            // print_r($dt_usul_pengadaan); die;

            if ($dt_usul_pengadaan != "0") {

                // Load plugin PHPExcel nya
                include APPPATH . 'third_party/PHPExcel.php';

                // Panggil class PHPExcel nya
                $excel = new PHPExcel();

                date_default_timezone_set('Asia/Jakarta');
                $date   =   date("mY");

                // Settingan awal fil excel
                $excel->getProperties()->setCreator('Aset SIMA SMAN 3 Cimahi (' . $this->session->userdata('username') . ')')
                    ->setLastModifiedBy('Aset SIMA SMAN 3 Cimahi (' . $this->session->userdata('username') . ')')
                    ->setTitle("Data Laporan Usulan Pengadaan " . $date)
                    ->setSubject("Laporan Usulan Pengadaan " . $date)
                    ->setDescription("Data Laporan Usulan Pengadaan " . $date)
                    ->setKeywords("Data Laporan Usulan Pengadaan " . $date);

                // Buat sebuah variabel untuk menampung pengaturan style dari TITLE tabel
                $style_tit = array(
                    'font' => array('bold' => true), // Set font nya jadi bold
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                    )
                );

                // Buat sebuah variabel untuk menampung pengaturan style dari TITLE tabel
                $style_ket = array(
                    'font' => array('bold' => true), // Set font nya jadi bold
                    'alignment' => array(
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                    )
                );

                // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
                $style_col = array(
                    'font' => array('bold' => true), // Set font nya jadi bold
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                        'wrap' => true
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
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                        'wrap' => true
                    ),
                    'borders' => array(
                        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
                    )
                );

                // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
                $style_row_center = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                        'wrap' => true
                    ),
                    'borders' => array(
                        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
                    )
                );

                // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
                $style_row_nm = array(
                    'font' => array(
                        'bold' => true, // Set font nya jadi bold
                        'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE,
                        'strike'    => false,
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                        'wrap' => true
                    )
                );

                // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
                $style_row_ttd = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                        'wrap' => true
                    )
                );

                $tahun = date("Y");

                // Buat header tabel nya pada baris ke 1
                $excel->setActiveSheetIndex(0)->mergeCells('A1:O1');
                $excel->setActiveSheetIndex(0)->setCellValue('A1', "USULAN RENCANA KEBUTUHAN PENGADAAN BARANG MILIK DAERAH");
                $excel->setActiveSheetIndex(0)->mergeCells('A2:O2');
                $excel->setActiveSheetIndex(0)->setCellValue('A2', "(RENCANA PENGADAAN)");
                $excel->setActiveSheetIndex(0)->mergeCells('A3:O3');
                $excel->setActiveSheetIndex(0)->setCellValue('A3', "KUASA PENGGUNA BARANG SMA NEGERI 3 CIMAHI");
                $excel->setActiveSheetIndex(0)->mergeCells('A4:O4');
                $excel->setActiveSheetIndex(0)->setCellValue('A4', "TAHUN " . $tahun);
                $excel->setActiveSheetIndex(0)->setCellValue('B6', "PEMERINTAH DAERAH");
                $excel->setActiveSheetIndex(0)->setCellValue('C6', ": PROVINSI JAWA BARAT");
                $excel->setActiveSheetIndex(0)->setCellValue('B7', "PENGGUNA BARANG");
                $excel->setActiveSheetIndex(0)->setCellValue('C7', ": DINAS PENDIDIKAN");

                // Apply style header yang telah kita buat tadi ke masing-masing kolom header
                $excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('A2')->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B6')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('C6')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B7')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('C7')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                // Buat table head
                $excel->setActiveSheetIndex(0)->mergeCells('A10:A12');
                $excel->setActiveSheetIndex(0)->setCellValue('A10', "NO");
                $excel->setActiveSheetIndex(0)->mergeCells('B10:B12');
                $excel->setActiveSheetIndex(0)->setCellValue('B10', "PROGRAM/KEGIATAN/OUTPUT");
                $excel->setActiveSheetIndex(0)->mergeCells('C10:F10');
                $excel->setActiveSheetIndex(0)->setCellValue('C10', "USULAN RKBMD");
                $excel->setActiveSheetIndex(0)->mergeCells('C11:C12');
                $excel->setActiveSheetIndex(0)->setCellValue('C11', "KODE BARANG");
                $excel->setActiveSheetIndex(0)->mergeCells('D11:D12');
                $excel->setActiveSheetIndex(0)->setCellValue('D11', "NAMA BARANG");
                $excel->setActiveSheetIndex(0)->mergeCells('E11:E12');
                $excel->setActiveSheetIndex(0)->setCellValue('E11', "JUMLAH");
                $excel->setActiveSheetIndex(0)->mergeCells('F11:F12');
                $excel->setActiveSheetIndex(0)->setCellValue('F11', "SATUAN");
                $excel->setActiveSheetIndex(0)->mergeCells('G10:H10');
                $excel->setActiveSheetIndex(0)->setCellValue('G10', "KEBUTUHAN MAKSIMUM");
                $excel->setActiveSheetIndex(0)->mergeCells('G11:G12');
                $excel->setActiveSheetIndex(0)->setCellValue('G11', "JUMLAH");
                $excel->setActiveSheetIndex(0)->mergeCells('H11:H12');
                $excel->setActiveSheetIndex(0)->setCellValue('H11', "SATUAN");
                $excel->setActiveSheetIndex(0)->mergeCells('I10:L10');
                $excel->setActiveSheetIndex(0)->setCellValue('I10', "USULAN KEBUTUHAN PEMELIHARAAN");
                $excel->setActiveSheetIndex(0)->mergeCells('I11:I12');
                $excel->setActiveSheetIndex(0)->setCellValue('I11', "KODE BARANG");
                $excel->setActiveSheetIndex(0)->mergeCells('J11:J12');
                $excel->setActiveSheetIndex(0)->setCellValue('J11', "NAMA BARANG");
                $excel->setActiveSheetIndex(0)->mergeCells('K11:K12');
                $excel->setActiveSheetIndex(0)->setCellValue('K11', "JUMLAH");
                $excel->setActiveSheetIndex(0)->mergeCells('L11:L12');
                $excel->setActiveSheetIndex(0)->setCellValue('L11', "SATUAN");
                $excel->setActiveSheetIndex(0)->mergeCells('M10:N10');
                $excel->setActiveSheetIndex(0)->setCellValue('M10', "KEBUTUHAN MAKSIMUM");
                $excel->setActiveSheetIndex(0)->mergeCells('M11:M12');
                $excel->setActiveSheetIndex(0)->setCellValue('M11', "JUMLAH");
                $excel->setActiveSheetIndex(0)->mergeCells('N11:N12');
                $excel->setActiveSheetIndex(0)->setCellValue('N11', "SATUAN");
                $excel->setActiveSheetIndex(0)->mergeCells('O10:O12');
                $excel->setActiveSheetIndex(0)->setCellValue('O10', "KETERANGAN");

                // style tale head
                $excel->getActiveSheet()->getStyle('A10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('A11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('A12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('C10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('C11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('C12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('E10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('E11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('E12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('F10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('F11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('F12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('G10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('G11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('G12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('H10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('H11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('H12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('I10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('I11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('I12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('J10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('J11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('J12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('K10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('K11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('K12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('L10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('L11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('L12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('M10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('M11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('M12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('N10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('N11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('N12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('O10')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('O11')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('O12')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                $no = 13;
                // Buat numbering
                $excel->setActiveSheetIndex(0)->setCellValue('A' . $no, "1");
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $no, "2");
                $excel->setActiveSheetIndex(0)->setCellValue('C' . $no, "3");
                $excel->setActiveSheetIndex(0)->setCellValue('D' . $no, "4");
                $excel->setActiveSheetIndex(0)->setCellValue('E' . $no, "5");
                $excel->setActiveSheetIndex(0)->setCellValue('F' . $no, "6");
                $excel->setActiveSheetIndex(0)->setCellValue('G' . $no, "7");
                $excel->setActiveSheetIndex(0)->setCellValue('H' . $no, "8");
                $excel->setActiveSheetIndex(0)->setCellValue('I' . $no, "9");
                $excel->setActiveSheetIndex(0)->setCellValue('J' . $no, "10");
                $excel->setActiveSheetIndex(0)->setCellValue('K' . $no, "11");
                $excel->setActiveSheetIndex(0)->setCellValue('L' . $no, "12");
                $excel->setActiveSheetIndex(0)->setCellValue('M' . $no, "13");
                $excel->setActiveSheetIndex(0)->setCellValue('N' . $no, "14");
                $excel->setActiveSheetIndex(0)->setCellValue('O' . $no, "15");

                // Apply style numbering yang telah kita buat tadi ke masing-masing kolom numbering
                $excel->getActiveSheet()->getStyle('A' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('C' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('E' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('F' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('G' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('H' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('I' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('J' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('K' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('L' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('M' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('N' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('O' . $no)->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                // Menampilkan data
                $numrow = 14; // Set baris pertama untuk isi tabel adalah baris ke 13
                $p = 1;
                $totrow = 0;
                foreach ($dt_usul_pengadaan as $i) { // Lakukan looping pada variabel

                    if ($i['satuan_brg'] == 1) {
                        $satuan_brg = "Buah";
                    } else if ($i['satuan_brg'] == 2) {
                        $satuan_brg = "Unit";
                    } else if ($i['satuan_brg'] == 3) {
                        $satuan_brg = "Set";
                    } else {
                        $satuan_brg = "";
                    }

                    if ($i['jmlh_brg'] == 0) {
                        $jmlh_brg = "";
                    } else {
                        $jmlh_brg = $i['jmlh_brg'];
                    }

                    $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $p);
                    $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, "");
                    $excel->setActiveSheetIndex(0)->setCellValueExplicit('C' . $numrow, $i['kd_brg'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $i['nm_brg']);
                    $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $jmlh_brg);
                    $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $satuan_brg);
                    $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, "");
                    $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, "");
                    $excel->setActiveSheetIndex(0)->setCellValueExplicit('I' . $numrow, $i['kd_brg'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $i['nm_brg']);
                    $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, "");
                    $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, "");
                    $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, "");
                    $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, "");
                    $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, $i['ket']);

                    // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                    $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row_center)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('M' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('N' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('O' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                    // $numrow++; // Tambah 1 setiap kali looping
                    $p++;
                    $totrow = $numrow++;
                }

                $tgl = tgl_indo(date('Y-m-d'));
                $row1 = $totrow + 2;
                $row2 = $totrow + 3;
                $row3 = $totrow + 4;
                $row7 = $totrow + 8;
                $row8 = $totrow + 9;

                // Buat Kolom Tanda tanggan
                $excel->setActiveSheetIndex(0)->mergeCells('M' . $row1 . ':O' . $row1);
                $excel->setActiveSheetIndex(0)->setCellValue('M' . $row1, "Bandung, " . $tgl);
                $excel->setActiveSheetIndex(0)->mergeCells('M' . $row2 . ':O' . $row2);
                $excel->setActiveSheetIndex(0)->setCellValue('M' . $row2, "Kuasa Pengguna Barang");
                $excel->setActiveSheetIndex(0)->mergeCells('M' . $row3 . ':O' . $row3);
                $excel->setActiveSheetIndex(0)->setCellValue('M' . $row3, "SMA Negeri 3 Cimahi");
                $excel->setActiveSheetIndex(0)->mergeCells('M' . $row7 . ':O' . $row7);
                $excel->setActiveSheetIndex(0)->setCellValue('M' . $row7, "Dra, Hj, Nelly Krisdiyana, MM");
                $excel->setActiveSheetIndex(0)->mergeCells('M' . $row8 . ':O' . $row8);
                $excel->setActiveSheetIndex(0)->setCellValue('M' . $row8, "NIP. 195912121983022003");

                // Apply style tanda tangan yang telah kita buat tadi ke masing-masing kolom tanda tangan
                $excel->getActiveSheet()->getStyle('M' . $row1)->applyFromArray($style_row_ttd)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('M' . $row2)->applyFromArray($style_row_ttd)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('M' . $row3)->applyFromArray($style_row_ttd)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('M' . $row7)->applyFromArray($style_row_nm)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('M' . $row8)->applyFromArray($style_row_ttd)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

                // Set width kolom
                $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
                $excel->getActiveSheet()->getColumnDimension('O')->setWidth(20);

                // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
                $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

                // Set orientasi kertas jadi LANDSCAPE
                $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

                date_default_timezone_set('Asia/Jakarta');
                $date   =   date("mY");

                // Set judul file excel nya
                $excel->getActiveSheet(0)->setTitle("Data Laporan Usulan Pengadaan");
                $excel->setActiveSheetIndex(0);

                // Proses file excel
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment; filename="Data Laporan Usulan Pengadaan ' . $date . '.xlsx"'); // Set nama file excel nya
                header('Cache-Control: max-age=0');

                header('Content-Transfer-Encoding: binary');
                header('Accept-Ranges: bytes');
                header('Cache-control: no-cache, pre-check=0, post-check=0');
                header('Cache-control: private');
                header('Pragma: private');
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // any date in the past

                $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
                $write->save('php://output');
            } else {
                $this->session->set_flashdata('statusgagal', 'Membuat Laporan!!!');
                redirect('Laporan/lp_usul_pengadaan');
            }
        }
    }

    public function export_pengadaan()
    {
        if (isset($_POST['cetak'])) 
        {
            $tgl_awal  = $this->input->post('tgl_awal');
            $tgl_akhir = $this->input->post('tgl_akhir');
            $kategori  = $this->input->post('kategori');
            $thn_beli  = $this->input->post('thn_beli');
            $dt_pengadaan = $this->Laporan_model->get_data_pengadaan_ctk($tgl_awal, $tgl_akhir, $kategori, $thn_beli);

            if ($dt_pengadaan != 0) {
                
                // Load plugin PHPExcel nya
                include APPPATH . 'third_party/PHPExcel.php';
    
                // Panggil class PHPExcel nya
                $excel = new PHPExcel();
    
                date_default_timezone_set('Asia/Jakarta');
                $date   =   date("mY");
    
                // Settingan awal fil excel
                $excel->getProperties()->setCreator('Wakasek SIMA SMAN 3 Cimahi (' . $this->session->userdata('username') . ')')
                    ->setLastModifiedBy('Wakasek SIMA SMAN 3 Cimahi (' . $this->session->userdata('username') . ')')
                    ->setTitle("Data Laporan Pengadaan " . $date)
                    ->setSubject("Laporan Pengadaan " . $date)
                    ->setDescription("Data Laporan Pengadaan " . $date)
                    ->setKeywords("Data Laporan Pengadaan " . $date);
    
                // Buat sebuah variabel untuk menampung pengaturan style dari TITLE tabel
                $style_tit = array(
                    'font' => array('bold' => true), // Set font nya jadi bold
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                    )
                );
    
                // Buat sebuah variabel untuk menampung pengaturan style dari ket tabel
                $style_ket = array(
                    'font' => array('bold' => true), // Set font nya jadi bold
                    'alignment' => array(
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                    )
                );
    
                // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
                $style_col = array(
                    'font' => array('bold' => true), // Set font nya jadi bold
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                        'wrap' => true
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
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                        'wrap' => true
                    ),
                    'borders' => array(
                        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
                    )
                );
    
                // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
                $style_row_center = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                        'wrap' => true
                    ),
                    'borders' => array(
                        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
                    )
                );
    
                // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
                $style_row_nm = array(
                    'font' => array(
                        'bold' => true, // Set font nya jadi bold
                        'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE,
                        'strike'    => false,
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                        'wrap' => true
                    )
                );
    
                // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
                $style_row_ttd = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                        'wrap' => true
                    )
                );
    
                // Buat header tabel nya pada baris ke 1
                $excel->setActiveSheetIndex(0)->mergeCells('A1:Q1');
                $excel->setActiveSheetIndex(0)->setCellValue('A1', "BUKU INVENTARIS");
                $excel->setActiveSheetIndex(0)->mergeCells('A2:Q2');
                $excel->setActiveSheetIndex(0)->setCellValue('A2', "INTRA COUNTABLE");
                $excel->setActiveSheetIndex(0)->mergeCells('B3:C3');
                $excel->setActiveSheetIndex(0)->setCellValue('B3', "SKPD");
                $excel->setActiveSheetIndex(0)->setCellValue('D3', ": 1.01.01.115. SMUN 3 CIMAHI");
                $excel->setActiveSheetIndex(0)->mergeCells('B4:C4');
                $excel->setActiveSheetIndex(0)->setCellValue('B4', "KABUPATEN/KOTA");
                $excel->setActiveSheetIndex(0)->setCellValue('D4', ": KOTA CIMAHI");
                $excel->setActiveSheetIndex(0)->mergeCells('B5:C5');
                $excel->setActiveSheetIndex(0)->setCellValue('B5', "PROVINSI");
                $excel->setActiveSheetIndex(0)->setCellValue('D5', ": JAWA BARAT");
                $excel->setActiveSheetIndex(0)->mergeCells('B6:C6');
                $excel->setActiveSheetIndex(0)->setCellValue('B6', "NO. KODE LOKASI");
                $excel->setActiveSheetIndex(0)->setCellValue('D6', ": ");
    
                // Style untuk keader
                $excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('A2')->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B5')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D5')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B6')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D6')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
    
                // Buat Table head
                $excel->setActiveSheetIndex(0)->setCellValue('A8', "No");
                $excel->setActiveSheetIndex(0)->setCellValue('B8', "No Kode Barang");
                $excel->setActiveSheetIndex(0)->setCellValue('C8', "No Register");
                $excel->setActiveSheetIndex(0)->setCellValue('D8', "Nama Barang");
                $excel->setActiveSheetIndex(0)->setCellValue('E8', "Merk/Type");
                $excel->setActiveSheetIndex(0)->setCellValue('F8', "No Sertifikat");
                $excel->setActiveSheetIndex(0)->setCellValue('G8', "Bahan");
                $excel->setActiveSheetIndex(0)->setCellValue('H8', "Asal/Cara Perolehan");
                $excel->setActiveSheetIndex(0)->setCellValue('I8', "Tahun Priode");
                $excel->setActiveSheetIndex(0)->setCellValue('J8', "Ukuran Barang");
                $excel->setActiveSheetIndex(0)->setCellValue('K8', "Satuan");
                $excel->setActiveSheetIndex(0)->setCellValue('L8', "Keadaan Barang (B, RR, RB)");
                $excel->setActiveSheetIndex(0)->setCellValue('M8', "Jumlah Barang");
                $excel->setActiveSheetIndex(0)->setCellValue('N8', "Harga");
                $excel->setActiveSheetIndex(0)->setCellValue('O8', "Umur Ekonomis");
                $excel->setActiveSheetIndex(0)->setCellValue('P8', "Nilai Sisa");
                $excel->setActiveSheetIndex(0)->setCellValue('Q8', "Keterangan");
    
                // Apply style table head yang telah kita buat tadi ke masing-masing kolom table head
                $excel->getActiveSheet()->getStyle('A8')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B8')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('C8')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D8')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('E8')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('F8')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('G8')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('H8')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('I8')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('J8')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('K8')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('L8')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('M8')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('N8')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('O8')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('P8')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('Q8')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
    
                // Menampilkan data
                $numrow = 9; // Set baris pertama untuk isi tabel adalah baris ke 9
                $p = 1;
                $totrow = 0;
                
                foreach ($dt_pengadaan as $i) { // Lakukan looping pada variabel
                    if ($i['satuan_brg'] == 1) {
                        $satuan = "Buah";
                    } else if ($i['satuan_brg'] == 2) {
                        $satuan = "Unit";
                    } else if ($i['satuan_brg'] == 3) {
                        $satuan = "Set";
                    } else {
                        $satuan = "-";
                    }
    
                    if ($i['kondisi'] == 1) {
                        $kondisi = "Baik";
                    } else if ($i['kondisi'] == 2) {
                        $kondisi = "Rusak Ringan";
                    } else if ($i['kondisi'] == 3) {
                        $kondisi = "Rusak Berat";
                    } else {
                        $kondisi = "-";
                    }
    
                    $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $p);
                    $excel->setActiveSheetIndex(0)->setCellValueExplicit('B' . $numrow, $i['kd_brg'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $excel->setActiveSheetIndex(0)->setCellValueExplicit('C' . $numrow, $i['no_reg'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $i['nm_brg']);
                    $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $i['merk_type']);
                    $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $i['st_stfkt_no']);
                    $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $i['bahan']);
                    $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $i['perolehan']);
                    $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $i['thn_beli']);
                    $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $i['ukuran_cc']);
                    $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $satuan);
                    $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $kondisi);
                    $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $i['jmlh_brg']);
                    $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, number_format("$i[harga]", 2, ",", "."));
                    $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, $i['umr_ekonomis']);
                    $excel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, number_format("$i[nli_sisa]", 2, ",", "."));
                    $excel->setActiveSheetIndex(0)->setCellValue('Q' . $numrow, $i['ket']);
    
                    // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                    $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row_center)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('M' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('N' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('O' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('P' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('Q' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
    
                    $totrow = $numrow++; // Tambah 1 setiap kali looping
                    $p++;
                }
    
                $row1 = $totrow + 2;
                $row2 = $totrow + 3;
                $row3 = $totrow + 8;
                $row4 = $totrow + 9;
                $row5 = $totrow + 10;
    
                // Buat Kolom Tanda tanggan
                $excel->setActiveSheetIndex(0)->mergeCells('B' . $row1 . ':C' . $row1);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $row1, "Mengetahui");
                $excel->setActiveSheetIndex(0)->mergeCells('B' . $row2 . ':C' . $row2);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $row2, "Kepala SMA Negeri 3 Cimahi");
                $excel->setActiveSheetIndex(0)->mergeCells('B' . $row3 . ':C' . $row3);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $row3, "Dra, Hj. Mimin Hermiati, MM");
                $excel->setActiveSheetIndex(0)->mergeCells('B' . $row4 . ':C' . $row4);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $row4, "Pembina Utama Muda");
                $excel->setActiveSheetIndex(0)->mergeCells('B' . $row5 . ':C' . $row5);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $row5, "NIP. 195611181980032004");
    
                $excel->setActiveSheetIndex(0)->mergeCells('H' . $row2 . ':J' . $row2);
                $excel->setActiveSheetIndex(0)->setCellValue('H' . $row2, "Wakasek Sarana");
                $excel->setActiveSheetIndex(0)->mergeCells('H' . $row3 . ':J' . $row3);
                $excel->setActiveSheetIndex(0)->setCellValue('H' . $row3, "Sri Purwanti, SE. MM");
                $excel->setActiveSheetIndex(0)->mergeCells('H' . $row4 . ':J' . $row4);
                $excel->setActiveSheetIndex(0)->setCellValue('H' . $row4, "NIP. 196412161987032005");
    
                $excel->setActiveSheetIndex(0)->mergeCells('O' . $row2 . ':P' . $row2);
                $excel->setActiveSheetIndex(0)->setCellValue('O' . $row2, "Pengurus Barang");
                $excel->setActiveSheetIndex(0)->mergeCells('O' . $row3 . ':P' . $row3);
                $excel->setActiveSheetIndex(0)->setCellValue('O' . $row3, "Dadang Yana Suryana");
                $excel->setActiveSheetIndex(0)->mergeCells('O' . $row4 . ':P' . $row4);
                $excel->setActiveSheetIndex(0)->setCellValue('O' . $row4, "NIP. 197004102010011004");
    
                // Apply style tanda tangan yang telah kita buat tadi ke masing-masing kolom tanda tangan
                $excel->getActiveSheet()->getStyle('B' . $row1)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B' . $row2)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B' . $row3)->applyFromArray($style_row_nm)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B' . $row4)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B' . $row5)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
    
                $excel->getActiveSheet()->getStyle('H' . $row2)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('H' . $row3)->applyFromArray($style_row_nm)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('H' . $row4)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
    
                $excel->getActiveSheet()->getStyle('O' . $row2)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('O' . $row3)->applyFromArray($style_row_nm)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('O' . $row4)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
    
                // Set width kolom
                $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth(50);
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('Q')->setWidth(50);
    
                // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
                $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
    
                // Set orientasi kertas jadi LANDSCAPE
                $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
    
                date_default_timezone_set('Asia/Jakarta');
                $date   =   date("mY");
    
                // Set judul file excel nya
                $excel->getActiveSheet(0)->setTitle("Data Laporan Pengadaan");
                $excel->setActiveSheetIndex(0);
    
                // Proses file excel
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment; filename="Data Laporan Pengadaan ' . $date . '.xlsx"'); // Set nama file excel nya
                header('Cache-Control: max-age=0');
    
                header('Content-Transfer-Encoding: binary');
                header('Accept-Ranges: bytes');
                header('Cache-control: no-cache, pre-check=0, post-check=0');
                header('Cache-control: private');
                header('Pragma: private');
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // any date in the past
    
                $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
                $write->save('php://output');
            } else {
                $role = $this->session->userdata('role');
                if ($role == 2) {
                    $this->session->set_flashdata('statusgagal', 'Membuat Laporan!!!');
                    redirect('Laporan/lp_pengadaan_wk');
                } elseif($role == 3) {
                    $this->session->set_flashdata('statusgagal', 'Membuat Laporan!!!');
                    redirect('Laporan/lp_pengadaan_kep');
                } else {
                    redirect('Welcome/index');
                }
            }
        }
    }

    public function export_peminjaman()
    {
        if (isset($_POST['cetak'])) {

            $tgl_awal  = $this->input->post('tgl_awal');
            $tgl_akhir = $this->input->post('tgl_akhir');
            $kategori  = $this->input->post('kategori');
            $dt_peminjaman = $this->Laporan_model->get_data_peminjaman_ctk($tgl_awal, $tgl_akhir, $kategori);

            if ($dt_peminjaman != 0) {
                
                // Load plugin PHPExcel nya
                include APPPATH . 'third_party/PHPExcel.php';
    
                // Panggil class PHPExcel nya
                $excel = new PHPExcel();
    
                date_default_timezone_set('Asia/Jakarta');
                $date   =   date("mY");
    
                // Settingan awal file excel
                $excel->getProperties()->setCreator('Wakasek SIMA SMAN 3 Cimahi (' . $this->session->userdata('username') . ')')
                    ->setLastModifiedBy('Wakasek SIMA SMAN 3 Cimahi (' . $this->session->userdata('username') . ')')
                    ->setTitle("Data Laporan Peminjaman " . $date)
                    ->setSubject("Laporan Peminjaman " . $date)
                    ->setDescription("Data Laporan Peminjaman " . $date)
                    ->setKeywords("Data Laporan Peminjaman " . $date);
    
                // Buat sebuah variabel untuk menampung pengaturan style dari TITLE tabel
                $style_tit = array(
                    'font' => array('bold' => true), // Set font nya jadi bold
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                    )
                );
    
                // Buat sebuah variabel untuk menampung pengaturan style dari ket tabel
                $style_ket = array(
                    'font' => array('bold' => true), // Set font nya jadi bold
                    'alignment' => array(
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                    )
                );
    
                // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
                $style_col = array(
                    'font' => array('bold' => true), // Set font nya jadi bold
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                        'wrap' => true
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
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                        'wrap' => true
                    ),
                    'borders' => array(
                        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
                    )
                );
    
                // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
                $style_row_center = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                        'wrap' => true
                    ),
                    'borders' => array(
                        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
                    )
                );
    
                // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
                $style_row_nm = array(
                    'font' => array(
                        'bold' => true, // Set font nya jadi bold
                        'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE,
                        'strike'    => false,
                    ),
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                        'wrap' => true
                    )
                );
    
                // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
                $style_row_ttd = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)
                        'wrap' => true
                    )
                );
    
                // Buat header tabel nya pada baris ke 1
                $excel->setActiveSheetIndex(0)->mergeCells('E1:F1');
                $excel->setActiveSheetIndex(0)->setCellValue('E1', "LAPORAN PEMINJAMAN");
                $excel->setActiveSheetIndex(0)->setCellValue('B3', "SKPD");
                $excel->setActiveSheetIndex(0)->setCellValue('C3', ": 1.01.01.115. SMUN 3 CIMAHI");
                $excel->setActiveSheetIndex(0)->setCellValue('B4', "KABUPATEN/KOTA");
                $excel->setActiveSheetIndex(0)->setCellValue('C4', ": KOTA CIMAHI");
                $excel->setActiveSheetIndex(0)->setCellValue('B5', "PROVINSI");
                $excel->setActiveSheetIndex(0)->setCellValue('C5', ": Jawa Barat");
    
                // Style untuk header
                $excel->getActiveSheet()->getStyle('E1')->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B5')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('C5')->applyFromArray($style_ket)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
    
                // Buat table head
                $excel->setActiveSheetIndex(0)->setCellValue('A8', "No");
                $excel->setActiveSheetIndex(0)->setCellValue('B8', "Nama Peminjaman");
                $excel->setActiveSheetIndex(0)->setCellValue('C8', "No Hp");
                $excel->setActiveSheetIndex(0)->setCellValue('D8', "Tanggal Peminjaman");
                $excel->setActiveSheetIndex(0)->setCellValue('E8', "Tanggal Pengembalian");
                $excel->setActiveSheetIndex(0)->setCellValue('F8', "Realisasi Pengembalian");
                $excel->setActiveSheetIndex(0)->setCellValue('G8', "Kode Barang");
                $excel->setActiveSheetIndex(0)->setCellValue('H8', "Nama Barang");
                $excel->setActiveSheetIndex(0)->setCellValue('I8', "Keterangan");
    
                // Apply style table head yang telah kita buat tadi ke masing-masing kolom table head
                $excel->getActiveSheet()->getStyle('A8')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B8')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('C8')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('D8')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
                $excel->getActiveSheet()->getStyle('E8')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
                $excel->getActiveSheet()->getStyle('F8')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
                $excel->getActiveSheet()->getStyle('G8')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('H8')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('I8')->applyFromArray($style_col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
    
                // Menampilkan data
                $numrow = 9; // Set baris pertama untuk isi tabel adalah baris ke 9
                $p = 1;
                $totrow = 0;
                
                foreach ($dt_peminjaman as $i) { // Lakukan looping pada variabel
    
                    $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $p);
                    $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $i['nm_peminjaman']);
                    $excel->setActiveSheetIndex(0)->setCellValueExplicit('C' . $numrow, $i['nohp_peminjaman'], PHPExcel_Cell_DataType::TYPE_STRING);
                    $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $i['tgl_peminjaman']);
                    $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $i['tgl_pengembalian']);
                    $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $i['realisasi_pengembalian']);
                    $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $i['kd_brg']);
                    $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $i['nm_brg']);
                    $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $i['ket']);
    
                    // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                    $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row_center)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                    $excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
    
                    $totrow = $numrow++; // Tambah 1 setiap kali looping
                    $p++;
                }
    
                $row1 = $totrow + 2;
                $row2 = $totrow + 3;
                $row3 = $totrow + 8;
                $row4 = $totrow + 9;
                $row5 = $totrow + 10;
    
                // Buat Kolom Tanda tanggan
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $row1, "Mengetahui");
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $row2, "Kepala SMA Negeri 3 Cimahi");
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $row3, "Dra, Hj. Mimin Hermiati, MM");
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $row4, "Pembina Utama Muda");
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $row5, "NIP. 195611181980032004");
    
                $excel->setActiveSheetIndex(0)->setCellValue('E' . $row2, "Wakasek Sarana");
                $excel->setActiveSheetIndex(0)->setCellValue('E' . $row3, "Sri Purwanti, SE. MM");
                $excel->setActiveSheetIndex(0)->setCellValue('E' . $row4, "NIP. 196412161987032005");
    
                $excel->setActiveSheetIndex(0)->setCellValue('H' . $row2, "Pengurus Barang");
                $excel->setActiveSheetIndex(0)->setCellValue('H' . $row3, "Dadang Yana Suryana");
                $excel->setActiveSheetIndex(0)->setCellValue('H' . $row4, "NIP. 197004102010011004");
    
                // Apply style tanda tangan yang telah kita buat tadi ke masing-masing kolom tanda tangan
                $excel->getActiveSheet()->getStyle('B' . $row1)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B' . $row2)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B' . $row3)->applyFromArray($style_row_nm)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B' . $row4)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('B' . $row5)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
    
                $excel->getActiveSheet()->getStyle('E' . $row2)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('E' . $row3)->applyFromArray($style_row_nm)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('E' . $row4)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
    
                $excel->getActiveSheet()->getStyle('H' . $row2)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('H' . $row3)->applyFromArray($style_row_nm)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $excel->getActiveSheet()->getStyle('H' . $row4)->applyFromArray($style_tit)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
    
                // Set width kolom
                $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth(22);
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth(23);
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
                $excel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
                $excel->getActiveSheet()->getColumnDimension('I')->setWidth(40);
    
                // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
                $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
    
                // Set orientasi kertas jadi LANDSCAPE
                $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
    
                date_default_timezone_set('Asia/Jakarta');
                $date   =   date("mY");
    
                // Set judul file excel nya
                $excel->getActiveSheet(0)->setTitle("Data Laporan Peminjaman");
                $excel->setActiveSheetIndex(0);
    
                // Proses file excel
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment; filename="Data Laporan Peminjaman ' . $date . '.xlsx"'); // Set nama file excel nya
                header('Cache-Control: max-age=0');
    
                header('Content-Transfer-Encoding: binary');
                header('Accept-Ranges: bytes');
                header('Cache-control: no-cache, pre-check=0, post-check=0');
                header('Cache-control: private');
                header('Pragma: private');
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // any date in the past
    
                $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
                $write->save('php://output');
            } else {
                $role = $this->session->userdata('role');
                if ($role == 2) {
                    $this->session->set_flashdata('statusgagal', 'Membuat Laporan!!!');
                    redirect('Laporan/lp_peminjaman_wk');
                } elseif($role == 3) {
                    $this->session->set_flashdata('statusgagal', 'Membuat Laporan!!!');
                    redirect('Laporan/lp_peminjaman_kep');
                } else {
                    redirect('Welcome/index');
                }
            }
        }
    }
}
