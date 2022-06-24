<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");

class Aset_it extends CI_Controller {

	function __construct(){
		parent::__construct();
		if($this->session->userdata('STATUSLOGIN') != "LOGIN"){
			redirect(base_url("Login"));
		}
    }
    
    //=====================================
    //bagian halaman/tampilan pertama
    public function index()
	{
		if($this->session->userdata('LEAD_STATUS')=='2'){
			redirect(base_url().'Aset/jadwal');	
		}
        $empID = $this->session->userdata('EMP_ID');
		$wherenol = array(
			'EMP_ID' => $this->session->userdata('EMP_ID'),
			'RP_STAT' => '0',
		);
		$whereada = array(
			'EMP_ID' => $this->session->userdata('EMP_ID'),
			'RP_STAT !=' => '0',
		);
		$where = array(
			'EMP_ID' => $this->session->userdata('EMP_ID'),
		);
		$data['repairs'] = $this->Model_online->findAllDataWhere($wherenol,'tr_repair');
		$data['repairsada'] = $this->Model_online->findAllDataWhere($whereada,'tr_repair');
		$data['rp'] = $this->Model_online->findSingleDataWhere($where,'tr_repair');
		$this->load->view('templates/head');
		$this->load->view('templates/sidenav');
		$this->load->view('aset/dashboard',$data);
		$this->load->view('templates/footer');
    }
    public function detail($RP_ID){		
		$empID = $this->session->userdata('EMP_ID');
        // ambil data
        $newID1 = substr($RP_ID,0,2);
        $newID2 = substr($RP_ID,2,6);
        $newID3 = substr($RP_ID,8,4);
        $newRP_ID = $newID1.'/' .$newID2.'/'.$newID3;
		$where = array(
			'RP_ID' => $newRP_ID,
            );
		// cari department/branch berdasarkan department user yg login
		$wherebr = array(
			'DEPART_ID' => $this->session->userdata('DEPART_ID'),
		);
		$caribr = $this->Model_online->findSingleDataWhere($wherebr,'m_department');
		// cari ruang berdasarkan department/branch yg telah dicari 		
		$whererg = array(
			'BRANCH_ID' => $caribr['BRANCH_ID'],
		);
        $data['repair'] = $this->Model_online->findSingleDataWhere($where,'tr_repair');
		$data['ruang']= $this->Model_online->findAllDataWhere($whererg,'m_ruang');
		$data['ruangan']= $this->Model_online->findAllDataWhereObj($whererg,'m_ruang');
		$data['dtrepair']= $this->Model_online->findAllDataWhere($where,'tr_detail_repair');
		$data['dtrepair2']= $this->Model_online->findAllDataWhere($where,'tr_detail_repair');
		$this->load->view('templates/head');
		$this->load->view('templates/sidenav');
		$this->load->view('aset/detrepair',$data);
		$this->load->view('templates/footer');
    }
	public function jadwal(){		
        $jadwal = date('ymd');
		$new_date = date('Y-m-d', strtotime($jadwal));
		$empID = $this->session->userdata('EMP_ID');
		$sql = "select trs.*, me.EMP_FULL_NAME, mb.BRANCH_NAME, tr.RP_STR_DATE, tr.RP_END_DATE,tr.RP_ID
		from tr_repair_sch trs 
		join tr_repair tr on tr.RP_ID = trs.RP_ID 
		join m_employee me on tr.EMP_ID = me.EMP_ID
		join m_department md on me.DEPART_ID = md.DEPART_ID 
		join m_branch mb on md.BRANCH_ID = mb.BRANCH_ID 
		where trs.EMP_ID = '".$empID."' and tr.RP_STAT = '3'";
		$sqlall = "select trs.*, me.EMP_FULL_NAME,mb.BRANCH_NAME, tr.RP_STR_DATE, tr.RP_END_DATE, tr.RP_ID
		from tr_repair_sch trs 
		join tr_repair tr on tr.RP_ID = trs.RP_ID 
		join m_employee me on tr.EMP_ID = me.EMP_ID
		join m_department md on me.DEPART_ID = md.DEPART_ID 
		join m_branch mb on md.BRANCH_ID = mb.BRANCH_ID 
		where tr.RP_STAT = '3'";
        $data['jadwal'] = $this->db->query($sql)->result_array();
		$data['jadwalall'] = $this->db->query($sqlall)->result_array();
		$this->load->view('templates/head');
		$this->load->view('templates/sidenav');
		$this->load->view('aset/jadwal',$data);
		$this->load->view('templates/footer');
    }
	function get_asset(){
        $ruang_id = $this->input->post('id',TRUE);
		// $where = array (
		// 	'RUANG_ID' => $ruang_id,
		// );
		$sql = "select m.* 
		from m_asset m, m_category c
		where m.RUANG_ID = '".$ruang_id."'
		and m.CAT_ID = c.CAT_ID and c.CAT_PART = 'GENERAL' ";
        $data = $this->db->query($sql)->result_array();
        //$data = $this->Model_online->findAllDataWhere($where,'m_asset');
        echo json_encode($data);
    }
	function get_jadwal(){
        $jadwal = $this->input->post('tanggal',TRUE);
		$new_date = date('Y-m-d', strtotime($jadwal));
		$empID = $this->session->userdata('EMP_ID');
		$sql = "select tr.RP_ID , me.EMP_FULL_NAME,mb.BRANCH_NAME
		from tr_repair_sch trs 
		join tr_repair tr on tr.RP_ID = trs.RP_ID 
		join m_employee me on tr.EMP_ID = me.EMP_ID
		join m_department md on me.DEPART_ID = md.DEPART_ID 
		join m_branch mb on md.BRANCH_ID = mb.BRANCH_ID 
		where trs.EMP_ID = '".$empID."' and date(tr.RP_STR_DATE) <= '$new_date' and tr.RP_STAT = '3'
		group by tr.RP_ID";
        $data = $this->db->query($sql)->result_array();
        //$data = $this->Model_online->findAllDataWhere($where,'m_asset');
        echo json_encode($data);
    }
	function get_jadwal_all(){
        $jadwal = $this->input->post('tanggal',TRUE);
		$new_date = date('Y-m-d', strtotime($jadwal));
		$sql = "select tr.RP_ID , me.EMP_FULL_NAME,mb.BRANCH_NAME
		from tr_repair_sch trs 
		join tr_repair tr on tr.RP_ID = trs.RP_ID 
		join m_employee me on tr.EMP_ID = me.EMP_ID
		join m_department md on me.DEPART_ID = md.DEPART_ID 
		join m_branch mb on md.BRANCH_ID = mb.BRANCH_ID 
		where date(tr.RP_STR_DATE) <= '$new_date' and tr.RP_STAT = '3'
		group by tr.RP_ID";
        $data = $this->db->query($sql)->result_array();
        //$data = $this->Model_online->findAllDataWhere($where,'m_asset');
        echo json_encode($data);
    }
	function get_emp(){
        $visit = $this->input->post('rangetgl',TRUE);
		$str = substr($visit,0,16);
		$end = substr($visit,19,17);
		$sql = "select me.* 
		from m_employee me
		where me.DEPART_ID = 'DP/006'
		and me.EMP_STATUS = '1'";
        $data = $this->db->query($sql)->result_array();
        echo json_encode($data);
    }
	public function history($RP_ID){		
		$empID = $this->session->userdata('EMP_ID');
        // ambil data
        $newID1 = substr($RP_ID,0,2);
        $newID2 = substr($RP_ID,2,6);
        $newID3 = substr($RP_ID,8,4);
        $newRP_ID = $newID1.'/' .$newID2.'/'.$newID3;
		$where = array(
			'RP_ID' => $newRP_ID,
            );
		// cari department/branch berdasarkan department user yg login
		$wherebr = array(
			'DEPART_ID' => $this->session->userdata('DEPART_ID'),
		);
		$caribr = $this->Model_online->findSingleDataWhere($wherebr,'m_department');
		// cari ruang berdasarkan department/branch yg telah dicari 		
		$whererg = array(
			'BRANCH_ID' => $caribr['BRANCH_ID'],
		);
        $data['repair'] = $this->Model_online->findSingleDataWhere($where,'tr_repair');
		$data['ruang']= $this->Model_online->findAllDataWhere($whererg,'m_ruang');
		$data['dtrepair']= $this->Model_online->findAllDataWhere($where,'tr_detail_repair');
		$data['dtrepair2']= $this->Model_online->findAllDataWhere($where,'tr_detail_repair');
		$this->load->view('templates/head');
		$this->load->view('templates/sidenav');
		$this->load->view('aset/historyrepair',$data);
		$this->load->view('templates/footer');
    }
	public function approval(){
		$empID = $this->session->userdata('EMP_ID');
		$select = array(
			'tar.APP_RP_ID', 
			'tr.RP_SUB_DATE', 
			'tr.RP_ID', 
			'me.EMP_FULL_NAME',
			'me.EMP_ID', 
			'md.DEPART_NAME', 
			'mb.BRANCH_NAME',
			'tr.RP_STAT', 
		);
		$where = array(
		 	'tr.RP_STAT' => '1',
			'tar.EMP_ID' => $empID,
		);
		$groupby = 'tar.APP_RP_ID';
		$whereAcc = array(
		 	'tr.RP_STAT !=' => '1',
			'tar.EMP_ID' => $empID,
		);
		$data['app'] = $this->Model_online->dataApprovalRP($select,$where,'tr_repair tr',$groupby);
		$data['appAcc'] = $this->Model_online->dataApprovalRP($select,$whereAcc,'tr_repair tr',$groupby);
		$wheredir = array(
			'RP_STAT !=' => '1'
		);
		$data['direksi'] = $this->Model_online->findAllDataWhere($wheredir,'tr_repair');
		$this->load->view('templates/head');
		$this->load->view('templates/sidenav');
		$this->load->view('aset/apprepair',$data);
		$this->load->view('templates/footer');
    }
	public function dtapp($id){	
		$empID = $this->session->userdata('EMP_ID');
		//cari id approval kasbon
		$newID1 = substr($id,0,3);
        $newID2 = substr($id,3,6);
        $newID3 = substr($id,9,4);
		$newnew = $newID1.'/' .$newID2.'/'.$newID3;
		$where = array(
			'APP_RP_ID' =>$newnew
		);
		$cari = $this->Model_online->findSingleDataWhere($where,'tr_app_repair');
		//ambil data detail approval dari id approval kasbon
		$whereCari = array(
			'RP_ID' => $cari['RP_ID']
		);
		$data['det'] = $this->Model_online->findAllDataWhere($whereCari,'tr_detail_repair');
		// ambil data kasbon dan nama pengaju single
		$selectx = array(
			'tr.*', 
			'me.EMP_FULL_NAME as nama',
			'me.DEPART_ID',
		);
		$wherex = array(
			'tr.RP_ID' => $cari['RP_ID']
		);
		$data['nama'] = $this->Model_online->singleNama($selectx,'tr_repair tr',$wherex);
		$repair = $this->Model_online->singleNama($selectx,'tr_repair tr',$wherex);
		$end = $repair['RP_END_DATE'];
		$str = $repair['RP_STR_DATE'];
		$sql = "select me.* 
		from m_employee me
		where me.DEPART_ID = 'DP/006'
		and me.EMP_STATUS='1' and me.LEAD_STATUS = '2'
		UNION 
		select me.* 
		from m_employee me
		where me.DEPART_ID = 'DP/002'
		and me.EMP_ID ='EMP/002/001'";
        $data['daftar'] = $this->db->query($sql)->result_array();
		
		$this->load->view('templates/head');
		$this->load->view('templates/sidenav');
		$this->load->view('aset/detapprepair',$data);
		$this->load->view('templates/footer'); 
	}
	public function dtjadwal($id){	
		$empID = $this->session->userdata('EMP_ID');
		//cari id approval kasbon
		$newID1 = substr($id,0,2);
        $newID2 = substr($id,2,6);
        $newID3 = substr($id,8,4);
		$newnew = $newID1.'/' .$newID2.'/'.$newID3;
		
		//ambil data detail approval dari id approval kasbon
		$whereCari = array(
			'RP_ID' => $newnew
		);
		$data['det'] = $this->Model_online->findAllDataWhere($whereCari,'tr_detail_repair');
		// ambil data kasbon dan nama pengaju single
		$selectx = array(
			'tr.*', 
			'me.EMP_FULL_NAME as nama',
			'me.DEPART_ID',
		);
		$wherex = array(
			'tr.RP_ID' => $newnew
		);
		$data['nama'] = $this->Model_online->singleNama($selectx,'tr_repair tr',$wherex);
		$repair = $this->Model_online->singleNama($selectx,'tr_repair tr',$wherex);
		$end = $repair['RP_END_DATE'];
		$str = $repair['RP_STR_DATE'];
		$sql = "select me.* 
		from m_employee me
		where me.DEPART_ID = 'DP/006'
		and me.EMP_STATUS='1'";
        $data['daftar'] = $this->db->query($sql)->result_array();
		
		$this->load->view('templates/head');
		$this->load->view('templates/sidenav');
		$this->load->view('aset/dtjadwal',$data);
		$this->load->view('templates/footer'); 
	}
	// end bagian tampilan
    //=====================================

	//=====================================
    // bagian repair
	public function insReq()
	{
		$Ym = date('ymd');
		$Ymdhis = date('Y-m-d H:i:s');
		$generateid = $this->Model_online->kode('RP/' . $Ym . '/', 14,'tr_repair','RP_ID');
		$EMP_ID = $this->session->userdata('EMP_ID');
		$data = array(
			"RP_ID" => $generateid,
			"EMP_ID" => $EMP_ID,
			"RP_STAT" => '0',
			);
		$this->Model_online->input($data,"tr_repair");
        redirect(base_url().'Aset/detail/'.str_replace('/','',$generateid));
	}
	public function delReq(){
		$RP_ID = $this->input->post("delID");
		$this->Model_online->deleteData('tr_repair','RP_ID',$RP_ID);
		redirect(base_url().'Aset');
    }
	// end bagian repair
    //=====================================

	//=====================================
    // bagian detail repair
	public function insDet()
	{
		$Ym = date('ymd');
		$Ymdhis = date('Y-m-d H:i:s');
		$generateid = $this->Model_online->kode('DRP/' . $Ym . '/', 15,'tr_detail_repair','DET_RP_ID');
		$RP_ID = $this->input->post("insID");
		$ASSET_CODE = $this->input->post("insAsset");
		$REASON = $this->input->post("insReason");
		$DET_RP_PHOTO = str_replace('/','',$generateid).".jpg";
		// atur config untuk upload
		$config['upload_path']          = './assets/doc-repair/';
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		$config['max_size']             = 8048;
		$config['file_name']            = str_replace('/','',$generateid).'.jpg';
		$this->load->library('upload', $config);
		$data = array(
			"DET_RP_ID" => $generateid,
			"RP_ID" => $RP_ID,
			"ASSET_CODE" => $ASSET_CODE,
			"DET_RP_REASON" => $REASON,
			"DET_RP_PHOTO" => $DET_RP_PHOTO,
			);
		$this->Model_online->input($data,"tr_detail_repair");
		
		if($this->upload->do_upload('insFoto')){
			$dataUpload = $this->upload->data();
			$this->image_lib->initialize(array(
				'image_library' => 'gd2', //library yang kita gunakan
				'source_image' => './assets/doc-repair/'. $dataUpload['file_name'],
				'maintain_ratio' => TRUE,
				'create_thumb' => FALSE,
				'width' => 900,
				'height' => 900,
				'new_image' => './assets/doc-repair/'. $dataUpload['file_name'],
			));
			$this->image_lib->resize();
		}
        redirect(base_url().'Aset/detail/'.str_replace('/','',$RP_ID));
	}
	public function delDet(){
		
		$DET_RP_ID = $this->input->post("delID");
		$RP_ID = $this->input->post("delIDrp");
		$this->Model_online->deleteData('tr_detail_repair','DET_RP_ID',$DET_RP_ID);
		$path = "./assets/doc-repair/".str_replace('/','',$DET_RP_ID).".jpg";
		unlink($path);
		redirect(base_url().'Aset/detail/'.str_replace('/','',$RP_ID));
    }
	public function upDet()
	{
		$DET_RP_ID = $this->input->post("upIDDet");
		$RP_ID = $this->input->post("upID");
		$ASSET_CODE = $this->input->post("upAsset");
		$DET_RP_REASON = $this->input->post("upReason");
		$DET_RP_PHOTO = str_replace('/','',$DET_RP_ID).".jpg";
		// atur config untuk upload
		$config['upload_path']          = './assets/doc-repair/';
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		$config['max_size']             = 8048;
		$config['file_name']            = str_replace('/','',$DET_RP_ID).'.jpg';
		$this->load->library('upload', $config);
		if($_FILES['upFoto']['name'] <> ""){
			$path = "./assets/doc-repair/".str_replace('/','',$DET_RP_ID).".jpg";
			unlink($path);
			$data = array(
				"ASSET_CODE" => $ASSET_CODE,
				"DET_RP_REASON" => $DET_RP_REASON,
				"DET_RP_PHOTO" => $DET_RP_PHOTO 
				);
			$where = array(
				'DET_RP_ID' => $DET_RP_ID
			);
			if($this->upload->do_upload('upFoto')){
				$dataUpload = $this->upload->data();
				$this->image_lib->initialize(array(
					'image_library' => 'gd2', //library yang kita gunakan
					'source_image' => './assets/doc-repair/'. $dataUpload['file_name'],
					'maintain_ratio' => TRUE,
					'create_thumb' => FALSE,
					'width' => 900,
					'height' => 900,
					'new_image' => './assets/doc-repair/'. $dataUpload['file_name'],
				));
				$this->image_lib->resize();
			}
			$this->Model_online->update($where,$data,"tr_detail_repair");
			clearstatcache();
			redirect(base_url().'Aset/detail/'.str_replace('/','',$RP_ID));
		}else{
			$data = array(
				"ASSET_CODE" => $ASSET_CODE,
				"DET_RP_REASON" => $DET_RP_REASON,
				"DET_RP_PHOTO" => $DET_RP_PHOTO,
				);
			$where = array(
				'DET_RP_ID' => $DET_RP_ID
			);
			$this->Model_online->update($where,$data,"tr_detail_repair");
			clearstatcache();
			redirect(base_url().'Aset/detail/'.str_replace('/','',$RP_ID));
		}

    }
	// end bagian detail repair
    //=====================================

	//=====================================
    // bagian ajukan approval repair
	public function insApp()
    {
        $Ym = date('ymd');
        $Ymdhis = date('Y-m-d H:i:s');
        $generateid = $this->Model_online->kode('ARP/' . $Ym . '/', 15,'tr_app_repair','APP_RP_ID');
        $RP_ID = $this->input->post("rpid");
        // mengambil id session saat ini yg sedang login
        $EMP_ID = $this->session->userdata('EMP_ID');
        $LEADER_ID = 'EMP/006/006';
        // cari email leadernya
        $row2 = $this->db->where('EMP_ID',$LEADER_ID)->get('m_employee')->row_array();
        $leaderEmail = $row2['EMP_EMAIL'];
        // pengecekan doble untuk id_app dan leader yg sama, di insert app
        $wAppLeader = array(
            'RP_ID' => $RP_ID,
            'EMP_ID' => 'EMP/006/006',
        );
        $countAppLeader = $this->Model_online->countRowWhere('tr_app_repair',$wAppLeader);
        if($countAppLeader<=0){
            // masukkan ke dalam tabel tr_app_repair
            $datax = array(
                "APP_RP_ID" => $generateid,
                "RP_ID" => $RP_ID,
                "EMP_ID" => 'EMP/006/006',
                "APP_RP_STAT" => '0',
                "APP_RP_SUB" => $Ymdhis,
                );	
            // update tanggal submit di tr_repair jika pertama kali ajukan approval
            $dataKB = array(
				"RP_SUB_DATE" => $Ymdhis,
				"RP_STAT" => '1'
                );
            $whereKB = array(
                'RP_ID' => $RP_ID
            );
			$this->Model_online->update($whereKB,$dataKB,"tr_repair");
			$this->Model_online->input($datax,"tr_app_repair");
			// BAGIAN EMAIL
			//  ============================================================== set value untuk email
				//pembuatan bagian isi email
				//ambil 1 row data repair
				$whereDataRP = array(
					'RP_ID' => $RP_ID,
				);
				$rowRP = $this->Model_online->findSingleDataWhere($whereDataRP,'tr_repair');
				//ambil 1 row nama employee
				$whereEmp = array(
					'EMP_ID' => $rowRP['EMP_ID'],
				);
				$rowEmp = $this->Model_online->findSingleDataWhere($whereEmp,'m_employee');
				//ambil nama depart dari EMP_ID
				$whereDep = array(
				'DEPART_ID' => $rowEmp['DEPART_ID'],
				);
				$rowDep = $this->Model_online->findSingleDataWhere($whereDep,'m_department');
				//ambil semua row detail repair
				$whereDet = array(
					'RP_ID' => $RP_ID,
				);
				$data['rowDet'] = $this->Model_online->findAllDataWhere($whereDet,'tr_detail_repair');
				//penamaan variable
				$to = $leaderEmail;
				$subject = 'Approval Repair | '.$rowDep['DEPART_NAME'].' - '.$rowEmp['EMP_FULL_NAME'].' - '.$RP_ID; 
				$data['nama'] = $rowEmp['EMP_FULL_NAME'];
				$data['leader'] = $row2;
				$data['rowRP'] = $rowRP;
				$message = $this->load->view('aset/emailawal', $data,true);
				//aksi input update email
				$this->Model_online->insEmail($to,$subject,$message);
            redirect(base_url().'Aset');
        }
        

    }
	// end bagian ajukan approval permintaan
    //=====================================
	
	//=====================================
    // bagian accept approval
	
	public function accApp()
    {
        // yang lama kalau jadwal tidak minimal besok dan jam 6 pagi
		// $str = substr($visit,0,16);
		// $end = substr($visit,19,17);
		
		$visit = $this->input->post("insTgl");
		$str = substr($visit,0,10).' 06:00';
		// $str = '2021/03/07';
		$end = substr($visit,13,10).' 22:00';
		$now = date('Y/m/d');
		$RP_ID = $this->input->post("repairid");
		$where = array(
			'RP_ID' => $RP_ID
		);
		$data = array(
			"RP_STR_DATE" => $str,
			"RP_END_DATE" => $end,
			);
		$app = $this->Model_online->findSingleDataWhere($where,'tr_app_repair');
		$appID = $app['APP_RP_ID'];
		if($str<$now){
			echo "kurang";
			$this->session->set_flashdata("flashdata","Minimal Penjadwalan Harus Hari Ini, ".$now."");
			redirect(base_url().'Aset/dtapp/'.str_replace('/','',$appID));
		}else{
			echo "masih lolos";
			$this->Model_online->update($where,$data,"tr_repair");
			clearstatcache();
			redirect(base_url().'Aset/dtapp/'.str_replace('/','',$appID));
		}
    }
	public function accAppFinal()
    {
		$Ymdhis = date('Y-m-d H:i:s');
		$RP_ID = $this->input->post("repairid");
		$where = array(
			'RP_ID' => $RP_ID
		);
        $data = array(
            "RP_STAT" => '3',
			"RP_APP_DATE" => $Ymdhis,
		);
		$dataapp = array(
            "APP_RP_ACC" => $Ymdhis,
			"APP_RP_STAT" => '1',
		);
		$app = $this->Model_online->findSingleDataWhere($where,'tr_app_repair');
		$appID = $app['APP_RP_ID'];
        $this->Model_online->update($where,$data,"tr_repair");
		$this->Model_online->update($where,$dataapp,"tr_app_repair");   
		// email pekerja
		// BAGIAN EMAIL
		//  ============================================================== set value untuk email
		//pembuatan bagian isi email
		//ambil 1 row data repair yg diajukan
		$whereDataRP = array(
			'RP_ID' => $RP_ID,
		);
		$rowRP = $this->Model_online->findSingleDataWhere($whereDataRP,'tr_repair');
		//ambil 1 row nama employee pengaju
		$whereEmp = array(
			'EMP_ID' => $rowRP['EMP_ID'],
		);
		$rowEmp = $this->Model_online->findSingleDataWhere($whereEmp,'m_employee');
		//ambil nama depart dari EMP_ID pengaju
		$whereDep = array(
		'DEPART_ID' => $rowEmp['DEPART_ID'],
		);
		$rowDep = $this->Model_online->findSingleDataWhere($whereDep,'m_department');
		//ambil nama branch dari depart pengaju
		$wherebr = array(
		'BRANCH_ID' => $rowDep['BRANCH_ID'],
		);
		$rowbr = $this->Model_online->findSingleDataWhere($wherebr,'m_branch');
		//ambil semua row detail repair yg diajukan
		$whereDet = array(
			'RP_ID' => $RP_ID,
		);
		$data['rowDet'] = $this->Model_online->findAllDataWhere($whereDet,'tr_detail_repair');
		$jadwal = $this->Model_online->findAllDataWhere($whereDet,'tr_repair_sch');
		$allemail= '';
		foreach($jadwal as $jadwal):
			$arr_email=array(
				'EMP_ID' => $jadwal['EMP_ID'],
			);
			$kary = $this->Model_online->findSingleDataWhere($arr_email,'m_employee');
			$em = $kary['EMP_EMAIL'];
			$allemail .= ''.$em.',';
		endforeach;
		$allemail .= ''.($rowbr['BRANCH_EMAIL']!=NULL) ? $rowbr['BRANCH_EMAIL'] : $rowEmp['EMP_EMAIL'].'';
		$separo = substr($allemail,0,-1);
		$to = "'".$allemail."'";
		//var_dump($to);
		$subject = 'Penjadwalan Perbaikan Aset | '.$rowDep['DEPART_NAME'].' - '.$rowEmp['EMP_FULL_NAME'].' - '.$RP_ID; 
		$data['nama'] = $rowEmp['EMP_FULL_NAME'];
		$data['rowRP'] = $rowRP;
		$message = $this->load->view('aset/emailpekerja', $data,true);
		//aksi input update email
		$this->Model_online->insEmail($allemail,$subject,$message);
		redirect(base_url().'Aset/approval/');
    }
	public function accDeny()
    {
		$Ymdhis = date('Y-m-d H:i:s');
		$RP_ID = $this->input->post("repairid");
		$where = array(
			'RP_ID' => $RP_ID
		);
        $data = array(
            "RP_STAT" => '2',
			"RP_APP_DATE" => $Ymdhis,
		);
		$dataapp = array(
            "APP_RP_ACC" => $Ymdhis,
			"APP_RP_STAT" => '2',
		);
		$app = $this->Model_online->findSingleDataWhere($where,'tr_app_repair');
		$appID = $app['APP_RP_ID'];
        $this->Model_online->update($where,$data,"tr_repair");
		$this->Model_online->update($where,$dataapp,"tr_app_repair");   
        redirect(base_url().'Aset/approval/');
    }
	// end bagian ajukan approval permintaan
    //=====================================
	
	//=====================================
	// bagian ins jadwal
	public function insEmp(){
		$emp = $this->input->post('insEmp',TRUE);
		$RP_ID = $this->input->post('repairid',TRUE);
		$Ym = date('ymd');
		$generateid = $this->Model_online->kode('RPS/' . $Ym . '/', 15,'tr_repair_sch','RP_SCH_ID');
		$where = array(
			'RP_ID' => $RP_ID
		);
		$repair = $this->Model_online->findSingleDataWhere($where,'tr_repair');
		$app = $this->Model_online->findSingleDataWhere($where,'tr_app_repair');
		$appID = $app['APP_RP_ID'];
		$data = array(
			"RP_SCH_ID" => $generateid,
			"RP_ID" => $RP_ID,
			"EMP_ID" => $emp,
			"RP_SCH_START" => $repair['RP_STR_DATE'],
			"RP_SCH_END" => $repair['RP_END_DATE'],
			);
		$this->Model_online->input($data,"tr_repair_sch");
		redirect(base_url().'Aset/dtapp/'.str_replace('/','',$appID));
	}
	
	public function insReview(){
		$emp = $this->input->post('star',TRUE);
		if($this->input->post('star',TRUE)==''){
			$emp = 0;
		}
		$RP_ID = $this->input->post('repairid',TRUE);
		$komentar = $this->input->post('insReason',TRUE);
		$arrival = $this->input->post('insArrival',TRUE);
		$finish = $this->input->post('insFinish',TRUE);
		$new_arr = date('Y-m-d H:i:s', strtotime($arrival));
		$new_fn = date('Y-m-d H:i:s', strtotime($finish));
		$where = array(
			'RP_ID' => $RP_ID
		);
		$data = array(
			"RP_RATE" => $emp,
			"RP_RATE_COMMENT" => $komentar,
			"RP_STAT" => '5',
			"RP_ARRIVAL" => $new_arr,
			"RP_FINISH" => $new_fn,
		);
		$dataapp = array(
			"RP_SCH_RATE" => $emp,
		);
		$this->Model_online->update($where,$data,"tr_repair");
		$this->Model_online->update($where,$dataapp,"tr_repair_sch");
		// email pekerja
		// BAGIAN EMAIL
		//  ============================================================== set value untuk email
		//pembuatan bagian isi email
		//ambil 1 row data repair yg diajukan
		$whereDataRP = array(
			'RP_ID' => $RP_ID,
		);
		$rowRP = $this->Model_online->findSingleDataWhere($whereDataRP,'tr_repair');
		//ambil 1 row nama employee pengaju
		$whereEmp = array(
			'EMP_ID' => $rowRP['EMP_ID'],
		);
		$rowEmp = $this->Model_online->findSingleDataWhere($whereEmp,'m_employee');
		//ambil nama depart dari EMP_ID pengaju
		$whereDep = array(
		'DEPART_ID' => $rowEmp['DEPART_ID'],
		);
		$rowDep = $this->Model_online->findSingleDataWhere($whereDep,'m_department');
		//ambil semua row detail repair yg diajukan
		$whereDet = array(
			'RP_ID' => $RP_ID,
		);
		$data['rowDet'] = $this->Model_online->findAllDataWhere($whereDet,'tr_detail_repair');
		$jadwal = $this->Model_online->findAllDataWhere($whereDet,'tr_repair_sch');
		$allemail= '';
		foreach($jadwal as $jadwal):
			$arr_email=array(
				'EMP_ID' => $jadwal['EMP_ID'],
			);
			$kary = $this->Model_online->findSingleDataWhere($arr_email,'m_employee');
			$em = $kary['EMP_EMAIL'];
			$allemail .= ''.$em.',';
		endforeach;
		$separo = substr($allemail,0,-1);
		$to = "'".$separo."'";
		//var_dump($to);
		$subject = 'Review Perbaikan Aset | '.$rowDep['DEPART_NAME'].' - '.$rowEmp['EMP_FULL_NAME'].' - '.$RP_ID; 
		$data['nama'] = $rowEmp['EMP_FULL_NAME'];
		$data['rowRP'] = $rowRP;
		$data['bintang'] = $emp;
		$data['komentar'] = $komentar;
		$message = $this->load->view('aset/emailreview', $data,true);
		//aksi input update email
		$this->Model_online->insEmail($separo,$subject,$message);
		redirect(base_url().'Aset/history/'.str_replace('/','',$RP_ID));
	}
	public function insFoto(){
		// cari data di tabel approval dengan reimburse ID dan employee ID
		$detailid = $this->input->post('detid',TRUE);
		$rpid = $this->input->post('rpid',TRUE);
		$rvphoto = 'RV-'.str_replace('/','',$detailid);
		// atur config untuk upload
		$config['upload_path']          = './assets/doc-repair/';
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		$config['max_size']             = 8048;
		$config['file_name']            = str_replace('/','',$rvphoto).'.jpg';
		$this->load->library('upload', $config);
		if($this->upload->do_upload('upFoto')){
			$dataUpload = $this->upload->data();
			$this->image_lib->initialize(array(
				'image_library' => 'gd2', //library yang kita gunakan
				'source_image' => './assets/doc-repair/'. $dataUpload['file_name'],
				'maintain_ratio' => TRUE,
				'create_thumb' => FALSE,
				'width' => 900,
				'height' => 900,
				'new_image' => './assets/doc-repair/'. $dataUpload['file_name'],
			));
			$this->image_lib->resize();
		}
		$where = array(
			"DET_RP_ID" => $detailid,
		);
		$data = array(
			"DET_RP_REV_PHOTO" => $rvphoto.'.jpg',
		);
		$this->Model_online->update($where,$data,"tr_detail_repair");
		redirect(base_url().'Aset/history/'.str_replace('/','',$rpid));
		
	}
	public function upFoto(){
		// cari data di tabel approval dengan reimburse ID dan employee ID
		$detailid = $this->input->post('detid',TRUE);
		$rpid = $this->input->post('rpid',TRUE);
		$rvphoto = 'RV-'.str_replace('/','',$detailid);
		$path = "./assets/doc-repair/".$rvphoto.".jpg";
		if(unlink($path)){
			// atur config untuk upload
			$config['upload_path']          = './assets/doc-repair/';
			$config['allowed_types']        = 'gif|jpg|png|jpeg';
			$config['max_size']             = 8048;
			$config['file_name']            = str_replace('/','',$rvphoto).'.jpg';
			$this->load->library('upload', $config);
			if($this->upload->do_upload('upFoto')){
				$dataUpload = $this->upload->data();
				$this->image_lib->initialize(array(
					'image_library' => 'gd2', //library yang kita gunakan
					'source_image' => './assets/doc-repair/'. $dataUpload['file_name'],
					'maintain_ratio' => TRUE,
					'create_thumb' => FALSE,
					'width' => 900,
					'height' => 900,
					'new_image' => './assets/doc-repair/'. $dataUpload['file_name'],
				));
				$this->image_lib->resize();
			}
			$where = array(
				"DET_RP_ID" => $detailid,
			);
			$data = array(
				"DET_RP_REV_PHOTO" => $rvphoto.'.jpg',
			);
			$this->Model_online->update($where,$data,"tr_detail_repair");
			clearstatcache();
			redirect(base_url().'Aset/history/'.str_replace('/','',$rpid));
		}
		
		
	}
	public function upReview(){
		// cari data di tabel approval dengan reimburse ID dan employee ID
		$repairId = $this->input->post('repairid',TRUE);
		$whereApp = array(
			"RP_ID" => $repairId,
		);
		$rowRepair = $this->Model_online->findSingleDataWhere($whereApp,'tr_repair');
		if($rowRepair['RP_STAT']>4){
			//dashboard
			$this->session->set_flashdata("app-error","Persetujuan/Penolakan Melalui Email Gagal");
			redirect(base_url().'Aset/history/'.str_replace('/','',$repairId));
		}else{
			//dashboard
			$data = array(
				'RP_STAT' => '5'
			);
			$where = array(
				'RP_ID' => $repairId
			);
			$this->Model_online->update($where,$data,"tr_repair");
			redirect(base_url().'Aset/history/'.str_replace('/','',$repairId));
		}
	}
	public function upnoReview(){
		// cari data di tabel approval dengan reimburse ID dan employee ID
		$repairId = $this->input->post('repairid',TRUE);
		$whereApp = array(
			"RP_ID" => $repairId,
		);
		$rowRepair = $this->Model_online->findSingleDataWhere($whereApp,'tr_repair');
		if($rowRepair['RP_STAT']>4){
			//dashboard
			$this->session->set_flashdata("app-error","Persetujuan/Penolakan Melalui Email Gagal");
			redirect(base_url().'Aset/history/'.str_replace('/','',$repairId));
		}else{
			//dashboard
			$data = array(
				'RP_STAT' => '3'
			);
			$where = array(
				'RP_ID' => $repairId
			);
			$this->Model_online->update($where,$data,"tr_repair");
			redirect(base_url().'Aset/history/'.str_replace('/','',$repairId));
		}
	}
	public function delEmp(){
		$RP_SCH_ID = $this->input->post('delID',TRUE);
		$RP_ID = $this->input->post('repairid',TRUE);
		$where = array(
			'RP_ID' => $RP_ID
		);
		$app = $this->Model_online->findSingleDataWhere($where,'tr_app_repair');
		$appID = $app['APP_RP_ID'];
		$this->Model_online->deleteData('tr_repair_sch','RP_SCH_ID',$RP_SCH_ID);
        redirect(base_url().'Aset/dtapp/'.str_replace('/','',$appID));
	}
	// end ins jadwal
    //=====================================

	//=====================================
	// bagian ins jadwal
	public function cronEmail(){
		//ambil tanggal saat ini
		$Ymdhis = date('Y-m-d H:i:s');
		$ymd = date('Y-m-d');
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
	// end ins jadwal
    //=====================================
}
?>