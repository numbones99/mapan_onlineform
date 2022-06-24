<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class Laporanproyek extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->library('PDFPROJECT');
    }
    
	public function index()
	{
        //ambil data
        $printId = $this->input->post("printId");
        //ambil data proyeknya
        $arr_project = array(
			'PR_ID' => $printId,
		);
        $rowProject = $this->Model_online->findSingleDataWhere($arr_project,'tr_project');
        //ambil data pengaju dari data proyek
        $arr_aju = array(
            'EMP_ID' => $rowProject['PR_SUB_EMP'],
        );
        $rowAju = $this->Model_online->findSingleDataWhere($arr_aju,'m_employee');
        //ambil data branch dari data proyek 
        $arr_branch = array(
            'BRANCH_ID' => $rowProject['BRANCH_ID'],
        );
        $rowBranch = $this->Model_online->findSingleDataWhere($arr_branch,'m_branch');
        //ambil data divisi dari data employee
        $arr_depart = array(
            'DEPART_ID' => $rowAju['DEPART_ID'],
        );
        $rowDepart = $this->Model_online->findSingleDataWhere($arr_depart,'m_department');
        //ambil data detail proyek dari data proyek
        $rowDtProject = $this->Model_online->findAllDataWhere($arr_project,'tr_detail_project_sub');
        //ambil data pembayaran proyek dari data proyek
        $rowRealProject = $this->Model_online->findAllDataWhere($arr_project,'tr_project_real');
        
        global $projectId;
        global $projectName;
        global $projectEmpName;
        global $projectDateSub;
        global $projectLastUpdate; 
        global $projectBranch;
        global $projectTotal;
        global $projectPaidTotal;
        global $projectEmpDepart;
        
        $projectId = $rowProject['PR_ID'];
        $projectName = $rowProject['PR_NAME'];
        $projectEmpName = $rowAju['EMP_FULL_NAME'];
        $projectDateSub = $rowProject['PR_SUB_DATE'];
        $projectLastUpdate = $rowProject['PR_LAST_UPDATE'];
        $projectBranch = $rowBranch['BRANCH_NAME'];
        $projectTotal = $rowProject['PR_TOTAL'];
        $projectPaidTotal = $rowProject['PR_PAID_TOTAL'];
        $projectEmpDepart = $rowDepart['DEPART_NAME'];
        //inisiasi
        $pdfx = new PDFPROJECT('P','mm','legal');
        $pdfx->isFinished = false;
        $pdfx->SetAutoPageBreak(true, 30);
        // membuat halaman baru
        $pdfx->AddPage();
        $pdfx->SetFont('Arial','',10);
        $x = 1;
        $winner = '';
        $countProject = count($rowDtProject);
        $countRealProject = count($rowRealProject);
        if($countProject>$countRealProject){
            $winner = $countProject;
        }elseif($countProject<$countRealProject){
            $winner = $countRealProject;
        }else{
            $winner = $countProject;
        }
        for($i=0;$i<$winner;$i++){
            $arr_ambil_emp = array(
                'EMP_ID' => $rowDtProject[$i]['EMP_ID'],
            );
            $row_ambil_emp = $this->Model_online->findSingleDataWhere($arr_ambil_emp,'m_employee');
            $arr_ambil_depart = array(
                'DEPART_ID' => $row_ambil_emp['DEPART_ID'],
            );
            $row_ambil_depart = $this->Model_online->findSingleDataWhere($arr_ambil_depart,'m_department');
            $pdfx->SetWidths(array(6,30,50,30,6,43,30));
            $pdfx->Row(array(
                        '#',
                        $row_ambil_depart['DEPART_NAME'],
                        $rowDtProject[$i]['DT_PRS_ITEM'],
                        'Rp.'.number_format($rowDtProject[$i]['DT_PRS_TOTAL']),
                        '#',
                        empty($rowRealProject[$i]['PRR_NOTE']) ? '' : $rowRealProject[$i]['PRR_NOTE'] ,
                        empty($rowRealProject[$i]['PRR_VALUE']) ? '' : 'Rp. '.number_format($rowRealProject[$i]['PRR_VALUE']) ,
                        )
                    );
        }
        $pdfx->Cell(71,6,'','BTL',0);
        $pdfx->Cell(15,6,'Total :','BTR',0);
        $pdfx->Cell(30,6,'Rp.'.number_format($projectTotal),1,0);
        $pdfx->Cell(6,6,'#','BTR',0);
        $pdfx->Cell(28,6,'','BTL',0);
        $pdfx->Cell(15,6,'Total :','BTR',0);
        $pdfx->Cell(30,6,'Rp. '.number_format($projectPaidTotal),1,1);
        $pdfx->Cell(191,2,'',0,1);
        $pdfx->isFinished = true;
        $pdfx->Output();
	}
}