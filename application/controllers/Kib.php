<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kib extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->model('Kib_model');
        $this->load->helper(array('form', 'url'));
        
        if (empty($_SESSION['username'])) 
        {
            redirect('Welcome/index');
        } 
    }

    // ----------------------- //
    //      Data kib_a        //
    // ----------------------- //
    public function kib_a()
    {
        $this->load->view('Aset/Kib/kib_a');
    }

    public function get_kib_a()
    {
        $data = $this->Kib_model->get_dt_kib_a();
        echo json_encode($data);
    }

    // ----------------------- //
    //      Data kib_b        //
    // ----------------------- //
    public function kib_b()
    {
        $data['kib_b'] = $this->Kib_model->get_dt_kib_b();
        $this->load->view('Aset/Kib/kib_b', $data);
    }

    public function uptd_kib_b()
    {
        $id = $this->input->post("id");
		$value = $this->input->post("value");
		$modul = $this->input->post("modul");
		$this->Kib_model->uptd_kib_b($id,$value,$modul);
		echo "{}";
    }


    // ----------------------- //
    //      Data kib_c        //
    // ----------------------- //
    public function kib_c()
    {
        $data['kib_c'] = $this->Kib_model->get_dt_kib_c();
        $this->load->view('Aset/Kib/kib_c', $data);
    }

    public function uptd_kib_c()
    {
        $id = $this->input->post("id");
		$value = $this->input->post("value");
		$modul = $this->input->post("modul");
		$this->Kib_model->update_kib_c($id,$value,$modul);
		echo "{}";
    }

    // ----------------------- //
    //      Data kib_e        //
    // ----------------------- //
    public function kib_e()
    {
        $this->load->view('Aset/Kib/kib_e');
    }

    public function get_kib_e()
    {
        $data = $this->Kib_model->get_dt_kib_e();
        echo json_encode($data);
    }



    // ----------------------- //
    //      Data kib_a        //
    // ----------------------- //
    public function kib_a_wk()
    {
        $this->load->view('Wakasek/Kib/kib_a');
    }

    public function get_kib_a_wk()
    {
        $data = $this->Kib_model->get_dt_kib_a();
        echo json_encode($data);
    }

    // ----------------------- //
    //      Data kib_b        //
    // ----------------------- //
    public function kib_b_wk()
    {
        $data['kib_b'] = $this->Kib_model->get_dt_kib_b();
        $this->load->view('Wakasek/Kib/kib_b', $data);
    }

    public function uptd_kib_b_wk()
    {
        $id = $this->input->post("id");
		$value = $this->input->post("value");
		$modul = $this->input->post("modul");
		$this->Kib_model->update_kib_b($id,$value,$modul);
		echo "{}";
    }


    // ----------------------- //
    //      Data kib_c        //
    // ----------------------- //
    public function kib_c_wk()
    {
        $data['kib_c'] = $this->Kib_model->get_dt_kib_c();
        $this->load->view('Wakasek/Kib/kib_c', $data);
    }

    public function uptd_kib_c_wk()
    {
        $id = $this->input->post("id");
		$value = $this->input->post("value");
		$modul = $this->input->post("modul");
		$this->Kib_model->update_kib_c($id,$value,$modul);
		echo "{}";
    }

    // ----------------------- //
    //      Data kib_e        //
    // ----------------------- //
    public function kib_e_wk()
    {
        $this->load->view('Wakasek/Kib/kib_e');
    }

    public function get_kib_e_wk()
    {
        $data = $this->Kib_model->get_dt_kib_e();
        echo json_encode($data);
    }



    // ----------------------- //
    //      Data kib_a        //
    // ----------------------- //
    public function kib_a_kep()
    {
        $this->load->view('Kepsek/Kib/kib_a');
    }

    public function get_kib_a_kep()
    {
        $data = $this->Kib_model->get_dt_kib_a();
        echo json_encode($data);
    }

    // ----------------------- //
    //      Data kib_b        //
    // ----------------------- //
    public function kib_b_kep()
    {
        $data['kib_b'] = $this->Kib_model->get_dt_kib_b();
        $this->load->view('Kepsek/Kib/kib_b', $data);
    }

    public function uptd_kib_b_kep()
    {
        $id = $this->input->post("id");
		$value = $this->input->post("value");
		$modul = $this->input->post("modul");
		$this->Kib_model->update_kib_b($id,$value,$modul);
		echo "{}";
    }


    // ----------------------- //
    //      Data kib_c        //
    // ----------------------- //
    public function kib_c_kep()
    {
        $data['kib_c'] = $this->Kib_model->get_dt_kib_c();
        $this->load->view('Kepsek/Kib/kib_c', $data);
    }

    public function uptd_kib_c_kep()
    {
        $id = $this->input->post("id");
		$value = $this->input->post("value");
		$modul = $this->input->post("modul");
		$this->Kib_model->update_kib_c($id,$value,$modul);
		echo "{}";
    }

    // ----------------------- //
    //      Data kib_e        //
    // ----------------------- //
    public function kib_e_kep()
    {
        $this->load->view('Kepsek/Kib/kib_e');
    }

    public function get_kib_e_kep()
    {
        $data = $this->Kib_model->get_dt_kib_e();
        echo json_encode($data);
    }
}


?>