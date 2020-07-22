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
}
?>