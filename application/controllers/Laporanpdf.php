<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class Laporanpdf extends CI_Controller {

	function __construct(){
        
        parent::__construct();
        $this->load->library('PDFNEW');
		/* if($this->session->userdata('STATUSLOGIN') != "LOGIN"){
			redirect(base_url("Login"));
		} */
    }
    
	public function index()
	{
        //ambil data
        $empID = $this->input->post("cetakIDemp");
        $rbID = $this->input->post("cetakIDreim");
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
        //ambil 1 row reimbursenya employee
		$whereReim = array(
			'RB_ID' => $rbID,
		);
		$rowReim = $this->Model_online->findSingleDataWhere($whereReim,'tr_reimburse');
		//ambil semua row detail reimburse
		$whereDet = array(
			'RB_ID' => $rbID,
		);
        $someData = $this->Model_online->findAllDataWhere($whereDet,'tr_detail_reimburse');
        $whereApp = array(
            'RB_ID' => $rbID,
        );
        $dataApp = $this->Model_online->findApproval($whereApp);
        $whereApp2 = array(
            'RB_ID' => $rbID,
        );
        $dataApp2 = $this->Model_online->findApproval($whereApp2);
        

        $nama = $rowEmp['EMP_FULL_NAME'];
        $idreim = $rowReim['RB_ID'];
        $tglSubmit = $rowReim['RB_SUBMIT_DATE'];
        $rbtotal = $rowReim['RB_TOTAL'];
        global $id;
        global $name;
        global $date;
        global $app;
        global $brName;
        global $departName;
        global $datapindah;
        global $datapindah2;
        global $datesub;
        $datapindah = $dataApp;
        $datapindah2 = $dataApp2;
        $name= $nama;
        $datesub = $tglSubmit;
        $id = $idreim;
        $brName = $rowBr['BRANCH_NAME'];
        $departName = $rowDiv['DEPART_NAME'];
        $app = $rowReim['RB_FINAL_APP_DATE'];
        //inisialisasi
        $pdf = new PDFNEW('L','mm','A5');
        $pdf->isFinished = false;
        $pdf->SetAutoPageBreak(true, 30);
        // membuat halaman baru
        $pdf->AddPage();
        $pdf->SetFont('Arial','',10);
        $x = 1;
        foreach ($someData as $someData){ 
            $pdf->SetWidths(array(6,145,40));
            $pdf->Row(array($x++,$someData['DET_RB_ITEM'],'Rp.'.number_format($someData['DET_RB_VALUE'])));
        }
           
        $pdf->Cell(121,6,'','BTL',0);
        $pdf->Cell(30,6,'Total Reimburse','BTR',0);
        $pdf->Cell(40,6,'Rp.'.number_format($rowReim['RB_TOTAL']),1,1);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(190,5,'',0,1);
        $pdf->isFinished = true;
        $pdf->Output();
	}
}