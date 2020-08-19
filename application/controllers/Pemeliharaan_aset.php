<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Pemeliharaan_aset extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->model('Pemeliharaan_aset_model');
        $this->load->helper(array('form', 'url'));
        
        if (empty($_SESSION['username'])) 
        {
            redirect('Welcome/index');
        } 
    }

    public function pemeliharaan_aset()
    {
        $this->load->view('Aset/pemeliharaan_aset');
    }

    public function pemeliharaan_aset_wk()
    {
        $this->load->view('Wakasek/pemeliharaan_aset');
    }

    public function pemeliharaan_aset_kep()
    {
        $this->load->view('Kepsek/pemeliharaan_aset');
    }

    public function get_data_aset()
    {
        $data = $this->Pemeliharaan_aset_model->get_data_aset();
        echo json_encode($data);
    }

    public function int_pelihara()
    {
        $id_brg = $this->input->post('id_brg');
        $ket = $this->input->post('ket');
        $data = $this->Pemeliharaan_aset_model->int_pemeliharaan($id_brg, $ket);
        echo json_encode($data);
    }

    public function hps_pelihara()
    {
        $id_brg = $this->input->post('id_brg');
        $data = $this->Pemeliharaan_aset_model->hps_pemeliharaan($id_brg);
        echo json_encode($data);
    }

    public function get_data_pelihara()
    {
        $data = $this->Pemeliharaan_aset_model->get_data_pemeliharaan();
        echo json_encode($data);
    }

    public function aksi_pelihara_wk()
    {
        $id_pemeliharaan    = $this->input->post('id_pemeliharaan');
        $id_brg             = $this->input->post('id_brg');
        $stts_approval      = $this->input->post('stts_approval');
        $nilai_buku_bln     = $this->input->post('nilai_buku_bln');
        $sisa_umr_ekonomis  = $this->input->post('sisa_umr_ekonomis');
        $data               = $this->Pemeliharaan_aset_model->aksi_pemeliharaan_wk($id_pemeliharaan, $id_brg, $stts_approval, $nilai_buku_bln, $sisa_umr_ekonomis);
        echo json_encode($data);
    }

    public function aksi_pelihara_kep()
    {
        $id_pemeliharaan    = $this->input->post('id_pemeliharaan');
        $stts_approval_kep  = $this->input->post('stts_approval_kep');
        $data = $this->Pemeliharaan_aset_model->aksi_pemeliharaan_kep($id_pemeliharaan, $stts_approval_kep);
        echo json_encode($data);
    }

    public function aksi_pelihara_batal_wk()
    {
        $id_pemeliharaan = $this->input->post('id_pemeliharaan');
        $id_brg = $this->input->post('id_brg');
        $data = $this->Pemeliharaan_aset_model->aksi_pemeliharaan_batal_wk($id_pemeliharaan, $id_brg);
        echo json_encode($data);
    }

    public function get_pelihara_aset_internal()
    {
        $data = $this->Pemeliharaan_aset_model->get_pemeliharaan_aset_internal();
        echo json_encode($data);
    }

    public function pelihara_selesai_in()
    {
        $id_pemeliharaan = $this->input->post('id_pemeliharaan');
        $id_brg = $this->input->post('id_brg');
        $data = $this->Pemeliharaan_aset_model->pemeliharaan_selesai_in($id_pemeliharaan, $id_brg);
        echo json_encode($data);
    }

    public function get_pelihara_aset_external()
    {
        $data = $this->Pemeliharaan_aset_model->get_pemeliharaan_aset_external();
        echo json_encode($data);
    }

    public function get_pelihara_aset_external_kep()
    {
        $data = $this->Pemeliharaan_aset_model->get_pemeliharaan_aset_external_kep();
        echo json_encode($data);
    }

    public function pelihara_selesai_ex()
    {
        $id_pemeliharaan = $this->input->post('id_pemeliharaan');
        $id_brg = $this->input->post('id_brg');
        $data = $this->Pemeliharaan_aset_model->pemeliharaan_selesai_ex($id_pemeliharaan, $id_brg);
        echo json_encode($data);
    }

    public function get_pelihara_aset()
    {
        $data = $this->Pemeliharaan_aset_model->get_pemeliharaan_aset();
        echo json_encode($data);
    }
}
?>