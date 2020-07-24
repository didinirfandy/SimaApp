<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Daftar_aset extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->model('Daftar_aset_model');
        $this->load->helper(array('form', 'url'));
        
        if (empty($_SESSION['username'])) 
        {
            redirect('Welcome/index');
        } 
    }

    public function daftar_aset()
    {
        $this->load->view('Aset/daftar_aset');
    }

    public function get_kib_a()
    {
        $data = $this->Daftar_aset_model->get_dt_kib_a();
        echo json_encode($data);
    }
}
