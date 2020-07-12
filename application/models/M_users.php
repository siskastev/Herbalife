<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_users extends CI_Model {


	public function getDataUsers()
	{
		//untuk select column
		$this->db->select('*');
		//untuk from table users
		$this->db->from("users");
		//$get eksekusi fungsi select
		//hasil eksesusi = "select * from users"

		
		$query = $this->db->get();
		//untuk merubah table menjadi array
		return $query->result();
	}


	public function getDataWhereId($id)
	{
		$this->db->select('*');
		$this->db->from("users");
		$this->db->where('id',$id);
		return $this->db->get()->result_array();
	}

	public function insertData($upload_name)
	{
		$data = $this->input->post();
		$data['password'] = md5($data['password']);
		$data['image'] = $upload_name;
		/* eksekusi query insert into "users" diisi dengan variable $data
		face2face ae lek bingung :| */
		$this->curl->simple_post($this->API.'/Users', $data, array(CURLOPT_BUFFERSIZE => 10));
	}

	public function updateData($id,$upload_name=null)	
	{
		/* jika semua sama sperti di table
		gunakan versi simple seprti berikut */
		$data = $this->input->post();
		$data['id'] = $id;
		$data['password'] = md5($data['password']);
		//jika image kosong maka tidak mengubah image
		if($upload_name!=null)
			$data['image'] = $upload_name;
		//mengeset where id=$id
		$this->db->where('id',$id);
		/*eksekusi update users set $data from users where id=$id
		jika berhasil return berhasil */
		
		$this->curl->simple_put($this->API.'/Users', $data, array(CURLOPT_BUFFERSIZE => 10));
	}

	public function hapusData($id)
	{
		//mengeset where id=$id
		$this->db->where('id',$id);
		/* eksekusi delete from users where id=$id 
		jika berhasil return berhasil*/
		if($this->db->delete("users")){
			return "Berhasil";
		}
	}

	public function upload(){
        $config['upload_path'] = './assets/upload/users/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = '2048';
        $config['remove_space'] = TRUE;
        $this->load->library('upload', $config);
        if($this->upload->do_upload('image')){
            $return = array('result' => 'success', 'file' => $this->upload->data(),
            'error' => '');
            return $return;
        }else{
            $return = array('result' => 'failed', 'file' => '', 'error' =>
            $this->upload->display_errors());
            return $return;
        }
    }
}
