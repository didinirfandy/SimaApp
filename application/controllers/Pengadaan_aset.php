<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Pengadaan_aset extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->model('Pengadaan_aset_model');
        $this->load->helper(array('form', 'url'));
        
        if (empty($_SESSION['username'])) 
        {
            redirect('Welcome/index');
        } 
    }

    public function pengadaan_aset()
    {
        $this->load->view('Aset/pengadaan_aset');
    }

    public function pengadaan_aset_wk()
    {
        $this->load->view('Wakasek/pengadaan_aset');
    }

    public function pengadaan_aset_kep()
    {
        $this->load->view('Kepsek/pengadaan_aset');
    }

    public function get_usulan_group()
    {
        $data = $this->Pengadaan_aset_model->get_usulan_group();
        echo json_encode($data);
    }

    public function get_dtl_brg()
    {
        $kd_usulan = $this->input->post('kd_usulan');
        $data = $this->Pengadaan_aset_model->get_dtl_brg($kd_usulan);
        echo json_encode($data);
    }

    public function get_pengadaan()
    {
        $data = $this->Pengadaan_aset_model->get_pengadaan();
        echo json_encode($data);
    }

    public function aksi_usulan_wk()
    {
        $kd_usulan = $this->input->post('kd_usulan');
        $stts_approval = $this->input->post('stts_approval');
        $data = $this->Pengadaan_aset_model->aksi_usulan_pengadaan_wk($kd_usulan, $stts_approval);
        echo json_encode($data);
    }

    public function aksi_usulan_kep()
    {
        $kd_usulan = $this->input->post('kd_usulan');
        $stts_approval = $this->input->post('stts_approval');
        $data = $this->Pengadaan_aset_model->aksi_usulan_pengadaan_kep($kd_usulan, $stts_approval);
        echo json_encode($data);
    }
}

?>