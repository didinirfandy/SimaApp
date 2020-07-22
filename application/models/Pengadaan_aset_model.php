<?php

class Pengadaan_aset_model extends CI_Model
{
    function get_usulan_group()
    {
        return $this->db->query("SELECT kd_usulan, ket, entry_date, stts_approval FROM tbl_usulan_aset GROUP BY kd_usulan")->result_array();
    }

    function get_dtl_brg($kd_usulan)
    {
        return $this->db->query("SELECT nm_brg, jns_brg, satuan_brg, jmlh_brg, harga_brg FROM tbl_usulan_aset WHERE kd_usulan='$kd_usulan' ")->result_array();
    }

    function get_pengadaan()
    {
        return $this->db->query("SELECT id_brg, kd_brg, nm_brg, no_reg, umr_ekonomis, nli_sisa FROM tbl_pengadaan_aset")->result_array();
    }
}

?>