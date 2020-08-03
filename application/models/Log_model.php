<?php

class Log_model extends CI_Model {

    function save_log($param)
    {
        $sql        = $this->db->insert_string('tbl_log',$param);
        $ex         = $this->db->query($sql);
        return $this->db->affected_rows($sql);
    }
}

?>