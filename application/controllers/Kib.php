<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kib extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->model('Kib_model');
        $this->load->helper(array('form', 'url'));
        
        if (empty($_SESSION['username'])) 
        {
            redirect('Welcome/index');
        } 
    }

    // ----------------------- //
    //      Data kib_a        //
    // ----------------------- //
    public function kib_a()
    {
        $this->load->view('Aset/Kib/kib_a');
    }

    public function get_kib_a()
    {
        $data = $this->Kib_model->get_dt_kib_a();
        echo json_encode($data);
    }

    // ----------------------- //
    //      Data kib_b        //
    // ----------------------- //
    public function kib_b()
    {
        $this->load->view('Aset/Kib/kib_b');
    }

    public function get_kib_b()
    {
        $data = $this->Kib_model->get_dt_kib_b();
        echo json_encode($data);
    }

    // ----------------------- //
    //      Data kib_c        //
    // ----------------------- //
    public function kib_c()
    {
        $this->load->view('Aset/Kib/kib_c');
    }

    public function get_kib_c()
    {
        $data = $this->Kib_model->get_dt_kib_c();
        echo json_encode($data);
    }

    // ----------------------- //
    //      Data kib_e        //
    // ----------------------- //
    public function kib_e()
    {
        $this->load->view('Aset/Kib/kib_e');
    }

    public function get_kib_e()
    {
        $data = $this->Kib_model->get_dt_kib_e();
        echo json_encode($data);
    }
}


?>