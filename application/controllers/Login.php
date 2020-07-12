<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Login extends CI_Controller{
 
    function __construct(){
        parent::__construct();      
        $this->load->model('M_login');
        $this->load->helper('form');
        $this->load->helper('url');
 
    }
 
    function index(){
        $this->load->view('v_login');
    }
   /* function aksi_login()
    {
        $username=$this->input->post('email');
        $password=$this->input->post('password');
        $cek=$this->M_login->cek_login($username,$password);
        $tes=count($cek);
        if ($tes > 0 ) 
        {
            $data_login=$this->M_login->cek_login($username,$password);
            $firstname=$data_login->firstname;
            $lastname=$data_login->lastname;
            $address=$data_login->address;
            $telp=$data_login->telp;
            $username=$data_login->email;
            $password=$data_login->password;
        }
        else
        {
            echo "<script>alert('Email atau Password yang Anda Masukan Salah !!!');history.go(-1);</script>";
            // redirect(base_url('signin'));
        }*/
    
 
    function aksi_login(){ 
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $where = array(
            'username' => $username,
            'password' => md5($password)
            );
        $cek = $this->M_login->cek_login("admin",$where)->num_rows();
       
        if($cek == true){
 
            $data_session = array(
                'username' => $username,
                'status' => "login"
            );
 
        $this->session->set_userdata($data_session);
 
        redirect("Users");
    }         
    else{
        echo "Username dan password salah !";
        redirect ('Login');
    }
           
 }
 
    function logout(){
        $this->session->sess_destroy();
        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('username');
        // Set message
        $this->session->set_flashdata('user_loggedout', 'Anda sudah log out');

        redirect(base_url('login'));

    }

    function register()
    {
         $this->load->view('v_register');
    }

    function aksiRegister(){

        if($this->form_validation->run() === FALSE){
            $this->load->view('register');
        } else {
            $config['upload_path'] = './assets/upload/users/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']  = '10000';
            $config['max_width']  = '10240';
            $config['max_height']  = '7680';
            
            $this->load->library('upload', $config);
            
            if ( ! $this->upload->do_upload("image")){
                $data['error'] = $this->upload->display_errors();
                $this->load->view('register',$data);
            }
            else{
                $set_users = array(
                    'firstname' => $this->input->post('firstname'),
                    'lastname' => $this->input->post('lastname'),
                    'address' => $this->input->post('address'),
                    'usia' => $this->input->post('usia'),
                    'telp' => $this->input->post('telp'),
                    'image' => $this->upload->data('file_name'),
                    'username' => $this->input->post('username'),
                    'password' => md5($this->input->post('password')),
                    'fk_id_level' => 2
                );
                $this->db->insert('users',$set_users);
                $id_user = $this->db->insert_id();
                $user_data = array(
                    'id' => $id_user,
                    'username' => $this->input->post('username'),
                    'level' => 2,
                    'logged_in' => true,
                );
                $this->session->set_userdata($user_data);
                redirect('Home','refresh'); 
            }
        }
    }
     function simpanbiodata()
    {
        $firstname = $this->input->post('firstname');
        $lastname = $this->input->post('lastname');
        $address = $this->input->post('address');
        $usia = $this->input->post('usia');
        $telp = $this->input->post('telp');
        $username = $this->input->post('username');
        $password = md5($this->input->post('password'));

                    $upload = $this->M_login->upload();
            if($upload['result'] == "success"){ // Jika proses upload sukses
                $this->M_login->inputdata($upload);
                $this->session->set_flashdata('success','Tambah Cake berhasil');
                redirect('Login');
            }else{ // Jika proses upload gagal
                $data['message'] = $upload['error'];
                $this->session->set_flashdata('error',$data['message']);
                redirect('Login');
            }

        // $data = array(
        //     'firstname' => $firstname,
        //     'lastname' => $lastname,
        //     'address' => $address,
        //     'telp' => $telp,
        //     'username' => $username,
        //     'password' => $password,
        // );
        // $this->M_login->input_biodata($data,'users');
        // redirect('Login');
    }
    
}   