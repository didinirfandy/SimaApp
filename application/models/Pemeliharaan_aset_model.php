<?php

class Pemeliharaan_aset_model extends CI_Model
{
    function get_data_aset()
    {
        return $this->db->query(
            "SELECT 
                a.id_brg, a.kd_brg, a.nm_brg, a.no_reg, a.merk_type, a.harga, a.kondisi, a.umr_ekonomis, a.nli_sisa, a.stts_pemeliharaan, 
                (a.umr_ekonomis - (DATE_FORMAT(NOW(), '%Y') - a.thn_beli)) AS sisa_umr_ekonomis, b.stts_approval
            FROM 
                tbl_pengadaan_aset a 
                LEFT JOIN tbl_pemeliharaan_aset b ON b.id_brg = a.id_brg
            ORDER BY a.id_brg
            "
        )->result_array();
    }

    function int_pemeliharaan ($id_brg, $ket)
    {
        $get = $this->db->get_where('tbl_pengadaan_aset', array('id_brg' => $id_brg))->result_array();
        
        $id_brg         = $get[0]['id_brg'];
        $kd_brg         = $get[0]['kd_brg'];
        $nm_brg         = $get[0]['nm_brg'];
        $no_reg         = $get[0]['no_reg'];
        $kondisi_brg    = $get[0]['kondisi'];
        $harga          = $get[0]['harga'];
        $merk_type      = $get[0]['merk_type'];
        $umr_ekonomis   = $get[0]['umr_ekonomis'];
        $nli_sisa       = $get[0]['nli_sisa'];

        date_default_timezone_set('Asia/Jakarta');
        $date   = date("Y-m-d H:i:s");

        $data = array(
            'id_brg'        => $id_brg,
            'kd_brg'        => $kd_brg,
            'nm_brg'        => $nm_brg,
            'no_reg'        => $no_reg,
            'kondisi_brg'   => $kondisi_brg,
            'harga'         => $harga,
            'merk_type'     => $merk_type,
            'umr_ekonomis'  => $umr_ekonomis,
            'nli_sisa'      => $nli_sisa,
            'ket'           => $ket,
            'entry_date'    => $date
        );

        if ($kondisi_brg == 1) {
            return 2;
        } else {
            $hasil1  = $this->db->insert('tbl_pemeliharaan_aset', $data);
            $hasil2  = $this->db->query("UPDATE tbl_pengadaan_aset SET stts_pemeliharaan = '2' WHERE id_brg = '$id_brg' ");
    
            if ($hasil1 && $hasil2) {
                if($this->db->affected_rows() > 0) {
                    $menu        = 'Pemeliharaan Aset';
                    $aksi        = 'Mengajukan pemeliharaan aset';
                    $item        = 'Menginsert data ke pemeliharaan dari data aset dan mengupdate status pemeliharaan menjadi 2';
                    $assign_to   = 'Wakasek';
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

    function hps_pemeliharaan($id_brg)
    {        
        $hasil1 = $this->db->delete('tbl_pemeliharaan_aset', array('id_brg' => $id_brg));
        $hasil2 = $this->db->query("UPDATE tbl_pengadaan_aset SET stts_pemeliharaan = '0' WHERE id_brg = '$id_brg' ");

        if ($hasil1 && $hasil2) {
            if($this->db->affected_rows() > 0) {
                $menu        = 'Pemeliharaan Aset';
                $aksi        = 'Membatalkan pemeliharaan';
                $item        = 'Menghapus data di pemeliharaan dan mengupdate status pemeliharaan menjadi 2';
                $assign_to   = '';
                $assign_type = '';
                activity_log($menu, $aksi, $item, $assign_to, $assign_type);
                return 1;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    function get_data_pemeliharaan()
    {
        return $this->db->query(
            "SELECT 
                a.id_pemeliharaan, a.id_brg, a.kd_brg, a.nm_brg, a.no_reg, a.kondisi_brg,
                a.harga, a.umr_ekonomis, a.merk_type, a.nli_sisa, a.stts_approval, b.thn_beli, a.ket,
                (a.umr_ekonomis - (DATE_FORMAT(NOW(), '%Y') - b.thn_beli)) AS sisa_umr_ekonomis
            FROM tbl_pemeliharaan_aset a
            LEFT JOIN tbl_pengadaan_aset b ON b.id_brg = a.id_brg
            ORDER BY a.entry_date"
        )->result_array();
    }

    function set_pemeliharaan($id_pemeliharaan, $id_brg, $stts_approval, $nilai_buku_bln, $sisa_umr_ekonomis)
    {
        $hasil1 = $this->db->query("UPDATE tbl_pemeliharaan_aset SET stts_approval = '$stts_approval' WHERE id_pemeliharaan = '$id_pemeliharaan' ");
        $hasil2 = $this->db->query("UPDATE tbl_pengadaan_aset SET stts_pemeliharaan = '2' WHERE id_brg = '$id_brg' ");

        $get = $this->db->get_where('tbl_pemeliharaan_aset', array('id_pemeliharaan' => $id_pemeliharaan))->result_array();
        $nb  = $this->db->get('tbl_nilai_buku')->result_array();

        $id_barang   = $get[0]['id_brg'];
        $kd_brg      = $get[0]['kd_brg'];
        $nm_brg      = $get[0]['nm_brg'];
        $no_reg      = $get[0]['no_reg'];        

        if ($get[0]['kondisi_brg'] == 2) {
            $kondisi_brg = 2;
        } elseif ($get[0]['kondisi_brg'] == 3) {
            $kondisi_brg = 4;
        }

        if ($sisa_umr_ekonomis == 0) {
            $sisa_umr_eko = 5;
        } elseif ($sisa_umr_ekonomis < 2) {
            $sisa_umr_eko = 4;
        } elseif($sisa_umr_ekonomis >= 2) {
            $sisa_umr_eko = 2;
        } else {
            $sisa_umr_eko = 0;
        }

        if ($nilai_buku_bln >= '44000' OR $nilai_buku_bln <= '2022999') {
            $nilai_buku = 8;
        } elseif ($nilai_buku_bln >= '2023000' OR $nilai_buku_bln <= '4001999') {
            $nilai_buku = 7;
        } elseif ($nilai_buku_bln >= '4002000' OR $nilai_buku_bln <= '5980999') {
            $nilai_buku = 6;
        } elseif ($nilai_buku_bln >= '5981000' OR $nilai_buku_bln <= '7959999') {
            $nilai_buku = 5;
        } elseif ($nilai_buku_bln >= '7960000' OR $nilai_buku_bln <= '9938999') {
            $nilai_buku = 4;
        } elseif ($nilai_buku_bln >= '9939000' OR $nilai_buku_bln <= '11917999') {
            $nilai_buku = 3;
        } elseif ($nilai_buku_bln >= '11918000' OR $nilai_buku_bln <= '13896999') {
            $nilai_buku = 2;
        } elseif ($nilai_buku_bln >= '13897000' OR $nilai_buku_bln <= '15876000') {
            $nilai_buku = 1;
        } else {
            $nilai_buku = 0;
        }
                
        date_default_timezone_set('Asia/Jakarta');
        $date        = date("Y-m-d H:i:s");

        $data = array(
            'id_brg' => $id_barang,
            'kd_brg' => $kd_brg,
            'nm_brg' => $nm_brg,
            'no_reg' => $no_reg,
            'kondisi_brg' => $kondisi_brg,
            'nilai_buku' => $nilai_buku,
            'sisa_umr_ekonomis' => $sisa_umr_eko,
            'tgl_approval' => $date
        );

        $hasil3 = $this->db->insert('tbl_matriks_nilai', $data);

        if ($hasil1 && $hasil2 && $hasil3) {
            if($this->db->affected_rows() > 0) {
                $menu        = 'Pemeliharaan Aset';
                $aksi        = 'Approve dan Insert';
                $item        = 'Menyetujui pemeliharaan dan menginput data ke tabel matriks';
                $assign_to   = 'Asset dan Kepsek';
                $assign_type = 'Approve dan Insert';
                activity_log($menu, $aksi, $item, $assign_to, $assign_type);
                return 1;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    function set_pemeliharaan_batal($id_pemeliharaan, $id_brg)
    {
        $hasil1 = $this->db->query("UPDATE tbl_pemeliharaan_aset SET stts_approval = '1' WHERE id_pemeliharaan = '$id_pemeliharaan' ");
        $hasil2 = $this->db->query("UPDATE tbl_pengadaan_aset SET stts_pemeliharaan = '1' WHERE id_brg = '$id_brg' ");

        if ($hasil1 && $hasil2) {
            if($this->db->affected_rows() > 0) {
                $menu        = 'Pemeliharaan Aset';
                $aksi        = 'Membatalkan pemeliharaan';
                $item        = 'Mengupdate status';
                $assign_to   = 'Asset';
                $assign_type = '';
                activity_log($menu, $aksi, $item, $assign_to, $assign_type);
                return 1;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    function get_pemeliharaan_aset_internal()
    {
        return $this->db->query("SELECT * FROM tbl_pemeliharaan_aset WHERE stts_approval IN ('2', '4')")->result_array();
    }

    function pemeliharaan_selesai_in($id_pemeliharaan, $id_brg)
    {
        $hasil1 = $this->db->query("UPDATE tbl_pemeliharaan_aset SET stts_approval = '4' WHERE id_pemeliharaan = '$id_pemeliharaan' ");
        $hasil2 = $this->db->query("UPDATE tbl_pengadaan_aset SET stts_pemeliharaan = '3' WHERE id_brg = '$id_brg' ");

        if ($hasil1 && $hasil2) {
            if($this->db->affected_rows() > 0) {
                $menu        = 'Pemeliharaan Aset';
                $aksi        = 'Telah selesai melakukan pemeliharaan aset';
                $item        = 'Mengupdate status';
                $assign_to   = 'Wakasek dan Kepsek';
                $assign_type = '';
                activity_log($menu, $aksi, $item, $assign_to, $assign_type);
                return 1;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    function get_pemeliharaan_aset_external()
    {
        return $this->db->query("SELECT * FROM tbl_pemeliharaan_aset WHERE stts_approval IN ('3', '5') ")->result_array();
    }

    function pemeliharaan_selesai_ex($id_pemeliharaan, $id_brg)
    {
        $hasil1 = $this->db->query("UPDATE tbl_pemeliharaan_aset SET stts_approval = '5' WHERE id_pemeliharaan = '$id_pemeliharaan' ");
        $hasil2 = $this->db->query("UPDATE tbl_pengadaan_aset SET stts_pemeliharaan = '3' WHERE id_brg = '$id_brg' ");

        if ($hasil1 && $hasil2) {
            if($this->db->affected_rows() > 0) {
                $menu        = 'Pemeliharaan Aset';
                $aksi        = 'Telah selesai melakukan pemeliharaan aset';
                $item        = 'Mengupdate status';
                $assign_to   = 'Wakasek dan Kepsek';
                $assign_type = '';
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

?>