<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_users($limit = 0, $offset = 0) {
        $this->db->select('*');

        $this->db->limit($limit, $offset);
        $this->db->from('user');
        $this->db->join('user_group', 'user.group_id = user_group.group_id');
        $query = $this->db->get();
        return $query->result();
    }

    function get_user_by($where) {
        if ($where) {
            $this->db->where($where);
            $this->db->from('user');
            $query = $this->db->get();
            return $query->row();
        }else{
            return FALSE;
        }
    }

    function get_num_rows() {
        return $this->db->count_all_results('user');
    }

    function check_repeat($data, $type = "add") {
        $this->db->where('username', $data['username']);
        $this->db->or_where('email', $data['email']);
        if ($type != "add") {
            $this->db->where('uid !=', $data['uid'] + 0);
        }
        return $this->db->count_all_results('user');
    }

    function add($data) {
        if (!$this->check_repeat($data)) {
            if ($this->db->insert('user', $data)) {
                $result = $this->db->query('select max(uid) as uid from user')->result();
                $uid = 0;
                foreach ($result as $row) {
                    $uid = $row->uid;
                }
                return "ok" . $uid;
            } else {
                return false;
            }
        } else {
            return "用户名或者email已存在";
        }
    }

    function edit($data) {
        //if(!$this->check_repeat($data,"edit")){
        $uid = array_pop($data);
        $this->db->where('uid', $uid);
        if ($this->db->update('user', $data)) {
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
        if ($this->db->update('user', $data)) {
            return "ok";
        } else {
            return false;
        }
        //}else{
        //	return "用户名或者email已存在";
        //}
    }

    function del($data) {
        if ($this->db->delete('user', $data)) {
            return "ok";
        } else {
            return false;
        }
    }

}

