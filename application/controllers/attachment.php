<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Attachment extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('attachment_model');
        //$this->authorization->check_auth();
    }

    function upload() {
        $this->attachment_model->upload();
    }

    

    function cover() {
        echo $this->attachment_model->cover($this->input->post('id'), $this->input->post('value'));
    }

    function del() {
        echo $this->attachment_model->del($this->input->post('id'));
    }

    function file_del() {
        $this->authorization->check_permission($this->uri->segment(2), '4');
        echo $this->attachment_model->file_del($this->input->post('path'));
    }

    function list_files() {
        $this->authorization->check_permission($this->uri->segment(2), '1');
        $root = realpath("./attachments");
        if ($this->input->post('path')) {
            $path = $this->input->post('path');
            if (realpath($path) != realpath("./attachments")) {
                $path = str_replace('\\', '/', $path);
                $arr = split('/', $path);
                array_pop($arr);
                $root = join('/', $arr);
            }
        } else {
            $path = $root;
        }
        $data['title'] = "附件管理:巴拉巴拉设计图下载系统";
        $data['copyright'] = "Balabala";
        $data['link'] = "http://www.balabala.com.cn";
        $data['files'] = $this->attachment_model->list_files($path);
        $data['root'] = $root;
        $this->load->view('attachment', $data);
    }

}