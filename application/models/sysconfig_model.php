<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sysconfig_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function syscon() {
        $this->db->select('*');
        $query = $this->db->from('sys_config');
        $query = $this->db->get();
        //return $query->result();
        return $query->row();
    }

    function get_controller($where = '') {
        $this->db->select('*');
        if ($where) {
            $this->db->where($where);
        }
        $this->db->from('sys_controller');
        $this->db->order_by("scSort", 'asc');
        $query = $this->db->get();
        //return $query->result();
        return $query->result();
    }

    function get_controller_row($where = '') {
        $this->db->select('*');
        if ($where) {
            $this->db->where($where);
        }
        $this->db->from('sys_controller');
        $this->db->order_by("scSort", 'asc');
        $query = $this->db->get();
        //return $query->result();
        return $query->row();
    }

    function get_controller_permission($where = '') {
        $this->db->select('*');
        if ($where) {
            $this->db->where($where);
        }
        $this->db->from('sys_controller_permission');
        $this->db->order_by("scpId", 'asc');
        $query = $this->db->get();
        //  print_r($query->result());
        return $query->result();
    }

    function sysInfo() {
        $this->cismarty->assign("base_url", $this->syscon()->domain);
        $this->cismarty->assign("web_title", $this->syscon()->title);
        $this->cismarty->assign("web_keyword", $this->syscon()->keyword);
        $this->cismarty->assign("web_contents", $this->syscon()->contents);
        $this->cismarty->assign("web_template", $this->syscon()->templates);
        $this->cismarty->assign("applist", $this->syscon()->applist);
        $this->cismarty->assign("web_copyright", $this->syscon()->copyright);
        $this->cismarty->assign("web_copyrighturl", $this->syscon()->copyrighturl);
    }

    function set_sys_permission() {

        $this->load->model('dx_auth/roles', 'roles');

        $this->load->model('dx_auth/dx_permissions', 'dx_permissions');

        if ($this->uri->segment(2) != '') {
            $controller = $this->uri->segment(2);
        } else {
            $controller = $this->uri->segment(1);
        }
        $role_id = $this->session->userdata('DX_role_id');
        // echo $controller;
        $conTemp = $this->sysconfig_model->get_controller_row("scUri = '" . $controller . "'");

        //     print_r($conTemp);
        //  exit();
        //   echo "sdf";
        $scPermission = array();
        if ($conTemp) {
            //     echo "1212";
            $pageTitle = $conTemp->scName . ' - ';
            $scPer = $this->sysconfig_model->get_controller_permission('scId = ' . $conTemp->scId);
            if ($scPer) {
                foreach ($scPer as $rowsc) {
                    if ($this->dx_permissions->get_permission_value($role_id, $rowsc->scpValue)) {
                        $scPermission[$rowsc->scpValue] = 1;
                    } else {
                        $scPermission[$rowsc->scpValue] = 0;
                    }
                }
            }

            //  print_r($scPermission);
            // exit();
        } else {
            $pageTitle = 'guanli';
        }

        $this->cismarty->assign("sysPermission", $scPermission);
        $this->cismarty->assign("pageTitle", $pageTitle);
    }

    function set_sys_permission_by() {
        $this->load->model('dx_auth/roles', 'roles');

        $this->load->model('dx_auth/dx_permissions', 'dx_permissions');

        if ($this->uri->segment(2) != '') {
            $controller = $this->uri->segment(2);
        } else {
            $controller = $this->uri->segment(1);
        }
        $role_id = $this->session->userdata('DX_role_id');
        // echo $controller;
        $conTemp = $this->sysconfig_model->get_controller_row("scUri = '" . $controller . "'");

        //     print_r($conTemp);
        //  exit();
        //   echo "sdf";
        $scPermission = array();
        if ($conTemp) {
            //     echo "1212";
            $pageTitle = $conTemp->scName . ' - ';
            $scPer = $this->sysconfig_model->get_controller_permission('scId = ' . $conTemp->scId);
            if ($scPer) {
                foreach ($scPer as $rowsc) {
                    if ($this->dx_permissions->get_permission_value($role_id, $rowsc->scpValue)) {
                        $scPermission[$rowsc->scpValue] = 1;
                    } else {
                        $scPermission[$rowsc->scpValue] = 0;
                    }
                }
            }

            //  print_r($scPermission);
            // exit();
        } else {
            $pageTitle = 'guanli';
        }
        return $scPermission;
      //  $this->cismarty->assign("sysPermission", $scPermission);
       // $this->cismarty->assign("pageTitle", $pageTitle);
    }

    function templates() {
        return $this->syscon()->templates;
    }

    function sys_user_log($data) {
        date_default_timezone_set("PRC");
        $this->db->insert("user_log", $data);
    }
 function sys_user_result($limit = 0, $offset = 0,$where="") {
        $this->db->select('*');
         if ($limit) {
            $this->db->limit($limit, $offset);
        }
        if ($where) {
            $this->db->where($where);
        }
        $this->db->from('user_log');
        $this->db->order_by("ul_time", 'desc');
        $query = $this->db->get();
        //  print_r($query->result());
        return $query->result();
    }
}
