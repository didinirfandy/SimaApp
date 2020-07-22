<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    function __construct() 
    {
        parent::__construct();
        $this->load->model('Login_model');
    }

    function login()
    {
        if(isset($_POST['submit']))
        {
            $username   =   $this->input->post('username',true);
            $password   =   md5($this->input->post('password',true));
            $hasil      =   $this->Login_model->login($username, $password);

            if($hasil == 1)
            {
                $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"><button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>Login Berhasil</div>');
                redirect(base_url(). "Aset/home");
            }
            elseif($hasil == 2)
            {
                $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"><button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>Login Berhasil</div>');
                redirect(base_url(). "Wakasek/home");
            } 
            elseif($hasil == 3)
            {
                $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"><button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>Login Berhasil</div>');
                redirect(base_url(). "Kepsek/home");
            } 
            else
            {
                $this->session->set_flashdata('notif','<div class="alert alert-danger alert-dismissible fade show" role="alert" style="font-size: 12px;"><button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>Username atau Password Salah</div>');
                redirect(base_url(). "Welcome/index");
            }
        }
        else
        {
            $this->session->set_flashdata('notif','<div class="alert alert-danger alert-dismissible fade show" role="alert" style="font-size: 12px;"><button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>Gagal Login</div>');
            redirect(base_url(). "Welcome/index");
        }
    }

    function logout()
    {
        $username   =   $this->session->userdata('stts_lg');
                        $this->Login_model->logout($username);
                        $this->session->set_userdata('notif', '<div class="alert alert-success alert-dismissible fade show" role="alert" style="font-size: 12px;"><button type="button" class="close sucess-op" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>Loguot Berhasil, Terima Kasih</div>');
        redirect(base_url(). "Welcome/index");
    }
}