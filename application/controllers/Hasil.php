<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hasil extends CI_Controller {


	function __construct(){
		parent::__construct();
		$this->load->library(array('form_validation','session'));
		
		$this->load->model('M_Hasil');
		if(!$this->session->userdata('username'))
		{
			redirect('Login');
		}
	}

	public function index()
	{
		$data['hasil']=$this->M_Hasil->getDataHasil();
		$data['page']='Hasil.php';
		$this->load->view('Admin/Menu',$data);
	}
}
?>