<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('staff_model');
        $this->sysconfig_model->sysInfo(); // set sysInfo
    }

    function pagination($linkUrl, $linkModel, $uri_segment, $condition = "") {
        $this->load->library('pagination');
        $config['base_url'] = site_url($linkUrl);
        $config['total_rows'] = $this->staff_model->$linkModel($condition);
        $config['per_page'] = 30;
        $config['uri_segment'] = $uri_segment;
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }

    function showmenu() {
        $showmenu = "<ul>";
        $showmenu .= "<li><a href=" . site_url("staff/") . " >基本信息</a></li>";
        $showmenu .= "<li><a href=" . site_url("staff/staff_system") . " >系统权限</a></li>";
        $showmenu .="<li><a href=" . site_url("staff/syscon") . " >应用软件</a></li>";
        $showmenu .="<li><a href=" . site_url("staff/syscon") . " >网络信息</a></li>";
        $showmenu .="<li><a href=" . site_url("staff/syscon") . " >办公设备</a></li>";
        $showmenu .="<li><a href=" . site_url("staff/syscon") . " >人事档案</a></li>";
        $showmenu .="<li><a href=" . site_url("staff/syscon") . " >信息查询</a></li>";
        $showmenu .="</ul>";
        return $showmenu;
    }

    function index() {

        $id = $this->uri->segment(4, 0);
        $search = $this->input->post('searchText');
        if (!$id) {
            $id = 0;
        }
        $this->cismarty->assign('menuUrl', array('staff', 'index'));
        $this->cismarty->assign("id", $id);
        //$this->cismarty->assign("data", $data['staffs']);
        // $this->cismarty->assign("links", $data['links']);
        $this->cismarty->assign("showmenu", $this->showmenu());
        $this->cismarty->display($this->sysconfig_model->templates() . '/public/search.tpl');
    }

    function system() {

        $search = trim($this->input->post('key'));
        // $where = "itname like '%" . $search . "%' and cname like '%" . $search . "%'";
        $where = "itname = '" . $search . "' or cname = '" . $search . "'";
        //echo $where;
        $data['stafftemp'] = $this->staff_model->get_staffs(100, $this->uri->segment(5, 0), $where);
        //print_r($data['staffs']);
        // 读取用户AD状态
        if ($data['stafftemp']) {
            foreach ($data['stafftemp'] as $row) {
                // load dept
                $this->load->model("deptsys_model"); // load deptinfo
                $dept = $this->deptsys_model->get_dept_val("id = " . $row->rootid);
                if ($dept) {
                    $row->deptname = $dept->deptName;
                } else {
                    $row->deptname = "暂无";
                }
                // load system
                $system_id = explode(',', $row->system_id);
                if ($system_id) {
                    for ($i = 0; $i < count($system_id); $i++) {
                        //  echo $system_id[$i];
                        $sysTemp = $this->staff_model->get_system_by("keynumber = " . (int) $system_id[$i] . "");
                        if ($sysTemp) {
                            $row->systeminfo[] = $sysTemp->sysName;
                        } else {
                            $row->systeminfo[] = '';
                        }
                    }
                } else {
                    $row->systeminfo[] = array();
                }
                $data['staffs'][] = $row;
            }
        } else {
            $data['staffs'] = "";
        }
        // print_r($data['staffs']);
        // $this->load->view('staffLayout', $data);
        $this->cismarty->assign("data", $data['staffs']);
        $this->cismarty->display($this->sysconfig_model->templates() . '/public/system_result.tpl');
    }

    function sms() {

        $k = trim($this->input->post('key'));

        // $where .= "staff_sms.itname = '" . $search . "' or cname = '" . $search . "'";
        $where2 = "itname = '" . $k . "' or cname = '" . $k . "'";
        //echo $where;
        $stafftemp = $this->staff_model->get_staff_by($where2);
       // print_r($stafftemp);
        if ($stafftemp) {
            $where = "staff_sms.sm_status = 1";
            $where .= " and staff_sms.itname = '" . $stafftemp->itname . "' ";
               ///////////////////////////////////////
            ////$where = "staff_sms.sm_status = 1";
            $this->load->model('sms_model');
            $data['staff_sms'] = $this->sms_model->staff_sms_list_search(30, $this->uri->segment(6, 0), $where);
            if ($data['staff_sms']) {
                foreach ($data['staff_sms'] as $row) {
                    $itname = $row->itname;
                    $this->load->model('staff_model');
                    $result = $this->staff_model->get_staff_by("itname = '" . $itname . "'");
                    // print_r($result);
                    if ($result) {
                        $row->cname = $result->cname;
                        $this->load->model('deptsys_model');
                        ///////////////////////////////////////////////////////////////
//                    $ouTemp = $this->deptsys_model->get_dept_parent_ou('id = ' . $result->rootid);
//                    //   print_r($sms_dept);
//                    $deptId = $ouTemp[0]['deptId'];
//                    $dept['dept_id'] = $deptId; 
//
//                    $dept['sm_id'] = $row->sm_id;
//                    $this->sms_model->staff_sms_edit($dept);
                        /////////////////////////////////////////////////////////////////////////
                        // echo  $row->sm_id;
                        if ($row->dept_id > 0) {
                            $sms_dept = $this->deptsys_model->get_dept_val("id = " . $row->dept_id);
                            $stafftemp->deptName = $sms_dept->deptName;
                            $row->deptName = $sms_dept->deptName;
                        } else {
                            $stafftemp->deptName = "";
                            $row->deptName = "";
                        }
                        //print_r($sms_dept);
                    } else {
                        $row->cname = $row->itname;
                        $row->deptName = "";
                        $stafftemp->deptName = "";
                    }
                    //load sms category  /////////////////////// 
                    $category = $this->sms_model->sms_category_by("sc_id =" . $row->sc_root);
                    $row->category_name = $category->sc_name;
                    //load sms category  /////////////////////// 
                    if ($row->sms_brand == 0) {
                        $row->sms_brand = "无";
                    } else {
                        $brand = $this->sms_model->sms_brand_by("sb_id =" . $row->sms_brand);
                        $row->sms_brand = $brand->sb_name;
                    }
                }
            }
            //////////////////////////////////
        } else {
            $data['staff_sms'] = "";
         
        }

        //  print_r($data['stafftemp']);

        $this->cismarty->assign("staff", $stafftemp);
        $this->cismarty->assign("data", $data['staff_sms']);
        $this->cismarty->display($this->sysconfig_model->templates() . '/public/sms_result.tpl');
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

}