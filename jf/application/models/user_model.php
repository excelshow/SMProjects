<?php

class User_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'ag_user';
    }

    function get_users($limit = 0, $offset = 0) {
        $this->db->select('*');

        $this->db->limit($limit, $offset);
        $this->db->from($this->table); 
        $this->db->join('ag_user_group', 'ag_user.group_id = ag_user_group.group_id');
        $query = $this->db->get();
        return $query->result();
    }

    function get_user_row($condition = "") {
        $this->db->select('*');

        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->first_row();
    }

    function get_num_rows() {
        return $this->db->count_all_results($this->table);
    }

    function check_repeat($data, $type = "add") {
        $this->db->where('username', $data['username']);
        $this->db->or_where('email', $data['email']);
        if ($type != "add") {
            $this->db->where('uid !=', $data['uid'] + 0);
        }
        return $this->db->count_all_results($this->table);
    }

    function add($data) {
        if (!$this->check_repeat($data)) {
            if ($this->db->insert($this->table, $data)) {
                $result = $this->db->query('select max(uid) as uid from ag_user')->result();
                $uid = 0;
                foreach ($result as $row) {
                    $uid = $row->uid;
                }
                return "ok";
            } else {
                return "false1";
            }
        } else {
            return "用户名或者email已存在";
        }
    }

    function edit($data) {
        //if(!$this->check_repeat($data,"edit")){
        $uid = array_pop($data);
        $this->db->where('uid', $uid);
        if ($this->db->update($this->table, $data)) {
            return "ok";
        } else {
            return false;
        }
        //}else{
        //	return "用户名或者email已存在";
        //}
    }

    function editpass($data) {
        //if(!$this->check_repeat($data,"edit")){
        $uid = $data['uid'];
        print_r($data);
        $this->db->where('uid', $uid);
        if ($this->db->update($this->table, $data)) {
            return "ok";
        } else {
            return false;
        }
        //}else{
        //	return "用户名或者email已存在";
        //}
    }

    function del($data) {
        if ($this->db->delete($this->table, $data)) {
            return "ok";
        } else {
            return false;
        }
    }

}
