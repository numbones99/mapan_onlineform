<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class Cron extends CI_Controller {
	
	public function index(){
		//ambil tanggal saat ini
		$Ymdhis = date('Y-m-d H:i:s');
		$ymd = date('Y-m-d');
		//ambil data semua teknisi
		// $arr_emp = array(
		// 	'me.LEAD_STATUS' => '2',
		// 	'me.EMP_STATUS' => '1',
		// 	'mb.BRANCH_ID' => 'BR/0009'
		// );
		// $dataemp = $this->Model_online->findAllDataWhere($arr_emp,'m_employee');
		$sqlall = "select me.*
		from m_employee me 
		join m_department md on me.DEPART_ID = md.DEPART_ID 
		join m_branch mb on md.BRANCH_ID = mb.BRANCH_ID 
		where mb.BRANCH_ID = 'BR/0009' and me.EMP_STATUS = '1' and me.LEAD_STATUS = '2'";
		$dataemp = $this->db->query($sqlall)->result_array();
		//cek apakah ada jadwal hari ini, atau jadwal kemarin yg belum selesai
		$i=0;
		foreach($dataemp as $dataemp) :
			$sql = "select tr.RP_ID , me.EMP_FULL_NAME,mb.BRANCH_NAME, tr.RP_STR_DATE
			from tr_repair_sch trs 
			join tr_repair tr on tr.RP_ID = trs.RP_ID 
			join m_employee me on tr.EMP_ID = me.EMP_ID
			join m_department md on me.DEPART_ID = md.DEPART_ID 
			join m_branch mb on md.BRANCH_ID = mb.BRANCH_ID 
			where trs.EMP_ID = '".$dataemp['EMP_ID']."' and date(tr.RP_STR_DATE) <= '".$Ymdhis."' and tr.RP_STAT = '3'
			group by tr.RP_ID";
			$hitung = $this->db->query($sql)->num_rows();
			if($hitung>0){
				$data['jadwal'] = $this->db->query($sql)->result_array();
				$data['emp'] = $dataemp;
				$to = $dataemp['EMP_EMAIL'];
				$subject = 'Penjadwalan Hari Ini - '.$ymd.' - '.$dataemp['EMP_FULL_NAME'];
				$message = $this->load->view('aset/emailpagi', $data,true);
				//aksi input update email
				$this->Model_online->insEmail($to,$subject,$message);
			}
		endforeach;
	}
}