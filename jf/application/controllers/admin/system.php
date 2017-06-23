<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class System extends CI_Controller {

    function __construct() {

        parent::__construct();

        $this->authorization->check_auth();
        $this->sysconfig_model->sysInfo(); // set sysInfo

        $this->load->model('user_model');
        $this->load->model('group_model');
        $navAction = "system";
        $this->cismarty->assign("navAction", $navAction);
    }

    function pagination() {
        $this->load->library('pagination');
        $config['base_url'] = site_url('user/view');
        $config['total_rows'] = $this->user_model->get_num_rows();
        $config['per_page'] = '10';
        $config['uri_segment'] = 4;
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }

    function showmenu() {
        $showmenu = "<ul>";
        $showmenu .= "<li><a href=" . site_url("system") . " >管理员配置</a></li>";
        $showmenu .= "<li><a href=" . site_url("system/group") . " >管理员分组</a></li>";
        $showmenu .= "<li><a href=" . site_url("system/syscon") . " >系统配置管理</a></li>";
        $showmenu .= "</ul>";
        return $showmenu;
    }

// user function
    function index() {

        $this->load->model('sysconfig_model');
        $result = $this->sysconfig_model->syscon();
        $this->cismarty->assign("data", $result);
        $this->cismarty->display($this->sysconfig_model->templates() . '/admin/system_syscon.tpl');
    }

    function userlist() {

        //$this->authorization->check_permission($this->uri->segment(2), '1');

        $data['users'] = $this->user_model->get_users(10, $this->uri->segment(4, 0));
        $data['links'] = $this->pagination();
        $data['groups'] = $this->group_model->get_groups();
        //print_r($data['users']);
        $this->cismarty->assign("groups", $data['groups']);

        $type = "";
        $this->cismarty->assign("type", $type);
        $this->cismarty->assign("users", $data['users']);
        $this->cismarty->assign("links", $data['links']);

        $this->cismarty->display('admin/user.tpl');
        //$this->load->view('user',$data);
    }

    function get_post_pass() {
        $data['userpass'] = md5($this->input->post('b_userpass'));

        //$data['group_id'] = $this->input->post('user_group');

        $data['uid'] = $this->input->post('uid');
        //print_r($data);
        return $data;
    }

    function user_add() {
        $data['groups'] = $this->group_model->get_groups();

        $this->cismarty->assign("groups", $data['groups']);
        $this->cismarty->display('admin/user_add.tpl');
    }

    function user_add_do() {
        
            //  print_r($this->get_post());
            // exit();
            if ($msg = $this->user_model->add($this->get_post())) {
                echo $msg;
            } else {
                echo "Error!!";
            }
        
    }

    function user_edit() {
        $uid = $this->uri->segment(4);
        $data['user'] = $this->user_model->get_user_row('uid = ' . $uid);
        $data['groups'] = $this->group_model->get_groups();

        $this->cismarty->assign("groups", $data['groups']);
        $this->cismarty->assign("user", $data['user']);
        $this->cismarty->display('admin/user_modify.tpl');
    }

    function user_edit_do() {
        //print_r($this->user_get_post());
        if ($msg = $this->user_model->edit($this->user_get_post()))
            echo $msg;
    }

    function user_editpass() {

        if ($this->input->post('submit'))
            if ($msg = $this->user_model->editpass($this->get_post_pass()))
                echo $msg;
    }

    function user_del() {
        $this->authorization->check_ajax_permission($this->uri->segment(2), '4');
        if ($uid = $this->input->post('uid')) {
            $data['uid'] = $uid;
            if ($msg = $this->user_model->del($data)) {
                echo $msg;
            } else {
                echo "删除操作失败,原因可能是当前记录不存在！";
            }
        }
    }

    function user_get_post() {
        $data['username'] = $this->input->post('username');
        if ($this->input->post('userpass')) {
            $data['userpass'] = md5($this->input->post('userpass'));
        }
        $data['group_id'] = $this->input->post('user_group');
        $data['nickname'] = $this->input->post('nickname');
        $data['phone'] = $this->input->post('iphone');
        $data['email'] = $this->input->post('email');

        if ($this->input->post('uid')) {
            $data['uid'] = $this->input->post('uid');
        }

        return $data;
    }

    function get_post() {
        $data['username'] = $this->input->post('username');
        if ($this->input->post('userpass')) {
            $data['userpass'] = md5($this->input->post('userpass'));
        }
        $data['group_id'] = $this->input->post('user_group');
        $data['nickname'] = $this->input->post('nickname');
        $data['phone'] = $this->input->post('iphone');
        $data['email'] = $this->input->post('email');
        if ($this->input->post('uid')) {
            $data['uid'] = $this->input->post('uid');
        }
        return $data;
    }

// user function end
// group function
    function group() {
        $this->authorization->check_permission($this->uri->segment(2), '1');

        $data['groups'] = $this->group_model->get_groups(10, $this->uri->segment(4, 0));
        $data['links'] = $this->pagination();

        $this->cismarty->assign("groups", $data['groups']);
        $this->cismarty->assign("links", $data['links']);
        $this->cismarty->assign("showmenu", $this->showmenu());
        $this->cismarty->display('admin/group.tpl');
        // $this->load->view('group', $data);
    }

    function group_get_post() {
        $data['group_name'] = $this->input->post('group_name');
        $data['permissions'] = $this->input->post('permission');
        $data['makes'] = $this->input->post('makes');
        if ($this->uri->segment(3) == "group_edit")
            $data['group_id'] = $this->input->post('group_id');
        return $data;
    }

    function group_add() {
        $this->authorization->check_ajax_permission($this->uri->segment(2), '2');
        if ($this->input->post('submit'))
            if ($msg = $this->group_model->add($this->group_get_post()))
                echo $msg;
    }

    function group_edit() {
        $this->authorization->check_ajax_permission($this->uri->segment(2), '3');
        if ($this->input->post('submit'))
            if ($msg = $this->group_model->edit($this->group_get_post()))
                echo $msg;
    }

    function group_del() {
        $this->authorization->check_ajax_permission($this->uri->segment(2), '4');
        if ($group_id = $this->input->post('group_id')) {
            $data['group_id'] = $group_id;
            if ($msg = $this->group_model->del($data)) {
                echo $msg;
            } else {
                echo "删除操作失败,原因可能是当前记录不存在！";
            }
        }
    }

    // group function end
}
