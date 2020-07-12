<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paket extends CI_Controller {


	function __construct(){
		parent::__construct();
		$this->load->library(array('form_validation','session'));
		$this->load->model('M_Paket');
		if(!$this->session->userdata('username'))
		{
			redirect('Login');
		}
	}

	public function index()
	{
		$data['paket']=$this->M_Paket->getDataPaket();
		$data['page']='Paket.php';
		$this->load->view('Admin/menu',$data);
	}

	public function addPaket()
	{
		$data['page']='addPaket.php';
		$this->load->view('Admin/menu',$data);
	}

	public function simpanPaket()
	{
		
		$data = array();
		$this->load->helper('url','form');
		$this->load->library("form_validation");
//        jika anda mau, anda bisa mengatur tampilan pesan error dengan menambahkan element dan css nya
		$this->form_validation->set_error_delimiters('<div style="color:red; margin-bottom: 5px">', '</div>');
		$this->form_validation->set_rules('nama_paket', 'Nama Paket', 'required');

		if($this->form_validation->run()==FALSE){
			$data['page']='addPaket.php';
			$this->load->view('Admin/menu',$data);
		}else{
			$upload = $this->M_Paket->upload();
			if($upload['result'] == "success"){ // Jika proses upload sukses
				$this->M_Paket->inputdata($upload);
				$this->session->set_flashdata('success','Tambah Paket berhasil');
				redirect('Paket');
			}else{ // Jika proses upload gagal
				$data['message'] = $upload['error'];
				$this->session->set_flashdata('error',$data['message']);
				redirect('Paket');
			}
		}
	}

	//ubah atau edit dengan foto kamera
	public function ubahPaket($id){
		$where = array('id_paket' => $id);
		$data['paket'] = $this->M_Paket->getdataID($where,'paket')->result();
		$data['page']='editPaket.php';
		$this->load->view('admin/menu',$data);
	}

	public function proses_ubah($id)
	{
		$Gambar = $_FILES['image']['name'];      
		if ($Gambar != null) {
			$uploadphoto = $this->M_Paket->upload();
			if($uploadphoto['result'] == 'success'){ 
				// Jika proses uploadphoto sukses
				$this->M_Paket->updatePaket($id,$uploadphoto['file']['file_name']);
				$this->session->set_flashdata('success','Ubah data berhasil');
				redirect('Paket','refresh');
				
				}else{ // Jika proses uploadphoto gagal
					$data['message'] = $uploadphoto['error'];
					$this->session->set_flashdata('error',$data['message']);
					redirect('Paket','refresh');
				}
			}
			else{
				$this->M_Paket->updatePaket($id);
				$this->session->set_flashdata('success','Ubah data berhasil');
				redirect('Paket','refresh');
			}			
		}
	

		function hapus_paket($id){
			$where = array('id_paket' => $id);
			$this->M_Paket->hapus($where,'paket');
			redirect('Paket/DataPaket');
		}
	}

	?>