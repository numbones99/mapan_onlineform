<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class EmailAppKB extends CI_Controller {

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
        // convert id kasbon setelah di encode, dan jadikan format data yg seharusnya
        $kasbonRaw = base64_decode($this->input->get("kasbonID"));
        $kasbonRaw1 = substr($kasbonRaw,0,2);
        $kasbonRaw2 = substr($kasbonRaw,2,6);
        $kasbonRaw3 = substr($kasbonRaw,8,4);
        $kasbonId = $kasbonRaw1.'/' .$kasbonRaw2.'/'.$kasbonRaw3;
        // convert id employee setelah di encode, dan jadikan format data yg seharusnya
        $empRaw = base64_decode($this->input->get("empID"));
        $empRaw1 = substr($empRaw,0,3);
        $empRaw2 = substr($empRaw,3,3);
        $empRaw3 = substr($empRaw,6,3);
        $empID = $empRaw1.'/' .$empRaw2.'/'.$empRaw3;
        $value = base64_decode($this->input->get("value"));
        $member = base64_decode($this->input->get("member"));
        // tanggal saat ini
        $Ymdhis = date('Y-m-d H:i:s');
        // mulai percabangan
        if($value=='Leader'){
            //cari approvalnya
            $whereApp = array(
                "KB_ID" => $kasbonId,
                "EMP_ID" => $empID,
            );
            $rowApp = $this->Model_online->findSingleDataWhere($whereApp,'tr_kb_approval');
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
            $idApp = $rowApp['TR_KB_APP_ID'];
            //$idReim = $reimId;
            //$empID = $empID;
            $appDate = date('Y-m-d H:i:s');
            $statusApp = '1';
            // ajukan approval ke Leader
            $Ym = date('ymd');
            $generateid = $this->Model_online->kode('KBP/' . $Ym . '/', 15,'tr_kb_approval','TR_KB_APP_ID');
            //$TR_APP_ID = $generateid;
            // pengecekan doble untuk status yg sudah lebih dari 0 atau sudah ada tindakan
            $wAppStatus = array(
                'TR_KB_APP_ID' => $idApp,
                'EMP_ID' => $empID,
                'TR_KB_APP_STATUS !=' => '0',
            );
            $countAppStatus = $this->Model_online->countRowWhere('tr_kb_approval',$wAppStatus);
            // pengecekan doble untuk id_app dan leader yg sama, di insert app
            $wAppLeader = array(
                'KB_ID' => $kasbonId,
                'EMP_ID' => $idLeader,
            );
            $countAppLeader = $this->Model_online->countRowWhere('tr_kb_approval',$wAppLeader);
            if($countAppLeader<=0 && $countAppStatus<=0){
                //setujui dan beri status 1
                $data = array(
                    "TR_KB_APP_DATE" => $appDate,
                    "TR_KB_APP_STATUS" => $statusApp,
                );
                $where = array(
                    'TR_KB_APP_ID' => $idApp
                );
                $this->Model_online->update($where,$data,"tr_kb_approval");
                // masukkan ke dalam tabel tr_approval
                $data = array(
                    "TR_KB_APP_ID" => $generateid,
                    "KB_ID" => $kasbonId,
                    "EMP_ID" => $idLeader,
                    "TR_KB_APP_DATE" => '',
                    "TR_KB_APP_STATUS" => '0',
                    "TR_KB_SUB_DATE" => $appDate,
                );	
                $this->Model_online->input($data,"tr_kb_approval");
                // update tanggal approval di tr_reimburse jika pertama kali approval
                $wApp = array(
                    'KB_ID' => $kasbonId
                );
                $countwApp = $this->Model_online->countRowWhere('tr_kb_approval',$wApp);
                if($countwApp<=0){
                    $dataReim = array(
                        "KB_SUBMIT_DATE" => $Ymdhis,
                        "KB_STATUS" => '1',
                        );
                    $whereReim = array(
                        'KB_ID' => $kasbonId
                    );
                    $this->Model_online->update($whereReim,$dataReim,"tr_kasbon");
                }else{
                    $dataReim = array(
                        "KB_STATUS" => '1',
                        );
                    $whereReim = array(
                        'KB_ID' => $kasbonId
                    );
                    $this->Model_online->update($whereReim,$dataReim,"tr_kasbon");
                }
            // BAGIAN EMAIL
			//  ============================================================== set value untuk email
				//pembuatan bagian isi email
				//ambil 1 row data kasbon
				$whereDataKB = array(
					'KB_ID' => $kasbonId,
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
					'KB_ID' => $kasbonId,
				);
				$data['rowDet'] = $this->Model_online->findAllDataWhere($whereDet,'tr_detail_kasbon');
				//penamaan variable
				$to = $leaderEmail;
				$subject = 'Approval Kasbon | '.$rowDep['DEPART_NAME'].' - '.$rowEmp['EMP_FULL_NAME'].' - '.$kasbonId; 
				$data['nama'] = $rowEmp['EMP_FULL_NAME'];
				$data['leader'] = $row2;
				$data['rowKB'] = $rowKB;
				$message = $this->load->view('kasbon/emailkasbon', $data,true);
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
                "KB_ID" => $kasbonId,
                "EMP_ID" => $empID,
            );
            $rowApp = $this->Model_online->findSingleDataWhere($whereApp,'tr_kb_approval');
            //setujui dan beri status 1 untuk menyetujui
            $idApp = $rowApp['TR_KB_APP_ID'];
            //$idReim = $reimId;
            //$empID = $empID;
            //tanggal saat ini
            $appDate = date('Y-m-d H:i:s');
            $statusApp = '3';
            // ajukan approval ke FA
            $Ym = date('ymd');
            $generateid = $this->Model_online->kode('KBP/' . $Ym . '/', 15,'tr_kb_approval','TR_KB_APP_ID');
            //$TR_APP_ID = $generateid;
            $MEMBER_FA = 'EMP/003/009';//sementara
            $row2 = $this->db->where('EMP_ID',$MEMBER_FA)->get('m_employee')->row_array();
            $emailFA = $row2['EMP_EMAIL'];
            // pengecekan doble untuk status yg sudah lebih dari 0 atau sudah ada tindakan
            $wAppStatus = array(
                'TR_KB_APP_ID' => $idApp,
                'EMP_ID' => $empID,
                'TR_KB_APP_STATUS !=' => '0',
            );
            $countAppStatus = $this->Model_online->countRowWhere('tr_kb_approval',$wAppStatus);
            // pengecekan doble untuk id_app dan leader yg sama, di insert app
            $wAppFA = array(
                'KB_ID' => $kasbonId,
                'EMP_ID' => $MEMBER_FA,
            );
            $countAppFA = $this->Model_online->countRowWhere('tr_kb_approval',$wAppFA);

            if($countAppFA<=0 && $countAppStatus<=0){
                //setujui dan beri status 1 untuk menyetujui
                $data = array(
                    "TR_KB_APP_DATE" => $appDate,
                    "TR_KB_APP_STATUS" => $statusApp,
                );
                $where = array(
                    'TR_KB_APP_ID' => $idApp
                );
                $this->Model_online->update($where,$data,"tr_kb_approval");
                // masukkan ke dalam tabel tr_approval
                $data = array(
                    "TR_KB_APP_ID" => $generateid,
                    "KB_ID" => $kasbonId,
                    "EMP_ID" => 'EMP/003/009',//sementara
                    "TR_KB_APP_DATE" => '',
                    "TR_KB_APP_STATUS" => '0',
                    "TR_KB_SUB_DATE" => $appDate,
                );	
                $this->Model_online->input($data,"tr_kb_approval");
                // update tanggal approval di tr_reimburse jika pertama kali approval
                $wApp = array(
                    'KB_ID' => $kasbonId
                );
                $countwApp = $this->Model_online->countRowWhere('tr_kb_approval',$wApp);
                if($countwApp<=0){
                    $dataReim = array(
                        "KB_SUBMIT_DATE" => $Ymdhis,
                        "KB_STATUS" => '3',
                        );
                    $whereReim = array(
                        'KB_ID' => $kasbonId
                    );
                    $this->Model_online->update($whereReim,$dataReim,"tr_kasbon");
                }else{
                    $dataReim = array(
                        "KB_STATUS" => '3',
                        );
                    $whereReim = array(
                        'KB_ID' => $kasbonId
                    );
                    $this->Model_online->update($whereReim,$dataReim,"tr_kasbon");
                }
            // BAGIAN EMAIL
			//  ============================================================== set value untuk email
				//pembuatan bagian isi email
				//ambil 1 row data kasbon
				$whereDataKB = array(
					'KB_ID' => $kasbonId,
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
					'KB_ID' => $kasbonId,
				);
				$data['rowDet'] = $this->Model_online->findAllDataWhere($whereDet,'tr_detail_kasbon');
				//penamaan variable
				$to = $emailFA;
				$subject = 'Approval Kasbon | '.$rowDep['DEPART_NAME'].' - '.$rowEmp['EMP_FULL_NAME'].' - '.$kasbonId; 
				$data['nama'] = $rowEmp['EMP_FULL_NAME'];
				$data['leader'] = $row2;
				$data['rowKB'] = $rowKB;
				$message = $this->load->view('kasbon/emailkasbon', $data,true);
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
                "KB_ID" => $kasbonId,
                "EMP_ID" => $empID,
            );
            $rowApp = $this->Model_online->findSingleDataWhere($whereApp,'tr_kb_approval');
            
            //setujui dan beri status 1 untuk menyetujui
            $idApp = $rowApp['TR_KB_APP_ID'];
            $appDate = date('Y-m-d H:i:s');
            $statusApp = '4';
            // pengecekan doble untuk id_app dan leader yg sama, di insert app
            $wAppFinal = array(
                'TR_KB_APP_ID' => $idApp,
                'EMP_ID' => $empID,
                'TR_KB_APP_STATUS !=' => '0',
            );
            $countAppFinal = $this->Model_online->countRowWhere('tr_kb_approval',$wAppFinal);
            if($countAppFinal<=0){
                $data = array(
                    "TR_KB_APP_DATE" => $appDate,
                    "TR_KB_APP_STATUS" => $statusApp,
                );
                $where = array(
                    'TR_KB_APP_ID' => $idApp
                );
                $this->Model_online->update($where,$data,"tr_kb_approval");
                // update tanggal approval di tr_reimburse jika pertama kali approval
                $wApp = array(
                    'KB_ID' => $kasbonId
                );
                $countwApp = $this->Model_online->countRowWhere('tr_kb_approval',$wApp);
                if($countwApp<=0){
                    $dataReim = array(
                        "KB_SUBMIT_DATE" => $Ymdhis,
                        "KB_STATUS" => '4',
                        );
                    $whereReim = array(
                        'KB_ID' => $kasbonId
                    );
                    $this->Model_online->update($whereReim,$dataReim,"tr_kasbon");
                }else{
                    $dataReim = array(
                        "KB_APP_DATE" => $Ymdhis,
                        "KB_STATUS" => '4',
                        );
                    $whereReim = array(
                        'KB_ID' => $kasbonId
                    );
                    $this->Model_online->update($whereReim,$dataReim,"tr_kasbon");
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
                "KB_ID" => $kasbonId,
                "EMP_ID" => $empID,
            );
            $rowApp = $this->Model_online->findSingleDataWhere($whereApp,'tr_kb_approval');
            //setujui dan beri status 2 untuk menolak
            $idApp = $rowApp['TR_KB_APP_ID'];
            $appDate = date('Y-m-d H:i:s');
            $statusApp = '2';
            // pengecekan doble untuk id_app dan leader yg sama, di insert app
            $wAppFinal = array(
                'TR_KB_APP_ID' => $idApp,
                'EMP_ID' => $empID,
                'TR_KB_APP_STATUS !=' => '0',
            );
            $countAppFinal = $this->Model_online->countRowWhere('tr_kb_approval',$wAppFinal);
            if($countAppFinal<=0){
                $data = array(
                    "TR_KB_APP_DATE" => $appDate,
                    "TR_KB_APP_STATUS" => $statusApp,
                );
                $where = array(
                    'TR_KB_APP_ID' => $idApp
                );
                $this->Model_online->update($where,$data,"tr_kb_approval");
                // update tanggal approval di tr_reimburse jika pertama kali approval
                $wApp = array(
                    'KB_ID' => $kasbonId
                );
                $countwApp = $this->Model_online->countRowWhere('tr_kb_approval',$wApp);
                if($countwApp<=0){
                    $dataReim = array(
                        "KB_SUBMIT_DATE" => $Ymdhis,
                        "KB_STATUS" => '2',
                        );
                    $whereReim = array(
                        'KB_ID' => $kasbonId
                    );
                    $this->Model_online->update($whereReim,$dataReim,"tr_kasbon");
                }else{
                    $dataReim = array(
                        "KB_APP_DATE" => $Ymdhis,
                        "KB_STATUS" => '2',
                        );
                    $whereReim = array(
                        'KB_ID' => $kasbonId
                    );
                    $this->Model_online->update($whereReim,$dataReim,"tr_kasbon");
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
}