<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lp_kib extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->model('Kib_model');
        $this->load->helper(array('form', 'url'));

        if (empty($_SESSION['username'])) {
            redirect('Welcome/index');
        }
    }

    // ----------------------- //
    //      Data kib_a        //
    // ----------------------- //
    public function lp_kib_a()
    {
        $data['dt_a'] = $this->Kib_model->get_dt_a();
        $this->load->view('Aset/LaporanKIB/kib_a', $data);
    }

    public function lp_get_kib_a()
    {
        $data = $this->Kib_model->get_dt_kib_a();
        echo json_encode($data);
    }

    // ----------------------- //
    //      Data kib_b        //
    // ----------------------- //
    public function lp_kib_b()
    {
        $data['dt_b'] = $this->Kib_model->get_dt_b();
        $this->load->view('Aset/LaporanKIB/kib_b', $data);
    }

    public function lp_get_kib_b()
    {
        $data = $this->Kib_model->get_dt_kib_b();
        echo json_encode($data);
    }


    // ----------------------- //
    //      Data kib_c        //
    // ----------------------- //
    public function lp_kib_c()
    {
        $data['dt_c'] = $this->Kib_model->get_dt_c();
        $this->load->view('Aset/LaporanKIB/kib_c', $data);
    }

    public function lp_get_kib_c()
    {
        $data = $this->Kib_model->get_dt_kib_c();
        echo json_encode($data);
    }

    // ----------------------- //
    //      Data kib_e        //
    // ----------------------- //
    public function lp_kib_e()
    {
        $data['dt_e'] = $this->Kib_model->get_dt_e();
        $this->load->view('Aset/LaporanKIB/kib_e', $data);
    }

    public function lp_get_kib_e()
    {
        $data = $this->Kib_model->get_dt_kib_e();
        echo json_encode($data);
    }
}
