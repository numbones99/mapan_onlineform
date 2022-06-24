<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class EmailApp extends CI_Controller {

	function __construct(){
		parent::__construct();
	}
	
	public function index()
	{
		$this->load->view('templates/head');
		$this->load->view('templates/sidenav');
		$this->load->view('templates/template');
		$this->load->view('templates/footer');
    }
    public function mainApp(){ // ini saya buat karena inline formaction untuk beda2 tombol nggak berfungsi di email
        // cari data di tabel approval dengan reimburse ID dan employee ID
        $reimRaw = base64_decode($this->input->get("reimID"));
        $reimRaw1 = substr($reimRaw,0,2);
        $reimRaw2 = substr($reimRaw,2,6);
        $reimRaw3 = substr($reimRaw,8,4);
        $reimId = $reimRaw1.'/' .$reimRaw2.'/'.$reimRaw3;
        $empRaw = base64_decode($this->input->get("empID"));
        $empRaw1 = substr($empRaw,0,3);
        $empRaw2 = substr($empRaw,3,3);
        $empRaw3 = substr($empRaw,6,3);
        $empID = $empRaw1.'/' .$empRaw2.'/'.$empRaw3;
        $value = base64_decode($this->input->get("value"));
        $member = base64_decode($this->input->get("member"));
        $Ymdhis = date('Y-m-d H:i:s');
        if($value=='Leader'){
            //cari approvalnya
            $whereApp = array(
                "RB_ID" => $reimId,
                "EMP_ID" => $empID,
            );
            $rowApp = $this->Model_online->findSingleDataWhere($whereApp,'tr_approval');
            //cari leadernya idleadernya brp 
            $whereSp = array(
                "EMP_ID_MEMBER" => $empID,
            );
            $rowSp = $this->Model_online->findSingleDataWhere($whereSp,'tr_supervision');
            //setujui dan beri status 1 untuk menyetujui
            $idLeader = $rowSp['EMP_ID_LEADER'];
            // cari email leadernya
            $row2 = $this->db->where('EMP_ID',$idLeader)->get('m_employee')->row_array();
            $leaderEmail = $row2['EMP_EMAIL'];
            $idApp = $rowApp['TR_APP_ID'];
            $idReim = $reimId;
            $empID = $empID;
            $appDate = date('Y-m-d H:i:s');
            $statusApp = '1';
            // ajukan approval ke Leader
            $Ym = date('ymd');
            $generateid = $this->Model_online->kode('APP/' . $Ym . '/', 15,'tr_approval','TR_APP_ID');
            $TR_APP_ID = $generateid;
            // pengecekan doble untuk status yg sudah lebih dari 0 atau sudah ada tindakan
            $wAppStatus = array(
                'TR_APP_ID' => $idApp,
                'EMP_ID' => $empID,
                'TR_APP_STATUS !=' => '0',
            );
            $countAppStatus = $this->Model_online->countRowWhere('tr_approval',$wAppStatus);
            // pengecekan doble untuk id_app dan leader yg sama, di insert app
            $wAppLeader = array(
                'RB_ID' => $idReim,
                'EMP_ID' => $idLeader,
            );
            $countAppLeader = $this->Model_online->countRowWhere('tr_approval',$wAppLeader);
            if($countAppLeader<=0 && $countAppStatus<=0){
                //setujui dan beri status 1
                $data = array(
                    "TR_APP_DATE" => $appDate,
                    "TR_APP_STATUS" => $statusApp,
                );
                $where = array(
                    'TR_APP_ID' => $idApp
                );
                $this->Model_online->update($where,$data,"tr_approval");
                // masukkan ke dalam tabel tr_approval
                $data = array(
                    "TR_APP_ID" => $TR_APP_ID,
                    "RB_ID" => $idReim,
                    "EMP_ID" => $idLeader,
                    "TR_APP_DATE" => '',
                    "TR_APP_STATUS" => '0',
                    "TR_SUB_DATE" => $appDate,
                    "TR_APP_COMMENT" => '',
                );	
                $this->Model_online->input($data,"tr_approval");
                // update tanggal approval di tr_reimburse jika pertama kali approval
                $wApp = array(
                    'RB_ID' => $idReim
                );
                $countwApp = $this->Model_online->countRowWhere('tr_approval',$wApp);
                if($countwApp<=0){
                    $dataReim = array(
                        "RB_SUBMIT_DATE" => $Ymdhis
                        );
                    $whereReim = array(
                        'RB_ID' => $idReim
                    );
                    $this->Model_online->update($whereReim,$dataReim,"tr_reimburse");
                }else{
                    $dataReim = array(
                        "RB_FINAL_APP_DATE" => $Ymdhis
                        );
                    $whereReim = array(
                        'RB_ID' => $idReim
                    );
                    $this->Model_online->update($whereReim,$dataReim,"tr_reimburse");
                }
                // BAGIAN EMAIL
                //  ============================================================== set value untuk email
                //pembuatan bagian isi email
                //ambil 1 row data reimburse
                $whereDataReim = array(
                    'RB_ID' => $reimId,
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
                    'RB_ID' => $reimId,
                );
                $data['rowDet'] = $this->Model_online->findAllDataWhere($whereDet,'tr_detail_reimburse');
                //penamaan variable
                $to = $leaderEmail;
                $subject = 'Approval Reimbursement | '.$rowDep['DEPART_NAME'].' - '.$rowEmp['EMP_FULL_NAME'].' - '.$reimId;
                $data['nama'] = $rowEmp['EMP_FULL_NAME'];
                $data['idEmp'] = $row2['EMP_ID'];
                $data['tglPengajuan'] = $rowReim['RB_SUBMIT_DATE'];
                $data['total'] = $rowReim['RB_TOTAL'];
                $data['idreim'] = $reimId ;
                $message = $this->load->view('templates/emailfix', $data,true);
                // aksi input update email
                $this->Model_online->insEmail($to,$subject,$message);
                $this->session->set_flashdata("app-done","Persetujuan & Permintaan Persetujuan Telah Berhasil");
                redirect(base_url("Login"));
            }else{
                // tampilkan error data telah di proses silahkan cek kembali 
                $this->session->set_flashdata("app-error","Persetujuan/Penolakan Melalui Email Gagal");
                //redirect
                redirect(base_url("Login"));
            }
        }elseif($value=='FA'){
            //cari data approval
            $whereApp = array(
                "RB_ID" => $reimId,
                "EMP_ID" => $empID,
            );
            $rowApp = $this->Model_online->findSingleDataWhere($whereApp,'tr_approval');
            //setujui dan beri status 1 untuk menyetujui
            $idApp = $rowApp['TR_APP_ID'];
            $idReim = $reimId;
            $empID = $empID;
            $appDate = date('Y-m-d H:i:s');
            $statusApp = '3';
            // ajukan approval ke FA
            $Ym = date('ymd');
            $generateid = $this->Model_online->kode('APP/' . $Ym . '/', 15,'tr_approval','TR_APP_ID');
            $TR_APP_ID = $generateid;
            $MEMBER_FA = 'EMP/003/009';//sementara
            $row2 = $this->db->where('EMP_ID',$MEMBER_FA)->get('m_employee')->row_array();
            $emailFA = $row2['EMP_EMAIL'];
            // pengecekan doble untuk status yg sudah lebih dari 0 atau sudah ada tindakan
            $wAppStatus = array(
                'TR_APP_ID' => $idApp,
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
                //setujui dan beri status 1 untuk menyetujui
                $data = array(
                    "TR_APP_DATE" => $appDate,
                    "TR_APP_STATUS" => $statusApp,
                );
                $where = array(
                    'TR_APP_ID' => $idApp
                );
                $this->Model_online->update($where,$data,"tr_approval");
                // masukkan ke dalam tabel tr_approval
                $data = array(
                    "TR_APP_ID" => $TR_APP_ID,
                    "RB_ID" => $idReim,
                    "EMP_ID" => 'EMP/003/009',//sementara
                    "TR_APP_DATE" => '',
                    "TR_APP_STATUS" => '0',
                    "TR_SUB_DATE" => $appDate,
                    "TR_APP_COMMENT" => '',
                );	
                $this->Model_online->input($data,"tr_approval");
                // update tanggal approval di tr_reimburse jika pertama kali approval
                $wApp = array(
                    'RB_ID' => $idReim
                );
                $countwApp = $this->Model_online->countRowWhere('tr_approval',$wApp);
                if($countwApp<=0){
                    $dataReim = array(
                        "RB_SUBMIT_DATE" => $Ymdhis
                        );
                    $whereReim = array(
                        'RB_ID' => $idReim
                    );
                    $this->Model_online->update($whereReim,$dataReim,"tr_reimburse");
                }else{
                    $dataReim = array(
                        "RB_FINAL_APP_DATE" => $Ymdhis
                        );
                    $whereReim = array(
                        'RB_ID' => $idReim
                    );
                    $this->Model_online->update($whereReim,$dataReim,"tr_reimburse");
                }
                // BAGIAN EMAIL
                //  ============================================================== set value untuk email
                //pembuatan bagian isi email
                //ambil 1 row data reimburse
                $whereDataReim = array(
                    'RB_ID' => $reimId,
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
                    'RB_ID' => $reimId,
                );
                $data['rowDet'] = $this->Model_online->findAllDataWhere($whereDet,'tr_detail_reimburse');
                //penamaan variable
                $to = $emailFA;
                $subject = 'Approval Reimbursement | '.$rowDep['DEPART_NAME'].' - '.$rowEmp['EMP_FULL_NAME'].' - '.$idReim;
                $data['nama'] = $rowEmp['EMP_FULL_NAME'];
                $data['idEmp'] = $row2['EMP_ID'];
                $data['tglPengajuan'] = $rowReim['RB_SUBMIT_DATE'];
                $data['total'] = $rowReim['RB_TOTAL'];
                $data['idreim'] = $reimId ;
                $message = $this->load->view('templates/emailfix', $data,true);
                // aksi input update email
                $this->Model_online->insEmail($to,$subject,$message);
                $this->session->set_flashdata("app-final","Persetujuan Final & Permintaan Release FA Telah Berhasil");
                redirect(base_url("Login"));
            }else{
                //tampilkan error data telah diproses silahkan cek kembali
                $this->session->set_flashdata("app-error","Persetujuan/Penolakan Melalui Email Gagal");
                //redirect ke halaman utama
                redirect(base_url("Login"));
            }
        }elseif($value=='Final'){
            // cari data di tabel approval dengan reimburse ID dan employee ID
            $whereApp = array(
                "RB_ID" => $reimId,
                "EMP_ID" => $empID,
            );
            $rowApp = $this->Model_online->findSingleDataWhere($whereApp,'tr_approval');
            
            //setujui dan beri status 1 untuk menyetujui
            $idApp = $rowApp['TR_APP_ID'];
            $empID = $empID;
            $appDate = date('Y-m-d H:i:s');
            $statusApp = '4';
            // pengecekan doble untuk id_app dan leader yg sama, di insert app
            $wAppFinal = array(
                'TR_APP_ID' => $idApp,
                'EMP_ID' => $empID,
                'TR_APP_STATUS !=' => '0',
            );
            $countAppFinal = $this->Model_online->countRowWhere('tr_approval',$wAppFinal);
            if($countAppFinal<=0){
                $data = array(
                    "TR_APP_DATE" => $appDate,
                    "TR_APP_STATUS" => $statusApp,
                );
                $where = array(
                    'TR_APP_ID' => $idApp
                );
                $this->Model_online->update($where,$data,"tr_approval");
                // update tanggal approval di tr_reimburse jika pertama kali approval
                $wApp = array(
                    'RB_ID' => $reimId
                );
                $countwApp = $this->Model_online->countRowWhere('tr_approval',$wApp);
                if($countwApp<=0){
                    $dataReim = array(
                        "RB_SUBMIT_DATE" => $Ymdhis
                        );
                    $whereReim = array(
                        'RB_ID' => $reimId
                    );
                    $this->Model_online->update($whereReim,$dataReim,"tr_reimburse");
                }else{
                    $dataReim = array(
                        "RB_FINAL_APP_DATE" => $Ymdhis
                        );
                    $whereReim = array(
                        'RB_ID' => $reimId
                    );
                    $this->Model_online->update($whereReim,$dataReim,"tr_reimburse");
                }
                $this->session->set_flashdata("app-final-fa","Release Pengajuan Telah Berhasil");
                redirect(base_url("Login"));
            }else{
                //tampilkan error data telah diproses
                $this->session->set_flashdata("app-error","Persetujuan/Penolakan Melalui Email Gagal");
                //redirect
                redirect(base_url("Login"));
            }
            
        }elseif($value=='Reject'){
            // cari data di tabel approval dengan reimburse ID dan employee ID
            $whereApp = array(
                "RB_ID" => $reimId,
                "EMP_ID" => $empID,
            );
            $rowApp = $this->Model_online->findSingleDataWhere($whereApp,'tr_approval');
            //setujui dan beri status 2 untuk menolak
            $idApp = $rowApp['TR_APP_ID'];
            $empID = $empID;
            $appDate = date('Y-m-d H:i:s');
            $statusApp = '2';
            // pengecekan doble untuk id_app dan leader yg sama, di insert app
            $wAppFinal = array(
                'TR_APP_ID' => $idApp,
                'EMP_ID' => $empID,
                'TR_APP_STATUS !=' => '0',
            );
            $countAppFinal = $this->Model_online->countRowWhere('tr_approval',$wAppFinal);
            if($countAppFinal<=0){
                $data = array(
                    "TR_APP_DATE" => $appDate,
                    "TR_APP_STATUS" => $statusApp,
                );
                $where = array(
                    'TR_APP_ID' => $idApp
                );
                $this->Model_online->update($where,$data,"tr_approval");
                // update tanggal approval di tr_reimburse jika pertama kali approval
                $wApp = array(
                    'RB_ID' => $reimId
                );
                $countwApp = $this->Model_online->countRowWhere('tr_approval',$wApp);
                if($countwApp<=0){
                    $dataReim = array(
                        "RB_SUBMIT_DATE" => $Ymdhis
                        );
                    $whereReim = array(
                        'RB_ID' => $reimId
                    );
                    $this->Model_online->update($whereReim,$dataReim,"tr_reimburse");
                }else{
                    $dataReim = array(
                        "RB_FINAL_APP_DATE" => $Ymdhis
                        );
                    $whereReim = array(
                        'RB_ID' => $reimId
                    );
                    $this->Model_online->update($whereReim,$dataReim,"tr_reimburse");
                }
                $this->session->set_flashdata("app-reject","Pengajuan Telah Berhasil Ditolak");
                redirect(base_url("Login"));
            }else{
                //tampilkan error
                $this->session->set_flashdata("app-error","Persetujuan/Penolakan Melalui Email Gagal");
                //redirect
                redirect(base_url("Login"));
            }
        }
    }

    //tidak digunakan weqheoqwhepqiw
    
    public function emailAppFA() // untuk Setujui & Ajukan ke FA
	{
        // cari data di tabel approval dengan reimburse ID dan employee ID
        $reimId = $this->input->post("reimID");
        $empID = $this->input->post("empID");
        $whereApp = array(
            "RB_ID" => $reimId,
            "EMP_ID" => $empID,
        );
        $rowApp = $this->Model_online->findSingleDataWhere($whereApp,'tr_approval');
		//setujui dan beri status 1 untuk menyetujui
		$idApp = $rowApp['TR_APP_ID'];
		$idReim = $reimId;
		$empID = $empID;
		$appDate = date('Y-m-d H:i:s');
		$statusApp = '1';
		/* $newID1 = substr($idApp,0,3);
        $newID2 = substr($idApp,3,6);
        $newID3 = substr($idApp,9,4);
        $newnew = $newID1.'/' .$newID2.'/'.$newID3; */
	    $data = array(
			"TR_APP_DATE" => $appDate,
			"TR_APP_STATUS" => $statusApp,
		);
		$where = array(
			'TR_APP_ID' => $idApp
		);
		$this->Model_online->update($where,$data,"tr_approval");
		// ajukan approval ke FA
		$Ym = date('ymd');
		$generateid = $this->Model_online->kode('APP/' . $Ym . '/', 15,'tr_approval','TR_APP_ID');
		$TR_APP_ID = $generateid;
		$MEMBER_FA = 'EMP/003/009';
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
        redirect(base_url().'Reimbursement');
    }
    public function emailAppLeader() // untuk Setujui & Ajukan ke Atasan
	{
        // cari data di tabel approval dengan reimburse ID dan employee ID
        $reimId = $this->input->post("reimID");
        $empID = $this->input->post("empID");
        $whereApp = array(
            "RB_ID" => $reimId,
            "EMP_ID" => $empID,
        );
        $rowApp = $this->Model_online->findSingleDataWhere($whereApp,'tr_approval');
        //cari leadernya idleadernya brp 
        $whereSp = array(
            "EMP_ID_MEMBER" => $empID,
        );
        $rowSp = $this->Model_online->findSingleDataWhere($whereSp,'tr_supervision');
        //setujui dan beri status 1 untuk menyetujui
        $idLeader = $rowSp['EMP_ID_LEADER'];
		$idApp = $rowApp['TR_APP_ID'];
		$idReim = $reimId;
		$empID = $empID;
		$appDate = date('Y-m-d H:i:s');
		$statusApp = '1';
	    $data = array(
			"TR_APP_DATE" => $appDate,
			"TR_APP_STATUS" => $statusApp,
		);
		$where = array(
			'TR_APP_ID' => $idApp
		);
		$this->Model_online->update($where,$data,"tr_approval");
		// ajukan approval ke Leader
		$Ym = date('ymd');
		$generateid = $this->Model_online->kode('APP/' . $Ym . '/', 15,'tr_approval','TR_APP_ID');
        $TR_APP_ID = $generateid;
		// masukkan ke dalam tabel tr_approval
		$data = array(
			"TR_APP_ID" => $TR_APP_ID,
			"RB_ID" => $idReim,
			"EMP_ID" => $idLeader,
			"TR_APP_DATE" => '',
			"TR_APP_STATUS" => '0',
			"TR_SUB_DATE" => $appDate,
			"TR_APP_COMMENT" => '',
		);	
        $this->Model_online->input($data,"tr_approval");
        redirect(base_url().'Reimbursement');
    }
    public function emailAppFinal() // untuk Setujui & Ajukan ke Atasan
	{
        // cari data di tabel approval dengan reimburse ID dan employee ID
        $reimId = $this->input->post("reimID");
        $empID = $this->input->post("empID");
        $whereApp = array(
            "RB_ID" => $reimId,
            "EMP_ID" => $empID,
        );
        $rowApp = $this->Model_online->findSingleDataWhere($whereApp,'tr_approval');
        //setujui dan beri status 1 untuk menyetujui
		$idApp = $rowApp['TR_APP_ID'];
		$empID = $empID;
		$appDate = date('Y-m-d H:i:s');
		$statusApp = '4';
	    $data = array(
			"TR_APP_DATE" => $appDate,
			"TR_APP_STATUS" => $statusApp,
		);
		$where = array(
			'TR_APP_ID' => $idApp
		);
        $this->Model_online->update($where,$data,"tr_approval");
        redirect(base_url().'Reimbursement');
    }
    public function emailAppDeny() // untuk Setujui & Ajukan ke Atasan
	{
        // cari data di tabel approval dengan reimburse ID dan employee ID
        $reimId = $this->input->post("reimID");
        $empID = $this->input->post("empID");
        $whereApp = array(
            "RB_ID" => $reimId,
            "EMP_ID" => $empID,
        );
        $rowApp = $this->Model_online->findSingleDataWhere($whereApp,'tr_approval');
        //setujui dan beri status 1 untuk menyetujui
		$idApp = $rowApp['TR_APP_ID'];
		$empID = $empID;
		$appDate = date('Y-m-d H:i:s');
		$statusApp = '2';
	    $data = array(
			"TR_APP_DATE" => $appDate,
			"TR_APP_STATUS" => $statusApp,
		);
		$where = array(
			'TR_APP_ID' => $idApp
		);
        $this->Model_online->update($where,$data,"tr_approval");
        redirect(base_url().'Reimbursement');
	}
}