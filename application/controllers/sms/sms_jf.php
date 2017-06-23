<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// 资产管理模块 lzd 20130108
class Sms_jf extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('email');
        $this->load->library('DX_Auth');
        $this->dx_auth->check_uri_permissions();
        $this->load->model('sms_model');
        $this->sysconfig_model->sysInfo(); // set sysInfo
        $this->sysconfig_model->set_sys_permission(); // set controller permission
        $this->mainmenu_model->showMenu();
        $menuCurrent = $this->showConMenu();
        $model = $this->load->model("deptsys_model");
        $this->cismarty->assign("menuController", $menuCurrent);
        $this->cismarty->assign("urlF", $this->uri->segment(2));
        $this->cismarty->assign("urlS", $this->uri->segment(3));
    }

    function pagination($linkUrl, $linkModel, $uri_segment, $condition = "") {
        $this->load->library('pagination');
        $config['base_url'] = site_url($linkUrl);
        $totla = $this->sms_model->$linkModel('', '', $condition);
        ;
        $config['total_rows'] = count($totla);
        $config['per_page'] = 20;
        $config['uri_segment'] = $uri_segment;
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }

    function paginationNew($linkUrl, $uri_segment, $totla) {
        $this->load->library('pagination');
        $config['base_url'] = site_url($linkUrl);
        // $totla = $this->sms_model->$linkModel('','',$condition);;
        $config['total_rows'] = $totla;
        $config['per_page'] = 20;
        $config['uri_segment'] = $uri_segment;
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }

    function showConMenu() {
        $showmenu = NULL;
        $showmenu .= "<li><a href=" . site_url("sms/sms_jf/index") . " >机房资产</a></li>";
        $showmenu .= "<li><a href=" . site_url("sms/sms_jf/kc_list") . " >仓库资产</a></li>";

        return $showmenu;
    }

    function index() {
        $t = $this->uri->segment(4, 0);
        $k = $this->uri->segment(5, 0);
        $where = "sms_status = 1";
        if (empty($k) && $k == 0) {
            // echo 'sdf';
            $k = 0;
        } else {
            $where .= " and  sms_number  like '%" . $k . "%'";
        }
        //$where = "staff_sms.sm_status = 1";

        $data['sms_jf'] = $this->sms_model->sms_jf_list(20, $this->uri->segment(6, 0), $where);
        if ($data['sms_jf']) {
            foreach ($data['sms_jf'] as $row) {
                if ($row->sms_cat_id) {
                    $category = $this->sms_model->sms_jf_category_by("sc_id =" . $row->sms_cat_id);
                    //  print_r($category);
                    if ($category) {
                        $row->sc_name = $category->sc_name;
                    } else {
                        $row->sc_name = "";
                    }
                } else {
                    $row->sc_name = "";
                }
            }
        }
        //  exit();

        $linkUrl = "sms/jf_sms/index/" . $t . "/" . $k . "/";
        $linkModel = "sms_jf_list"; //"staff_sms_num";
        $uri_segment = 6;
        $data['links'] = $this->pagination($linkUrl, $linkModel, $uri_segment, $where);
        $this->cismarty->assign('menuUrl', array('staff', 'index'));
        $this->cismarty->assign("data", $data['sms_jf']);
        $this->cismarty->assign("links", $data['links']);
        //   print_r($data);
        $this->cismarty->display($this->sysconfig_model->templates() . '/sms/sms_jf_list.tpl');
    }

    function kc_list() {
        $t = $this->uri->segment(4, 0);
        $k = $this->uri->segment(5, 0);
        $where = "sms_status = 0";
        if (empty($k) && $k == 0) {
            // echo 'sdf';
            $k = 0;
        } else {
            $where .= " and  sms_number  like '%" . $k . "%'";
        }
        //$where = "staff_sms.sm_status = 1";

        $data['sms_jf'] = $this->sms_model->sms_jf_list(20, $this->uri->segment(6, 0), $where);
        if ($data['sms_jf']) {
            foreach ($data['sms_jf'] as $row) {
                if ($row->sms_cat_id) {
                    $category = $this->sms_model->sms_jf_category_by("sc_id =" . $row->sms_cat_id);
                    //  print_r($category);
                    if ($category) {
                        $row->sc_name = $category->sc_name;
                    } else {
                        $row->sc_name = "";
                    }
                } else {
                    $row->sc_name = "";
                }
            }
        }
        //  exit();

        $linkUrl = "sms/sms_jf/kc_list/" . $t . "/" . $k . "/";
        $linkModel = "sms_jf_list"; //"staff_sms_num";
        $uri_segment = 6;
        $data['links'] = $this->pagination($linkUrl, $linkModel, $uri_segment, $where);
        $this->cismarty->assign('menuUrl', array('staff', 'index'));
        $this->cismarty->assign("data", $data['sms_jf']);
        $this->cismarty->assign("links", $data['links']);
        //   print_r($data);
        $this->cismarty->display($this->sysconfig_model->templates() . '/sms/sms_jf_kc_list.tpl');
    }

    function staff_sms_add() {

        $reUrl = $this->input->server('HTTP_REFERER');
        $this->cismarty->assign("reurl", $reUrl);
        $this->cismarty->display($this->sysconfig_model->templates() . '/sms/staff_sms_add.tpl');
    }

    function staff_sms_add_com() {
        // $sms_number = $this->input->post('sms_number');
        $sms_number[] = $this->input->post('sms_number1');
        $sms_number[] = $this->input->post('sms_number2');
        $sms_number[] = $this->input->post('sms_number3');

        $data['itname'] = $this->input->post('itname');
        $data['dept_id'] = $this->input->post('dept_id');
        $data['use_time'] = date('Y-m-d H:i:s');
        $data['sm_type'] = $this->input->post('sm_type');
        $data['sm_remark'] = $this->input->post('sm_remark');

        $data['op_user'] = $this->input->post('op_user');
        $data['op_time'] = date('Y-m-d H:i:s');
        //  print_r($sms_number);
        $sms_temp = $sms_number;

        // print_r($sms_temp);
        //$msg = $this->staff_model->add($data);
        if ($sms_temp) {
            for ($s = 0; $s < count($sms_temp); $s++) {
                if ($sms_temp[$s]) {
                    $main['sms_number'] = $sms_temp[$s];
                    $main['sms_status'] = 2;
                    $main['sms_kuwei'] = 2;
                    //$main['sms_sap_status'] = 0;
                    $this->sms_model->sms_main_edit($main); //set sms main status

                    $ruselt = $this->sms_model->staff_sms_by("sms_number = '" . $sms_temp[$s] . "' and sm_status = 1");
                    if ($ruselt) {
                        $dept['dept_id'] = $data['dept_id'];
                        $dept['sms_number'] = $sms_temp[$s];
                        $dept['sm_status'] = 2;
                        $dept['return_time'] = date('Y-m-d H:i:s');
                        $this->sms_model->staff_sms_edit($dept); // set staff sms history status
                    }
                    if ($this->input->post('sms_number1') == $sms_temp[$s]) { // 判读是否是主机编号
                        if ($this->input->post('ipType') == 1) {
                            $data['sms_ip'] = $this->input->post('ip1');
                        } else {
                            // locad 原ip
                            $old['sms_number'] = $this->input->post('oldSmsNumber');
                            $old['sms_ip'] = '';
                            $this->sms_model->staff_sms_edit($old); // set staff sms history status
                            $data['sms_ip'] = $this->input->post('ip2');
                        }
                    } else {
                        $data['sms_ip'] = '';
                    }


                    // exit();
                    $data['sm_status'] = 1;
                    $data['sms_number'] = $sms_temp[$s];
                    $data['sm_sap_status'] = 0;
                    // print_r($data);
                    // exit();
                    $this->sms_model->staff_sms_add($data);
                    // save  log
                    $log['ul_title'] = "资产借用";
                    $log['ul_function'] = json_encode($data);
                    $this->saveUserLog($log);
                    // loading sms info

                    if ($data['sm_type'] != 2) {
                        $tomail['sms_number'] = $sms_temp[$s];
                        $numkey = substr($tomail['sms_number'], 0, 1);
                        if (in_array($numkey, array('S', 's'))) {
                            $tomail['type'] = $data['sm_type'];
                            $tomail['itnameOld'] = '';
                            $tomail['itname'] = $data['itname'];
                            $tomail['sm_remark'] = $data['sm_remark'];
                            //  print_r($smsCate);
                            $this->sendemail($tomail);
                        }
                    }
                }
            }
            echo 1;
            // send email to 财务
        } else {
            echo 0; //  
        }
    }

    function sms_jf_out() {
        $sms_id = $this->input->post('sms_id');
        $row = $this->sms_model->sms_jf_by("sms_id = " . $sms_id);
        //  print_r($row);
        if ($row) {

            $this->cismarty->assign("data", $row);
            $this->cismarty->display($this->sysconfig_model->templates() . '/sms/sms_jf_out.tpl');
        } else {
            echo '参数错误！<br>请确认操作记录。';
        }
    }

    function sms_jf_out_do() {
        $sms_id = $this->input->post('sms_id');
        $row = $this->sms_model->sms_jf_by("sms_id = " . $sms_id);
        //  print_r($row);
        if ($row) {
            $main['sms_id'] = $sms_id;
            $main['sms_status'] = 1;
            $main['sms_local'] = $this->input->post('sms_local');
            $main['out_itname'] = $this->session->userdata('DX_username');
            $main['out_time'] = date('Y-m-d H:i:s');
            $this->sms_model->sms_jf_editbyId($main); //set sms main status 
            // save  log
            $log['ul_title'] = "仓库资产出库";
            $log['ul_function'] = json_encode($main);
            $this->saveUserLog($log);
            echo 1;
        } else {
            echo 0;
        }
    }

    function sms_jf_return() {
        $sms_id = $this->input->post('sms_id');
        $row = $this->sms_model->sms_jf_by("sms_id = " . $sms_id);

        if ($row) {

            $main['sms_id'] = $sms_id;
            $main['sms_status'] = 0;
            $this->sms_model->sms_jf_editbyId($main); //set sms main status 
            // save  log
            $log['ul_title'] = "仓库资产收回";
            $log['ul_function'] = json_encode($main);
            $this->saveUserLog($log);

            echo 1;
        } else {
            echo 0;
        }
    }

    function sms_jf_main_add() {
         
        //print_r($smsAff);
        $reUrl = $this->input->server('HTTP_REFERER');
        $this->cismarty->assign("reurl", $reUrl); 
        $this->cismarty->display($this->sysconfig_model->templates() . '/sms/sms_jf_add.tpl');
    }

    function sms_jf_add_com() {
        $data = $_POST;
        //  print_r($data);
        //$msg = $this->staff_model->add($data);

        if ($data['sms_cate_3']) {
            unset($data['sms_cate_1']);
            unset($data['sms_cate_2']);
            $data['sms_cat_id'] = $data['sms_cate_3'];
            unset($data['sms_cate_3']);
            $this->sms_model->sms_jf_main_add($data);

            echo 1;
            // add user to RTX
        } else {
            echo 0; // 写数据库失败成功
        }
        // save  log
        $log['ul_title'] = "新增资产";
        $log['ul_function'] = json_encode($data);
        $this->saveUserLog($log);
    }

    function sms_jf_edit() {
        $sms_id = $this->uri->segment(4, 0);
        $row = $this->sms_model->sms_jf_by("sms_id = " . $sms_id);
        if ($row) {
            $catergoryS = $this->sms_model->sms_jf_category_by("sc_id = " . $row->sms_cat_id);

            if ($catergoryS) {
                $row->cateid2 = $catergoryS->sc_root;
                $catergoryF = $this->sms_model->sms_jf_category_by("sc_id = " . $catergoryS->sc_root);
                if ($catergoryF) {
                    $row->cateid1 = $catergoryF->sc_root;
                }
            } else {
                $row->cateid2 = "";
                $row->cateid1 = "";
            }

            $reUrl = $this->input->server('HTTP_REFERER');
            $this->cismarty->assign("reurl", $reUrl);
            $this->cismarty->assign("data", $row);
            $this->cismarty->display($this->sysconfig_model->templates() . '/sms/sms_jf_edit.tpl');
        } else {
            echo "资产信息错误，请确认！！";
        }
    }

    function sms_jf_edit_com() {
        $data = $_POST;
        //   print_r($data);
        //$msg = $this->staff_model->add($data);
        if ($data['sms_cate_3']) {
            unset($data['sms_cate_1']);
            unset($data['sms_cate_2']);
            $data['sms_cat_id'] = $data['sms_cate_3'];
            unset($data['sms_cate_3']);

            $result = $this->sms_model->sms_jf_main_edit($data);
            // print_r($result);
            if ($result) {
                // save  log
                $log['ul_title'] = "资产编辑";
                $log['ul_function'] = json_encode($data);
                $this->saveUserLog($log);
                echo 1;
            } else {
                echo 2;
            }
            // add user to RTX
        } else {
            echo 0; // 写数据库失败成功
        }
    }

    function sms_jf_category_select() {
        $arr = "";
        $root = $this->input->post('root');
        if (!$root) {
            $root = 1;
        }
        $result = $this->sms_model->sms_jf_category_list('', '', '');
        //print_r($result);
        //echo  $id;
        foreach ($result as $val) { //as $val
            $arr[] = array('sc_id' => $val->sc_id, 'sc_root' => $val->sc_root, 'n' => $val->sc_name);
        }
        $ouTree = $this->list_to_tree($arr, "sc_id", "sc_root", "c", 0, $root);
        foreach ($ouTree as $row) { //as $val
            if ($row['sc_id'] == $root) {
                $category = $row['c'];
            }
        }
        //  print_r($category);
        print_r(json_encode($category));
    }

    function list_to_tree($list, $pk = 'id', $pid = 'data', $child = 'children', $root = "OU=Semir", $nowid = 0) {
        // 创建Tree
        $tree = array();
        if (is_array($list)) {
            // 创建基于主键的数组引用
            $refer = array();
            $temPid = "";
            foreach ($list as $key => $data) {
                $refer[$data[$pk]] = & $list[$key]; //array('id'=>$list[$key]['id'],'data' =>$list[$key]['pid']);
                if ($nowid == $list[$key][$pk]) {
                    $list[$key]["state"] = "open";
                    $temPid = $list[$key][$pid];
                }
                // print_r($refer[$data[$pk]]);
            }
            // print_r($temPid);

            foreach ($list as $key => $data) {
                // 判断是否存在parent
                $parentId = $data[$pid];
                if ($root == $parentId) {
                    // echo $root;
                    if ($temPid == $list[$key][$pk]) {
                        $list[$key]["state"] = "open";
                        $temPid = $list[$key][$pid];
                    }
                    $tree[] = & $list[$key]; //array('id'=>$list[$key]['id'],'data' =>$list[$key]['pid']);
                    //print_r( $list[$key]);
                } else {
                    if (isset($refer[$parentId])) {

                        $parent = & $refer[$parentId];

                        $parent[$child][] = & $list[$key]; //array('id'=>$list[$key]['id'],'data' =>$list[$key]['pid']);
                        // print_r( $list[$key]);
                    }
                }
            }
        }
        //print_r($tree);
        return $tree;
        //return "sdfsdf";
    }

    ///
    function sms_jf_main_scrap() {    ////////////////////报废
        $sms_id = $this->input->post('sms_id');
        $row = $this->sms_model->sms_jf_by("sms_id = " . $sms_id);
        if ($row) {
            // print_r($sms_main); 
            $main['sms_id'] = $row->sms_id;
            $main['sms_status'] = 2;
            $main['baofei_itname'] = $this->session->userdata('DX_username');
            $main['baofei_time'] = date('Y-m-d H:i:s');
            $this->sms_model->sms_jf_editbyId($main); //set sms main status 
            // save  log
            $log['ul_title'] = "资产报废";
            $log['ul_function'] = json_encode($main);
            $this->saveUserLog($log);
            echo 1;
        }
    }

    function history_list() {
        $t = $this->uri->segment(4, 0);
        $k = $this->uri->segment(5, 0);
        $where = "staff_sms.sm_status = 2";
        if ($t == 2) {
            $type = "staff_sms.sms_number";
        } else {
            $type = "staff_sms.itname";
            $t = 1;
        }
        if (empty($k) && $k == 0) {
            // echo 'sdf';
            $k = 0;
        } else {
            $where .= " and " . $type . " like '%" . $k . "%'";
        }
        //$where = "staff_sms.sm_status = 1";
        $data['staff_sms'] = $this->sms_model->staff_sms_history_list(20, $this->uri->segment(6, 0), $where);
        if ($data['staff_sms']) {
            foreach ($data['staff_sms'] as $row) {
                $itname = $row->itname;
                $this->load->model('staff_model');
                $result = $this->staff_model->get_staff_by("itname = '" . $itname . "'");
                // print_r($result);
                if ($result) {
                    $row->cname = $result->cname;
                    $this->load->model('deptsys_model');
                    if ($row->dept_id > 0) {
                        $sms_dept = $this->deptsys_model->get_dept_val("id = " . $row->dept_id);
                        if ($sms_dept) {
                            $row->deptName = $sms_dept->deptName;
                        } else {
                            $row->deptName = "";
                        }
                    } else {
                        $row->deptName = "";
                    }
                    // $row->deptName = $this->staffDeptName($itname);
                    //print_r($sms_dept);
                } else {
                    $row->cname = $row->itname;
                    $row->deptName = "";
                }
                //load sms main  /////////////////////// 
                $smsMain = $this->loadSmsMain($row->sms_number);
                if ($smsMain) {
                    $row->sms_sapnumber = $smsMain->sms_sapnumber;
                    $row->sc_name = $smsMain->sc_name;
                    $row->category_name = $smsMain->category_name;
                    $row->sms_brand = $smsMain->sms_brand;
                    $row->sms_size = $smsMain->sms_size;
                    $row->sl_name = $smsMain->sl_name;
                    $row->sa_name = $smsMain->sa_name;
                } else {
                    $row->sms_sapnumber = "";
                    $row->sc_name = "";
                    $row->category_name = "";
                    $row->sms_brand = "";
                    $row->sms_size = "";
                    $row->sl_name = "";
                    $row->sa_name = "";
                }
            }
        }
        // print_r($data);

        $linkUrl = "sms/sms/history_list/" . $t . "/" . $k . "/";
        $linkModel = "staff_sms_history_list";
        $uri_segment = 6;
        $data['links'] = $this->pagination($linkUrl, $linkModel, $uri_segment, $where);
        $this->cismarty->assign('menuUrl', array('staff', 'index'));
        $this->cismarty->assign("data", $data['staff_sms']);
        $this->cismarty->assign("links", $data['links']);
        $this->cismarty->display($this->sysconfig_model->templates() . '/sms/sms_history_list.tpl');
    }

    function cut_str($string, $sublen, $start = 0, $code = 'UTF-8') {
        if ($code == 'UTF-8') {
            $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
            preg_match_all($pa, $string, $t_string);

            if (count($t_string[0]) - $start > $sublen)
                return join('', array_slice($t_string[0], $start, $sublen)) . "";
            return join('', array_slice($t_string[0], $start, $sublen));
        }
        else {
            $start = $start * 2;
            $sublen = $sublen * 2;
            $strlen = strlen($string);
            $tmpstr = '';

            for ($i = 0; $i < $strlen; $i++) {
                if ($i >= $start && $i < ($start + $sublen)) {
                    if (ord(substr($string, $i, 1)) > 129) {
                        $tmpstr.= substr($string, $i, 2);
                    } else {
                        $tmpstr.= substr($string, $i, 1);
                    }
                }
                if (ord(substr($string, $i, 1)) > 129)
                    $i++;
            }
            if (strlen($tmpstr) < $strlen)
                $tmpstr.= "...";
            return $tmpstr;
        }
    }

    function saveUserLog($data) {
        $data['ul_username'] = $this->session->userdata('DX_username');
        $data['ul_time'] = date('Y-m-d H:i:s');
        $data['ul_model'] = '资产管理';
        $this->sysconfig_model->sys_user_log($data);
    }

}

?>