<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class Laporanoutletdone extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->library('PDFOUTLETDONE');
        
    }
    
	public function index()
	{
        //ambil data outlet
        $outletId = $this->input->post("outletId");
        $arr_branch = array(
            'BRANCH_ID' => $outletId,
        );
        $rowBranch = $this->Model_online->findSingleDataWhere($arr_branch,'m_branch');
        // ambil data leadernya
        $arr_depart = array(
            'BRANCH_ID' => $outletId,
        );
        $rowDepart = $this->Model_online->findSingleDataWhere($arr_depart,'m_department');
        $arr_leader = array(
            'DEPART_ID' => $rowDepart['DEPART_ID'],
        );
        $rowLeader = $this->Model_online->findSingleDataWhere($arr_leader,'m_employee');
        //ambil data semua proyek yg ada dan aktif
        $arr_project = array(
			'BRANCH_ID' => $outletId,
            'PR_STATUS' => '3'
		);
        $rowProject = $this->Model_online->findAllDataWhere($arr_project,'tr_project');
        $sqlallother = "select sum(PR_TOTAL) as TOTAL_AJU, 
        sum(PR_PAID_TOTAL) as TOTAL_BAYAR  
        from tr_project
		where BRANCH_ID = '".$outletId."'
		and PR_STATUS = '3'";
		$allpay = $this->db->query($sqlallother)->row_array();
        global $branchId;
        global $branchCode;
        global $branchName;
        global $leaderName;
        global $allTotal;
        global $allPaidTotal;

        $branchId = $rowBranch['BRANCH_ID'];
        $branchCode = $rowBranch['BRANCH_CODE'];
        $branchName = $rowBranch['BRANCH_NAME'];
        $leaderName = $rowLeader['EMP_FULL_NAME'];
        $allTotal = $allpay['TOTAL_AJU'];
        $allPaidTotal = $allpay['TOTAL_BAYAR'];
        
        
        //inisiasi
        $pdfx = new PDFOUTLETDONE('P','mm','legal');
        $pdfx->isFinished = false;
        $pdfx->SetAutoPageBreak(true, 30);
        // membuat halaman baru
        $pdfx->AddPage();
        $pdfx->SetFont('Arial','',10);
        $x = 1;
        $winner = '';
        foreach($rowProject as $rowProject){
            $pdfx->SetWidths(array(6,60,35,58,35));
            $pdfx->SetAligns(array('C','L','R','L','R'));
            $pdfx->Row(array(
                        $x++,
                        $rowProject['PR_NAME'],
                        number_format($rowProject['PR_TOTAL']),
                        'Pengeluaran Proyek',
                        number_format($rowProject['PR_PAID_TOTAL']),
                        )
                    );
            //ambil data semua detail proyek
            $arr_dt = array(
                'PR_ID' => $rowProject['PR_ID'],
            );
            $dtProject = $this->Model_online->findAllDataWhere($arr_dt,'tr_detail_project_sub');
            $dtReal = $this->Model_online->findAllDataWhere($arr_dt,'tr_project_real');
            $ctDtProject = count($dtProject);
            $ctDtReal = count($dtReal);
            $winner = '';
            if($ctDtProject > $ctDtReal){
                $winner = $ctDtProject;
            }elseif($ctDtProject < $ctDtReal){
                $winner = $ctDtReal;
            }else{
                $winner = $ctDtProject;
            }
            $w = 1;
            
            // $str = "&rarr";
            // $str = utf8_decode($str);
            // $str = html_entity_decode($str);
            // $huha =  iconv('UTF-8', 'windows-1252',$str);
            // // $huha = iconv('UTF-8', 'windows-1252', html_entity_decode("&rarr;"));
            // // $huha = html_entity_decode("&#169;", ENT_XHTML,"ISO-8859-1");
            for($o = 0; $o<$winner;$o++){
                $pdfx->SetWidths(array(6,6,54,35,58,35));
                $pdfx->SetAligns(array('C','C','L','R','L','R'));
                $pdfx->Row(array(
                    chr(187),
                    $w++,
                    $dtProject[$o]['DT_PRS_ITEM'],
                    number_format($dtProject[$o]['DT_PRS_TOTAL']),
                    empty($dtReal[$o]['PRR_NOTE']) ? '' : $dtReal[$o]['PRR_NOTE'],
                    empty($dtReal[$o]['PRR_VALUE']) ? '' : number_format($dtReal[$o]['PRR_VALUE']),
                    )
                );
            }
        }
        $pdfx->Cell(51,6,'','BTL',0);
        $pdfx->Cell(15,6,'Total :','BTR',0);
        $pdfx->Cell(35,6,'Rp.'.number_format($allpay['TOTAL_AJU']),1,0,'R');
        $pdfx->Cell(43,6,'','BT',0);
        // $pdfx->Cell(37,6,'#','BT',0);
        // $pdfx->Cell(20,8 ,'','','','',false, "http://www.intranet.com/mb/rprh06/"); 
        $pdfx->Cell(15,6,'Total :','BTR',0);
        $pdfx->Cell(35,6,'Rp. '.number_format($allpay['TOTAL_BAYAR']),1,1,'R');
        $pdfx->Cell(191,2,'',0,1);
        $pdfx->isFinished = true;
        $pdfx->Output();
	}
   
}