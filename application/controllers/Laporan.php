<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->model('Laporan_model');
        $this->load->helper(array('form', 'url'));
        
        if (empty($_SESSION['username'])) 
        {
            redirect('Welcome/index');
        } 
    }

    // Laporan aset
    public function lp_pemeliharaan()
    {
        $this->load->view('Aset/lp_pemeliharaan');
    }

    public function lp_usul_pengadaan()
    {
        $data['dt_usul'] = $this->Laporan_model->dt_usulan_pengadaan();
        $this->load->view('Aset/lp_usul_pengadaan', $data);
    }

    public function get_usul_pengadaan()
    {
        $data = $this->Laporan_model->get_dt_usulan_pengadaan();
        echo json_encode($data);
    }


    // Laporan Wakasek
    public function lp_pengadaan_wk()
    {
        $data['peng'] = $this->Laporan_model->dt_pengadaan();
        $this->load->view('Wakasek/lp_pengadaan', $data);
    }

    public function get_dt_pengadaan()
    {
        $data = $this->Laporan_model->get_data_pengadaan();
        echo json_encode($data);
    }

    public function lp_peminjaman_wk()
    {
        $data['pin'] = $this->Laporan_model->dt_peminjaman();
        $this->load->view('Wakasek/lp_peminjaman', $data);
    }

    public function get_dt_peminjaman()
    {
        $data = $this->Laporan_model->get_data_peminjaman();
        echo json_encode($data);
    }

    // public function lp_pemeliharaan_wk()
    // {
    //     $this->load->view('Wakasek/lp_pemeliharaan');
    // }

    // public function lp_penghapusan_wk()
    // {
    //     $this->load->view('Wakasek/lp_penghapusan');
    // }

    // LAPORAN kepsek
    public function lp_pengadaan_kep()
    {
        $data['peng'] = $this->Laporan_model->dt_pengadaan();
        $this->load->view('Kepsek/lp_pengadaan', $data);
    }

    public function lp_peminjaman_kep()
    {
        $data['pin'] = $this->Laporan_model->dt_peminjaman();
        $this->load->view('Kepsek/lp_peminjaman', $data);
    }

    // public function lp_pemeliharaan_kep()
    // {
    //     $this->load->view('Kepsek/lp_pemeliharaan');
    // }

    // public function lp_penghapusan_kep()
    // {
    //     $this->load->view('Kepsek/lp_penghapusan');
    // }
}