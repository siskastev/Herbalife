<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Rule extends CI_Model {

	public function getDataRule($value='')
	{
		// $query = $this->db->query("Select * from kamera");
		$this->db->select('*');
		$this->db->from('rule');
		$this->db->order_by('id_rule','DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function inputData()
	{
		$data = array(
			'usia'=>$this->input->post('usia'),
			'lemak_tubuh'=>$this->input->post('lemak_tubuh'),
			'massa_tulang'=>$this->input->post('massa_tulang'),
			'lemak_perut'=>$this->input->post('lemak_perut'),
			'shake'=>$this->input->post('shake'),
			'aloe'=>$this->input->post('aloe'),
			'thermo'=>$this->input->post('thermo'),
			'nrg'=>$this->input->post('nrg'),
			'ppp'=>$this->input->post('ppp'),
			'mixed_fiber'=>$this->input->post('mixed_fiber'));
		$this->db->insert('rule', $data);
	}

		//edit
	function getdataID($where,$table){		
		return $this->db->get_where($table,$where);
	}

	function update_data($where,$data,$table){
		$this->db->where($where);
		$this->db->update($table,$data);
	}

	public function updateRule($id,$upload_name = null){
		$data = array(
			'usia'=>$this->input->post('usia'),
			'lemak_tubuh'=>$this->input->post('lemak_tubuh'),
			'massa_otot'=>$this->input->post('massa_otot'),
			'massa_tulang'=>$this->input->post('massa_tulang'),
			'lemak_perut'=>$this->input->post('lemak_perut'),
			'shake'=>$this->input->post('shake'),
			'aloe'=>$this->input->post('aloe'),
			'thermo'=>$this->input->post('thermo'),
			'nrg'=>$this->input->post('nrg'),
			'ppp'=>$this->input->post('ppp'),
			'mixed_fiber'=>$this->input->post('mixed_fiber'));
		$data = $this->input->post();
		if($upload_name!=null){
			$data['image'] = $upload_name;
		}
		//mengeset where id=$id
		$this->db->where('id_rule',$id);
		/*eksekusi update product set $data from product where id=$id
		jika berhasil return berhasil */
		if($this->db->update("rule",$data)){
			return "Berhasil";
		}
	}

	function hapus($where,$table){
		$this->db->where($where);
		$this->db->delete($table);
	}
	

}