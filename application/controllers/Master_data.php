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

        if (empty($_SESSION['username'])) {
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

    public function get_kd_aset()
    {
        $data = $this->Master_data_model->get_kode_aset('tbl_kd_barang');
        echo json_encode($data);
    }

    public function inpt_usulan()
    {
        $kd_usulan     =   $this->input->post('kd_usulan');
        $kd_brg        =   $this->input->post('kd_brg');
        $nm_brg        =   $this->input->post('nm_brg');
        $jns_brg       =   $this->input->post('jns_brg');
        $jmlh_brg      =   $this->input->post('jmlh_brg');
        $satuan_brg    =   $this->input->post('satuan_brg');
        $masa_manfaat  =   $this->input->post('masa_manfaat');
        $harga_brg     =   $this->input->post('harga_brg');
        $ket           =   $this->input->post('ket');

        date_default_timezone_set('Asia/Jakarta');
        $date   = date("Y/m/d H:i:s");
        $data   = array(
            'kd_usulan'         => $kd_usulan,
            'kd_brg'            => $kd_brg,
            'nm_brg'            => $nm_brg,
            'jns_brg'           => $jns_brg,
            'jmlh_brg'          => $jmlh_brg,
            'satuan_brg'        => $satuan_brg,
            'masa_manfaat'      => $masa_manfaat,
            'harga_brg'         => $harga_brg,
            'ket'               => $ket,
            'stts_approval_wk'  => '1',
            'tgl_approval_wk'   => '',
            'stts_approval_kep' => '1',
            'tgl_approval_kep'  => '',
            'entry_date'        => $date
        );

        $berhasil   =   $this->Master_data_model->entry_usulan_pengadaan('tbl_usulan_aset', $data, $nm_brg);

        echo json_encode($berhasil);
    }


    // ----------------------- //
    //      Data pengadaan     //
    // ----------------------- //
    public function data_pengadaan()
    {
        $data['pgdn'] = $this->Master_data_model->get_pengadaan();
        $this->load->view('Aset/Master/pengadaan', $data);
    }

    public function updt_pengadaan()
    {
        $id = $this->input->post("id");
        $value = $this->input->post("value");
        $modul = $this->input->post("modul");
        $this->Master_data_model->update_pengadaan($id, $value, $modul);
        echo "{}";
    }

    public function dlt_pengadaan()
    {
        $id = $this->input->post("id");
        $this->Master_data_model->delete_pengadaan($id);
        echo "{}";
    }

    public function get_usulan_jns()
    {
        $jns_brg_usul = $this->input->post('jns_brg_usul');
        $data = $this->Master_data_model->get_usulan_jns('tbl_usulan_aset', $jns_brg_usul);
        echo json_encode($data);
    }

    public function int_pengadaan()
    {
        $id_usulan      =   $this->input->post('id_usulan');
        $kd_brg         =   $this->input->post('kd_brg');
        $nm_brg         =   $this->input->post('nm_brg');
        $jmlh_brg       =   $this->input->post('jmlh_brg');
        $satuan_brg     =   $this->input->post('satuan_brg');
        $merk_type      =   $this->input->post('merk_type');
        $ukuran_cc      =   $this->input->post('ukuran_cc');
        $bahan          =   $this->input->post('bahan');
        $perolehan      =   $this->input->post('perolehan');
        $harga          =   $this->input->post('harga');
        $thn_beli       =   $this->input->post('thn_beli');
        $umr_ekonomis   =   $this->input->post('umr_ekonomis');
        $dipinjam       =   $this->input->post('dipinjam');
        $penyusutan     =   $this->input->post('penyusutan');
        $nli_sisa       =   $this->input->post('nli_sisa');
        $jns_brg        =   $this->input->post('jns_brg');
        $ket            =   $this->input->post('ket');

        if (isset($dipinjam) and isset($penyusutan)) {
            $dp = "1";
        } else {
            $dp = "0";
        }

        $no = $this->Master_data_model->get_no_req($kd_brg);
        if ($no == "") {
            $no_reg = "0001";
        } else {
            $no_reg = $no;
        }

        $data = array();

        for ($j = 0; $j < $jmlh_brg; $j++) {
            $no = str_pad($no_reg, 4, "0", STR_PAD_LEFT);
            // print_r($kode);
            date_default_timezone_set('Asia/Jakarta');
            $date   = date('Y/m/d H:i:s');
            array_push($data, array(
                'kd_brg' => $kd_brg,
                'nm_brg' => $nm_brg,
                'no_reg' => $no,
                'jmlh_brg' => $jmlh_brg,
                'satuan_brg' => $satuan_brg,
                'merk_type' => $merk_type,
                'ukuran_cc' => $ukuran_cc,
                'bahan' => $bahan,
                'perolehan' => $perolehan,
                'harga' => $harga,
                'thn_beli' => $thn_beli,
                'umr_ekonomis' => $umr_ekonomis,
                'dipinjam' => $dp,
                'penyusutan' => $dp,
                'nli_sisa' => $nli_sisa,
                'jns_brg' => $jns_brg,
                'ket' => $ket,
                'entry_date' => $date

            ));
            $no_reg++;
        }

        $berhasil   =   $this->Master_data_model->entry_pengadaan('tbl_pengadaan_aset', $data, $nm_brg, $id_usulan);

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
        $data['kd_peminjaman']  = $this->Master_data_model->kd_peminjaman();
        $kd_peminjaman          = $data['kd_peminjaman'];
        $data['post']           = $this->Master_data_model->get_kd_peminjaman('tbl_peminjaman_aset', $kd_peminjaman);
        $data['get_pinjam']     = $this->Master_data_model->get_dt_pinjam();
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

    public function pengembalian()
    {
        if (isset($_POST['submit'])) {

            $id_peminjaman          = $this->input->post('id_peminjaman');
            $id_brg                 = $this->input->post('id_brg');
            $realisasi_pengembalian = $this->input->post('realisasi_pengembalian');
            $kondisi                = $this->input->post('kondisi');

            $berhasil = $this->Master_data_model->update_pengembalian($id_peminjaman, $id_brg, $realisasi_pengembalian, $kondisi);

            if ($berhasil == 1) {
                redirect('Master_data/data_peminjaman');
            } else {
                redirect('Master_data/data_peminjaman');
            }
        }
    }

    public function inpt_peminjaman()
    {
        $id_brg             =   $this->input->post('id_brg');
        $kd_peminjaman      =   $this->input->post('kd_peminjaman');
        $nm_peminjaman      =   $this->input->post('nm_peminjaman');
        $nohp_peminjaman    =   $this->input->post('nohp_peminjaman');
        $tgl_peminjaman     =   $this->input->post('tgl_peminjaman');
        $tgl_pengembalian   =   $this->input->post('tgl_pengembalian');
        $kd_brg             =   $this->input->post('kd_brg');
        $nm_brg             =   $this->input->post('nm_brg');
        $ket                =   $this->input->post('ket');

        date_default_timezone_set('Asia/Jakarta');
        $date   = date("Y/m/d H:i:s");

        $data = array(
            'id_brg' => $id_brg,
            'kd_peminjaman' => $kd_peminjaman,
            'nm_peminjaman' => $nm_peminjaman,
            'nohp_peminjaman' => $nohp_peminjaman,
            'tgl_peminjaman' => $tgl_peminjaman,
            'tgl_pengembalian' => $tgl_pengembalian,
            'kd_brg' => $kd_brg,
            'nm_brg' => $nm_brg,
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
        $data = $this->Master_data_model->delete_peminjaman('tbl_peminjaman_aset', $id_peminjaman);
        echo json_encode($data);
    }
}
