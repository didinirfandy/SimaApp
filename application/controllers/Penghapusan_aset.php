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
        $this->load->view('Aset/penghapusan_aset');
    }
}

?>