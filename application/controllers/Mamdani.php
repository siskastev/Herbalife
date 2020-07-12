<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Analisis extends CI_Controller
{


	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation', 'session'));

		$this->load->model('M_Analisis');
		if (!$this->session->userdata('username')) {
			redirect('Login');
		}
	}

	public function index()
	{
		$data['analisis'] = $this->M_Analisis->getDataAnalisis();
		$data['page'] = 'Analisis.php';
		$this->load->view('Admin/menu', $data);
	}
	public function hitung($id_analisis)
	{
		// $id_analisis = 1;

		$db_analisis = $this->db->where('id_analisis', $id_analisis)->get('analisis')->row();


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
		$data_fuzzy = [];
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

			foreach ($data_kriteria['label'] as $key => $label) {
				$data_fuzzy[$kriteria][$label] = $fuzzy[$key];
			}
			$data_fuzzy[$kriteria]['nilai'] = $nilai_usia;
		}

		$arr_data_rules[] = [
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
		];
		$arr_data_rules = [];
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

		foreach ($arr_data_rules as $key => $data_rules) {
			$get_fuzzy = [];
			foreach ($data_rules['condition'] as $kriteria => $himpunan) {
				$get_fuzzy[] = $data_fuzzy[$kriteria][$himpunan];
			}

			$arr_data_rules[$key]['nilai'] = min($get_fuzzy);
		}

		$komposisi_aturan = [];
		foreach ($arr_data_rules as $key => $value) {
			foreach ($value['rules'] as $k => $v) {
				$komposisi_aturan[$k][$v]['data'][] = $value['nilai'];
			}
		}

		foreach ($komposisi_aturan as $key => $value) {
			foreach ($value as $k => $v) {
				$komposisi_aturan[$key][$k]['max'] = max($v['data']);
				//debug
				// unset($komposisi_aturan[$key][$k]['data']);
			}
		}

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

		$hasil_per_produk = [];
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


		echo "<pre>";
		var_dump($hasil_per_produk);
	}



	public function addAnalisis()
	{
		$data['page'] = 'addAnalisis.php';
		$this->load->view('Admin/menu', $data);
	}

	public function simpanAnalisis()
	{

		$data = array();
		$this->load->helper('url', 'form');
		$this->load->library("form_validation");
		//        jika anda mau, anda bisa mengatur tampilan pesan error dengan menambahkan element dan css nya
		$this->form_validation->set_error_delimiters('<div style="color:red; margin-bottom: 5px">', '</div>');
		$this->form_validation->set_rules('nama', 'nama', 'required');

		if ($this->form_validation->run() == FALSE) {
			$data['page'] = 'addAnalisis.php';
			$this->load->view('Admin/menu', $data);
		} else {
			$this->M_Analisis->inputdata();
			$this->session->set_flashdata('success', 'Tambah Produk berhasil');
			redirect('Analisis/refresh');
		}
	}

	//ubah atau edit dengan foto kamera
	public function ubahAnalisis($id)
	{
		$where = array('id_analisis' => $id);
		$data['analisis'] = $this->M_Analisis->getdataID($where, 'analisis')->result();
		$data['page'] = 'editAnalisis.php';
		$this->load->view('admin/menu', $data);
	}

	public function proses_ubah($id)
	{
		$this->M_Analisis->updateAnalisis($id);
		$this->session->set_flashdata('success', 'Ubah data berhasil');
		redirect('Analisis', 'refresh');
	}



	function hapus_Analisis($id)
	{
		$where = array('id_analisis' => $id);
		$this->M_Analisis->hapus($where, 'analisis');
		redirect('Analisis', 'refresh');
	}
}

function dd($data)
{
	echo "<pre>";
	var_dump($data);
	die();
}