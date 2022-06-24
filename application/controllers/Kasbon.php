<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");

class Kasbon extends CI_Controller {

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
        $empID = $this->session->userdata('EMP_ID');
		$where = array(
			'EMP_ID' => $empID,
			'KB_SUBMIT_DATE' => null,
        );
        $where2 = array(
			'EMP_ID' => $empID,
			'KB_SUBMIT_DATE !=' => null,
        );
        $data['kasbonAju'] = $this->Model_online->tampilData('tr_kasbon',$where2,'KB_ID');
        $data['kasbon'] = $this->Model_online->tampilData('tr_kasbon',$where,'KB_ID');
		$this->load->view('templates/head');
		$this->load->view('templates/sidenav');
		$this->load->view('kasbon/dashboard',$data);
		$this->load->view('templates/footer');
    }
    public function detail($KB_ID){		
		$empID = $this->session->userdata('EMP_ID');
        // ambil data
        $newID1 = substr($KB_ID,0,2);
        $newID2 = substr($KB_ID,2,6);
        $newID3 = substr($KB_ID,8,4);
        $newKB_ID = $newID1.'/' .$newID2.'/'.$newID3;
		$where = array(
			'KB_ID' => $newKB_ID,
            );
        $data['kasbon'] = $this->Model_online->findSingleDataWhere($where,'tr_kasbon');
        $data['dkasbon'] = $this->Model_online->tampilData('tr_detail_kasbon',$where,'KB_ID');
        $data['dkasbon2'] = $this->Model_online->findAllDataWhere($where,'tr_detail_kasbon');
        $data['dkasbon3'] = $this->Model_online->findAllDataWhere($where,'tr_detail_kasbon');
		$data['app'] = $this->Model_online->findSingleDataWhere($where,'tr_kb_approval');
		//end ambil data
		$this->load->view('templates/head');
		$this->load->view('templates/sidenav');
		$this->load->view('kasbon/detailkasbon',$data);
		$this->load->view('templates/footer');
    }
    public function approval(){
		$empID = $this->session->userdata('EMP_ID');
		$select = array(
			'tak.TR_KB_APP_ID', 
			'tak.TR_KB_SUB_DATE', 
			'tak.KB_ID', 
			'tr.KB_TOTAL_AWAL', 
			'md.DEPART_NAME', 
			'me.EMP_FULL_NAME',
			'tr.KB_STATUS'
		);
		$where = array(
			'tak.EMP_ID' => $empID,
			'tak.TR_KB_APP_STATUS ' => '0',
		);
		$groupby = 'tak.TR_KB_APP_ID';
		$data['app'] = $this->Model_online->dataApprovalKB($select,$where,'tr_kb_approval tak',$groupby);

		$selectNo = array(
			'tak.TR_KB_APP_ID', 
			'tak.TR_KB_SUB_DATE', 
			'tak.KB_ID', 
			'tr.KB_TOTAL_AWAL', 
			'md.DEPART_NAME',
			'me.EMP_FULL_NAME',
			'me.EMP_ID',
			'tr.KB_STATUS'
		);
		$whereNo = array(
			'tak.EMP_ID' => $empID,
			'tr.KB_STATUS !=' => '0',
		);
		$groupbyNo = 'tak.TR_KB_APP_ID';
		$data['appNo'] = $this->Model_online->dataApprovalKB($selectNo,$whereNo,'tr_kb_approval tak',$groupbyNo);
		$whereReal = array(
			'KB_STATUS' => '5',
		);
		$data['appReal'] = $this->Model_online->findAllDataWhere($whereReal,'tr_kasbon');
		$selectFA = array(
			'tak.TR_KB_APP_ID', 
			'tak.TR_KB_SUB_DATE', 
			'tak.KB_ID', 
			'tr.KB_TOTAL_AWAL', 
			'md.DEPART_NAME',
			'me.EMP_FULL_NAME',
			'me.EMP_ID',
			'tr.KB_STATUS'
		);
		$whereFA = array(
			'tak.TR_KB_APP_STATUS' => '4',
		);
		$groupbyFA = 'tak.TR_KB_APP_ID';
		$data['appFA'] = $this->Model_online->dataApprovalKB($selectFA,$whereFA,'tr_kb_approval tak',$groupbyFA);

		$this->load->view('templates/head');
		$this->load->view('templates/sidenav');
		$this->load->view('kasbon/kasbonapp',$data);
		$this->load->view('templates/footer');
    }
    public function detailapproval($id){	
		$empID = $this->session->userdata('EMP_ID');
		//cari id approval kasbon
		$newID1 = substr($id,0,3);
        $newID2 = substr($id,3,6);
        $newID3 = substr($id,9,4);
		$newnew = $newID1.'/' .$newID2.'/'.$newID3;
		$where = array(
			'TR_KB_APP_ID' =>$newnew
		);
		$cari = $this->Model_online->findSingleDataWhere($where,'tr_kb_approval');
		//ambil data detail approval dari id approval kasbon
		$whereCari = array(
			'KB_ID' => $cari['KB_ID']
		);
		$data['det'] = $this->Model_online->findAllDataWhere($whereCari,'tr_detail_kasbon');
		// ambil data kasbon dan nama pengaju single
		$selectx = array(
			'tr.*', 
			'me.EMP_FULL_NAME as nama'
		);
		$wherex = array(
			'tr.KB_ID' => $cari['KB_ID']
		);
		$data['kbnama'] = $this->Model_online->singleNama($selectx,'tr_kasbon tr',$wherex);
		
		$this->load->view('templates/head');
		$this->load->view('templates/sidenav');
		$this->load->view('kasbon/kasbondetailapp',$data);
		$this->load->view('templates/footer'); 
	}
	public function detailappreal($id){	
		$empID = $this->session->userdata('EMP_ID');
		//cari id approval kasbon
		$newID1 = substr($id,0,2);
        $newID2 = substr($id,2,6);
        $newID3 = substr($id,8,4);
		$newnew = $newID1.'/' .$newID2.'/'.$newID3;
		$where = array(
			'KB_ID' =>$newnew
		);
		$data['kasbon'] = $this->Model_online->findSingleDataWhere($where,'tr_kasbon');
		$this->load->view('templates/head');
		$this->load->view('templates/sidenav');
		$this->load->view('kasbon/kasbonrealapp',$data);
		$this->load->view('templates/footer'); 
	}
	public function report($id){
		$empID = $this->session->userdata('EMP_ID');
        // ambil data
        $newID1 = substr($id,0,2);
        $newID2 = substr($id,2,6);
        $newID3 = substr($id,8,4);
        $newKB_ID = $newID1.'/' .$newID2.'/'.$newID3;
		$where = array(
			'KB_ID' => $newKB_ID,
			);
		$whereDet = array(
			'KB_ID' => $newKB_ID,
			'DET_KB_END_VALUE' => null
			);
		$whereDetIsi = array(
			'KB_ID' => $newKB_ID,
			'DET_KB_END_VALUE !=' => null
			);
        $data['kasbon'] = $this->Model_online->findSingleDataWhere($where,'tr_kasbon');
        $data['dkasbon'] = $this->Model_online->findAllDataWhere($whereDet,'tr_detail_kasbon');
		$data['dkasbon2'] = $this->Model_online->findAllDataWhere($whereDetIsi,'tr_detail_kasbon');
		$data['dkasbon3'] = $this->Model_online->findAllDataWhere($whereDetIsi,'tr_detail_kasbon');
		$data['hitDKasbon'] = $this->Model_online->countRowWhere('tr_detail_kasbon',$whereDet);
		$data['hitDKasbonIsi'] = $this->Model_online->countRowWhere('tr_detail_kasbon',$whereDetIsi);
		$data['app'] = $this->Model_online->findSingleDataWhere($where,'tr_kb_approval');
		//end ambil data
		$this->load->view('templates/head');
		$this->load->view('templates/sidenav');
		$this->load->view('kasbon/kasbonreport',$data);
		$this->load->view('templates/footer');
	}
	public function dtreport($id){
		$empID = $this->session->userdata('EMP_ID');
        // ambil data
        $newID1 = substr($id,0,3);
        $newID2 = substr($id,3,6);
        $newID3 = substr($id,9,4);
        $newDtKB_ID = $newID1.'/' .$newID2.'/'.$newID3;
		$where = array(
			'DET_KB_ID' => $newDtKB_ID,
			);
        $data['dtkasbon'] = $this->Model_online->findSingleDataWhere($where,'tr_detail_kasbon');
        $data['dtreal'] = $this->Model_online->findAllDataWhere($where,'tr_detail_real');
		//end ambil data
		clearstatcache();
		$this->load->view('templates/head');
		$this->load->view('templates/sidenav');
		$this->load->view('kasbon/kasbondtreport',$data);
		$this->load->view('templates/footer');
	}
    //end bagian halaman/tampilan pertama
    //=====================================

    //=====================================
    // bagian Kasbon
    public function insKasbon()
	{
		$Ym = date('ymd');
		$generateid = $this->Model_online->kode('KB/' . $Ym . '/', 14,'tr_kasbon','KB_ID');
		$KB_ID = $generateid;
		$EMP_ID = $this->session->userdata('EMP_ID');
		$KB_TOTAL_AWAL = 0;
		$data = array(
			"KB_ID" => $KB_ID,
			"EMP_ID" => $EMP_ID,
			"KB_TOTAL_AWAL" => $KB_TOTAL_AWAL
			);
		$this->Model_online->input($data,"tr_kasbon");
        redirect(base_url().'Kasbon/detail/'.str_replace('/','',$KB_ID));
	}
	public function delKasbon(){
		$KB_ID = $this->input->post("delID");
		$this->Model_online->deleteData('tr_kasbon','KB_ID',$KB_ID);
		redirect(base_url().'Kasbon');
    }
    // end bagian kasbon
    //=====================================
    
    //=====================================
    // bagian detail kasbon
    public function insDetKB()
	{
		//ambil setiap post masukkan dalam variable
		$Ym = date('ymd');
		$generateid = $this->Model_online->kode('DKB/' . $Ym . '/', 15,'tr_detail_kasbon','DET_KB_ID');
		$KB_ID = $this->input->post("insID");
		$DET_KB_ITEM = $this->input->post("insNama");
		$DET_KB_VALUE = str_replace('.','',$this->input->post("insHarga"));
		// atur array untuk insert data detail kasbon
		$data = array(
		"DET_KB_ID" => $generateid,
		"KB_ID" => $KB_ID,
		"DET_KB_ITEM" => $DET_KB_ITEM,
		"DET_KB_VALUE" => $DET_KB_VALUE,
		);
		// update total kasbon
		$totalsaatini = $this->input->post("insTotal");
		$dataKB = array(
			"KB_TOTAL_AWAL" => $totalsaatini + $DET_KB_VALUE
			);
		$whereKB = array(
			'KB_ID' => $KB_ID
		);
		$this->Model_online->update($whereKB,$dataKB,"tr_kasbon");
		// action upload dan insert data
		$this->Model_online->input($data,"tr_detail_kasbon");
		redirect(base_url().'Kasbon/detail/'.str_replace('/','',$KB_ID));
    }
    public function delDetKB(){
		
		$DET_KB_ID = $this->input->post("delID");
		$KB_ID = $this->input->post("delIDUtama");
		$DET_KB_VALUE = $this->input->post("delHarga");
		
		$this->Model_online->deleteData('tr_detail_kasbon','DET_KB_ID',$DET_KB_ID);
		// update total kasbon
		$totalsaatini = $this->input->post("delTotal");
		$dataKasbon = array(
			"KB_TOTAL_AWAL" => $totalsaatini - str_replace('.','',$DET_KB_VALUE)
			);
		$whereKasbon = array(
			'KB_ID' => $KB_ID
		);
		$this->Model_online->update($whereKasbon,$dataKasbon,"tr_kasbon");

		redirect(base_url().'Kasbon/detail/'.str_replace('/','',$KB_ID));
    }
    public function upDetKB()
	{
		$DET_KB_ID = $this->input->post("upIDDet");
		$KB_ID = $this->input->post("upID");
		$DET_KB_ITEM = $this->input->post("upNama");
		$DET_KB_VALUE = str_replace('.','',$this->input->post("upHarga"));
		$valueLama = str_replace('.','',$this->input->post("upHargaLama"));
		
		//untuk menghitung/kalibrasi total di tr_kasbon
        $valueBaru = $DET_KB_VALUE - $valueLama;
        $totalsaatini = $this->input->post("upTotal");
        $array1 = array($totalsaatini,$valueBaru);
        $yangdiinput = array_sum($array1);
    
        $data = array(
            "DET_KB_ITEM" => $DET_KB_ITEM,
            "DET_KB_VALUE" => $DET_KB_VALUE,
            );
        $where = array(
            'DET_KB_ID' => $DET_KB_ID
        );
        $this->Model_online->update($where,$data,"tr_detail_kasbon");
        // update total kasbon	
        $dataKB = array(
            "KB_TOTAL_AWAL" => $yangdiinput
            );
        $whereKB = array(
            'KB_ID' => $KB_ID
        );
        $this->Model_online->update($whereKB,$dataKB,"tr_kasbon");
        // end update total 
        clearstatcache();
        redirect(base_url().'Kasbon/detail/'.str_replace('/','',$KB_ID));
    }
    // end bagian detail kasbon
    //=====================================

    //=====================================
    /// Bagian Pengajuan Approval
    public function insAppLeader()
    {
        $Ym = date('ymd');
        $Ymdhis = date('Y-m-d H:i:s');
        $generateid = $this->Model_online->kode('KBP/' . $Ym . '/', 15,'tr_kb_approval','TR_KB_APP_ID');
        $KB_ID = $this->input->post("insAppIdReim");
        // mengambil id session saat ini yg sedang login
        $EMP_ID = $this->session->userdata('EMP_ID');
        //cari siapa leadernya
        $row = $this->db->where('EMP_ID_MEMBER',$EMP_ID)->get('tr_supervision')->row_array();
        $LEADER_ID = $row['EMP_ID_LEADER'];
        // cari email leadernya
        $row2 = $this->db->where('EMP_ID',$LEADER_ID)->get('m_employee')->row_array();
        $leaderEmail = $row2['EMP_EMAIL'];
        // pengecekan doble untuk id_app dan leader yg sama, di insert app
        $wAppLeader = array(
            'KB_ID' => $KB_ID,
            'EMP_ID' => $LEADER_ID,
        );
        $countAppLeader = $this->Model_online->countRowWhere('tr_kb_approval',$wAppLeader);
        if($countAppLeader<=0){
            // masukkan ke dalam tabel tr_kb_approval
            $datax = array(
                "TR_KB_APP_ID" => $generateid,
                "KB_ID" => $KB_ID,
                "EMP_ID" => $LEADER_ID,
                "TR_KB_APP_STATUS" => '0',
                "TR_KB_SUB_DATE" => $Ymdhis,
                );	
            // update tanggal submit di tr_kasbon jika pertama kali approval
            $wApp = array(
                'KB_ID' => $KB_ID
            );
            $countwApp = $this->Model_online->countRowWhere('tr_kb_approval',$wApp);
            $dataKB = array(
				"KB_SUBMIT_DATE" => $Ymdhis,
				"KB_STATUS" => '1'
                );
            $whereKB = array(
                'KB_ID' => $KB_ID
            );
			$this->Model_online->update($whereKB,$dataKB,"tr_kasbon");
				$this->Model_online->input($datax,"tr_kb_approval");
			// BAGIAN EMAIL
			//  ============================================================== set value untuk email
				//pembuatan bagian isi email
				//ambil 1 row data kasbon
				$whereDataKB = array(
					'KB_ID' => $KB_ID,
				);
				$rowKB = $this->Model_online->findSingleDataWhere($whereDataKB,'tr_kasbon');
				//ambil 1 row nama employee
				$whereEmp = array(
					'EMP_ID' => $rowKB['EMP_ID'],
				);
				$rowEmp = $this->Model_online->findSingleDataWhere($whereEmp,'m_employee');
				//ambil nama depart dari EMP_ID
				$whereDep = array(
				'DEPART_ID' => $rowEmp['DEPART_ID'],
				);
				$rowDep = $this->Model_online->findSingleDataWhere($whereDep,'m_department');
				//ambil semua row detail kasbon
				$whereDet = array(
					'KB_ID' => $KB_ID,
				);
				$data['rowDet'] = $this->Model_online->findAllDataWhere($whereDet,'tr_detail_kasbon');
				//penamaan variable
				$to = $leaderEmail;
				$subject = 'Approval Kasbon | '.$rowDep['DEPART_NAME'].' - '.$rowEmp['EMP_FULL_NAME'].' - '.$KB_ID; 
				$data['nama'] = $rowEmp['EMP_FULL_NAME'];
				$data['leader'] = $row2;
				$data['rowKB'] = $rowKB;
				$message = $this->load->view('kasbon/emailkasbon', $data,true);
				// aksi input update email
				
				$this->Model_online->insEmail($to,$subject,$message);
            redirect(base_url().'Kasbon');
        }
        

    }
    public function insAppFA()
    {
        $Ym = date('ymd');
		$Ymdhis = date('Y-m-d H:i:s');
		$generateid = $this->Model_online->kode('KBP/' . $Ym . '/', 15,'tr_kb_approval','TR_KB_APP_ID');
		$KB_ID = $this->input->post("insAppIdReim");
		$insFA = 'EMP/003/009';
		// cari email karyawan FA
		$row2 = $this->db->where('EMP_ID',$insFA)->get('m_employee')->row_array();
		$emailFA = $row2['EMP_EMAIL'];
        // masukkan data ke dalam tabel tr_approval
		$data = array(
			"TR_KB_APP_ID" => $generateid,
			"KB_ID" => $KB_ID,
			"EMP_ID" => 'EMP/003/009',
			"TR_KB_APP_STATUS" => '0',
			"TR_KB_SUB_DATE" => $Ymdhis,
            );	    
        $this->Model_online->input($data,"tr_kb_approval");
        // update tanggal submit di tr_kasbon jika pertama kali approval
        $dataApp = array(
			"KB_SUBMIT_DATE" => $Ymdhis,
			"KB_STATUS" => '3'
            );
        $whereApp = array(
            'KB_ID' => $KB_ID
        );
		$this->Model_online->update($whereApp,$dataApp,"tr_kasbon");
		// BAGIAN EMAIL
			//  ============================================================== set value untuk email
				//pembuatan bagian isi email
				//ambil 1 row data kasbon
				$whereDataKB = array(
					'KB_ID' => $KB_ID,
				);
				$rowKB = $this->Model_online->findSingleDataWhere($whereDataKB,'tr_kasbon');
				//ambil 1 row nama employee
				$whereEmp = array(
					'EMP_ID' => $rowKB['EMP_ID'],
				);
				$rowEmp = $this->Model_online->findSingleDataWhere($whereEmp,'m_employee');
				//ambil nama depart dari EMP_ID
				$whereDep = array(
				'DEPART_ID' => $rowEmp['DEPART_ID'],
				);
				$rowDep = $this->Model_online->findSingleDataWhere($whereDep,'m_department');
				//ambil semua row detail kasbon
				$whereDet = array(
					'KB_ID' => $KB_ID,
				);
				$data['rowDet'] = $this->Model_online->findAllDataWhere($whereDet,'tr_detail_kasbon');
				//penamaan variable
				$to = $emailFA;
				$subject = 'Approval Kasbon | '.$rowDep['DEPART_NAME'].' - '.$rowEmp['EMP_FULL_NAME'].' - '.$KB_ID; 
				$data['nama'] = $rowEmp['EMP_FULL_NAME'];
				$data['leader'] = $row2;
				$data['rowKB'] = $rowKB;
				$message = $this->load->view('kasbon/emailkasbon', $data,true);
				// aksi input update email
				$this->Model_online->insEmail($to,$subject,$message);
		redirect(base_url().'Kasbon');
        }
    // End Bagian Pengajuan Approval
    //=====================================

    //=====================================
    /// Bagian Menyetujui Pengajuan
    public function conApp()
	{
		//setujui dan beri status 1
		$idApp = $this->input->post("idApp");
		$idKB = $this->input->post("idKB");
		$empID = $this->session->userdata('EMP_ID');
		$appDate = date('Y-m-d H:i:s');
		$statusApp = '1';
		$newID1 = substr($idApp,0,3);
        $newID2 = substr($idApp,3,6);
        $newID3 = substr($idApp,9,4);
		$newnew = $newID1.'/' .$newID2.'/'.$newID3;
		// masukkan approval lanjutan(approval baru)
		$Ym = date('ymd');
		$generateid = $this->Model_online->kode('KBP/' . $Ym . '/', 15,'tr_kb_approval','TR_KB_APP_ID');
		$TR_APP_ID = $generateid;
		$row = $this->db->where('EMP_ID_MEMBER',$empID)->get('tr_supervision')->row_array();
		$LEADER_ID = $row['EMP_ID_LEADER'];
		//$idLeader = $rowSp['EMP_ID_LEADER'];
		// cari email leadernya
		$row2 = $this->db->where('EMP_ID',$LEADER_ID)->get('m_employee')->row_array();
		$leaderEmail = $row2['EMP_EMAIL'];
		// pengecekan doble untuk status yg sudah lebih dari 0 atau sudah ada tindakan
		$wAppStatus = array(
			'TR_KB_APP_ID' => $newnew,
			'EMP_ID' => $empID,
			'TR_KB_APP_STATUS !=' => '0',
		);
		$countAppStatus = $this->Model_online->countRowWhere('tr_kb_approval',$wAppStatus);
		// pengecekan doble untuk id_app dan leader yg sama, di insert app
		$wAppLeader = array(
			'KB_ID' => $idKB,
			'EMP_ID' => $LEADER_ID,
		);
		$countAppLeader = $this->Model_online->countRowWhere('tr_kb_approval',$wAppLeader);
		if($countAppLeader<=0 && $countAppStatus<=0){
			//setujui dan beri status 1
			$data = array(
				"TR_KB_APP_DATE" => $appDate,
				"TR_KB_APP_STATUS" => $statusApp,
			);
			$where = array(
				'TR_KB_APP_ID' => $newnew
			);
			$this->Model_online->update($where,$data,"tr_kb_approval");
			// masukkan ke dalam tabel tr_approval
			$data = array(
				"TR_KB_APP_ID" => $TR_APP_ID,
				"KB_ID" => $idKB,
				"EMP_ID" => $LEADER_ID,
				"TR_KB_APP_STATUS" => '0',
				"TR_KB_SUB_DATE" => $appDate,
				);	
			$this->Model_online->input($data,"tr_kb_approval");
			$dataKasbon = array(
				"KB_APP_DATE" => $appDate,
				"KB_STATUS" => '1'
				);
			$whereKasbon = array(
				'KB_ID' => $idKB,
			);
			$this->Model_online->update($whereKasbon,$dataKasbon,"tr_kasbon");
			// BAGIAN EMAIL
			//  ============================================================== set value untuk email
				//pembuatan bagian isi email
				//ambil 1 row data kasbon
				$whereDataKB = array(
					'KB_ID' => $idKB,
				);
				$rowKB = $this->Model_online->findSingleDataWhere($whereDataKB,'tr_kasbon');
				//ambil 1 row nama employee
				$whereEmp = array(
					'EMP_ID' => $rowKB['EMP_ID'],
				);
				$rowEmp = $this->Model_online->findSingleDataWhere($whereEmp,'m_employee');
				//ambil nama depart dari EMP_ID
				$whereDep = array(
				'DEPART_ID' => $rowEmp['DEPART_ID'],
				);
				$rowDep = $this->Model_online->findSingleDataWhere($whereDep,'m_department');
				//ambil semua row detail kasbon
				$whereDet = array(
					'KB_ID' => $idKB,
				);
				$data['rowDet'] = $this->Model_online->findAllDataWhere($whereDet,'tr_detail_kasbon');
				//penamaan variable
				$to = $leaderEmail;
				$subject = 'Approval Kasbon | '.$rowDep['DEPART_NAME'].' - '.$rowEmp['EMP_FULL_NAME'].' - '.$idKB; 
				$data['nama'] = $rowEmp['EMP_FULL_NAME'];
				$data['leader'] = $row2;
				$data['rowKB'] = $rowKB;
				$message = $this->load->view('kasbon/emailkasbon', $data,true);
				// aksi input update email
				$this->Model_online->insEmail($to,$subject,$message);
			//redirect ke halaman awal
			redirect(base_url().'Kasbon/approval');
		}else{
			// bikin tampilan error data telah di proses harap cek kembali
			// redirect ke halaman approval
			redirect(base_url().'Kasbon/approval');
		}
	}
	public function finalApp()
	{
		//setujui dan beri status 1 untuk menyetujui
		$idApp = $this->input->post("idApp");
		$idKB = $this->input->post("idKB");
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
		$generateid = $this->Model_online->kode('KBP/' . $Ym . '/', 15,'tr_kb_approval','TR_KB_APP_ID');
		$TR_APP_ID = $generateid;
		//$MEMBER_FA = $this->input->post("insFA");
		$MEMBER_FA = 'EMP/003/009';//sementara
		$row2 = $this->db->where('EMP_ID',$MEMBER_FA)->get('m_employee')->row_array();
		$emailFA = $row2['EMP_EMAIL'];
		// pengecekan doble untuk status yg sudah lebih dari 0 atau sudah ada tindakan
		$wAppStatus = array(
			'TR_KB_APP_ID' => $newnew,
			'EMP_ID' => $empID,
			'TR_KB_APP_STATUS !=' => '0',
		);
		$countAppStatus = $this->Model_online->countRowWhere('tr_kb_approval',$wAppStatus);
		// pengecekan doble untuk id_app dan leader yg sama, di insert app
		$wAppFA = array(
			'KB_ID' => $idKB,
			'EMP_ID' => $MEMBER_FA,
		);
		$countAppFA = $this->Model_online->countRowWhere('tr_kb_approval',$wAppFA);
		if($countAppFA<=0 && $countAppStatus<=0){
			//setujui dan beri status 1
			$data = array(
				"TR_KB_APP_DATE" => $appDate,
				"TR_KB_APP_STATUS" => $statusApp,
			);
			$where = array(
				'TR_KB_APP_ID' => $newnew
			);
			$this->Model_online->update($where,$data,"tr_kb_approval");
			// masukkan ke dalam tabel tr_approval
			$data = array(
				"TR_KB_APP_ID" => $TR_APP_ID,
				"KB_ID" => $idKB,
				"EMP_ID" => 'EMP/003/009',
				"TR_KB_APP_STATUS" => '0',
				"TR_KB_SUB_DATE" => $appDate,
				);	
			$this->Model_online->input($data,"tr_kb_approval");
			$dataKasbon = array(
				"KB_STATUS" => '3'
				);
			$whereKasbon = array(
				'KB_ID' => $idKB,
			);
			$this->Model_online->update($whereKasbon,$dataKasbon,"tr_kasbon");
			// BAGIAN EMAIL
			//  ============================================================== set value untuk email
				//pembuatan bagian isi email
				//ambil 1 row data kasbon
				$whereDataKB = array(
					'KB_ID' => $idKB,
				);
				$rowKB = $this->Model_online->findSingleDataWhere($whereDataKB,'tr_kasbon');
				//ambil 1 row nama employee
				$whereEmp = array(
					'EMP_ID' => $rowKB['EMP_ID'],
				);
				$rowEmp = $this->Model_online->findSingleDataWhere($whereEmp,'m_employee');
				//ambil nama depart dari EMP_ID
				$whereDep = array(
				'DEPART_ID' => $rowEmp['DEPART_ID'],
				);
				$rowDep = $this->Model_online->findSingleDataWhere($whereDep,'m_department');
				//ambil semua row detail kasbon
				$whereDet = array(
					'KB_ID' => $idKB,
				);
				$data['rowDet'] = $this->Model_online->findAllDataWhere($whereDet,'tr_detail_kasbon');
				//penamaan variable
				$to = $emailFA;
				$subject = 'Approval Kasbon | '.$rowDep['DEPART_NAME'].' - '.$rowEmp['EMP_FULL_NAME'].' - '.$idKB; 
				$data['nama'] = $rowEmp['EMP_FULL_NAME'];
				$data['leader'] = $row2;
				$data['rowKB'] = $rowKB;
				$message = $this->load->view('kasbon/emailkasbon', $data,true);
				// aksi input update email
				$this->Model_online->insEmail($to,$subject,$message);
			redirect(base_url().'Kasbon/approval');
		}else{
			//tampilkan error data telah diproses harap cek kembali
			redirect(base_url().'Kasbon/approval');
			//redirect ke approval
		}
		
	}
	public function finalAppFA()
	{
		//setujui dan beri status 1
		$idApp = $this->input->post("idApp");
		$idKB = $this->input->post("idKB");

		if(!empty($this->input->post("tglRealisasi"))){
			$tfDate = $this->input->post("tglRealisasi");
			$myWhere = array(
				'KB_ID' => $idKB
			);
			$myData = array(
				'KB_TRANSFER_DATE' => $tfDate
			);
			$this->Model_online->update($myWhere,$myData,"tr_kasbon");
		}

		$appDate = date('Y-m-d H:i:s');
		$statusApp = '4';
		$newID1 = substr($idApp,0,3);
        $newID2 = substr($idApp,3,6);
        $newID3 = substr($idApp,9,4);
		$newnew = $newID1.'/' .$newID2.'/'.$newID3;
		// pengecekan doble untuk id_app dan leader yg sama dan status lebih dari 0, di insert app
		$wAppFinal = array(
			'KB_ID' => $idKB,
			'TR_KB_APP_ID' => $newnew,
			'TR_KB_APP_STATUS !=' => '0'
		);
		$cAppFinal = $this->Model_online->countRowWhere('tr_kb_approval',$wAppFinal);
		if($cAppFinal<=0){
			$data = array(
				"TR_KB_APP_DATE" => $appDate,
				"TR_KB_APP_STATUS" => $statusApp,
			);
			$where = array(
				'TR_KB_APP_ID' => $newnew
			);
			$this->Model_online->update($where,$data,"tr_kb_approval");
			$dataKasbon = array(
				"KB_APP_DATE" => $appDate,
				"KB_STATUS" => '4'
				);
			$whereKasbon = array(
				'KB_ID' => $idKB,
			);
			$this->Model_online->update($whereKasbon,$dataKasbon,"tr_kasbon");
			//redirect ke halaman awal
			redirect(base_url().'Kasbon/Approval');
		}else{
			//tampilkan error data telah diproses harap cek kembali

			//redirect ke approval
			redirect(base_url().'Kasbon/Approval');
		}
		
	}
	public function denyApp()
	{
		//setujui dan beri status 1
		$idApp = $this->input->post("idApp");
		$idKB = $this->input->post("idKB");
		$alasantolak = $this->input->post("alasantolak");
		$empID = $this->session->userdata('EMP_ID');
		$appDate = date('Y-m-d H:i:s');
		$statusApp = '2';
		$newID1 = substr($idApp,0,3);
        $newID2 = substr($idApp,3,6);
        $newID3 = substr($idApp,9,4);
		$newnew = $newID1.'/' .$newID2.'/'.$newID3;
		// pengecekan doble untuk id_app dan leader yg sama dan status lebih dari 0, di insert app
		$wAppDeny = array(
			'KB_ID' => $idKB,
			'TR_KB_APP_ID' => $newnew,
			'TR_KB_APP_STATUS !=' => '0'
		);
		$cAppDeny = $this->Model_online->countRowWhere('tr_kb_approval',$wAppDeny);
		if($cAppDeny<=0){
			$data = array(
				"TR_KB_APP_DATE" => $appDate,
				"TR_KB_APP_STATUS" => $statusApp,
				"TR_APP_COMMENT" => $alasantolak
			);
			$where = array(
				'TR_KB_APP_ID' => $newnew
			);
			$this->Model_online->update($where,$data,"tr_kb_approval");
			$dataKasbon = array(
				"KB_APP_DATE" => $appDate,
				"KB_STATUS" => '2'
				);
			$whereKasbon = array(
				'KB_ID' => $idKB,
			);
			$this->Model_online->update($whereKasbon,$dataKasbon,"tr_kasbon");
			//redirect ke halaman awal
			redirect(base_url().'Kasbon/Approval');
		}else{
			//beri error
			//redirect
			redirect(base_url().'Kasbon/Approval');
		}
	}
    /// end bagian menyetujui pengajuan
	// ====================================

	// ====================================
	/// Bagian Reporting
	public function insReport()
	{
		//ambil setiap post masukkan dalam variable
		$Ym = date('ymd');
		$KB_ID = $this->input->post("insIDKB");
		$DET_KB_ID = $this->input->post("insIDDet");
		$DET_KB_VALUE_AWAL = str_replace('.','',$this->input->post("insValueAwal"));
		$DET_KB_VALUE_AKHIR = str_replace('.','',$this->input->post("insValueAkhir"));
		$DET_KB_PHOTO = str_replace('/','',$DET_KB_ID).".jpg";
		// atur config untuk upload
		$config['upload_path']          = './assets/doc-kasbon/';
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		$config['max_size']             = 8048;
		$config['file_name']            = str_replace('/','',$DET_KB_ID).'.jpg';
		$this->load->library('upload', $config);
		// update tabel tr_detail_kasbon untuk reporting
		$data = array(
			"DET_KB_END_VALUE" => $DET_KB_VALUE_AKHIR,
			"DET_KB_DIFF" =>  $DET_KB_VALUE_AWAL - $DET_KB_VALUE_AKHIR,
			"DET_KB_PHOTO" => $DET_KB_PHOTO,
		);
		$whereData = array(
			"DET_KB_ID" => $DET_KB_ID,
		);
		$this->Model_online->update($whereData,$data,"tr_detail_kasbon");
		// update total tr_kasbon
		$totalKasbonAkhir = $this->input->post("insTotalAkhir");
		$totalKasbonAwal = $this->input->post("insTotalAwal");
		$dataKasbon = array(
			"KB_TOTAL_AKHIR" => $totalKasbonAkhir + $DET_KB_VALUE_AKHIR,
			"KB_DIFF" => $totalKasbonAwal - ($totalKasbonAkhir + $DET_KB_VALUE_AKHIR),
			);
		$whereKasbon = array(
			'KB_ID' => $KB_ID
		);
		$this->Model_online->update($whereKasbon,$dataKasbon,"tr_kasbon");
		// upload foto dan kecilkan ukuran foto
		if($this->upload->do_upload('insNota')){
			$dataUpload = $this->upload->data();
			$this->image_lib->initialize(array(
				'image_library' => 'gd2', //library yang kita gunakan
				'source_image' => './assets/doc-kasbon/'. $dataUpload['file_name'],
				'maintain_ratio' => TRUE,
				'create_thumb' => FALSE,
				'width' => 900,
				'height' => 900,
				'new_image' => './assets/doc-kasbon/'. $dataUpload['file_name'],
			));
			$this->image_lib->resize();
		}
		redirect(base_url().'Kasbon/report/'.str_replace('/','',$KB_ID));
    }
    public function upReport()
	{
		$DET_KB_ID = $this->input->post("upIDDet");
		$KB_ID = $this->input->post("upIDKB");
		$DET_KB_VALUE_AWAL = str_replace('.','',$this->input->post("upValueAwal"));
		$DET_KB_VALUE_AKHIR_LAMA = str_replace('.','',$this->input->post("upValueAkhirLama"));
		$DET_KB_VALUE_AKHIR_BARU = str_replace('.','',$this->input->post("upValueAkhir"));
		
		$DET_KB_PHOTO = str_replace('/','',$DET_KB_ID).".jpg";
		// untuk menghitung/kalibrasi total di tr_reimburse
		 	$valueBaru = $DET_KB_VALUE_AKHIR_BARU - $DET_KB_VALUE_AKHIR_LAMA;
			$KB_TOTAL_AWAL = str_replace('.','',$this->input->post("upTotalAwal"));
			$KB_TOTAL_AKHIR = str_replace('.','',$this->input->post("upTotalAkhir")); 
			$array1 = array($KB_TOTAL_AKHIR,$valueBaru);
			$yangdiinput = array_sum($array1);
		
		// atur config untuk upload
		$config['upload_path']          = './assets/doc-kasbon/';
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		$config['max_size']             = 8048;
		$config['file_name']            = str_replace('/','',$DET_KB_ID).'.jpg';
		$this->load->library('upload', $config);
		
		if($_FILES['upNota']['name'] <> ""){
			$path = "./assets/doc-kasbon/".str_replace('/','',$DET_KB_ID).".jpg";
			unlink($path);
			$data = array(
				"DET_KB_END_VALUE" => $DET_KB_VALUE_AKHIR_BARU,
				"DET_KB_DIFF" => $DET_KB_VALUE_AWAL - $DET_KB_VALUE_AKHIR_BARU,
				"DET_KB_PHOTO" => $DET_KB_PHOTO
				);
			$where = array(
				'DET_KB_ID' => $DET_KB_ID
			);
			if($this->upload->do_upload('upNota')){
				$dataUpload = $this->upload->data();
				$this->image_lib->initialize(array(
					'image_library' => 'gd2', //library yang kita gunakan
					'source_image' => './assets/doc-kasbon/'. $dataUpload['file_name'],
					'maintain_ratio' => TRUE,
					'create_thumb' => FALSE,
					'width' => 900,
					'height' => 900,
					'new_image' => './assets/doc-kasbon/'. $dataUpload['file_name'],
				));
				$this->image_lib->resize();
			}	
			$this->Model_online->update($where,$data,"tr_detail_kasbon");
			// update total reimburse	
			$dataKasbon = array(
				"KB_TOTAL_AKHIR" => $yangdiinput,
				"KB_DIFF" => $KB_TOTAL_AWAL - $yangdiinput, 
				);
			$whereKasbon = array(
				'KB_ID' => $KB_ID
			);
			$this->Model_online->update($whereKasbon,$dataKasbon,"tr_kasbon");
			// end update total reimburse
			clearstatcache();
			redirect(base_url().'Kasbon/report/'.str_replace('/','',$KB_ID));
		}else{
			$data = array(
				"DET_KB_END_VALUE" => $DET_KB_VALUE_AKHIR_BARU,
				"DET_KB_DIFF" => $DET_KB_VALUE_AWAL - $DET_KB_VALUE_AKHIR_BARU,
				);
			$where = array(
				'DET_KB_ID' => $DET_KB_ID
			);	
			$this->Model_online->update($where,$data,"tr_detail_kasbon");
			// update total reimburse	
			$dataKasbon = array(
				"KB_TOTAL_AKHIR" => $yangdiinput,
				"KB_DIFF" => $KB_TOTAL_AWAL - $yangdiinput, 
				);
			$whereKasbon = array(
				'KB_ID' => $KB_ID
			);
			$this->Model_online->update($whereKasbon,$dataKasbon,"tr_kasbon");
			// end update total reimburse
			clearstatcache();
			redirect(base_url().'Kasbon/report/'.str_replace('/','',$KB_ID));
		} 
	}
	public function sendReport()
    {
        $Ymdhis = date('Y-m-d H:i:s');   
		$KB_ID = $this->input->post("sendID");
		$MEMBER_FA = 'EMP/003/009';//sementara
		// $MANAJER_FA = $this->db->where('Dr
		$row2 = $this->db->where('EMP_ID',$MEMBER_FA)->get('m_employee')->row_array();
		$emailFA = $row2['EMP_EMAIL'];
		$dataKB = array(
			"KB_REPORT_DATE" => $Ymdhis,
			"KB_STATUS" => '5'
			);
		$whereKB = array(
			'KB_ID' => $KB_ID
		);
		$this->Model_online->update($whereKB,$dataKB,"tr_kasbon");
		// BAGIAN EMAIL
			//  ============================================================== set value untuk email
				//pembuatan bagian isi email
				//ambil 1 row data kasbon
				$whereDataKB = array(
					'KB_ID' => $KB_ID,
				);
				$rowKB = $this->Model_online->findSingleDataWhere($whereDataKB,'tr_kasbon');
				//ambil 1 row nama employee
				$whereEmp = array(
					'EMP_ID' => $rowKB['EMP_ID'],
				);
				$rowEmp = $this->Model_online->findSingleDataWhere($whereEmp,'m_employee');
				//ambil nama depart dari EMP_ID
				$whereDep = array(
				'DEPART_ID' => $rowEmp['DEPART_ID'],
				);
				$rowDep = $this->Model_online->findSingleDataWhere($whereDep,'m_department');
				//ambil semua row detail kasbon
				$whereDet = array(
					'KB_ID' => $KB_ID,
				);
				$data['rowDet'] = $this->Model_online->findAllDataWhere($whereDet,'tr_detail_kasbon');
				//penamaan variable
				$to = $emailFA;
				$subject = 'Kelengkapan Laporan Kasbon | '.$rowDep['DEPART_NAME'].' - '.$rowEmp['EMP_FULL_NAME'].' - '.$KB_ID; 
				$data['nama'] = $rowEmp['EMP_FULL_NAME'];
				$data['leader'] = $row2;
				$data['rowKB'] = $rowKB;
				$message = $this->load->view('kasbon/emailreport', $data,true);
				// aksi input update email
				$this->Model_online->insEmail($to,$subject,$message);
		redirect(base_url().'Kasbon');
	}
    //belum dikerjakan  
	public function remindReport()
    {
        $Ym = date('ymd');
        $Ymdhis = date('Y-m-d H:i:s');
        $generateid = $this->Model_online->kode('KBP/' . $Ym . '/', 15,'tr_kb_approval','TR_KB_APP_ID');
        
        $KB_ID = $this->input->post("insAppIdReim");
        // mengambil id session saat ini yg sedang login
        $EMP_ID = $this->session->userdata('EMP_ID');
        //cari siapa leadernya
        $row = $this->db->where('EMP_ID_MEMBER',$EMP_ID)->get('tr_supervision')->row_array();
        $LEADER_ID = $row['EMP_ID_LEADER'];
        // cari email leadernya
        $row2 = $this->db->where('EMP_ID',$LEADER_ID)->get('m_employee')->row_array();
        $leaderEmail = $row2['EMP_EMAIL'];
        // pengecekan doble untuk id_app dan leader yg sama, di insert app
        $wAppLeader = array(
            'KB_ID' => $KB_ID,
            'EMP_ID' => $LEADER_ID,
        );
        $countAppLeader = $this->Model_online->countRowWhere('tr_kb_approval',$wAppLeader);
        if($countAppLeader<=0){
            // masukkan ke dalam tabel tr_kb_approval
            $datax = array(
                "TR_KB_APP_ID" => $generateid,
                "KB_ID" => $KB_ID,
                "EMP_ID" => $LEADER_ID,
                "TR_KB_APP_STATUS" => '0',
                "TR_KB_SUB_DATE" => $Ymdhis,
                );	
            // update tanggal submit di tr_kasbon jika pertama kali approval
            $wApp = array(
                'KB_ID' => $KB_ID
            );
            $countwApp = $this->Model_online->countRowWhere('tr_kb_approval',$wApp);
            $dataKB = array(
				"KB_SUBMIT_DATE" => $Ymdhis,
				"KB_STATUS" => '1'
                );
            $whereKB = array(
                'KB_ID' => $KB_ID
            );
            $this->Model_online->update($whereKB,$dataKB,"tr_kasbon");
            $this->Model_online->input($datax,"tr_kb_approval");
            redirect(base_url().'Kasbon');
        }
        

	}
	/// end bagian reporting
	// ====================================

	// ====================================
	/// Bagian Detail Realisasi
	public function insReal()
	{
		//ambil setiap post masukkan dalam variable
		$Ym = date('ymd');
		$generateid = $this->Model_online->kode('DRP/' . $Ym . '/', 15,'tr_detail_real','REAL_ID');
		$DET_KB_ID = $this->input->post("insDetKBID");
		$REAL_NAME = $this->input->post("insRealName");
		$REAL_VALUE = $this->input->post("insRealValue");
		// $DET_KB_VALUE_AWAL = str_replace('.','',$this->input->post("insValueAwal"));
		// $DET_KB_VALUE_AKHIR = str_replace('.','',$this->input->post("insValueAkhir"));
		$REAL_PHOTO = str_replace('/','',$generateid).".jpg";
		// atur config untuk upload
		$config['upload_path']          = './assets/doc-kasbon/';
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		$config['max_size']             = 8048;
		$config['file_name']            = str_replace('/','',$generateid).'.jpg';
		$this->load->library('upload', $config);
		// update tabel tr_detail_real
		$data = array(
			"REAL_ID" => $generateid,
			"DET_KB_ID" => $DET_KB_ID,
			"REAL_NAME" =>  $REAL_NAME,
			"REAL_VALUE" => str_replace('.','',$REAL_VALUE),
			"REAL_PHOTO" => $REAL_PHOTO,
		);
		$this->Model_online->input($data,'tr_detail_real');
		
		// ============ update total tr_detail_kasbon
		// cari detail_kasbon saat ini
		$whereDt = array(
			'DET_KB_ID' => $DET_KB_ID,
			);
        $dtkasbon = $this->Model_online->findSingleDataWhere($whereDt,'tr_detail_kasbon');
		$queryRl = $this->db->query("select SUM(tdk.	REAL_VALUE) as rp_value from tr_detail_real tdk where DET_KB_ID = '".$DET_KB_ID."'");
      	$sumRl = $queryRl->row()->rp_value;
		// end cari detail_kasbon saat ini
		// ditambahkan dengan value saat ini dan di update
		$dataUpDt = array(
			"DET_KB_END_VALUE" => $sumRl,
			"DET_KB_DIFF" => $dtkasbon['DET_KB_VALUE'] - $sumRl,
			);
		$whereUpDt = array(
			'DET_KB_ID' => $DET_KB_ID
		);
		$this->Model_online->update($whereUpDt,$dataUpDt,"tr_detail_kasbon");
		// end ditambahkan dengan value saat ini dan di update
		// ============ end update total tr_detail_kasbon

		// ============ update total tr_kasbon
		// cari detail_kasbon saat ini
		$whereKb = array(
			'KB_ID' => $dtkasbon['KB_ID'],
			);
        $kasbon = $this->Model_online->findSingleDataWhere($whereKb,'tr_kasbon');
		$queryKb = $this->db->query("select SUM(tdk.DET_KB_END_VALUE) as rp_value from tr_detail_kasbon tdk where KB_ID = '".$dtkasbon['KB_ID']."'");
      	$sumKb = $queryKb->row()->rp_value;
		// end cari detail_kasbon saat ini
		// ditambahkan dengan value saat ini dan di update
		$dataUpKB = array(
			"KB_TOTAL_AKHIR" => $sumKb,
			"KB_DIFF" => $kasbon['KB_TOTAL_AWAL'] - $sumKb,
			);
		$whereUpKB = array(
			'KB_ID' => $dtkasbon['KB_ID']
		);
		$this->Model_online->update($whereUpKB,$dataUpKB,"tr_kasbon");
		
		// end ditambahkan dengan value saat ini dan di update
		// ============ end update total tr_detail_kasbon

		// upload foto dan kecilkan ukuran foto
		if($this->upload->do_upload('insNota')){
			$dataUpload = $this->upload->data();
			$this->image_lib->initialize(array(
				'image_library' => 'gd2', //library yang kita gunakan
				'source_image' => './assets/doc-kasbon/'. $dataUpload['file_name'],
				'maintain_ratio' => TRUE,
				'create_thumb' => FALSE,
				'width' => 900,
				'height' => 900,
				'new_image' => './assets/doc-kasbon/'. $dataUpload['file_name'],
			));
			$this->image_lib->resize();
		}
		redirect(base_url().'Kasbon/dtreport/'.str_replace('/','',$DET_KB_ID));
    }
	public function upReal()
	{
		$REAL_ID = $this->input->post("upIDReal");
		$REAL_NAME = $this->input->post("upNama");
		$REAL_VALUE = str_replace('.','',$this->input->post("upValue"));
		$DET_KB_ID = $this->input->post("insDetKBID");
		$REAL_PHOTO = str_replace('/','',$REAL_ID).".jpg";

		// cari detail_kasbon saat ini
		$whereDt = array(
			'DET_KB_ID' => $DET_KB_ID,
			);
        $dtkasbon = $this->Model_online->findSingleDataWhere($whereDt,'tr_detail_kasbon');
		// end cari detail_kasbon saat ini
		// cari kasbon saat ini
		$whereKB = array(
			'KB_ID' => $dtkasbon['KB_ID'],
			);
        $kasbon = $this->Model_online->findSingleDataWhere($whereKB,'tr_kasbon');
		// end cari kasbon saat ini

		// atur config untuk upload
		$config['upload_path']          = './assets/doc-kasbon/';
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		$config['max_size']             = 8048;
		$config['file_name']            = str_replace('/','',$REAL_ID).'.jpg';
		$this->load->library('upload', $config);
		
		if($_FILES['upNota']['name'] <> ""){
			$path = "./assets/doc-kasbon/".str_replace('/','',$REAL_ID).".jpg";
			unlink($path);
			$dataReal = array(
				"REAL_NAME" => $REAL_NAME,
				"REAL_VALUE" => $REAL_VALUE,
				"REAL_PHOTO" => $REAL_PHOTO,
				);
			$whereReal = array(
				'REAL_ID' => $REAL_ID
			);
			if($this->upload->do_upload('upNota')){
				$dataUpload = $this->upload->data();
				$this->image_lib->initialize(array(
					'image_library' => 'gd2', //library yang kita gunakan
					'source_image' => './assets/doc-kasbon/'. $dataUpload['file_name'],
					'maintain_ratio' => TRUE,
					'create_thumb' => FALSE,
					'width' => 900,
					'height' => 900,
					'new_image' => './assets/doc-kasbon/'. $dataUpload['file_name'],
				));
				$this->image_lib->resize();
			}	
			$this->Model_online->update($whereReal,$dataReal,"tr_detail_real");
			
			// update total detail kasbon
			$queryRl = $this->db->query("select SUM(tdk.REAL_VALUE) as rp_value from tr_detail_real tdk where DET_KB_ID = '".$DET_KB_ID."'");
      		$sumRl = $queryRl->row()->rp_value;
			$datadt = array(
				"DET_KB_END_VALUE" => $sumRl,
				"DET_KB_DIFF" => $dtkasbon['DET_KB_VALUE'] - $sumRl, 
				);
			$wheredt = array(
				'DET_KB_ID' => $DET_KB_ID
			);
			$this->Model_online->update($wheredt,$datadt,"tr_detail_kasbon");
			// end update total detail kasbon
			// update total kasbon	
			$queryKb = $this->db->query("select SUM(tdk.DET_KB_END_VALUE) as rp_value from tr_detail_kasbon tdk where KB_ID = '".$dtkasbon['KB_ID']."'");
      		$sumKb = $queryKb->row()->rp_value;
			$dataupKB = array(
				"KB_TOTAL_AKHIR" => $sumKb,
				"KB_DIFF" => $dtkasbon['DET_KB_VALUE'] - $sumKb, 
				);
			$whereupKB = array(
				'KB_ID' => $kasbon['KB_ID'],
			);
			$this->Model_online->update($whereupKB,$dataupKB,"tr_kasbon");
			// end update total kasbon
			clearstatcache();
			redirect(base_url().'Kasbon/dtreport/'.str_replace('/','',$DET_KB_ID));
		}else{
			$dataReal = array(
				"REAL_NAME" => $REAL_NAME,
				"REAL_VALUE" => $REAL_VALUE,
				"REAL_PHOTO" => $REAL_PHOTO,
				);
			$whereReal = array(
				'REAL_ID' => $REAL_ID
			);	
			$this->Model_online->update($whereReal,$dataReal,"tr_detail_real");
			// update total detail kasbon
			$queryRl = $this->db->query("select SUM(tdk.REAL_VALUE) as rp_value from tr_detail_real tdk where DET_KB_ID = '".$DET_KB_ID."'");
      		$sumRl = $queryRl->row()->rp_value;
			$datadt = array(
				"DET_KB_END_VALUE" => $sumRl,
				"DET_KB_DIFF" => $dtkasbon['DET_KB_VALUE'] - $sumRl, 
				);
			$wheredt = array(
				'DET_KB_ID' => $DET_KB_ID
			);
			$this->Model_online->update($wheredt,$datadt,"tr_detail_kasbon");
			// end update total detail kasbon
			// update total kasbon	
			$queryKb = $this->db->query("select SUM(tdk.DET_KB_END_VALUE) as rp_value from tr_detail_kasbon tdk where KB_ID = '".$dtkasbon['KB_ID']."'");
      		$sumKb = $queryKb->row()->rp_value;
			$dataupKB = array(
				"KB_TOTAL_AKHIR" => $sumKb,
				"KB_DIFF" => $dtkasbon['DET_KB_VALUE'] - $sumKb, 
				);
			$whereupKB = array(
				'KB_ID' => $kasbon['KB_ID'],
			);
			$this->Model_online->update($whereupKB,$dataupKB,"tr_kasbon");
			// end update total kasbon
			clearstatcache();
			redirect(base_url().'Kasbon/dtreport/'.str_replace('/','',$DET_KB_ID));
		}
    }
	public function delReal()
	{
		//inisiasi data POST
		$REAL_ID = $this->input->post("delIDReal");
		$DET_KB_ID = $this->input->post("delDetKBID");
		// cari detail_kasbon saat ini
		$whereDt = array(
			'DET_KB_ID' => $DET_KB_ID,
			);
        $dtkasbon = $this->Model_online->findSingleDataWhere($whereDt,'tr_detail_kasbon');
		// end cari detail_kasbon saat ini
		// cari kasbon saat ini
		$whereKB = array(
			'KB_ID' => $dtkasbon['KB_ID'],
			);
        $kasbon = $this->Model_online->findSingleDataWhere($whereKB,'tr_kasbon');
		// end cari kasbon saat ini
		//delete data dan delete file foto
		$path = "./assets/doc-kasbon/".str_replace('/','',$REAL_ID).".jpg";
		unlink($path);
		$this->Model_online->deleteData('tr_detail_real','REAL_ID',$REAL_ID);
		//end delete data dan delete file foto
		// update total detail kasbon
		$queryRl = $this->db->query("select SUM(tdk.REAL_VALUE) as rp_value from tr_detail_real tdk where DET_KB_ID = '".$DET_KB_ID."'");
		$sumRl = $queryRl->row()->rp_value;
		$datadt = array(
			"DET_KB_END_VALUE" => $sumRl,
			"DET_KB_DIFF" => $dtkasbon['DET_KB_VALUE'] - $sumRl, 
			);
		$wheredt = array(
			'DET_KB_ID' => $DET_KB_ID
		);
		$this->Model_online->update($wheredt,$datadt,"tr_detail_kasbon");
		// end update total detail kasbon
		// update total kasbon	
		$queryKb = $this->db->query("select SUM(tdk.DET_KB_END_VALUE) as rp_value from tr_detail_kasbon tdk where KB_ID = '".$dtkasbon['KB_ID']."'");
		$sumKb = $queryKb->row()->rp_value;
		$dataupKB = array(
			"KB_TOTAL_AKHIR" => $sumKb,
			"KB_DIFF" => $dtkasbon['DET_KB_VALUE'] - $sumKb, 
			);
		$whereupKB = array(
			'KB_ID' => $kasbon['KB_ID'],
		);
		$this->Model_online->update($whereupKB,$dataupKB,"tr_kasbon");
		// end update total kasbon
		clearstatcache();
		redirect(base_url().'Kasbon/dtreport/'.str_replace('/','',$DET_KB_ID));
    }
	/// End bagian Detail realisasi
	// ====================================

	// ====================================
	/// Bagian Approval Realisasi
	public function denyAppReal()
	{
		//setujui dan beri status 7
		$idKB = $this->input->post("idKasbon");
		$dataKasbon = array(
			"KB_STATUS" => '7'
			);
		$whereKasbon = array(
			'KB_ID' => $idKB,
		);
		$this->Model_online->update($whereKasbon,$dataKasbon,"tr_kasbon");
		//redirect ke halaman awal
		redirect(base_url().'Kasbon/approval');
	}
	public function AccAppReal()
	{
		//setujui dan beri status 7
		$idKB = $this->input->post("idKasbon");
		$dataKasbon = array(
			"KB_STATUS" => '6'
			);
		$whereKasbon = array(
			'KB_ID' => $idKB,
		);
		$this->Model_online->update($whereKasbon,$dataKasbon,"tr_kasbon");
		//redirect ke halaman awal
		redirect(base_url().'Kasbon/approval');
	}

	// Persetujuan Final Dari Yg tidak punya atasan lagi (top)
	public function finalApprovalMngFa()
	{
		//setujui dan beri status 1 untuk menyetujui
		$idApp = $this->input->post("idApp");
		$idReim = $this->input->post("idKB");
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
		$generateid = $this->Model_online->kode('KBP/' . $Ym . '/', 15,'tr_kb_approval','TR_KB_APP_ID');
		$TR_APP_ID = $generateid;
		//$MEMBER_FA = $this->input->post("insFA");
		$MEMBER_FA = 'EMP/003/002';//sementara
		$row2 = $this->db->where('EMP_ID',$MEMBER_FA)->get('m_employee')->row_array();
		$emailFA = $row2['EMP_EMAIL'];
		// pengecekan doble untuk status yg sudah lebih dari 0 atau sudah ada tindakan
		$wAppStatus = array(
			'TR_KB_APP_ID' => $newnew,
			'EMP_ID' => $empID,
			'TR_KB_APP_STATUS !=' => '0',
		);
		$countAppStatus = $this->Model_online->countRowWhere('tr_kb_approval',$wAppStatus);
		// pengecekan doble untuk id_app dan leader yg sama, di insert app
		$wAppFA = array(
			'KB_ID' => $idReim,
			'EMP_ID' => $MEMBER_FA,
		);
		$countAppFA = $this->Model_online->countRowWhere('tr_kb_approval',$wAppFA);
		if($countAppFA<=0 && $countAppStatus<=0){
			//setujui dan beri status 1
			$data = array(
				"TR_KB_APP_DATE" => $appDate,
				"TR_KB_APP_STATUS" => $statusApp,
			);
			$where = array(
				'TR_KB_APP_ID' => $newnew
			);
			$this->Model_online->update($where,$data,"tr_kb_approval");
			// masukkan ke dalam tabel tr_approval
			$data = array(
				"TR_KB_APP_ID" => $TR_APP_ID,
				"KB_ID" => $idReim,
				"EMP_ID" => 'EMP/003/002',
				"TR_KB_APP_DATE" => '',
				"TR_KB_APP_STATUS" => '0',
				"TR_KB_SUB_DATE" => $appDate,
				"TR_APP_COMMENT" => '',
				);	
			$this->Model_online->input($data,"tr_kb_approval");
			$dataReim = array(
				"KB_APP_DATE" => $Ymdhis
				);
			$whereReim = array(
				'KB_ID' => $idReim
			);
			$this->Model_online->update($whereReim,$dataReim,"tr_kasbon");
			// BAGIAN EMAIL
				//  ============================================================== set value untuk email
				//pembuatan bagian isi email
				//ambil 1 row data reimburse
				$whereDataReim = array(
					'KB_ID' => $idReim,
				);
				$rowReim = $this->Model_online->findSingleDataWhere($whereDataReim,'tr_kasbon');
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
					'KB_ID' => $idReim,
				);
				$data['rowDet'] = $this->Model_online->findAllDataWhere($whereDet,'tr_detail_kasbon');
				//penamaan variable
				$to = $emailFA;
				$subject = 'Approval Kasbon | '.$rowDep['DEPART_NAME'].' - '.$rowEmp['EMP_FULL_NAME'].' - '.$idReim;
				$data['nama'] = $rowEmp['EMP_FULL_NAME'];
				$data['idEmp'] = $row2['EMP_ID'];
				$data['tglPengajuan'] = $rowReim['KB_SUBMIT_DATE'];
				$data['total'] = $rowReim['KB_TOTAL_AWAL'];
				$data['idreim'] = $idReim ;
				$message = $this->load->view('templates/emailfix', $data,true);
				// aksi input update email
				$this->Model_online->insEmail($to,$subject,$message);
			redirect(base_url().'Kasbon/Approval');
		}else{
			//tampilkan error data telah diproses harap cek kembali
			redirect(base_url().'Kasbon/Approval');
			//redirect ke approval
		}
		
	}

	/// End bagian Detail realisasi
	// ====================================
	
}