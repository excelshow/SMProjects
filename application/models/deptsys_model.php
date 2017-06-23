<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Deptsys_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_deptall($limit = 0, $offset = 0) {
        $this->db->select('*');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->from('staff_dept');
        $this->db->order_by("sortBy", 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function get_deptall_result($limit = 0, $offset = 0, $where) {
        $this->db->select('*');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        if ($where) {
            $this->db->where($where);
        }
        $this->db->from('staff_dept');
        $this->db->order_by("sortBy", 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function get_deptall_result_scrap($limit = 0, $offset = 0, $where) {
        $this->db->select('*');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        if ($where) {
            $this->db->where($where);
        }
        $this->db->from('staff_dept_scrap');
        $this->db->order_by("sortBy", 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function get_dept_temp() {
        $this->db->select('*');

        $this->db->from('staff_dept');
        $query = $this->db->get();
        return $query->result();
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

    function truncate_formAd() {
        $this->db->truncate('staff_dept');
    }

    function get_dept_child_list($where, $limit = 0, $offset = 0) {
        $this->db->distinct();
        $this->db->select('staff_dept.*');
        $this->db->select('staff_dept_type.*');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->where($where);
        $this->db->from('staff_dept');
        $this->db->join('staff_dept_type', 'staff_dept_type.dt_id = staff_dept.dt_id', 'inner');
        $this->db->order_by("staff_dept.sortBy", 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function get_dept_child_DN($where) {
        $arr = $this->get_dept_child_DN_tree($where);
        if ($arr) {
            $arrDn[] = $arr->deptName;
            if ($arr->root > 0) {
                $rootId = $arr->root;
                //echo $rootId.'=rootId';
                do {
                    $query = $this->get_dept_child_DN_tree('id = ' . $rootId);
                    $rootId = $query->root;
                    $arrDn[] = $query->deptName;
                    // echo $rootId.'=rootId';
                } while ($rootId > 0);
                // return $arrDn;
            }
            return array_reverse($arrDn); // 排序
        } else {
            return FALSE;
        }
    }

    function get_dept_parent_ou($where) {
        $arr = $this->get_dept_child_DN_tree($where);
        $arrDn = array();
        if ($arr) {
            $rootId = $arr->root;
            $dt_id = $arr->dt_id;
            if ($dt_id > 5) {
                if ($arr->root > 0) {              //&& 
                    //echo $rootId.'=rootId';
                    do {
                        $query = $this->get_dept_child_DN_tree('id = ' . $rootId);
                        if ($query) {
                            $rootId = $query->root;
                            $dt_id = $query->dt_id;
                            $arrDn[] = array('deptName' => $query->deptName, 'deptId' => $query->id);
                        } else {
                            $arrDn[] = array('deptName' => '无部门', 0);
                        }
                        // echo $rootId.'=rootId';
                    } while ($rootId > 0 && $dt_id > 5);
                    // return $arrDn;
                }
                return array_reverse($arrDn); // 排序
            } else {
                if ($arr->root > 0) {              //&& 
                    //echo $rootId.'=rootId';
                    $arrDn[] = array('deptName' => $arr->deptName, 'deptId' => $arr->id);
                    // echo $rootId.'=rootId';
                }
                return $arrDn; // 排序
            }
        } else {
            return FALSE;
        }
    }

    function get_dept_child_DN_tree($where) {
        $this->db->select('*');
        $this->db->where($where);
        $this->db->from('staff_dept');
        $query = $this->db->get()->row();

        if ($query) {
            $arrDn[] = $query->deptName;
            return $query;
            // echo $query->deptName;
//            if ($query->root > 0) {
//              $this->get_dept_child_DN_tree('id = ' . $query->root,$arrDn);
//               // return $arrDn;
//            }
        } else {
            return FALSE;
        }
        // return $arrDn;
    }

    function get_child_num($classid) {
        $query = $this->db->query("select count(*) as children from staff_dept where root='$classid'");
        foreach ($query->result() as $row) {
            return $row->children;
        }
    }

    function get_in_tree($array, $pid = 0, $y, &$tdata = array()) {
        foreach ($array as $row) {
            if ($row->root == $pid) {
                $n = $y + 1;
                $row->deep = $y;
                $tdata[] = $row;
                $this->get_in_tree($array, $row->id, $n, $tdata);
            }
        }
        return $tdata;
    }

    function get_dept_child_id($where = '') {
        global $str;
        $this->db->select('*');
        if ($where) {
            $this->db->where($where);
        } else {
            $this->db->where("root = 0");
        }

        $this->db->from('staff_dept');
        $this->db->order_by('sortBy', 'asc');
        $query = $this->db->get();
        $result = $query->result_array();
        $tempRows = $this->db->affected_rows();

        if ($result && $tempRows) {//如果有子类 
            // print_r($result);
            foreach ($result as $row) { //循环记录集 
                $str[] = $row['id']; //构建字符串 
                $this->get_dept_child_id("root = " . $row['id']); //调用get_str()，将记录集中的id参数传入函数中，继续查询下级 
            }
        }
        return $str;
    }

    function get_dept() {
        return $this->get_in_tree($this->get_deptall(), 0, 0);
    }

    function get_dept_type_list() {
        $this->db->select('*');

        $this->db->from('staff_dept_type');
        $query = $this->db->get();
        return $query->result();
    }

    function get_num_rows() {
        return $this->db->count_all_results('staff_dept');
    }

    function check_repeat($data, $type = "add") {
        $this->db->where('group_name', $data['group_name']);
        if ($type != "add") {
            $this->db->where('group_id !=', $data['group_id'] + 0);
        }
        return $this->db->count_all_results('staff_dept');
    }

    function add_formAD($data) {
        if ($this->db->insert('staff_dept', $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function add($data) {

        // print_r($this->get_post());
        if ($this->db->insert('staff_dept', $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function add_scrap($data) {

        // print_r($this->get_post());
        if ($this->db->insert('staff_dept_scrap', $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function edit($data) {

        $id = $data["id"];
        $this->db->where('id', $id);
        if ($this->db->update('staff_dept', $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function del($data) {
        if ($this->db->delete('staff_dept', $data)) {
            return true;
        } else {
            return false;
        }
    }

}
