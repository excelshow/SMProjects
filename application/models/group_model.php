<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Group_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_groups($limit=0, $offset=0) {
        $this->db->select('*');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->from('user_group');
        $query = $this->db->get();
        return $query->result();
    }

    function get_num_rows() {
        return $this->db->count_all_results('user_group');
    }

    function check_repeat($data, $type="add") {
        $this->db->where('group_name', $data['group_name']);
        if ($type != "add") {
            $this->db->where('group_id !=', $data['group_id'] + 0);
        }
        return $this->db->count_all_results('user_group');
    }

    function add($data) {
        if (!$this->check_repeat($data)) {
            if ($this->db->insert('user_group', $data)) {
                $result = $this->db->query('select max(group_id) as uid from user')->result();
                $group_id = 0;
                foreach ($result as $row) {
                    $group_id = $row->uid;
                }
                return "ok" . $group_id;
            } else {
                return false;
            }
        } else {
            return "组名已经存在";
        }
    }

    function edit($data) {
        $group_id = array_pop($data);
        $this->db->where('group_id', $group_id);
        if ($this->db->update('user_group', $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function del($data) {
        if ($this->db->delete('user_group', $data)) {
            return "ok";
        } else {
            return false;
        }
    }

}