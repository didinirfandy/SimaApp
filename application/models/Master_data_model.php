<?php

class Master_data_model extends CI_Model
{

    // ----------------------- //
    //  Data usulan pengadaan  //
    // ----------------------- //
    function kd_usulan()
    {
        $this->db->select_max('kd_usulan');
        $hasil = $this->db->get('tbl_usulan_aset');
        foreach ($hasil->result_array() as $j) {
            $kode = 1 + $j['kd_usulan'];
        }
        return $kode;
    }

    function entry_usulan_pengadaan($tbl, $data, $nm_brg)
    {
        $insert = $this->db->insert($tbl, $data);
        if ($insert) {
            if ($this->db->affected_rows() > 0) {
                $menu        = 'Data usulan pengadaan';
                $aksi        = 'Menambah';
                $item        = $nm_brg;
                $assign_to   = 'Wakasek dan Kepsek';
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

    function get_kd_usulan($db, $kd_usulan)
    {
        return $this->db->get_where($db, array('kd_usulan' => $kd_usulan));
    }

    function get_usulan_pengadaan($db, $kd_usulan)
    {
        return $this->db->get_where($db, array('kd_usulan' => $kd_usulan))->result_array();
    }

    function del_usulan_pengadaan($db, $id_usulan)
    {
        $data = $this->db->get_where($db, array('id_usulan' => $id_usulan))->result_array();
        if ($this->db->affected_rows() > 0) {
            $menu        = 'data usulan pengadaan';
            $aksi        = 'menghapus';
            $item        = $data[0]["nm_brg"];
            $assign_to   = '';
            $assign_type = '';
            activity_log($menu, $aksi, $item, $assign_to, $assign_type);
            return $this->db->delete($db, array('id_usulan' => $id_usulan));
        } else {
            return false;
        }
    }

    function get_kode_aset($db)
    {
        return $this->db->get($db)->result_array();
    }


    // ----------------------- //
    //      Data pengadaan     //
    // ----------------------- //
    function entry_pengadaan($db, $data, $nm_brg, $id_usulan)
    {
        $insert = $this->db->insert_batch($db, $data);

        if ($insert) {
            if ($this->db->affected_rows() > 0) {
                $menu        = 'data pengadaan';
                $aksi        = 'menambah';
                $item        = $nm_brg;
                $assign_to   = '';
                $assign_type = '';
                activity_log($menu, $aksi, $item, $assign_to, $assign_type);

                $this->db->query("UPDATE tbl_usulan_aset SET stts_pengadaan = '3' WHERE id_usulan = '$id_usulan' ");

                return 1;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    function get_no_req($kd_brg)
    {
        $hasil = $this->db->query("SELECT MAX(no_reg)+1 AS no_reg FROM tbl_pengadaan_aset WHERE kd_brg = '$kd_brg'")->result_array();
        $kode = $hasil[0]['no_reg'];
        // foreach ($hasil->result_array() as $j) {

        // }
        return $kode;
    }

    function get_pengadaan()
    {
        return $this->db->query(
            "SELECT 
                id_brg, kd_brg, nm_brg, no_reg, merk_type, ukuran_cc, perolehan, bahan,
                thn_beli, umr_ekonomis, nli_sisa, kondisi, satuan_brg, dipinjam, penyusutan
            FROM tbl_pengadaan_aset ORDER BY entry_date DESC"
        )->result_array();
    }

    function update_pengadaan($id, $value, $modul)
    {
        $data = $this->db->get_where("tbl_pengadaan_aset", array('id_brg' => $id))->result_array();
        if ($this->db->affected_rows() > 0) {
            $menu        = 'Data pengadaan';
            $aksi        = 'mengubah';
            $item        = $data[0]["nm_brg"] . " mengubah " . $modul . " " . $data[0][$modul] . " menjadi " . $value;
            $assign_to   = '';
            $assign_type = '';
            activity_log($menu, $aksi, $item, $assign_to, $assign_type);

            $this->db->where(array("id_brg" => $id));
            $this->db->update("tbl_pengadaan_aset", array($modul => $value));

            return true;
        } else {
            return false;
        }
    }

    function delete_pengadaan($id)
    {
        $this->db->where("id_brg", $id);
        $this->db->delete("tbl_pengadaan_aset");
        if ($this->db->affected_rows() > 0) {
            $menu        = 'Data pengadaan';
            $aksi        = 'Menghapus';
            $item        = 'Menghapus data pengadaan';
            $assign_to   = '';
            $assign_type = '';
            activity_log($menu, $aksi, $item, $assign_to, $assign_type);
            return true;
        } else {
            return false;
        }
    }

    function get_usulan_jns($db, $jns_brg)
    {
        return $this->db->get_where($db, array('jns_brg' => $jns_brg, 'stts_approval_kep' => '2'))->result_array();
    }

    function del_pengadaan($db, $id_brg)
    {
        $data = $this->db->get_where($db, array('id_brg' => $id_brg))->result_array();
        if ($this->db->affected_rows() > 0) {
            $menu        = 'data pengadaan';
            $aksi        = 'menghapus';
            $item        = $data[0]["nm_brg"];
            $assign_to   = '';
            $assign_type = '';
            activity_log($menu, $aksi, $item, $assign_to, $assign_type);
            return $this->db->delete($db, array('id_brg' => $id_brg));
        } else {
            return false;
        }
    }


    // ----------------------- //
    //      Data peminjaman    //
    // ----------------------- //
    function kd_peminjaman()
    {
        $this->db->select_max('kd_peminjaman');
        $hasil = $this->db->get('tbl_peminjaman_aset');
        foreach ($hasil->result_array() as $j) {
            $kode = 1 + $j['kd_peminjaman'];
        }
        return $kode;
    }

    function get_kd_peminjaman($db, $kd_peminjaman)
    {
        return $this->db->get_where($db, array('kd_peminjaman' => $kd_peminjaman));
    }

    function get_peminjaman($db, $kd_peminjaman)
    {
        return $this->db->get_where($db, array('kd_peminjaman' => $kd_peminjaman))->result_array();
    }

    function get_dt_pengadaan()
    {
        return $this->db->query(
            "SELECT 
                id_brg, kd_brg, no_reg, nm_brg, merk_type, kondisi, dipinjam 
            FROM 
                tbl_pengadaan_aset 
            WHERE dipinjam = '1'"
        )->result_array();
    }

    function get_dt_peminjaman($kd_peminjaman)
    {
        return $this->db->query(
            "SELECT 
                id_peminjaman, nm_peminjaman, nohp_peminjaman, kd_brg, nm_brg
            FROM tbl_peminjaman_aset 
            WHERE kd_peminjaman='$kd_peminjaman'"
        )->result_array();
    }

    function get_dt_pinjam()
    {
        return $this->db->query(
            "SELECT 
                id_peminjaman, id_brg, nm_peminjaman, nohp_peminjaman, tgl_peminjaman, 
                tgl_pengembalian, realisasi_pengembalian, stts_peminjaman, kd_brg, nm_brg, ket
            FROM tbl_peminjaman_aset"
        )->result_array();
    }

    function entry_peminjaman($db, $data, $nm_peminjaman)
    {
        $insert = $this->db->insert($db, $data);
        if ($insert) {
            if ($this->db->affected_rows() > 0) {
                $menu        = 'data peminjaman';
                $aksi        = 'menambah';
                $item        = $nm_peminjaman;
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

    function delete_peminjaman($db, $id_peminjaman)
    {
        $data = $this->db->get_where($db, array('id_peminjaman' => $id_peminjaman))->result_array();
        if ($this->db->affected_rows() > 0) {
            $menu        = 'data peminjaman';
            $aksi        = 'menghapus';
            $item        = $data[0]["nm_peminjaman"];
            $assign_to   = '';
            $assign_type = '';
            activity_log($menu, $aksi, $item, $assign_to, $assign_type);
            return $this->db->delete($db, array('id_peminjaman' => $id_peminjaman));
        } else {
            return false;
        }
    }

    function update_pengembalian($id_peminjaman, $id_brg, $realisasi_pengembalian, $kondisi)
    {
        if ($this->db->affected_rows() > 0) {
            $menu        = 'data peminjaman';
            $aksi        = 'Mengubah';
            $item        = 'Mengubah tanggal realisasi pengembalian menjadi ' . $realisasi_pengembalian . '';
            $assign_to   = '';
            $assign_type = '';
            activity_log($menu, $aksi, $item, $assign_to, $assign_type);

            $up1 = $this->db->query("UPDATE tbl_peminjaman_aset SET realisasi_pengembalian = '$realisasi_pengembalian', stts_peminjaman = '2' WHERE id_peminjaman = '$id_peminjaman'");
            $up2 = $this->db->query("UPDATE tbl_pengadaan_aset SET kondisi = '$kondisi' WHERE id_brg = '$id_brg'");

            if ($up1 && $up2) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return false;
        }
    }
}
