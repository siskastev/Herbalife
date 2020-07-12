<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Analisis extends CI_Model {

	public function getDataAnalisis($value='')
	{
		// $query = $this->db->query("Select * from kamera");
		$this->db->select('*');
		$this->db->from('analisis');
		$this->db->order_by('id_analisis','DESC');
		$query = $this->db->get();//untuk mendapatkan database
		return $query->result();//mengembalikan hasil object
	}

	public function getDataHasilAnalisis($id)
	{
		$query= $this->db->query("SELECT output.*, analisis.nama as nama, analisis.usia as getusia, analisis.lemak_tubuh as getlemaktubuh, analisis.kadar_air as getkadarair, analisis.postur_tubuh as getposturtubuh, analisis.massa_tulang as getmassatulang, analisis.lemak_perut as getlemakperut FROM output JOIN analisis ON analisis.id_analisis = output.fk_id_analisis where output.fk_id_analisis ='$id'");
		return $query->result();
	}

	public function inputData()
	{
		$data = array(
			'nama'=>$this->input->post('nama'),
			'usia'=>$this->input->post('usia'),
			'tinggi'=>$this->input->post('tinggi'),
			'berat_badan'=>$this->input->post('berat_badan'),
			'lemak_tubuh'=>$this->input->post('lemak_tubuh'),
			'kadar_air'=>$this->input->post('kadar_air'),
			'massa_otot'=>$this->input->post('massa_otot'),
			'postur_tubuh'=>$this->input->post('postur_tubuh'),
			'bmr_kalori'=>$this->input->post('bmr_kalori'),
			'usia_sel'=>$this->input->post('usia_sel'),
			'massa_tulang'=>$this->input->post('massa_tulang'),
			'lemak_perut'=>$this->input->post('lemak_perut'),
			'tanggal'=>$this->input->post('tanggal'));
		$this->db->insert('analisis', $data);
	}

	public function input($data,$table)
	{
		$this->db->insert($table,$data);
	}

		//edit
	function getdataID($where,$table){		
		return $this->db->get_where($table,$where);
	}

	function update_data($where,$data,$table){
		$this->db->where($where);
		$this->db->update($table,$data);
	}

	public function updateAnalisis($id,$upload_name = null){
		$data = array(
			'nama'=>$this->input->post('nama'),
			'usia'=>$this->input->post('usia'),
			'tinggi'=>$this->input->post('tinggi'),
			'berat_badan'=>$this->input->post('berat_badan'),
			'lemak_tubuh'=>$this->input->post('lemak_tubuh'),
			'kadar_air'=>$this->input->post('kadar_air'),
			'massa_otot'=>$this->input->post('massa_otot'),
			'postur_tubuh'=>$this->input->post('postur_tubuh'),
			'bmr_kalori'=>$this->input->post('bmr_kalori'),
			'usia_sel'=>$this->input->post('usia_sel'),
			'massa_tulang'=>$this->input->post('massa_tulang'),
			'lemak_perut'=>$this->input->post('lemak_perut'),
			'tanggal'=>$this->input->post('tanggal'));
		$data = $this->input->post();
		if($upload_name!=null){
			$data['image'] = $upload_name;
		}
		//mengeset where id=$id
		$this->db->where('id_analisis',$id);
		/*eksekusi update product set $data from product where id=$id
		jika berhasil return berhasil */
		if($this->db->update("analisis",$data)){
			return "Berhasil";
		}
	}

	function hapus($where,$table){
		$this->db->where($where);
		$this->db->delete($table);
	}
	

}