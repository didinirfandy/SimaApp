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

}

?>