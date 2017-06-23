<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model('user_model');
    }

    function login($data) {
        $this->db->where($data);
        $this->db->from('user');

        // print_r($layout);
        //echo 'sdfdsf';
        if ($this->db->count_all_results()) {
            $this->db->where($data);
            $this->db->from('user');
            $query = $this->db->get();
            $layout = $query->row();
            if ($layout->mid == 0) {
                show_error('对不起，你的用户权限出错，请重新登录！');
                return false;
            } else {
                
            }
        } else {
            show_error('对不起，用户名密码错误，请重新登录！');
            return false;
        }
    }

    function logout() {
        
    }

}