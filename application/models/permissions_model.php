<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Permissions_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_staffs($limit = 0, $offset = 0, $condition = "") {
        $this->db->select('*');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_main');
        $this->db->order_by("staff_main.itname", 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function get_staffs_top($limit = 0, $offset = 0, $condition = "") {

        $this->db->select('*');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff');
        $this->db->join('menu', "menu.id = staff.classId");
        $this->db->order_by("staff.post_time", 'desc');
        $query = $this->db->get();
        return $query->first_row();
    }

    function get_staffs_oa_top($condition = "") {
        $this->db->select('*');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_system_oa');
        $query = $this->db->get();
        return $query->first_row();
    }

    function get_staffs_oa_list($condition = "") {
        $this->db->select('*');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_system_oa');
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

    function get_system_by($condition = "") {
        $this->db->select('*');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_system');
        $query = $this->db->get();
        return $query->row();
    }

    function add($data) {
        date_default_timezone_set("PRC");
        if ($this->db->insert("staff_main", $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function edit($data) {
        $id = $data['id'];
        date_default_timezone_set("PRC");
        $data['modifytime'] = date("Y-m-d H:i:s");
        $this->db->where('id', $id);

        if ($this->db->update('staff_main', $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function editTemp($data) {
        $sm_id = $data['sm_id'];
        // print_r($data);
        date_default_timezone_set("PRC");

        $this->db->where('sm_id', $sm_id);
        // $data = array_shift($data);
        if ($this->db->update('staff_sms', $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function del($data) {
        $this->db->where_in('id', $data);
        $query = $this->db->delete('staff_main');
        return true;
    }

    function multi_del($data) {
        $this->db->where_in('staff_id', $data);
        if ($this->db->update('staff', array('is_del' => 1))) {
            return true;
        } else {
            return false;
        }
    }

    function physical_del($data) {
        $this->db->where_in('staff_id', $data);
        $query = $this->db->delete('staff');
        //$this->db->where_in('staff_id',$data);
        //$query = $this->db->delete('attachment');
        return true;
    }

    function recover($data) {
        $this->db->where_in('staff_id', $data);
        if ($this->db->update('staff', array('is_del' => 0))) {
            return true;
        } else {
            return false;
        }
    }

    /////////////////////////////////////////api   ////////////////////////////////
    // 导入数据专用
    function get_temps($limit = 0, $offset = 0, $condition = "") {
        $this->db->select('*');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_sms');
        $query = $this->db->get();
        return $query->result();
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

/////////////////////////////
    function get_dg_quarters($condition = "") {
        $this->db->select('*');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('dg_quarters');
        $this->db->order_by("quarters_id", 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    /////////////////////////////
    function get_dg_quarters_row($condition = "") {
        $this->db->select('*');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('dg_quarters');
        $this->db->order_by("quarters_id", 'asc');
        $query = $this->db->get();
        return $query->row();
    }

    function dg_quarters_add($data) {
        date_default_timezone_set("PRC");
        if ($this->db->insert("dg_quarters", $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function dg_quarters_edit($data) {
        $quarters_id = $data['quarters_id'];
        date_default_timezone_set("PRC");
        $this->db->where('quarters_id', $quarters_id);
        if ($this->db->update('dg_quarters', $data)) {
            return "ok";
        } else {
            return false;
        }
    }

/////////////////////////////
    function get_dg_doctype($condition = "") {
        $this->db->select('*');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('dg_doctype');
        $this->db->order_by("doctype_id", 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    /////////////////////////////
    function get_dg_doctype_row($condition = "") {
        $this->db->select('*');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('dg_doctype');
        $this->db->order_by("doctype_id", 'asc');
        $query = $this->db->get();
        return $query->row();
    }

    function dg_doctype_add($data) {
        date_default_timezone_set("PRC");
        if ($this->db->insert("dg_doctype", $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function dg_doctype_edit($data) {
        $quarters_id = $data['doctype_id'];
        date_default_timezone_set("PRC");
        $this->db->where('doctype_id', $doctype_id);
        if ($this->db->update('dg_doctype', $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    //////////////////////////////////
    function staff_dg_row($condition = "") {
        $this->db->select('*');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_dg');
        $query = $this->db->get();
        return $query->row();
    }

    function staff_dg_add($data) {
        date_default_timezone_set("PRC");
        if ($this->db->insert("staff_dg", $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function staff_dg_edit($data) {
        $itname = $data['itname'];
        date_default_timezone_set("PRC");
        $this->db->where('itname', $itname);
        if ($this->db->update('staff_dg', $data)) {
            return "ok";
        } else {
            return false;
        }
    }

///
    function staff_dg_join_row($condition = "") {

        $this->db->select('dg_quarters.quarters_name');
        $this->db->select('dg_doctype.doctype_name');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_dg');
        $this->db->join('dg_quarters', "staff_dg.quarters_id = dg_quarters.quarters_id");
        $this->db->join('dg_doctype', "staff_dg.doctype_id = dg_doctype.doctype_id");
        $query = $this->db->get();
        return $query->first_row();
    }

}
