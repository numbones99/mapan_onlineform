<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class EmailAppRP extends CI_Controller {

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
        $repairRaw = base64_decode($this->input->get("repairID"));
        $repairRaw1 = substr($repairRaw,0,2);
        $repairRaw2 = substr($repairRaw,2,6);
        $repairRaw3 = substr($repairRaw,8,4);
        $repairId = $repairRaw1.'/' .$repairRaw2.'/'.$repairRaw3;
        $value = base64_decode($this->input->get("value"));
 
        // tanggal saat ini
        $Ymdhis = date('Y-m-d H:i:s');
        // mulai percabangan
        if($value=='Final'){
            // cari data di tabel approval dengan reimburse ID dan employee ID
            $whereApp = array(
                "RP_ID" => $repairId,
            );
            $rowRepair = $this->Model_online->findSingleDataWhere($whereApp,'tr_repair');
            $rowapp = $this->Model_online->findSingleDataWhere($whereApp,'tr_app_repair');
            if($rowRepair['RP_STAT']>1){
                //dashboard
                redirect(base_url("Login"));
            }else{
                //masuk ke sana
                redirect(base_url().'Aset/dtapp/'.str_replace('/','',$rowapp['APP_RP_ID']));
            }           
        }elseif($value=='Reject'){
            // cari data di tabel approval dengan reimburse ID dan employee ID
            $whereApp = array(
                "RP_ID" => $repairId,
            );
            $rowRepair = $this->Model_online->findSingleDataWhere($whereApp,'tr_repair');
            $rowapp = $this->Model_online->findSingleDataWhere($whereApp,'tr_app_repair');
            if($rowRepair['RP_STAT']>1){
                //dashboard
                $this->session->set_flashdata("app-error","Persetujuan/Penolakan Melalui Email Gagal");
                redirect(base_url("Login"));
            }else{
                $dataapp = array(
                    "APP_RP_ACC" => $Ymdhis,
                    "APP_RP_STAT" => '2',
                );
                $data = array(
                    'RP_APP_DATE' => $Ymdhis,
                    'RP_STAT' => '2'
                );
                $where = array(
                    'RP_ID' => $repairId
                );
                $this->Model_online->update($where,$dataapp,"tr_app_repair");
                $this->Model_online->update($where,$data,"tr_repair");
                //masuk ke sana
                $this->session->set_flashdata("app-reject","Pengajuan Telah Berhasil Ditolak");
                redirect(base_url("Login"));
            }    
        }
    }
    public function reviewApp(){ // ini saya buat karena inline formaction untuk beda2 tombol nggak berfungsi di email
        // cari data di tabel approval dengan reimburse ID dan employee ID
        // convert id kasbon setelah di encode, dan jadikan format data yg seharusnya
        $repairRaw = base64_decode($this->input->get("repairID"));
        $repairRaw1 = substr($repairRaw,0,2);
        $repairRaw2 = substr($repairRaw,2,6);
        $repairRaw3 = substr($repairRaw,8,4);
        $repairId = $repairRaw1.'/' .$repairRaw2.'/'.$repairRaw3;
        $value = base64_decode($this->input->get("value"));
 
        // tanggal saat ini
        $Ymdhis = date('Y-m-d H:i:s');
        // mulai percabangan
        if($value=='Final'){
            // cari data di tabel approval dengan reimburse ID dan employee ID
            $whereApp = array(
                "RP_ID" => $repairId,
            );
            $rowRepair = $this->Model_online->findSingleDataWhere($whereApp,'tr_repair');
            $rowapp = $this->Model_online->findSingleDataWhere($whereApp,'tr_app_repair');
            if($rowRepair['RP_STAT']>4){
                //dashboard
                $this->session->set_flashdata("app-error","Persetujuan/Penolakan Melalui Email Gagal");
                redirect(base_url("Login"));
            }else{
                //dashboard
                $data = array(
                    'RP_STAT' => '5'
                );
                $where = array(
                    'RP_ID' => $repairId
                );
                $this->Model_online->update($where,$data,"tr_repair");
                redirect(base_url("Login"));
            }           
        }elseif($value=='Reject'){
            // cari data di tabel approval dengan reimburse ID dan employee ID
            $whereApp = array(
                "RP_ID" => $repairId,
            );
            $rowRepair = $this->Model_online->findSingleDataWhere($whereApp,'tr_repair');
            $rowapp = $this->Model_online->findSingleDataWhere($whereApp,'tr_app_repair');
            if($rowRepair['RP_STAT']>4){
                //dashboard
                $this->session->set_flashdata("app-error","Persetujuan/Penolakan Melalui Email Gagal");
                redirect(base_url("Login"));
            }else{
                $data = array(
                    'RP_STAT' => '3'
                );
                $where = array(
                    'RP_ID' => $repairId
                );
                $this->Model_online->update($where,$data,"tr_repair");
                $this->session->set_flashdata("app-reject","Pengajuan Telah Berhasil Ditolak");
                redirect(base_url("Login"));
            }    
        }
    }
}