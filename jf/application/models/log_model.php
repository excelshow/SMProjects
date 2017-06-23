<?php

if (!defined('BASEPATH'))  exit('No direct script access allowed');

class Log_model extends CI_Model {

    function __construct() {

        parent::__construct();
          $this->table = 'ag_user';
    }

    function login($data) {

        $this->db->where($data);

        $this->db->from($this->table);



        if ($this->db->count_all_results()) {

            $this->db->where($data);

            $this->db->from($this->table);

            $query = $this->db->get();

            $admin = $query->row();

            if ($admin->mid == 0) {

                $this->session->set_userdata('admin_log', true);

                $this->session->set_userdata('admin', $data['username']);

                return true;
            } else {

                show_error($admin->mid . '对不起，你不是管理员！请勿尝试登录！！！');

                return false;
            }
        } else {

            show_error('对不起，你的用户名或密码错误！请核实后再登录！！');

            return false;
        }
    }

    function logout() {
         $this->session->sess_destroy();
    }

}