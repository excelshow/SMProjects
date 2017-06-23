<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Temp_model extends CI_Model {

    /////////////////////////////////////////api   ////////////////////////////////
    // 导入数据专用

    function __construct() {
        parent::__construct();
    }

    function get_all($limit = 0, $offset = 0, $condition = "") {
        $this->db->select('*');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_main');
        $query = $this->db->get();
        return $query->result();
    }
    function get_staff_by($condition = "") {
        $this->db->select('*');
       
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_main');
        $query = $this->db->get();
        return $query->row();
    }

    ////  获取 system code 
    function get_system_code($condition) {
        $this->db->select('*');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_system_code');
        $query = $this->db->get();
        return $query->row();
    }

    function upsystem_api($api) {
        if ($this->db->insert("staff_system_api", $api)) {
            return "ok";
        } else {
            return false;
        }
    }

}