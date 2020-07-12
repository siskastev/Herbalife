<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Diskehan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('logged_in')) {

			$session_data=$this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$data['level']=$session_data['level'];
			$current_controller = $this->router->fetch_class();
			$this->load->library('Acl');
			if (! $this->acl->is_public($current_controller)){
				if (! $this->acl->is_allowed($current_controller, $data['level'])){
					//redirect('login/logout','refresh');
					echo '<script>alert("Anda tidak memiliki hak akses untuk mengakses halaman ini")</script>';
	                if($session_data['level'] == 'Dinas Pertanian'){
	                    redirect('Pertanian','refresh');
	                }

	                else if($session_data['level'] == 'Dinas Perikanan'){
	                    redirect('Perikanan','refresh');
	                }

	                else if($session_data['level'] == 'Dinas Peternakan'){
	                    redirect('Peternakan','refresh');
	                }
				}
			}
		}
		else{
			redirect('Login','refresh');
		}

		$this->session->set_userdata('username', $data['username']);
		$this->load->model("Diskehan_model");
        $this->load->library('form_validation');
		$this->load->library('session');
		$this->load->helper('url','form');
		
	}

	public function Logout()
    {
        $this->load->model("User");
        $session_data=$this->session->userdata('logged_in');
        $this->session->unset_userdata('logged_in');
        $this->session->sess_destroy();
        redirect('Welcome');
    }
	
	public function index()
	{
		$this->load->model([
			
			'Diskehan_model' => 'penduduk',
			
		]);
		 $komoditi = $this->Diskehan_model->getkomoditibyid(1);
		  //$komoditi = $this->Diskehan_model->getkomoditibyid(3);
		$data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/Dashboard',
			'menu'	=> 'dashboard',
			'title' => 'dashboard',
			'komoditi' => $komoditi,
			'footer'=> 'Diskehan/footer',
		];
		$this->load->view('Diskehan/template', $data);
	}

	public function kecamatan()
	{
		$kecamatan = $this->Diskehan_model->getkecamatan();
			$data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/kecamatan',
			'menu'	=> 'Data Penduduk',
			'title' => 'Data Kecamatan',
			'kecamatan' => $kecamatan,
			'footer' => 'Diskehan/footer',

		];
		$this->load->view('Diskehan/template',$data);
	}

	public function tambahkecamatan()
	{
		$this->form_validation->set_rules('kec_id','ID kecamatan','required',array('required' => '%s tidak boleh kosong.'));
		$this->form_validation->set_rules('kec_nama','Nama kecamatan','required',array('required' => '%s tidak boleh kosong.'));

		if($this->form_validation->run() == False)
		{
			$data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/form_kecamatan',
			'menu'	=> 'Data Penduduk',
			'title' => 'Tambah data kecamatan',
			'footer' => 'Diskehan/footer',
		];
			$this->load->view('Diskehan/template', $data);
		}
		else
		{
			$this->Diskehan_model->savekecamatan();
			$this->session->set_flashdata('flash','disimpan');
			$this->kecamatan();
			$this->session->set_flashdata('flash','');
		}	
	}

	public function hapuskecamatan($id)
	{
	    $this->Diskehan_model->deletekecamatan($id);       
	    $this->session->set_flashdata('flash','dihapus');
	    $this->kecamatan();
	    $this->session->set_flashdata('flash','');
	}

	public function penduduk()
	{
		$penduduk = $this->Diskehan_model->getpenduduk();
		$jumlahpenduduk = $this->Diskehan_model->getjumlahpenduduk();
		$data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/penduduk',
			'menu'	=> 'Data Penduduk',
			'title' => 'Data jumlah penduduk',
			'penduduk' => $penduduk,
			'jumlah' => $jumlahpenduduk,
			'footer' => 'Diskehan/footer',
		];
		$this->load->view('Diskehan/template',$data);
	}

	public function penduduk_search(){
		$kecamatan = $this->Diskehan_model->getkecamatan();
		$data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/search_penduduk',
			'menu'	=> 'Data Penduduk',
			'title' => 'Data jumlah penduduk',
			'kecamatan' => $kecamatan,
			'footer' => 'Diskehan/footer',
		];
		$this->load->view('Diskehan/template',$data);
	}

	public function get_search_penduduk(){
		$kec=$this->input->post('kec');
		$data=$this->Diskehan_model->ajax_search_penduduk($kec);
		echo json_encode($data);
	}

	public function carirowkosongpenduduk()
	{
		$i = 1;
		$x = 1;
		
		while($x != 0)
		{
			$data = $this->Diskehan_model->newrowpenduduk($i);
			$x = count($data);
			$i++;
		}

		$i = $i - 1;
		return $i;
	}

	public function tambahpenduduk()
	{
		$kecamatan = $this->Diskehan_model->getkecamatan();

		$this->form_validation->set_rules('pend_jml','Jumlah Penduduk','required',array('required' => '%s tidak boleh kosong.'));
		$this->form_validation->set_rules('pend_thn','Tahun Data','required',array('required' => '%s tidak boleh kosong.'));
		$this->form_validation->set_rules('pend_kec_id','Nama Kecamatan','required',array('required' => '%s tidak boleh kosong.'));

		if($this->form_validation->run() == False)
		{
			$data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/form_penduduk',
			'menu'	=> 'Data Penduduk',
			'title' => 'Tambah Data jumlah penduduk',
			'kecamatan' => $kecamatan,
			'footer' => 'Diskehan/footer'
			
		];
			$this->load->view('Diskehan/template',$data);
		}
		else
		{
			$barisbaru = $this->carirowkosongpenduduk();
			$this->Diskehan_model->savependuduk($barisbaru);
			$data['penduduk'] = $this->Diskehan_model->getpenduduk();
			$this->session->set_flashdata('flash','disimpan');
			$this->penduduk();
    		$this->session->set_flashdata('flash','');
		}	
	}

	public function editdatapenduduk($id)
	{
		$this->form_validation->set_rules('pend_jml','Jumlah Penduduk','required',array('required' => '%s tidak boleh kosong.'));
		$this->form_validation->set_rules('pend_thn','Tahun Data','required',array('required' => '%s tidak boleh kosong.'));

		if($this->form_validation->run() == False)
		{
			$penduduk = $this->Diskehan_model->getpendudukbyid($id);
			$data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/edit_penduduk',
			'menu'	=> 'Data Penduduk',
			'title' => 'Edit Data Penduduk',
			'penduduk' => $penduduk,
			'footer' => 'Diskehan/footer',

		];
		$this->load->view('Diskehan/template',$data);
		}
		else
		{
			$this->Diskehan_model->editdatapenduduk($id);
			$this->session->set_flashdata('flash','diupdate');
			$this->penduduk();
			$this->session->set_flashdata('flash','');
		}
	}

	public function hapusdatapenduduk($id)
	{
	    $this->Diskehan_model->hapusdatapenduduk($id);       
	    $this->session->set_flashdata('flash','dihapus');
	    $this->penduduk();
	    $this->session->set_flashdata('flash','');
	}

	public function komoditas_pertanian()
	{
		$komoditi = $this->Diskehan_model->getkomoditibyid(1);
			$data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/list_komoditi_pertanian',
			'menu'	=> 'Data Pertanian',
			'title' => 'Data Komoditas Pertanian',
			'komoditi' => $komoditi,
			'footer' => 'Diskehan/footer',
			
		];
			$this->load->view('Diskehan/template',$data);
	}

	public function carirowkosongkonsumsi()
	{
		$i = 1;
		$x = 1;
		
		while($x != 0)
		{
			$data = $this->Diskehan_model->newrowkonsumsi($i);
			$x = count($data);
			$i++;
		}

		$i = $i - 1;
		return $i;
	}

	public function konsumsi_pertanian()
	{
		$konsumsi = $this->Diskehan_model->getkonsumsipertanian();
		$data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/konsumsi_pertanian',
			'menu'	=> 'Data Pertanian',
			'title' => 'Data konsumsi Pertanian',
			'konsumsi' => $konsumsi,
			'footer' => 'Diskehan/footer'
		];
		$this->load->view('Diskehan/template',$data);
	}

	public function tambah_konsumsi_pertanian()
	{
		$komoditas = $this->Diskehan_model->getkomoditibyid(1);

		$this->form_validation->set_rules('kons_det_kmd_id','Jenis Komoditi','required',array('required' => '%s tidak boleh kosong.'));
		$this->form_validation->set_rules('kons_thn','Tahun','required',array('required' => '%s tidak boleh kosong.'));
		$this->form_validation->set_rules('kons_jml','Jumlah Konsumsi','required',array('required' => '%s tidak boleh kosong.'));
		
		if($this->form_validation->run() == False)
		{
			$data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/form_konsumsi_pertanian',
			'menu'	=> 'Data Pertanian',
			'title' => 'Data konsumsi Pertanian',
			'komoditas' => $komoditas,
			'footer' => 'Diskehan/footer',

		];
		$this->load->view('Diskehan/template',$data);
		}
		else
		{
			$barisbaru = $this->carirowkosongkonsumsi();
			$this->Diskehan_model->savekonsumsi($barisbaru);
			$this->session->set_flashdata('flash','disimpan');
			$this->konsumsi_pertanian();
			$this->session->set_flashdata('flash','');
		}	      
	}

	public function edit_konsumsi_pertanian($id)
	{
        $this->form_validation->set_rules('kons_det_kmd_id','Jenis Komoditi','required',array('required' => '%s tidak boleh kosong.'));
		$this->form_validation->set_rules('kons_thn','Tahun','required',array('required' => '%s tidak boleh kosong.'));
		$this->form_validation->set_rules('kons_jml','Jumlah Konsumsi','required',array('required' => '%s tidak boleh kosong.'));
		
		if($this->form_validation->run() == False)
		{
			$komoditas = $this->Diskehan_model->getkomoditibyid(1);
			$konsumsi = $this->Diskehan_model->getdatakonsumsibyid($id);
			$data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/edit_konsumsi_pertanian',
			'menu'	=> 'Data Pertanian',
			'title' => 'Data konsumsi Pertanian',
			'komoditas' => $komoditas,
			'konsumsi' => $konsumsi,
			'footer' => 'Diskehan/footer',

		];
		$this->load->view('Diskehan/template',$data);
		}
		else
		{
			$this->Diskehan_model->editkonsumsi($id);
			$this->session->set_flashdata('flash','diupdate');
			$this->konsumsi_pertanian();
			$this->session->set_flashdata('flash','');
		}	
	}

	public function hapus_konsumsi_pertanian($id)
	{
	    $this->Diskehan_model->hapusdatakonsumsi($id);       
	    $this->session->set_flashdata('flash','dihapus');
	    $this->konsumsi_pertanian();
	    $this->session->set_flashdata('flash','');
	}

	public function carirowkosongkomoditas()
	{
		$this->load->model('Diskehan_model');
		
		$i = 1;
		$x = 1;
		
		while($x != 0)
		{
			$data = $this->Diskehan_model->newrowkomoditas($i);
			$x = count($data);
			$i++;
		}

		$i = $i - 1;
		return $i;
	}

	public function data_komoditas_pertanian()
	{
		$data_komoditas = $this->Diskehan_model->getdatakomoditasbyid(1);
		$data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/data_komoditas_pertanian',
			'menu'	=> 'Data Pertanian',
			'title' => 'Data komoditas Pertanian',
			'data_komoditas' => $data_komoditas,
			'footer' => 'Diskehan/footer',

		];
		$this->load->view('Diskehan/template',$data);
	}

	public function tambah_komoditas_pertanian()
	{
		$kecamatan = $this->Diskehan_model->getkecamatan();
		$komoditas = $this->Diskehan_model->getkomoditibyid(1);

		$this->form_validation->set_rules('det_kmd_id','Jenis Komoditi','required',array('required' => '%s tidak boleh kosong.'));
		$this->form_validation->set_rules('kec_id','Nama Kecamatan','required',array('required' => '%s tidak boleh kosong.'));
// 		$this->form_validation->set_rules('tanam','Jumlah Tanam','required',array('required' => '%s tidak boleh kosong.'));
// 		$this->form_validation->set_rules('panen','Jumlah Panen','required',array('required' => '%s tidak boleh kosong.'));
// 		$this->form_validation->set_rules('provitas','Jumlah Provitas','required',array('required' => '%s tidak boleh kosong.'));
// 		$this->form_validation->set_rules('produksi','Jumlah Produksi','required',array('required' => '%s tidak boleh kosong.'));
		$this->form_validation->set_rules('bulan','Nama Bulan','required',array('required' => '%s tidak boleh kosong.'));
		$this->form_validation->set_rules('tahun','Nama Tahun','required',array('required' => '%s tidak boleh kosong.'));
		
		if($this->form_validation->run() == False)
		{
			$data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/form_komoditas_pertanian',
			'menu'	=> 'Data Pertanian',
			'title' => 'Tambah Data Komoditas Pertanian',
			'kecamatan' => $kecamatan,
			'komoditas' => $komoditas,
			'footer' => 'Diskehan/footer',

		];
			$this->load->view('Diskehan/template',$data);
		}
		else
		{
			$barisbaru = $this->carirowkosongkomoditas();
			$this->Diskehan_model->savekomoditas($barisbaru);
			$this->session->set_flashdata('flash','disimpan');
			$this->data_komoditas_pertanian();
			$this->session->set_flashdata('flash','');
		}	      
	}

	public function edit_komoditas_pertanian($id)
	{
	    $kecamatan = $this->Diskehan_model->getkecamatan();
		$listkomoditas = $this->Diskehan_model->getkomoditibyid(1);
	    $komoditas = $this->Diskehan_model->getdatakomoditasforupdate($id);
	    
		$this->form_validation->set_rules('det_kmd_id','Jenis Komoditi','required',array('required' => '%s tidak boleh kosong.'));
		$this->form_validation->set_rules('kec_id','Nama Kecamatan','required',array('required' => '%s tidak boleh kosong.'));
// 		$this->form_validation->set_rules('tanam','Jumlah Tanam','required',array('required' => '%s tidak boleh kosong.'));
// 		$this->form_validation->set_rules('panen','Jumlah Panen','required',array('required' => '%s tidak boleh kosong.'));
// 		$this->form_validation->set_rules('provitas','Jumlah Provitas','required',array('required' => '%s tidak boleh kosong.'));
// 		$this->form_validation->set_rules('produksi','Jumlah Produksi','required',array('required' => '%s tidak boleh kosong.'));
		$this->form_validation->set_rules('bulan','Nama Bulan','required',array('required' => '%s tidak boleh kosong.'));
		$this->form_validation->set_rules('tahun','Nama Tahun','required',array('required' => '%s tidak boleh kosong.'));

		if($this->form_validation->run() == False)
		{
		    $data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/edit_komoditas_pertanian',
			'menu'	=> 'Data Pertanian',
			'title' => 'Update Data Komoditas Pertanian',
			'kecamatan' => $kecamatan,
			'listkomoditas' => $listkomoditas,
			'komoditas' => $komoditas,
			'footer' => 'Diskehan/footer',

		];
			$this->load->view('Diskehan/template',$data);
		}
		else
		{
			$this->Diskehan_model->updatekomoditaspertanian($id);
			$this->session->set_flashdata('flash','diupdate');
			$this->data_komoditas_pertanian();
			$this->session->set_flashdata('flash','');
		}
	}

	public function hapus_komoditas_pertanian($id)
	{
	    $this->Diskehan_model->hapusdatakomoditas($id);       
	    $this->session->set_flashdata('flash','dihapus');
	    $this->data_komoditas_pertanian();
	    $this->session->set_flashdata('flash','');
	}

	public function komoditas_pertanian_search(){
	    $tahun = $this->Diskehan_model->listyear();
		$kecamatan = $this->Diskehan_model->getkecamatan();
		$komoditi = $this->Diskehan_model->getkomoditibyid(1);
		$data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/search_komoditas_pertanian',
			'menu'	=> 'Data Pertanian',
			'title' => 'Data komoditas Pertanian',
			'kecamatan' => $kecamatan,
			'komoditi' => $komoditi,
			'tahun' => $tahun,
			'footer' => 'Diskehan/footer',
		];
		$this->load->view('Diskehan/template',$data);
	}

	public function get_search_komoditas(){
		$kec_id=$this->input->post('kec_id');
		$kom_id=$this->input->post('kom_id');
		$tahun=$this->input->post('tahun');
		$data=$this->Diskehan_model->ajax_search_komoditas($kec_id, $kom_id, $tahun);
		echo json_encode($data);
	}
	
	public function get_surplus_komoditas(){
		$kec_id=$this->input->post('kec_id');
		$kom_id=$this->input->post('kom_id');
		$tahun=$this->input->post('tahun');
		$bulan=$this->input->post('bulan');
		$data=$this->Diskehan_model->getkebutuhan($kec_id, $bulan, $kom_id, $tahun);
		echo json_encode($data);
	}
	
	public function get_surplus_komoditas_perikananpeternakan(){
		$kom_id=$this->input->post('kom_id');
		$tahun=$this->input->post('tahun');
		$bulan=$this->input->post('bulan');
		$kebutuhan=$this->Diskehan_model->getkonsumsipeternakanperikanan($bulan, $kom_id, $tahun);
		$penduduk=$this->Diskehan_model->getpendudukkabupatenbytahun($tahun);
		echo json_encode(array($kebutuhan,$penduduk));
	}

	//mulai rekap-rekap

	function rekap_pertanian(){
	    $kecamatan = $this->Diskehan_model->getkecamatan();
	    $tahun = $this->Diskehan_model->listyear();
		$data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/Rekap_pertanian',
			'menu'	=> 'Data Pertanian',
			'title' => 'Rekap Kebutuhan Pangan Pertanian',
			'footer' => 'Diskehan/footer',
			'tahun' => $tahun,
			'kecamatan' => $kecamatan
		];
		$this->load->view('Diskehan/template',$data);
	}
	
	function rekap_peternakan(){
	    $tahun = $this->Diskehan_model->listyear();
		$data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/Rekap_peternakan',
			'menu'	=> 'Data Peternakan',
			'title' => 'Rekap Kebutuhan Pangan Peternakan',
			'tahun' => $tahun,
			'footer' => 'Diskehan/footer',
		];
		$this->load->view('Diskehan/template',$data);
	}
	
	function rekap_perikanan(){
	    $tahun = $this->Diskehan_model->listyear();
		$data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/Rekap_perikanan',
			'menu'	=> 'Data Perikanan',
			'title' => 'Rekap Perikanan',
			'footer' => 'Diskehan/footer',
            'tahun' => $tahun,
		];
		$this->load->view('Diskehan/template',$data);
	}
	
	function get_rekap(){
	    $tipe = $this->input->post('tipe');
	    $tahun= $this->input->post('tahun');
		$bulan = $this->input->post('bulan');
		$kecamatan = $this->input->post('kec_id');
		
		$newdata;
		$penduduk = array();
		$konsumsi = array();
		$kebutuhan = array();
		$komoditas = array();
		
		$pr_penduduk = array();
		$pr_konsumsi = array();
		$pr_kebutuhan = array();
		$pr_komoditas_tanam = array();
		$pr_komoditas_panen = array();
		$pr_komoditas_provitas = array();
		$pr_komoditas_produksi = array();
		$pr_komoditas_ketersediaan = array();
		$pr_komoditas_surplus = array();
		$pr_komoditas_psb = array();
		
		
		$namafile = "";
		$judul = "";
		
		if($tipe == '1'){
		    //PERTANIAN
		    
		    $namafile = "Pertanian - ".$tahun;
		    
		     if($bulan == "SEMUA" AND $kecamatan == "SEMUA"){
		             $judul = "KABUPATEN MALANG TAHUN : ".$tahun." PERIODE : SATU TAHUN"; 
		    }
		     else if($kecamatan == "SEMUA"){
		             $judul = "KABUPATEN MALANG TAHUN : ".$tahun." PERIODE : BULAN ".$bulan; 
		    }
		    else if($bulan == "SEMUA"){
		              $namakecamatan = $this->Diskehan_model->getkecamatanbyid($kecamatan);
		              $judul = "KECAMATAN ".$namakecamatan[0]->kec_nama." TAHUN : ".$tahun." PERIODE : SATU TAHUN"; 
		    }
		    else{
		             $namakecamatan = $this->Diskehan_model->getkecamatanbyid($kecamatan);
		             $judul = "KECAMATAN ".$namakecamatan[0]->kec_nama." TAHUN : ".$tahun." PERIODE : BULAN ".$bulan; 
		    }
		    
		    $komoditi = $this->Diskehan_model->getkomoditibyid(1);
		    //penduduk
    		if($kecamatan == "SEMUA"){
    		    $penduduk= $this->Diskehan_model->ajax_rekap_penduduk($tahun);
    		    
    		    
    		   for($i = 0; $i < 12; $i++){
        		  array_push($pr_penduduk,$penduduk[0]->jumlah_penduduk);
        		}
    		}
    		else{
    		    $penduduk= $this->Diskehan_model->ajax_rekap_penduduk_perkecamatan($tahun, $kecamatan);
    		    for($i = 0; $i < 12; $i++){
        		  array_push($pr_penduduk,$penduduk[0]->jumlah_penduduk);
        		}
    		}
    		
    		
    		//konsumsi
    		if($kecamatan == "SEMUA" && $bulan == "SEMUA"){
    		    for ($i = 0; $i < count($komoditi); $i++) {
    		    $newdata = $this->Diskehan_model->ajax_rekap_konsumsi_pertanian($tahun, $komoditi[$i]->det_kmd_nama);
    		    array_push($konsumsi, $newdata);
    		    }
    		    
    		    foreach($konsumsi as $value){
    		        if($value == null){
    		            array_push($pr_konsumsi, '-');
    		        }
    		        else{
    		            array_push($pr_konsumsi, $value[0]->total_konsumsi);
    		        }
    		    }
    		}
    		else if($kecamatan == "SEMUA"){
        		    for ($i = 0; $i < count($komoditi); $i++) {
        		        $newdata = $this->Diskehan_model->ajax_rekap_konsumsi_pertanian_perkecamatan($tahun, $komoditi[$i]->det_kmd_nama);
        		        array_push($konsumsi, $newdata);
        		    }
        		
        		   for($i = 0; $i < 12; $i++){
        		       if($konsumsi[$i][0]->total_konsumsi == null){
        		           array_push($pr_konsumsi,'-');
        		       }
        		       else{
    		            array_push($pr_konsumsi, $konsumsi[$i][0]->total_konsumsi);
    		            }
        		   }
    		}
    		else if($bulan == "SEMUA"){
        		    for ($i = 0; $i < count($komoditi); $i++) {
        		    $newdata = $this->Diskehan_model->ajax_rekap_konsumsi_pertanian_perkecamatan_satutahun($tahun, $komoditi[$i]->det_kmd_nama, $kecamatan);
        		    array_push($konsumsi, $newdata);
        		}
        		
        		for($i = 0; $i < 12; $i++){
        		       if($konsumsi[$i][0]->total_konsumsi == null){
        		           array_push($pr_konsumsi,'-');
        		       }
        		       else{
    		            array_push($pr_konsumsi, $konsumsi[$i][0]->total_konsumsi);
    		            }
        		   }
    		}
    		else{
    		     for ($i = 0; $i < count($komoditi); $i++) {
        		    $newdata = $this->Diskehan_model->ajax_rekap_konsumsi_persatuan($tahun, $komoditi[$i]->det_kmd_nama, $kecamatan, $bulan);
        		    array_push($konsumsi, $newdata);
        		}
        		
        		 foreach($konsumsi as $value){
    		        if($value == null){
    		            array_push($pr_konsumsi, '-');
    		        }
    		        else{
    		            array_push($pr_konsumsi, $value[0]->total_konsumsi);
    		        }
    		    }
    		}
    		
    		//kebutuhan
    		if($kecamatan == "SEMUA" && $bulan == "SEMUA"){
    		    for ($i = 0; $i < count($komoditi); $i++) {
    		         $newdata = $this->Diskehan_model->ajax_rekap_kebutuhan_pertanian_satutahun($tahun,$komoditi[$i]->det_kmd_nama);
    		         array_push($kebutuhan, $newdata);
    	    	}
    	    	
    	    	for($i = 0; $i < 12; $i++){
        		       if($kebutuhan[$i][0]->jml_kebutuhan == null){
        		           array_push($pr_kebutuhan,'-');
        		       }
        		       else{
    		            array_push($pr_kebutuhan, number_format($kebutuhan[$i][0]->jml_kebutuhan,3));
    		            }
        		   } 
    		}
    		else if($kecamatan == "SEMUA"){
    		    for ($i = 0; $i < count($komoditi); $i++) {
    		         $newdata = $this->Diskehan_model->ajax_rekap_kebutuhan_pertanian($tahun,$bulan,$komoditi[$i]->det_kmd_nama);
    		         array_push($kebutuhan, $newdata);
    	    	}
    	    	
    	    	 for($i = 0; $i < 12; $i++){
        		       if($kebutuhan[$i][0]->jml_kebutuhan == null){
        		           array_push($pr_kebutuhan,'-');
        		       }
        		       else{
    		            array_push($pr_kebutuhan, number_format($kebutuhan[$i][0]->jml_kebutuhan,3));
    		            }
        		   } 
    		}
    		else if($bulan == "SEMUA"){ 
    		    for ($i = 0; $i < count($komoditi); $i++) {
    		         $newdata = $this->Diskehan_model->ajax_rekap_kebutuhan_pertanian_satutahun_perkecamatan($tahun,$kecamatan,$komoditi[$i]->det_kmd_nama);
    		         array_push($kebutuhan, $newdata);
    	    	}
    	    	
    	    		for($i = 0; $i < 12; $i++){
        		       if($kebutuhan[$i][0]->jml_kebutuhan == null){
        		           array_push($pr_kebutuhan,'-');
        		       }
        		       else{
    		            array_push($pr_kebutuhan, number_format($kebutuhan[$i][0]->jml_kebutuhan,3));
    		            }
        		   }
    		}
    		else{
    		    for ($i = 0; $i < count($komoditi); $i++) {
    		         $newdata = $this->Diskehan_model->ajax_rekap_kebutuhan_pertanian_persatuan($tahun,$kecamatan,$komoditi[$i]->det_kmd_nama, $bulan);
    		         array_push($kebutuhan, $newdata);
    	    	}
    	    	
    	    	foreach($kebutuhan as $value){
        		       if($value == null){
        		           array_push($pr_kebutuhan,'-');
        		       }
        		       else{
    		            array_push($pr_kebutuhan, number_format($value[0]->jml_kebutuhan,3));
    		            }
        		   }
    		    }
    		    
    		 //data komoditas
        		if($kecamatan == "SEMUA" && $bulan == "SEMUA"){
        		    for ($i = 0; $i < count($komoditi); $i++) {
        		         $newdata = $this->Diskehan_model->ajax_rekap_pertanian_satutahun($tahun,$komoditi[$i]->det_kmd_nama);
        		         array_push($komoditas, $newdata);
        	    	}
        	    	
        	    	for($i = 0; $i < 12; $i++){
        		       if($komoditas[$i][0]->tanam != null){
        		           if($komoditas[$i][0]->tanam != 0){
        		                array_push($pr_komoditas_tanam, number_format($komoditas[$i][0]->tanam,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_tanam,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->panen != 0){
        		                array_push($pr_komoditas_panen, number_format($komoditas[$i][0]->panen,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_panen,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->provitas != 0){
        		                array_push($pr_komoditas_provitas, number_format($komoditas[$i][0]->provitas,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_provitas,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->produksi != 0){
        		                array_push($pr_komoditas_produksi, number_format($komoditas[$i][0]->produksi,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_produksi,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->ketersediaan != 0){
        		                array_push($pr_komoditas_ketersediaan, number_format($komoditas[$i][0]->ketersediaan,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_ketersediaan,"-");
        		           }
        		           
        		          // if($komoditas[$i][0]->surplus != 0){
        		          //      array_push($pr_komoditas_surplus, number_format($komoditas[$i][0]->surplus,3));
        		          // }
        		          // else{
        		          //     array_push($pr_komoditas_surplus,"-");
        		          // }
        		           
        		           if($komoditas[$i][0]->psb != 0){
        		                array_push($pr_komoditas_psb, number_format($komoditas[$i][0]->psb,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_psb,"-");
        		           }
        		       }
        		       else{
        		           array_push($pr_komoditas_tanam,"-");
        		           array_push($pr_komoditas_panen,"-");
        		           array_push($pr_komoditas_provitas,"-");
        		           array_push($pr_komoditas_produksi,"-");
        		           array_push($pr_komoditas_ketersediaan,"-");
        		          // array_push($pr_komoditas_surplus,"-");
        		           array_push($pr_komoditas_psb,"-");
        		       }
        	    	}
        		}
        		else if($kecamatan == "SEMUA")
        		{
        		    for ($i = 0; $i < count($komoditi); $i++) {
        		         $newdata = $this->Diskehan_model->ajax_rekap_pertanian($tahun,$bulan,$komoditi[$i]->det_kmd_nama);
        		         array_push($komoditas, $newdata);
        	    	}
        	    	
        	    	 for($i = 0; $i < 12; $i++){
        		       if($komoditas[$i][0]->tanam != null){
        		           if($komoditas[$i][0]->tanam != 0){
        		                array_push($pr_komoditas_tanam, number_format($komoditas[$i][0]->tanam,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_tanam,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->panen != 0){
        		                array_push($pr_komoditas_panen, number_format($komoditas[$i][0]->panen,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_panen,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->provitas != 0){
        		                array_push($pr_komoditas_provitas, number_format($komoditas[$i][0]->provitas,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_provitas,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->produksi != 0){
        		                array_push($pr_komoditas_produksi, number_format($komoditas[$i][0]->produksi,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_produksi,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->ketersediaan != 0){
        		                array_push($pr_komoditas_ketersediaan, number_format($komoditas[$i][0]->ketersediaan,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_ketersediaan,"-");
        		           }
        		           
        		          // if($komoditas[$i][0]->surplus != 0){
        		          //      array_push($pr_komoditas_surplus, number_format($komoditas[$i][0]->surplus,3));
        		          // }
        		          // else{
        		          //     array_push($pr_komoditas_surplus,"-");
        		          // }
        		           
        		           if($komoditas[$i][0]->psb != 0){
        		                array_push($pr_komoditas_psb, number_format($komoditas[$i][0]->psb,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_psb,"-");
        		           }
        		       }
        		       else{
        		           array_push($pr_komoditas_tanam,"-");
        		           array_push($pr_komoditas_panen,"-");
        		           array_push($pr_komoditas_provitas,"-");
        		           array_push($pr_komoditas_produksi,"-");
        		           array_push($pr_komoditas_ketersediaan,"-");
        		          // array_push($pr_komoditas_surplus,"-");
        		           array_push($pr_komoditas_psb,"-");
        		       }
        	    	 }
        		}
        		else if($bulan == "SEMUA"){
        		    for ($i = 0; $i < count($komoditi); $i++) {
        		         $newdata = $this->Diskehan_model->ajax_rekap_pertanian_perkecamatan($tahun,$kecamatan,$komoditi[$i]->det_kmd_nama);
        		         array_push($komoditas, $newdata);
        	    	}
        	    	
        	    	   for($i = 0; $i < 12; $i++){
        		       if($komoditas[$i][0]->tanam != null){
        		           if($komoditas[$i][0]->tanam != 0){
        		                array_push($pr_komoditas_tanam, number_format($komoditas[$i][0]->tanam,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_tanam,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->panen != 0){
        		                array_push($pr_komoditas_panen, number_format($komoditas[$i][0]->panen,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_panen,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->provitas != 0){
        		                array_push($pr_komoditas_provitas, number_format($komoditas[$i][0]->provitas,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_provitas,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->produksi != 0){
        		                array_push($pr_komoditas_produksi, number_format($komoditas[$i][0]->produksi,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_produksi,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->ketersediaan != 0){
        		                array_push($pr_komoditas_ketersediaan, number_format($komoditas[$i][0]->ketersediaan,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_ketersediaan,"-");
        		           }
        		           
        		          // if($komoditas[$i][0]->surplus != 0){
        		          //      array_push($pr_komoditas_surplus, number_format($komoditas[$i][0]->surplus,3));
        		          // }
        		          // else{
        		          //     array_push($pr_komoditas_surplus,"-");
        		          // }
        		           
        		           if($komoditas[$i][0]->psb != 0){
        		                array_push($pr_komoditas_psb, number_format($komoditas[$i][0]->psb,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_psb,"-");
        		           }
        		       }
        		       else{
        		           array_push($pr_komoditas_tanam,"-");
        		           array_push($pr_komoditas_panen,"-");
        		           array_push($pr_komoditas_provitas,"-");
        		           array_push($pr_komoditas_produksi,"-");
        		           array_push($pr_komoditas_ketersediaan,"-");
        		          // array_push($pr_komoditas_surplus,"-");
        		           array_push($pr_komoditas_psb,"-");
        		       }
        	    	}
        		}
        		else{
        		    for ($i = 0; $i < count($komoditi); $i++) {
        		         $newdata = $this->Diskehan_model->ajax_rekap_pertanian_persatuan($tahun,$kecamatan,$komoditi[$i]->det_kmd_nama, $bulan);
        		         array_push($komoditas, $newdata);
        	    	}
        	    	
        	    	for($i = 0; $i < 12; $i++){
        		       if(count($komoditas[$i]) > 0){
        		           if($komoditas[$i][0]->tanam != 0){
        		                array_push($pr_komoditas_tanam, number_format($komoditas[$i][0]->tanam,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_tanam,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->panen != 0){
        		                array_push($pr_komoditas_panen, number_format($komoditas[$i][0]->panen,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_panen,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->provitas != 0){
        		                array_push($pr_komoditas_provitas, number_format($komoditas[$i][0]->provitas,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_provitas,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->produksi != 0){
        		                array_push($pr_komoditas_produksi, number_format($komoditas[$i][0]->produksi,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_produksi,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->ketersediaan != 0){
        		                array_push($pr_komoditas_ketersediaan, number_format($komoditas[$i][0]->ketersediaan,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_ketersediaan,"-");
        		           }
        		           
        		          // if($komoditas[$i][0]->surplus != 0){
        		          //      array_push($pr_komoditas_surplus, number_format($komoditas[$i][0]->surplus,3));
        		          // }
        		          // else{
        		          //     array_push($pr_komoditas_surplus,"-");
        		          // }
        		           
        		           if($komoditas[$i][0]->psb != 0){
        		                array_push($pr_komoditas_psb, number_format($komoditas[$i][0]->psb,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_psb,"-");
        		           }
        		       }
        		       else{
        		           array_push($pr_komoditas_tanam,"-");
        		           array_push($pr_komoditas_panen,"-");
        		           array_push($pr_komoditas_provitas,"-");
        		           array_push($pr_komoditas_produksi,"-");
        		           array_push($pr_komoditas_ketersediaan,"-");
        		          // array_push($pr_komoditas_surplus,"-");
        		           array_push($pr_komoditas_psb,"-");
        		       }
        		   }
        		}
        		
        		 	for($i = 0; $i < 12; $i++){
        		 	    $komoditi[$i] = $komoditi[$i]->det_kmd_nama;
        		 	}
        		 	
        		 		for($i = 0; $i < 12; $i++){ 
        		 	    	$newsurplus = 0;
                    		$newketersediaan = 0;
                    		$newkebutuhan = 0;
                    		if($pr_komoditas_ketersediaan[$i] == "-"){
                    		    $newkebutuhan = (float)(str_replace(",", "", $pr_kebutuhan[$i]));
                    		    $newsurplus = 0 - $newkebutuhan;
                    		    array_push($pr_komoditas_surplus, $newsurplus);
                    		}
                    		else if($pr_kebutuhan[$i] == "-"){
                    		    $newketersediaan = (float)(str_replace(",", "", $pr_komoditas_ketersediaan[$i]));
                    		    $newsurplus = $newketersediaan - 0;
                    		    array_push($pr_komoditas_surplus, $newsurplus);
                    		}
                    		else if($pr_kebutuhan[$i] == "-" && $pr_komoditas_ketersediaan[$i] == "-"){
                    		    $newsurplus = 0;
                    		    array_push($pr_komoditas_surplus, $newsurplus);
                    		}
                    		else{
                    		    $newkebutuhan = (float)(str_replace(",", "", $pr_kebutuhan[$i]));
                    		    $newketersediaan = (float)(str_replace(",", "", $pr_komoditas_ketersediaan[$i]));
                    		    $newsurplus = $newketersediaan - $newkebutuhan;
                    		    array_push($pr_komoditas_surplus, $newsurplus);
                    		}
        		 	};
		}
		
		else if($tipe == '2'){
		    
		        $namafile = "Peternakan - ".$tahun;
		        
		        if($bulan == "SEMUA"){
		             $judul = "KABUPATEN MALANG TAHUN : ".$tahun." PERIODE : SATU TAHUN"; 
		        }
		        else{
		             $judul = "KABUPATEN MALANG TAHUN : ".$tahun." PERIODE : BULAN ".$bulan; 
		        }
		        
		        //penduduk
		        $penduduk= $this->Diskehan_model->ajax_rekap_penduduk($tahun);
		        $komoditi = $this->Diskehan_model->get_kategori_peternakan();
    		    
    		    for($i = 0; $i < 3; $i++){
        		  array_push($pr_penduduk,$penduduk[0]->jumlah_penduduk);
        		}
        		
                // konsumsi
                if($bulan == "SEMUA"){
            		for ($i = 0; $i < count($komoditi); $i++) {
            		    $newdata = $this->Diskehan_model->ajax_rekap_konsumsi_peternakandanperikanan_pertahun($tahun, $komoditi[$i]->kmd_nama);
            		    array_push($konsumsi, $newdata);
            		}
            		
            		for($i = 0; $i < 3; $i++){
        		       if(count($konsumsi[$i]) > 0){
        		           array_push($pr_konsumsi, $konsumsi[$i][0]->total_konsumsi);
        		       }
        		       else{
    		               array_push($pr_konsumsi, "-");
    		            }
        		   }
                }
                else{
                    for ($i = 0; $i < count($komoditi); $i++) {
            		    $newdata = $this->Diskehan_model-> ajax_rekap_konsumsi_peternakandanperikanan($tahun, $komoditi[$i]->kmd_nama, $bulan);
            		    array_push($konsumsi, $newdata);
            		}
            		
            		for($i = 0; $i < 3; $i++){
        		       if($konsumsi[$i][0]->total_konsumsi == null){
        		           array_push($pr_konsumsi, "-");
        		       }
        		       else{
    		               array_push($pr_konsumsi, $konsumsi[$i][0]->total_konsumsi);
    		            }
        		   }
                }
        		
        // 		//kebutuhan
        		if($bulan == "SEMUA")
        		{
        		    for ($i = 0; $i < count($komoditi); $i++) {
        		         $newdata = $this->Diskehan_model->ajax_rekap_kebutuhan_peternakanperikanan_satutahun($tahun,$komoditi[$i]->kmd_nama);
        		         array_push($kebutuhan, $newdata);
        	    	}
        	    	
        	    	
        	    	for($i = 0; $i < 3; $i++){
        		       if($kebutuhan[$i][0]->jml_kebutuhan == null){
        		           array_push($pr_kebutuhan, "-");
        		       }
        		       else{
    		               array_push($pr_kebutuhan, number_format($kebutuhan[$i][0]->jml_kebutuhan,3));
    		            }
        		   }
        		}
        		else{
        		    for ($i = 0; $i < count($komoditi); $i++) {
        		        $newdata = $this->Diskehan_model->ajax_rekap_kebutuhan_peternakanperikanan($tahun,$bulan, $komoditi[$i]->kmd_nama);
        		         array_push($kebutuhan, $newdata);
        	    	}
        	    	
        	    	for($i = 0; $i < 3; $i++){
        		       if($kebutuhan[$i][0]->jml_kebutuhan == null){
        		           array_push($pr_kebutuhan, "-");
        		       }
        		       else{
    		               array_push($pr_kebutuhan, number_format($kebutuhan[$i][0]->jml_kebutuhan,3));
    		            }
        		   }
        		}
        		
        		//data komoditas
        		if($bulan == "SEMUA")
        		{
        		  for ($i = 0; $i < count($komoditi); $i++) {
        		         $newdata = $this->Diskehan_model->ajax_rekap_peternakanperikanan_satutahun($tahun,$komoditi[$i]->kmd_nama);
        		         array_push($komoditas, $newdata);
        	    	}
        	    	
        	            for($i = 0; $i < 3; $i++){
        	                
        	               array_push($pr_komoditas_tanam," ");
        		           array_push($pr_komoditas_panen," ");
        		           array_push($pr_komoditas_provitas," ");
        		           
        		           
        		       if(count($komoditas[$i]) > 0){
        		           if($komoditas[$i][0]->produksi != 0){
        		                array_push($pr_komoditas_produksi, number_format($komoditas[$i][0]->produksi,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_produksi,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->ketersediaan != 0){
        		                array_push($pr_komoditas_ketersediaan, number_format($komoditas[$i][0]->ketersediaan,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_ketersediaan,"-");
        		           }
        		           
        		          // if($komoditas[$i][0]->surplus != 0){
        		          //      array_push($pr_komoditas_surplus, number_format($komoditas[$i][0]->surplus,3));
        		          // }
        		          // else{
        		          //     array_push($pr_komoditas_surplus,"-");
        		          // }
        		           
        		           if($komoditas[$i][0]->psb != 0){
        		                array_push($pr_komoditas_psb, number_format($komoditas[$i][0]->psb,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_psb,"-");
        		           }
        		       }
        		       else{
        		           array_push($pr_komoditas_produksi,"-");
        		           array_push($pr_komoditas_ketersediaan,"-");
        		           array_push($pr_komoditas_surplus,"-");
        		           array_push($pr_komoditas_psb,"-");
        		       }
        		   }
        		}
        		else{
        		    for ($i = 0; $i < count($komoditi); $i++) {
        		         $newdata = $this->Diskehan_model->ajax_rekap_peternakanperikanan($tahun,$bulan,$komoditi[$i]->kmd_nama);
        		         array_push($komoditas, $newdata);
        	    	}
        	    	
        	    	for($i = 0; $i < 3; $i++){
        	    	      array_push($pr_komoditas_tanam," ");
        		           array_push($pr_komoditas_panen," ");
        		           array_push($pr_komoditas_provitas," ");
        		       if(count($komoditas[$i]) > 0){
        		           if($komoditas[$i][0]->produksi != 0){
        		                array_push($pr_komoditas_produksi, number_format($komoditas[$i][0]->produksi,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_produksi,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->ketersediaan != 0){
        		                array_push($pr_komoditas_ketersediaan, number_format($komoditas[$i][0]->ketersediaan,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_ketersediaan,"-");
        		           }
        		           
        		          // if($komoditas[$i][0]->surplus != 0){
        		          //      array_push($pr_komoditas_surplus, number_format($komoditas[$i][0]->surplus,3));
        		          // }
        		          // else{
        		          //     array_push($pr_komoditas_surplus,"-");
        		          // }
        		           
        		           if($komoditas[$i][0]->psb != 0){
        		                array_push($pr_komoditas_psb, number_format($komoditas[$i][0]->psb,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_psb,"-");
        		           }
        		       }
        		       else{
        		           array_push($pr_komoditas_produksi,"-");
        		           array_push($pr_komoditas_ketersediaan,"-");
        		           array_push($pr_komoditas_surplus,"-");
        		           array_push($pr_komoditas_psb,"-");
        		       }
        		   }
        		}
        		
        			for($i = 0; $i < 3; $i++){
        		 	    $komoditi[$i] = $komoditi[$i]->kmd_nama;
        		 	}
        		 	
        		//coba surplus peternakan
        		for($i = 0; $i < 3; $i++){
        		$newsurplus = 0;
        		$newketersediaan = 0;
        		$newkebutuhan = 0;
        		if($pr_komoditas_ketersediaan[$i] == "-"){
        		    $newkebutuhan = (float)(str_replace(",", "", $pr_kebutuhan[$i]));
        		    $newsurplus = 0 - $newkebutuhan;
        		    array_push($pr_komoditas_surplus, $newsurplus);
        		}
        		else if($pr_kebutuhan[$i] == "-"){
        		    $newketersediaan = (float)(str_replace(",", "", $pr_komoditas_ketersediaan[$i]));
        		    $newsurplus = $newketersediaan - 0;
        		    array_push($pr_komoditas_surplus, $newsurplus);
        		}
        		else if($pr_kebutuhan[$i] == "-" && $pr_komoditas_ketersediaan[$i] == "-"){
        		    $newsurplus = 0;
        		    array_push($pr_komoditas_surplus, $newsurplus);
        		}
        		else{
        		    $newkebutuhan = (float)(str_replace(",", "", $pr_kebutuhan[$i]));
        		    $newketersediaan = (float)(str_replace(",", "", $pr_komoditas_ketersediaan[$i]));
        		    $newsurplus = $newketersediaan - $newkebutuhan;
        		    array_push($pr_komoditas_surplus, $newsurplus);
        		}
        	}
        		  
		}
		
		else if($tipe == '3'){
		    
		    $namafile = "Perikanan - ".$tahun;
		    
		     if($bulan == "SEMUA"){
		             $judul = "KABUPATEN MALANG TAHUN : ".$tahun." PERIODE : SATU TAHUN"; 
		     }
		     else{
		             $judul = "KABUPATEN MALANG TAHUN : ".$tahun." PERIODE : BULAN ".$bulan; 
		     }

                                                        
		    $komoditi = $this->Diskehan_model->get_kategori_perikanan();
		    $penduduk= $this->Diskehan_model->ajax_rekap_penduduk($tahun);
		    
		        for($i = 0; $i <  1; $i++){
        		  array_push($pr_penduduk,$penduduk[0]->jumlah_penduduk);
        		}
        		
                // konsumsi
                if($bulan == "SEMUA"){
            		for ($i = 0; $i < count($komoditi); $i++) {
            		    $newdata = $this->Diskehan_model->ajax_rekap_konsumsi_peternakandanperikanan_pertahun($tahun, $komoditi[$i]->kmd_nama);
            		    array_push($konsumsi, $newdata);
            		}
            		
            		for($i = 0; $i < 1; $i++){
        		       if(count($konsumsi[$i]) > 0){
        		           array_push($pr_konsumsi, $konsumsi[$i][0]->total_konsumsi);
        		       }
        		       else{
    		               array_push($pr_konsumsi, "-");
    		            }
        		   }
                }
                else{
                    for ($i = 0; $i < count($komoditi); $i++) {
            		    $newdata = $this->Diskehan_model-> ajax_rekap_konsumsi_peternakandanperikanan($tahun, $komoditi[$i]->kmd_nama, $bulan);
            		    array_push($konsumsi, $newdata);
            		}
            		
            		for($i = 0; $i < 1; $i++){
        		       if($konsumsi[$i][0]->total_konsumsi == null){
        		           array_push($pr_konsumsi, "-");
        		       }
        		       else{
    		               array_push($pr_konsumsi, $konsumsi[$i][0]->total_konsumsi);
    		            }
        		   }
                }
        		
        // 		//kebutuhan
        		if($bulan == "SEMUA")
        		{
        		    for ($i = 0; $i < count($komoditi); $i++) {
        		         $newdata = $this->Diskehan_model->ajax_rekap_kebutuhan_peternakanperikanan_satutahun($tahun,$komoditi[$i]->kmd_nama);
        		         array_push($kebutuhan, $newdata);
        	    	}
        	    	
        	    	
        	    	for($i = 0; $i < 1; $i++){
        		       if($kebutuhan[$i][0]->jml_kebutuhan == null){
        		           array_push($pr_kebutuhan, "-");
        		       }
        		       else{
    		               array_push($pr_kebutuhan, number_format($kebutuhan[$i][0]->jml_kebutuhan,3));
    		            }
        		   }
        		}
        		else{
        		    for ($i = 0; $i < count($komoditi); $i++) {
        		        $newdata = $this->Diskehan_model->ajax_rekap_kebutuhan_peternakanperikanan($tahun,$bulan, $komoditi[$i]->kmd_nama);
        		         array_push($kebutuhan, $newdata);
        	    	}
        	    	
        	    	for($i = 0; $i < 1; $i++){
        		       if($kebutuhan[$i][0]->jml_kebutuhan == null){
        		           array_push($pr_kebutuhan, "-");
        		       }
        		       else{
    		               array_push($pr_kebutuhan, number_format($kebutuhan[$i][0]->jml_kebutuhan,3));
    		            }
        		   }
        		}
        		
        		//data komoditas
        		if($bulan == "SEMUA")
        		{
        		  for ($i = 0; $i < count($komoditi); $i++) {
        		         $newdata = $this->Diskehan_model->ajax_rekap_peternakanperikanan_satutahun($tahun,$komoditi[$i]->kmd_nama);
        		         array_push($komoditas, $newdata);
        	    	}
        	    	
        	        	for($i = 0; $i < 1; $i++){
        	        	  array_push($pr_komoditas_tanam," ");
        		           array_push($pr_komoditas_panen," ");
        		           array_push($pr_komoditas_provitas," ");
        		       if(count($komoditas[$i]) > 0){
        		           if($komoditas[$i][0]->produksi != 0){
        		                array_push($pr_komoditas_produksi, number_format($komoditas[$i][0]->produksi,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_produksi,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->ketersediaan != 0){
        		                array_push($pr_komoditas_ketersediaan, number_format($komoditas[$i][0]->ketersediaan,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_ketersediaan,"-");
        		           }
        		           
        		          // if($komoditas[$i][0]->surplus != 0){
        		          //      array_push($pr_komoditas_surplus, number_format($komoditas[$i][0]->surplus,3));
        		          // }
        		          // else{
        		          //     array_push($pr_komoditas_surplus,"-");
        		          // }
        		           
        		           if($komoditas[$i][0]->psb != 0){
        		                array_push($pr_komoditas_psb, number_format($komoditas[$i][0]->psb,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_psb,"-");
        		           }
        		       }
        		       else{
        		           array_push($pr_komoditas_produksi,"-");
        		           array_push($pr_komoditas_ketersediaan,"-");
        		          // array_push($pr_komoditas_surplus,"-");
        		           array_push($pr_komoditas_psb,"-");
        		       }
        		   }
        		}
        		else{
        		    for ($i = 0; $i < count($komoditi); $i++) {
        		         $newdata = $this->Diskehan_model->ajax_rekap_peternakanperikanan($tahun,$bulan,$komoditi[$i]->kmd_nama);
        		         array_push($komoditas, $newdata);
        	    	}
        	    	
        	    	for($i = 0; $i < 1; $i++){
        	    	      array_push($pr_komoditas_tanam," ");
        		           array_push($pr_komoditas_panen," ");
        		           array_push($pr_komoditas_provitas," ");
        		           
        		       if(count($komoditas[$i]) > 0){
        		           if($komoditas[$i][0]->produksi != 0){
        		                array_push($pr_komoditas_produksi, number_format($komoditas[$i][0]->produksi,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_produksi,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->ketersediaan != 0){
        		                array_push($pr_komoditas_ketersediaan, number_format($komoditas[$i][0]->ketersediaan,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_ketersediaan,"-");
        		           }
        		           
        		          // if($komoditas[$i][0]->surplus != 0){
        		          //      array_push($pr_komoditas_surplus, number_format($komoditas[$i][0]->surplus,3));
        		          // }
        		          // else{
        		          //     array_push($pr_komoditas_surplus,"-");
        		          // }
        		           
        		           if($komoditas[$i][0]->psb != 0){
        		                array_push($pr_komoditas_psb, number_format($komoditas[$i][0]->psb,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_psb,"-");
        		           }
        		       }
        		       else{
        		           array_push($pr_komoditas_produksi,"-");
        		           array_push($pr_komoditas_ketersediaan,"-");
        		          // array_push($pr_komoditas_surplus,"-");
        		           array_push($pr_komoditas_psb,"-");
        		       }
        		   }
        		}
        		
        		for($i = 0; $i < 1; $i++){
        		 	    $komoditi[$i] = $komoditi[$i]->kmd_nama;
        		 	}
        		 	
        		//coba surplus perikanan
        		$newsurplus = 0;
        		$newketersediaan = 0;
        		$newkebutuhan = 0;
        		if($pr_komoditas_ketersediaan[0] == "-"){
        		    $newkebutuhan = (float)(str_replace(",", "", $pr_kebutuhan[0]));
        		    $newsurplus = 0 - $newkebutuhan;
        		    array_push($pr_komoditas_surplus, $newsurplus);
        		}
        		else if($pr_kebutuhan[0] == "-"){
        		    $newketersediaan = (float)(str_replace(",", "", $pr_komoditas_ketersediaan[0]));
        		    $newsurplus = $newketersediaan - 0;
        		    array_push($pr_komoditas_surplus, $newsurplus);
        		}
        		else if($pr_kebutuhan[0] == "-" && $pr_komoditas_ketersediaan[0] == "-"){
        		    $newsurplus = 0;
        		    array_push($pr_komoditas_surplus, $newsurplus);
        		}
        		else{
        		    $newkebutuhan = (float)(str_replace(",", "", $pr_kebutuhan[0]));
        		    $newketersediaan = (float)(str_replace(",", "", $pr_komoditas_ketersediaan[0]));
        		    $newsurplus = $newketersediaan - $newkebutuhan;
        		    array_push($pr_komoditas_surplus, $newsurplus);
        		}
		}
        		  echo json_encode(array($komoditi,	$pr_penduduk, $pr_konsumsi, $pr_kebutuhan,$pr_komoditas_panen , $pr_komoditas_tanam, $pr_komoditas_provitas, $pr_komoditas_produksi, $pr_komoditas_ketersediaan, 	$pr_komoditas_surplus, 	$pr_komoditas_psb ));
	}
	
	
	function get_rekap_peternakandanperikanan(){
		$tahun=$this->input->post('tahun');
		$bulan = $this->input->post('bulan');
		$penduduk= $this->Diskehan_model->ajax_rekap_penduduk($tahun);
		$komoditi = $this->Diskehan_model->get_kategori_peternakan();
		
		$newdata = array();
		$konsumsi = array();
		$kebutuhan = array();
		$komoditas = array();
		
// 		konsumsi
        if($bulan == "SEMUA"){
		for ($i = 0; $i < count($komoditi); $i++) {
		    $newdata = $this->Diskehan_model->ajax_rekap_konsumsi_peternakandanperikanan_pertahun($tahun, $komoditi[$i]->kmd_nama);
		    array_push($konsumsi, $newdata);
		}
        }
        else{
        for ($i = 0; $i < count($komoditi); $i++) {
		    $newdata = $this->Diskehan_model-> ajax_rekap_konsumsi_peternakandanperikanan($tahun, $komoditi[$i]->kmd_nama, $bulan);
		    array_push($konsumsi, $newdata);
		}
        }
		
// 		//kebutuhan
		if($bulan == "SEMUA")
		{
		    for ($i = 0; $i < count($komoditi); $i++) {
		         $newdata = $this->Diskehan_model->ajax_rekap_kebutuhan_peternakanperikanan_satutahun($tahun,$komoditi[$i]->kmd_nama);
		         array_push($kebutuhan, $newdata);
	    	}
		}
		else{
		    for ($i = 0; $i < count($komoditi); $i++) {
		        $newdata = $this->Diskehan_model->ajax_rekap_kebutuhan_peternakanperikanan($tahun,$bulan, $komoditi[$i]->kmd_nama);
		         array_push($kebutuhan, $newdata);
	    	}
		}
		
		//data komoditas
		if($bulan == "SEMUA")
		{
		  for ($i = 0; $i < count($komoditi); $i++) {
		         $newdata = $this->Diskehan_model->ajax_rekap_peternakanperikanan_satutahun($tahun,$komoditi[$i]->kmd_nama);
		         array_push($komoditas, $newdata);
	    	}
		}
		else{
		    for ($i = 0; $i < count($komoditi); $i++) {
		         $newdata = $this->Diskehan_model->ajax_rekap_peternakanperikanan($tahun,$bulan,$komoditi[$i]->kmd_nama);
		         array_push($komoditas, $newdata);
	    	}
		}
		
		echo json_encode(array($penduduk, $komoditi, $konsumsi,$kebutuhan, $komoditas));
	}
	
		function get_rekap_peternakandanperikanan2(){
		$tahun=$this->input->post('tahun');
		$bulan = $this->input->post('bulan');
		$penduduk= $this->Diskehan_model->ajax_rekap_penduduk($tahun);
		$komoditi = $this->Diskehan_model->get_kategori_perikanan();
		
		$newdata = array();
		$konsumsi = array();
		$kebutuhan = array();
		$komoditas = array();
		
// 		konsumsi
        if($bulan == "SEMUA"){
		for ($i = 0; $i < count($komoditi); $i++) {
		    $newdata = $this->Diskehan_model->ajax_rekap_konsumsi_peternakandanperikanan_pertahun($tahun, $komoditi[$i]->kmd_nama);
		    array_push($konsumsi, $newdata);
		}
        }
        else{
        for ($i = 0; $i < count($komoditi); $i++) {
		    $newdata = $this->Diskehan_model-> ajax_rekap_konsumsi_peternakandanperikanan($tahun, $komoditi[$i]->kmd_nama, $bulan);
		    array_push($konsumsi, $newdata);
		}
        }
		
// 		//kebutuhan
		if($bulan == "SEMUA")
		{
		    for ($i = 0; $i < count($komoditi); $i++) {
		         $newdata = $this->Diskehan_model->ajax_rekap_kebutuhan_peternakanperikanan_satutahun($tahun,$komoditi[$i]->kmd_nama);
		         array_push($kebutuhan, $newdata);
	    	}
		}
		else{
		    for ($i = 0; $i < count($komoditi); $i++) {
		        $newdata = $this->Diskehan_model->ajax_rekap_kebutuhan_peternakanperikanan($tahun,$bulan, $komoditi[$i]->kmd_nama);
		         array_push($kebutuhan, $newdata);
	    	}
		}
		
		//data komoditas
		if($bulan == "SEMUA")
		{
		  for ($i = 0; $i < count($komoditi); $i++) {
		         $newdata = $this->Diskehan_model->ajax_rekap_peternakanperikanan_satutahun($tahun,$komoditi[$i]->kmd_nama);
		         array_push($komoditas, $newdata);
	    	}
		}
		else{
		    for ($i = 0; $i < count($komoditi); $i++) {
		         $newdata = $this->Diskehan_model->ajax_rekap_peternakanperikanan($tahun,$bulan,$komoditi[$i]->kmd_nama);
		         array_push($komoditas, $newdata);
	    	}
		}
		
		echo json_encode(array($penduduk, $komoditi, $konsumsi,$kebutuhan, $komoditas));
	}

	// mulai grafik pertanian
	function grafik_pertanian(){
	    $komoditi = $this->Diskehan_model->getkomoditibyid(1);
	    $kecamatan = $this->Diskehan_model->getkecamatan();
	    $tahun = $this->Diskehan_model->listyear();
	    $data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/Grafik_pertanian',
			'menu'	=> 'Data Pertanian',
			'title' => 'Grafik Pertanian',
			'komoditi' => $komoditi,
			'kecamatan' => $kecamatan,
			'tahun' => $tahun,
			'footer' => 'Diskehan/footer',
		];
		$this->load->view('Diskehan/template',$data);
        // $this->load->view('Diskehan/Grafik_pertanian');
	}
	
	function grafik_peternakan(){
	    $tahun = $this->Diskehan_model->listyear();
	    $data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/Grafik_peternakan',
			'menu'	=> 'Data Peternakan',
			'title' => 'Grafik Peternakan',
			'footer' => 'Diskehan/footer',
			'tahun' => $tahun
		];
		$this->load->view('Diskehan/template',$data);
        // $this->load->view('Diskehan/Grafik_pertanian');
	}
	
	function grafik_perikanan(){
	    $tahun = $this->Diskehan_model->listyear();
	    $data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/Grafik_perikanan',
			'menu'	=> 'Data Perikanan',
			'title' => 'Grafik Perikanan',
			'footer' => 'Diskehan/footer',
			 'tahun' => $tahun
		];
		$this->load->view('Diskehan/template',$data);
        // $this->load->view('Diskehan/Grafik_pertanian');
	}
	
	function get_grafik_pertanian(){
		$tahun=$this->input->post('tahun');
		$komoditi=$this->input->post('komoditi');
		$kecamatan = $this->input->post('kecamatan');
		$datakebutuhan=$this->Diskehan_model->ajax_grafik_pertanian($tahun,$komoditi,$kecamatan);
		$dataketersediaan=$this->Diskehan_model->ajax_grafik_ketersediaan_pertanian($tahun,$komoditi,$kecamatan);
		echo json_encode(array($datakebutuhan, $dataketersediaan));
	}
	
	//prototype
	function get_grafik_pertanian_satukabupaten(){
		$tahun=$this->input->post('tahun');
		$komoditi=$this->input->post('komoditi');
		$datakebutuhan=$this->Diskehan_model->ajax_grafik_pertanian_satukabupaten($tahun,$komoditi);
		$dataketersediaan=$this->Diskehan_model->ajax_grafik_ketersediaan_pertanian_satukabupaten($tahun,$komoditi);
		echo json_encode(array($datakebutuhan, $dataketersediaan));
	}
	
	function get_grafik_peternakan_satukabupaten(){
		$tahun=$this->input->post('tahun');
		$komoditi=$this->input->post('komoditi');
// 		$newdata=$this->Diskehan_model->ajax_rekap_kebutuhan_peternakanperikanan($tahun,"JANUARI",$komoditi);
// 		$datakebutuhan = array("bulan"=>"JANUARI", "jml_kebutuhan" => $newdata);
        $newdata = $this->Diskehan_model->ajax_rekap_kebutuhan_peternakanperikananforgrafik($tahun,'JANUARI',$komoditi);
        $datakebutuhan = array(array("bulan"=>"JANUARI", "jml_kebutuhan" => $newdata[0]->jml_kebutuhan),array("bulan"=>"FEBRUARI", "jml_kebutuhan" => $newdata[0]->jml_kebutuhan),array("bulan"=>"MARET", "jml_kebutuhan" => $newdata[0]->jml_kebutuhan),array("bulan"=>"APRIL", "jml_kebutuhan" => $newdata[0]->jml_kebutuhan),array("bulan"=>"MEI", "jml_kebutuhan" => $newdata[0]->jml_kebutuhan),array("bulan"=>"JUNI", "jml_kebutuhan" => $newdata[0]->jml_kebutuhan),array("bulan"=>"JULI", "jml_kebutuhan" => $newdata[0]->jml_kebutuhan),array("bulan"=>"AGUSTUS", "jml_kebutuhan" => $newdata[0]->jml_kebutuhan),array("bulan"=>"SEPTEMBER", "jml_kebutuhan" => $newdata[0]->jml_kebutuhan),array("bulan"=>"OKTOBER", "jml_kebutuhan" => $newdata[0]->jml_kebutuhan),array("bulan"=>"NOPEMBER", "jml_kebutuhan" => $newdata[0]->jml_kebutuhan),array("bulan"=>"DESEMBER", "jml_kebutuhan" => $newdata[0]->jml_kebutuhan));
		$dataketersediaan = $this->Diskehan_model-> ajax_peternakan_ketersediaan($tahun,$komoditi);
		echo json_encode(array($datakebutuhan, $dataketersediaan));
	}

	//mulai peternakan
	public function komoditas_peternakan()
	{
		$komoditi = $this->Diskehan_model->getkomoditibyid(2);
			$data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/list_komoditi_peternakan',
			'menu'	=> 'Data Peternakan',
			'title' => 'Komoditas Peternakan',
			'komoditi' => $komoditi,
			'footer' => 'Diskehan/footer',
			
		];
			$this->load->view('Diskehan/template',$data);
	}

	public function konsumsi_peternakan()
	{
		$konsumsi = $this->Diskehan_model->getkonsumsipeternakan();
		$data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/konsumsi_peternakan',
			'menu'	=> 'Data Peternakan',
			'title' => 'Data konsumsi Peternakan',
			'konsumsi' => $konsumsi,
			'footer' => 'Diskehan/footer',

		];
		$this->load->view('Diskehan/template',$data);
	}

	public function tambah_konsumsi_peternakan()
	{
		$kategori = $this->Diskehan_model->get_kategori_peternakan();
        
		$this->form_validation->set_rules('kons_thn','Tahun','required',array('required' => '%s tidak boleh kosong.'));
		$this->form_validation->set_rules('kons_jml','Jumlah Konsumsi','required',array('required' => '%s tidak boleh kosong.'));
		
		if($this->form_validation->run() == False)
		{
			$data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/form_konsumsi_peternakan',
			'menu'	=> 'Data Peternakan',
			'title' => 'Tambah Data konsumsi Peternakan',
			'kategori' => $kategori,
			'footer' => 'Diskehan/footer',

		];
		$this->load->view('Diskehan/template',$data);
		}
		else
		{
			$barisbaru = $this->carirowkosongkonsumsi();
			$this->Diskehan_model->savekonsumsipeternakanperikanan($barisbaru);
			$this->session->set_flashdata('flash','disimpan');
			$this->konsumsi_peternakan();
			$this->session->set_flashdata('flash','');
		}	      
	}

	public function get_subkategori_peternakan(){
		$id=$this->input->post('id');
		$data=$this->Diskehan_model->ajax_komoditi_peternakan($id);
		echo json_encode($data);
	}

	public function edit_konsumsi_peternakan($id)
	{
		$this->form_validation->set_rules('kons_jml','Jumlah Konsumsi','required',array('required' => '%s tidak boleh kosong.'));

		if($this->form_validation->run() == False)
		{
			$kategori = $this->Diskehan_model->get_kategori_peternakan();
			$konsumsi = $this->Diskehan_model->getdatakonsumsibyidpeternakan($id);
			$data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/edit_konsumsi_peternakan',
			'menu'	=> 'Data Peternakan',
			'title' => 'Data konsumsi Peternakan',
			'kategori' => $kategori,
			'konsumsi' => $konsumsi,
			'footer' => 'Diskehan/footer',

		];
			$this->load->view('Diskehan/template',$data);
		}
		else
		{
			$this->Diskehan_model->editkonsumsipeternakanperikanan($id);
			$this->session->set_flashdata('flash','diupdate');
			$this->konsumsi_peternakan();
			$this->session->set_flashdata('flash','');
		}	
	}

	public function hapus_konsumsi_peternakan($id)
	{
	    $this->Diskehan_model->hapusdatakonsumsi($id);       
	    $this->session->set_flashdata('flash','dihapus');
	    $this->konsumsi_peternakan();
	    $this->session->set_flashdata('flash','');
	}
	
	public function konsumsi_peternakan_search(){
	    $tahun = $this->Diskehan_model->listyear();
		$kategori = $this->Diskehan_model->get_kategori_peternakan();
		$data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/search_konsumsi_peternakan',
			'menu'	=> 'Data Peternakan',
			'title' => 'Search Data Peternakan',
			'kategori' => $kategori,
			'tahun' => $tahun,
			'footer' => 'Diskehan/footer',
		];
		$this->load->view('Diskehan/template',$data);
	}
	
	public function get_search_konsumsi_peternakan(){
		$kat=$this->input->post('kat');
		$tahun=$this->input->post('tahun');
		$data=$this->Diskehan_model->ajax_search_komoditi_peternakan($kat,$tahun);
		echo json_encode($data);
	}

	public function data_komoditas_peternakan()
	{
		$data_komoditas = $this->Diskehan_model->getdatakomoditasbyid(2);
		$data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/data_komoditas_peternakan',
			'menu'	=> 'Data Peternakan',
			'title' => 'Data komoditas Peternakan',
			'data_komoditas' => $data_komoditas,
			'footer' => 'Diskehan/footer',

		];
		$this->load->view('Diskehan/template',$data);
	}

	public function tambah_komoditas_peternakan()
	{
		$kategori = $this->Diskehan_model->get_kategori_peternakan();

		$this->form_validation->set_rules('bulan','Nama Bulan','required',array('required' => '%s tidak boleh kosong.'));
		$this->form_validation->set_rules('tahun','Tahun','required',array('required' => '%s tidak boleh kosong.'));
		
		if($this->form_validation->run() == False)
		{
			$data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/form_komoditas_peternakan',
			'menu'	=> 'Data Peternakan',
			'title' => 'Tambah Data Komoditas Peternakan',
			'kategori' => $kategori,
			'footer' => 'Diskehan/footer',

		];
			$this->load->view('Diskehan/template',$data);
		}
		else
		{
			$barisbaru = $this->carirowkosongkomoditas();
			$this->Diskehan_model->savekomoditaspeternakan($barisbaru);
			$this->session->set_flashdata('flash','disimpan');
			$this->data_komoditas_peternakan();
			$this->session->set_flashdata('flash','');
		}	      
	}

	public function edit_komoditas_peternakan($id)
	{
	    $kategori = $this->Diskehan_model->get_kategori_peternakan();
	    $komoditas = $this->Diskehan_model->getdatakomoditasforupdate($id);
	    $listkomoditas = $this->Diskehan_model->ajax_komoditi_peternakan($komoditas[0]->kmd_id);
	    
// 		$this->form_validation->set_rules('kons_det_kmd_id','Nama Komoditi','required',array('required' => '%s tidak boleh kosong.'));
// 		$this->form_validation->set_rules('produksi','Jumlah Produksi','required',array('required' => '%s tidak boleh kosong.'));
		$this->form_validation->set_rules('bulan','Nama Bulan','required',array('required' => '%s tidak boleh kosong.'));
		$this->form_validation->set_rules('tahun','Tahun','required',array('required' => '%s tidak boleh kosong.'));

		if($this->form_validation->run() == False)
		{
		    $data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/edit_komoditas_peternakan',
			'menu'	=> 'Data Peternakan',
			'title' => 'Edit Data Komoditas Peternakan',
			'kategori' => $kategori,
			'komoditas' => $komoditas,
			'listkomoditas' => $listkomoditas,
			'footer' => 'Diskehan/footer',

		];
			$this->load->view('Diskehan/template',$data);
		}
		else
		{
			$this->Diskehan_model->updatekomoditaspeternakanperikanan($id);
			$this->session->set_flashdata('flash','diupdate');
			$this->data_komoditas_peternakan();
			$this->session->set_flashdata('flash','');
		}	
	}
	
	public function hapus_komoditas_peternakan($id)
	{
	    $this->Diskehan_model->hapusdatakomoditas($id);       
	    $this->session->set_flashdata('flash','dihapus');
	    $this->data_komoditas_peternakan();
	    $this->session->set_flashdata('flash','');
	}

	public function komoditas_peternakan_search(){
	    $tahun = $this->Diskehan_model->listyear();
		$kategori = $this->Diskehan_model->get_kategori_peternakan();
		$data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/search_komoditas_peternakan',
			'menu'	=> 'Data Peternakan',
			'title' => 'Search Data Komoditas Peternakan',
			'kategori' => $kategori,
			'tahun' => $tahun,
			'footer' => 'Diskehan/footer',
		];
		$this->load->view('Diskehan/template',$data);
	}

	//mulai perikanan
	public function komoditas_perikanan()
	{
		$komoditi = $this->Diskehan_model->getkomoditibyid(3);
			$data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/list_komoditi_perikanan',
			'menu'	=> 'Data Perikanan',
			'title' => 'Komoditas Perikanan',
			'komoditi' => $komoditi,
			'footer' => 'Diskehan/footer',
			
		];
		$this->load->view('Diskehan/template',$data);
	}

  public function konsumsi_perikanan()
	{
		$konsumsi = $this->Diskehan_model->getkonsumsiperikanan();
		$data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/konsumsi_perikanan',
			'menu'	=> 'Data Perikanan',
			'title' => 'Data konsumsi Perikanan',
			'konsumsi' => $konsumsi,
			'footer' => 'Diskehan/footer',

		];
		$this->load->view('Diskehan/template',$data);
	}

	public function tambah_konsumsi_perikanan()
	{
		$komoditas = $this->Diskehan_model->getkomoditibyid(3);

// 		$this->form_validation->set_rules('kons_det_kmd_id','Nama Komoditi','required',array('required' => '%s tidak boleh kosong.'));
		$this->form_validation->set_rules('kons_thn','Tahun','required',array('required' => '%s tidak boleh kosong.'));
		$this->form_validation->set_rules('kons_jml','Jumlah Konsumsi','required',array('required' => '%s tidak boleh kosong.'));
		
		if($this->form_validation->run() == False)
		{
			$data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/form_konsumsi_perikanan',
			'menu'	=> 'Data Perikanan',
			'title' => 'Tambah Data konsumsi Perikanan',
			'komoditas' => $komoditas,
			'footer' => 'Diskehan/footer',

		];
		$this->load->view('Diskehan/template',$data);
		}
		else
		{
			$barisbaru = $this->carirowkosongkonsumsi();
			$this->Diskehan_model->savekonsumsipeternakanperikanan($barisbaru);
			$this->session->set_flashdata('flash','disimpan');
			$this->konsumsi_perikanan();
			$this->session->set_flashdata('flash','');
		}	      
	}

	public function edit_konsumsi_perikanan($id)
	{
// 		$this->form_validation->set_rules('kons_det_kmd_id','Jenis Komoditi','required',array('required' => '%s tidak boleh kosong.'));
// 		$this->form_validation->set_rules('kons_thn','Tahun','required',array('required' => '%s tidak boleh kosong.'));
// 		$this->form_validation->set_rules('kons_jml','Jumlah Konsumsi','required',array('required' => '%s tidak boleh kosong.'));

		if($this->form_validation->run() == False)
		{
			$komoditas = $this->Diskehan_model->getkomoditibyid(3);
			$konsumsi = $this->Diskehan_model->getdatakonsumsibyidpeternakan($id);
			$data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/edit_konsumsi_perikanan',
			'menu'	=> 'Data Perikanan',
			'title' => 'Data Konsumsi Perikanan',
			'komoditas' => $komoditas,
			'konsumsi' => $konsumsi,
			'footer' => 'Diskehan/footer',

		];
			$this->load->view('Diskehan/template',$data);
		}
		else
		{
		    $this->Diskehan_model->editkonsumsipeternakanperikanan($id);
			$this->session->set_flashdata('flash','diupdate');
			$this->konsumsi_perikanan();
			$this->session->set_flashdata('flash','');
		}	
	}

	public function hapus_konsumsi_perikanan($id)
	{
	    $this->Diskehan_model->hapusdatakonsumsi($id);       
	    $this->session->set_flashdata('flash','dihapus');
	    $this->konsumsi_perikanan();
	    $this->session->set_flashdata('flash','');
	}

	public function data_komoditas_perikanan()
	{
		$data_komoditas = $this->Diskehan_model->getdatakomoditasbyid(3);
		$data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/data_komoditas_perikanan',
			'menu'	=> 'Data Perikanan',
			'title' => 'Data komoditas Perikanan',
			'data_komoditas' => $data_komoditas,
			'footer' => 'Diskehan/footer',
		];
		$this->load->view('Diskehan/template',$data);
	}

	public function tambah_komoditas_perikanan()
	{
        $komoditi = $this->Diskehan_model->getkomoditibyid(3);
        
// 		$this->form_validation->set_rules('produksi','Jumlah Produksi','required',array('required' => '%s tidak boleh kosong.'));
// 		$this->form_validation->set_rules('ketersediaan','Ketersediaan','required',array('required' => '%s tidak boleh kosong.'));
// 		$this->form_validation->set_rules('psb','PSB','required',array('required' => '%s tidak boleh kosong.'));
// 		$this->form_validation->set_rules('surplus','Surplus','required',array('required' => '%s tidak boleh kosong.'));
		$this->form_validation->set_rules('bulan','Nama Bulan','required',array('required' => '%s tidak boleh kosong.'));
		$this->form_validation->set_rules('tahun','Tahun','required',array('required' => '%s tidak boleh kosong.'));
		
		if($this->form_validation->run() == False)
		{
			$data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/form_komoditas_perikanan',
			'menu'	=> 'Data Perikanan',
			'title' => 'Tambah Data Komoditas Perikanan',
			'komoditi' => $komoditi,
			'footer' => 'Diskehan/footer',

		];
			$this->load->view('Diskehan/template',$data);
		}
		else
		{
			$barisbaru = $this->carirowkosongkomoditas();
			$this->Diskehan_model->savekomoditaspeternakan($barisbaru);
			$this->session->set_flashdata('flash','disimpan');
			$this->data_komoditas_perikanan();
			$this->session->set_flashdata('flash','');
		}	      
	}
	
	public function edit_komoditas_perikanan($id)
	{
	    $komoditas = $this->Diskehan_model->getdatakomoditasforupdate($id);
        $komoditi = $this->Diskehan_model->getkomoditibyid(3);
        
// 		$this->form_validation->set_rules('kons_det_kmd_id','Nama Komoditi','required',array('required' => '%s tidak boleh kosong.'));
// 		$this->form_validation->set_rules('produksi','Jumlah Produksi','required',array('required' => '%s tidak boleh kosong.'));
		$this->form_validation->set_rules('bulan','Nama Bulan','required',array('required' => '%s tidak boleh kosong.'));
		$this->form_validation->set_rules('tahun','Tahun','required',array('required' => '%s tidak boleh kosong.'));
		
		if($this->form_validation->run() == False)
		{
			$data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/edit_komoditas_perikanan',
			'menu'	=> 'Data Perikanan',
			'title' => 'Update Data Komoditas Perikanan',
			'komoditi' => $komoditi,
			'komoditas' => $komoditas,
			'footer' => 'Diskehan/footer',

		];
			$this->load->view('Diskehan/template',$data);
		}
		else
		{
			$this->Diskehan_model->updatekomoditaspeternakanperikanan($id);
			$this->session->set_flashdata('flash','diupdate');
			$this->data_komoditas_perikanan();
			$this->session->set_flashdata('flash','');
		}	      
	}
	
	
	public function hapus_komoditas_perikanan($id)
	{
	    $this->Diskehan_model->hapusdatakomoditas($id);       
	    $this->session->set_flashdata('flash','dihapus');
	    $this->data_komoditas_perikanan();
	    $this->session->set_flashdata('flash','');
	}
	
	public function komoditas_perikanan_search(){
	    $tahun = $this->Diskehan_model->listyear();
		$komoditi = $this->Diskehan_model->getkomoditibyid(3);
		$data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/search_komoditas_perikanan',
			'menu'	=> 'Data Perikanan',
			'title' => 'Search Data Komoditas Perikanan',
			'komoditi' => $komoditi,
			'tahun' => $tahun,
			'footer' => 'Diskehan/footer',
		];
		$this->load->view('Diskehan/template',$data);
	}
	
	function proyeksi(){
	    $proyeksi = $this->Diskehan_model->getkomoditiproyeksi();
	    $data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/Proyeksi1',
			'menu'	=> 'Proyeksi',
			'title' => 'Proyeksi',
			'proyeksi' => $proyeksi,
			'footer' => 'Diskehan/footer',
		];
		$this->load->view('Diskehan/template',$data);
	   // $this->load->view("Diskehan/proyeksi.php",$data);
	}
	
	function get_proyeksi(){
		$komoditi=$this->input->post('komoditi');
		$data=$this->Diskehan_model->getproyeksi($komoditi);
		echo json_encode($data);
	}
	
	function kelola_akun()
	{
		    $id = $this->Diskehan_model->getakun();
			$data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/kelola_akun',
			'menu'	=> 'Kelola Akun',
			'title' => 'Data Akun',
			'id' => $id,
			'footer' => 'Diskehan/footer',

		];
		$this->load->view('Diskehan/template',$data);
	}
	
	public function tambah_akun()
	{
		$this->form_validation->set_rules('username','Username','required',array('required' => '%s tidak boleh kosong.'));
		$this->form_validation->set_rules('password','Password','required',array('required' => '%s tidak boleh kosong.'));
		$this->form_validation->set_rules('level','Bagian','required',array('required' => '%s tidak boleh kosong.'));

		if($this->form_validation->run() == False)
		{
			$data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/form_akun',
			'menu'	=> 'Data Akun',
			'title' => 'Tambah Akun',
			'footer' => 'Diskehan/footer'
			
		];
			$this->load->view('Diskehan/template',$data);
		}
		else
		{
			$this->Diskehan_model->tambahakun();
			$this->session->set_flashdata('flash','disimpan');
			$this->kelola_akun();
    		$this->session->set_flashdata('flash','');
		}	
	}
	
	function cekakun(){
		$username = $this->input->post('username');
		$data=$this->Diskehan_model->cekakun($username);
		echo json_encode($data);
	}
	
	public function hapus_akun($id)
	{
	    $this->Diskehan_model->hapusakun($id);       
	    $this->session->set_flashdata('flash','dihapus');
	    $this->kelola_akun();
	    $this->session->set_flashdata('flash','');
	}
	
	public function update_akun($id)
	{
	    $akun = $this->Diskehan_model->getakundata($id);
		$this->form_validation->set_rules('password','Password','required',array('required' => '%s tidak boleh kosong.'));

		if($this->form_validation->run() == False)
		{
			$data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/edit_akun',
			'menu'	=> 'Kelola Akun',
			'title' => 'Update Akun',
			'akun' => $akun,
			'footer' => 'Diskehan/footer'
			
		];
			$this->load->view('Diskehan/template',$data);
		}
		else
		{
			$this->Diskehan_model->updateakun($id);
			$this->session->set_flashdata('flash','diupdate');
			$this->kelola_akun();
    		$this->session->set_flashdata('flash','');
		}	
	}
	
	// mulai neraca
	function neraca_pertanian(){
	    $komoditi = $this->Diskehan_model->getkomoditibyid(1);
	    $kecamatan = $this->Diskehan_model->getkecamatan();
	    $tahun = $this->Diskehan_model->listyear();
	    $data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/neraca_pertanian',
			'menu'	=> 'Data Pertanian',
			'title' => 'Neraca Pertanian',
			'komoditi' => $komoditi,
			'kecamatan' => $kecamatan,
			'tahun' => $tahun,
			'footer' => 'Diskehan/footer',
		];
		$this->load->view('Diskehan/template',$data);
        // $this->load->view('Diskehan/Grafik_pertanian');
	}
	
	function get_neraca_pertanian(){ 
	    $tahun=$this->input->post('tahun');
		$komoditi = $this->input->post('komoditi');
		$kecamatan = $this->input->post('kecamatan');
        // $tahun="2018";
        // $kecamatan = "SEMUA";
        // $komoditi = "JAGUNG";
		$bulan = array("JANUARI","FEBRUARI","MARET","APRIL","MEI","JUNI","JULI","AGUSTUS","SEPTEMBER","OKTOBER","NOPEMBER","DESEMBER");
		
		$newdata = array();
		$datakebutuhan = array();
		$kebutuhan = array();
		$komoditas = array();
		$total = array();
		$akumulatif = array();
		$newsurplus = 0;
		$surplus = array();
		
		//kebutuhan
		if($kecamatan == "SEMUA"){
		         $newdata = $this->Diskehan_model->ajax_rekap_kebutuhan_pertanian($tahun,'JANUARI',$komoditi);
		         array_push($datakebutuhan, $newdata);
		}
		else{
		         $newdata = $this->Diskehan_model->ajax_rekap_kebutuhan_pertanian_persatuan($tahun,$kecamatan,$komoditi, 'JANUARI');
		         array_push($datakebutuhan, $newdata);
		}
		
		array_push($kebutuhan,number_format($datakebutuhan[0][0]->jml_kebutuhan, 3, '.', ''));
		
// 		//data komoditas
		if($kecamatan == "SEMUA")
		{
		    for ($i = 0; $i < count($bulan); $i++) {
		         $newdata = $this->Diskehan_model->ajax_rekap_pertanian($tahun,$bulan[$i],$komoditi);
		         array_push($komoditas, $newdata);
		         
	    	}
		}
		else{
		    for ($i = 0; $i < count($bulan); $i++) {
		         $newdata = $this->Diskehan_model->ajax_rekap_pertanian_persatuan($tahun,$kecamatan,$komoditi,$bulan[$i]);
		         array_push($komoditas, $newdata);
	    	}
		    
		}
		
			//surplus
	    	for ($i = 0; $i < count($bulan); $i++) {
	    	    $newsurplus = 0;
        		$newketersediaan = 0;
        		$newkebutuhan = 0;
        		if($komoditas[$i][0]->ketersediaan != null){
        		    $newketersediaan = (float)(str_replace(",", "", $komoditas[$i][0]->ketersediaan));
        		    $newkebutuhan = (float)(str_replace(",", "", $kebutuhan[0]));
        		    $newsurplus = $newketersediaan - $newkebutuhan;
        		    array_push($surplus, $newsurplus);
        		}
        		else{
        		    $newkebutuhan = (float)(str_replace(",", "", $kebutuhan[0]));
        		    $newsurplus = 0 - $newkebutuhan;
        		     array_push($surplus, $newsurplus);
        		}
	    	}
	    	
	    	//akumulatif surplus
	    	$newsurplus = 0;
	    	for ($i = 0; $i < count($bulan); $i++) {
	    	         $newsurplus = $newsurplus + $surplus[$i];
	    	         array_push($akumulatif, $newsurplus);
	    	};
	    	
	    	
	    	//total produksi
	    	$totalproduksi = 0;
	    	for ($i = 0; $i < count($bulan); $i++) {
	    	    if($komoditas[$i][0]->produksi != null){
	    	         $newtotalproduksi = (float)(str_replace(",", "", $komoditas[$i][0]->produksi));
	    	         $totalproduksi = $totalproduksi +  $newtotalproduksi;
	    	    }
	    	};
	    	
	    	//total ketersediaan
	    	$totalketersediaan = 0;
	    	for ($i = 0; $i < count($bulan); $i++) {
	    	    if($komoditas[$i][0]->ketersediaan != null){
	    	         $totalketersediaan = $totalketersediaan + (float)$komoditas[$i][0]->ketersediaan;
	    	    }
	    	};
	    	
	    	//total surplus
	    	$totalsurplus = 0;
	    	for ($i = 0; $i < count($bulan); $i++) {
	    	   $totalsurplus = $totalsurplus + $surplus[$i];
	    	};
	    	
	    	//sepertinya totalkumultaif tidak usah eheh
	   // 	$totalakumulatif = 0;
	   // 	for ($i = 0; $i < count($bulan); $i++) {
	   // 	    if($akumulatif[$i] != null){
	   // 	         $totalakumulatif = $totalakumulatif + $akumulatif[$i];
	   // 	    }
	   // 	};
	       
	        $totalkebutuhan = array();
	        for ($i = 0; $i < count($komoditi); $i++) {
        		 $newdata = $this->Diskehan_model->ajax_rekap_kebutuhan_peternakanperikanan_satutahun($tahun,$komoditi);
        		 array_push($totalkebutuhan, $newdata);
        	}
        	 
        	$nb_totalkebutuhan = (float)(str_replace(",", "", $totalkebutuhan[0][0]->jml_kebutuhan)); 	
        	    	
        	   // 	for($i = 0; $i < 1; $i++){
        		  //     if($kebutuhan[$i][0]->jml_kebutuhan == null){
        		  //         array_push($pr_kebutuhan, "-");
        		  //     }
        		  //     else{
    		      //         array_push($pr_kebutuhan, number_format($kebutuhan[$i][0]->jml_kebutuhan,3));
    		      //      }
        		  // }
	    	
	    $total[0] = $totalproduksi;
	    $total[1] = $totalketersediaan;
	    $total[2] = number_format($nb_totalkebutuhan, 3, '.', '');
	    $total[3] = $totalsurplus;
	    $total[4] = $akumulatif;
		
    //   echo '<pre>',var_dump($kebutuhan, $komoditas, $akumulatif, $total,$tahun, $komoditi, $totalkebutuhan),'</pre>';
    	echo json_encode(array($kebutuhan, $komoditas, $surplus, $akumulatif, $total,$tahun, $komoditi));
	}
	
	function neraca_peternakan(){
	    $tahun = $this->Diskehan_model->listyear();
	    $data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/neraca_peternakan',
			'menu'	=> 'Data Perternakan',
			'title' => 'Neraca Peternakan',
			'tahun' => $tahun,
			'footer' => 'Diskehan/footer',
		];
		$this->load->view('Diskehan/template',$data);
        // $this->load->view('Diskehan/Grafik_pertanian');
	}
	
	function neraca_perikanan(){
	    $tahun = $this->Diskehan_model->listyear();
	    $data = [
			// 'username'= $session_data'username',
			// 'level'= $session_data'level',
			'sidebar' => 'Diskehan/sidebar',
			'content' => 'Diskehan/neraca_perikanan',
			'menu'	=> 'Data Perikanan',
			'title' => 'Neraca Perikanan',
			'tahun' => $tahun,
			'footer' => 'Diskehan/footer',
		];
		$this->load->view('Diskehan/template',$data);
        // $this->load->view('Diskehan/Grafik_pertanian');
	}
	
	function get_neraca_peternakanperikanan(){ 
	    $tahun=$this->input->post('tahun');
		$komoditi = $this->input->post('komoditi');
        // $tahun = 2018;
        // $komoditi = 'Ikan';
		$bulan = array("JANUARI","FEBRUARI","MARET","APRIL","MEI","JUNI","JULI","AGUSTUS","SEPTEMBER","OKTOBER","NOPEMBER","DESEMBER");
		
		$newdata = array();
		$datakebutuhan = array();
		$kebutuhan = array();
		$komoditas = array();
		$total = array();
		$akumulatif = array();
		$newsurplus = 0;
		$surplus = array();
		
		//kebutuhan
	        for ($i = 0; $i < count($komoditi); $i++) {
		        $newdata = $this->Diskehan_model->ajax_rekap_kebutuhan_peternakanperikanan($tahun,'JANUARI', $komoditi);
		        array_push($datakebutuhan, $newdata);
		        array_push($kebutuhan,number_format($datakebutuhan[0][0]->jml_kebutuhan, 3, '.', ''));
	    	}
		
// 		//data komoditas
		    for ($i = 0; $i < count($bulan); $i++) {
		         $newdata = $this->Diskehan_model->ajax_rekap_peternakanperikanan($tahun,$bulan[$i],$komoditi);
		         array_push($komoditas, $newdata);
	    	}
	    	
	    	//surplus
	    	for ($i = 0; $i < count($bulan); $i++) {
	    	    $newsurplus = 0;
        		$newketersediaan = 0;
        		$newkebutuhan = 0;
        		if($komoditas[$i][0]->ketersediaan != null){
        		    $newketersediaan = (float)(str_replace(",", "", $komoditas[$i][0]->ketersediaan));
        		    $newkebutuhan = (float)(str_replace(",", "", $kebutuhan[0]));
        		    $newsurplus = $newketersediaan - $newkebutuhan;
        		    array_push($surplus, $newsurplus);
        		}
        		else{
        		    $newkebutuhan = (float)(str_replace(",", "", $kebutuhan[0]));
        		    $newsurplus = 0 - $newkebutuhan;
        		     array_push($surplus, $newsurplus);
        		}
	    	}
	    	
	    	//akumulatif surplus
	    	$newsurplus = 0;
	    	for ($i = 0; $i < count($bulan); $i++) {
	    	         $newsurplus = $newsurplus + $surplus[$i];
	    	         array_push($akumulatif, $newsurplus);
	    	};
	    	
	    	
	    	//total produksi
	    	$totalproduksi = 0;
	    	for ($i = 0; $i < count($bulan); $i++) {
	    	    if($komoditas[$i][0]->produksi != null){
	    	         $newtotalproduksi = (float)(str_replace(",", "", $komoditas[$i][0]->produksi));
	    	         $totalproduksi = $totalproduksi +  $newtotalproduksi;
	    	    }
	    	};
	    	
	    	//total ketersediaan
	    	$totalketersediaan = 0;
	    	for ($i = 0; $i < count($bulan); $i++) {
	    	    if($komoditas[$i][0]->ketersediaan != null){
	    	         $totalketersediaan = $totalketersediaan + (float)$komoditas[$i][0]->ketersediaan;
	    	    }
	    	};
	    	
	    	//total surplus
	    	$totalsurplus = 0;
	    	for ($i = 0; $i < count($bulan); $i++) {
	    	   $totalsurplus = $totalsurplus + $surplus[$i];
	    	};
	    	
	    	//sepertinya totalkumultaif tidak usah eheh
	   // 	$totalakumulatif = 0;
	   // 	for ($i = 0; $i < count($bulan); $i++) {
	   // 	    if($akumulatif[$i] != null){
	   // 	         $totalakumulatif = $totalakumulatif + $akumulatif[$i];
	   // 	    }
	   // 	};
	       
	        $totalkebutuhan = array();
	        for ($i = 0; $i < count($komoditi); $i++) {
        		 $newdata = $this->Diskehan_model->ajax_rekap_kebutuhan_peternakanperikanan_satutahun($tahun,$komoditi);
        		 array_push($totalkebutuhan, $newdata);
        	}
        	 
        	$nb_totalkebutuhan = (float)(str_replace(",", "", $totalkebutuhan[0][0]->jml_kebutuhan)); 	
        	    	
        	   // 	for($i = 0; $i < 1; $i++){
        		  //     if($kebutuhan[$i][0]->jml_kebutuhan == null){
        		  //         array_push($pr_kebutuhan, "-");
        		  //     }
        		  //     else{
    		      //         array_push($pr_kebutuhan, number_format($kebutuhan[$i][0]->jml_kebutuhan,3));
    		      //      }
        		  // }
	    	
	    $total[0] = $totalproduksi;
	    $total[1] = $totalketersediaan;
	    $total[2] = number_format($nb_totalkebutuhan, 3, '.', '');
	    $total[3] = $totalsurplus;
	    $total[4] = $akumulatif;
	    	
// 		echo '<pre>',var_dump($kebutuhan, $komoditas, $akumulatif, $total,$tahun, $komoditi, $totalkebutuhan),'</pre>';
		echo json_encode(array($kebutuhan, $komoditas, $surplus, $akumulatif, $total,$tahun, $komoditi));
	}
	
	function print($tipe, $tahun, $bulan, $kecamatan){
	    
// 		$komoditi = $this->Diskehan_model->getkomoditibyid(1);
		
		$newdata;
		$penduduk = array();
		$konsumsi = array();
		$kebutuhan = array();
		$komoditas = array();
		
		$pr_penduduk = array();
		$pr_konsumsi = array();
		$pr_kebutuhan = array();
		$pr_komoditas_tanam = array();
		$pr_komoditas_panen = array();
		$pr_komoditas_provitas = array();
		$pr_komoditas_produksi = array();
		$pr_komoditas_ketersediaan = array();
		$pr_komoditas_surplus = array();
		$pr_komoditas_psb = array();
		
		
		$namafile = "";
		$judul = "";
		
		if($tipe == '1'){
		    //PERTANIAN
		    
		    $namafile = "Pertanian - ".$tahun;
		    
		     if($bulan == "SEMUA" AND $kecamatan == "SEMUA"){
		             $judul = "KABUPATEN MALANG TAHUN : ".$tahun." PERIODE : SATU TAHUN"; 
		    }
		     else if($kecamatan == "SEMUA"){
		             $judul = "KABUPATEN MALANG TAHUN : ".$tahun." PERIODE : BULAN ".$bulan; 
		    }
		    else if($bulan == "SEMUA"){
		              $namakecamatan = $this->Diskehan_model->getkecamatanbyid($kecamatan);
		              $judul = "KECAMATAN ".$namakecamatan[0]->kec_nama." TAHUN : ".$tahun." PERIODE : SATU TAHUN"; 
		    }
		    else{
		             $namakecamatan = $this->Diskehan_model->getkecamatanbyid($kecamatan);
		             $judul = "KECAMATAN ".$namakecamatan[0]->kec_nama." TAHUN : ".$tahun." PERIODE : BULAN ".$bulan; 
		    }
		    
		    $komoditi = $this->Diskehan_model->getkomoditibyid(1);
		    //penduduk
    		if($kecamatan == "SEMUA"){
    		    $penduduk= $this->Diskehan_model->ajax_rekap_penduduk($tahun);
    		    
    		    
    		   for($i = 0; $i < 12; $i++){
        		  array_push($pr_penduduk,$penduduk[0]->jumlah_penduduk);
        		}
    		}
    		else{
    		    $penduduk= $this->Diskehan_model->ajax_rekap_penduduk_perkecamatan($tahun, $kecamatan);
    		    for($i = 0; $i < 12; $i++){
        		  array_push($pr_penduduk,$penduduk[0]->jumlah_penduduk);
        		}
    		}
    		
    		
    		//konsumsi
    		if($kecamatan == "SEMUA" && $bulan == "SEMUA"){
    		    for ($i = 0; $i < count($komoditi); $i++) {
    		    $newdata = $this->Diskehan_model->ajax_rekap_konsumsi_pertanian($tahun, $komoditi[$i]->det_kmd_nama);
    		    array_push($konsumsi, $newdata);
    		    }
    		    
    		    foreach($konsumsi as $value){
    		        if($value == null){
    		            array_push($pr_konsumsi, '-');
    		        }
    		        else{
    		            array_push($pr_konsumsi, $value[0]->total_konsumsi);
    		        }
    		    }
    		}
    		else if($kecamatan == "SEMUA"){
        		    for ($i = 0; $i < count($komoditi); $i++) {
        		        $newdata = $this->Diskehan_model->ajax_rekap_konsumsi_pertanian_perkecamatan($tahun, $komoditi[$i]->det_kmd_nama);
        		        array_push($konsumsi, $newdata);
        		    }
        		
        		   for($i = 0; $i < 12; $i++){
        		       if($konsumsi[$i][0]->total_konsumsi == null){
        		           array_push($pr_konsumsi,'-');
        		       }
        		       else{
    		            array_push($pr_konsumsi, $konsumsi[$i][0]->total_konsumsi);
    		            }
        		   }
    		}
    		else if($bulan == "SEMUA"){
        		    for ($i = 0; $i < count($komoditi); $i++) {
        		    $newdata = $this->Diskehan_model->ajax_rekap_konsumsi_pertanian_perkecamatan_satutahun($tahun, $komoditi[$i]->det_kmd_nama, $kecamatan);
        		    array_push($konsumsi, $newdata);
        		}
        		
        		for($i = 0; $i < 12; $i++){
        		       if($konsumsi[$i][0]->total_konsumsi == null){
        		           array_push($pr_konsumsi,'-');
        		       }
        		       else{
    		            array_push($pr_konsumsi, $konsumsi[$i][0]->total_konsumsi);
    		            }
        		   }
    		}
    		else{
    		     for ($i = 0; $i < count($komoditi); $i++) {
        		    $newdata = $this->Diskehan_model->ajax_rekap_konsumsi_persatuan($tahun, $komoditi[$i]->det_kmd_nama, $kecamatan, $bulan);
        		    array_push($konsumsi, $newdata);
        		}
        		
        		 foreach($konsumsi as $value){
    		        if($value == null){
    		            array_push($pr_konsumsi, '-');
    		        }
    		        else{
    		            array_push($pr_konsumsi, $value[0]->total_konsumsi);
    		        }
    		    }
    		}
    		
    		//kebutuhan
    		if($kecamatan == "SEMUA" && $bulan == "SEMUA"){
    		    for ($i = 0; $i < count($komoditi); $i++) {
    		         $newdata = $this->Diskehan_model->ajax_rekap_kebutuhan_pertanian_satutahun($tahun,$komoditi[$i]->det_kmd_nama);
    		         array_push($kebutuhan, $newdata);
    	    	}
    	    	
    	    	for($i = 0; $i < 12; $i++){
        		       if($kebutuhan[$i][0]->jml_kebutuhan == null){
        		           array_push($pr_kebutuhan,'-');
        		       }
        		       else{
    		            array_push($pr_kebutuhan, number_format($kebutuhan[$i][0]->jml_kebutuhan,3));
    		            }
        		   } 
    		}
    		else if($kecamatan == "SEMUA"){
    		    for ($i = 0; $i < count($komoditi); $i++) {
    		         $newdata = $this->Diskehan_model->ajax_rekap_kebutuhan_pertanian($tahun,$bulan,$komoditi[$i]->det_kmd_nama);
    		         array_push($kebutuhan, $newdata);
    	    	}
    	    	
    	    	 for($i = 0; $i < 12; $i++){
        		       if($kebutuhan[$i][0]->jml_kebutuhan == null){
        		           array_push($pr_kebutuhan,'-');
        		       }
        		       else{
    		            array_push($pr_kebutuhan, number_format($kebutuhan[$i][0]->jml_kebutuhan,3));
    		            }
        		   } 
    		}
    		else if($bulan == "SEMUA"){ 
    		    for ($i = 0; $i < count($komoditi); $i++) {
    		         $newdata = $this->Diskehan_model->ajax_rekap_kebutuhan_pertanian_satutahun_perkecamatan($tahun,$kecamatan,$komoditi[$i]->det_kmd_nama);
    		         array_push($kebutuhan, $newdata);
    	    	}
    	    	
    	    		for($i = 0; $i < 12; $i++){
        		       if($kebutuhan[$i][0]->jml_kebutuhan == null){
        		           array_push($pr_kebutuhan,'-');
        		       }
        		       else{
    		            array_push($pr_kebutuhan, number_format($kebutuhan[$i][0]->jml_kebutuhan,3));
    		            }
        		   }
    		}
    		else{
    		    for ($i = 0; $i < count($komoditi); $i++) {
    		         $newdata = $this->Diskehan_model->ajax_rekap_kebutuhan_pertanian_persatuan($tahun,$kecamatan,$komoditi[$i]->det_kmd_nama, $bulan);
    		         array_push($kebutuhan, $newdata);
    	    	}
    	    	
    	    	foreach($kebutuhan as $value){
        		       if($value == null){
        		           array_push($pr_kebutuhan,'-');
        		       }
        		       else{
    		            array_push($pr_kebutuhan, number_format($value[0]->jml_kebutuhan,3));
    		            }
        		   }
    		    }
    		    
    		 //data komoditas
        		if($kecamatan == "SEMUA" && $bulan == "SEMUA"){
        		    for ($i = 0; $i < count($komoditi); $i++) {
        		         $newdata = $this->Diskehan_model->ajax_rekap_pertanian_satutahun($tahun,$komoditi[$i]->det_kmd_nama);
        		         array_push($komoditas, $newdata);
        	    	}
        	    	
        	    	for($i = 0; $i < 12; $i++){
        		       if($komoditas[$i][0]->tanam != null){
        		           if($komoditas[$i][0]->tanam != 0){
        		                array_push($pr_komoditas_tanam, number_format($komoditas[$i][0]->tanam,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_tanam,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->panen != 0){
        		                array_push($pr_komoditas_panen, number_format($komoditas[$i][0]->panen,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_panen,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->provitas != 0){
        		                array_push($pr_komoditas_provitas, number_format($komoditas[$i][0]->provitas,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_provitas,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->produksi != 0){
        		                array_push($pr_komoditas_produksi, number_format($komoditas[$i][0]->produksi,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_produksi,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->ketersediaan != 0){
        		                array_push($pr_komoditas_ketersediaan, number_format($komoditas[$i][0]->ketersediaan,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_ketersediaan,"-");
        		           }
        		           
        		          // if($komoditas[$i][0]->surplus != 0){
        		          //      array_push($pr_komoditas_surplus, number_format($komoditas[$i][0]->surplus,3));
        		          // }
        		          // else{
        		          //     array_push($pr_komoditas_surplus,"-");
        		          // }
        		           
        		           if($komoditas[$i][0]->psb != 0){
        		                array_push($pr_komoditas_psb, number_format($komoditas[$i][0]->psb,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_psb,"-");
        		           }
        		       }
        		       else{
        		           array_push($pr_komoditas_tanam,"-");
        		           array_push($pr_komoditas_panen,"-");
        		           array_push($pr_komoditas_provitas,"-");
        		           array_push($pr_komoditas_produksi,"-");
        		           array_push($pr_komoditas_ketersediaan,"-");
        		          // array_push($pr_komoditas_surplus,"-");
        		           array_push($pr_komoditas_psb,"-");
        		       }
        	    	}
        		}
        		else if($kecamatan == "SEMUA")
        		{
        		    for ($i = 0; $i < count($komoditi); $i++) {
        		         $newdata = $this->Diskehan_model->ajax_rekap_pertanian($tahun,$bulan,$komoditi[$i]->det_kmd_nama);
        		         array_push($komoditas, $newdata);
        	    	}
        	    	
        	    	 for($i = 0; $i < 12; $i++){
        		       if($komoditas[$i][0]->tanam != null){
        		           if($komoditas[$i][0]->tanam != 0){
        		                array_push($pr_komoditas_tanam, number_format($komoditas[$i][0]->tanam,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_tanam,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->panen != 0){
        		                array_push($pr_komoditas_panen, number_format($komoditas[$i][0]->panen,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_panen,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->provitas != 0){
        		                array_push($pr_komoditas_provitas, number_format($komoditas[$i][0]->provitas,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_provitas,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->produksi != 0){
        		                array_push($pr_komoditas_produksi, number_format($komoditas[$i][0]->produksi,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_produksi,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->ketersediaan != 0){
        		                array_push($pr_komoditas_ketersediaan, number_format($komoditas[$i][0]->ketersediaan,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_ketersediaan,"-");
        		           }
        		           
        		          // if($komoditas[$i][0]->surplus != 0){
        		          //      array_push($pr_komoditas_surplus, number_format($komoditas[$i][0]->surplus,3));
        		          // }
        		          // else{
        		          //     array_push($pr_komoditas_surplus,"-");
        		          // }
        		           
        		           if($komoditas[$i][0]->psb != 0){
        		                array_push($pr_komoditas_psb, number_format($komoditas[$i][0]->psb,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_psb,"-");
        		           }
        		       }
        		       else{
        		           array_push($pr_komoditas_tanam,"-");
        		           array_push($pr_komoditas_panen,"-");
        		           array_push($pr_komoditas_provitas,"-");
        		           array_push($pr_komoditas_produksi,"-");
        		           array_push($pr_komoditas_ketersediaan,"-");
        		          // array_push($pr_komoditas_surplus,"-");
        		           array_push($pr_komoditas_psb,"-");
        		       }
        	    	 }
        		}
        		else if($bulan == "SEMUA"){
        		    for ($i = 0; $i < count($komoditi); $i++) {
        		         $newdata = $this->Diskehan_model->ajax_rekap_pertanian_perkecamatan($tahun,$kecamatan,$komoditi[$i]->det_kmd_nama);
        		         array_push($komoditas, $newdata);
        	    	}
        	    	
        	    	   for($i = 0; $i < 12; $i++){
        		       if($komoditas[$i][0]->tanam != null){
        		           if($komoditas[$i][0]->tanam != 0){
        		                array_push($pr_komoditas_tanam, number_format($komoditas[$i][0]->tanam,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_tanam,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->panen != 0){
        		                array_push($pr_komoditas_panen, number_format($komoditas[$i][0]->panen,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_panen,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->provitas != 0){
        		                array_push($pr_komoditas_provitas, number_format($komoditas[$i][0]->provitas,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_provitas,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->produksi != 0){
        		                array_push($pr_komoditas_produksi, number_format($komoditas[$i][0]->produksi,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_produksi,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->ketersediaan != 0){
        		                array_push($pr_komoditas_ketersediaan, number_format($komoditas[$i][0]->ketersediaan,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_ketersediaan,"-");
        		           }
        		           
        		          // if($komoditas[$i][0]->surplus != 0){
        		          //      array_push($pr_komoditas_surplus, number_format($komoditas[$i][0]->surplus,3));
        		          // }
        		          // else{
        		          //     array_push($pr_komoditas_surplus,"-");
        		          // }
        		           
        		           if($komoditas[$i][0]->psb != 0){
        		                array_push($pr_komoditas_psb, number_format($komoditas[$i][0]->psb,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_psb,"-");
        		           }
        		       }
        		       else{
        		           array_push($pr_komoditas_tanam,"-");
        		           array_push($pr_komoditas_panen,"-");
        		           array_push($pr_komoditas_provitas,"-");
        		           array_push($pr_komoditas_produksi,"-");
        		           array_push($pr_komoditas_ketersediaan,"-");
        		          // array_push($pr_komoditas_surplus,"-");
        		           array_push($pr_komoditas_psb,"-");
        		       }
        	    	}
        		}
        		else{
        		    for ($i = 0; $i < count($komoditi); $i++) {
        		         $newdata = $this->Diskehan_model->ajax_rekap_pertanian_persatuan($tahun,$kecamatan,$komoditi[$i]->det_kmd_nama, $bulan);
        		         array_push($komoditas, $newdata);
        	    	}
        	    	
        	    	for($i = 0; $i < 12; $i++){
        		       if(count($komoditas[$i]) > 0){
        		           if($komoditas[$i][0]->tanam != 0){
        		                array_push($pr_komoditas_tanam, number_format($komoditas[$i][0]->tanam,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_tanam,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->panen != 0){
        		                array_push($pr_komoditas_panen, number_format($komoditas[$i][0]->panen,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_panen,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->provitas != 0){
        		                array_push($pr_komoditas_provitas, number_format($komoditas[$i][0]->provitas,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_provitas,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->produksi != 0){
        		                array_push($pr_komoditas_produksi, number_format($komoditas[$i][0]->produksi,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_produksi,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->ketersediaan != 0){
        		                array_push($pr_komoditas_ketersediaan, number_format($komoditas[$i][0]->ketersediaan,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_ketersediaan,"-");
        		           }
        		           
        		          // if($komoditas[$i][0]->surplus != 0){
        		          //      array_push($pr_komoditas_surplus, number_format($komoditas[$i][0]->surplus,3));
        		          // }
        		          // else{
        		          //     array_push($pr_komoditas_surplus,"-");
        		          // }
        		           
        		           if($komoditas[$i][0]->psb != 0){
        		                array_push($pr_komoditas_psb, number_format($komoditas[$i][0]->psb,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_psb,"-");
        		           }
        		       }
        		       else{
        		           array_push($pr_komoditas_tanam,"-");
        		           array_push($pr_komoditas_panen,"-");
        		           array_push($pr_komoditas_provitas,"-");
        		           array_push($pr_komoditas_produksi,"-");
        		           array_push($pr_komoditas_ketersediaan,"-");
        		          // array_push($pr_komoditas_surplus,"-");
        		           array_push($pr_komoditas_psb,"-");
        		       }
        		   }
        		}
        		
        		 	for($i = 0; $i < 12; $i++){
        		 	    $komoditi[$i] = $komoditi[$i]->det_kmd_nama;
        		 	}
        		 	
        		 		for($i = 0; $i < 12; $i++){ 
        		 	    	$newsurplus = 0;
                    		$newketersediaan = 0;
                    		$newkebutuhan = 0;
                    		if($pr_komoditas_ketersediaan[$i] == "-"){
                    		    $newkebutuhan = (float)(str_replace(",", "", $pr_kebutuhan[$i]));
                    		    $newsurplus = 0 - $newkebutuhan;
                    		    array_push($pr_komoditas_surplus, $newsurplus);
                    		}
                    		else if($pr_kebutuhan[$i] == "-"){
                    		    $newketersediaan = (float)(str_replace(",", "", $pr_komoditas_ketersediaan[$i]));
                    		    $newsurplus = $newketersediaan - 0;
                    		    array_push($pr_komoditas_surplus, $newsurplus);
                    		}
                    		else if($pr_kebutuhan[$i] == "-" && $pr_komoditas_ketersediaan[$i] == "-"){
                    		    $newsurplus = 0;
                    		    array_push($pr_komoditas_surplus, $newsurplus);
                    		}
                    		else{
                    		    $newkebutuhan = (float)(str_replace(",", "", $pr_kebutuhan[$i]));
                    		    $newketersediaan = (float)(str_replace(",", "", $pr_komoditas_ketersediaan[$i]));
                    		    $newsurplus = $newketersediaan - $newkebutuhan;
                    		    array_push($pr_komoditas_surplus, $newsurplus);
                    		}
        		 	};
		}
		
		else if($tipe == '2'){
		    
		        $namafile = "Peternakan - ".$tahun;
		        
		        if($bulan == "SEMUA"){
		             $judul = "KABUPATEN MALANG TAHUN : ".$tahun." PERIODE : SATU TAHUN"; 
		        }
		        else{
		             $judul = "KABUPATEN MALANG TAHUN : ".$tahun." PERIODE : BULAN ".$bulan; 
		        }
		        
		        //penduduk
		        $penduduk= $this->Diskehan_model->ajax_rekap_penduduk($tahun);
		        $komoditi = $this->Diskehan_model->get_kategori_peternakan();
    		    
    		    for($i = 0; $i < 3; $i++){
        		  array_push($pr_penduduk,$penduduk[0]->jumlah_penduduk);
        		}
        		
                // konsumsi
                if($bulan == "SEMUA"){
            		for ($i = 0; $i < count($komoditi); $i++) {
            		    $newdata = $this->Diskehan_model->ajax_rekap_konsumsi_peternakandanperikanan_pertahun($tahun, $komoditi[$i]->kmd_nama);
            		    array_push($konsumsi, $newdata);
            		}
            		
            		for($i = 0; $i < 3; $i++){
        		       if(count($konsumsi[$i]) > 0){
        		           array_push($pr_konsumsi, $konsumsi[$i][0]->total_konsumsi);
        		       }
        		       else{
    		               array_push($pr_konsumsi, "-");
    		            }
        		   }
                }
                else{
                    for ($i = 0; $i < count($komoditi); $i++) {
            		    $newdata = $this->Diskehan_model-> ajax_rekap_konsumsi_peternakandanperikanan($tahun, $komoditi[$i]->kmd_nama, $bulan);
            		    array_push($konsumsi, $newdata);
            		}
            		
            		for($i = 0; $i < 3; $i++){
        		       if($konsumsi[$i][0]->total_konsumsi == null){
        		           array_push($pr_konsumsi, "-");
        		       }
        		       else{
    		               array_push($pr_konsumsi, $konsumsi[$i][0]->total_konsumsi);
    		            }
        		   }
                }
        		
        // 		//kebutuhan
        		if($bulan == "SEMUA")
        		{
        		    for ($i = 0; $i < count($komoditi); $i++) {
        		         $newdata = $this->Diskehan_model->ajax_rekap_kebutuhan_peternakanperikanan_satutahun($tahun,$komoditi[$i]->kmd_nama);
        		         array_push($kebutuhan, $newdata);
        	    	}
        	    	
        	    	
        	    	for($i = 0; $i < 3; $i++){
        		       if($kebutuhan[$i][0]->jml_kebutuhan == null){
        		           array_push($pr_kebutuhan, "-");
        		       }
        		       else{
    		               array_push($pr_kebutuhan, number_format($kebutuhan[$i][0]->jml_kebutuhan,3));
    		            }
        		   }
        		}
        		else{
        		    for ($i = 0; $i < count($komoditi); $i++) {
        		        $newdata = $this->Diskehan_model->ajax_rekap_kebutuhan_peternakanperikanan($tahun,$bulan, $komoditi[$i]->kmd_nama);
        		         array_push($kebutuhan, $newdata);
        	    	}
        	    	
        	    	for($i = 0; $i < 3; $i++){
        		       if($kebutuhan[$i][0]->jml_kebutuhan == null){
        		           array_push($pr_kebutuhan, "-");
        		       }
        		       else{
    		               array_push($pr_kebutuhan, number_format($kebutuhan[$i][0]->jml_kebutuhan,3));
    		            }
        		   }
        		}
        		
        		//data komoditas
        		if($bulan == "SEMUA")
        		{
        		  for ($i = 0; $i < count($komoditi); $i++) {
        		         $newdata = $this->Diskehan_model->ajax_rekap_peternakanperikanan_satutahun($tahun,$komoditi[$i]->kmd_nama);
        		         array_push($komoditas, $newdata);
        	    	}
        	    	
        	            for($i = 0; $i < 3; $i++){
        	                
        	               array_push($pr_komoditas_tanam," ");
        		           array_push($pr_komoditas_panen," ");
        		           array_push($pr_komoditas_provitas," ");
        		           
        		           
        		       if(count($komoditas[$i]) > 0){
        		           if($komoditas[$i][0]->produksi != 0){
        		                array_push($pr_komoditas_produksi, number_format($komoditas[$i][0]->produksi,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_produksi,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->ketersediaan != 0){
        		                array_push($pr_komoditas_ketersediaan, number_format($komoditas[$i][0]->ketersediaan,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_ketersediaan,"-");
        		           }
        		           
        		          // if($komoditas[$i][0]->surplus != 0){
        		          //      array_push($pr_komoditas_surplus, number_format($komoditas[$i][0]->surplus,3));
        		          // }
        		          // else{
        		          //     array_push($pr_komoditas_surplus,"-");
        		          // }
        		           
        		           if($komoditas[$i][0]->psb != 0){
        		                array_push($pr_komoditas_psb, number_format($komoditas[$i][0]->psb,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_psb,"-");
        		           }
        		       }
        		       else{
        		           array_push($pr_komoditas_produksi,"-");
        		           array_push($pr_komoditas_ketersediaan,"-");
        		          // array_push($pr_komoditas_surplus,"-");
        		           array_push($pr_komoditas_psb,"-");
        		       }
        		   }
        		}
        		else{
        		    for ($i = 0; $i < count($komoditi); $i++) {
        		         $newdata = $this->Diskehan_model->ajax_rekap_peternakanperikanan($tahun,$bulan,$komoditi[$i]->kmd_nama);
        		         array_push($komoditas, $newdata);
        	    	}
        	    	
        	    	for($i = 0; $i < 3; $i++){
        	    	      array_push($pr_komoditas_tanam," ");
        		           array_push($pr_komoditas_panen," ");
        		           array_push($pr_komoditas_provitas," ");
        		       if(count($komoditas[$i]) > 0){
        		           if($komoditas[$i][0]->produksi != 0){
        		                array_push($pr_komoditas_produksi, number_format($komoditas[$i][0]->produksi,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_produksi,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->ketersediaan != 0){
        		                array_push($pr_komoditas_ketersediaan, number_format($komoditas[$i][0]->ketersediaan,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_ketersediaan,"-");
        		           }
        		           
        		          // if($komoditas[$i][0]->surplus != 0){
        		          //      array_push($pr_komoditas_surplus, number_format($komoditas[$i][0]->surplus,3));
        		          // }
        		          // else{
        		          //     array_push($pr_komoditas_surplus,"-");
        		          // }
        		           
        		           if($komoditas[$i][0]->psb != 0){
        		                array_push($pr_komoditas_psb, number_format($komoditas[$i][0]->psb,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_psb,"-");
        		           }
        		       }
        		       else{
        		           array_push($pr_komoditas_produksi,"-");
        		           array_push($pr_komoditas_ketersediaan,"-");
        		          // array_push($pr_komoditas_surplus,"-");
        		           array_push($pr_komoditas_psb,"-");
        		       }
        		   }
        		}
        		
        			for($i = 0; $i < 3; $i++){
        		 	    $komoditi[$i] = $komoditi[$i]->kmd_nama;
        		 	}
        		 	
        		 	//coba print surplus peternakan
        		 	for($i = 0; $i < 3; $i++){
            		$newsurplus = 0;
            		$newketersediaan = 0;
            		$newkebutuhan = 0;
            		if($pr_komoditas_ketersediaan[$i] == "-"){
            		    $newkebutuhan = (float)(str_replace(",", "", $pr_kebutuhan[$i]));
            		    $newsurplus = 0 - $newkebutuhan;
            		    array_push($pr_komoditas_surplus, $newsurplus);
            		}
            		else if($pr_kebutuhan[$i] == "-"){
            		    $newketersediaan = (float)(str_replace(",", "", $pr_komoditas_ketersediaan[$i]));
            		    $newsurplus = $newketersediaan - 0;
            		    array_push($pr_komoditas_surplus, $newsurplus);
            		}
            		else if($pr_kebutuhan[$i] == "-" && $pr_komoditas_ketersediaan[$i] == "-"){
            		    $newsurplus = 0;
            		    array_push($pr_komoditas_surplus, $newsurplus);
            		}
            		else{
            		    $newkebutuhan = (float)(str_replace(",", "", $pr_kebutuhan[$i]));
            		    $newketersediaan = (float)(str_replace(",", "", $pr_komoditas_ketersediaan[$i]));
            		    $newsurplus = $newketersediaan - $newkebutuhan;
            		    array_push($pr_komoditas_surplus, $newsurplus);
            		}
            	}
        		  
		}
		
		else if($tipe == '3'){
		    
		    $namafile = "Perikanan - ".$tahun;
		    
		     if($bulan == "SEMUA"){
		             $judul = "KABUPATEN MALANG TAHUN : ".$tahun." PERIODE : SATU TAHUN"; 
		     }
		     else{
		             $judul = "KABUPATEN MALANG TAHUN : ".$tahun." PERIODE : BULAN ".$bulan; 
		     }

                                                        
		    $komoditi = $this->Diskehan_model->get_kategori_perikanan();
		    $penduduk= $this->Diskehan_model->ajax_rekap_penduduk($tahun);
		    
		        for($i = 0; $i <  1; $i++){
        		  array_push($pr_penduduk,$penduduk[0]->jumlah_penduduk);
        		}
        		
                // konsumsi
                if($bulan == "SEMUA"){
            		for ($i = 0; $i < count($komoditi); $i++) {
            		    $newdata = $this->Diskehan_model->ajax_rekap_konsumsi_peternakandanperikanan_pertahun($tahun, $komoditi[$i]->kmd_nama);
            		    array_push($konsumsi, $newdata);
            		}
            		
            		for($i = 0; $i < 1; $i++){
        		       if(count($konsumsi[$i]) > 0){
        		           array_push($pr_konsumsi, $konsumsi[$i][0]->total_konsumsi);
        		       }
        		       else{
    		               array_push($pr_konsumsi, "-");
    		            }
        		   }
                }
                else{
                    for ($i = 0; $i < count($komoditi); $i++) {
            		    $newdata = $this->Diskehan_model-> ajax_rekap_konsumsi_peternakandanperikanan($tahun, $komoditi[$i]->kmd_nama, $bulan);
            		    array_push($konsumsi, $newdata);
            		}
            		
            		for($i = 0; $i < 1; $i++){
        		       if($konsumsi[$i][0]->total_konsumsi == null){
        		           array_push($pr_konsumsi, "-");
        		       }
        		       else{
    		               array_push($pr_konsumsi, $konsumsi[$i][0]->total_konsumsi);
    		            }
        		   }
                }
        		
        // 		//kebutuhan
        		if($bulan == "SEMUA")
        		{
        		    for ($i = 0; $i < count($komoditi); $i++) {
        		         $newdata = $this->Diskehan_model->ajax_rekap_kebutuhan_peternakanperikanan_satutahun($tahun,$komoditi[$i]->kmd_nama);
        		         array_push($kebutuhan, $newdata);
        	    	}
        	    	
        	    	
        	    	for($i = 0; $i < 1; $i++){
        		       if($kebutuhan[$i][0]->jml_kebutuhan == null){
        		           array_push($pr_kebutuhan, "-");
        		       }
        		       else{
    		               array_push($pr_kebutuhan, number_format($kebutuhan[$i][0]->jml_kebutuhan,3));
    		            }
        		   }
        		}
        		else{
        		    for ($i = 0; $i < count($komoditi); $i++) {
        		        $newdata = $this->Diskehan_model->ajax_rekap_kebutuhan_peternakanperikanan($tahun,$bulan, $komoditi[$i]->kmd_nama);
        		         array_push($kebutuhan, $newdata);
        	    	}
        	    	
        	    	for($i = 0; $i < 1; $i++){
        		       if($kebutuhan[$i][0]->jml_kebutuhan == null){
        		           array_push($pr_kebutuhan, "-");
        		       }
        		       else{
    		               array_push($pr_kebutuhan, number_format($kebutuhan[$i][0]->jml_kebutuhan,3));
    		            }
        		   }
        		}
        		
        		//data komoditas
        		if($bulan == "SEMUA")
        		{
        		  for ($i = 0; $i < count($komoditi); $i++) {
        		         $newdata = $this->Diskehan_model->ajax_rekap_peternakanperikanan_satutahun($tahun,$komoditi[$i]->kmd_nama);
        		         array_push($komoditas, $newdata);
        	    	}
        	    	
        	        	for($i = 0; $i < 1; $i++){
        	        	  array_push($pr_komoditas_tanam," ");
        		           array_push($pr_komoditas_panen," ");
        		           array_push($pr_komoditas_provitas," ");
        		       if(count($komoditas[$i]) > 0){
        		           if($komoditas[$i][0]->produksi != 0){
        		                array_push($pr_komoditas_produksi, number_format($komoditas[$i][0]->produksi,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_produksi,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->ketersediaan != 0){
        		                array_push($pr_komoditas_ketersediaan, number_format($komoditas[$i][0]->ketersediaan,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_ketersediaan,"-");
        		           }
        		           
        		          // if($komoditas[$i][0]->surplus != 0){
        		          //      array_push($pr_komoditas_surplus, number_format($komoditas[$i][0]->surplus,3));
        		          // }
        		          // else{
        		          //     array_push($pr_komoditas_surplus,"-");
        		          // }
        		           
        		           if($komoditas[$i][0]->psb != 0){
        		                array_push($pr_komoditas_psb, number_format($komoditas[$i][0]->psb,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_psb,"-");
        		           }
        		       }
        		       else{
        		           array_push($pr_komoditas_produksi,"-");
        		           array_push($pr_komoditas_ketersediaan,"-");
        		          // array_push($pr_komoditas_surplus,"-");
        		           array_push($pr_komoditas_psb,"-");
        		       }
        		   }
        		}
        		else{
        		    for ($i = 0; $i < count($komoditi); $i++) {
        		         $newdata = $this->Diskehan_model->ajax_rekap_peternakanperikanan($tahun,$bulan,$komoditi[$i]->kmd_nama);
        		         array_push($komoditas, $newdata);
        	    	}
        	    	
        	    	for($i = 0; $i < 1; $i++){
        	    	      array_push($pr_komoditas_tanam," ");
        		           array_push($pr_komoditas_panen," ");
        		           array_push($pr_komoditas_provitas," ");
        		           
        		       if(count($komoditas[$i]) > 0){
        		           if($komoditas[$i][0]->produksi != 0){
        		                array_push($pr_komoditas_produksi, number_format($komoditas[$i][0]->produksi,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_produksi,"-");
        		           }
        		           
        		           if($komoditas[$i][0]->ketersediaan != 0){
        		                array_push($pr_komoditas_ketersediaan, number_format($komoditas[$i][0]->ketersediaan,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_ketersediaan,"-");
        		           }
        		           
        		          // if($komoditas[$i][0]->surplus != 0){
        		          //      array_push($pr_komoditas_surplus, number_format($komoditas[$i][0]->surplus,3));
        		          // }
        		          // else{
        		          //     array_push($pr_komoditas_surplus,"-");
        		          // }
        		           
        		           if($komoditas[$i][0]->psb != 0){
        		                array_push($pr_komoditas_psb, number_format($komoditas[$i][0]->psb,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_psb,"-");
        		           }
        		       }
        		       else{
        		           array_push($pr_komoditas_produksi,"-");
        		           array_push($pr_komoditas_ketersediaan,"-");
        		          // array_push($pr_komoditas_surplus,"-");
        		           array_push($pr_komoditas_psb,"-");
        		       }
        		   }
        		}
        		
        		for($i = 0; $i < 1; $i++){
        		 	    $komoditi[$i] = $komoditi[$i]->kmd_nama;
        		 	}
        		 	
        		//coba surplus
        		$newsurplus = 0;
        		$newketersediaan = 0;
        		$newkebutuhan = 0;
        		if($pr_komoditas_ketersediaan[0] == "-"){
        		    $newkebutuhan = (float)(str_replace(",", "", $pr_kebutuhan[0]));
        		    $newsurplus = 0 - $newkebutuhan;
        		    array_push($pr_komoditas_surplus, $newsurplus);
        		}
        		else if($pr_kebutuhan[0] == "-"){
        		    $newketersediaan = (float)(str_replace(",", "", $pr_komoditas_ketersediaan[0]));
        		    $newsurplus = $newketersediaan - 0;
        		    array_push($pr_komoditas_surplus, $newsurplus);
        		}
        		else if($pr_kebutuhan[0] == "-" && $pr_komoditas_ketersediaan[0] == "-"){
        		    $newsurplus = 0;
        		    array_push($pr_komoditas_surplus, $newsurplus);
        		}
        		else{
        		    $newkebutuhan = (float)(str_replace(",", "", $pr_kebutuhan[0]));
        		    $newketersediaan = (float)(str_replace(",", "", $pr_komoditas_ketersediaan[0]));
        		    $newsurplus = $newketersediaan - $newkebutuhan;
        		    array_push($pr_komoditas_surplus, $newsurplus);
        		}
		    
		}
		else if($tipe == 'SEMUA'){
		    
		     $namafile = "Rekap Tahun - ".$tahun;
		    
		     
		    $judul = "KABUPATEN MALANG TAHUN : ".$tahun; 
		    
		      $penduduk= $this->Diskehan_model->ajax_rekap_penduduk($tahun);
		      $komoditi = array();
    		    
    		    
    		 for($i = 0; $i < 16; $i++){
        		  array_push($pr_penduduk,$penduduk[0]->jumlah_penduduk);
        	 }
        	 
        	 $komoditi1 = $this->Diskehan_model->getkomoditibyid(1);
             $komoditi2 = $this->Diskehan_model->get_kategori_peternakan();
             $komoditi3 = $this->Diskehan_model->get_kategori_perikanan();
             $konsumsi1 = array();
             $konsumsi2 = array();
             $konsumsi3 = array();
             $kebutuhan1 = array();
             $kebutuhan2 = array();
             $kebutuhan3 = array();
             $komoditas1 = array();
             $komoditas2 = array();
             $komoditas3 = array();
             
              foreach ($komoditi1 as $key) {
        	   array_push($komoditi,$key->det_kmd_nama);
             }

            foreach ($komoditi2 as $key) {
        	   array_push($komoditi,$key->kmd_nama);
             }
             
             foreach ($komoditi3 as $key) {
        	   array_push($komoditi,$key->kmd_nama);
             }
             
            //konsumsi
              for ($i = 0; $i < count($komoditi1); $i++) {
              		$newdata = $this->Diskehan_model->ajax_rekap_konsumsi_pertanian($tahun, $komoditi1[$i]->det_kmd_nama);
              		array_push($konsumsi1, $newdata);
              }
    		    
              foreach($konsumsi1 as $value){
               if($value == null){
                	array_push($pr_konsumsi, '-');
                }
                else{
                	array_push($pr_konsumsi, $value[0]->total_konsumsi);
                }
               }

              for ($i = 0; $i < count($komoditi2); $i++) {
                  $newdata = $this->Diskehan_model->ajax_rekap_konsumsi_peternakandanperikanan_pertahun($tahun, $komoditi2[$i]->kmd_nama);
                  array_push($konsumsi2, $newdata);
                 }
                        		
                for($i = 0; $i < 3; $i++){
                  if(count($konsumsi2[$i]) > 0){
                    array_push($pr_konsumsi, $konsumsi2[$i][0]->total_konsumsi);
                    }
                  	else{
                	array_push($pr_konsumsi, "-");
                	 }
                 }

                 for ($i = 0; $i < count($komoditi3); $i++) {
                    $newdata = $this->Diskehan_model->ajax_rekap_konsumsi_peternakandanperikanan_pertahun($tahun, $komoditi3[$i]->kmd_nama);
                    array_push($konsumsi3, $newdata);
                }
                        		
                for($i = 0; $i < 1; $i++){
                if(count($konsumsi3[$i]) > 0){
                    array_push($pr_konsumsi, $konsumsi3[$i][0]->total_konsumsi);
                }
                else{
                	array_push($pr_konsumsi, "-");
                }
                }
                
                //kebutuhan
                for ($i = 0; $i < count($komoditi1); $i++) {
                	$newdata = $this->Diskehan_model->ajax_rekap_kebutuhan_pertanian_satutahun($tahun,$komoditi1[$i]->det_kmd_nama);
                    array_push($kebutuhan1, $newdata);
                }
                	    	
                 for($i = 0; $i < 12; $i++){
                if($kebutuhan1[$i][0]->jml_kebutuhan == null){
                    	array_push($pr_kebutuhan,'-');
                }
                else{
                		 array_push($pr_kebutuhan, number_format($kebutuhan1[$i][0]->jml_kebutuhan,3));
                	}
                }
            
                for ($i = 0; $i < count($komoditi2); $i++) {
                    $newdata = $this->Diskehan_model->ajax_rekap_kebutuhan_peternakanperikanan_satutahun($tahun,$komoditi2[$i]->kmd_nama);
                     array_push($kebutuhan2, $newdata);
                 }
                    	    	
                    	    	
                 for($i = 0; $i < 3; $i++){
                   if($kebutuhan2[$i][0]->jml_kebutuhan == null){
                    array_push($pr_kebutuhan, "-");
                   }
                   else{
                	array_push($pr_kebutuhan, number_format($kebutuhan2[$i][0]->jml_kebutuhan,3));
                	}
                  }

                 for ($i = 0; $i < count($komoditi3); $i++) {
        		         $newdata = $this->Diskehan_model->ajax_rekap_kebutuhan_peternakanperikanan_satutahun($tahun,$komoditi3[$i]->kmd_nama);
        		         array_push($kebutuhan3, $newdata);
        	    	}
        	    	
        	    	
        	    	for($i = 0; $i < 1; $i++){
        		       if($kebutuhan3[$i][0]->jml_kebutuhan == null){
        		           array_push($pr_kebutuhan, "-");
        		       }
        		       else{
    		               array_push($pr_kebutuhan, number_format($kebutuhan3[$i][0]->jml_kebutuhan,3));
    		            }
        		   }
        		   
        		   
        		     //komoditaas
     for ($i = 0; $i < count($komoditi1); $i++) {
        $newdata = $this->Diskehan_model->ajax_rekap_pertanian_satutahun($tahun,$komoditi1[$i]->det_kmd_nama);
      	 array_push($komoditas1, $newdata);
      }
        	    	
       for($i = 0; $i < 12; $i++){
        	if($komoditas1[$i][0]->tanam != null){
        		           if($komoditas1[$i][0]->tanam != 0){
        		                array_push($pr_komoditas_tanam, number_format($komoditas1[$i][0]->tanam,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_tanam,"-");
        		           }
        		           
        		           if($komoditas1[$i][0]->panen != 0){
        		                array_push($pr_komoditas_panen, number_format($komoditas1[$i][0]->panen,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_panen,"-");
        		           }
        		           
        		           if($komoditas1[$i][0]->provitas != 0){
        		                array_push($pr_komoditas_provitas, number_format($komoditas1[$i][0]->provitas,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_provitas,"-");
        		           }
        		           
        		           if($komoditas1[$i][0]->produksi != 0){
        		                array_push($pr_komoditas_produksi, number_format($komoditas1[$i][0]->produksi,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_produksi,"-");
        		           }
        		           
        		           if($komoditas1[$i][0]->ketersediaan != 0){
        		                array_push($pr_komoditas_ketersediaan, number_format($komoditas1[$i][0]->ketersediaan,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_ketersediaan,"-");
        		           }
        		           
        		           if($komoditas1[$i][0]->surplus != 0){
        		                array_push($pr_komoditas_surplus, number_format($komoditas1[$i][0]->surplus,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_surplus,"-");
        		           }
        		           
        		           if($komoditas1[$i][0]->psb != 0){
        		                array_push($pr_komoditas_psb, number_format($komoditas1[$i][0]->psb,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_psb,"-");
        		           }
        		       }
        		       else{
        		           array_push($pr_komoditas_tanam,"-");
        		           array_push($pr_komoditas_panen,"-");
        		           array_push($pr_komoditas_provitas,"-");
        		           array_push($pr_komoditas_produksi,"-");
        		           array_push($pr_komoditas_ketersediaan,"-");
        		           array_push($pr_komoditas_surplus,"-");
        		           array_push($pr_komoditas_psb,"-");
       		 }
        }

        for ($i = 0; $i < count($komoditi2); $i++) {
        		         $newdata = $this->Diskehan_model->ajax_rekap_peternakanperikanan_satutahun($tahun,$komoditi2[$i]->kmd_nama);
        		         array_push($komoditas2, $newdata);
        	    	}
        	    	
        	        	for($i = 0; $i < 3; $i++){
        	        	    
        	        	   array_push($pr_komoditas_tanam," ");
        		           array_push($pr_komoditas_panen," ");
        		           array_push($pr_komoditas_provitas," ");
        		           
        		       if(count($komoditas2[$i]) > 0){
        		           if($komoditas2[$i][0]->produksi != 0){
        		                array_push($pr_komoditas_produksi, number_format($komoditas2[$i][0]->produksi,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_produksi,"-");
        		           }
        		           
        		           if($komoditas2[$i][0]->ketersediaan != 0){
        		                array_push($pr_komoditas_ketersediaan, number_format($komoditas2[$i][0]->ketersediaan,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_ketersediaan,"-");
        		           }
        		           
        		           if($komoditas2[$i][0]->surplus != 0){
        		                array_push($pr_komoditas_surplus, number_format($komoditas2[$i][0]->surplus,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_surplus,"-");
        		           }
        		           
        		           if($komoditas2[$i][0]->psb != 0){
        		                array_push($pr_komoditas_psb, number_format($komoditas2[$i][0]->psb,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_psb,"-");
        		           }
        		       }
        		       else{
        		           array_push($pr_komoditas_produksi,"-");
        		           array_push($pr_komoditas_ketersediaan,"-");
        		           array_push($pr_komoditas_surplus,"-");
        		           array_push($pr_komoditas_psb,"-");
        		       }
        		   }

        for ($i = 0; $i < count($komoditi3); $i++) {
        		         $newdata = $this->Diskehan_model->ajax_rekap_peternakanperikanan_satutahun($tahun,$komoditi3[$i]->kmd_nama);
        		         array_push($komoditas3, $newdata);
        	    	}
        	    	
        	        	for($i = 0; $i < 1; $i++){
        	        	    
        	        	   array_push($pr_komoditas_tanam," ");
        		           array_push($pr_komoditas_panen," ");
        		           array_push($pr_komoditas_provitas," ");
        		           
        		       if(count($komoditas3[$i]) > 0){
        		           if($komoditas3[$i][0]->produksi != 0){
        		                array_push($pr_komoditas_produksi, number_format($komoditas3[$i][0]->produksi,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_produksi,"-");
        		           }
        		           
        		           if($komoditas3[$i][0]->ketersediaan != 0){
        		                array_push($pr_komoditas_ketersediaan, number_format($komoditas3[$i][0]->ketersediaan,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_ketersediaan,"-");
        		           }
        		           
        		           if($komoditas3[$i][0]->surplus != 0){
        		                array_push($pr_komoditas_surplus, number_format($komoditas3[$i][0]->surplus,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_surplus,"-");
        		           }
        		           
        		           if($komoditas3[$i][0]->psb != 0){
        		                array_push($pr_komoditas_psb, number_format($komoditas3[$i][0]->psb,3));
        		           }
        		           else{
        		               array_push($pr_komoditas_psb,"-");
        		           }
        		       }
        		       else{
        		           array_push($pr_komoditas_produksi,"-");
        		           array_push($pr_komoditas_ketersediaan,"-");
        		           array_push($pr_komoditas_surplus,"-");
        		           array_push($pr_komoditas_psb,"-");
        		       }
        		   }
		    }
		            
		          //  echo "<pre>"; var_dump($komoditi); "</pre>";
		          //  echo "<pre>"; var_dump($pr_komoditas_tanam); "</pre>";
        		  //  echo "<pre>"; var_dump($pr_komoditas_panen); "</pre>";
        		  //  echo "<pre>"; var_dump($pr_komoditas_provitas); "</pre>";
        		  //  echo "<pre>"; var_dump($pr_komoditas_produksi); "</pre>";
        		  //  echo "<pre>"; var_dump($pr_komoditas_ketersediaan); "</pre>";
        		  //  echo "<pre>"; var_dump($pr_komoditas_surplus); "</pre>";
        		  //  echo "<pre>"; var_dump($pr_komoditas_psb); "</pre>";
		
		//mulai print
			include APPPATH.'third_party/PHPExcel/PHPExcel.php';

		$excel = new PHPExcel();

		$excel->getDefaultStyle()->getFont()->setName('Arial');
		$excel->getDefaultStyle()->getFont()->setSize(10);  
		$excel->getActiveSheet()->getDefaultColumnDimension()->setWidth(15); 

		$style_col = array(
			'alignment' => array(
			  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
			  'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			)
		  );

		  $style_satu = array(
			'borders' => array(
			  'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
			  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
			  'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
			  'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			));

			$style_row = array(
				'alignment' => array(
				  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
				  'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
				),
				'borders' => array(
					'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
					'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
					'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
					'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
				  )
			  );

		$excel->getActiveSheet(0)->setTitle("Rekap");
		$excel->setActiveSheetIndex(0);

		$excel->getActiveSheet()->mergeCells('A2:K2');
		$excel->setActiveSheetIndex(0)->setCellValue('A2', "REALISASI KEBUTUHAN DAN KETERSEDIAAN PANGAN KABUPATEN MALANG");
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);

		$excel->getActiveSheet()->mergeCells('A3:K3');
		
		$excel->setActiveSheetIndex(0)->setCellValue('A3', $judul);
		$excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);

		$excel->getActiveSheet()->mergeCells('A5:A7');
		$excel->setActiveSheetIndex(0)->setCellValue('A5',"No.");
		$excel->getActiveSheet()->getStyle('A5')->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('a7b4c9');
		$excel->getActiveSheet()->getStyle('A5:A7')->applyFromArray($style_satu);

		$excel->getActiveSheet()->mergeCells('B5:E5');
		$excel->setActiveSheetIndex(0)->setCellValue('B5',"KEBUTUHAN PANGAN");
		$excel->getActiveSheet()->getStyle('B5')->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('a7b4c9');
		$excel->getActiveSheet()->getStyle('B5')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('B5:E5')->applyFromArray($style_satu);

		$excel->getActiveSheet()->mergeCells('B6:B7');
		$excel->setActiveSheetIndex(0)->setCellValue('B6',"KOMODITI");
		$excel->getActiveSheet()->getStyle('B6')->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('e085c2');
		$excel->getActiveSheet()->getStyle('B6:B7')->applyFromArray($style_satu);

		$excel->setActiveSheetIndex(0)->setCellValue('C6',"Jml Penduduk");
		$excel->getActiveSheet()->getStyle('C6')->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('e085c2');

		$excel->setActiveSheetIndex(0)->setCellValue('C7',"(Jiwa)");
		$excel->getActiveSheet()->getStyle('C7')->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('e085c2');
		$excel->getActiveSheet()->getStyle('C6:C7')->applyFromArray($style_satu);

		$excel->setActiveSheetIndex(0)->setCellValue('D6',"Konsumsi");
		$excel->getActiveSheet()->getStyle('D6')->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('e085c2');

		$excel->setActiveSheetIndex(0)->setCellValue('D7',"Kg/kap./bln");
		$excel->getActiveSheet()->getStyle('D7')->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('e085c2');
		$excel->getActiveSheet()->getStyle('D6:D7')->applyFromArray($style_satu);

		$excel->setActiveSheetIndex(0)->setCellValue('E6',"Kebutuhan");
		$excel->getActiveSheet()->getStyle('E6')->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('e085c2');

		$excel->setActiveSheetIndex(0)->setCellValue('E7',"(Ton)");
		$excel->getActiveSheet()->getStyle('E7')->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('e085c2');
		$excel->getActiveSheet()->getStyle('E6:E7')->applyFromArray($style_satu);

		$excel->getActiveSheet()->mergeCells('F5:I5');
		$excel->setActiveSheetIndex(0)->setCellValue('F5',"KETERSEDIAAN PANGAN");
		$excel->getActiveSheet()->getStyle('F5')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('F5')->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('ff9999');
		$excel->getActiveSheet()->getStyle('F5:I5')->applyFromArray($style_satu);

		$excel->setActiveSheetIndex(0)->setCellValue('F6',"Luas Panen");
		$excel->setActiveSheetIndex(0)->setCellValue('F7',"(Ha)");
		$excel->getActiveSheet()->getStyle('F6:F7')->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('2eb82e');
		$excel->getActiveSheet()->getStyle('F6:F7')->applyFromArray($style_satu);

		$excel->setActiveSheetIndex(0)->setCellValue('G6',"Produktivitas");
		$excel->setActiveSheetIndex(0)->setCellValue('G7',"(Kw/ha)");
		$excel->getActiveSheet()->getStyle('G6:G7')->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('2eb82e');
		$excel->getActiveSheet()->getStyle('G6:G7')->applyFromArray($style_satu);

		$excel->setActiveSheetIndex(0)->setCellValue('H6',"Produksi");
		$excel->setActiveSheetIndex(0)->setCellValue('H7',"(Ton)");
		$excel->getActiveSheet()->getStyle('H6:H7')->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('2eb82e');
		$excel->getActiveSheet()->getStyle('H6:H7')->applyFromArray($style_satu);

		$excel->setActiveSheetIndex(0)->setCellValue('I6',"Ketersediaan");
		$excel->setActiveSheetIndex(0)->setCellValue('I7',"(Ton, Beras)");
		$excel->getActiveSheet()->getStyle('I6:I7')->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('2eb82e');
		$excel->getActiveSheet()->getStyle('I6:I7')->applyFromArray($style_satu);

		$excel->getActiveSheet()->mergeCells('J5:J6');
		$excel->setActiveSheetIndex(0)->setCellValue('J5',"Surplus/Minus");
		$excel->setActiveSheetIndex(0)->setCellValue('J7',"(Ton, Beras)");
		$excel->getActiveSheet()->getStyle('J5:J7')->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('ffff1a');
		$excel->getActiveSheet()->getStyle('J5:J7')->applyFromArray($style_satu);

		$excel->getActiveSheet()->mergeCells('K5:K6');
		$excel->setActiveSheetIndex(0)->setCellValue('K5',"PSB");
		$excel->setActiveSheetIndex(0)->setCellValue('K7',"(Ton)");
		$excel->getActiveSheet()->getStyle('K5:K7')->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('ff8c1a');
		$excel->getActiveSheet()->getStyle('K5:K7')->applyFromArray($style_satu);
		

		$no = 1; // Untuk penomoran tabel, di awal set dengan 1
		$numrow = 8; // Set baris pertama untuk isi tabel adalah baris ke 4
		
    //         for ($i = 0; $i < count($komoditi); $i++) {
				// $excel->setActiveSheetIndex(0)->setCellValue('B'.($numrow+$i), $komoditi[$i]->det_kmd_nama);
				
				// $excel->getActiveSheet()->getStyle('B'.($numrow+$i))->applyFromArray($style_row);
    // 		}
    
            //komoditi
			foreach($komoditi as $value){ 
				$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
				$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $value);
				
				// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
				$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
				
				$no++; // Tambah 1 setiap kali looping
				$numrow++; // Tambah 1 setiap kali looping
			}
			
			//penduduk
			$numrow = 8;
			foreach($pr_penduduk as $value){ 
				$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $value);
				
				$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('C'.$numrow)->getNumberFormat()->setFormatCode('#,##0');
				
				$numrow++; 
			}
			
			//konsumsi
			$numrow = 8;
			foreach($pr_konsumsi as $value){ 
				$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $value);
				
				$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('D'.$numrow)->getNumberFormat()->setFormatCode('#,##0.000');
				
				$numrow++; 
			}
			
			//kebutuhan
			$numrow = 8;
			foreach($pr_kebutuhan as $value){ 
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $value);
				
				$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
				
				$numrow++; 
			}
			
			//panen
			$numrow = 8;
			foreach($pr_komoditas_panen as $value){ 
				$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $value);
				
				$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
				
				$numrow++; 
			}
			
			//provitas
			$numrow = 8;
			foreach($pr_komoditas_provitas as $value){ 
				$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $value);
				
				$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
				
				$numrow++; 
			}
			
			//produksi
			$numrow = 8;
			foreach($pr_komoditas_produksi as $value){ 
				$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $value);
				
				$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
				
				$numrow++; 
			}
			
			//ketersediaan
			$numrow = 8;
			foreach($pr_komoditas_ketersediaan as $value){ 
				$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $value);
				
				$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
				
				$numrow++; 
			}
			
			//surplus
			$numrow = 8;
			foreach($pr_komoditas_surplus as $value){ 
				$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $value);
				
				$excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('J'.$numrow)->getNumberFormat()->setFormatCode('#,##0.000');
				
				$numrow++; 
			}
			
			//surplus
			$numrow = 8;
			foreach($pr_komoditas_psb as $value){ 
				$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $value);
				
				$excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
				
				$numrow++; 
			}
		
		$excel->getActiveSheet()->getStyle('A1:O50')->applyFromArray($style_col);
		

		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=$namafile.xlsx"); // Set nama file excel nya
		header('Cache-Control: max-age=0');

		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');


	}
	
}

/* End of file Diskehan.php */
/* Location: ./application/controllers/Diskehan.php */