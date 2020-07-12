<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Produk extends CI_Model {

	public function getDataProduk($value='')
	{
		// $query = $this->db->query("Select * from kamera");
		$this->db->select('*');
		$this->db->from('produk');
		$this->db->order_by('id_produk','DESC');
		$query = $this->db->get();
		return $query->result();
	}

	public function upload(){
		$config['upload_path'] = './Upload/'; //definisi folder yg telah dibuat di root project
		$config['allowed_types'] = 'jpg|png|jpeg';
		$config['max_size'] = '10240';
		$config['remove_space'] = TRUE;
		$this->load->library('upload', $config); // Load konfigurasi uploadnya
		if($this->upload->do_upload('image')){ // Lakukan upload dan Cek jika proses upload berhasil
		// Jika berhasil :
			$fileData = $this->upload->data();
			$config['image_library'] = 'gd2';  
			$config['source_image'] = './Upload/'.$fileData["file_name"];  
			$config['create_thumb'] = FALSE;  
			$config['maintain_ratio'] = FALSE;  
			$config['quality'] = '100%';  
			$config['width'] = 1024;  
			$config['height'] = 768;  
			$config['new_image'] = './Upload/'.$fileData["file_name"];  
			$this->load->library('image_lib', $config);  
			$this->image_lib->resize();  
			$return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
			return $return;
		}else{
		// Jika gagal :
			$return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
			return $return;
		}
	}


	public function inputData($upload)
	{
		$data = array(
			'nama_produk'=>$this->input->post('nama_produk'),
			'keterangan'=>$this->input->post('keterangan'),
			'usia'=>$this->input->post('usia'),
			'lemak_tubuh'=>$this->input->post('lemak_tubuh'),
			'massa_tulang'=>$this->input->post('massa_tulang'),
			'lemak_perut'=>$this->input->post('lemak_perut'),
			'image' => $upload['file']['file_name']);
		$this->db->insert('produk', $data);
	}

		//edit
	function getdataID($where,$table){		
		return $this->db->get_where($table,$where);
	}

	function update_data($where,$data,$table){
		$this->db->where($where);
		$this->db->update($table,$data);
	}

	public function updateProduk($id,$upload_name = null){
		$data = array(
			'nama_produk'=>$this->input->post('nama_produk'),
			'keterangan'=>$this->input->post('keterangan'),
			'usia'=>$this->input->post('usia'),
			'lemak_tubuh'=>$this->input->post('lemak_tubuh'),
			'massa_tulang'=>$this->input->post('massa_tulang'),
			'lemak_perut'=>$this->input->post('lemak_perut'),
		);
		$data = $this->input->post();
		if($upload_name!=null){
			$data['image'] = $upload_name;
		}
		//mengeset where id=$id
		$this->db->where('id_produk',$id);
		/*eksekusi update product set $data from product where id=$id
		jika berhasil return berhasil */
		if($this->db->update("produk",$data)){
			return "Berhasil";
		}
	}

	function hapus($where,$table){
		$this->db->where($where);
		$this->db->delete($table);
	}
	

}