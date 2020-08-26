<?php

class Penghapusan_aset_model extends CI_Model
{
    function get_dt_pemeliharaan_aset()
    {
        // return $this->db->query("SELECT * FROM tbl_pemeliharaan_aset WHERE stts_approval IN ('4', '5') ")->result_array();
        return $this->db->query("SELECT * FROM tbl_pemeliharaan_aset")->result_array();
    }

    function get_matriks_nilai_while()
    {
        return $this->db->query(
            "SELECT 
                *
            FROM 
                tbl_matriks_nilai_while 
            ORDER BY 
                id_matriks ASC"
        )->result_array();
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
            FROM tbl_matriks_nilai_while"
        )->result_array();
    }

    function hapus_data_matriks_sementara()
    {
        $data = $this->db->query("DELETE FROM tbl_matriks_nilai_while");

        if ($data) {
            return 1;
        } else {
            return 0;
        }
        
    }

    function update_stts_matriks($id_brg)
    {
        foreach ($id_brg as $i) {
            $data1 = array('status' => '3');
            $data2 = array('stts_pemeliharaan' => '4', 'stts_penghapusan' => '2');
            $hsl1 = $this->db->update("tbl_matriks_nilai", $data1, array('id_brg' => $i));
            $hsl2 = $this->db->update("tbl_pengadaan_aset", $data2, array('id_brg' => $i));
        }
        
        if ($hsl1 && $hsl2) {
            if ($this->db->affected_rows() > 0) {
                $menu        = 'Rekomendasi Penghapusan';
                $aksi        = 'Mengubah';
                $item        = 'Mengubah Status yang telah di lakukan perengkingan';
                $assign_to   = '';
                $assign_type = 'Aset';
                activity_log($menu, $aksi, $item, $assign_to, $assign_type);
                return 1;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    function input_data_matriks($id_matriks)
    {
        $get = $this->db->get_where('tbl_matriks_nilai', array('id_matriks' => $id_matriks))->result_array();

        $id_matriks   = $get[0]['id_matriks'];
        $id_barang    = $get[0]['id_brg'];
        $kd_brg       = $get[0]['kd_brg'];
        $kd_matriks   = $get[0]['kd_matriks'];
        $nm_brg       = $get[0]['nm_brg'];
        $no_reg       = $get[0]['no_reg'];
        $kondisi_brg  = $get[0]['kondisi_brg'];
        $nilai_buku   = $get[0]['nilai_buku'];
        $sisa_umr_eko = $get[0]['sisa_umr_ekonomis'];

        $data = array(
            'id_matriks' => $id_matriks,
            'id_brg' => $id_barang,
            'kd_brg' => $kd_brg,
            'kd_matriks' => $kd_matriks,
            'nm_brg' => $nm_brg,
            'no_reg' => $no_reg,
            'kondisi_brg' => $kondisi_brg,
            'nilai_buku' => $nilai_buku,
            'sisa_umr_ekonomis' => $sisa_umr_eko
        );

        $hsl1 = $this->db->insert('tbl_matriks_nilai_while', $data);
        $hsl2 = $this->db->query("UPDATE tbl_matriks_nilai SET status='2' WHERE id_matriks = '$id_matriks' ");

        if ($hsl1 && $hsl2) {
            if ($this->db->affected_rows() > 0) {
                $menu        = 'Rekomendasi Penghapusan';
                $aksi        = 'Menginput';
                $item        = 'Memasukan data ke tabel sementara';
                $assign_to   = '';
                $assign_type = 'Aset';
                activity_log($menu, $aksi, $item, $assign_to, $assign_type);
                return 1;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
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
        $hsl = $this->db->insert_batch($db, $data);
        if($hsl){
            return 1;
        } else {
            return 0;
        }
    }

    function get_rengking()
    {
        return $this->db->query("SELECT * FROM tbl_rengking GROUP BY kd_rengking DESC")->result_array();
    }

    function get_rengking_kd($kd_rengking)
    {
        return $this->db->query("SELECT * FROM tbl_rengking WHERE kd_rengking = '$kd_rengking' ORDER BY rangking ASC")->result_array();
    }

    function delete_data_matriks($id_matriks)
    {
        $hsl1 = $this->db->delete('tbl_matriks_nilai_while', array('id_matriks' => $id_matriks)); 
        $hsl2 = $this->db->query("UPDATE `tbl_matriks_nilai` SET `status` ='1' WHERE id_matriks = '$id_matriks' ");

        if ($hsl1 && $hsl2) {
            if ($this->db->affected_rows() > 0) {
                $menu        = 'Rekomendasi Penghapusan';
                $aksi        = 'Hapus';
                $item        = 'Menghapus data yang dipilih untuk melakukan perhitungan rangking';
                $assign_to   = '';
                $assign_type = 'Aset';
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