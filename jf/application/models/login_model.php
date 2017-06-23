<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function login($data) {
        $this->db->where($data);
        $this->db->from('member');
        $query = $this->db->get();
        $layout = $query->row();
        //  print_r($layout);
        if ($layout) {
            $this->session->set_userdata('member', true);
            $this->session->set_userdata('member_name', $layout->name);
            $this->session->set_userdata('member_email', $layout->email);
            return true;
        } else {

            return false;
        }
    }

    function login_set_zj($data) {
        $this->db->where($data);
        $this->db->from('member_type');
        $query = $this->db->get();
        $layout = $query->row();
        //  print_r($layout);
        if ($layout) {
            $this->session->set_userdata('zj', true);
            $this->session->set_userdata('mt_id', $layout->mt_id);
            $this->session->set_userdata('zj_name', $layout->zj_name);
            // $this->session->set_userdata('member_email', $layout->email);
            return true;
        } else {

            return false;
        }
    }

    function logout() {
        $this->session->sess_destroy();
        redirect(site_url('/'));
    }

}

