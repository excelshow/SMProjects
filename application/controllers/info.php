<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Info extends  CI_Controller {

    function __construct() {
        parent::__construct();
        $this->authorization->check_auth();
        $this->load->model('info_model');
    }

    function index() {
        $this->view();
    }

    function pagination($condition="") {
        $this->load->library('pagination');
        $config['base_url'] = site_url('info/view');
        $config['total_rows'] = $this->info_model->get_num_rows($condition);
        $config['per_page'] = '20';
        $config['uri_segment'] = 4;
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }

    function view() {
        $this->authorization->check_permission($this->uri->segment(2), '1');
       
        $where = "info.is_del = 0 ";

        parse_str($_SERVER['QUERY_STRING'], $_GET);
        if (isset($_GET['mode']))
            $this->mode = $_GET['mode'];
        if (isset($_GET['q']))
            $this->q = $_GET['q'];
        if (isset($_GET['v']))
            $this->v = $_GET['v'];
        //if($this->mode!="normal")
        $where = "info.is_del = 0 ";


        // load menu start

        $data['menu'] = $this->info_model->get_menus();

        //print_r($data['menu_Name']);
        // load menu end
        $data['infos'] = $this->info_model->get_infos(20, $this->uri->segment(4, 0), $where);
        $data['links'] = $this->pagination($where);
        $data['action'] = "view";

        $data['q'] = $this->q;
        $data['v'] = $this->v;
        $data['mode'] = $this->mode;
        $this->load->view('info', $data);
    }

    function get_post() {
        $data['title'] = $this->input->post('title');
        $data['description'] = $this->input->post('description');
        $data['content'] = $this->input->post('info_con');
        $data['classId'] = $this->input->post('classId');
        $data['keyword'] = $this->input->post('keyword');
        $data['author'] = $this->input->post('author');
        $data['info_from'] = $this->input->post('info_from');
        $data['edit_author'] = $this->input->post('edit_author');
        $data['is_best'] = $this->input->post('is_best');
        $data['info_pic'] = $this->input->post('info_pic');

        $data['post_time'] = $this->input->post('post_time');
        if ($this->uri->segment(3) == "edit") {
            if ($this->input->post('verify')) {
                $data['is_verified'] = $this->input->post('is_verified');
                $data['verifier'] = $this->session->userdata('admin');
                date_default_timezone_set("PRC");
                $data['verify_time'] = date("Y-m-d H:i:s");
            }
            $data['infoId'] = $this->input->post('infoId');
        }
        return $data;
    }

    function get_category() {
        $this->load->model('category_model');
        return $this->category_model->get_category();
    }

    function add_info() {
        $this->authorization->check_ajax_permission($this->uri->segment(2), '2');

        
        $data['action'] = "add";
        // load menu start

        $data['menu'] = $this->info_model->get_menus();
        // load menu end
        $this->load->view('info', $data);
    }

    function edit_info() {
        $this->authorization->check_permission($this->uri->segment(2), '3');
        $data['verify'] = $this->authorization->permission($this->uri->segment(2), '5');
        
        $data['action'] = "edit";
        $data['info'] = $this->info_model->get_infos(0, 0, "infoId = " . $this->uri->segment(4));
        //$data['attachments'] = $this->info_model->get_attachments("info_id = ".$this->uri->segment(4));
        $data['file_types'] = array('jpg' => 'jpg', 'gif' => 'gif', 'png' => 'png', 'jpeg' => 'jpeg', 'bmp' => 'bmp');
        // load menu start

        $data['menu'] = $this->info_model->get_menus();
        // load menu end
        $this->load->view('info', $data);
    }

    function add() {
        $this->authorization->check_permission($this->uri->segment(2), '2');
        //  print_r($this->get_post());

        if ($msg = $this->info_model->add($this->get_post())) {
            echo $msg;
        }

        // $this->view();
    }

    function edit() {
        $this->authorization->check_permission($this->uri->segment(2), '3');
        //print_r($this->get_post());
        if ($msg = $this->info_model->edit($this->get_post())) {
            echo $msg;
        }
    }

    function del() {
        $this->authorization->check_permission($this->uri->segment(2), '4');
        if ($info_id = $this->input->post('info_id')) {
            $data['info_id'] = $info_id;
            if ($msg = $this->info_model->del($data)) {
                echo $msg;
            } else {
                echo "删除操作失败,原因可能是当前记录不存在！";
            }
        }
    }

    function get_info_id() {
        $data = array();
        foreach ($_POST as $key => $v)
            $data[$key] = $v;
        if ($this->input->post('is_verified'))
            array_pop($data);
        if ($this->input->post('class_id'))
            array_pop($data);
        if ($this->input->post('recover'))
            array_pop($data);
        if ($this->input->post('submit'))
            array_pop($data);
        if (count($data)) {
            return $data;
        } else {
            return false;
        }
    }

    function multi_del() {
        $this->authorization->check_permission($this->uri->segment(2), '4');
        if ($data = $this->get_info_id()) {
            if ($msg = $this->info_model->multi_del($data)) {
                $this->view();
            } else {
                show_error("删除操作失败,原因可能是当前记录不存在！");
            }
        }
    }

    function physical_del() {
        $this->authorization->check_permission($this->uri->segment(2), '4');
        if ($data = $this->get_info_id()) {
            if ($this->info_model->physical_del($data)) {
                //$this->view();
                echo "ok";
            } else {
                show_error("删除操作失败,原因可能是当前记录不存在！");
            }
        }
    }

    function recover() {
        $this->authorization->check_permission($this->uri->segment(2), '3');
        if ($data = $this->get_info_id()) {
            if ($this->info_model->recover($data)) {
                $this->view();
            } else {
                show_error("编辑失败,原因可能是当前记录不存在！");
            }
        }
    }

    // upload Pic and PDF satart
    function uploadPicLink() {

        // return false;
        $name_array = explode("\.", $_FILES['userfile']['name']);
        date_default_timezone_set("PRC");
        $post_time = date("YmdHis");
        $file_type = $name_array[count($name_array) - 1];
        $realname = $post_time . "." . $file_type;
        $upload_dir = './attachments/info/';

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

    // online edit HTML ajax  uploadPIC
    function uploadHtmlPic() {
		echo 'sdf';
		exit();
        $inputName = 'filedata'; //表单文件域name
        $attachDir = 'attachments/info'; //上传文件保存路径，结尾不要带/  $upload_dir = './attachments/product/';
        $dirType = 2; //1:按天存入目录 2:按月存入目录 3:按扩展名存目录  建议使用按天存
        $maxAttachSize = 2097152; //最大上传大小，默认是2M
        $upExt = 'jpg,jpeg,gif,png'; //上传扩展名
        $msgType = 2; //返回上传参数的格式：1，只返回url，2，返回参数数组
        $immediate = isset($_GET['immediate']) ? $_GET['immediate'] : 0; //立即上传模式，仅为演示用
        ini_set('date.timezone', 'Asia/Shanghai'); //时区

        $err = "";
        $msg = "''";
        $tempPath = $attachDir . '/' . date("YmdHis") . mt_rand(10000, 99999) . '.tmp';
        $localName = '';

        function jsonString($str) {
            return preg_replace("/([\\\\\/'])/", '\\\$1', $str);
        }

        if (isset($_SERVER['HTTP_CONTENT_DISPOSITION']) && preg_match('/attachment;\s+name="(.+?)";\s+filename="(.+?)"/i', $_SERVER['HTTP_CONTENT_DISPOSITION'], $info)) {//HTML5上传
            file_put_contents($tempPath, file_get_contents("php://input"));
            $localName = $info[2];
        } else {//标准表单式上传
            $upfile = @$_FILES[$inputName];
            if (!isset($upfile)

                )$err = '文件域的name错误';
            elseif (!empty($upfile['error'])) {
                switch ($upfile['error']) {
                    case '1':
                        $err = '文件大小超过了php.ini定义的upload_max_filesize值';
                        break;
                    case '2':
                        $err = '文件大小超过了HTML定义的MAX_FILE_SIZE值';
                        break;
                    case '3':
                        $err = '文件上传不完全';
                        break;
                    case '4':
                        $err = '无文件上传';
                        break;
                    case '6':
                        $err = '缺少临时文件夹';
                        break;
                    case '7':
                        $err = '写文件失败';
                        break;
                    case '8':
                        $err = '上传被其它扩展中断';
                        break;
                    case '999':
                    default:
                        $err = '无有效错误代码';
                }
            } elseif (empty($upfile['tmp_name']) || $upfile['tmp_name'] == 'none'

                )$err = '无文件上传';
            else {
                move_uploaded_file($upfile['tmp_name'], $tempPath);
                $localName = $upfile['name'];
            }
        }

        if ($err == '') {
            $fileInfo = pathinfo($localName);
            $extension = $fileInfo['extension'];
            if (preg_match('/' . str_replace(',', '|', $upExt) . '/i', $extension)) {
                $bytes = filesize($tempPath);
                if ($bytes > $maxAttachSize

                    )$err = '请不要上传大小超过' . $this->formatBytes($maxAttachSize) . '的文件';
                else {
                    switch ($dirType) {
                        case 1: $attachSubDir = 'day_' . date('ymd');
                            break;
                        case 2: $attachSubDir = 'month_' . date('ym');
                            break;
                        case 3: $attachSubDir = 'ext_' . $extension;
                            break;
                    }
                    $attachDir = $attachDir . '/' . $attachSubDir;
                    if (!is_dir($attachDir)) {
                        @mkdir($attachDir, 0777);
                        @fclose(fopen($attachDir . '/index.htm', 'w'));
                    }
                    PHP_VERSION < '4.2.0' && mt_srand((double) microtime() * 1000000);
                    $newFilename = date("YmdHis") . mt_rand(1000, 9999) . '.' . $extension;
                    $targetPath = $attachDir . '/' . $newFilename;

                    rename($tempPath, $targetPath);
                    @chmod($targetPath, 0755);

                    // $targetPath = $this->jsonString($targetPath);
                    //echo $targetPath;
                    $targetPath = preg_replace("/([\\\\\/'])/", '\\\$1', $targetPath);
                    if ($immediate == '1'

                        )$targetPath = '!' . $targetPath;
                    if ($msgType == 1

                        )$msg = "'$targetPath'";
                    else
                        $msg="{'url':'/" . $targetPath . "','localname':'" . preg_replace("/([\\\\\/'])/", '\\\$1', $localName) . "','id':'1'}"; //id参数固定不变，仅供演示，实际项目中可以是数据库ID



                }
            }
            else
                $err='上传文件扩展名必需为：' . $upExt;

            @unlink($tempPath);
        }

        echo "{'err':'" . preg_replace("/([\\\\\/'])/", '\\\$1', $err) . "','msg':" . $msg . "}";

        function formatBytes($bytes) {
            if ($bytes >= 1073741824) {
                $bytes = round($bytes / 1073741824 * 100) / 100 . 'GB';
            } elseif ($bytes >= 1048576) {
                $bytes = round($bytes / 1048576 * 100) / 100 . 'MB';
            } elseif ($bytes >= 1024) {
                $bytes = round($bytes / 1024 * 100) / 100 . 'KB';
            } else {
                $bytes = $bytes . 'Bytes';
            }
            return $bytes;
        }

    }

}