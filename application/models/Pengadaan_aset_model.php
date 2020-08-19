<?php

class Pengadaan_aset_model extends CI_Model
{
    function get_usulan_group()
    {
        return $this->db->query("SELECT kd_usulan, ket, entry_date, stts_approval_wk, stts_approval_kep FROM tbl_usulan_aset GROUP BY kd_usulan")->result_array();
    }

    function get_dtl_brg($kd_usulan)
    {
        return $this->db->query("SELECT nm_brg, jns_brg, satuan_brg, jmlh_brg, harga_brg FROM tbl_usulan_aset WHERE kd_usulan='$kd_usulan' ")->result_array();
    }

    function get_pengadaan()
    {
        return $this->db->query("SELECT id_brg, kd_brg, nm_brg, no_reg, umr_ekonomis, nli_sisa FROM tbl_pengadaan_aset ORDER BY id_brg DESC")->result_array();
    }

    function aksi_usulan_pengadaan_wk($kd_usulan, $stts_approval)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date   = date("Y/m/d H:i:s");
        $hasil = $this->db->query("UPDATE tbl_usulan_aset SET stts_approval_wk = '$stts_approval', tgl_approval_wk = '$date', stts_pengadaan='2' WHERE kd_usulan = '$kd_usulan' ");

        if ($hasil) {
            if ($this->db->affected_rows() > 0) {
                $menu        = 'Pengadaan Aset';
                $aksi        = 'Menyetujui Usulan Pengadaan Aset';
                $item        = 'Mengupdate status';
                $assign_to   = 'Aset dan Kepsek';
                $assign_type = 'Approval';
                activity_log($menu, $aksi, $item, $assign_to, $assign_type);
                return 1;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    function aksi_usulan_pengadaan_kep($kd_usulan, $stts_approval)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date   = date("Y/m/d H:i:s");
        $hasil = $this->db->query("UPDATE tbl_usulan_aset SET stts_approval_kep = '$stts_approval', tgl_approval_kep = '$date' WHERE kd_usulan = '$kd_usulan' ");

        if ($hasil) {
            if ($this->db->affected_rows() > 0) {
                $menu        = 'Pengadaan Aset';
                $aksi        = 'Menyetujui Usulan Pengadaan Aset';
                $item        = 'Mengupdate status';
                $assign_to   = 'Aset dan Wakasek';
                $assign_type = 'Approval';
                activity_log($menu, $aksi, $item, $assign_to, $assign_type);
                return 1;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }
}
