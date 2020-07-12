<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Analisis extends CI_Controller
{


	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation', 'session'));

		$this->load->model('M_analisis');
		if (!$this->session->userdata('username')) {
			redirect('Login');
		}
	}

	public function index()
	{
		$data['analisis'] = $this->M_analisis->getDataAnalisis();
		$data['page'] = 'Analisis.php';
		$this->load->view('Admin/Menu', $data);
	}

	public function simpanhasilAnalisis($id)
	{
		$data = array(
			'fk_id_analisis' => $id,
			'usia' => $this->input->post('usia'),
			'lemak_tubuh' => $this->input->post('lemak_tubuh'),  
			'kadar_air' => $this->input->post('kadar_air'),
			'postur_tubuh' => $this->input->post('postur_tubuh'),
			'massa_tulang' => $this->input->post('massa_tulang'), 
			'lemak_perut' => $this->input->post('lemak_perut'), 
			'shake' => $this->input->post('shake'), 
			'aloe' => $this->input->post('aloe'), 
			'thermo' => $this->input->post('thermo'), 
			'nrg' => $this->input->post('nrg'),
			'ppp' => $this->input->post('ppp'), 
			'mixed_fiber' => $this->input->post('mixed'),  
		);
		$where=array(
			'fk_id_analisis' => $id
		);

		$db_analisis = $this->db->where('fk_id_analisis', $id)->get('output')->row();
		if ($db_analisis == null) {
			$this->M_analisis->input($data,'output');
		}
		else{
			$this->M_analisis->update_data($where,$data,'output');
		}
		redirect('Analisis');

	}

	public function hasil_analisis($id)
	{
		$data['getData']= $this->M_analisis->getDataHasilAnalisis($id);
		$data['page'] = 'Hasil.php';
		$this->load->view('Admin/Menu',$data);

	}

	public function addAnalisis()
	{
		$data['page'] = 'addAnalisis.php';
		$this->load->view('Admin/Menu', $data);
	}

	public function simpanAnalisis()
	{

		$data = array();
		$this->load->helper('url', 'form');
		$this->load->library("form_validation");
		//        jika anda mau, anda bisa mengatur tampilan pesan error dengan menambahkan element dan css nya
		$this->form_validation->set_error_delimiters('<div style="color:red; margin-bottom: 5px">', '</div>');
		$this->form_validation->set_rules('nama', 'nama', 'required');
		$this->form_validation->set_rules('usia', 'usia', 'required');
		$this->form_validation->set_rules('tinggi', 'tinggi', 'required');

		if ($this->form_validation->run() == FALSE) {
			$data['page'] = 'addAnalisis.php';
			$this->load->view('Admin/Menu', $data);
		} else {
			$this->M_analisis->inputdata();
			$id_analisis = $this->db->insert_id();


		$db_analisis = $this->db->where('id_analisis', $id_analisis)->get('analisis')->row();

//tahap 1 fuzzifikasi
		$himpunan = [
			'usia' => [
				'label' => ['muda', 'dewasa', 'tua'],
				'batas' => [25, 30, 50, 55],
			],
			'lemak_tubuh' => [
				'label' => ['kurang', 'normal', 'tinggi'],
				'batas' => [21, 22, 23, 24],
			],
			'kadar_air' => [
				'label' => ['kurang', 'normal', 'tinggi'],
				'batas' => [45, 50, 55, 60],
			],
			'postur_tubuh' => [
				'label' => ['gemuk', 'ideal', 'kurus'],
				'batas' => [3, 4, 6, 7],
			],
			'massa_tulang' => [
				'label' => ['kurang', 'normal', 'tinggi'],
				'batas' => [1.9, 1.95, 2.4, 2.45],
			],
			'lemak_perut' => [
				'label' => ['rendah', 'medium', 'tinggi'],
				'batas' => [4, 5, 9, 10],
			]
		];
		$data_fuzzy = [];//inisialisasi array = 
		foreach ($himpunan as $kriteria => $data_kriteria) {
			$nilai_usia = $db_analisis->$kriteria;
			$batas = $data_kriteria['batas'];
			if ($nilai_usia <= $batas[0]) {
				$fuzzy[0] = 1;
			} else if ($nilai_usia >= $batas[1]) {
				$fuzzy[0] = 0;
			} else {
				$fuzzy[0] = ($batas[1] - $nilai_usia) / ($batas[1] - $batas[0]);
			}

			if ($nilai_usia <= $batas[0] || $nilai_usia >= $batas[3]) {
				$fuzzy[1] = 0;
			} else if ($nilai_usia >= $batas[1] && $nilai_usia <= $batas[2]) {
				$fuzzy[1] = 1;
			} else {
				if ($nilai_usia < $batas[1]) {
					$fuzzy[1] = ($nilai_usia - $batas[0]) / ($batas[1] - $batas[0]);
				}
				if ($nilai_usia > $batas[2]) {
					$fuzzy[1] = ($batas[3] - $nilai_usia) / ($batas[3] - $batas[2]);
				}
			}

			if ($nilai_usia <= $batas[2]) {
				$fuzzy[2] = 0;
			} else if ($nilai_usia >= $batas[3]) {
				$fuzzy[2] = 1;
			} else {
				$fuzzy[2] = ($batas[2] - $nilai_usia) / ($batas[2] - $batas[3]);
			}

			foreach ($data_kriteria['label'] as $key => $label) {//mengambil label untuk dimasukkan ke $fuzzy dalam bentuk array data fuzzy 
				$data_fuzzy[$kriteria][$label] = $fuzzy[$key];
			}
			$data_fuzzy[$kriteria]['nilai'] = $nilai_usia;// nilai yg diinputkan

		}


		/* echo "<pre>";
		var_dump($data_fuzzy); //data hasil fuzzifikasi
		 echo "<pre>";
		var_dump($himpunan);*/ //array himpunan
		//fuzzifikasi

//tahap 2 implikasi rule
		/*$arr_data_rules[] = [
			'condition' => [
				'usia' => 'muda',
				'lemak_tubuh' => 'kurang',
				'massa_tulang' => 'kurang',
				'lemak_perut' => 'rendah',
			],
			'rules' => [
				'shake' => 'sangat_butuh',
				'aloe' => 'sangat_butuh',
				'thermo' => 'tidak_butuh',
				'nrg' => 'sangat_butuh',
				'ppp' => 'sangat_butuh',
				'mixed' => 'tidak_butuh'
			],
		];*/

		$arr_data_rules = [];//inisialisasi array
		$db_rule = $this->db->get('rule')->result();
		foreach ($db_rule as $key => $value) {
			$arr_data_rules[] = [
				'condition' => [
					'usia' => $value->usia,
					'lemak_tubuh' => $value->lemak_tubuh,
					'massa_tulang' => $value->massa_tulang,
					'lemak_perut' => $value->lemak_perut,
				],
				'rules' => [
					'shake' => $value->shake,
					'aloe' => $value->aloe,
					'thermo' => $value->thermo,
					'nrg' => $value->nrg,
					'ppp' => $value->ppp,
					'mixed' => $value->mixed_fiber,
				],
			];
		}

		foreach ($arr_data_rules as $key => $data_rules) {//$data_rue = output
			$get_fuzzy = [];//inisialisasi untuk manggil tahap fuzzifikasi
			foreach ($data_rules['condition'] as $kriteria => $himpunan) {
				$get_fuzzy[] = $data_fuzzy[$kriteria][$himpunan];
			}

			$arr_data_rules[$key]['nilai'] = min($get_fuzzy);
		}

		/*echo "<pre>";
		var_dump($get_fuzzy);*///nilai rulenya

		/*echo "<pre>";
		var_dump($arr_data_rules);*///sebanyak rule

		$komposisi_aturan = [];//inisialisasi array
		foreach ($arr_data_rules as $key => $value) {
			foreach ($value['rules'] as $k => $v) {
				$komposisi_aturan[$k][$v]['data'][] = $value['nilai'];
			}
		}

		/*echo "<pre>";
		var_dump($komposisi_aturan);*///inisialisasi hasil masing" aturan

//tahap 3 fungsi max
		foreach ($komposisi_aturan as $key => $value) {
			foreach ($value as $k => $v) {
				$komposisi_aturan[$key][$k]['max'] = max($v['data']);
				//debug
				// unset($komposisi_aturan[$key][$k]['data']);
			}
		}
		/*echo "<pre>";
		var_dump($komposisi_aturan);*/

		$himpunan_z['sangat_butuh'] = [55, 100];
		$himpunan_z['tidak_butuh'] = [0, 35];
		$himpunan_z['butuh'] = [30, 55];

		foreach ($komposisi_aturan as $key => $value) {
			foreach ($value as $k => $v) {
				$fz = 0;
				if($v['max'] != 0){
					$fz = (($himpunan_z[$k][1]-$himpunan_z[$k][0])*$v['max'])+$himpunan_z[$k][0];
				}
				$komposisi_aturan[$key][$k]['z'] = $fz;
			}
		}

		/*echo "<pre>";
		var_dump($komposisi_aturan);/*///nilai dari masing2 komposisi aturan 
//tahap 4 defuzzifikasi
		$hasil_per_produk = [];//inisialisasi hasil per produk
		foreach ($komposisi_aturan as $key => $value) {
			$top = 0;
			$down = 0;
			foreach ($value as $k => $v) {
				$top += $v['max']*$v['z'];
				$down += $v['max'];
			}

			$komposisi_aturan[$key]['z*'] = $top/$down;
			$hasil_per_produk[$key] = $top/$down;
		}

		$data['id'] = $id_analisis;
		$data['shake'] = $hasil_per_produk['shake'];
		$data['aloe'] = $hasil_per_produk['aloe'];
		$data['thermo'] = $hasil_per_produk['thermo'];
		$data['nrg'] = $hasil_per_produk['nrg'];
		$data['ppp'] = $hasil_per_produk['ppp'];
		$data['mixed'] = $hasil_per_produk['mixed'];
		$data['coba'] = $data_fuzzy;
		$data['page'] = 'HasilAnalisis.php';
		$this->load->view('Admin/Menu', $data);

		/*echo "<pre>";
		var_dump($hasil_per_produk);*/
			// $this->session->set_flashdata('success', 'Tambah Produk berhasil');
			// redirect('Analisis');
		}
	}

	//ubah atau edit dengan foto kamera
	public function ubahAnalisis($id)
	{
		$where = array('id_analisis' => $id);
		$data['analisis'] = $this->M_analisis->getdataID($where, 'analisis')->result();
		$data['page'] = 'editAnalisis.php';
		$this->load->view('Admin/Menu', $data);
	}

	public function ubahhasil_analisis($id)
	{
		$where = array('id_analisis' => $id);
		$data['getData'] = $this->M_analisis->getDataHasilAnalisis($where, 'output')->result();
		$this->load->view('Admin/Menu', $data);
	}


	public function proses_ubah($id)
	{
		$this->M_analisis->updateAnalisis($id);
		$this->session->set_flashdata('success', 'Ubah data berhasil');
		redirect('Analisis', 'refresh');
	}



	function hapus_Analisis($id)
	{
		$where = array('id_analisis' => $id);
		$this->M_analisis->hapus($where, 'analisis');
		redirect('Analisis', 'refresh');
	}
}

function dd($data)
{
	echo "<pre>";
	var_dump($data);
	die();
}