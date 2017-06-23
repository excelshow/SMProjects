<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tongxun_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function address_rose_result($condition = "") {
        $this->db->select('*');

        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_address_rose');
        $this->db->order_by("sar_id", 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function publicResult($condition = "") {
        $this->db->select('*');

        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_address_public');
        $this->db->order_by("sap_sort", 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function publicRow($condition = "") {
        $this->db->select('*');

        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_address_public');
        $this->db->order_by("sap_sort", 'asc');
        $query = $this->db->get();
        return $query->row();
    }

    function publicEdit($id, $data) {
        date_default_timezone_set("PRC");
        $this->db->where('sap_id', $id);
        if ($this->db->update('staff_address_public', $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function publicInster($data) {
        date_default_timezone_set("PRC");
        if ($this->db->insert("staff_address_public", $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function get_staffs_where_in($limit = 0, $offset = 0, $condition = "", $arr) {
        $this->db->select('*');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        if ($arr) {
            $this->db->where_in('rootId', $arr);
        }
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_main');
        $this->db->order_by("staff_main.rootId,staff_main.itname", 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function get_staffs_limit($limit = 0, $offset = 0, $condition = "") {
        $this->db->select('*');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }

        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_address');
        $this->db->order_by("itname", 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function get_staffs_top($condition = "") {

        $this->db->select('*');

        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_main');
        $this->db->order_by("staff_main.rootId,staff_main.itname", 'asc');
        $query = $this->db->get();
        return $query->first_row();
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

    function staffs_addree_result($condition = "") {

        $this->db->select('*');

        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_address');
        $this->db->order_by("itname", 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function staffs_addree_row($condition = "") {

        $this->db->select('*');

        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_address');
        $this->db->order_by("itname", 'desc');
        $query = $this->db->get();
        return $query->row();
    }

    function dept_get_all($limit = 0, $offset = 0, $condition = '') {
        $this->db->select('*');
        if ($condition) {
            $this->db->where($condition);
        }
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->from('staff_dept');
        $this->db->order_by("sortBy", 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function staff_dept_by($condition = "") {

        $this->db->select('staff_main.*');
        $this->db->select('staff_dept.*');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_main');
        $this->db->join('staff_dept', 'staff_main.rootid = staff_dept.id', 'inner');
        $query = $this->db->get();
        return $query->row();
    }

    function get_num_rows($condition = "") {
        if ($condition)
            $this->db->where($condition);
        return $this->db->count_all_results('staff_main');
    }

    function get_system_num_rows($condition = "") {
        if ($condition)
            $this->db->where($condition);
        return $this->db->count_all_results('staff_system');
    }

    function get_systems($limit = 0, $offset = 0, $condition = "") {
        $this->db->select('*');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_system');
        $this->db->order_by("staff_system.sortBy", 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function get_staffs_jason() {
        $this->db->select('staff_main.itname,staff_main.cname,staff_main.station');
        $this->db->select('staff_dept.deptName,staff_dept.id');
        $this->db->from('staff_main');
        $this->db->join('staff_dept', "staff_dept.id = staff_main.rootid");
        $this->db->order_by("staff_main.itname", 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function add($data) {
        date_default_timezone_set("PRC");
        if ($this->db->insert("staff_main", $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function insert_address($data) {
        date_default_timezone_set("PRC");
        if ($this->db->insert("staff_address", $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function edit_address($data) {
        $itname = $data['itname'];
        $this->db->where('itname', $itname);
        if ($this->db->update('staff_address', $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function insert_address_log($data) {
        date_default_timezone_set("PRC");
        if ($this->db->insert("staff_address_log", $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function del_address($data) {
        $this->db->where_in('itname', $data);
        $query = $this->db->delete('staff_address');
        return true;
    }

    function del_public($data) {
        $this->db->where_in('sap_id', $data);
        $query = $this->db->delete('staff_address_public');
        return true;
    }

}
