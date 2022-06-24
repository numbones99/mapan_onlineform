<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class Laporankasbon extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->library('PDFKASBON');
    }
    
	public function index()
	{
        //ambil data
        $empID = $this->input->post("cetakIDemp");
        $kbID = $this->input->post("cetakIDkb");
        //ambil 1 row nama employee
		$whereEmp = array(
			'EMP_ID' => $empID,
		);
        $rowEmp = $this->Model_online->findSingleDataWhere($whereEmp,'m_employee');
        //cari departemen/divisinya
        $whereDiv = array(
			'DEPART_ID' => $rowEmp['DEPART_ID'],
		);
        $rowDiv = $this->Model_online->findSingleDataWhere($whereDiv,'m_department');
        //cari cabangnya
        $whereBr = array(
			'BRANCH_ID' => $rowDiv['BRANCH_ID'],
		);
        $rowBr = $this->Model_online->findSingleDataWhere($whereBr,'m_branch');
        //ambil 1 row kasbon employee
		$whereKasbon = array(
			'KB_ID' => $kbID,
		);
		$rowKasbon = $this->Model_online->findSingleDataWhere($whereKasbon,'tr_kasbon');
		//ambil semua row detail kasbon
		$whereDet = array(
			'KB_ID' => $kbID,
		);
        $someData = $this->Model_online->findAllDataWhere($whereDet,'tr_detail_kasbon');
        
        $whereApp = array(
            'KB_ID' => $kbID,
        );
        $dataApp = $this->Model_online->findApprovalKB($whereApp);
        $whereApp2 = array(
            'KB_ID' => $kbID,
        );
        $dataApp2 = $this->Model_online->findApprovalKB($whereApp2);
        
        global $idkasbon;
        global $namekasbon;
        global $datesub; // diganti dari $date ke $datesub
        global $daterep; 
        global $appkasbon;
        global $brNamekasbon;
        global $departNamekasbon;
        global $totalawal;
        global $totalakhir;
        global $selisih;
        global $datapindah;
        global $datapindah2;
        
        $datapindah = $dataApp;
        $datapindah2 = $dataApp2;
        $namekasbon= $rowEmp['EMP_FULL_NAME'];
        $datesub = $rowKasbon['KB_SUBMIT_DATE'];
        $daterep= $rowKasbon['KB_REPORT_DATE'];
        $idkasbon = $rowKasbon['KB_ID'];
        $brNamekasbon = $rowBr['BRANCH_NAME'];
        $departNamekasbon = $rowDiv['DEPART_NAME'];
        $totalawal = $rowKasbon['KB_TOTAL_AWAL'];
        $totalakhir = $rowKasbon['KB_TOTAL_AWAL'];
        $selisih = $rowKasbon['KB_DIFF'];
        $appkasbon = $rowKasbon['KB_APP_DATE'];
        //inisiasi
        $pdfx = new PDFKASBON('L','mm','A5');
        $pdfx->isFinished = false;
        $pdfx->SetAutoPageBreak(true, 30);
        // membuat halaman baru
        $pdfx->AddPage();
        $pdfx->SetFont('Arial','',10);
        $x = 1;
        $countData = count($someData);
        foreach ($someData as $someData){ 
            $pdfx->SetWidths(array(6,95,30,30,30));
            $pdfx->Row(array($x++,$someData['DET_KB_ITEM'],'Rp.'.number_format($someData['DET_KB_VALUE']),'Rp.'.number_format($someData['DET_KB_END_VALUE']),'Rp.'.number_format($someData['DET_KB_DIFF'])));
            $whereReal = array(
                'DET_KB_ID' => $someData['DET_KB_ID'],
            );
            $someDataReal = $this->Model_online->findAllDataWhere($whereReal,'tr_detail_real');
            foreach ($someDataReal as $someDataReal){
                $pdfx->SetFillColor(255,251,77);
                $pdfx->SetWidths(array(6,95,30,30,30));
                $pdfx->Row(array('>',$someDataReal['REAL_NAME'],'','Rp.'.number_format($someDataReal['REAL_VALUE']),''));
            }
        }
        $pdfx->Cell(86,6,'','BTL',0);
        $pdfx->Cell(15,6,'Total :','BTR',0);
        $pdfx->Cell(30,6,'Rp.'.number_format($rowKasbon['KB_TOTAL_AWAL']),1,0);
        $pdfx->Cell(30,6,'Rp.'.number_format($rowKasbon['KB_TOTAL_AKHIR']),1,0);
        $pdfx->Cell(30,6,'Rp.'.number_format($rowKasbon['KB_DIFF']),1,1);
        $pdfx->Cell(191,2,'',0,1);
        $pdfx->isFinished = true;
        $pdfx->Output();
	}
}