<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Master_data extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->model('Master_data_model');
        $this->load->helper(array('form', 'url'));
        
        if (empty($_SESSION['username'])) 
        {
            redirect('Welcome/index');
        } 
    }

    // ----------------------- //
    //  Data usulan pengadaan  //
    // ----------------------- //
    public function data_usulan_pengadaan()
    {   
        $data['kd_usulan'] = $this->Master_data_model->kd_usulan();
        $kd_usulan = $data['kd_usulan'];
        $data['post'] = $this->Master_data_model->get_kd_usulan('tbl_usulan_aset', $kd_usulan);
        $this->load->view('Aset/Master/Usulan_pengadaan', $data);
    }

    public function get_usulan()
    {
        $kd_usulan = $this->input->post('kd_usulan');
        $data = $this->Master_data_model->get_usulan_pengadaan('tbl_usulan_aset', $kd_usulan);
        echo json_encode($data);
    }

    public function del_usulan()
    {
        $id_usulan = $this->input->post('id_usulan');
        $data = $this->Master_data_model->del_usulan_pengadaan('tbl_usulan_aset', $id_usulan);
        echo json_encode($data);
    }

    public function inpt_usulan()
    {
        $kd_usulan  =   $this->input->post('kd_usulan');
        $kd_brg     =   $this->input->post('kd_brg');
        $nm_brg     =   $this->input->post('nm_brg');
        $jns_brg    =   $this->input->post('jns_brg');
        $jmlh_brg   =   $this->input->post('jmlh_brg');
        $satuan_brg =   $this->input->post('satuan_brg');
        $harga_brg  =   $this->input->post('harga_brg');
        $ket        =   $this->input->post('ket');

        date_default_timezone_set('Asia/Jakarta');
        $date   = date("Y/m/d H:i:s");
        $data   = array(
                'kd_usulan' => $kd_usulan,
                'kd_brg' => $kd_brg,
                'nm_brg' => $nm_brg, 
                'jns_brg' => $jns_brg, 
                'jmlh_brg' => $jmlh_brg, 
                'satuan_brg' => $satuan_brg, 
                'harga_brg' => $harga_brg,
                'ket' => $ket,
                'stts_approval' => '1',
                'tgl_approval' => '', 
                'entry_date' => $date
        );

        $berhasil   =   $this->Master_data_model->entry_usulan_pengadaan('tbl_usulan_aset', $data, $nm_brg);

        echo json_encode($berhasil);
    }


    // ----------------------- //
    //      Data pengadaan     //
    // ----------------------- //
    public function data_pengadaan()
    {
        $this->load->view('Aset/Master/pengadaan');
    }

    public function get_pengadaan()
    {
        $data = $this->Master_data_model->get_pengadaan();
        echo json_encode($data);
    }

    public function get_usulan_jns()
    {
        $jns_brg_usul = $this->input->post('jns_brg_usul');
        $data = $this->Master_data_model->get_usulan_jns('tbl_usulan_aset', $jns_brg_usul);
        echo json_encode($data);
    }

    public function int_pengadaan()
    {
        $kd_brg         =   $this->input->post('kd_brg');
        $nm_brg         =   $this->input->post('nm_brg');
        $no_reg         =   $this->input->post('no_reg');
        $jmlh_brg       =   $this->input->post('jmlh_brg');
        $merk_type      =   $this->input->post('merk_type');
        $ukuran_cc      =   $this->input->post('ukuran_cc');
        $bahan          =   $this->input->post('bahan');
        $perolehan      =   $this->input->post('perolehan');
        $kondisi        =   $this->input->post('kondisi');
        $harga          =   $this->input->post('harga');
        $thn_beli       =   $this->input->post('thn_beli');
        $umr_ekonomis   =   $this->input->post('umr_ekonomis');
        $dipinjam       =   $this->input->post('dipinjam');
        $penyusutan     =   $this->input->post('penyusutan');
        $nli_sisa       =   $this->input->post('nli_sisa');
        $ket            =   $this->input->post('ket');

        if (isset($dipinjam) and isset($penyusutan)) {
            $dp = "1";
        } else {
            $dp = "0";
        }

        date_default_timezone_set('Asia/Jakarta');
        $date   = date("Y/m/d H:i:s");
        $data   = array(
                'kd_brg' => $kd_brg,
                'nm_brg' => $nm_brg, 
                'no_reg' => $no_reg, 
                'jmlh_brg' => $jmlh_brg, 
                'merk_type' => $merk_type, 
                'ukuran_cc' => $ukuran_cc,
                'bahan' => $bahan,
                'perolehan' => $perolehan,
                'kondisi' => $kondisi,
                'harga' => $harga,
                'thn_beli' => $thn_beli,
                'umr_ekonomis' => $umr_ekonomis,
                'dipinjam' => $dp,
                'penyusutan' => $dp,
                'nli_sisa' => $nli_sisa,
                'ket' => $ket,
                'entry_date' => $date
        );

        $berhasil   =   $this->Master_data_model->entry_pengadaan('tbl_pengadaan_aset', $data, $nm_brg);
        
        if ($berhasil == 1) {
            $result['pesan'] = $this->session->set_flashdata('statusinsert', 'Disimpan!!!');    
        } else {
            $result['pesan'] = $this->session->set_flashdata('statusgagal', 'Disimpan!!!');
        }
        echo json_encode($berhasil);
    }

    public function del_pengadaan()
    {
        $id_brg = $this->input->post('id_brg');
        $data = $this->Master_data_model->del_pengadaan('tbl_pengadaan_aset', $id_brg);
        echo json_encode($data);
    }


    // ----------------------- //
    //      Data peminjaman    //
    // ----------------------- //
    public function data_peminjaman()
    {
        $data['kd_peminjaman'] = $this->Master_data_model->kd_peminjaman();
        $kd_peminjaman = $data['kd_peminjaman'];
        $data['post'] = $this->Master_data_model->get_kd_peminjaman('tbl_peminjaman_aset', $kd_peminjaman);
        $this->load->view('Aset/Master/peminjaman', $data);
    }

    public function get_dt_pengadaan()
    {
        $data = $this->Master_data_model->get_dt_pengadaan();
        echo json_encode($data);
    }

    public function get_dt_peminjaman()
    {
        $kd_peminjaman = $this->input->post('kd_peminjaman');
        $data = $this->Master_data_model->get_dt_peminjaman($kd_peminjaman);
        echo json_encode($data);
    }

    public function inpt_peminjaman()
    {
        $kd_peminjaman      =   $this->input->post('kd_peminjaman');
        $nm_peminjaman      =   $this->input->post('nm_peminjaman');
        $nohp_peminjaman    =   $this->input->post('nohp_peminjaman');
        $tgl_peminjaman     =   $this->input->post('tgl_peminjaman');
        $tgl_pengembalian   =   $this->input->post('tgl_pengembalian');
        $kd_brg             =   $this->input->post('kd_brg');
        $nm_brg             =   $this->input->post('nm_brg');
        $merk_type          =   $this->input->post('merk_type');
        $ket                =   $this->input->post('ket');

        date_default_timezone_set('Asia/Jakarta');
        $date   = date("Y/m/d H:i:s");

        $data = array(
            'kd_peminjaman' => $kd_peminjaman,
            'nm_peminjaman' => $nm_peminjaman,
            'nohp_peminjaman' => $nohp_peminjaman,
            'tgl_peminjaman' => $tgl_peminjaman,
            'tgl_pengembalian' => $tgl_pengembalian,
            'kd_brg' => $kd_brg,
            'nm_brg' => $nm_brg,
            'merk_type' => $merk_type,
            'ket' => $ket,
            'stts_peminjaman' => "1",
            'entry_date' => $date
        );

        $berhasil = $this->Master_data_model->entry_peminjaman('tbl_peminjaman_aset', $data, $nm_peminjaman);

        echo json_encode($berhasil);
    }

    public function del_peminjaman()
    {
        $id_peminjaman = $this->input->post('id_peminjaman');
        $data = $this->Master_data_model->del_peminjaman('tbl_peminjaman_aset', $id_peminjaman);
        echo json_encode($data);
    }
}


?>