<?php

class Laporan_model extends  CI_Model
{
    function get_data_pengadaan()
    {
        return $this->db->query(
            "SELECT 
                kd_brg, no_reg, nm_brg, merk_type, st_stfkt_no, bahan, perolehan, thn_beli, 
                ukuran_cc, satuan_brg, kondisi, jmlh_brg, harga, umr_ekonomis, nli_sisa, ket
            FROM tbl_pengadaan_aset
            ORDER BY entry_date DESC"
        )->result_array();
    }

    function get_data_pengadaan_ctk($tgl_awal, $tgl_akhir)
    {
        return $this->db->query(
            "SELECT 
                kd_brg, no_reg, nm_brg, merk_type, st_stfkt_no, bahan, perolehan, thn_beli, ukuran_cc, 
                satuan_brg, kondisi, jmlh_brg, harga, umr_ekonomis, nli_sisa, ket, entry_date
            FROM 
                tbl_pengadaan_aset
            WHERE 
                date(entry_date) BETWEEN date('$tgl_awal') AND date('$tgl_akhir')
            ORDER BY entry_date DESC"
        )->result_array();
    }

    function get_data_peminjaman()
    {
        return $this->db->query(
            "SELECT 
                nm_peminjaman, nohp_peminjaman, tgl_peminjaman, tgl_pengembalian, 
                realisasi_pengembalian, kd_brg, nm_brg, ket
            FROM 
                tbl_peminjaman_aset
            ORDER BY entry_date DESC"
        )->result_array();
    }

    function get_data_peminjaman_ctk($tgl_awal, $tgl_akhir)
    {
        return $this->db->query(
            "SELECT 
                nm_peminjaman, nohp_peminjaman, tgl_peminjaman, tgl_pengembalian, 
                realisasi_pengembalian, kd_brg, nm_brg, ket
            FROM 
                tbl_peminjaman_aset
            WHERE 
                date(entry_date) BETWEEN date('$tgl_awal') AND date('$tgl_akhir')
            ORDER BY entry_date DESC"
        )->result_array();
    }

    function get_dt_usulan_pengadaan()
    {
        return $this->db->query(
            "SELECT 
                kd_brg, nm_brg, jmlh_brg, satuan_brg, harga_brg, masa_manfaat, ket 
            FROM tbl_usulan_aset 
            WHERE 
                stts_approval_kep = '2' 
                AND stts_pengadaan = '2' 
            ORDER BY entry_date DESC"
        )->result_array();
    }

    function dt_usulan_pengadaan()
    {
        return $this->db->query(
            "SELECT 
                kd_usulan, ket 
            FROM tbl_usulan_aset
            WHERE 
                stts_approval_kep = '2' 
                AND stts_pengadaan = '2' 
            GROUP BY kd_usulan"
        )->result_array();
    }

    function print_usul_pengadaan($tgl_awal, $tgl_akhir, $kategori)
    {
        if ($kategori != "all") {
            $ktr = " AND kd_usulan = '$kategori'";
        } else {
            $ktr = " ";
        }

        if ($tgl_awal == "" AND $tgl_akhir == "") {
            $data = $this->db->query(
                "SELECT 
                    kd_brg, nm_brg, jmlh_brg, satuan_brg, harga_brg, masa_manfaat, ket 
                FROM tbl_usulan_aset 
                WHERE 
                    stts_approval_kep = '2' 
                    AND stts_pengadaan = '2' 
                    $ktr
                ORDER BY entry_date DESC"
            )->result_array();
        } else {
            $data = $this->db->query(
                "SELECT 
                    kd_brg, nm_brg, jmlh_brg, satuan_brg, harga_brg, masa_manfaat, ket 
                FROM tbl_usulan_aset 
                WHERE 
                    stts_approval_kep = '2' 
                    AND stts_pengadaan = '2' 
                    AND date(entry_date) BETWEEN date('$tgl_awal') AND date('$tgl_akhir')
                    $ktr
                ORDER BY entry_date DESC"
            )->result_array();
        }

        if ($data) {
            return $data;
        } else {
            return 0;
        }
    }
}
