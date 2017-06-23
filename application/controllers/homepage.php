<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Homepage extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->authorization->check_auth();
        $this->load->model('homepage_model');
    }

    function index() {

        $this->view();
    }

    function view() {
        $this->authorization->check_permission($this->uri->segment(2), '1');
        $data['title'] = "管理中心:圣地美琼网站系统";
        $data['copyright'] = "圣地美琼网站";
        $data['link'] = "http://www.vins-selection.com.cn/";
        $data['f_type'] = $this->uri->segment(3);

        //if($this->v!="-1")
        //	$where .= " and gallery.is_verified = $this->v";
        $data['adPics'] = $this->homepage_model->get_adpics();
        $data['newproducts'] = $this->homepage_model->get_newproducts();
        //print_r($data['gallerys']);
        //$data['links'] = $this->pagination($where);
        $data['action'] = "view";

        $this->load->view('homepage_layout', $data);
    }

    function get_post() {

        $data['hType'] = $this->input->post('hType');
        $data['hPic'] = $this->input->post('Pic');
        $data['hTitle'] = $this->input->post('galleryName');
        $data['hContents'] = $this->input->post('galleryContents');
        $data['hUrl'] = $this->input->post('hUrl');
        $data['hSort'] = $this->input->post('gallerySort');
        if ($this->uri->segment(3) == "edit") {

            $data['gallery_id'] = $this->input->post('id');
        }
        return $data;
    }

    function getByid() {
        $list = $this->homepage_model->get_homepage_byid($this->uri->segment(4));
        print(json_encode($list));
    }

    function add() {
        $this->authorization->check_permission($this->uri->segment(2), '2');

        if ($msg = $this->homepage_model->add($this->get_post())) {
            echo $msg;
        }
    }

    function edit() {
        $this->authorization->check_permission($this->uri->segment(2), '3');

        if ($msg = $this->homepage_model->edit($this->get_post())) {
            echo $msg;
        }
        //die('修改成功');
        // $this->view();
    }

    function del() {
        $this->authorization->check_permission($this->uri->segment(2), '4');
        if ($gallery_id = $this->input->post('gallery_id')) {
            $data['gallery_id'] = $gallery_id;
            if ($msg = $this->gallery_model->del($data)) {
                echo $msg;
            } else {
                echo "删除操作失败,原因可能是当前记录不存在！";
            }
        }
    }

    function get_homepage_id() {
        $data = array();
        foreach ($_POST as $key => $v)
            $data[$key] = $v;
        if ($this->input->post('submit'))
            array_pop($data);
        if (count($data)) {
            return $data;
        } else {
            return false;
        }
    }

    function physical_del() {
        $this->authorization->check_permission($this->uri->segment(2), '4');

        if ($data = $this->get_homepage_id()) {
            if ($this->homepage_model->physical_del($data)) {
                $this->view();
            } else {
                show_error("删除操作失败,原因可能是当前记录不存在！");
            }
        } else {
            show_error("删除操作失败,原因可能是当前记录不存在！");
        }
    }

    function recover() {
        $this->authorization->check_permission($this->uri->segment(2), '3');
        if ($data = $this->get_gallery_id()) {
            if ($this->gallery_model->recover($data)) {
                $this->view();
            } else {
                show_error("编辑失败,原因可能是当前记录不存在！");
            }
        }
    }

    function uploadPicLink() {

        // return false;
        $name_array = explode("\.", $_FILES['userfile']['name']);
        date_default_timezone_set("PRC");
        $post_time = date("YmdHis");
        $file_type = $name_array[count($name_array) - 1];
        $realname = $post_time . "." . $file_type;
        $upload_dir = './attachments/gallery/';

        $file_path = $upload_dir . $realname;
        $MAX_SIZE = 20000000;
        echo "<div id=realname style='display:none;'>" . $realname . "</div>";
        //echo $_POST['buttoninfo'];
        if (!is_dir($upload_dir)) {
            if (!mkdir($upload_dir))
                echo "文件上传目录不存在并且无法创建文件上传目录";
            if (!chmod($upload_dir, 0755))
                echo "文件上传目录的权限无法设定为可读可写";
        }

        if ($_FILES['userfile']['size'] > $MAX_SIZE)
            echo "上传的文件大小超过了规定大小";

        if ($_FILES['userfile']['size'] == 0)
            echo "请选择上传的文件";

        if (!move_uploaded_file($_FILES['userfile']['tmp_name'], $file_path))
            echo "复制文件失败，请重新上传";

        switch ($_FILES['userfile']['error']) {
            case 0:
                echo ""; // echo "success";
                break;
            case 1:
                echo "上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值";
                break;
            case 2:
                echo "上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值";
                break;
            case 3:
                echo "文件只有部分被上传";
                break;
            case 4:
                echo "没有文件被上传";
                break;
        }
    }

}