<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// 资产管理模块 lzd 20130108
class Sms_parts extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('email');
        $this->load->library('DX_Auth');
        $this->dx_auth->check_uri_permissions();
        $this->load->model('sms_parts_model');
        $this->sysconfig_model->sysInfo(); // set sysInfo
        $this->sysconfig_model->set_sys_permission(); // set controller permission
        $this->mainmenu_model->showMenu();
        $menuCurrent = $this->showConMenu();
        $model = $this->load->model("staff_model");
        $model = $this->load->model("deptsys_model");
        $this->cismarty->assign("menuController", $menuCurrent);
        $this->cismarty->assign("urlF", $this->uri->segment(2));
        $this->cismarty->assign("urlS", $this->uri->segment(3));
    }

    function pagination($linkUrl, $linkModel, $uri_segment, $condition = "") {
        $this->load->library('pagination');
        $config['base_url'] = site_url($linkUrl);
        $totla = $this->sms_parts_model->$linkModel('', '', $condition);
        ;
        $config['total_rows'] = count($totla);
        $config['per_page'] = 20;
        $config['uri_segment'] = $uri_segment;
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }

    function showConMenu() {
        $showmenu = NULL;
        $showmenu .= "<li><a href=" . site_url("sms/sms_parts/index") . " >领用流水</a></li>";
        $showmenu .= "<li><a href=" . site_url("sms/sms_parts/cklist") . " >配件仓库</a></li>";
        $showmenu .= "<li><a href=" . site_url("sms/sms_parts/jieyong") . " >借用流水</a></li>";
        $showmenu .= "<li><a href=" . site_url("sms/sms_parts/jieyong_cklist") . " >借用仓库</a></li>";
        return $showmenu;
    }

    function index() {
        $t = $this->uri->segment(4, 0);
        $k = $this->uri->segment(5, 0);
        $where = "";
        if (empty($k) && $k == 0) {
            $k = 0;
        } else {
            $where .= " and  sms_number  like '%" . $k . "%'";
        }
        //$where = "staff_sms.sm_status = 1";

        $data = $this->sms_parts_model->staff_sms_parts_result(50, $this->uri->segment(6, 0), $where);
        if ($data) {
            foreach ($data as $row) {
                // load part 
                $sms_part = $this->sms_parts_model->sms_parts_row("sp_number = '" . $row->sp_number . "'");
                if ($sms_part) {
                    $row->part = $sms_part->sp_name;
                } else {
                    $row->part = "已无名称";
                }

                // load staff
                $staff = $this->staff_model->get_staff_by("itname = '" . $row->itname . "'");
                if ($staff) {
                    $row->cname = $staff->cname;
                    $this->load->model('deptsys_model');
                    $sms_dept = $this->deptsys_model->get_dept_val("id = " . $staff->rootid);
                    if ($sms_dept) {
                        $ouTemp = $this->deptsys_model->get_dept_child_DN('id = ' . $staff->rootid);
                        if ($ouTemp) {
                            $row->deptOu = implode("&raquo;", $ouTemp);
                        } else {
                            $row->deptOu = "";
                        }
                        $row->deptName = $sms_dept->deptName;
                    } else {
                        $row->deptOu = "";
                        $row->deptName = "";
                    }
                } else {
                    $row->cname = $row->itname;
                    $row->deptOu = "";
                    $row->deptName = "";
                }
            }
        }
        // print_r($data);
        //  exit();
        $linkUrl = "sms/sms_parts/index/" . $t . "/" . $k . "/";
        $linkModel = "sms_parts_result"; //"staff_sms_num";
        $uri_segment = 6;
        $links = $this->pagination($linkUrl, $linkModel, $uri_segment, $where);
        $this->cismarty->assign('menuUrl', array('staff', 'index'));
        $this->cismarty->assign("links", $links);
        $this->cismarty->assign("data", $data);
        //   print_r($data);
        $this->cismarty->display($this->sysconfig_model->templates() . '/sms/sms_parts.tpl');
    }

    function cklist() {
        $t = $this->uri->segment(4, 0);
        $k = $this->uri->segment(5, 0);
        $where = "";
        if (empty($k) && $k == 0) {
            // echo 'sdf';
            $k = 0;
        } else {
            $where .= "  sp_number  like '%" . $k . "%'";
        }
        //$where = "staff_sms.sm_status = 1";

        $data = $this->sms_parts_model->sms_parts_result(20, $this->uri->segment(6, 0), $where);

        if ($data) {
            foreach ($data as $row) {
                $category = $this->sms_parts_model->sms_parts_category_row("spc_id =" . $row->spc_id);
                //  print_r($category);
                if ($category) {
                    $row->spc_name = $category->spc_name;
                } else {
                    $row->spc_name = "无此类别";
                }
            }
        }
        //  exit();
        // print_r($data);
        $linkUrl = "sms/sms_parts/cklist/" . $t . "/" . $k . "/";
        $linkModel = "sms_parts_result"; //"staff_sms_num";
        $uri_segment = 6;
        $links = $this->pagination($linkUrl, $linkModel, $uri_segment, $where);
        $this->cismarty->assign('menuUrl', array('staff', 'index'));

        $this->cismarty->assign("data", $data);
        $this->cismarty->assign("links", $links);

        $reUrl = $this->input->server('HTTP_REFERER');
        $this->cismarty->assign("reurl", $reUrl);
        //   print_r($data);
        $this->cismarty->display($this->sysconfig_model->templates() . '/sms/sms_parts_cklist.tpl');
    }

    function sms_parts_add() {
        $category = $this->sms_parts_model->sms_parts_category_result(0, 0, '');
        //print_r($smsAff);
        $reUrl = $this->input->server('HTTP_REFERER');
        $this->cismarty->assign("reurl", $reUrl);
        $this->cismarty->assign("category", $category);
        $this->cismarty->display($this->sysconfig_model->templates() . '/sms/sms_parts_add.tpl');
    }

    function sms_parts_add_com() {
        $data = $this->sms_parts_post();
        echo $this->sms_parts_model->sms_parts_add($data);
        $log['ul_title'] = "配件添加";
        $log['ul_function'] = json_encode($data);
        $this->saveUserLog($log);
    }

    function sms_parts_edit() {
        $category = $this->sms_parts_model->sms_parts_category_result(0, 0, '');
        $sp_id = $this->input->post('sp_id');
        $data = $this->sms_parts_model->sms_parts_row("sp_id = " . $sp_id);
        //print_r($smsAff);
        $reUrl = $this->input->server('HTTP_REFERER');
        $this->cismarty->assign("reurl", $reUrl);
        $this->cismarty->assign("category", $category);
        $this->cismarty->assign("data", $data);
        $this->cismarty->display($this->sysconfig_model->templates() . '/sms/sms_parts_edit.tpl');
    }

    function sms_parts_edit_com() {

        $data = $this->sms_parts_post();
        $data['sp_id'] = $this->input->post('sp_id');
        echo $this->sms_parts_model->sms_parts_edit($data);
        $log['ul_title'] = "配件编辑";
        $log['ul_function'] = json_encode($data);
        $this->saveUserLog($log);
    }

    function sms_parts_post() {
        $data['spc_id'] = $this->input->post('spc_id');
        $data['sp_number'] = strtoupper(trim($this->input->post('sp_number')));
        $data['sp_name'] = $this->input->post('sp_name');
        $data['sp_total'] = $this->input->post('sp_total');
        $data['sp_local'] = $this->input->post('sp_local');
        $data['sp_ck'] = $this->input->post('sp_ck');
        return $data;
    }

    function sms_parts_check() {
        $sp_number = strtoupper($this->input->post('sp_number'));
        $sms_part = $this->sms_parts_model->sms_parts_row("sp_number = '" . $sp_number . "'");
        if ($sms_part) {
            echo "false";
        } else {
            echo "true";
        }
    }

    function staff_sms_parts_edit() {
        $ss_id = $this->input->post('ss_id');
        $row = $this->sms_parts_model->staff_sms_parts_row("ss_id = " . $ss_id);
        // load part 
        $sms_part = $this->sms_parts_model->sms_parts_row("sp_number = '" . $row->sp_number . "'");
        if ($sms_part) {
            $row->part = $sms_part->sp_name;
        } else {
            $row->part = "已无名称";
        }

        // load staff
        $staff = $this->staff_model->get_staff_by("itname = '" . $row->itname . "'");
        if ($staff) {
            $row->cname = $staff->cname;
            $this->load->model('deptsys_model');
            $sms_dept = $this->deptsys_model->get_dept_val("id = " . $staff->rootid);
            if ($sms_dept) {
                $ouTemp = $this->deptsys_model->get_dept_child_DN('id = ' . $staff->rootid);
                if ($ouTemp) {
                    $row->deptOu = implode("&raquo;", $ouTemp);
                } else {
                    $row->deptOu = "";
                }
                $row->deptName = $sms_dept->deptName;
            } else {
                $row->deptOu = "";
                $row->deptName = "";
            }
        } else {
            $row->cname = $row->itname;
            $row->deptOu = "";
            $row->deptName = "";
        }
        // print_r($row);
        $reUrl = $this->input->server('HTTP_REFERER');
        $this->cismarty->assign("reurl", $reUrl);
        $this->cismarty->assign("data", $row);
        $this->cismarty->display($this->sysconfig_model->templates() . '/sms/staff_sms_parts_edit.tpl');
    }

    function staff_sms_parts_edit_com() {
        $ss_id = $this->input->post('ss_id');
        $type = $this->input->post('type');
        $number = $this->input->post('number');
        $ss_remark = $this->input->post('ss_remark');
        $row = $this->sms_parts_model->staff_sms_parts_row("ss_id = " . $ss_id);
        $sms_part = $this->sms_parts_model->sms_parts_row("sp_number = '" . $row->sp_number . "'");
        if ($type == 1) {  /// 1=出库，2=归还
            $tempVal = $sms_part->sp_total - $number;
            if ($tempVal >= 0) {
                // 计算总库存
                $up_sms_parts['sp_id'] = $sms_part->sp_id;
                $up_sms_parts['sp_total'] = $tempVal;
                $this->sms_parts_model->sms_parts_edit($up_sms_parts);
                $log['ul_title'] = "领用库存";
                $log['ul_function'] = json_encode($up_sms_parts);
                $this->saveUserLog($log);
                // 计算总库存

                $up_staff_parts['ss_id'] = $ss_id;
                $up_staff_parts['ss_total'] = $row->ss_total + $number;
                $up_staff_parts['ss_remark'] = $ss_remark;
                $up_staff_parts['op_user'] = $this->session->userdata('DX_username');
                $up_staff_parts['op_time'] = date('Y-m-d H:i:s');
                $this->sms_parts_model->staff_sms_parts_edit($up_staff_parts);
                $log['ul_title'] = "领用出库";
                $log['ul_function'] = json_encode($up_staff_parts);
                $this->saveUserLog($log);
                echo "ok";
            } else {
                echo "无库存，无法领用";
                exit;
            }
        } else {
            $tempVal = $row->ss_total - $number;
            if ($tempVal >= 0) {
                // 计算总库存
                $up_sms_parts['sp_id'] = $sms_part->sp_id;
                $up_sms_parts['sp_total'] = $sms_part->sp_total + $number;
                $this->sms_parts_model->sms_parts_edit($up_sms_parts);
                $log['ul_title'] = "领用库存";
                $log['ul_function'] = json_encode($up_sms_parts);
                $this->saveUserLog($log);
                // 计算总库存

                $up_staff_parts['ss_id'] = $ss_id;
                $up_staff_parts['ss_total'] = $row->ss_total - $number;
                $up_staff_parts['ss_remark'] = $ss_remark;
                $up_staff_parts['op_user'] = $this->session->userdata('DX_username');
                $up_staff_parts['op_time'] = date('Y-m-d H:i:s');
                $this->sms_parts_model->staff_sms_parts_edit($up_staff_parts);
                $log['ul_title'] = "领用出库";
                $log['ul_function'] = json_encode($up_staff_parts);
                $this->saveUserLog($log);
                echo "ok";
            } else {
                echo "归还数量比借出的还多？！";
                exit;
            }
        }
    }
/*
 * 
 * 借用类 lizd11
 * 
 */
    function jieyong_cklist() { 
        $t = 0;
        $k = $this->input->post('k');
        $where = "sj_status = 1";
        if (empty($k) && $k == 0) {
            // echo 'sdf';
            $k = 0;
        } else {
            $where .= " and sj_number  like '%" . $k . "%'";
        } 
        $data = $this->sms_parts_model->sms_jieyong_result(20, $this->uri->segment(6, 0), $where); 
        if ($data) {
            foreach ($data as $row) { 
                //  print_r($category);
                if ($row->spc_id ==1 ) {
                    $row->spc_name = '笔记本';
                } else {
                    $row->spc_name = "其他";
                }
            }
        }
        //  exit();
       // print_r($data);
        $linkUrl = "sms/sms_parts/jieyong_cklist/" . $t . "/" . $k . "/";
        $linkModel = "sms_jieyong_result"; //"staff_sms_num";
        $uri_segment = 6;
        $links = $this->pagination($linkUrl, $linkModel, $uri_segment, $where);
        $this->cismarty->assign('menuUrl', array('staff', 'index'));

        $this->cismarty->assign("data", $data);
        $this->cismarty->assign("links", $links);

        $reUrl = $this->input->server('HTTP_REFERER');
        $this->cismarty->assign("reurl", $reUrl);
        //   print_r($data);
        $this->cismarty->display($this->sysconfig_model->templates() . '/sms/sms_jieyong_cklist.tpl');
    }
    function sms_jieyong_add() {
       
        //print_r($smsAff);
        $reUrl = $this->input->server('HTTP_REFERER');
        $this->cismarty->assign("reurl", $reUrl); 
        $this->cismarty->display($this->sysconfig_model->templates() . '/sms/sms_jieyong_add.tpl');
    }

    function sms_jieyong_add_com() {
        $data = $this->sms_jieyong_post();
        echo $this->sms_parts_model->sms_jieyong_add($data);
        
        $log['ul_title'] = "借用资产添加";
        $log['ul_function'] = json_encode($data);
        $this->saveUserLog($log);
    }

    function sms_jieyong_edit() { 
        $sj_id = $this->input->post('sj_id');
        $data = $this->sms_parts_model->sms_jieyong_row("sj_id = " . $sj_id);
        //print_r($smsAff);
        $reUrl = $this->input->server('HTTP_REFERER');
        $this->cismarty->assign("reurl", $reUrl);
        $this->cismarty->assign("data", $data);
        $this->cismarty->display($this->sysconfig_model->templates() . '/sms/sms_jieyong_edit.tpl');
    }

    function sms_jieyong_edit_com() {

        $data = $this->sms_jieyong_post();
        $data['sj_id'] = $this->input->post('sj_id');
        echo $this->sms_parts_model->sms_jieyong_edit($data);
        $log['ul_title'] = "借用资产编辑";
        $log['ul_function'] = json_encode($data);
        $this->saveUserLog($log);
    }

    function sms_jieyong_post() {
        $data['spc_id'] = $this->input->post('spc_id');
        $data['sj_number'] = strtoupper(trim($this->input->post('sj_number')));
        $data['sj_name'] = $this->input->post('sj_name'); 
        $data['sj_local'] = $this->input->post('sj_local');
        $data['sj_ck'] = $this->input->post('sj_ck');
        return $data;
    }

    function sms_jieyong_check() {
        $sj_number = strtoupper($this->input->post('sj_number'));
        $row = $this->sms_parts_model->sms_jieyong_row("sj_number = '" . $sj_number . "'");
        if ($row) {
            echo "false";
        } else {
            echo "true";
        }
    }
       function jieyong() {
        $t = $this->uri->segment(4, 0);
        $k = $this->uri->segment(5, 0);
        $where = "ssj_status = 1";
        if (empty($k) && $k == 0) {
            $k = 0;
        } else {
            $where .= " and  sms_number  like '%" . $k . "%'";
        }
        //$where = "staff_sms.sm_status = 1";

        $data = $this->sms_parts_model->staff_sms_jieyong_result(20, $this->uri->segment(6, 0), $where);
        if ($data) {
            foreach ($data as $row) {
                // 使用周期
                $datetime1 = date_create($row->use_time);
                $datetime2 = date_create(date('Y-m-d h:i:s'));
                $interval = date_diff($datetime1, $datetime2);
                $row->timeOut = $interval->format('%a');
                // load part 
                $rowt = $this->sms_parts_model->sms_jieyong_row("sj_number = '" . $row->sj_number . "'");
                if ($rowt) {
                    $row->jieyong = $rowt->sj_name;
                } else {
                    $row->jieyong = "已无名称";
                }

                // load staff
                $staff = $this->staff_model->get_staff_by("itname = '" . $row->itname . "'");
                if ($staff) {
                    $row->cname = $staff->cname;
                    $this->load->model('deptsys_model');
                    $sms_dept = $this->deptsys_model->get_dept_val("id = " . $staff->rootid);
                    if ($sms_dept) {
                        $ouTemp = $this->deptsys_model->get_dept_child_DN('id = ' . $staff->rootid);
                        if ($ouTemp) {
                            $row->deptOu = implode("&raquo;", $ouTemp);
                        } else {
                            $row->deptOu = "";
                        }
                        $row->deptName = $sms_dept->deptName;
                    } else {
                        $row->deptOu = "";
                        $row->deptName = "";
                    }
                } else {
                    $row->cname = $row->itname;
                    $row->deptOu = "";
                    $row->deptName = "";
                }
            }
        }
        //  print_r($data);
        //  exit();
        $linkUrl = "sms/sms_parts/jieyong/" . $t . "/" . $k . "/";
        $linkModel = "staff_sms_jieyong_result"; //"staff_sms_num";
        $uri_segment = 6;
        $links = $this->pagination($linkUrl, $linkModel, $uri_segment, $where);
        $this->cismarty->assign('menuUrl', array('staff', 'index'));
        $this->cismarty->assign("links", $links);
        $this->cismarty->assign("data", $data);
        //   print_r($data);
        $this->cismarty->display($this->sysconfig_model->templates() . '/sms/staff_jieyong.tpl');
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
        $data['ul_model'] = '配件管理';
        $this->sysconfig_model->sys_user_log($data);
    }

}

?>