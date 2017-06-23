<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('group_model');
        $this->authorization->check_auth();
    }

    function index() {
        $this->view();
    }

    function pagination() {
        $this->load->library('pagination');
        $config['base_url'] = site_url('group/view');
        $config['total_rows'] = $this->group_model->get_num_rows();
        $config['per_page'] = '10';
        $config['uri_segment'] = 4;
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }

    function view() {
        $this->authorization->check_permission($this->uri->segment(2), '1');
        $data['title'] = "用户组管理:巴拉巴拉设计图下载系统";
        $data['copyright'] = "Balabala";
        $data['link'] = "http://www.balabala.com.cn";
        $data['groups'] = $this->group_model->get_groups(10, $this->uri->segment(4, 0));
        $data['links'] = $this->pagination();
        $this->load->view('group', $data);
    }

    function get_post() {
        $data['group_name'] = $this->input->post('group_name');
        $data['permissions'] = $this->input->post('permission');
        if ($this->uri->segment(3) == "edit")
            $data['group_id'] = $this->input->post('group_id');
        return $data;
    }

    function add() {
        $this->authorization->check_ajax_permission($this->uri->segment(2), '2');
        if ($this->input->post('submit'))
            if ($msg = $this->group_model->add($this->get_post()))
                echo $msg;
    }

    function edit() {
        $this->authorization->check_ajax_permission($this->uri->segment(2), '3');
        if ($this->input->post('submit'))
            if ($msg = $this->group_model->edit($this->get_post()))
                echo $msg;
    }

    function del() {
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

}