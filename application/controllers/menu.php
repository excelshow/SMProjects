<?php

class Menu extends Controller {

    function __construct() {
        parent::Controller();
        $this->load->model('menu_model');
        $this->authorization->check_auth();
    }

    function uploadMenuLink() {
       //   $this->menu_model->upload();

        $name_array = explode("\.", $_FILES['userfile']['name']);
        date_default_timezone_set("PRC");
        $post_time = date("YmdHis");
        $file_type = $name_array[count($name_array) - 1];
        $realname = $post_time . "." . $file_type;
        $upload_dir = './attachments/menu/';

        $file_path = $upload_dir . $realname;
        $MAX_SIZE = 20000000;
        echo "<div id=realname style='display:none;'>".$realname."</div>";
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

    function index() {
       
        $this->authorization->check_permission($this->uri->segment(2), '1');
        $data['menuType'] = $this->menu_model->get_menuTypes();
        $data['menu'] = $this->menu_model->get_menus();

        //  print_r($data['menu']);
        $this->load->view('menu', $data);
    }

    function getByid() {
        $id = $this->uri->segment(4);
        if ($id) {
            $list = $this->menu_model->get_menu_byid($id);
            print(json_encode($list));
        }
    }

    function move($from, $to) {
        $this->authorization->check_ajax_permission($this->uri->segment(2), '3');
        if (isset($from) && isset($to))
            $this->menu_model->move_category($from, $to);
    }

    function create() {
        $this->authorization->check_ajax_permission($this->uri->segment(2), '2');
        $data['menuName'] = $this->input->post('menuName');
        $data['parent_id'] = $this->input->post('parent_id');
        $data['typeId'] = $this->input->post('typeId');
        $data['menuSort'] = $this->input->post('menuSort');
		$data['menuUrl'] = $this->input->post('menuUrl');
        $data['optional'] = $this->input->post('optional');
        $data['seoKeyword'] = $this->input->post('seoKeyword');
        $data['menuPic'] = $this->input->post('menuPic');
        $data['menuBackpic'] = $this->input->post('menuBackpic');
	 // print_r($data);
	 
        if ($msg = $this->menu_model->insert($data))
				echo $msg;
        
    }

    function edit() {
        $this->authorization->check_ajax_permission($this->uri->segment(2), '3');
        $data['menuName'] = $this->input->post('menuName');
        $classid = $this->input->post('id');
        $data['typeId'] = $this->input->post('typeId');
        $data['menuSort'] = $this->input->post('menuSort');
        $data['optional'] = $this->input->post('optional');
        $data['seoKeyword'] = $this->input->post('seoKeyword');
		$data['menuUrl'] = $this->input->post('menuUrl');
        $data['menuPic'] = $this->input->post('menuPic');
        $data['menuBackpic'] = $this->input->post('menuBackpic');
		 $data['menuLeftpic'] = $this->input->post('menuLeftpic');
        $msg = $this->menu_model->update($classid, $data);
        if ($msg){
            echo $msg;
        }
				
    }

    function del() {
        $this->authorization->check_ajax_permission($this->uri->segment(2), '4');
        $classid = $this->input->post('class_id');
        $this->menu_model->del($classid);
    }

}