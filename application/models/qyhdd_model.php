<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Qyhdd_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function qyh_dept_result($condition = "") {
        $this->db->select('*');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('qyh_dept');
        $query = $this->db->get();
        return $query->result();
    }

    function qyh_dept_row($condition = "") {
        $this->db->select('*');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('qyh_dept');
        $query = $this->db->get();
        return $query->row();
    }

    function qyh_dept_child_id($where = '') {
        global $str;
        $this->db->select('*');
        if ($where) {
            $this->db->where($where);
        } else {
            $this->db->where("qyh_parentid = 1");
        }

        $this->db->from('qyh_dept');
        $this->db->order_by('qyh_name', 'asc');
        $query = $this->db->get();
        $result = $query->result_array();
        $tempRows = $this->db->affected_rows();

        if ($result && $tempRows) {//如果有子类 
            // print_r($result);
            foreach ($result as $row) { //循环记录集 
                $str[] = $row['sd_id']; //构建字符串 
                $this->qyh_dept_child_id("qyh_parentid = " . $row['qyh_id']); //调用get_str()，将记录集中的id参数传入函数中，继续查询下级 
            }
        }
        return $str;
    }

    function qyh_staff_row($condition = "") {
        $this->db->select('*');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('qyh_staff');
        $this->db->order_by("qyh_staff.itname", 'asc');
        $query = $this->db->get();
        return $query->row();
    }

    function qyh_staffs_result($limit = 0, $offset = 0, $condition = "") {
        $this->db->select('*');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('qyh_staff');
        $this->db->order_by("qyh_staff.itname", 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function qyh_staffs_where_in($limit = 0, $offset = 0, $condition = "", $arr) {
        $this->db->select('* ');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        if ($arr) {
            $this->db->where_in('qyh_staff.qyh_id', $arr);
        }
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('qyh_staff');
        // $this->db->join('staff_main','staff_main.itname = qyh_staff.itname','INNER');
        $this->db->order_by("qyh_staff.itname", 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function qyh_dept_add($data) {
        date_default_timezone_set("PRC");
        if ($this->db->insert("qyh_dept", $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function qyh_dept_edit($sd_id, $data) {

        date_default_timezone_set("PRC");

        $this->db->where('sd_id', $sd_id);
        if ($this->db->update('qyh_dept', $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function qyh_dept_del($sd_id) {
        $this->db->where('sd_id', $sd_id);
        $this->db->delete('qyh_dept');
    }

    function qyh_staff_add($data) {
        date_default_timezone_set("PRC");
        if ($this->db->insert("qyh_staff", $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function qyh_staff_edit($itname, $data) {
        date_default_timezone_set("PRC");
        $this->db->where('itname', $itname);
        if ($this->db->update('qyh_staff', $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function qyh_staff_del($itname) {
        $this->db->where('itname', $itname);
        $this->db->delete('qyh_staff');
    }

    /*
     * DD model
     */

    function dd_dept_add($data) {
        date_default_timezone_set("PRC");
        if ($this->db->insert("qyh_dd_dept", $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function dd_dept_edit($sd_id, $data) {
        date_default_timezone_set("PRC");
        $this->db->where('sd_id', $sd_id);
        if ($this->db->update('qyh_dd_dept', $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function dd_dept_del($sd_id) {
        $this->db->where('sd_id', $sd_id);
        $this->db->delete('qyh_dd_dept');
    }

    function dd_dept_result($condition = "") {
        $this->db->select('*');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('qyh_dd_dept');
        $query = $this->db->get();
        return $query->result();
    }

    function dd_dept_row($condition = "") {
        $this->db->select('*');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('qyh_dd_dept');
        $query = $this->db->get();
        return $query->row();
    }

    function dd_staff_add($data) {
        date_default_timezone_set("PRC");
        if ($this->db->insert("qyh_dd_staff", $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function dd_staff_edit($itname, $data) {
        date_default_timezone_set("PRC");
        $this->db->where('itname', $itname);
        if ($this->db->update('qyh_dd_staff', $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function dd_staff_del($itname) {
        $this->db->where('itname', $itname);
        $this->db->delete('qyh_dd_staff');
    }

    function dd_staff_row($condition = "") {
        $this->db->select('*');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('qyh_dd_staff');
        $this->db->order_by("itname", 'asc');
        $query = $this->db->get();
        return $query->row();
    }

    function dd_staff_result($limit = 0, $offset = 0,$condition = "") {
        $this->db->select('*');
         if ($limit) {
            $this->db->limit($limit, $offset);
        }
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('qyh_dd_staff');
        $this->db->order_by("itname", 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function dd_dept_child_id($where = '') {
        global $str;
        $this->db->select('*');
        if ($where) {
            $this->db->where($where);
        } else {
            $this->db->where("dd_parentid = 6");
        }

        $this->db->from('qyh_dd_dept');
        $this->db->order_by('dd_name', 'asc');
        $query = $this->db->get();
        $result = $query->result_array();
        $tempRows = $this->db->affected_rows();

        if ($result && $tempRows) {//如果有子类 
            // print_r($result);
            foreach ($result as $row) { //循环记录集 
                $str[] = $row['sd_id']; //构建字符串 
                $this->dd_dept_child_id("dd_parentid = " . $row['dd_id']); //调用get_str()，将记录集中的id参数传入函数中，继续查询下级 
            }
        }
        return $str;
    }

    function get_dept_val($data) {
        $this->db->select('*');
        if ($data) {
            $this->db->where($data);
        }
        $this->db->from('staff_dept');
        $query = $this->db->get();
        return $query->row();
    }

    function curl_post($data, $url) {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, 'http://smbqq.sinaapp.com/testapi/smgapi/' . $url . '.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $file_contents = curl_exec($ch);
        curl_close($ch);
        return $file_contents;
    }

}
