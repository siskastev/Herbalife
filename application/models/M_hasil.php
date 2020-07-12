<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Hasil extends CI_Model {

	public function getDataHasil($value='')
	{
		// $query = $this->db->query("Select * from kamera");
		$this->db->select('*');
		$this->db->from('output');
		$this->db->order_by('id_output','DESC');
		$query = $this->db->get();
		return $query->result();
	}

		//edit
	function getdataID($where,$table){		
		return $this->db->get_where($table,$where);
	}

}