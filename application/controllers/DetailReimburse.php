<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class DetailReimburse extends CI_Controller {

	function __construct(){
		parent::__construct();
		if($this->session->userdata('STATUSLOGIN') != "LOGIN"){
			redirect(base_url("Login"));
		}
	}
	
	public function index($reimID)
	{
        
        //ambil id reimburse
        $id = $reimID;
		//$empID = $this->session->userdata('EMP_ID');
        //ambil data
        $newID1 = substr($reimID,0,2);
        $newID2 = substr($reimID,2,6);
        $newID3 = substr($reimID,8,4);
        $newnew = $newID1.'/' .$newID2.'/'.$newID3;
		
		$where = array(
			'RB_ID' => $newnew,
			); 
        $data['reimburse'] = $this->Model_online->tampilData('tr_detail_reimburse',$where);
		
		$this->load->view('templates/head');
		$this->load->view('templates/sidenav');
		$this->load->view('reimburse',$data);
		$this->load->view('templates/footer');
	}

	
}