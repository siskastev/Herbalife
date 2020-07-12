<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Data extends CI_Controller {
    
        public function index()
        {
            $this->load->view('data_diri');
        }

         public function data_analisis()
        {
            $this->load->view('data_analisis');
        }
    }