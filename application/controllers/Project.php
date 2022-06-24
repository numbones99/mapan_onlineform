a<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");

class Project extends CI_Controller {

	function __construct(){
		parent::__construct();
		if($this->session->userdata('STATUSLOGIN') != "LOGIN"){
			redirect(base_url("Login"));
		}
    }
	function get_data_proyek(){
		$branch = $this->input->post('id',true);
		// $branch = $this->uri->segment(3, 0);
		$branchmod = substr($branch,0,2).'/'.substr($branch,2,9);
		$arr_br = array(
			'BRANCH_ID' => $branchmod,
			'PR_STATUS !=' => '0'
		);
		$getbr = $this->Model_online->findAllDataWhere($arr_br,'tr_project');
		$array = [];
		foreach ($getbr as $getbr):
			$subarray = [];
			$subarray['PR_ID'] = $getbr['PR_ID'];
			$subarray['BRANCH_ID'] = $getbr['BRANCH_ID'];
			$subarray['PR_NAME'] = $getbr['PR_NAME'];
			$subarray['PR_TOTAL'] = $getbr['PR_TOTAL'];
			$subarray['PR_PAID_TOTAL'] = $getbr['PR_PAID_TOTAL'];
			$subarray['PR_SUB_DATE'] = $getbr['PR_SUB_DATE'];
			$subarray['PR_SUB_EMP'] = $getbr['PR_SUB_EMP'];
			$subarray['PR_LAST_UPDATE'] = $getbr['PR_LAST_UPDATE'];
			$subarray['ACTION'] = "<button>Action</button>";
			$subarray['DETAIL'] = [];
				$arr_detail = array(
					'PR_ID' => $getbr['PR_ID'],
				);
				$getdetail = $this->Model_online->findAllDataWhere($arr_detail,'tr_detail_project_sub');
				foreach($getdetail as $getdetail):
					$secondarray = [];
					$secondarray['DT_PRS_ID'] = $getdetail['DT_PRS_ID'];
					$secondarray['PR_ID'] = $getdetail['PR_ID'];
					$secondarray['DT_PRS_ITEM'] = $getdetail['DT_PRS_ITEM'];
					$secondarray['DT_PRS_VALUE'] = $getdetail['DT_PRS_VALUE'];
					$secondarray['DT_PRS_QTY'] = $getdetail['DT_PRS_QTY'];
					$secondarray['DT_PRS_TOTAL'] = $getdetail['DT_PRS_TOTAL'];
					$secondarray['EMP_ID'] = $getdetail['EMP_ID'];
					$secondarray['DT_PRS_SUB_DATE'] = $getdetail['DT_PRS_SUB_DATE'];
					$secondarray['DT_PRS_UP_DATE'] = $getdetail['DT_PRS_UP_DATE'];
					// $subarray['DETAIL'] = $secondarray;
					array_push($subarray['DETAIL'],$secondarray);
				endforeach;
			$subarray['DETAIL_REAL'] = [];
				$arr_detail_real = array(
					'PR_ID' => $getbr['PR_ID'],
				);
				$getdetail_real = $this->Model_online->findAllDataWhere($arr_detail_real,'tr_project_real');
				foreach($getdetail_real as $getdetail_real):
					$thirdarray = [];
					$thirdarray['PRR_ID'] = $getdetail_real['PRR_ID'];
					$thirdarray['PR_ID'] = $getdetail_real['PR_ID'];
					$thirdarray['PRR_NOTE'] = $getdetail_real['PRR_NOTE'];
					$thirdarray['PRR_VALUE'] = $getdetail_real['PRR_VALUE'];
					$thirdarray['PRR_PHOTO'] = $getdetail_real['PRR_PHOTO'];
					$thirdarray['PRR_SUB_DATE'] = $getdetail_real['PRR_SUB_DATE'];
					$thirdarray['PRR_SUB_EMP'] = $getdetail_real['PRR_SUB_EMP'];
					// $subarray['DETAIL_REAL'] = $thirdarray;
					array_push($subarray['DETAIL_REAL'],$thirdarray);
				endforeach;
			$array[] = $subarray;
		endforeach;
		$output = array(
			// "draw" => intval($_POST['draw']),
			// "length" => $_POST['length'],
			"recordTotal" => count($getbr),
			"recordFiltered" => count($getbr),
			"data" => $array
		);
		echo json_encode($output);
	}
    public function index(){
		$sql = "select * 
		from m_branch br
		join tr_project pr on br.BRANCH_ID = pr.BRANCH_ID
		where br.BRANCH_ID not in ('BR/0004','BR/0009','BR/0022')
		and pr.PR_STATUS = '0'
		group by br.BRANCH_ID";
		$data['branch'] = $this->db->query($sql)->result();
		$sqlall = "select * 
		from m_branch br
		join tr_project pr on br.BRANCH_ID = pr.BRANCH_ID
		where br.BRANCH_ID not in ('BR/0004','BR/0009','BR/0022')
		and pr.PR_STATUS = '0' ";
		$data['all'] = $this->db->query($sqlall)->result();
		$sqlalldone = "select * 
		from m_branch br
		join tr_project pr on br.BRANCH_ID = pr.BRANCH_ID
		where br.BRANCH_ID not in ('BR/0004','BR/0009','BR/0022')
		and pr.PR_STATUS = '3' ";
		$data['alldone'] = $this->db->query($sqlalldone)->result();
		$sqlallother = "select br.*,
		sum(pr.PR_TOTAL) as TOTAL_AJU, 
		sum(pr.PR_PAID_TOTAL) as TOTAL_BAYAR  
		from m_branch br
		join tr_project pr on br.BRANCH_ID = pr.BRANCH_ID
		where br.BRANCH_ID not in ('BR/0004','BR/0009','BR/0022')
		and pr.PR_STATUS = '0'
		group by br.BRANCH_ID";
		$data['allother'] = $this->db->query($sqlallother)->result();
		$sqlallotherdone = "select br.*,
		sum(pr.PR_TOTAL) as TOTAL_AJU, 
		sum(pr.PR_PAID_TOTAL) as TOTAL_BAYAR  
		from m_branch br
		join tr_project pr on br.BRANCH_ID = pr.BRANCH_ID
		where br.BRANCH_ID not in ('BR/0004','BR/0009','BR/0022')
		and pr.PR_STATUS = '3'
		group by br.BRANCH_ID";
		$data['allotherdone'] = $this->db->query($sqlallotherdone)->result();
		$sqlbranch = "select * from m_branch where BRANCH_ID not in ('BR/0004','BR/0009','BR/0022')";
		$data['allbranch'] = $this->db->query($sqlbranch)->result();
        $this->load->view('templates/head');
		$this->load->view('templates/sidenav');
		$this->load->view('project/projectmenu',$data);
		$this->load->view('templates/footer');
    }
	public function DetailProject($id){
		$branch = $id;
		// $branch = $this->uri->segment(3, 0);
		$branchmod = substr($branch,0,2).'/'.substr($branch,2,9);
		$sqlallother = "select br.*,
		sum(pr.PR_TOTAL) as TOTAL_AJU, 
		sum(pr.PR_PAID_TOTAL) as TOTAL_BAYAR  
		from m_branch br
		join tr_project pr on br.BRANCH_ID = pr.BRANCH_ID
		where br.BRANCH_ID = '".$branchmod."'
		and pr.PR_STATUS = '0'
		group by br.BRANCH_ID";
		$data['allother'] = $this->db->query($sqlallother)->row();
		$sqlallotherdone = "select br.*,
		sum(pr.PR_TOTAL) as TOTAL_AJU, 
		sum(pr.PR_PAID_TOTAL) as TOTAL_BAYAR  
		from m_branch br
		join tr_project pr on br.BRANCH_ID = pr.BRANCH_ID
		where br.BRANCH_ID = '".$branchmod."'
		and pr.PR_STATUS = '3'
		group by br.BRANCH_ID";
		$data['allotherdone'] = $this->db->query($sqlallotherdone)->row();
		$arr_br = array(
			'BRANCH_ID' => $branchmod,
			'PR_STATUS' => '0',
		);
		$arr_br2 = array(
			'BRANCH_ID' => $branchmod,
			'PR_STATUS' => '3',
		);
		$data['some'] = $this->Model_online->findAllDataWhereObj($arr_br,'tr_project');
		$getbr = $this->Model_online->findAllDataWhere($arr_br,'tr_project');
		$getbr2 = $this->Model_online->findAllDataWhere($arr_br2,'tr_project');
		$data['all'] = [];
		foreach ($getbr as $getbr):
			$subarray = [];
			$subarray['PR_ID'] = $getbr['PR_ID'];
			$subarray['BRANCH_ID'] = $getbr['BRANCH_ID'];
			$subarray['PR_NAME'] = $getbr['PR_NAME'];
			$subarray['PR_TOTAL'] = $getbr['PR_TOTAL'];
			$subarray['PR_PAID_TOTAL'] = $getbr['PR_PAID_TOTAL'];
			$subarray['PR_SUB_DATE'] = $getbr['PR_SUB_DATE'];
			$subarray['PR_SUB_EMP'] = $getbr['PR_SUB_EMP'];
			$subarray['PR_LAST_UPDATE'] = $getbr['PR_LAST_UPDATE'];
			$subarray['ACTION'] = "<button>Action</button>";
			$subarray['DETAIL'] = [];
					$arr_detail = array(
						'PR_ID' => $getbr['PR_ID'],
					);
					$getdetail = $this->Model_online->findAllDataWhere($arr_detail,'tr_detail_project_sub');
					foreach($getdetail as $getdetail):
						$secondarray = [];
						$secondarray['DT_PRS_ID'] = $getdetail['DT_PRS_ID'];
						$secondarray['PR_ID'] = $getdetail['PR_ID'];
						$secondarray['DT_PRS_ITEM'] = $getdetail['DT_PRS_ITEM'];
						$secondarray['DT_PRS_VALUE'] = $getdetail['DT_PRS_VALUE'];
						$secondarray['DT_PRS_QTY'] = $getdetail['DT_PRS_QTY'];
						$secondarray['DT_PRS_TOTAL'] = $getdetail['DT_PRS_TOTAL'];
						$secondarray['EMP_ID'] = $getdetail['EMP_ID'];
						$secondarray['DT_PRS_SUB_DATE'] = $getdetail['DT_PRS_SUB_DATE'];
						$secondarray['DT_PRS_UP_DATE'] = $getdetail['DT_PRS_UP_DATE'];
						// $subarray['DETAIL'] = $secondarray;
						array_push($subarray['DETAIL'],$secondarray);
					endforeach;
			$subarray['DETAIL_REAL'] = [];
					$arr_detail_real = array(
						'PR_ID' => $getbr['PR_ID'],
					);
					$getdetail_real = $this->Model_online->findAllDataWhere($arr_detail_real,'tr_project_real');
					foreach($getdetail_real as $getdetail_real):
						$thirdarray = [];
						$thirdarray['PRR_ID'] = $getdetail_real['PRR_ID'];
						$thirdarray['PR_ID'] = $getdetail_real['PR_ID'];
						$thirdarray['PRR_NOTE'] = $getdetail_real['PRR_NOTE'];
						$thirdarray['PRR_VALUE'] = $getdetail_real['PRR_VALUE'];
						$thirdarray['PRR_PHOTO'] = $getdetail_real['PRR_PHOTO'];
						$thirdarray['PRR_SUB_DATE'] = $getdetail_real['PRR_SUB_DATE'];
						$thirdarray['PRR_SUB_EMP'] = $getdetail_real['PRR_SUB_EMP'];
						array_push($subarray['DETAIL_REAL'],$thirdarray);
					endforeach;
			array_push($data['all'],$subarray);
		endforeach;
		$data['alldone'] = [];
		foreach ($getbr2 as $getbr2):
			$subarray = [];
			$subarray['PR_ID'] = $getbr2['PR_ID'];
			$subarray['BRANCH_ID'] = $getbr2['BRANCH_ID'];
			$subarray['PR_NAME'] = $getbr2['PR_NAME'];
			$subarray['PR_TOTAL'] = $getbr2['PR_TOTAL'];
			$subarray['PR_PAID_TOTAL'] = $getbr2['PR_PAID_TOTAL'];
			$subarray['PR_SUB_DATE'] = $getbr2['PR_SUB_DATE'];
			$subarray['PR_SUB_EMP'] = $getbr2['PR_SUB_EMP'];
			$subarray['PR_LAST_UPDATE'] = $getbr2['PR_LAST_UPDATE'];
			$subarray['ACTION'] = "<button>Action</button>";
			$subarray['DETAIL'] = [];
					$arr_detail = array(
						'PR_ID' => $getbr2['PR_ID'],
					);
					$getdetail = $this->Model_online->findAllDataWhere($arr_detail,'tr_detail_project_sub');
					foreach($getdetail as $getdetail):
						$secondarray = [];
						$secondarray['DT_PRS_ID'] = $getdetail['DT_PRS_ID'];
						$secondarray['PR_ID'] = $getdetail['PR_ID'];
						$secondarray['DT_PRS_ITEM'] = $getdetail['DT_PRS_ITEM'];
						$secondarray['DT_PRS_VALUE'] = $getdetail['DT_PRS_VALUE'];
						$secondarray['DT_PRS_QTY'] = $getdetail['DT_PRS_QTY'];
						$secondarray['DT_PRS_TOTAL'] = $getdetail['DT_PRS_TOTAL'];
						$secondarray['EMP_ID'] = $getdetail['EMP_ID'];
						$secondarray['DT_PRS_SUB_DATE'] = $getdetail['DT_PRS_SUB_DATE'];
						$secondarray['DT_PRS_UP_DATE'] = $getdetail['DT_PRS_UP_DATE'];
						// $subarray['DETAIL'] = $secondarray='' ? 'Kosong' : '$subarray['DETAIL']';
						array_push($subarray['DETAIL'],$secondarray);
					endforeach;
			$subarray['DETAIL_REAL'] = [];
					$arr_detail_real = array(
						'PR_ID' => $getbr2['PR_ID'],
					);
					$getdetail_real = $this->Model_online->findAllDataWhere($arr_detail_real,'tr_project_real');
					foreach($getdetail_real as $getdetail_real):
						$thirdarray = [];
						$thirdarray['PRR_ID'] = $getdetail_real['PRR_ID'];
						$thirdarray['PR_ID'] = $getdetail_real['PR_ID'];
						$thirdarray['PRR_NOTE'] = $getdetail_real['PRR_NOTE'];
						$thirdarray['PRR_VALUE'] = $getdetail_real['PRR_VALUE'];
						$thirdarray['PRR_PHOTO'] = $getdetail_real['PRR_PHOTO'];
						$thirdarray['PRR_SUB_DATE'] = $getdetail_real['PRR_SUB_DATE'];
						$thirdarray['PRR_SUB_EMP'] = $getdetail_real['PRR_SUB_EMP'];
						array_push($subarray['DETAIL_REAL'],$thirdarray);
					endforeach;
			array_push($data['alldone'],$subarray);
		endforeach;
		$this->load->view('templates/head');
		$this->load->view('templates/sidenav');
		$this->load->view('project/dashboard',$data);
		$this->load->view('templates/footer');
	}
	public function AddProject(){
		$insEmp = $this->input->post("insEmp");
		$insTgl = $this->input->post("insTgl");
		$insProyek = $this->input->post("insProyek");
		$insBr = $this->input->post("insBr");
		$insBrCode = $this->input->post("insBrCode");
		$year = date('Y');
		$generateid = $this->Model_online->kode('PR/'.$insBrCode.'/'.$year.'/', 15,'tr_project','PR_ID');
		$data = array(
			'PR_ID' => $generateid,
			'BRANCH_ID' => $insBr,
			'PR_NAME' => $insProyek,
			'PR_SUB_DATE' => date('Y-m-d H:i:s'),
			'PR_SUB_EMP' => $insEmp,
			'PR_LAST_UPDATE' => date('Y-m-d H:i:s'),
			'PR_STATUS' => '0',
			);
		$this->Model_online->input($data,"tr_project");
		$this->session->set_flashdata("flashdata","Anda Berhasil Menambahkan Proyek Baru");
		$refer =  $this->agent->referrer();
		redirect($refer);
	}
	public function CloseProject(){
		$clId = $this->input->post("clId");
		$clIdEmp = $this->input->post("clIdEmp");
		$arr_up = array(
			'PR_STATUS' => '3',
			'PR_LAST_UPDATE' => date('Y-m-d H:i:s'),
			'PR_CLOSE_EMP' => $clIdEmp,
		);
		$where_up = array(
			'PR_ID' => $clId,
		);
		$this->Model_online->update($where_up,$arr_up,"tr_project");
		$this->session->set_flashdata("flashdata","Anda Berhasil Menutup Proyek");
		$refer =  $this->agent->referrer();
		redirect($refer);
	}
	public function AddProjectMenu(){
		$insEmp = $this->input->post("insEmp");
		$insTgl = $this->input->post("insTgl");
		$insProyek = $this->input->post("insProyek");
		$insBr = $this->input->post("insBr");
		$exBr = explode("|",$insBr);
		$br_name = $exBr[0];
		$br_code = $exBr[1];
		$year = date('Y');
		$generateid = $this->Model_online->kode('PR/'.$br_code.'/'.$year.'/', 15,'tr_project','PR_ID');
		$data = array(
			'PR_ID' => $generateid,
			'BRANCH_ID' => $br_name,
			'PR_NAME' => $insProyek,
			'PR_SUB_DATE' => date('Y-m-d H:i:s'),
			'PR_SUB_EMP' => $insEmp,
			'PR_LAST_UPDATE' => date('Y-m-d H:i:s'),
			'PR_STATUS' => '0',
			);
		$this->Model_online->input($data,"tr_project");
		$this->session->set_flashdata("flashdata","Anda Berhasil Menambahkan Proyek");
		$refer =  $this->agent->referrer();
		redirect($refer);
	}
	public function AddDetail(){
		//set data
		$insDtItem = $this->input->post("insDtItem");
		$insParId = $this->input->post("insParId");
		$parMod = substr($insParId,-4); 
		$insQty = $this->input->post("insQty");
		$insValue = str_replace('.','',$this->input->post("insValue"));
		$insBrCode = $this->input->post("insBrCode");
		$generateid = $this->Model_online->kode('DT/PRS/'.$insBrCode.'/'.$parMod.'/', 20,'tr_detail_project_sub','DT_PRS_ID');
		//insert detail
		$data = array(
			'DT_PRS_ID' => $generateid,
			'PR_ID' => $insParId,
			'DT_PRS_ITEM' => $insDtItem,
			'DT_PRS_VALUE' => $insValue,
			'DT_PRS_QTY' => $insQty,
			'DT_PRS_TOTAL' => $insValue * $insQty,
			'EMP_ID' =>  $this->session->userdata('EMP_ID'),
			'DT_PRS_SUB_DATE' => date('Y-m-d H:i:s'),
			'DT_PRS_UP_DATE' => date('Y-m-d H:i:s'),
			);
		$this->Model_online->input($data,"tr_detail_project_sub");
		//total datanya
		$sqlsum = "select sum(DT_PRS_TOTAL) as TOTAL 
		from tr_detail_project_sub
		where PR_ID = '".$insParId."'";
		$datasum = $this->db->query($sqlsum)->row();
		//update ke table parent
		$arr_up = array(
			'PR_TOTAL' => $datasum->TOTAL,
			'PR_LAST_UPDATE' => date('Y-m-d H:i:s'),
		);
		$where_up = array(
			'PR_ID' => $insParId,
		);
		$this->Model_online->update($where_up,$arr_up,"tr_project");
		$this->session->set_flashdata("flashdata","Anda Berhasil Menambahkan Detail Proyek");
		//redirect
		$refer =  $this->agent->referrer();
		redirect($refer);
	}
	public function AddReal(){
		//set data
		$insRlItem = $this->input->post("insRlItem");
		$insParId = $this->input->post("insParId");
		$parMod = substr($insParId,-4); 
		$insRlValue = str_replace('.','',$this->input->post("insRlValue"));
		$insBrCode = $this->input->post("insBrCode");
		$year = date('Y');
		$yearall = date('ymdhis');
		$generateid = $this->Model_online->kode('PRR/'.$insBrCode.'/'.$year.'/', 16,'tr_project_real','PRR_ID');
		// atur config untuk upload
		$config['upload_path']          = './assets/doc-proyek/';
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		$config['max_size']             = 8048;
		$config['file_name']            = str_replace('/','',$generateid).'-'.$yearall.'.jpg';
		$this->load->library('upload', $config);
		//insert realisasi
		$data = array(
			'PRR_ID' => $generateid,
			'PR_ID' => $insParId,
			'PRR_NOTE' => $insRlItem,
			'PRR_VALUE' => $insRlValue,
			'PRR_PHOTO' => str_replace('/','',$generateid).'-'.$yearall.'.jpg',
			'PRR_SUB_DATE' => date('Y-m-d H:i:s'),
			'PRR_SUB_EMP' =>  $this->session->userdata('EMP_ID'),
			);
		$this->Model_online->input($data,"tr_project_real");
		if($this->upload->do_upload('insRlFoto')){
			$dataUpload = $this->upload->data();
			$this->image_lib->initialize(array(
				'image_library' => 'gd2', //library yang kita gunakan
				'source_image' => './assets/doc-proyek/'. $dataUpload['file_name'],
				'maintain_ratio' => TRUE,
				'create_thumb' => FALSE,
				'width' => 900,
				'height' => 900,
				'new_image' => './assets/doc-proyek/'. $dataUpload['file_name'],
			));
			$this->image_lib->resize();
		}
		//total datanya
		$sqlsum = "select sum(PRR_VALUE) as TOTAL 
		from tr_project_real
		where PR_ID = '".$insParId."'";
		$datasum = $this->db->query($sqlsum)->row();
		//update ke table parent
		$arr_up = array(
			'PR_PAID_TOTAL' => $datasum->TOTAL,
		);
		$where_up = array(
			'PR_ID' => $insParId,
		);
		$this->Model_online->update($where_up,$arr_up,"tr_project");
		$this->session->set_flashdata("flashdata","Anda Berhasil Menambahkan Pengeluaran Proyek");
		//redirect
		$refer =  $this->agent->referrer();
		redirect($refer);
	}
	public function UpdateDtProject(){
		//set data
		$upNama = $this->input->post("upNama");
		$upId = $this->input->post("upId");
		$upParId = $this->input->post("upParId");
		$upQty = $this->input->post("upQty");
		$upValue = str_replace('.','',$this->input->post("upValue"));
		//update detail
		$arr_up = array(
			'DT_PRS_ITEM' => $upNama,
			'DT_PRS_VALUE' => $upValue,
			'DT_PRS_QTY' => $upQty,
			'DT_PRS_TOTAL' => $upValue * $upQty,
			'DT_PRS_UP_DATE' => date('Y-m-d H:i:s'),
		);
		$where_up = array(
			'DT_PRS_ID' => $upId,
		);
		$this->Model_online->update($where_up,$arr_up,"tr_detail_project_sub");
		//total datanya
		$sqlsum = "select sum(DT_PRS_TOTAL) as TOTAL 
		from tr_detail_project_sub
		where PR_ID = '".$upParId."'";
		$datasum = $this->db->query($sqlsum)->row();
		//update ke table parent
		$arr_up = array(
			'PR_TOTAL' => $datasum->TOTAL,
			'PR_LAST_UPDATE' => date('Y-m-d H:i:s'),
		);
		$where_up = array(
			'PR_ID' => $upParId,
		);
		$this->Model_online->update($where_up,$arr_up,"tr_project");
		$this->session->set_flashdata("flashdata","Anda Berhasil Memperbarui Detail Proyek");
		//redirect
		$refer =  $this->agent->referrer();
		redirect($refer);
	}
	public function DeleteProject(){
		//set data
		$delId = $this->input->post("delId");
		//Delete detail
		$this->Model_online->deleteData('tr_project','PR_ID',$delId);
		$this->session->set_flashdata("flashdata","Anda Berhasil Menghapus Proyek");
		//redirect
		$refer =  $this->agent->referrer();
		redirect($refer);
	}
	public function DeleteDtProject(){
		//set data
		$delNama = $this->input->post("delNama");
		$delId = $this->input->post("delId");
		$delParId = $this->input->post("delParId");
		$delQty = $this->input->post("delQty");
		$delValue = str_replace('.','',$this->input->post("delValue"));
		//Delete detail
		$this->Model_online->deleteData('tr_detail_project_sub','DT_PRS_ID',$delId);
		//total datanya
		$sqlsum = "select sum(DT_PRS_TOTAL) as TOTAL 
		from tr_detail_project_sub
		where PR_ID = '".$delParId."'";
		$datasum = $this->db->query($sqlsum)->row();
		//update ke table parent
		$arr_up = array(
			'PR_TOTAL' => $datasum->TOTAL,
			'PR_LAST_UPDATE' => date('Y-m-d H:i:s'),
		);
		$where_up = array(
			'PR_ID' => $delParId,
		);
		$this->Model_online->update($where_up,$arr_up,"tr_project");
		$this->session->set_flashdata("flashdata","Anda Berhasil Menghapus Detail Proyek");
		//redirect
		$refer =  $this->agent->referrer();
		redirect($refer);
	}
	public function UpdateRealisasi(){
		//set data
		$upNama = $this->input->post("upNama");
		$upId = $this->input->post("upId");
		$upParId = $this->input->post("upParId");
		$upValue = str_replace('.','',$this->input->post("upValue"));
		$ymdhis_all = date('ymdhis');
		$foto = str_replace('/','',$upId).'-'.$ymdhis_all;
		if($_FILES['upFoto']['name'] <> ""){
			$filefoto = str_replace('/','',$upId);
			$sqlfoto = "select * 
			from tr_project_real 
			where PRR_PHOTO LIKE '".$filefoto."%';";
			$rowfoto = $this->db->query($sqlfoto)->row_array();
			$path = "./assets/doc-proyek/".$rowfoto['PRR_PHOTO'];
			unlink($path);
			clearstatcache();
			//update detail
			$arr_up = array(
				'PRR_NOTE' => $upNama,
				'PRR_VALUE' => $upValue,
				'PRR_SUB_DATE' => date('Y-m-d H:i:s'),
				'PRR_SUB_EMP' => $this->session->userdata('EMP_ID'),
				'PRR_PHOTO' => $foto.'.jpg',
			);
			$where_up = array(
				'PRR_ID' => $upId,
			);
			$this->Model_online->update($where_up,$arr_up,"tr_project_real");
			// atur config untuk upload
			$config['upload_path']          = './assets/doc-proyek/';
			$config['allowed_types']        = 'gif|jpg|png|jpeg';
			$config['max_size']             = 8048;
			$config['file_name']            = $foto.'.jpg';
			$this->load->library('upload', $config);
			if($this->upload->do_upload('upFoto')){
				$dataUpload = $this->upload->data();
				$this->image_lib->initialize(array(
					'image_library' => 'gd2', //library yang kita gunakan
					'source_image' => './assets/doc-proyek/'. $dataUpload['file_name'],
					'maintain_ratio' => TRUE,
					'create_thumb' => FALSE,
					'width' => 900,
					'height' => 900,
					'new_image' => './assets/doc-proyek/'. $dataUpload['file_name'],
				));
				$this->image_lib->resize();
			}
			//total datanya
			$sqlsum = "select sum(PRR_VALUE) as TOTAL 
			from tr_project_real
			where PR_ID = '".$upParId."'";
			$datasum = $this->db->query($sqlsum)->row();
			//update ke table parent
			$arr_up = array(
				'PR_TOTAL' => $datasum->TOTAL,
				'PR_LAST_UPDATE' => date('Y-m-d H:i:s'),
			);
			$where_up = array(
				'PR_ID' => $upParId,
			);
			$this->Model_online->update($where_up,$arr_up,"tr_project");
			$this->session->set_flashdata("flashdata","Anda Berhasil Memperbarui Detail Proyek");
			//redirect
			$refer =  $this->agent->referrer();
			redirect($refer);
		}else{
			//update detail
			$arr_up = array(
				'PRR_NOTE' => $upNama,
				'PRR_VALUE' => $upValue,
				'PRR_SUB_DATE' => date('Y-m-d H:i:s'),
				'PRR_SUB_EMP' => $this->session->userdata('EMP_ID'),
			);
			$where_up = array(
				'PRR_ID' => $upId,
			);
			$this->Model_online->update($where_up,$arr_up,"tr_project_real");
			//total datanya
			$sqlsum = "select sum(PRR_VALUE) as TOTAL 
			from tr_project_real
			where PR_ID = '".$upParId."'";
			$datasum = $this->db->query($sqlsum)->row();
			//update ke table parent
			$arr_up = array(
				'PR_PAID_TOTAL' => $datasum->TOTAL,
				'PR_LAST_UPDATE' => date('Y-m-d H:i:s'),
			);
			$where_up = array(
				'PR_ID' => $upParId,
			);
			$this->Model_online->update($where_up,$arr_up,"tr_project");
			$this->session->set_flashdata("flashdata","Anda Berhasil Memperbarui Detail Proyek");
			//redirect
			$refer =  $this->agent->referrer();
			redirect($refer);
		}
	}
	public function DeleteRealisasi(){
		//set data
		$delNama = $this->input->post("delNama");
		$delId = $this->input->post("delId");
		$delParId = $this->input->post("delParId");
		$delValue = str_replace('.','',$this->input->post("delValue"));
		$ymdhis_all = date('ymdhis');
		$foto = str_replace('/','',$delId).'-'.$ymdhis_all;
		//delfoto
		$filefoto = str_replace('/','',$delId);
		// print_r($filefoto);
		$sqlfoto = "select * 
		from tr_project_real 
		where PRR_PHOTO LIKE '".$filefoto."%';";
		$rowfoto = $this->db->query($sqlfoto)->row_array();
		$path = "./assets/doc-proyek/".$rowfoto['PRR_PHOTO'];
		unlink($path);
		clearstatcache();
		//Delete detail
		$this->Model_online->deleteData('tr_project_real','PRR_ID',$delId);
		//total datanya
		$sqlsum = "select sum(PRR_VALUE) as TOTAL 
		from tr_project_real
		where PR_ID = '".$delParId."'";
		$datasum = $this->db->query($sqlsum)->row();
		//update ke table parent
		$arr_up = array(
			'PR_PAID_TOTAL' => $datasum->TOTAL,
			'PR_LAST_UPDATE' => date('Y-m-d H:i:s'),
		);
		$where_up = array(
			'PR_ID' => $delParId,
		);
		$this->Model_online->update($where_up,$arr_up,"tr_project");
		$this->session->set_flashdata("flashdata","Anda Berhasil Menghapus Realisasi Proyek");
		//redirect
		$refer =  $this->agent->referrer();
		redirect($refer);
	}
}
?>