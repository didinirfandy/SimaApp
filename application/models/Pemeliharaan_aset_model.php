<?php

class Pemeliharaan_aset_model extends CI_Model
{
    function get_data_aset()
    {
        return $this->db->query(
            "SELECT 
                a.id_brg, a.kd_brg, a.nm_brg, a.no_reg, a.merk_type, a.harga, a.kondisi, a.umr_ekonomis, a.nli_sisa, a.stts_pemeliharaan, a.thn_beli,
                (a.umr_ekonomis - (DATE_FORMAT(NOW(), '%Y') - a.thn_beli)) AS sisa_umr_ekonomis, a.jns_brg,
                ((a.harga - a.nli_sisa) / a.umr_ekonomis) AS penyusutan, b.stts_approval
            FROM 
                tbl_pengadaan_aset a 
                LEFT JOIN tbl_pemeliharaan_aset b ON b.id_brg = a.id_brg
            WHERE 
                a.jns_brg != 1
                AND a.thn_beli != ''
                AND a.umr_ekonomis != ''
            ORDER BY a.kondisi DESC"
        )->result_array();
    }

    function int_pemeliharaan($id_brg, $ket)
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
        $date = date("Y-m-d H:i:s");

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
                if ($this->db->affected_rows() > 0) {
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
            if ($this->db->affected_rows() > 0) {
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
                a.harga, a.umr_ekonomis, a.merk_type, a.nli_sisa, a.stts_approval, a.stts_approval_kep, b.thn_beli, a.ket,
                (a.umr_ekonomis - (DATE_FORMAT(NOW(), '%Y') - b.thn_beli)) AS sisa_umr_ekonomis,
                ((b.harga - b.nli_sisa) / b.umr_ekonomis) AS penyusutan
            FROM tbl_pemeliharaan_aset a
                LEFT JOIN tbl_pengadaan_aset b ON b.id_brg = a.id_brg
            WHERE 
                b.jns_brg != 1
                AND b.thn_beli != ''
            ORDER BY a.stts_approval ASC, a.stts_approval_kep ASC"
        )->result_array();
    }

    function get_kd_matriks()
    {
        $data = $this->db->query(
            "SELECT 
                MAX(kd_matriks) AS kd_matriks 
            FROM 
                tbl_matriks_nilai 
            WHERE date(entry_date) NOT IN (date_format(curdate(), '%Y-%m-%d'))"
        )->result_array();

        foreach ($data as $j) {
            $kode = 1 + $j['kd_matriks'];
        }
        return $kode;
    }

    function aksi_pemeliharaan_wk($id_pemeliharaan, $id_brg, $kd_matriks, $stts_approval, $nilai_buku_bln, $sisa_umr_ekonomis)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date   = date("Y-m-d H:i:s");
        if ($stts_approval == 2) {
            $hasil1 = $this->db->query(
                "UPDATE 
                    tbl_pemeliharaan_aset SET 
                    stts_approval = '$stts_approval', tgl_approval = '$date', stts_approval_kep = '2', tgl_approval_kep = '$date'
                WHERE id_pemeliharaan = '$id_pemeliharaan' "
            );

            $hasil2 = $this->db->query("UPDATE tbl_pengadaan_aset SET stts_pemeliharaan = '2' WHERE id_brg = '$id_brg' ");

            $get = $this->db->get_where('tbl_pemeliharaan_aset', array('id_pemeliharaan' => $id_pemeliharaan))->result_array();

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
            } elseif ($sisa_umr_ekonomis >= 2) {
                $sisa_umr_eko = 2;
            } else {
                $sisa_umr_eko = 0;
            }

            if ($nilai_buku_bln >= '44000' and $nilai_buku_bln <= '2022999') {
                $nilai_buku = 8;
            } elseif ($nilai_buku_bln >= '2023000' and $nilai_buku_bln <= '4001999') {
                $nilai_buku = 7;
            } elseif ($nilai_buku_bln >= '4002000' and $nilai_buku_bln <= '5980999') {
                $nilai_buku = 6;
            } elseif ($nilai_buku_bln >= '5981000' and $nilai_buku_bln <= '7959999') {
                $nilai_buku = 5;
            } elseif ($nilai_buku_bln >= '7960000' and $nilai_buku_bln <= '9938999') {
                $nilai_buku = 4;
            } elseif ($nilai_buku_bln >= '9939000' and $nilai_buku_bln <= '11917999') {
                $nilai_buku = 3;
            } elseif ($nilai_buku_bln >= '11918000' and $nilai_buku_bln <= '13896999') {
                $nilai_buku = 2;
            } elseif ($nilai_buku_bln >= '13897000' and $nilai_buku_bln <= '15876000') {
                $nilai_buku = 1;
            } else {
                $nilai_buku = 0;
            }

            date_default_timezone_set('Asia/Jakarta');
            $date = date("Y-m-d H:i:s");

            $data = array(
                'id_brg' => $id_barang,
                'kd_brg' => $kd_brg,
                'kd_matriks' => $kd_matriks,
                'nm_brg' => $nm_brg,
                'no_reg' => $no_reg,
                'kondisi_brg' => $kondisi_brg,
                'nilai_buku' => $nilai_buku,
                'sisa_umr_ekonomis' => $sisa_umr_eko,
                'entry_date' => $date
            );

            $hasil3 = $this->db->insert('tbl_matriks_nilai', $data);

            if ($hasil1 && $hasil2 && $hasil3) {
                if ($this->db->affected_rows() > 0) {
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
        } else {
            $hasil1 = $this->db->query("UPDATE tbl_pemeliharaan_aset SET stts_approval = '$stts_approval', tgl_approval = '$date' WHERE id_pemeliharaan = '$id_pemeliharaan' ");
            $hasil2 = $this->db->query("UPDATE tbl_pengadaan_aset SET stts_pemeliharaan = '2' WHERE id_brg = '$id_brg' ");

            if ($hasil1 && $hasil2) {
                if ($this->db->affected_rows() > 0) {
                    $menu        = 'Pemeliharaan Aset';
                    $aksi        = 'Approve dan Insert';
                    $item        = 'Menyetujui pemeliharaan';
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
    }

    function aksi_pemeliharaan_kep($id_pemeliharaan, $id_brg, $kd_matriks, $stts_approval_kep, $nilai_buku_bln, $sisa_umr_ekonomis)
    {
        if ($stts_approval_kep == 2) {

            date_default_timezone_set('Asia/Jakarta');
            $date   = date("Y-m-d H:i:s");
            $hasil1  = $this->db->query(
                "UPDATE 
                    tbl_pemeliharaan_aset SET 
                    stts_approval_kep = '$stts_approval_kep', tgl_approval_kep = '$date'
                WHERE id_pemeliharaan = '$id_pemeliharaan' "
            );

            $hasil2 = $this->db->query("UPDATE tbl_pengadaan_aset SET stts_pemeliharaan = '2' WHERE id_brg = '$id_brg' ");

            $get = $this->db->get_where('tbl_pemeliharaan_aset', array('id_pemeliharaan' => $id_pemeliharaan))->result_array();

            $id_barang   = $get[0]['id_brg'];
            $kd_brg      = $get[0]['kd_brg'];
            $nm_brg      = $get[0]['nm_brg'];
            $no_reg      = $get[0]['no_reg'];


            if ($get[0]['kondisi_brg'] == 2) {
                $kondisi_brg = 2;
            } elseif ($get[0]['kondisi_brg'] == 3) {
                $kondisi_brg = 4;
            }

            if ($sisa_umr_ekonomis <= 2) {
                $sisa_umr_eko = 5;
            } elseif ($sisa_umr_ekonomis > 2) {
                $sisa_umr_eko = 2;
            }

            if ($nilai_buku_bln >= '44000' and $nilai_buku_bln <= '2022999') {
                $nilai_buku = 8;
            } elseif ($nilai_buku_bln >= '2023000' and $nilai_buku_bln <= '4001999') {
                $nilai_buku = 7;
            } elseif ($nilai_buku_bln >= '4002000' and $nilai_buku_bln <= '5980999') {
                $nilai_buku = 6;
            } elseif ($nilai_buku_bln >= '5981000' and $nilai_buku_bln <= '7959999') {
                $nilai_buku = 5;
            } elseif ($nilai_buku_bln >= '7960000' and $nilai_buku_bln <= '9938999') {
                $nilai_buku = 4;
            } elseif ($nilai_buku_bln >= '9939000' and $nilai_buku_bln <= '11917999') {
                $nilai_buku = 3;
            } elseif ($nilai_buku_bln >= '11918000' and $nilai_buku_bln <= '13896999') {
                $nilai_buku = 2;
            } elseif ($nilai_buku_bln >= '13897000' and $nilai_buku_bln <= '15876000') {
                $nilai_buku = 1;
            } else {
                $nilai_buku = 0;
            }

            date_default_timezone_set('Asia/Jakarta');
            $date = date("Y-m-d H:i:s");

            $data = array(
                'id_brg' => $id_barang,
                'kd_brg' => $kd_brg,
                'kd_matriks' => $kd_matriks,
                'nm_brg' => $nm_brg,
                'no_reg' => $no_reg,
                'kondisi_brg' => $kondisi_brg,
                'nilai_buku' => $nilai_buku,
                'sisa_umr_ekonomis' => $sisa_umr_eko,
                'entry_date' => $date
            );

            $hasil3 = $this->db->insert('tbl_matriks_nilai', $data);

            if ($hasil1 && $hasil2 && $hasil3) {
                if ($this->db->affected_rows() > 0) {
                    $menu        = 'Pemeliharaan Aset';
                    $aksi        = 'Update';
                    $item        = 'Menyetujui pemeliharaan External dan mengupdate data ke tabel matriks';
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
        } else {
            date_default_timezone_set('Asia/Jakarta');
            $date   = date("Y-m-d H:i:s");
            $hasil  = $this->db->query(
                "UPDATE 
                    tbl_pemeliharaan_aset SET 
                    stts_approval_kep = '$stts_approval_kep', tgl_approval_kep = '$date'
                WHERE id_pemeliharaan = '$id_pemeliharaan' "
            );

            if ($hasil) {
                if ($this->db->affected_rows() > 0) {
                    $menu        = 'Pemeliharaan Aset';
                    $aksi        = 'Update';
                    $item        = 'Menolak pemeliharaan External';
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
    }

    function aksi_pemeliharaan_batal_wk($id_pemeliharaan, $id_brg)
    {
        $hasil1 = $this->db->query("UPDATE tbl_pemeliharaan_aset SET stts_approval = '1', stts_approval_kep = '1' WHERE id_pemeliharaan = '$id_pemeliharaan' ");
        $hasil2 = $this->db->query("UPDATE tbl_pengadaan_aset SET stts_pemeliharaan = '1' WHERE id_brg = '$id_brg' ");
        $hasil3 = $this->db->query("DELETE FROM tbl_matriks_nilai WHERE id_brg = '$id_brg'");

        if ($hasil1 && $hasil2 && $hasil3) {
            if ($this->db->affected_rows() > 0) {
                $menu        = 'Pemeliharaan Aset';
                $aksi        = 'Update dan Delete';
                $item        = 'Mengupdate status dan menghapus data matriksnya';
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
        return $this->db->query("SELECT * FROM tbl_pemeliharaan_aset WHERE stts_approval_kep = '2' AND stts_approval IN ('2', '4', '6') ORDER BY id_pemeliharaan DESC")->result_array();
    }

    function pemeliharaan_selesai_in($id_pemeliharaan, $id_brg)
    {
        $hasil1 = $this->db->query("UPDATE tbl_pemeliharaan_aset SET stts_approval = '4' WHERE id_pemeliharaan = '$id_pemeliharaan' ");
        $hasil2 = $this->db->query("UPDATE tbl_pengadaan_aset SET stts_pemeliharaan = '3' WHERE id_brg = '$id_brg' ");

        if ($hasil1 && $hasil2) {
            if ($this->db->affected_rows() > 0) {
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
        return $this->db->query("SELECT * FROM tbl_pemeliharaan_aset WHERE stts_approval_kep = '2' AND stts_approval IN ('3', '5', '7') ORDER BY id_pemeliharaan DESC")->result_array();
    }

    function get_pemeliharaan_aset_external_kep()
    {
        return $this->db->query(
            "SELECT 
                a.id_pemeliharaan, a.id_brg, a.kd_brg, a.nm_brg, a.no_reg, a.kondisi_brg,
                a.harga, a.umr_ekonomis, a.merk_type, a.nli_sisa, a.stts_approval, a.stts_approval_kep, b.thn_beli, a.ket,
                (a.umr_ekonomis - (DATE_FORMAT(NOW(), '%Y') - b.thn_beli)) AS sisa_umr_ekonomis,
                ((b.harga - b.nli_sisa) / b.umr_ekonomis) AS nil_bku
            FROM tbl_pemeliharaan_aset a
            LEFT JOIN tbl_pengadaan_aset b ON b.id_brg = a.id_brg
            WHERE stts_approval IN ('3', '5', '7')
            ORDER BY a.entry_date"
        )->result_array();
    }

    function pemeliharaan_selesai_ex($id_pemeliharaan, $id_brg)
    {
        $hasil1 = $this->db->query("UPDATE tbl_pemeliharaan_aset SET stts_approval = '5' WHERE id_pemeliharaan = '$id_pemeliharaan' ");
        $hasil2 = $this->db->query("UPDATE tbl_pengadaan_aset SET stts_pemeliharaan = '3' WHERE id_brg = '$id_brg' ");

        if ($hasil1 && $hasil2) {
            if ($this->db->affected_rows() > 0) {
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

    function print_pemeliharaan_aset_ex($tgl_awal, $tgl_akhir, $kategori)
    {
        if ($tgl_awal == "" and $tgl_akhir == "") {
            if ($kategori == 1) {
                $stts_approval = "stts_approval IN ('2','3')";
            } else if ($kategori == 2) {
                $stts_approval = "stts_approval = '2'";
            } else if ($kategori == 3) {
                $stts_approval = "stts_approval = '3' AND stts_approval_kep = '2'";
            } else {
                $stts_approval = "stts_approval IN ('2','3')";
            }

            $data = $this->db->query(
                "SELECT 
                    a.kd_brg, a.no_reg, a.nm_brg, a.kondisi_brg, a.harga, a.umr_ekonomis, a.merk_type, a.nli_sisa, a.ket,
                    b.st_stfkt_no, b.bahan, b.perolehan, b.thn_beli, b.satuan_brg,
                    (
                        SELECT COUNT(jmlh_brg) FROM tbl_pengadaan_aset WHERE kd_brg = a.kd_brg AND stts_pemeliharaan = '2'
                    ) AS jmlh_brg
                FROM 
                    tbl_pemeliharaan_aset a
                    LEFT JOIN tbl_pengadaan_aset b ON b.id_brg = a.id_brg
                WHERE 
                    $stts_approval
                GROUP BY a.kd_brg"
            )->result_array();
        } else {
            if ($kategori == 1) {
                $stts_approval = "AND stts_approval IN ('2','3')";
            } else if ($kategori == 2) {
                $stts_approval = "AND stts_approval = '2'";
            } else if ($kategori == 3) {
                $stts_approval = "AND stts_approval = '3' AND stts_approval_kep = '2'";
            } else {
                $stts_approval = "AND stts_approval IN ('2','3')";
            }

            $data = $this->db->query(
                "SELECT 
                    a.kd_brg, a.no_reg, a.nm_brg, a.kondisi_brg, a.harga, a.umr_ekonomis, a.merk_type, a.nli_sisa, a.ket,
                    b.st_stfkt_no, b.bahan, b.perolehan, b.thn_beli, b.satuan_brg,
                    (
                        SELECT COUNT(jmlh_brg) FROM tbl_pengadaan_aset WHERE kd_brg = a.kd_brg AND stts_pemeliharaan = '2'
                    ) AS jmlh_brg
                FROM 
                    tbl_pemeliharaan_aset a
                    LEFT JOIN tbl_pengadaan_aset b ON b.id_brg = a.id_brg
                WHERE 
                    date(a.entry_date) BETWEEN date('$tgl_awal') AND date('$tgl_akhir')
                    $stts_approval
                GROUP BY a.kd_brg"
            )->result_array();
        }

        if ($data) {
            return $data;
        } else {
            return 0;
        }
    }

    function get_pemeliharaan_aset()
    {
        return $this->db->query(
            "SELECT 
                a.kd_brg, a.no_reg, a.nm_brg, a.kondisi_brg, a.harga, a.umr_ekonomis, a.merk_type, a.nli_sisa, a.ket,
                b.st_stfkt_no, b.bahan, b.perolehan, b.thn_beli, b.satuan_brg, 
                (
                    SELECT COUNT(jmlh_brg) FROM tbl_pengadaan_aset WHERE kd_brg = a.kd_brg AND stts_pemeliharaan = '2'
                ) AS jmlh_brg
            FROM 
                tbl_pemeliharaan_aset a
                LEFT JOIN tbl_pengadaan_aset b ON b.id_brg = a.id_brg
            WHERE 
                stts_approval IN ('2','3')
                AND stts_approval_kep = '2'
            GROUP BY a.kd_brg"
        )->result_array();
    }
}
