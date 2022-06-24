<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

		public function index()
		{
			$this->load->view('login');
		}

		public function aksi_login(){
			
			$nomor = $this->input->post('nomor');
			$where2 = array(
				'EMP_F_NUM' => $nomor,
			);
			$row = $this->Model_online->findSingleDataWhere($where2,'m_employee');
			$arr_dep = array(
				'DEPART_ID' => $row['DEPART_ID'],
			);
			$rowdep = $this->Model_online->findSingleDataWhere($arr_dep,'m_department');
			$arr_dep = array(
				'BRANCH_ID' => $rowdep['BRANCH_ID'],
			);
			$rowbr = $this->Model_online->findSingleDataWhere($arr_dep,'m_branch');
			$passSaatIni = $row['EMP_PASS'];
			$statSaatIni = $row['EMP_STATUS'];
			if($passSaatIni=='11111' || $statSaatIni=='99'){
				$pass = $this->input->post('pass');
				$where = array(
					'EMP_F_NUM' => $nomor,
					'EMP_PASS' => $pass,
					'EMP_STATUS !=' => '0',
					);
				$cek = $this->Model_online->cek_login("m_employee",$where)->num_rows();
				// cek apakah usernya status 4 di outlet atau semua orang HO
				$sqloutlet = "select me.*
				from m_employee me 
				join m_department md on me.DEPART_ID = md.DEPART_ID 
				join m_branch mb on md.BRANCH_ID = mb.BRANCH_ID 
				where mb.BRANCH_ID != 'BR/0009' and me.EMP_STATUS != '0' and me.LEAD_STATUS in ('3','4','5')
				and me.EMP_F_NUM = '".$nomor."' ";
				$hitungoutlet = $this->db->query($sqloutlet)->num_rows();
				$sqlho = "select me.*
				from m_employee me 
				join m_department md on me.DEPART_ID = md.DEPART_ID 
				join m_branch mb on md.BRANCH_ID = mb.BRANCH_ID 
				where mb.BRANCH_ID = 'BR/0009' and me.EMP_STATUS != '0'
				and me.EMP_F_NUM = '".$nomor."' ";
				$hitungho = $this->db->query($sqlho)->num_rows();
				echo $hitungho;
				// cek apakah usernya aktif & passwordnya sesuai
				if($cek > 0 && ($hitungho > 0 || $hitungoutlet > 0)){
					$data = $this->Model_online->getDataLogin("m_employee",$where);
					$data_session = array(
						'EMP_ID' => $data['EMP_ID'],
						'EMP_FULL_NAME' => $data['EMP_FULL_NAME'],
						'EMP_F_NUM' => $data['EMP_F_NUM'],
						'EMP_EMAIL' => $data['EMP_EMAIL'],
						'LEAD_STATUS' => $data['LEAD_STATUS'],
						'DEPART_ID' => $data['DEPART_ID'],
						'BRANCH_ID' => $rowbr['BRANCH_ID'],
						'BRANCH_NAME' => $rowbr['BRANCH_NAME'],
						'STATUSLOGIN' => "LOGIN",
						);

				$this->session->set_userdata($data_session);
				redirect(base_url("Dashboard"));
				}else{
					$this->session->set_flashdata("flashdata","Username Atau Password salah");
					redirect(base_url("Login"));
				}
			}
			else{
				$DEpass = base64_encode($this->input->post('pass'));
				$pass = $DEpass;
				$where = array(
					'EMP_F_NUM' => $nomor,
					'EMP_PASS' => $pass,
					'EMP_STATUS' => '1',
					);
				$cek = $this->Model_online->cek_login("m_employee",$where)->num_rows();
				// cek apakah usernya status 4 di outlet atau semua orang HO
				$sqloutlet = "select me.*
				from m_employee me 
				join m_department md on me.DEPART_ID = md.DEPART_ID 
				join m_branch mb on md.BRANCH_ID = mb.BRANCH_ID 
				where mb.BRANCH_ID != 'BR/0009' and me.EMP_STATUS != '0' and me.LEAD_STATUS in ('3','4','5')
				and me.EMP_F_NUM = '".$nomor."' ";
				$hitungoutlet = $this->db->query($sqloutlet)->num_rows();
				$sqlho = "select me.*
				from m_employee me 
				join m_department md on me.DEPART_ID = md.DEPART_ID 
				join m_branch mb on md.BRANCH_ID = mb.BRANCH_ID 
				where mb.BRANCH_ID = 'BR/0009' and me.EMP_STATUS != '0'
				and me.EMP_F_NUM = '".$nomor."' ";
				$hitungho = $this->db->query($sqlho)->num_rows();
				// cek apakah usernya aktif & passwordnya sesuai
				if($cek > 0 && ($hitungho >0 || $hitungoutlet>0)){
					$data = $this->Model_online->getDataLogin("m_employee",$where);
					$data_session = array(
						'EMP_ID' => $data['EMP_ID'],
						'EMP_FULL_NAME' => $data['EMP_FULL_NAME'],
						'EMP_F_NUM' => $data['EMP_F_NUM'],
						'EMP_EMAIL' => $data['EMP_EMAIL'],
						'LEAD_STATUS' => $data['LEAD_STATUS'],
						'DEPART_ID' => $data['DEPART_ID'],
						'BRANCH_ID' => $rowbr['BRANCH_ID'],
						'BRANCH_NAME' => $rowbr['BRANCH_NAME'],
						'STATUSLOGIN' => "LOGIN",
						);
					$this->session->set_userdata($data_session);
					redirect(base_url("Dashboard"));
				}else{
					$this->session->set_flashdata("flashdata","Username Atau Password salah");
					redirect(base_url("Login"));
				}
			}				
		}

	function logout(){
		$this->session->sess_destroy();
		redirect(base_url('login'));
	}
}
?>