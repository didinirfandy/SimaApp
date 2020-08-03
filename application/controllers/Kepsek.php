<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kepsek extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model');

        if (empty($_SESSION['username'])) 
        {
            redirect('Welcome/index');
        } 
    }

    public function home()
    {
        $data['jmlh']               = $this->Login_model->total_aset();
        $data['jns_brg']            = $this->Login_model->get_jns_brg();
        $data['stts_dipinjam']      = $this->Login_model->get_peminjaman_aset();
        $data['stts_dikembalikan']  = $this->Login_model->get_pengembalian_aset();
        $this->load->view('Kepsek/home', $data);
    }

    public function get_status()
    {
        $data = $this->Login_model->get_stts();
        echo json_encode($data);
    }

    public function get_data_aset()
    {
        $data = $this->Login_model->get_dt_aset();
        echo json_encode($data);
    }
}
