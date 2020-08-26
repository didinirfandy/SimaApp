<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kepsek extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model');

        if (empty($_SESSION['username'])) {
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

    public function setting()
    {
        $user_id = $this->session->userdata('user_id');
        $data['pro'] = $this->Login_model->get_prfil($user_id);
        $this->load->view('Kepsek/setting', $data);
    }

    public function edt_dt_user()
    {
        $user_id        =    $this->input->post('user_id');
        $nama_pegawai   =   $this->input->post('nama_pegawai');
        $nik            =    $this->input->post('nik');
        $ktp            =    $this->input->post('ktp');
        $username       =   $this->input->post('username');

        $config['upload_path']    = "./assets_app/img/profil";
        $config['allowed_types']  = 'png|jpg|jpeg';
        $config['overwrite']      = true;
        $config['max_size']       = 16048;
        $config['file_name']      = $username;

        $this->load->library('upload', $config);

        if (isset($_FILES['image'])) {
            if (!$this->upload->do_upload('image')) {
                $berhasil = $this->Login_model->update_no_image($user_id, $nama_pegawai, $nik, $ktp, $username);

                if ($berhasil == 1) {
                    $this->session->set_flashdata('statusok', 'Diganti!!!');
                } else {
                    $this->session->set_flashdata('gagal', '<div class="alert alert-warning" role="alert">
                        <button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
                        <span class="icon-sc-cl" aria-hidden="true">x</span>
                    </button>Photo Gagal Diganti!!!</div>');
                }
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('msg', '<div class="alert alert-warning" role="alert">
				<button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
				<span class="icon-sc-cl" aria-hidden="true">x</span>
            </button>' . $error . '</div>');
            } else {
                $image = $config['file_name'] . $this->upload->data('file_ext');
                $berhasil = $this->Login_model->update_image($user_id, $nama_pegawai, $nik, $ktp, $username, $image);

                if ($berhasil == 1) {
                    $this->session->set_flashdata('statusok', 'Diganti!!!');
                } else {
                    $this->session->set_flashdata('gagal', '<div class="alert alert-warning" role="alert">
                        <button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
                        <span class="icon-sc-cl" aria-hidden="true">x</span>
                    </button>Photo Gagal Diganti!!!</div>');
                }
            }
            $this->output->delete_cache();
        }

        if ($_POST['pass'] != "" || $_POST['new_password'] != "" || $_POST['confirm_password'] != "") {
            $pass             = md5($this->input->post('password'));
            $new_password     = $this->input->post('new_password');
            $confirm_password = $this->input->post('confirm_password');
            $cek_old_password = $this->Login_model->cek_old_password($user_id, $pass);

            if ($cek_old_password == 1) {
                if ($new_password == $confirm_password) {
                    $berhasil = $this->Login_model->ganti_password($user_id, md5($new_password));
                    $this->session->set_flashdata('statusinsert', 'Password Diganti!!!');
                } else {
                    $this->session->set_flashdata('statusgagal', 'Password Baru Tidak Cocok!!!');
                }
            } else {
                $this->session->set_flashdata('statuslama', 'Password Lama Salah!!!');
            }
        }
        redirect('Kepsek/setting');
    }
}
