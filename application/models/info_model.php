<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Info_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_info_byKey($condition) {

        $this->db->select('*');

        $this->db->from('info');
        $this->db->where($condition);
        $query = $this->db->get();
        // return $this->db->get($this->_product_table);
        return $query->row();
    }

    function get_infos($limit = 0, $offset = 0, $condition = "") {
        $this->db->select('*');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('info');
        $this->db->join('menu', "menu.id = info.classId");
        $query = $this->db->get();
        return $query->result();
    }

    function get_num_rows($condition = "") {
        if ($condition)
            $this->db->where($condition);
        return $this->db->count_all_results('info');
    }

    function add($data) {

        if ($this->db->insert("info", $data)) {
            return "ok";
        } else {
            return "ewew";
            //	return false;
        }
    }

    function edit($data) {
        $infoId = array_pop($data);
        date_default_timezone_set("PRC");
        $data['update_time'] = date("Y-m-d H:i:s");
        $this->db->where('infoId', $infoId);

        if ($this->db->update('info', $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function del($data) {
        $this->db->where($data);
        if ($this->db->update('info', array('is_del' => 1))) {
            return "ok";
        } else {
            return false;
        }
    }

    function multi_del($data) {
        $this->db->where_in('infoId', $data);
        if ($this->db->update('info', array('is_del' => 1))) {
            return true;
        } else {
            return false;
        }
    }

    function physical_del($data) {
        $this->db->where_in('infoId', $data);
        $query = $this->db->delete('info');
        //$this->db->where_in('article_id',$data);
        //$query = $this->db->delete('attachment');
        return true;
    }

    function recover($data) {
        $this->db->where_in('infoId', $data);
        if ($this->db->update('infoId', array('is_del' => 0))) {
            return true;
        } else {
            return false;
        }
    }

    // laod menu start
    function get_all() {
        $records = array();
        $query = $this->db->query('SELECT * FROM menu_type INNER JOIN menu ON (menu_type.id = menu.typeId) AND typeId = 1 ORDER BY menuSort');
        foreach ($query->result() as $row) {
            $row->children = $this->get_child_num($row->id);
            $records[] = $row;
        }
        return $records;
    }

    function get_child_num($classid) {
        $query = $this->db->query("select count(*) as children from menu where parent_id='$classid'");
        foreach ($query->result() as $row) {
            return $row->children;
        }
    }

    function get_in_tree($array, $pid = 0, $y, &$tdata = array()) {
        foreach ($array as $row) {
            if ($row->parent_id == $pid) {
                $n = $y + 1;
                $row->deep = $y;
                $tdata[] = $row;
                $this->get_in_tree($array, $row->id, $n, $tdata);
            }
        }
        return $tdata;
    }

    function get_menus() {
        return $this->get_in_tree($this->get_all(), 0, 0);
    }

    // laod menu end 
}