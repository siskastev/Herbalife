<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_paket extends CI_Model {

	public function getDataPaket()
	{
		$this->db->select('*');
		$this->db->from("paket");
		$query = $this->db->get();
		return $query->result_array();

	}

	public function getData()
	{
		//untuk select column
		$this->db->select('*');
		//untuk from table jam
		$this->db->from("paket");
		//$get eksekusi fungsi select
		//hasil eksesusi = "select * from jam"

		
		$query = $this->db->get();
		//untuk merubah table menjadi array
		return $query->result_array();
	}


	public function getDataWhereId($id)
	{
		$this->db->select('*');
		$this->db->from("paket");
		$this->db->where('id_paket',$id);
		return $this->db->get()->result_array();
	}

	public function insertData($upload_name)
	{
		/* jika semua sama sperti di table
		gunakan versi simple seprti berikut */
		$data = $this->input->post();
		$data['image'] = $upload_name;
		/* eksekusi query insert into "jam" diisi dengan variable $data
		face2face ae lek bingung :| */
		$this->db->insert("paket",$data);
	}

	public function updateData($id,$upload_name=null)	
	{
		/* jika semua sama sperti di table
		gunakan versi simple seprti berikut */
		$data = $this->input->post();

		if($upload_name!=null)
			$data['image'] = $upload_name;
		//mengeset where id=$id
		$this->db->where('id_paket',$id);
		/*eksekusi update jam set $data from jam where id=$id
		jika berhasil return berhasil */
		if($this->db->update("paket",$data)){
			return "Berhasil";
		}
	}

	public function hapusData($id)
	{
		//mengeset where id=$id
		$this->db->where('id_paket',$id);
		/* eksekusi delete from jam where id=$id 
		jika berhasil return berhasil*/
		if($this->db->delete("paket")){
			return "Berhasil";
		}
	}

	public function upload(){
        $config['upload_path'] = './Ipload/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = '2048';
        $config['remove_space'] = TRUE;
        $this->load->library('upload', $config);
        if($this->upload->do_upload('image_paket')){
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
