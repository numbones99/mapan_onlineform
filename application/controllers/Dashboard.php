<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
class Dashboard extends CI_Controller {

	function __construct(){
		parent::__construct();
		if($this->session->userdata('STATUSLOGIN') != "LOGIN"){
			redirect(base_url("Login"));
		}
	}
	
	public function index()
	{
		$this->load->view('templates/head');
		$this->load->view('templates/sidenav');
		$this->load->view('templates/template');
		$this->load->view('templates/footer');
	}
	public function emailbaru()
	{
		$this->load->view('templates/emailbaru');
	}
}