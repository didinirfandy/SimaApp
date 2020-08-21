<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Penghapusan_aset extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->model('Penghapusan_aset_model');
        $this->load->helper(array('form', 'url'));
        
        if (empty($_SESSION['username'])) 
        {
            redirect('Welcome/index');
        } 
    }

    public function penghapusan_aset()
    {
        $data['matriks_nilai_while'] = $this->Penghapusan_aset_model->get_matriks_nilai_while();
        $data['matriks_nilai']       = $this->Penghapusan_aset_model->get_matriks_nilai();
        $data['bbt']                 = $this->Penghapusan_aset_model->get_bobot();
        $data['minmax']              = $this->Penghapusan_aset_model->get_mtrk_minmax();
        // $data['rengking']            = $this->Penghapusan_aset_model->get_rengking();
        $data['kd_rangking']         = $this->Penghapusan_aset_model->kd_rengking();
        $this->load->view('Aset/penghapusan_aset', $data);
    }

    public function get_rengking()
    {
        $data = $this->Penghapusan_aset_model->get_rengking();
        echo json_encode($data);
    }

    public function get_data_m_kd()
    {
        $kd_rengking = $this->input->post('kd_rengking');
        $data = $this->Penghapusan_aset_model->get_rengking_kd($kd_rengking);
        echo json_encode($data);
    }

    public function in_data_m()
    {
        $id_matriks = $this->input->post('id_matriks');
        $data = $this->Penghapusan_aset_model->input_data_matriks($id_matriks);
        echo json_encode($data);
    }

    public function del_data_m()
    {
        $id_matriks = $this->input->post('id_matriks');
        $data = $this->Penghapusan_aset_model->delete_data_matriks($id_matriks);
        echo json_encode($data);
    }

    public function penghapusan_aset_wk()
    {
        $data['rengking']      = $this->Penghapusan_aset_model->get_rengking();
        $this->load->view('Wakasek/penghapusan_aset', $data);
    }

    public function penghapusan_aset_kep()
    {
        $data['rengking']      = $this->Penghapusan_aset_model->get_rengking();
        $this->load->view('Kepsek/penghapusan_aset', $data);
    }

    public function insert_rengking()
    {
        if (isset($_POST['submit'])) 
        {
            $kd_rangking = $this->input->post('kd_rengking');
            $rangking    = $this->input->post('rangking');
            $id_brg      = $this->input->post('id_brg');
            $kd_brg      = $this->input->post('kd_brg');
            $no_reg      = $this->input->post('no_reg');
            $nm_brg      = $this->input->post('nm_brg');
            $nilai_akhir = $this->input->post('nilai_akhir');
            $ket         = $this->input->post('ket');
            
            $data = array();
            $totdata = $id_brg;
            
            for ($i=0; $i < count($totdata); $i++) {
                date_default_timezone_set('Asia/Jakarta');
                $date   =   date('Y-m-d H:i:s');
                array_push($data, array(
                    'kd_rengking' => $kd_rangking[$i],
                    'rangking' => $rangking[$i],
                    'id_brg' => $id_brg[$i],
                    'kd_brg' => $kd_brg[$i],
                    'no_reg' => $no_reg[$i],
                    'nm_brg' => $nm_brg[$i],
                    'nilai_akhir' => $nilai_akhir[$i],
                    'ket' => $ket[0],
                    'entry_date' => $date
                ));
            }
    
            $hasil1 = $this->Penghapusan_aset_model->entry_rengking('tbl_rengking', $data);
            $hasil2 = $this->Penghapusan_aset_model->hapus_data_matriks_sementara();
            $hasil3 = $this->Penghapusan_aset_model->update_stts_matriks($id_brg);
    
            if ($hasil1 && $hasil2 && $hasil3) {
                $this->session->set_flashdata('statusinsert', 'Berhasil!!!');
                redirect('Penghapusan_aset/penghapusan_aset');
            } else {
                $this->session->set_flashdata('statusgagal', 'Gagal!!!');
                redirect('Penghapusan_aset/penghapusan_aset');
            }
        }
    }
}
