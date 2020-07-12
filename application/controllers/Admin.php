<?php 
 
class Admin extends CI_Controller{
 
	function __construct(){
		parent::__construct();
	
		if($this->session->userdata('status') != "login"){
			redirect(base_url("login"));
		}
	}
 
	function index(){
		$data['page']='Home.php';/*
		$this->load->view('v_admin');*/
		$this->load->view('Admin/Menu',$data);
	}
	
}