<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admanager extends CI_Controller {

    function __construct() {
        parent::__construct();
        //$this->dx_auth->check_uri_permissions();
        $this->sysconfig_model->sysInfo(); // set sysInfo
        $this->sysconfig_model->set_sys_permission(); // set controller permission
        $this->mainmenu_model->showMenu();
        $menuCurrent = $this->showConMenu();
        $this->cismarty->assign("menuController", $menuCurrent);
        $this->cismarty->assign("urlF", $this->uri->segment(2));
        $this->cismarty->assign("urlS", $this->uri->segment(3));
    }

    function showConMenu() {
        $showmenu = NULL;
        $showmenu .= "<li><a href='" . site_url("dept/deptsys") . "' >系统组织架构</a></li>
                            <li><a href=" . site_url("dept/admanager/dept_ad") . " >AD组织架构</a></li>";

        return $showmenu;
    }

    function index() {
        $this->view();
    }

    function dept_ad() {


        $data['action'] = "view";
        //$this->cismarty->assign("action","view");
        //$this->cismarty->assign("links", $data['links']);
        $this->cismarty->display($this->sysconfig_model->templates() . '/dept/deptad.tpl');
        //$this->load->view('admanagerLayout',$data);
    }

    function deptadlist() {
        $this->load->library('adldaplibrary');
        $adldap = new adLDAP();
        $dn = array();
        $ouData = array();
        $DnPost = $this->input->post('dn');
        // echo $DnPost;
        if ($DnPost) {              // 组合 listing Dn 数组
            $DnTemp = explode(',', $DnPost);
            // print_r($DnTemp);
            for ($i = 0; $i < count($DnTemp); $i++) {
                $ouArr = explode('=', $DnTemp[$i]);
                if ($ouArr[0] == 'OU') {
                    $outData[] = $ouArr[1];
                }
            }
            // print_r($outData);
            $dn = $outData;
            $data['ouDnPost'] = $DnPost;
        } else {
            $dn = array("Semir");
            $data['ouDnPost'] = "OU=Semir,DC=semir,DC=cn";
        }
        //echo $dn;
        $result = $adldap->folder()->listing($dn, adLDAP::ADLDAP_FOLDER, false, "folder"); ///,adLDAP::ADLDAP_FOLDER, false  输出 LIst
        unset($result['count']);

        foreach (array_reverse($result) as $row):     //array_reverse 排序
            // echo $row['dn'];
            $OuTemp = explode(',', $row['dn']);
            $OuTempShow = explode('=', $OuTemp[0]);
            $ouData[] = array('ouType' => $OuTempShow[0], 'ouName' => $OuTempShow[1], 'ouDN' => $row['dn']);
        endforeach;
        // print_r($ouData);

        $data['ouTemp'] = array_reverse($dn);
        $data['ouData'] = $ouData;
        // print_r($ouData);

        $this->cismarty->assign("ouDnPost", $data['ouDnPost']);
        $this->cismarty->assign("ouTemp", array_reverse($dn));
        $this->cismarty->assign("ouData", $ouData);
        $this->cismarty->display($this->sysconfig_model->templates() . '/dept/deptadlist.tpl');
        // $this->load->view('adListLayout', $data);
    }

    function deptselect() {
        // $this->authorization->check_permission($this->uri->segment(2), '1');
        $this->load->model("deptsys_model");
        $root = $this->input->post('id');
        if (!$root) {
            $root = 0;
        }
        $result = $this->deptsys_model->get_dept_child_list('root = ' . $root); // child list
        $ouDnPost = array("DC=cn", "DC=Semir", "OU=Semir");
        $ouTemp = array();
        //echo $root;
        if ($root == '0') {
            $ouTemp = array();
        } else {
            $ouTemp = $this->deptsys_model->get_dept_child_DN('id = ' . $root);
            foreach ($ouTemp as $val) {
                $ouDnPost[] = 'OU=' . $val;
            }
        }
        // print_r($ouDnPost);
        array_unshift($ouTemp, "Semir"); // array 加元素
        //  print_r($resultTree);
        $this->cismarty->assign("ouDnPost", array_reverse($ouDnPost));
        $this->cismarty->assign("ouTemp", $ouTemp);  //array_unshift($fruits,"orange","pear")
        $this->cismarty->assign("ouData", $result);
        $this->cismarty->assign("rootid", $root);
        $this->cismarty->display($this->sysconfig_model->templates() . '/dept/deptselect.tpl');
        // $this->load->view('adListLayout', $data);
    }

    function list_to_tree($list, $pk = 'id', $pid = 'data', $child = 'children', $root = "OU=Semir") {
        // 创建Tree
        $tree = array();
        if (is_array($list)) {
            // 创建基于主键的数组引用
            $refer = array();
            foreach ($list as $key => $data) {
                $refer[$data[$pk]] = & $list[$key]; //array('id'=>$list[$key]['id'],'data' =>$list[$key]['pid']);
            }

            foreach ($list as $key => $data) {
                // 判断是否存在parent
                $parentId = $data[$pid];
                if ($root == $parentId) {
                    $tree[] = & $list[$key]; //array('id'=>$list[$key]['id'],'data' =>$list[$key]['pid']);
                    //print_r($list[$key]);
                } else {
                    if (isset($refer[$parentId])) {
                        $parent = & $refer[$parentId];
                        //print_r($refer[$parentId]);
                        $parent[$child][] = & $list[$key]; //array('id'=>$list[$key]['id'],'data' =>$list[$key]['pid']);
                    }
                }
            }
        }
        //print_r($tree);
        return $tree;
        //return "sdfsdf";
    }

    function outree() {
        // print_r($arr);
        $bbc = '';
        $this->load->library('adldaplibrary');
        $result = $this->adldaplibrary->OuList(array('Semir')); ///,adLDAP::ADLDAP_FOLDER, false
        //print_r($result);
        foreach ($result as $val) { //as $val
            if ($val['dn']) {
                $ouNameTemp = explode(",", $val['dn']);
                $ouName = explode("=", $ouNameTemp[0]);
                $ouNameP = explode("=", $ouNameTemp[1]);
                if ($ouName[0] == "OU") {
                    $bbc[] = array('id' => $ouName[1], 'pid' => $ouNameP[1], 'data' => $ouName[1], "attr" => array('id' => $val['dn'])); //'linkurl' => $val['dn']
                }
            }
        }
        //print_r($bbc);
        $ouTree = $this->list_to_tree($bbc, "id", "pid", "children", "Semir");
        // print_r($ouTree);
        echo json_encode($ouTree);
        //print_r($ouTree);
    }

    function dept_synctosys() {
        $action = $this->input->post('action');
        if ($action) {
            $this->load->model("deptsys_model");
            // $this->deptsys_model->truncate_formAd(); //清空staff dept table

            $this->load->library('adldaplibrary');
            $result = $this->adldaplibrary->OuList(array('Semir')); ///,adLDAP::ADLDAP_FOLDER, false
            // print_r($result);

            foreach ($result as $val) { //as $val
                if ($val['dn']) {
                    $ouNameTemp = explode(",", $val['dn']);
                    $ouName = explode("=", $ouNameTemp[0]);
                    $ouNameP = explode("=", $ouNameTemp[1]);
                    if ($ouName[0] == "OU") {

                        $rootData = $this->deptsys_model->get_dept_val("deptName ='" . $ouNameP[1] . "'");
                        //  echo $rootData->id;
                        //  echo $ouName[1].'<br>';
                        if ($rootData) {
                            // echo $rootData->id;
                            $saveData = array('root' => $rootData->id, 'deptName' => $ouName[1]);
                        } else {
                            $saveData = array('root' => 0, 'deptName' => $ouName[1]);
                        }
                        //
                        $this->deptsys_model->add_formAD($saveData);
                    }
                }
            }
            echo "同步成功！";
        } else {
            //$this->cismarty->assign("ouData", $ouData);
            $this->cismarty->display($this->sysconfig_model->templates() . '/dept/dept_synctosys.tpl');
        }
    }

    function dept_synctosys_user() {
        $action = $this->input->post('action');
        if ($action) {
            // $this->deptsys_model->truncate_formAd(); //清空staff dept table
            $bbc = '';
            $this->load->library('adldaplibrary');
            $result = $this->adldaplibrary->OuListUser(array('Semir')); ///,adLDAP::ADLDAP_FOLDER, false
            // print_r($result);
            foreach ($result as $val) { //as $val
                if ($val['dn']) {
                    // print_r($val['samaccountname'][0]); // login name
                    $ouNameTemp = explode(",", $val['dn']);
                    $cnName = explode("=", $ouNameTemp[0]);
                    $ouNameP = explode("=", $ouNameTemp[1]);
                    // print_r($cnName[1]); // 显示名称
                    //    $resultUser = $this->adldaplibrary->UserAccountInfo($val['samaccountname'][0]);
                    // 用户状态
                    $enabled = 2;
                    $resultEn = $this->adldaplibrary->UserAccountControl($val['samaccountname'][0]);
                    if ($resultEn == "正常") {
                        $enabled = 1;
                    }
                    if ($resultEn == "禁用") {
                        $enabled = 0;
                    }

                    // load rootid
                    $this->load->model("deptsys_model");
                    $resultRoot = $this->deptsys_model->get_dept_val("deptName = '" . $ouNameP[1] . "'");
                    if ($resultRoot) {
                        $rootid = $resultRoot->id;
                    } else {
                        $rootid = 0;
                    }

                    //print_r($val['samaccountname']);
                    // exit();
                    // print_r($rootid);
                    $data['rootid'] = $rootid;
                    $data['appstore'] = "ad"; //$this->input->post('appstore');
                    $data['cname'] = $cnName[1];
                    $data['username'] = $val['samaccountname'][0];
                    //  $data['surname'] = $this->input->post('surname');
                    // $data['firstname'] = $this->input->post('firstname');
                    $data['itname'] = $val['samaccountname'][0];
                    //  $data['password'] = $this->input->post('password');
                    //   $data['email'] = $this->input->post('email') . "@" . $this->input->post('domain');
                    $data['enabled'] = $enabled;
                    $data['addtime'] = date('Y-m-d H:i:s');
                    // write system data
                    $this->load->model("staff_model");
                    $this->staff_model->add($data);
                    //   $msg = $this->staff_model->add($data);
                    //   $saveData = array('root' => 0, 'deptName' => $ouName[1]);
                    //  $this->deptsys_model->add_formAD($saveData);
                }
            }
            echo "同步成功！";
        } else {
            //$this->cismarty->assign("ouData", $ouData);
            $this->cismarty->display($this->sysconfig_model->templates() . '/dept/dept_synctosys_user.tpl');
        }
        $this->output->enable_profiler(TRUE);
    }

    function get_post() {
        $data['title'] = $this->input->post('title');
        $data['description'] = $this->input->post('description');
        $data['content'] = $this->input->post('content');
        $data['classId'] = $this->input->post('classId');
        $data['keyword'] = $this->input->post('keyword');
        $data['author'] = $this->input->post('author');
        $data['staff_from'] = $this->input->post('staff_from');
        $data['edit_author'] = $this->input->post('edit_author');
        $data['is_best'] = $this->input->post('is_best');
        $data['staff_pic'] = $this->input->post('staff_pic');
        $data['post_time'] = $this->input->post('post_time');
        if ($this->uri->segment(3) == "edit") {
            if ($this->input->post('verify')) {
                $data['is_verified'] = $this->input->post('is_verified');
                $data['verifier'] = $this->session->userdata('admin');
                date_default_timezone_set("PRC");
                $data['verify_time'] = date("Y-m-d H:i:s");
            }
            $data['staff_id'] = $this->input->post('staff_id');
        }
        return $data;
    }

    function dept_add() {
        $this->authorization->check_permission($this->uri->segment(2), '2');

        if ($msg = $this->staff_model->add($this->get_post())) {
            echo $msg;
        }

        // $this->view();
    }

    function dept_edit() {
        $this->authorization->check_permission($this->uri->segment(2), '3');

        if ($msg = $this->staff_model->edit($this->get_post())) {
            echo $msg;
        }
    }

    function dept_del() {
        $this->authorization->check_permission($this->uri->segment(2), '4');
        if ($staff_id = $this->input->post('staff_id')) {
            $data['staff_id'] = $staff_id;
            if ($msg = $this->staff_model->del($data)) {
                echo $msg;
            } else {
                echo "删除操作失败,原因可能是当前记录不存在！";
            }
        }
    }

    function get_staff_id() {
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
        if ($data = $this->get_staff_id()) {
            if ($msg = $this->staff_model->multi_del($data)) {
                $this->view();
            } else {
                show_error("删除操作失败,原因可能是当前记录不存在！");
            }
        }
    }

    function physical_del() {
        $this->authorization->check_permission($this->uri->segment(2), '4');
        if ($data = $this->get_staff_id()) {
            if ($this->staff_model->physical_del($data)) {
                //$this->view();
                echo "ok";
            } else {
                show_error("删除操作失败,原因可能是当前记录不存在！");
            }
        }
    }

    function recover() {
        $this->authorization->check_permission($this->uri->segment(2), '3');
        if ($data = $this->get_staff_id()) {
            if ($this->staff_model->recover($data)) {
                //$this->view();
                echo "ok";
            } else {
                show_error("编辑失败,原因可能是当前记录不存在！");
            }
        }
    }

    // upload Pic  satart
    function uploadPicLink() {

        // return false;
        $name_array = explode("\.", $_FILES['userfile']['name']);
        date_default_timezone_set("PRC");
        $post_time = date("YmdHis");
        $file_type = $name_array[count($name_array) - 1];
        $realname = $post_time . "." . $file_type;
        $upload_dir = './attachments/staff/';

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
