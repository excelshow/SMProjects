<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Authorization extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function check_log() {
        if (!$this->session->userdata('admin_log')) {
            return false;
        } else {
            return true;
        }
    }

    function check_auth() {
        if (!$this->check_log()) {
            redirect(site_url('log'));
        }
    }

    function check_ajax_permission($controller, $permission, $only_controller = false) {
        if (!$this->permission($controller, $permission, $only_controller)) {
            die('你没有管理此的权限！');
        }
    }

    function check_permission($controller, $permission, $only_controller = false) {
        if (!$this->permission($controller, $permission, $only_controller)) {
            show_error('对不起，你没有管理这里的权限!');
        }
    }

    function permission($controller, $permission = "", $only_controller = false) {
        if (!$this->check_log()) {
            return false;
        } else {
            //query data from database
            $query = $this->db->query("select * from user,user_group where user.group_id=user_group.group_id and user.username='" . $this->session->userdata('admin') . "'");
            if (!$query->num_rows()) {
                //destroy session data
                $this->session->sess_destroy();
                return false;
            } else {

                $permissions = "";
                foreach ($query->result() as $row) {
                    $permissions = $row->permissions;
                }
             
                if ($permissions == "")
                    return false;
                 //echo $permission;
            //  print_r(json_decode($permissions));
                foreach (json_decode($permissions) as $row) {
                    if ($row->controller == "all") {
                        return true;
                    } else {
                         
                          echo $controller;
                          echo '<br>';
                        //echo strpos($row->controller,$controller);
                        // echo stristr('ba,e', 'c') ;
                        if (stristr($row->controller, $controller)) {
                            if ($only_controller || $row->permission == "all") {
                                return true;
                            } else {
                                return ereg($permission, $row->permission) == 1 ? true : false;
                            }
                        }
                    }
                }
                return false;
            }
        }
    }

    // layout author show start
    //
      function check_layout_log() {
        if (!$this->session->userdata('layout_log')) {
            return false;
        } else {

            return true;
        }
    }

    function check_layout_auth() {
        if (!$this->check_layout_log()) {
            redirect(site_url('loginlayout'));
        }
    }

    function check_layout_ajax_permission($controller, $permission, $only_controller = false) {
        if (!$this->permission($controller, $permission, $only_controller)) {
            die('你没有管理此的权限！');
        }
    }

    function check_layout_permission($controller, $permission, $only_controller = false) {
        if (!$this->permission($controller, $permission, $only_controller)) {
            show_error('对不起，你没有管理这里的权限，囧');
        }
    }

    function layout_permission($controller, $permission = "", $only_controller = false) {
        if (!$this->check_log()) {
            return false;
        } else {
            //query data from database
            $query = $this->db->query("select * from user,user_group where user.group_id=user_group.group_id and user.username='" . $this->session->userdata('admin') . "'");
            if (!$query->num_rows()) {
                //destroy session data
                $this->session->sess_destroy();
                return false;
            } else {

                $permissions = "";
                foreach ($query->result() as $row) {
                    $permissions = $row->permissions;
                }

                if ($permissions == "")
                    return false;

                foreach (json_decode($permissions) as $row) {
                    if ($row->controller == "all") {
                        return true;
                    } else {
                        if ($controller == $row->controller) {
                            if ($only_controller || $row->permission == "all")
                                return true;
                            else
                                return ereg($permission, $row->permission) == 1 ? true : false;
                        }
                    }
                }
                return false;
            }
        }
    }

    //
    //
                //
                //layout author show end
}