<?php

class Penghapusan_aset_model extends CI_Model
{
    function get_dt_pemeliharaan_aset()
    {
        // return $this->db->query("SELECT * FROM tbl_pemeliharaan_aset WHERE stts_approval IN ('4', '5') ")->result_array();
        return $this->db->query("SELECT * FROM tbl_pemeliharaan_aset")->result_array();
    }

    function get_matriks_nilai()
    {
        return $this->db->query(
            "SELECT 
                *
            FROM 
                tbl_matriks_nilai 
            ORDER BY 
                id_matriks ASC"
        )->result_array();
    }

    function get_mtrk_minmax()
    {
        return $this->db->query(
            "SELECT *, 
                    MAX(kondisi_brg) AS kon_brgx, MAX(nilai_buku) AS nil_bukux, MAX(sisa_umr_ekonomis) AS sisa_umr_ekonomisx, 
                    MIN(kondisi_brg) AS kon_brgn, MIN(nilai_buku) AS nil_bukun, MIN(sisa_umr_ekonomis) AS sisa_umr_ekonomisn 
            FROM tbl_matriks_nilai"
        )->result_array();
    }

    function get_bobot()
    {
        return $this->db->query("SELECT * FROM tbl_bobot")->result_array();
    }

    function kd_rengking()
    {
        $this->db->select_max('kd_rengking');
        $hasil = $this->db->get('tbl_rengking');
        foreach ($hasil->result_array() as $j) {
            $kode = 1 + $j['kd_rengking'];
        }
        return $kode;
    }

    function entry_rengking($db, $data)
    {
        return $this->db->insert_batch($db, $data);
    }

    function get_rengking()
    {
        return $this->db->query("SELECT * FROM tbl_rengking ORDER BY nilai_akhir DESC")->result_array();
    }
}

?>