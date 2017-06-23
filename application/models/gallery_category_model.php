<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Gallery_category_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_all() {
        $records = array();
        $query = $this->db->query('SELECT * FROM gallery_category ORDER BY class_sequence');
        foreach ($query->result() as $row) {
            $row->children = $this->get_child_num($row->class_id);
            $records[] = $row;
        }
        return $records;
    }

    function get_byid($id) {

        $this->db->select('*');

        $this->db->from('gallery_category');
        $this->db->where('class_id', $id);
        $query = $this->db->get();
        // return $this->db->get($this->_product_table);
        return $query->row();
    }

    function get_child_num($classid) {
        $query = $this->db->query("select count(*) as children from gallery_category where parent_id='$classid'");
        foreach ($query->result() as $row) {
            return $row->children;
        }
    }

    function get_in_tree($array, $pid=0, $y, &$tdata=array()) {
        foreach ($array as $row) {
            if ($row->parent_id == $pid) {
                $n = $y + 1;
                $row->deep = $y;
                $tdata[] = $row;
                $this->get_in_tree($array, $row->class_id, $n, $tdata);
            }
        }
        return $tdata;
    }

    function get_category() {
        return $this->get_in_tree($this->get_all(), 0, 0);
    }

    function move_category($from, $to) {
        $data = array(
            'parent_id' => $to
        );
        $this->db->where('class_id', $from);
        $this->db->update('gallery_category', $data);
        return true;
    }

    function insert($data) {
        if ($this->db->insert('gallery_category', $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function update($classid, $data) {
        $this->db->where('class_id', $classid);
        //$this->db->update('gallery_category', $data);
        if ($this->db->update('gallery_category', $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function del($classid) {
        $this->db->where('class_id', $classid);
        $this->db->delete('gallery_category');
    }

}