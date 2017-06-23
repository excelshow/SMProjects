<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Xmlrpc_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // 查询 user 信息 //////////////////////////////////
    function get_staff_address($limit = 0, $offset = 0, $condition = "") {
        $this->db->select('*');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_main');
         $this->db->join('staff_address', "staff_address.itname = staff_main.itname");
         $this->db->join('staff_dept', "staff_dept.id = staff_main.rootId");
        $this->db->order_by("staff_main.itname", 'asc');
        $query = $this->db->get();
        return $query->result();
    }

     
}