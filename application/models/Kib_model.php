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
            WHERE jns_brg = '1' 
            ORDER BY entry_date DESC"
        )->result_array();
    }

    function get_data_kib_a_ctk($tgl_awal, $tgl_akhir, $kategori, $thn_beli)
    {
        if ($kategori != "") {
            $ktr = " AND kd_brg = '$kategori'";
        } else {
            $ktr = "";
        }

        if ($thn_beli != "") {
            $thn = " AND thn_beli = '$thn_beli'";
        } else {
            $thn = "";
        }

        if ($tgl_awal == "" AND $tgl_akhir == "") 
        {
            $data = $this->db->query(
                "SELECT 
                    kd_brg, nm_brg, no_reg, luas, YEAR(thn_pengadaan) AS thn_pengadaan, letak_lokasi,
                    st_hak, st_stfkt_tgl, st_stfkt_no, perolehan, harga, hi_kf_a,
                    hi_kf_ta, hi_kf_bt, hi_dk_a, hi_dk_ta, hi_p_s, hi_p_pl, ket 
                FROM tbl_pengadaan_aset 
                WHERE 
                    jns_brg = '1' 
                    $ktr
                    $thn
                ORDER BY entry_date DESC"
            )->result_array();
        } 
        else 
        {
            $data = $this->db->query(
                "SELECT 
                    kd_brg, nm_brg, no_reg, luas, YEAR(thn_pengadaan) AS thn_pengadaan, letak_lokasi,
                    st_hak, st_stfkt_tgl, st_stfkt_no, perolehan, harga, hi_kf_a,
                    hi_kf_ta, hi_kf_bt, hi_dk_a, hi_dk_ta, hi_p_s, hi_p_pl, ket 
                FROM tbl_pengadaan_aset 
                WHERE 
                    date(entry_date) BETWEEN date('$tgl_awal') AND date('$tgl_akhir') 
                    AND jns_brg = '1'
                    $ktr
                    $thn 
                ORDER BY entry_date DESC"
            )->result_array();
        }

        if ($data) {
            return $data;
        } else {
            return 0;
        }
    }

    function get_dt_a()
    {
        return $this->db->query(
            "SELECT kd_brg, nm_brg FROM tbl_pengadaan_aset WHERE jns_brg = '1' GROUP BY kd_brg"
        )->result_array();
    }

    // ----------------------- //
    //      Data kib_b        //
    // ----------------------- //
    function get_dt_kib_b()
    {
        return $this->db->query(
            "SELECT 
                id_brg, kd_brg, nm_brg, no_reg, merk_type, bahan, thn_beli, 
                perolehan, kondisi, harga, umr_ekonomis, nli_sisa 
            FROM tbl_pengadaan_aset 
            WHERE jns_brg = '2' 
            ORDER BY entry_date DESC"
        )->result_array();
    }

    function get_data_kib_b_ctk($tgl_awal, $tgl_akhir, $kategori, $thn_beli)
    {
        if ($kategori != "") {
            $ktr = " AND kd_brg = '$kategori'";
        } else {
            $ktr = "";
        }

        if ($thn_beli != "") {
            $thn = " AND thn_beli = '$thn_beli'";
        } else {
            $thn = "";
        }
        
        if ($tgl_awal == "" AND $tgl_akhir == "") {
            $data = $this->db->query(
                "SELECT 
                    kd_brg, nm_brg, no_reg, merk_type, ukuran_cc, bahan, thn_beli, 
                    perolehan, kondisi, harga, umr_ekonomis, nli_sisa, ket
                FROM tbl_pengadaan_aset 
                WHERE
                    jns_brg = '2' 
                    $ktr
                    $thn 
                ORDER BY entry_date DESC"
            )->result_array();
        } else {
            $data = $this->db->query(
                "SELECT 
                    kd_brg, nm_brg, no_reg, merk_type, ukuran_cc, bahan, thn_beli, 
                    perolehan, kondisi, harga, umr_ekonomis, nli_sisa, ket
                FROM tbl_pengadaan_aset 
                WHERE
                    date(entry_date) BETWEEN date('$tgl_awal') AND date('$tgl_akhir')
                    AND jns_brg = '2' 
                    $ktr
                    $thn 
                ORDER BY entry_date DESC"
            )->result_array();
        }
        
        if ($data) {
            return $data;
        } else {
            return 0;
        }
    }

    function update_kib_b($id,$value,$modul)
    {
        $data = $this->db->get_where("tbl_pengadaan_aset", array('id_brg' => $id))->result_array();
        if($this->db->affected_rows() > 0) {
            $menu        = 'KIB B';
            $aksi        = 'Mengubah';
            $item        = $data[0]["nm_brg"]." mengubah ".$modul." ".$data[0][$modul]. " menjadi ".$value;
            $assign_to   = '';
            $assign_type = '';
            activity_log($menu, $aksi, $item, $assign_to, $assign_type);

            $this->db->where(array("id_brg"=>$id));
            $this->db->update("tbl_pengadaan_aset",array($modul=>$value));

            return true;
        } else {
            return false;
        }
        
    }

    function get_dt_b()
    {
        return $this->db->query(
            "SELECT kd_brg, nm_brg FROM tbl_pengadaan_aset WHERE jns_brg = '2' GROUP BY kd_brg"
        )->result_array();
    }

    // ----------------------- //
    //      Data kib_c        //
    // ----------------------- //
    function get_dt_kib_c()
    {
        return $this->db->query(
            "SELECT 
                id_brg, kd_brg, nm_brg, no_reg, kondisi, bertingkat, 
                beton, luas, letak_lokasi, dg_tgl, dg_no, 
                stts_tanah, harga, no_kd_tanah, perolehan, ket
            FROM tbl_pengadaan_aset 
            WHERE jns_brg = '3' 
            ORDER BY entry_date DESC"
        )->result_array();
    }

    function get_data_kib_c_ctk($tgl_awal, $tgl_akhir, $kategori, $thn_beli)
    {
        if ($kategori != "") {
            $ktr = " AND kd_brg = '$kategori'";
        } else {
            $ktr = "";
        }

        if ($thn_beli != "") {
            $thn = " AND thn_beli = '$thn_beli'";
        } else {
            $thn = "";
        }

        if ($tgl_awal == "" AND $tgl_akhir == "") {
            $data = $this->db->query(
                "SELECT 
                    kd_brg, nm_brg, no_reg, kondisi, bertingkat, 
                    beton, luas, letak_lokasi, dg_tgl, dg_no, 
                    stts_tanah, harga, no_kd_tanah, perolehan, ket
                FROM tbl_pengadaan_aset 
                WHERE 
                    jns_brg = '3'
                    $ktr
                    $thn  
                ORDER BY entry_date DESC"
            )->result_array();
        } else {
            $data = $this->db->query(
                "SELECT 
                    kd_brg, nm_brg, no_reg, kondisi, bertingkat, 
                    beton, luas, letak_lokasi, dg_tgl, dg_no, 
                    stts_tanah, harga, no_kd_tanah, perolehan, ket
                FROM tbl_pengadaan_aset 
                WHERE 
                    date(entry_date) BETWEEN date('$tgl_awal') AND date('$tgl_akhir')
                    AND jns_brg = '3' 
                    $ktr
                    $thn 
                ORDER BY entry_date DESC"
            )->result_array();
        }

        if ($data) {
            return $data;
        } else {
            return 0;
        }
    }

    function update_kib_c($id,$value,$modul)
    {
        $data = $this->db->get_where("tbl_pengadaan_aset", array('id_brg' => $id))->result_array();
        if($this->db->affected_rows() > 0) {
            $menu        = 'KIB C';
            $aksi        = 'Mengubah';
            $item        = $data[0]["nm_brg"]." mengubah ".$modul." ".$data[0][$modul]. " menjadi ".$value;
            $assign_to   = '';
            $assign_type = '';
            activity_log($menu, $aksi, $item, $assign_to, $assign_type);

            $this->db->where(array("id_brg"=>$id));
            $this->db->update("tbl_pengadaan_aset",array($modul=>$value));

            return true;
        } else {
            return false;
        }
        
    }

    function get_dt_c()
    {
        return $this->db->query(
            "SELECT kd_brg, nm_brg FROM tbl_pengadaan_aset WHERE jns_brg = '3' GROUP BY kd_brg"
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
                jmlh_brg, thn_beli, perolehan, harga, ket
            FROM tbl_pengadaan_aset 
            WHERE jns_brg = '5'
            ORDER BY entry_date DESC"
        )->result_array();
    }

    function get_data_kib_e_ctk($tgl_awal, $tgl_akhir, $kategori, $thn_beli)
    {
        if ($kategori != "") {
            $ktr = " AND kd_brg = '$kategori'";
        } else {
            $ktr = "";
        }

        if ($thn_beli != "") {
            $thn = " AND thn_beli = '$thn_beli'";
        } else {
            $thn = "";
        }

        if ($tgl_awal == "" AND $tgl_akhir == "") {
            $data = $this->db->query(
                "SELECT 
                    kd_brg, nm_brg, no_reg, bp_jp, bp_s, bbkk_ad, bbkk_p, bbkk_b, htt_j, 
                    htt_u, jmlh_brg, thn_beli, perolehan, harga, umr_ekonomis, nli_sisa, ket
                FROM tbl_pengadaan_aset 
                WHERE
                    jns_brg = '5' 
                    $ktr
                    $thn 
                ORDER BY entry_date DESC"
            )->result_array();
        } else {
            $data = $this->db->query(
                "SELECT 
                    kd_brg, nm_brg, no_reg, bp_jp, bp_s, bbkk_ad, bbkk_p, bbkk_b, htt_j, 
                    htt_u, jmlh_brg, thn_beli, perolehan, harga, umr_ekonomis, nli_sisa, ket
                FROM tbl_pengadaan_aset 
                WHERE
                    date(entry_date) BETWEEN date('$tgl_awal') AND date('$tgl_akhir')
                    AND jns_brg = '5' 
                    $ktr
                    $thn 
                ORDER BY entry_date DESC"
            )->result_array();
        }

        if ($data) {
            return $data;
        } else {
            return 0;
        }
    }

    function get_dt_e()
    {
        return $this->db->query(
            "SELECT kd_brg, nm_brg FROM tbl_pengadaan_aset WHERE jns_brg = '5' GROUP BY kd_brg"
        )->result_array();
    }
}
