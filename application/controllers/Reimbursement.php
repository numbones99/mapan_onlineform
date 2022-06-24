<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");

class Reimbursement extends CI_Controller {

	function __construct(){
		parent::__construct();
		if($this->session->userdata('STATUSLOGIN') != "LOGIN"){
			redirect(base_url("Login"));
		}
	}
	
	public function index()
	{
		// untuk ambil reimbursement
		$empID = $this->session->userdata('EMP_ID');
		$where = array(
			'EMP_ID' => $empID,
			'RB_SUBMIT_DATE ' => null,
			);
		$whereAju = array(
			'EMP_ID' => $empID,
			'RB_SUBMIT_DATE !=' => null,
			);	
		$id = 'RB_ID';
		$data['reimburse'] = $this->Model_online->tampilData('tr_reimburse',$where,$id);
		$data['reimburseAju'] = $this->Model_online->tampilData('tr_reimburse',$whereAju,$id);
		$this->load->view('templates/head');
		$this->load->view('templates/sidenav');
		$this->load->view('Reimburse',$data);
		$this->load->view('templates/footer');
	}
	public function Password(){
		$newPass = $this->input->post("newPass");
		$ENnewPass = base64_encode($newPass);
		$data = array(
			'EMP_PASS' => $ENnewPass,
			'EMP_STATUS' => '1'
		);
		$where = array(
			'EMP_ID' => $this->session->userdata('EMP_ID'),
		);
		$this->Model_online->update($where,$data,'m_employee');
		redirect(base_url().'Dashboard');
	}
	public function Approval(){
		$empID = $this->session->userdata('EMP_ID');
		//$data['app']  = $this->Model_online->dataApprovalBaru($empID);
		//$data['appNo']  = $this->Model_online->dataApprovalNolBaru($empID);
		$select = array(
			'ta.TR_APP_ID', 
			'ta.TR_SUB_DATE', 
			'ta.RB_ID', 
			'tr.RB_TOTAL', 
			'md.DEPART_NAME', 
			'me.EMP_FULL_NAME',
		);
		$where = array(
			'ta.EMP_ID' => $empID,
			'ta.TR_APP_STATUS ' => '0',
		);
		$groupby = 'ta.TR_APP_ID';
		$data['app'] = $this->Model_online->dataApproval($select,$where,'tr_approval ta',$groupby);

		$selectNo = array(
			'ta.TR_APP_ID', 
			'ta.TR_SUB_DATE', 
			'ta.RB_ID', 
			'tr.RB_TOTAL', 
			'md.DEPART_NAME',
			'me.EMP_FULL_NAME',
			'me.EMP_ID',
		);
		$whereNo = array(
			'ta.EMP_ID' => $empID,
			'ta.TR_APP_STATUS !=' => '0',
			'ta.TR_APP_STATUS !=' => '2',
		);
		$groupbyNo = 'ta.TR_APP_ID';
		$data['appNo'] = $this->Model_online->dataApproval($selectNo,$whereNo,'tr_approval ta',$groupbyNo);

		$selectFA = array(
			'ta.TR_APP_ID', 
			'ta.TR_SUB_DATE', 
			'ta.RB_ID', 
			'tr.RB_TOTAL', 
			'md.DEPART_NAME',
			'me.EMP_FULL_NAME',
			'me.EMP_ID',
		);
		$whereFA = array(
			'ta.TR_APP_STATUS' => '4',
		);
		$groupbyFA = 'ta.TR_APP_ID';
		$data['appFA'] = $this->Model_online->dataApproval($selectFA,$whereFA,'tr_approval ta',$groupbyFA);

		$this->load->view('templates/head');
		$this->load->view('templates/sidenav');
		$this->load->view('Approval',$data);
		$this->load->view('templates/footer');
	}
	public function DetailApproval($id){
		
		$empID = $this->session->userdata('EMP_ID');
		//cari id approval
		$newID1 = substr($id,0,3);
        $newID2 = substr($id,3,6);
        $newID3 = substr($id,9,4);
		$newnew = $newID1.'/' .$newID2.'/'.$newID3;
		$where = array(
			'TR_APP_ID' =>$newnew
		);
		$cari = $this->Model_online->findSingleDataWhere($where,'tr_approval');
		//ambil data detail reimbusement dari id approval
		
		$idreim = $cari['RB_ID'];
		$whereCari = array(
			'RB_ID' => $idreim
		);
		$data['det'] = $this->Model_online->findAllDataWhere($whereCari,'tr_detail_reimburse');
		// ambil data reimbusement dan nama pengaju single
		$selectx = array(
			'tr.*', 
			'me.EMP_FULL_NAME as nama'
		);
		$wherex = array(
			'tr.RB_ID' => $idreim
		);
		$data['reimNama'] = $this->Model_online->singleNama($selectx,'tr_reimburse tr',$wherex);
		
		//$data['ss'] = $idreim;
		$this->load->view('templates/head');
		$this->load->view('templates/sidenav');
		$this->load->view('DetailApproval',$data);
		$this->load->view('templates/footer'); 
	}
	

	public function detail($reimID){
		//ambil id reimburse
        $id = $reimID;
		$empID = $this->session->userdata('EMP_ID');
        // ambil data
        $newID1 = substr($reimID,0,2);
        $newID2 = substr($reimID,2,6);
        $newID3 = substr($reimID,8,4);
        $newnew = $newID1.'/' .$newID2.'/'.$newID3;
		
		$where = array(
			'RB_ID' => $newnew,
			);
		
		$whereReim = array(
			'RB_ID' => $newnew,
		);
		$id = 'RB_ID';
		$query = $this->db->query("select * from tr_reimburse where RB_ID='$newnew'");
		$row = $query->row();

		$data['dreim'] = $this->Model_online->tampilData('tr_detail_reimburse',$where,$id);
        $data['id_re'] = $newnew;
		$data['dreim2'] = $this->Model_online->tampilData('tr_detail_reimburse',$where,$id);
		$data['RB_TOTAL'] = $row->RB_TOTAL;
		$data['RB_TRANSFER_DATE'] = $row->RB_TRANSFER_DATE;
		//untuk ambil data dari tr_reimburse dengan ID tertentu 1 row saja
		$selectx = '*';
		$fromx = 'tr_reimburse';
		$wherex = array (
			'RB_ID' => $newnew,
		);
		$data['row'] = $this->Model_online->cariDataRow($selectx,$fromx,$wherex);
		//end ambil data
		//untuk ambil data dari tr_approval dengan ID tertentu 1 row saja
		$selectApp = '*';
		$fromApp = 'tr_approval';
		$whereApp = array (
			'RB_ID' => $newnew,
		);
		$data['rowApp'] = $this->Model_online->cariDataRow($selectApp,$fromApp,$whereApp);
		//end ambil data
		$this->load->view('templates/head');
		$this->load->view('templates/sidenav');
		$this->load->view('Detail_Reimburse',$data);
		$this->load->view('templates/footer');
	}
	public function insertReim()
	{
		
		$Ym = date('ymd');
		$generateid = $this->Model_online->kode('RB/' . $Ym . '/', 14,'tr_reimburse','RB_ID');
		$RB_ID = $generateid;
		$EMP_ID = $this->session->userdata('EMP_ID');
		$RB_TOTAL = 0;
		$data = array(
			"RB_ID" => $RB_ID,
			"EMP_ID" => $EMP_ID,
			"RB_TOTAL" => $RB_TOTAL
			);
		$this->Model_online->input($data,"tr_reimburse");
		redirect(base_url().'Reimbursement/detail/'.str_replace('/','',$RB_ID));
	}
	public function deleteReim(){
		$RB_ID = $this->input->post("delID");
		$this->Model_online->deleteData('tr_reimburse','RB_ID',$RB_ID);
		redirect(base_url().'Reimbursement');
	}
	
	public function insertDetReim()
	{
		$RB_TRANSACTION_DATE = $this->input->post("trDate");
		//ambil setiap post masukkan dalam variable
		$Ym = date('ymd');
		$generateid = $this->Model_online->kode('DRB/' . $Ym . '/', 15,'tr_detail_reimburse','DET_RB_ID');
		$DET_RB_ID = $generateid;
		$RB_ID = $this->input->post("insID");
		$DET_RB_ITEM = $this->input->post("insNama");
		$DET_RB_VALUE = str_replace('.','',$this->input->post("insHarga"));
		$DET_RB_PHOTO = str_replace('/','',$generateid).".jpg";
		// atur config untuk upload
		$config['upload_path']          = './assets/dokumen/';
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		$config['max_size']             = 8048;
		$config['file_name']            = str_replace('/','',$generateid).'.jpg';
		$this->load->library('upload', $config);
		// atur array untuk insert data detail_reimburse
		$data = array(
		"DET_RB_ID" => $generateid,
		"RB_ID" => $RB_ID,
		"DET_RB_ITEM" => $DET_RB_ITEM,
		"DET_RB_VALUE" => $DET_RB_VALUE,
		"DET_RB_PHOTO" => $DET_RB_PHOTO,
		"DET_RB_TRANSACTION_DATE" => $RB_TRANSACTION_DATE
		);
		// update total reimburse
		$totalsaatini = $this->input->post("insTotal");
		$dataReim = array(
			"RB_TOTAL" => $totalsaatini + $DET_RB_VALUE
			);
		$whereReim = array(
			'RB_ID' => $RB_ID
		);
		$this->Model_online->update($whereReim,$dataReim,"tr_reimburse");
		// action upload dan insert data
		$this->Model_online->input($data,"tr_detail_reimburse");
		//$this->upload->do_upload('insNota');
		if($this->upload->do_upload('insNota')){
			$dataUpload = $this->upload->data();
			$this->image_lib->initialize(array(
				'image_library' => 'gd2', //library yang kita gunakan
				'source_image' => './assets/dokumen/'. $dataUpload['file_name'],
				'maintain_ratio' => TRUE,
				'create_thumb' => FALSE,
				'width' => 900,
				'height' => 900,
				'new_image' => './assets/dokumen/'. $dataUpload['file_name'],
			));
			$this->image_lib->resize();
		}
		redirect(base_url().'Reimbursement/detail/'.str_replace('/','',$RB_ID));
	}
	public function deleteDetReim(){
		
		$DET_RB_ID = $this->input->post("delID");
		$RB_ID = $this->input->post("delIDUtama");
		$DET_RB_VALUE = $this->input->post("delHarga");
		$path = "./assets/dokumen/".str_replace('/','',$DET_RB_ID).".jpg";
		
		$this->Model_online->deleteData('tr_detail_reimburse','DET_RB_ID',$DET_RB_ID);
		unlink($path);
		// update total reimburse
		$totalsaatini = $this->input->post("delTotal");
		$dataReim = array(
			"RB_TOTAL" => $totalsaatini - str_replace('.','',$DET_RB_VALUE)
			);
		$whereReim = array(
			'RB_ID' => $RB_ID
		);
		$this->Model_online->update($whereReim,$dataReim,"tr_reimburse");

		redirect(base_url().'Reimbursement/detail/'.str_replace('/','',$RB_ID));
	}
	public function updateDetReim()
	{
		$DET_RB_ID = $this->input->post("upIDDet");
		$RB_ID = $this->input->post("upID");
		$DET_RB_ITEM = $this->input->post("upNama");
		$DET_RB_VALUE = str_replace('.','',$this->input->post("upHarga"));
		$valueLama = str_replace('.','',$this->input->post("upHargaLama"));
		$DET_RB_PHOTO = str_replace('/','',$DET_RB_ID).".jpg";
		//untuk menghitung/kalibrasi total di tr_reimburse
			$valueBaru = $DET_RB_VALUE - $valueLama;
			$totalsaatini = $this->input->post("upTotal");
			$array1 = array($totalsaatini,$valueBaru);
			$yangdiinput = array_sum($array1);
		
		// atur config untuk upload
		$config['upload_path']          = './assets/dokumen/';
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		$config['max_size']             = 8048;
		$config['file_name']            = str_replace('/','',$DET_RB_ID).'.jpg';
		$this->load->library('upload', $config);
		
		if($_FILES['upNota']['name'] <> ""){
			$path = "./assets/dokumen/".str_replace('/','',$DET_RB_ID).".jpg";
			unlink($path);
			$data = array(
				"DET_RB_ITEM" => $DET_RB_ITEM,
				"DET_RB_VALUE" => $DET_RB_VALUE,
				"DET_RB_PHOTO" => $DET_RB_PHOTO
				);
			$where = array(
				'DET_RB_ID' => $DET_RB_ID
			);
			if($this->upload->do_upload('upNota')){
				$dataUpload = $this->upload->data();
				$this->image_lib->initialize(array(
					'image_library' => 'gd2', //library yang kita gunakan
					'source_image' => './assets/dokumen/'. $dataUpload['file_name'],
					'maintain_ratio' => TRUE,
					'create_thumb' => FALSE,
					'width' => 900,
					'height' => 900,
					'new_image' => './assets/dokumen/'. $dataUpload['file_name'],
				));
				$this->image_lib->resize();
			}	
			$this->Model_online->update($where,$data,"tr_detail_reimburse");
			// update total reimburse	
			$dataReim = array(
				"RB_TOTAL" => $yangdiinput
				);
			$whereReim = array(
				'RB_ID' => $RB_ID
			);
			$this->Model_online->update($whereReim,$dataReim,"tr_reimburse");
			// end update total reimburse
			clearstatcache();
			redirect(base_url().'Reimbursement/detail/'.str_replace('/','',$RB_ID));
		}else{
			$data = array(
				"DET_RB_ITEM" => $DET_RB_ITEM,
				"DET_RB_VALUE" => $DET_RB_VALUE,
				"DET_RB_PHOTO" => $DET_RB_PHOTO
				);
			$where = array(
				'DET_RB_ID' => $DET_RB_ID
			);
			$this->Model_online->update($where,$data,"tr_detail_reimburse");
			// update total reimburse	
			$dataReim = array(
				"RB_TOTAL" => $yangdiinput
				);
			$whereReim = array(
				'RB_ID' => $RB_ID
			);
			$this->Model_online->update($whereReim,$dataReim,"tr_reimburse");
			// end update total 
			clearstatcache();
			redirect(base_url().'Reimbursement/detail/'.str_replace('/','',$RB_ID));
		} 
	}
	/// Bagian Approval Awal Pengajuan Reimburse
	public function insertAppLeader(){
			$Ym = date('ymd');
			$Ymdhis = date('Y-m-d H:i:s');
			$generateid = $this->Model_online->kode('APP/' . $Ym . '/', 15,'tr_approval','TR_APP_ID');
			$TR_APP_ID = $generateid;
			$RB_ID = $this->input->post("insAppIdReim");
			// mengambil id session saat ini yg sedang login
			$EMP_ID = $this->input->post("insAppIdEmp");
			//cari siapa leadernya
			$row = $this->db->where('EMP_ID_MEMBER',$EMP_ID)->get('tr_supervision')->row_array();
			$LEADER_ID = $row['EMP_ID_LEADER'];
			// cari email leadernya
			$row2 = $this->db->where('EMP_ID',$LEADER_ID)->get('m_employee')->row_array();
			$leaderEmail = $row2['EMP_EMAIL'];
			// pengecekan doble untuk id_app dan leader yg sama, di insert app
			$wAppLeader = array(
				'RB_ID' => $RB_ID,
				'EMP_ID' => $LEADER_ID,
			);
			$countAppLeader = $this->Model_online->countRowWhere('tr_approval',$wAppLeader);
			if($countAppLeader<=0){
				// masukkan ke dalam tabel tr_approval
				$datax = array(
					"TR_APP_ID" => $TR_APP_ID,
					"RB_ID" => $RB_ID,
					"EMP_ID" => $LEADER_ID,
					"TR_APP_DATE" => '',
					"TR_APP_STATUS" => '0',
					"TR_SUB_DATE" => $Ymdhis,
					"TR_APP_COMMENT" => '',
					);	
				// update tanggal submit di tr_reimburse jika pertama kali approval
				$wApp = array(
					'RB_ID' => $RB_ID
				);
				$countwApp = $this->Model_online->countRowWhere('tr_approval',$wApp);
				if($countwApp<=0){
					$dataReim = array(
						"RB_SUBMIT_DATE" => $Ymdhis
						);
					$whereReim = array(
						'RB_ID' => $RB_ID
					);
					$this->Model_online->update($whereReim,$dataReim,"tr_reimburse");
				}else{
					$dataReim = array(
						"RB_FINAL_APP_DATE" => $Ymdhis
						);
					$whereReim = array(
						'RB_ID' => $RB_ID
					);
					$this->Model_online->update($whereReim,$dataReim,"tr_reimburse");
				}
				$this->Model_online->input($datax,"tr_approval");
				// BAGIAN EMAIL
				//  ============================================================== set value untuk email
					//pembuatan bagian isi email
					//ambil 1 row data reimburse
				$whereDataReim = array(
					'RB_ID' => $RB_ID,
				);
				$rowReim = $this->Model_online->findSingleDataWhere($whereDataReim,'tr_reimburse');
					//ambil 1 row nama employee
				$whereEmp = array(
					'EMP_ID' => $rowReim['EMP_ID'],
				);
				$rowEmp = $this->Model_online->findSingleDataWhere($whereEmp,'m_employee');
					//ambil nama depart dari EMP_ID
				$whereDep = array(
					'DEPART_ID' => $rowEmp['DEPART_ID'],
				);
				$rowDep = $this->Model_online->findSingleDataWhere($whereDep,'m_department');
					//ambil semua row detail reimburse
				$whereDet = array(
					'RB_ID' => $RB_ID,
				);
				$data['rowDet'] = $this->Model_online->findAllDataWhere($whereDet,'tr_detail_reimburse');
				//penamaan variable
				$to = $leaderEmail;
				$subject = 'Approval Reimbursement | '.$rowDep['DEPART_NAME'].' - '.$rowEmp['EMP_FULL_NAME'].' - '.$RB_ID; 
				$data['nama'] = $rowEmp['EMP_FULL_NAME'];
				$data['idEmp'] = $row2['EMP_ID'];
				$data['tglPengajuan'] = $rowReim['RB_SUBMIT_DATE'];
				$data['total'] = $rowReim['RB_TOTAL'];
				$data['idreim'] = $RB_ID ;
				$message = $this->load->view('templates/emailfix', $data,true);
				// aksi input update email
				$this->Model_online->insEmail($to,$subject,$message);
				//ke
				redirect(base_url().'Reimbursement');
			}
			
		
	}
	
	public function insertAppFA(){ // insert reimburse untuk langsung ke FA|| bagi leader atau orang FA sendiri
		$Ym = date('ymd');
		$Ymdhis = date('Y-m-d H:i:s');
		$generateid = $this->Model_online->kode('APP/' . $Ym . '/', 15,'tr_approval','TR_APP_ID');
		$TR_APP_ID = $generateid;
		$RB_ID = $this->input->post("insAppIdReim");
		$insFA = 'EMP/003/009';
		// cari email karyawan FA
		$row2 = $this->db->where('EMP_ID',$insFA)->get('m_employee')->row_array();
		$emailFA = $row2['EMP_EMAIL'];
		// masukkan data ke dalam tabel tr_approval
		$data = array(
			"TR_APP_ID" => $TR_APP_ID,
			"RB_ID" => $RB_ID,
			"EMP_ID" => 'EMP/003/009',
			"TR_APP_DATE" => '',
			"TR_APP_STATUS" => '0',
			"TR_SUB_DATE" => $Ymdhis,
			"TR_APP_COMMENT" => '',
			);	
		// update tanggal submit di tr_reimburse jika pertama kali approval
		$wApp = array(
			'RB_ID' => $RB_ID
		);
		$countwApp = $this->Model_online->countRowWhere('tr_approval',$wApp);
		if($countwApp<=0){
			$dataReim = array(
				"RB_SUBMIT_DATE" => $Ymdhis
				);
			$whereReim = array(
				'RB_ID' => $RB_ID
			);
			$this->Model_online->update($whereReim,$dataReim,"tr_reimburse");
		}else{
			$dataReim = array(
				"RB_FINAL_APP_DATE" => $Ymdhis
				);
			$whereReim = array(
				'RB_ID' => $RB_ID
			);
			$this->Model_online->update($whereReim,$dataReim,"tr_reimburse");
		}
		$this->Model_online->input($data,"tr_approval");
		// BAGIAN EMAIL
		//  ============================================================== set value untuk email
		//pembuatan bagian isi email
		//ambil 1 row data reimburse
		$whereDataReim = array(
			'RB_ID' => $RB_ID,
		);
		$rowReim = $this->Model_online->findSingleDataWhere($whereDataReim,'tr_reimburse');
			//ambil 1 row nama employee
		$whereEmp = array(
			'EMP_ID' => $rowReim['EMP_ID'],
		);
		$rowEmp = $this->Model_online->findSingleDataWhere($whereEmp,'m_employee');
		//ambil nama depart dari EMP_ID
		$whereDep = array(
			'DEPART_ID' => $rowEmp['DEPART_ID'],
		);
		$rowDep = $this->Model_online->findSingleDataWhere($whereDep,'m_department');
			//ambil semua row detail reimburse
		$whereDet = array(
			'RB_ID' => $RB_ID,
		);
		$data['rowDet'] = $this->Model_online->findAllDataWhere($whereDet,'tr_detail_reimburse');
		//penamaan variable
		$to = $emailFA;
		$subject = 'Approval Reimbursement | '.$rowDep['DEPART_NAME'].' - '.$rowEmp['EMP_FULL_NAME'].' - '.$RB_ID;
		$data['nama'] = $rowEmp['EMP_FULL_NAME'];
		$data['idEmp'] = $row2['EMP_ID'];
		$data['tglPengajuan'] = $rowReim['RB_SUBMIT_DATE'];
		$data['total'] = $rowReim['RB_TOTAL'];
		$data['idreim'] = $RB_ID ;
		$message = $this->load->view('templates/emailfix', $data,true);
		// aksi input update email
		$this->Model_online->insEmail($to,$subject,$message);
		//ke
		redirect(base_url().'Reimbursement');
	}

	public function insertAppMngFA()
	{ // insert reimburse untuk langsung ke FA|| bagi leader atau orang FA sendiri
		$Ym = date('ymd');
		$Ymdhis = date('Y-m-d H:i:s');
		$generateid = $this->Model_online->kode('APP/' . $Ym . '/', 15, 'tr_approval', 'TR_APP_ID');
		$TR_APP_ID = $generateid;
		$RB_ID = $this->input->post("insAppIdReim");
		$insFA = 'EMP/003/002';
		// cari email karyawan FA
		$row2 = $this->db->where('EMP_ID', $insFA)->get('m_employee')->row_array();
		$emailFA = $row2['EMP_EMAIL'];
		// masukkan data ke dalam tabel tr_approval
		$data = array(
			"TR_APP_ID" => $TR_APP_ID,
			"RB_ID" => $RB_ID,
			"EMP_ID" => 'EMP/003/002',
			"TR_APP_DATE" => '',
			"TR_APP_STATUS" => '0',
			"TR_SUB_DATE" => $Ymdhis,
			"TR_APP_COMMENT" => '',
		);
		// update tanggal submit di tr_reimburse jika pertama kali approval
		$wApp = array(
			'RB_ID' => $RB_ID
		);
		$countwApp = $this->Model_online->countRowWhere('tr_approval', $wApp);
		if ($countwApp <= 0) {
			$dataReim = array(
				"RB_SUBMIT_DATE" => $Ymdhis
			);
			$whereReim = array(
				'RB_ID' => $RB_ID
			);
			$this->Model_online->update($whereReim, $dataReim, "tr_reimburse");
		} else {
			$dataReim = array(
				"RB_FINAL_APP_DATE" => $Ymdhis
			);
			$whereReim = array(
				'RB_ID' => $RB_ID
			);
			$this->Model_online->update($whereReim, $dataReim, "tr_reimburse");
		}
		$this->Model_online->input($data, "tr_approval");
		// BAGIAN EMAIL
		//  ============================================================== set value untuk email
		//pembuatan bagian isi email
		//ambil 1 row data reimburse
		$whereDataReim = array(
			'RB_ID' => $RB_ID,
		);
		$rowReim = $this->Model_online->findSingleDataWhere($whereDataReim, 'tr_reimburse');
		//ambil 1 row nama employee
		$whereEmp = array(
			'EMP_ID' => $rowReim['EMP_ID'],
		);
		$rowEmp = $this->Model_online->findSingleDataWhere($whereEmp, 'm_employee');
		//ambil nama depart dari EMP_ID
		$whereDep = array(
			'DEPART_ID' => $rowEmp['DEPART_ID'],
		);
		$rowDep = $this->Model_online->findSingleDataWhere($whereDep, 'm_department');
		//ambil semua row detail reimburse
		$whereDet = array(
			'RB_ID' => $RB_ID,
		);
		$data['rowDet'] = $this->Model_online->findAllDataWhere($whereDet, 'tr_detail_reimburse');
		//penamaan variable
		$to = $emailFA;
		$subject = 'Approval Reimbursement | ' . $rowDep['DEPART_NAME'] . ' - ' . $rowEmp['EMP_FULL_NAME'] . ' - ' . $RB_ID;
		$data['nama'] = $rowEmp['EMP_FULL_NAME'];
		$data['idEmp'] = $row2['EMP_ID'];
		$data['tglPengajuan'] = $rowReim['RB_SUBMIT_DATE'];
		$data['total'] = $rowReim['RB_TOTAL'];
		$data['idreim'] = $RB_ID;
		$message = $this->load->view('templates/emailfix', $data, true);
		// aksi input update email
		$this->Model_online->insEmail($to, $subject, $message);
		//ke
		redirect(base_url() . 'Reimbursement');
	}
	/* public function insertOwnFA(){
		$Ym = date('ymd');
		$Ymdhis = date('Y-m-d H:i:s');
		$generateid = $this->Model_online->kode('APP/' . $Ym . '/', 15,'tr_approval','TR_APP_ID');
		$TR_APP_ID = $generateid;
		$RB_ID = $this->input->post("insAppIdReim");
		$siLogin = $this->session->userdata('EMP_ID');
		// masukkan data ke dalam tabel tr_approval
		// masukkan data ke dalam tabel tr_approval
		$data = array(
			"TR_APP_ID" => $TR_APP_ID,
			"RB_ID" => $RB_ID,
			"EMP_ID" => $siLogin,
			"TR_APP_DATE" => '',
			"TR_APP_STATUS" => '0',
			"TR_SUB_DATE" => $Ymdhis,
			"TR_APP_COMMENT" => '',
			);	
		$this->Model_online->input($data,"tr_approval");
		// update tanggal submit di tr_reimburse
		$dataReim = array(
			"RB_SUBMIT_DATE" => $Ymdhis
			);
		$whereReim = array(
			'RB_ID' => $RB_ID
		);
		$this->Model_online->update($whereReim,$dataReim,"tr_reimburse");
		redirect(base_url().'Reimbursement');
	} */
	/* public function insertApproval()
	{
		$Ym = date('ymd');
		$Ymdhis = date('Y-m-d H:i:s');
		$generateid = $this->Model_online->kode('APP/' . $Ym . '/', 15,'tr_approval','TR_APP_ID');
		$TR_APP_ID = $generateid;
		$RB_ID = $this->input->post("insAppIdReim");
		$insFA = $this->input->post("insFA");
		// mengambil id session saat ini yg sedang login
		$EMP_ID = $this->input->post("insAppIdEmp");
		// Cek Apakah yang sedang Login Mempunyai Leader ?
		$siLogin = $this->session->userdata('EMP_ID');
		$whereAdaLeader = array(
		'EMP_ID_MEMBER' => $siLogin,
		);
		$cekAdaDataLeader = $this->Model_online->countRowWhere('tr_supervision',$whereAdaLeader);
		// Cek Apakah yang sedang login adalah dari departemen FA ?
		$whereFA = array(
		'EMP_ID' => $siLogin,
		'DEPART_ID' => 'DP/003', // INI ADALAH DEPARTEMEN FA SAAT INI - (TERGANTUNG DATABASE LOH YA)
		);
		$cekFA = $this->Model_online->countRowWhere('m_employee',$whereFA);
		
		// Jika Yang Login Punya Leader maka masukkan approval kepada leadernya di kolom EMP_ID di tabel tr_approval
		if($cekAdaDataLeader>0){
			//cari siapa leadernya
			$row = $this->db->where('EMP_ID_MEMBER',$EMP_ID)->get('tr_supervision')->row_array();
			$LEADER_ID = $row['EMP_ID_LEADER'];
			// cari email leadernya
			$row2 = $this->db->where('EMP_ID',$LEADER_ID)->get('m_employee')->row_array();
			$leaderEmail = $row2['EMP_EMAIL'];
			// masukkan ke dalam tabel tr_approval
			$data = array(
				"TR_APP_ID" => $TR_APP_ID,
				"RB_ID" => $RB_ID,
				"EMP_ID" => $LEADER_ID,
				"TR_APP_DATE" => '',
				"TR_APP_STATUS" => '0',
				"TR_SUB_DATE" => $Ymdhis,
				"TR_APP_COMMENT" => '',
				);	
			$this->Model_online->input($data,"tr_approval");
			// update tanggal submit di tr_reimburse
			$dataReim = array(
				"RB_SUBMIT_DATE" => $Ymdhis
				);
			$whereReim = array(
				'RB_ID' => $RB_ID
			);
			$this->Model_online->update($whereReim,$dataReim,"tr_reimburse");
			// set value untuk email
			$to = $leaderEmail;
			$subject = 'Approval Online Form - Reimbursement ID :'.$RB_ID;
			$message = 'Coba dari controller';
			$this->Model_online->insEmail($to,$subject,$message);
			redirect(base_url().'Reimbursement');
		}// Jika Yang Login Tidak Punya Leader dan Orang FA Maka Masukkan Approval Kepada Dirinya Sendiri di kolom EMP_ID di tabel tr_approval 
		elseif($cekFA>0 && $cekAdaDataLeader=0){
			// masukkan data ke dalam tabel tr_approval
			$data = array(
				"TR_APP_ID" => $TR_APP_ID,
				"RB_ID" => $RB_ID,
				"EMP_ID" => $siLogin,
				"TR_APP_DATE" => '',
				"TR_APP_STATUS" => '0',
				"TR_SUB_DATE" => $Ymdhis,
				"TR_APP_COMMENT" => '',
				);	
			$this->Model_online->input($data,"tr_approval");
			// update tanggal submit di tr_reimburse
			$dataReim = array(
				"RB_SUBMIT_DATE" => $Ymdhis
				);
			$whereReim = array(
				'RB_ID' => $RB_ID
			);
			$this->Model_online->update($whereReim,$dataReim,"tr_reimburse");
			redirect(base_url().'Reimbursement');
		}// jika yang login adalah leader dan bukan anggota FA
		elseif($cekFA<=0 && $cekAdaDataLeader<=0){
			// masukkan data ke dalam tabel tr_approval
			$data = array(
				"TR_APP_ID" => $TR_APP_ID,
				"RB_ID" => $RB_ID,
				"EMP_ID" => $insFA,
				"TR_APP_DATE" => '',
				"TR_APP_STATUS" => '0',
				"TR_SUB_DATE" => $Ymdhis,
				"TR_APP_COMMENT" => '',
				);	
			$this->Model_online->input($data,"tr_approval");
			// update tanggal submit di tr_reimburse
			$dataReim = array(
				"RB_SUBMIT_DATE" => $Ymdhis
				);
			$whereReim = array(
				'RB_ID' => $RB_ID
			);
			$this->Model_online->update($whereReim,$dataReim,"tr_reimburse");
			redirect(base_url().'Reimbursement');
		}
	} */
	
	// Setujui dan Langsung Ajukan Ke FA
	public function updateApproval()
	{
		//setujui dan beri status 1 untuk menyetujui
		$idApp = $this->input->post("idApp");
		$idReim = $this->input->post("idReim");
		$empID = $this->session->userdata('EMP_ID');
		$appDate = date('Y-m-d H:i:s');
		$statusApp = '1';
		$newID1 = substr($idApp,0,3);
        $newID2 = substr($idApp,3,6);
        $newID3 = substr($idApp,9,4);
        $newnew = $newID1.'/' .$newID2.'/'.$newID3;
		// ajukan approval ke FA
		$Ym = date('ymd');
		$Ymdhis = date('Y-m-d H:i:s');
		$generateid = $this->Model_online->kode('APP/' . $Ym . '/', 15,'tr_approval','TR_APP_ID');
		$TR_APP_ID = $generateid;
		//$MEMBER_FA = $this->input->post("insFA");
		$MEMBER_FA = 'EMP/003/009';//sementara
		$row2 = $this->db->where('EMP_ID',$MEMBER_FA)->get('m_employee')->row_array();
		$emailFA = $row2['EMP_EMAIL'];
		// pengecekan doble untuk status yg sudah lebih dari 0 atau sudah ada tindakan
		$wAppStatus = array(
			'TR_APP_ID' => $newnew,
			'EMP_ID' => $empID,
			'TR_APP_STATUS !=' => '0',
		);
		$countAppStatus = $this->Model_online->countRowWhere('tr_approval',$wAppStatus);
		// pengecekan doble untuk id_app dan leader yg sama, di insert app
		$wAppFA = array(
			'RB_ID' => $idReim,
			'EMP_ID' => $MEMBER_FA,
		);
		$countAppFA = $this->Model_online->countRowWhere('tr_approval',$wAppFA);
		if($countAppFA<=0 && $countAppStatus<=0){
			//setujui dan beri status 1
			$data = array(
				"TR_APP_DATE" => $appDate,
				"TR_APP_STATUS" => $statusApp,
			);
			$where = array(
				'TR_APP_ID' => $newnew
			);
			$this->Model_online->update($where,$data,"tr_approval");
			// masukkan ke dalam tabel tr_approval
			$data = array(
				"TR_APP_ID" => $TR_APP_ID,
				"RB_ID" => $idReim,
				"EMP_ID" => 'EMP/003/009',
				"TR_APP_DATE" => '',
				"TR_APP_STATUS" => '0',
				"TR_SUB_DATE" => $appDate,
				"TR_APP_COMMENT" => '',
				);	
			$this->Model_online->input($data,"tr_approval");
			$dataReim = array(
				"RB_FINAL_APP_DATE" => $Ymdhis
				);
			$whereReim = array(
				'RB_ID' => $idReim
			);
			$this->Model_online->update($whereReim,$dataReim,"tr_reimburse");
			// BAGIAN EMAIL
				//  ============================================================== set value untuk email
				//pembuatan bagian isi email
				//ambil 1 row data reimburse
				$whereDataReim = array(
					'RB_ID' => $idReim,
				);
				$rowReim = $this->Model_online->findSingleDataWhere($whereDataReim,'tr_reimburse');
					//ambil 1 row nama employee
				$whereEmp = array(
					'EMP_ID' => $rowReim['EMP_ID'],
				);
				$rowEmp = $this->Model_online->findSingleDataWhere($whereEmp,'m_employee');
				//ambil nama depart dari EMP_ID
				$whereDep = array(
					'DEPART_ID' => $rowEmp['DEPART_ID'],
				);
				$rowDep = $this->Model_online->findSingleDataWhere($whereDep,'m_department');
					//ambil semua row detail reimburse
				$whereDet = array(
					'RB_ID' => $idReim,
				);
				$data['rowDet'] = $this->Model_online->findAllDataWhere($whereDet,'tr_detail_reimburse');
				//penamaan variable
				$to = $emailFA;
				$subject = 'Approval Reimbursement | '.$rowDep['DEPART_NAME'].' - '.$rowEmp['EMP_FULL_NAME'].' - '.$idReim;
				$data['nama'] = $rowEmp['EMP_FULL_NAME'];
				$data['idEmp'] = $row2['EMP_ID'];
				$data['tglPengajuan'] = $rowReim['RB_SUBMIT_DATE'];
				$data['total'] = $rowReim['RB_TOTAL'];
				$data['idreim'] = $idReim ;
				$message = $this->load->view('templates/emailfix', $data,true);
				// aksi input update email
				$this->Model_online->insEmail($to,$subject,$message);
			redirect(base_url().'Reimbursement/Approval');
		}else{
			//tampilkan error data telah diproses harap cek kembali
			redirect(base_url().'Reimbursement/Approval');
			//redirect ke approval
		}
	}

	// Setujui dan kasih approval tambahan dari atasan
	public function conApproval()
	{
		//setujui dan beri status 1
		$idApp = $this->input->post("idApp");
		$idReim = $this->input->post("idReim");
		$empID = $this->session->userdata('EMP_ID');
		$appDate = date('Y-m-d H:i:s');
		$statusApp = '1';
		$newID1 = substr($idApp,0,3);
        $newID2 = substr($idApp,3,6);
        $newID3 = substr($idApp,9,4);
		$newnew = $newID1.'/' .$newID2.'/'.$newID3;
		// masukkan approval lanjutan(approval baru)
		$Ym = date('ymd');
		$generateid = $this->Model_online->kode('APP/' . $Ym . '/', 15,'tr_approval','TR_APP_ID');
		$TR_APP_ID = $generateid;
		$row = $this->db->where('EMP_ID_MEMBER',$empID)->get('tr_supervision')->row_array();
		$LEADER_ID = $row['EMP_ID_LEADER'];
		//$idLeader = $rowSp['EMP_ID_LEADER'];
		// cari email leadernya
		$row2 = $this->db->where('EMP_ID',$LEADER_ID)->get('m_employee')->row_array();
		$leaderEmail = $row2['EMP_EMAIL'];
		// pengecekan doble untuk status yg sudah lebih dari 0 atau sudah ada tindakan
		$wAppStatus = array(
			'TR_APP_ID' => $newnew,
			'EMP_ID' => $empID,
			'TR_APP_STATUS !=' => '0',
		);
		$countAppStatus = $this->Model_online->countRowWhere('tr_approval',$wAppStatus);
		// pengecekan doble untuk id_app dan leader yg sama, di insert app
		$wAppLeader = array(
			'RB_ID' => $idReim,
			'EMP_ID' => $LEADER_ID,
		);
		$countAppLeader = $this->Model_online->countRowWhere('tr_approval',$wAppLeader);
		if($countAppLeader<=0 && $countAppStatus<=0){
			//setujui dan beri status 1
			$data = array(
				"TR_APP_DATE" => $appDate,
				"TR_APP_STATUS" => $statusApp,
			);
			$where = array(
				'TR_APP_ID' => $newnew
			);
			$this->Model_online->update($where,$data,"tr_approval");
			// masukkan ke dalam tabel tr_approval
			$data = array(
				"TR_APP_ID" => $TR_APP_ID,
				"RB_ID" => $idReim,
				"EMP_ID" => $LEADER_ID,
				"TR_APP_DATE" => '',
				"TR_APP_STATUS" => '0',
				"TR_SUB_DATE" => $appDate,
				"TR_APP_COMMENT" => '',
				);	
			$this->Model_online->input($data,"tr_approval");

			// BAGIAN EMAIL
			//  ============================================================== set value untuk email
			//pembuatan bagian isi email
			//ambil 1 row data reimburse
			$whereDataReim = array(
				'RB_ID' => $idReim,
			);
			$rowReim = $this->Model_online->findSingleDataWhere($whereDataReim,'tr_reimburse');
				//ambil 1 row nama employee
			$whereEmp = array(
				'EMP_ID' => $rowReim['EMP_ID'],
			);
			$rowEmp = $this->Model_online->findSingleDataWhere($whereEmp,'m_employee');
			//ambil nama depart dari EMP_ID
			$whereDep = array(
				'DEPART_ID' => $rowEmp['DEPART_ID'],
			);
			$rowDep = $this->Model_online->findSingleDataWhere($whereDep,'m_department');
				//ambil semua row detail reimburse
			$whereDet = array(
				'RB_ID' => $idReim,
			);
			$data['rowDet'] = $this->Model_online->findAllDataWhere($whereDet,'tr_detail_reimburse');
			//penamaan variable
			$to = $leaderEmail;
			$subject = 'Approval Reimbursement | '.$rowDep['DEPART_NAME'].' - '.$rowEmp['EMP_FULL_NAME'].' - '.$idReim; 
			$data['nama'] = $rowEmp['EMP_FULL_NAME'];
			$data['idEmp'] = $row2['EMP_ID'];
			$data['tglPengajuan'] = $rowReim['RB_SUBMIT_DATE'];
			$data['total'] = $rowReim['RB_TOTAL'];
			$data['idreim'] = $idReim ;
			$message = $this->load->view('templates/emailfix', $data,true);
			// aksi input update email
			$this->Model_online->insEmail($to,$subject,$message);
			//redirect ke halaman awal
			redirect(base_url().'Reimbursement/Approval');
		}else{
			// bikin tampilan error data telah di proses harap cek kembali
			// redirect ke halaman approval
			redirect(base_url().'Reimbursement/Approval');
		}
	}

	// Persetujuan Final Dari Yg tidak punya atasan lagi (top)
	public function finalApprovalMngFa()
	{
		//setujui dan beri status 1 untuk menyetujui
		$idApp = $this->input->post("idApp");
		$idReim = $this->input->post("idReim");
		$empID = $this->session->userdata('EMP_ID');
		$appDate = date('Y-m-d H:i:s');
		$statusApp = '3';
		$newID1 = substr($idApp,0,3);
        $newID2 = substr($idApp,3,6);
        $newID3 = substr($idApp,9,4);
        $newnew = $newID1.'/' .$newID2.'/'.$newID3;
		// ajukan approval ke FA
		$Ym = date('ymd');
		$Ymdhis = date('Y-m-d H:i:s');
		$generateid = $this->Model_online->kode('APP/' . $Ym . '/', 15,'tr_approval','TR_APP_ID');
		$TR_APP_ID = $generateid;
		//$MEMBER_FA = $this->input->post("insFA");
		$MEMBER_FA = 'EMP/003/002';//sementara
		$row2 = $this->db->where('EMP_ID',$MEMBER_FA)->get('m_employee')->row_array();
		$emailFA = $row2['EMP_EMAIL'];
		// pengecekan doble untuk status yg sudah lebih dari 0 atau sudah ada tindakan
		$wAppStatus = array(
			'TR_APP_ID' => $newnew,
			'EMP_ID' => $empID,
			'TR_APP_STATUS !=' => '0',
		);
		$countAppStatus = $this->Model_online->countRowWhere('tr_approval',$wAppStatus);
		// pengecekan doble untuk id_app dan leader yg sama, di insert app
		$wAppFA = array(
			'RB_ID' => $idReim,
			'EMP_ID' => $MEMBER_FA,
		);
		$countAppFA = $this->Model_online->countRowWhere('tr_approval',$wAppFA);
		if($countAppFA<=0 && $countAppStatus<=0){
			//setujui dan beri status 1
			$data = array(
				"TR_APP_DATE" => $appDate,
				"TR_APP_STATUS" => $statusApp,
			);
			$where = array(
				'TR_APP_ID' => $newnew
			);
			$this->Model_online->update($where,$data,"tr_approval");
			// masukkan ke dalam tabel tr_approval
			$data = array(
				"TR_APP_ID" => $TR_APP_ID,
				"RB_ID" => $idReim,
				"EMP_ID" => 'EMP/003/002',
				"TR_APP_DATE" => '',
				"TR_APP_STATUS" => '0',
				"TR_SUB_DATE" => $appDate,
				"TR_APP_COMMENT" => '',
				);	
			$this->Model_online->input($data,"tr_approval");
			$dataReim = array(
				"RB_FINAL_APP_DATE" => $Ymdhis
				);
			$whereReim = array(
				'RB_ID' => $idReim
			);
			$this->Model_online->update($whereReim,$dataReim,"tr_reimburse");
			// BAGIAN EMAIL
				//  ============================================================== set value untuk email
				//pembuatan bagian isi email
				//ambil 1 row data reimburse
				$whereDataReim = array(
					'RB_ID' => $idReim,
				);
				$rowReim = $this->Model_online->findSingleDataWhere($whereDataReim,'tr_reimburse');
					//ambil 1 row nama employee
				$whereEmp = array(
					'EMP_ID' => $rowReim['EMP_ID'],
				);
				$rowEmp = $this->Model_online->findSingleDataWhere($whereEmp,'m_employee');
				//ambil nama depart dari EMP_ID
				$whereDep = array(
					'DEPART_ID' => $rowEmp['DEPART_ID'],
				);
				$rowDep = $this->Model_online->findSingleDataWhere($whereDep,'m_department');
					//ambil semua row detail reimburse
				$whereDet = array(
					'RB_ID' => $idReim,
				);
				$data['rowDet'] = $this->Model_online->findAllDataWhere($whereDet,'tr_detail_reimburse');
				//penamaan variable
				$to = $emailFA;
				$subject = 'Approval Reimbursement | '.$rowDep['DEPART_NAME'].' - '.$rowEmp['EMP_FULL_NAME'].' - '.$idReim;
				$data['nama'] = $rowEmp['EMP_FULL_NAME'];
				$data['idEmp'] = $row2['EMP_ID'];
				$data['tglPengajuan'] = $rowReim['RB_SUBMIT_DATE'];
				$data['total'] = $rowReim['RB_TOTAL'];
				$data['idreim'] = $idReim ;
				$message = $this->load->view('templates/emailfix', $data,true);
				// aksi input update email
				$this->Model_online->insEmail($to,$subject,$message);
			redirect(base_url().'Reimbursement/Approval');
		}else{
			//tampilkan error data telah diproses harap cek kembali
			redirect(base_url().'Reimbursement/Approval');
			//redirect ke approval
		}
		
	}
	// Persetujuan Final Dari Yg tidak punya atasan lagi (top)
	public function finalApproval()
	{
		//setujui dan beri status 1 untuk menyetujui
		$idApp = $this->input->post("idApp");
		$idReim = $this->input->post("idReim");
		$empID = $this->session->userdata('EMP_ID');
		$appDate = date('Y-m-d H:i:s');
		$statusApp = '3';
		$newID1 = substr($idApp,0,3);
        $newID2 = substr($idApp,3,6);
        $newID3 = substr($idApp,9,4);
        $newnew = $newID1.'/' .$newID2.'/'.$newID3;
		// ajukan approval ke FA
		$Ym = date('ymd');
		$Ymdhis = date('Y-m-d H:i:s');
		$generateid = $this->Model_online->kode('APP/' . $Ym . '/', 15,'tr_approval','TR_APP_ID');
		$TR_APP_ID = $generateid;
		//$MEMBER_FA = $this->input->post("insFA");
		$MEMBER_FA = 'EMP/003/009';//sementara
		$row2 = $this->db->where('EMP_ID',$MEMBER_FA)->get('m_employee')->row_array();
		$emailFA = $row2['EMP_EMAIL'];
		// pengecekan doble untuk status yg sudah lebih dari 0 atau sudah ada tindakan
		$wAppStatus = array(
			'TR_APP_ID' => $newnew,
			'EMP_ID' => $empID,
			'TR_APP_STATUS !=' => '0',
		);
		$countAppStatus = $this->Model_online->countRowWhere('tr_approval',$wAppStatus);
		// pengecekan doble untuk id_app dan leader yg sama, di insert app
		$wAppFA = array(
			'RB_ID' => $idReim,
			'EMP_ID' => $MEMBER_FA,
		);
		$countAppFA = $this->Model_online->countRowWhere('tr_approval',$wAppFA);
		if($countAppFA<=0 && $countAppStatus<=0){
			//setujui dan beri status 1
			$data = array(
				"TR_APP_DATE" => $appDate,
				"TR_APP_STATUS" => $statusApp,
			);
			$where = array(
				'TR_APP_ID' => $newnew
			);
			$this->Model_online->update($where,$data,"tr_approval");
			// masukkan ke dalam tabel tr_approval
			$data = array(
				"TR_APP_ID" => $TR_APP_ID,
				"RB_ID" => $idReim,
				"EMP_ID" => 'EMP/003/009',
				"TR_APP_DATE" => '',
				"TR_APP_STATUS" => '0',
				"TR_SUB_DATE" => $appDate,
				"TR_APP_COMMENT" => '',
				);	
			$this->Model_online->input($data,"tr_approval");
			$dataReim = array(
				"RB_FINAL_APP_DATE" => $Ymdhis
				);
			$whereReim = array(
				'RB_ID' => $idReim
			);
			$this->Model_online->update($whereReim,$dataReim,"tr_reimburse");
			// BAGIAN EMAIL
				//  ============================================================== set value untuk email
				//pembuatan bagian isi email
				//ambil 1 row data reimburse
				$whereDataReim = array(
					'RB_ID' => $idReim,
				);
				$rowReim = $this->Model_online->findSingleDataWhere($whereDataReim,'tr_reimburse');
					//ambil 1 row nama employee
				$whereEmp = array(
					'EMP_ID' => $rowReim['EMP_ID'],
				);
				$rowEmp = $this->Model_online->findSingleDataWhere($whereEmp,'m_employee');
				//ambil nama depart dari EMP_ID
				$whereDep = array(
					'DEPART_ID' => $rowEmp['DEPART_ID'],
				);
				$rowDep = $this->Model_online->findSingleDataWhere($whereDep,'m_department');
					//ambil semua row detail reimburse
				$whereDet = array(
					'RB_ID' => $idReim,
				);
				$data['rowDet'] = $this->Model_online->findAllDataWhere($whereDet,'tr_detail_reimburse');
				//penamaan variable
				$to = $emailFA;
				$subject = 'Approval Reimbursement | '.$rowDep['DEPART_NAME'].' - '.$rowEmp['EMP_FULL_NAME'].' - '.$idReim;
				$data['nama'] = $rowEmp['EMP_FULL_NAME'];
				$data['idEmp'] = $row2['EMP_ID'];
				$data['tglPengajuan'] = $rowReim['RB_SUBMIT_DATE'];
				$data['total'] = $rowReim['RB_TOTAL'];
				$data['idreim'] = $idReim ;
				$message = $this->load->view('templates/emailfix', $data,true);
				// aksi input update email
				$this->Model_online->insEmail($to,$subject,$message);
			redirect(base_url().'Reimbursement/Approval');
		}else{
			//tampilkan error data telah diproses harap cek kembali
			redirect(base_url().'Reimbursement/Approval');
			//redirect ke approval
		}
		
	}

	// Persetujuan Final Dari FA
	public function finalApprovalFA()
	{
		//setujui dan beri status 1
		$idApp = $this->input->post("idApp");
		$idReim = $this->input->post("idReim");

		if(!empty($this->input->post("tglRealisasi"))){
			$tfDate = $this->input->post("tglRealisasi");
			$myWhere = array(
				'RB_ID' => $idReim
			);
			$myData = array(
				'RB_TRANSFER_DATE' => $tfDate
			);
			$this->Model_online->update($myWhere,$myData,"tr_reimburse");
		}

		$empID = $this->session->userdata('EMP_ID');
		$appDate = date('Y-m-d H:i:s');
		$statusApp = '4';
		$newID1 = substr($idApp,0,3);
        $newID2 = substr($idApp,3,6);
        $newID3 = substr($idApp,9,4);
		$newnew = $newID1.'/' .$newID2.'/'.$newID3;
		// pengecekan doble untuk id_app dan leader yg sama dan status lebih dari 0, di insert app
		$wAppFinal = array(
			'RB_ID' => $idReim,
			'TR_APP_ID' => $newnew,
			'TR_APP_STATUS !=' => '0'
		);
		$cAppFinal = $this->Model_online->countRowWhere('tr_approval',$wAppFinal);
		if($cAppFinal<=0){
			$data = array(
				"TR_APP_DATE" => $appDate,
				"TR_APP_STATUS" => $statusApp,
			);
			$where = array(
				'TR_APP_ID' => $newnew
			);
			$this->Model_online->update($where,$data,"tr_approval");
			$dataReim = array(
				"RB_FINAL_APP_DATE" => $appDate,
				);
			$whereReim = array(
				'RB_ID' => $idReim,
			);
			$this->Model_online->update($whereReim,$dataReim,"tr_reimburse");
			//redirect ke halaman awal
			redirect(base_url().'Reimbursement/Approval');
		}else{
			//tampilkan error data telah diproses harap cek kembali

			//redirect ke approval
			redirect(base_url().'Reimbursement/Approval');
		}
		
	}
	public function denyApproval()
	{
		//setujui dan beri status 1
		$idApp = $this->input->post("idApp");
		$idReim = $this->input->post("idReim");
		$alasantolak = $this->input->post("alasantolak");
		// if(isset($this->input->post("alasantolak"))){
		// }else{
		// 	$alasantolak = '-';
		// }
		$empID = $this->session->userdata('EMP_ID');
		$appDate = date('Y-m-d H:i:s');
		$statusApp = '2';
		$newID1 = substr($idApp,0,3);
        $newID2 = substr($idApp,3,6);
        $newID3 = substr($idApp,9,4);
		$newnew = $newID1.'/' .$newID2.'/'.$newID3;
		// pengecekan doble untuk id_app dan leader yg sama dan status lebih dari 0, di insert app
		$wAppDeny = array(
			'RB_ID' => $idReim,
			'TR_APP_ID' => $newnew,
			'TR_APP_STATUS !=' => '0'
		);
		$cAppDeny = $this->Model_online->countRowWhere('tr_approval',$wAppDeny);
		if($cAppDeny<=0){
			$data = array(
				"TR_APP_DATE" => $appDate,
				"TR_APP_STATUS" => $statusApp,
				"TR_APP_COMMENT" => $alasantolak,
			);
			$where = array(
				'TR_APP_ID' => $newnew
			);
			$this->Model_online->update($where,$data,"tr_approval");
			//redirect ke halaman awal
			redirect(base_url().'Reimbursement/Approval');
		}else{
			//beri error
			//redirect
			redirect(base_url().'Reimbursement/Approval');
		}
	}
	
	
	
}