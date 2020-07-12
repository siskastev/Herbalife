<?php 
 
class M_login extends CI_Model{ 
	
  function cek_login($table,$where){    
    return $this->db->get_where($table,$where);
  } 

  function input_biodata($data,$table){
		$this->db->insert($table,$data);
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
		'firstname'=>$this->input->post('firstname'),
		'lastname'=>$this->input->post('lastname'),
		'address'=>$this->input->post('address'),
		'usia'=>$this->input->post('usia'),
		'telp'=>$this->input->post('telp'),
		'username'=>$this->input->post('username'),
		'password'=>md5($this->input->post('password')),
		'image' => $upload['file']['file_name']);
		$this->db->insert('users', $data);
	}

}

   
