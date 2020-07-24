<?php 

class Kib_model extends CI_Model
{
    // ----------------------- //
    //      Data kib_a        //
    // ----------------------- //
    function get_dt_kib_a()
    {
        return $this->db->query(
            "SELECT 
                kd_brg, nm_brg, no_reg, luas, thn_pengadaan, 
                st_hak, st_stfkt_tgl, st_stfkt_no, perolehan, harga 
            FROM tbl_pengadaan_aset 
            WHERE jns_brg = '1' "
        )->result_array();
    }

    // ----------------------- //
    //      Data kib_b        //
    // ----------------------- //
    function get_dt_kib_b()
    {
        return $this->db->query(
            "SELECT 
                kd_brg, nm_brg, no_reg, merk_type, bahan, thn_beli, 
                perolehan, kondisi, harga, umr_ekonomis, nli_sisa 
            FROM tbl_pengadaan_aset 
            WHERE jns_brg = '2' "
        )->result_array();
    }

    // ----------------------- //
    //      Data kib_c        //
    // ----------------------- //
    function get_dt_kib_c()
    {
        return $this->db->query(
            "SELECT 
                kd_brg, nm_brg, no_reg, kondisi, bertingkat, 
                beton, luas, letak_lokasi, dg_tgl, dg_no, 
                stts_tanah, harga, no_kd_tanah, perolehan, ket
            FROM tbl_pengadaan_aset 
            WHERE jns_brg = '3' "
        )->result_array();
    }

    // ----------------------- //
    //      Data kib_d        //
    // ----------------------- //
    function get_dt_kib_d()
    {
        // return $this->db->query(
        //     "SELECT 
        //         kd_brg, nm_brg, no_reg, luas, thn_pengadaan,
        //         st_hak, st_stfkt_tgl, st_stfkt_no, perolehan, harga 
        //     FROM tbl_pengadaan_aset 
        //     WHERE jns_brg = '4' "
        // )->result_array();
    }

    // ----------------------- //
    //      Data kib_e        //
    // ----------------------- //
    function get_dt_kib_e()
    {
        return $this->db->query(
            "SELECT 
                kd_brg, nm_brg, no_reg, bp_jp, bp_s, 
                bbkk_ad, bbkk_p, bbkk_b, htt_j, htt_u, 
                jmlh_brg, thn_beli, perolehan, harga
            FROM tbl_pengadaan_aset 
            WHERE jns_brg = '5' "
        )->result_array();
    }
}


?>