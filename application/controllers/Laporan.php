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

    // Laporan Wakasek
    public function lp_pengadaan_wk()
    {
        $this->load->view('Wakasek/lp_pengadaan');
    }

    public function lp_peminjaman_wk()
    {
        $this->load->view('Wakasek/lp_peminjaman');
    }

    public function lp_pemeliharaan_wk()
    {
        $this->load->view('Wakasek/lp_pemeliharaan');
    }

    public function lp_penghapusan_wk()
    {
        $this->load->view('Wakasek/lp_penghapusan');
    }

    // LAPORAN kepsek
    public function lp_pengadaan_kep()
    {
        $this->load->view('Kepsek/lp_pengadaan');
    }

    public function lp_peminjaman_kep()
    {
        $this->load->view('Kepsek/lp_peminjaman');
    }

    public function lp_pemeliharaan_kep()
    {
        $this->load->view('Kepsek/lp_pemeliharaan');
    }

    public function lp_penghapusan_kep()
    {
        $this->load->view('Kepsek/lp_penghapusan');
    }
}