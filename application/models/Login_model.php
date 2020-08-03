<?php 

class Login_model extends CI_Model {
    
    function login($username,$password)
    {
        $get = $this->db->get_where('app_user',array('username'=>$username,'password'=>$password));

        foreach ($get->result_array() as $q)
        {
            $this->session->set_userdata('user_id', $q['user_id']);
            $this->session->set_userdata('username', $q['username']);
            $this->session->set_userdata('nama_pegawai', $q['nama_pegawai']);
            $this->session->set_userdata('ktp', $q['ktp']);
            $this->session->set_userdata('nik', $q['nik']);
            $this->session->set_userdata('role', $q['role']);
            $this->session->set_userdata('genre', $q['genre']);
            $this->session->set_userdata('image', $q['image']);
            $valid = $q['valid'];
        }

        if($valid==1) 
        {
            $row = $get->row_array();
            if ($get->num_rows() > 0)
            {
                date_default_timezone_set('Asia/Jakarta');

                $date = date("Y/m/d H:i:s");  
                $data = array('tgl' => $date, 'status' => 1);

                $this->db->where('username', $username);
                $this->db->update('app_user', $data);

                if($this->db->affected_rows() > 0)
                {
                    $item        = '';
                    $assign_to   = 'dashboard';
                    $assign_type = '';
                    activity_log("login", "masuk", $item, $assign_to, $assign_type);
                    return $row['role'];
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    function logout($username)
    {
        $username = $this->session->userdata('username');
        $this->db->set('status', 0);
        $this->db->where('username', $username);
        $this->db->update('app_user');

        if($this->db->affected_rows() > 0)
        {
            $item        = '';
            $assign_to   = '';
            $assign_type = '';
            activity_log("logout", "keluar", $item, $assign_to, $assign_type);
            return true;
        }
        else
        {
            return false;
        }
    }

    function get_login($id)
    {
        return $this->db->query("SELECT * FROM app_user WHERE user_id='$id' GROUP BY user_id='$id'")->result_array();
    }

    function total_aset()
    {
        return $this->db->query("SELECT COUNT(id_brg) AS id FROM tbl_pengadaan_aset")->result_array();
    }

    function get_jns_brg()
    {
        return $this->db->query("SELECT jns_brg, COUNT(jns_brg) AS tot FROM tbl_pengadaan_aset GROUP BY jns_brg")->result_array();
    }

    function get_stts()
    {
        return $this->db->query(
            "SELECT 
                MAX(id_usulan) AS max_id,
                (SELECT COUNT(stts_approval_kep) FROM tbl_usulan_aset WHERE stts_approval_kep = '1') AS pending,
                (SELECT COUNT(stts_approval_kep) FROM tbl_usulan_aset WHERE stts_approval_kep = '2') AS diterima,
                (SELECT COUNT(stts_approval_kep) FROM tbl_usulan_aset WHERE stts_approval_kep = '3') AS ditolak
            FROM tbl_usulan_aset"
        )->result_array();
    }

    function get_peminjaman_aset()
    {
        return $this->db->query(
            "SELECT COUNT(id_peminjaman) AS dipinjam FROM tbl_peminjaman_aset WHERE stts_peminjaman = '1'"
        )->result_array();
    }

    function get_pengembalian_aset()
    {
        return $this->db->query(
            "SELECT COUNT(id_peminjaman) AS dikembalikan FROM tbl_peminjaman_aset WHERE stts_peminjaman = '2'"
        )->result_array();
    }

    function get_dt_aset()
    {
        return $this->db->query(
            "SELECT
                (SELECT COUNT(kondisi) FROM tbl_pengadaan_aset WHERE kondisi = '1' ) AS tot_aset_b,
                (SELECT COUNT(kondisi) FROM tbl_pengadaan_aset WHERE kondisi = '2' ) AS tot_aset_rr,
                (SELECT COUNT(kondisi) FROM tbl_pengadaan_aset WHERE kondisi = '3' ) AS tot_aset_rb,
                (SELECT COUNT(stts_approval) FROM tbl_pemeliharaan_aset WHERE stts_approval = '2') AS tot_pemeliharaan_in,
                (SELECT COUNT(stts_approval) FROM tbl_pemeliharaan_aset WHERE stts_approval = '3') AS tot_pemeliharaan_ex,
                (SELECT COUNT(stts_approval) FROM tbl_pemeliharaan_aset WHERE stts_approval = '4') AS tot_pemeliharaan_selesai_in,
                (SELECT COUNT(stts_approval) FROM tbl_pemeliharaan_aset WHERE stts_approval = '5') AS tot_pemeliharaan_selesai_ex,
                (SELECT COUNT(stts_penghapusan) FROM tbl_pengadaan_aset WHERE stts_penghapusan = '3' ) AS tot_penghapusan
            FROM 
                tbl_pengadaan_aset
            GROUP BY 
                tot_aset_b, tot_aset_rr, tot_aset_rb, tot_pemeliharaan_in, tot_pemeliharaan_ex, 
                tot_pemeliharaan_selesai_in, tot_pemeliharaan_selesai_ex, tot_penghapusan"
        )->result_array();
    }

}

?>