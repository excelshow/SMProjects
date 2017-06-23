<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// 资产管理模块 lzd 20130108
class Sms extends CI_Controller {

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
        $showmenu .= "<li><a href=" . site_url("sms/sms/index") . " >用户资产</a></li>";
        $showmenu .= "<li><a href=" . site_url("sms/sms/sms_main_list") . " >仓库资产</a></li>";
        $showmenu .="<li><a href=" . site_url("sms/sms/finance") . " >财务审核</a></li>";
        $showmenu .="<li><a href=" . site_url("sms/sms/history_list") . " >历史报表</a></li>";
        $showmenu .="<li><a href=" . site_url("sms/sms/reports") . " >统计报表</a></li>";
        $showmenu .="<li><a href=" . site_url("sms/sms/ip_layout") . " >IP管理</a></li>";
        $showmenu .="<li><a href=" . site_url("sms/config") . " >资产配置</a></li>";

        return $showmenu;
    }

    function index() {
        $t = $this->uri->segment(4, 0);
        $k = $this->uri->segment(5, 0);
        $where = "staff_sms.sm_status = 1";
        if (empty($k) && $k == 0) {
            // echo 'sdf';
            $k = 0;
        } else {
            if ($t == 2) {
                //  $type = "staff_sms.sms_number";
                $where .= " and  staff_sms.sms_number  like '%" . $k . "%'";
            } else {
                $type = "staff_sms.itname";
                $where .= " and  ( staff_sms.itname  like '%" . urldecode($k) . "%') "; // or staff_main.cname  like '%" . urldecode($k) . "%'
                $t = 1;
            }
            // $where .= " and " . $type . " like '%" . $k . "%'";
        }
        //$where = "staff_sms.sm_status = 1";
        $data['staff_sms'] = $this->sms_model->staff_sms_list(20, $this->uri->segment(6, 0), $where);
        // print_r($data);
        if ($data['staff_sms']) {
            foreach ($data['staff_sms'] as $row) {
                //load staff   /////////////////////// 
                $itname = $row->itname;
                $this->load->model('staff_model');
                $result = $this->staff_model->get_staff_by("itname = '" . $itname . "'");
                // print_r($result);
                if ($result) {
                    $row->cname = $result->cname;
                    $this->load->model('deptsys_model');
                    if ((int) $row->dept_id > 0) {
                        $sms_dept = $this->deptsys_model->get_dept_val("id = " . $result->rootid);
                        ////
                        ///
                        if ($sms_dept) {
                            $ouTemp = $this->deptsys_model->get_dept_child_DN('id = ' . $result->rootid);
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
                        $row->deptOu = "";
                        $row->deptName = "";
                    }
                    // $row->deptName = $this->staffDeptName($itname);
                    //print_r($sms_dept);
                } else {
                    $row->cname = $row->itname;
                    $row->deptOu = "";
                    $row->deptName = "";
                }
                //load sms main  /////////////////////// 
                $smsMain = $this->loadSmsMain($row->sms_number);
                if ($smsMain) {
                    $row->sms_id = $smsMain->sms_id;
                    $row->sms_sapnumber = $smsMain->sms_sapnumber;
                    $row->sc_name = $smsMain->sc_name;
                    $row->category_name = $smsMain->category_name;
                    $row->sms_brand = $smsMain->sms_brand;
                    $row->sms_size = $smsMain->sms_size;
                    $row->sl_name = $smsMain->sl_name;
                    $row->sa_name = $smsMain->sa_name;
                } else {
                    $row->sms_id = '';
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
        //  print_r($data);

        $linkUrl = "sms/sms/index/" . $t . "/" . $k . "/";
        $linkModel = "staff_sms_list"; //"staff_sms_num";
        $uri_segment = 6;
        $data['links'] = $this->pagination($linkUrl, $linkModel, $uri_segment, $where);
        $this->cismarty->assign('menuUrl', array('staff', 'index'));
        $this->cismarty->assign("data", $data['staff_sms']);
        $this->cismarty->assign("links", $data['links']);

        $this->cismarty->display($this->sysconfig_model->templates() . '/sms/staff_sms_list.tpl');
    }

    function loadSmsMain($sms_number) {
        $data = $this->sms_model->sms_main_by("sms_number = '" . $sms_number . "'");
        if ($data) {
            if ($data->sms_cat_id) {
                $category = $this->sms_model->sms_category_by("sc_id =" . $data->sms_cat_id);
                if ($category) {
                    $data->sc_name = $category->sc_name;
                    $categoryRoot = $this->sms_model->sms_category_by("sc_id =" . $category->sc_root);
                    if ($categoryRoot) {
                        $data->category_name = $categoryRoot->sc_name;
                    } else {
                        $data->category_name = '';
                    }
                } else {
                    $data->sc_name = "";
                    $data->category_name = '';
                }
            } else {
                $data->sc_name = "";
                $data->category_name = '';
            }
            //////
            if ($data->sms_brand) {
                $brand = $this->sms_model->sms_brand_by("sb_id =" . $data->sms_brand);
                $data->sms_brand = $brand->sb_name;
            } else {
                $data->sms_brand = "无";
            }
            //////
            if ($data->sms_local) {
                $location = $this->sms_model->sms_location_by("sl_id =" . $data->sms_local);
                $data->sl_name = $location->sl_name;
            } else {
                $data->sl_name = "";
            }
            //////
            if ($data->sa_id) {
                $location = $this->sms_model->sms_affiliate_by("sa_id =" . $data->sa_id);
                $data->sa_name = $location->sa_name;
            } else {
                $data->sa_name = "";
            }
        } else {
            
        }
        return $data;
    }

    function deptSmsList() {
        $itname = $this->input->post('itname');
        $this->load->model('staff_model');
        $staff = $this->staff_model->get_staff_by("itname ='" . $itname . "'");

        $this->load->model('deptsys_model');
        $ouTemp = $this->deptsys_model->get_dept_parent_ou('id = ' . $staff->rootid);
        //print_r($ouTemp);
        //  $deptName = $ouTemp[0]['deptName'];
        $deptId = $ouTemp[0]['deptId'];
        $sms_dept = $this->sms_model->get_sms_dept("staff_sms.itname = ''and staff_sms.sm_status=2 and staff_sms.dept_id = " . $deptId);

        $this->cismarty->assign("deptName", $ouTemp[0]);
        $this->cismarty->assign("sms_dept", $sms_dept);
        // $this->cismarty->assign("ipAddress", $ipAddress);
        $this->cismarty->display($this->sysconfig_model->templates() . '/sms/sms_dept_list.tpl');
        //print_r($sms_dept);
    }

    function staffDeptName($itname) {

        $itname = $itname;
        $this->load->model('staff_model');
        $staff = $this->staff_model->get_staff_by("itname ='" . $itname . "'");
        if ($staff) {
            $this->load->model('deptsys_model');
            $ouTemp = $this->deptsys_model->get_dept_parent_ou('id = ' . $staff->rootid);
            if ($ouTemp) {
                $deptName = $ouTemp[0]['deptName'];
                return $deptName;
            } else {
                return '无部门';
            }
        } else {
            return '无部门';
        }
        //print_r($sms_dept);
    }

    function staffDeptId($itname) {

        $itname = $itname;
        $this->load->model('staff_model');
        $staff = $this->staff_model->get_staff_by("itname ='" . $itname . "'");

        $this->load->model('deptsys_model');
        $ouTemp = $this->deptsys_model->get_dept_parent_ou('id = ' . $staff->rootid);
        //print_r($ouTemp);
        $deptId = $ouTemp[0]['deptId'];
        if ($deptId) {
            return $deptId;
        } else {
            return 0;
        }
        //print_r($sms_dept);
    }

    function staff_sms_add() {

        $reUrl = $this->input->server('HTTP_REFERER');
        $this->cismarty->assign("reurl", $reUrl);
        $this->cismarty->display($this->sysconfig_model->templates() . '/sms/staff_sms_add.tpl');
    }

    function staff_sms_add_com() {

        $sms_number = $this->input->post('sms_number');
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
        $sms_temp = array_filter($sms_number);

        //$msg = $this->staff_model->add($data);
        if ($sms_temp) {
            foreach ($sms_temp as $row) {
                $main['sms_number'] = $row;
                $main['sms_status'] = 2;
                //$main['sms_sap_status'] = 0;
                $this->sms_model->sms_main_edit($main); //set sms main status

                $ruselt = $this->sms_model->staff_sms_by("sms_number = '" . $row . "'");
                if ($ruselt) {
                    $dept['dept_id'] = $data['dept_id'];
                    $dept['sms_number'] = $row;
                    $dept['sm_status'] = 2;
                    $dept['return_time'] = date('Y-m-d H:i:s');
                    $this->sms_model->staff_sms_edit($dept); // set staff sms history status
                }
                if ($sms_number[0]) { // 判读是否是主机编号
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
                $data['sm_status'] = 1;
                $data['sms_number'] = $row;
                $data['sm_sap_status'] = 0;
                $this->sms_model->staff_sms_add($data);
                
                // save  log
                $log['ul_title'] = "资产借用";
                $log['ul_function'] = json_encode($data);
                $this->saveUserLog($log);
                
                // loading sms info
                $tomail['sms_number'] = $row;
                $tomail['type'] = $data['sm_type'];
                $tomail['itnameOld'] = '';
                $tomail['itname'] = $data['itname'];
                $tomail['sm_remark'] = $data['sm_remark'];
                //  print_r($smsCate);
                $this->sendemail($tomail);
            }
            echo 1;
            // send email to 财务
        } else {
            echo 0; //  
        }
    }

    function staff_sms_move() {

        $id = $this->uri->segment(4, 0);
        $staff_sms = $this->sms_model->staff_sms_by_join('staff_sms.sm_id =' . $id);
        //  print_r($staff_sms);
        if ($staff_sms) {
            $smsCate = $this->sms_model->sms_category_by("sc_id = " . $staff_sms->sms_cat_id);
            //  print_r($smsCate);
            $deptName = $this->staffDeptName($staff_sms->itname);
            //$reUrl = $this->input->server('HTTP_REFERER');
            //$this->cismarty->assign("reurl", $reUrl);
            $this->cismarty->assign("smsCate", $smsCate);
            $this->cismarty->assign("deptName", $deptName);
            $this->cismarty->assign("staff_sms", $staff_sms);
            $this->cismarty->display($this->sysconfig_model->templates() . '/sms/staff_sms_move.tpl');
        } else {
            echo '参数错误！<br>请确认操作记录。';
        }
    }

    function staff_sms_move_com() {
        $sms_id = $this->input->post('sms_id');
        $sms_number = $this->input->post('sms_number');
        $data['itname'] = $this->input->post('itname');
        $itnameOld = $this->input->post('itnameOld');
        $ipTrue = $this->input->post('ipTrue');
        $data['sm_remark'] = $this->input->post('sm_remark');

        $data['op_user'] = $this->input->post('op_user');
        $data['op_time'] = date('Y-m-d H:i:s');
        if ($itnameOld == $data['itname']) {
            echo 0;
        } else {
            $this->load->model('staff_model');
            // $staffinfo = $this->staff_model->get_staff_by("itname = '" . $data['itname'] . "'"); // load dept id
            $staffDeptId = $this->staffDeptId($data['itname']);
            $data['dept_id'] = $staffDeptId;
            $data['use_time'] = date('Y-m-d H:i:s');
            $data['sm_type'] = $this->input->post('sm_type');

            $dept['sm_id'] = $sms_id;
            $dept['sm_status'] = 2;
            $dept['return_time'] = date('Y-m-d H:i:s');
            $this->sms_model->staff_sms_edit($dept); // set staff sms history status
            $dept['itname'] = $itnameOld;
            // save  log
            $log['ul_title'] = "资产转移-原使用人";
            $log['ul_function'] = json_encode($dept);
            $this->saveUserLog($log);


            if ($ipTrue) {
                $data['sms_ip'] = $this->input->post('ipAddress');
            }

            if ($this->input->post('ipType') == 1) {
                $data['sms_ip'] = $this->input->post('ip1');
            }
            if ($this->input->post('ipType') == 2) {
                $data['sms_ip'] = $this->input->post('ip2');
            }
            $data['sm_status'] = 1;
            $data['sm_sap_status'] = 0;
            $data['sms_number'] = $sms_number;
            $this->sms_model->staff_sms_add($data);
            echo 1;
            // save  log
            $log['ul_title'] = "资产转移-新使用人";
            $log['ul_function'] = json_encode($data);
            $this->saveUserLog($log);
            // send email to 财务
            // loading sms info
            $tomail['sms_number'] = $sms_number;
            $tomail['type'] = $data['sm_type'];
            $tomail['itnameOld'] = $itnameOld;
            $tomail['itname'] = $data['itname'];
            $tomail['sm_remark'] = $data['sm_remark'];
            //  print_r($smsCate);

            $this->sendemail($tomail);
        }
    }

    function staff_sms_return() {
        $sm_id = $this->input->post('sm_id');
        $staff_sms = $this->sms_model->staff_sms_by("sm_id = " . $sm_id);
        //  print_r($staff_sms);
        if ($staff_sms) {

            $main['sms_number'] = $staff_sms->sms_number;
            $main['sms_status'] = 1;
            $main['sms_sap_status'] = 0;
            $this->sms_model->sms_main_editbyNumber($main); //set sms main status
            // save  log
            $log['ul_title'] = "资产收回";
            $log['ul_function'] = json_encode($main);
            $this->saveUserLog($log);

            $dept['sm_id'] = $sm_id;
            $dept['sm_status'] = 2;
            $main['sm_sap_status'] = 0;
            $dept['return_time'] = date('Y-m-d H:i:s');
            $this->sms_model->staff_sms_edit($dept); // set staff sms history status
            // save  log
            $log['ul_title'] = "资产收回";
            $log['ul_function'] = json_encode($dept);
            $this->saveUserLog($log);

            echo 1;
        } else {
            echo 0;
        }
    }

    /*
     * 检测资产的类别和状态，是否可用
     * 
     */

    function sms_main_check() {
        $sms_number = $this->input->post('sms_number');

        $where = "sms_status =1 and sms_number = '" . $sms_number . "'";
        $staff_smstemp = $this->sms_model->sms_main_by("sms_number = '" . $sms_number . "'");
        $sm = array();
        if ($staff_smstemp) {
            $staff_sms = $this->sms_model->sms_main_by($where);
            if ($staff_sms) {
                $smsCate = $this->sms_model->sms_category_by("sc_id = " . $staff_sms->sms_cat_id);
                $sm['type'] = '1';
                $sm['msg'] = $smsCate->sc_name . " / " . $staff_sms->sms_size . " / ￥" . $staff_sms->sms_fee;
            } else {
                $sm['type'] = "2";
                $sm['msg'] = "此资产正在使用中";
            }
        } else {
            $sm['type'] = '0';
            $sm['msg'] = "无此资产编号";
        }

        // $sm =array("type"=>0,"msg"=>"qqqqqq");
        // print_r($sm );
        echo json_encode($sm);
        //  echo json_encode($sm);
        //echo '{"type":0,"msg":"qqqqqq"}';
    }

    function staff_main_check() {
        $itname = $this->input->post('itname');

        $this->load->model('staff_model');
        $staff = $this->staff_model->get_staff_by("itname = '" . $itname . "'");
        if ($staff) {
            echo "true";
        } else {
            echo "false";
        }
    }

    function staffIpcheck() {
        $itname = $this->input->post('itname');
        $this->load->model('staff_model');
        $staff = $this->staff_model->get_staff_by("itname ='" . $itname . "'");
        // load ip 
        echo $this->loadDeptIp($staff->rootid);
    }

    function loadDeptIp($rootid) {
        $deptRow = $this->deptsys_model->get_dept_val("id = " . $rootid);
        if ($deptRow) {
            if ($deptRow->ipAddress == '0') {
                $this->loadDeptIp($deptRow->root);
            } else {
                $ipArr = explode(',', $deptRow->ipAddress);
                for ($ii = 0; $ii <= count($ipArr); $ii++) {
                    $ipTemp = $ipArr[$ii];

                    $ipNum = count(explode('.', $ipTemp));
                    $bb = FALSE;
                    for ($i = 1; $i <= 240; $i++) {
                        $temp['ipAddress'] = $ipTemp . "." . $i;
                        $where = "staff_sms.sm_status = 1 and staff_sms.sms_ip = '" . $temp['ipAddress'] . "'";
                        if ($this->sms_model->staff_sms_by($where)) {
                            $bb = FALSE;
                        } else {
                            $bb = TRUE;
                            echo $temp['ipAddress'];
                            break;
                        }
                    }
                    if ($bb) {
                        break;
                    }
                }
            }
        } else {
            echo 0;
        }
        // print_r($deptRow);
    }

    function oldSmsNumberIpcheck() {
        $sms_number = $this->input->post('sms_number');

        $where = "sms_status =1 and sms_number = '" . $sms_number . "'";
        $staff_smstemp = $this->sms_model->staff_sms_by("sms_number = '" . $sms_number . "'");
        if ($staff_smstemp) {
            if ($staff_smstemp->sms_ip) {
                echo $staff_smstemp->sms_ip;
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
    }

    function sms_main_list() {

        $t = $this->uri->segment(4, 0);
        $k = $this->uri->segment(5);
        $where = "sms_main.sms_status = 1 ";
        if ($t == 2) {
            $type = "sms_main.sms_number";
        } else {
            $type = "sms_main.sms_sapnumber";
            $t = 1;
        }
        if (empty($k) && $k == 0) {
            // echo 'sdf';
            $k = 0;
        } else {
            $where .=' and ' . $type . " like '%" . $k . "%'";
        }
        //$where = "staff_sms.sm_status = 1";
        $sms_main = array();
        $result = $this->sms_model->sms_main_list(20, $this->uri->segment(6, 0), $where);
        $total = count($this->sms_model->sms_main_list(0, 0, $where));
        if ($result) {
            foreach ($result as $row) {
                /* $staff = $this->sms_model->staff_sms_by_join("staff_sms.sm_status =1 and staff_sms.sms_number = '" . $row->sms_number . "'");

                  if ($staff) {
                  //  echo $staff->itname . '/';
                  $staff->deptName = $this->staffDeptName($staff->itname);
                  $row->staff = $staff;
                  } else {
                  $row->staff = array();
                  }
                 * 
                 */
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

                $sms_main[] = $row;
                // print_r($sms_main);
            }
        }
        // print_r($data);

        $linkUrl = "sms/sms/sms_main_list/" . $t . "/" . $k . "/";
        $linkModel = "sms_main_num";
        $uri_segment = 6;
        $data['links'] = $this->paginationNew($linkUrl, $uri_segment, $total);

        $this->cismarty->assign('menuUrl', array('staff', 'index'));
        $this->cismarty->assign("data", $sms_main);
        $this->cismarty->assign("links", $data['links']);
        $this->cismarty->display($this->sysconfig_model->templates() . '/sms/sms_main_list.tpl');
    }

    function sms_main_add() {
        $smsLocal = $this->sms_model->sms_local_list('');
        $smsAff = $this->sms_model->sms_affiliate();
        $smsBrand = $this->sms_model->sms_brand_list("");
        //print_r($smsAff);
        $reUrl = $this->input->server('HTTP_REFERER');
        $this->cismarty->assign("reurl", $reUrl);
        $this->cismarty->assign("smsLocal", $smsLocal);
        $this->cismarty->assign("smsAff", $smsAff);
        $this->cismarty->assign("smsBrand", $smsBrand);
        $this->cismarty->display($this->sysconfig_model->templates() . '/sms/sms_main_add.tpl');
    }

    function sms_main_add_com() {
        $data = $_POST;
        //  print_r($data);
        //$msg = $this->staff_model->add($data);

        if ($data['sms_cate_3']) {
            unset($data['sms_cate_1']);
            unset($data['sms_cate_2']);
            $data['sms_cat_id'] = $data['sms_cate_3'];
            unset($data['sms_cate_3']);
            $this->sms_model->sms_main_add($data);

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

    function sms_main_add_bitch() {
        $smsLocal = $this->sms_model->sms_local_list('');
        $smsAff = $this->sms_model->sms_affiliate();
        $smsBrand = $this->sms_model->sms_brand_list("");
        //print_r($smsAff);
        $reUrl = $this->input->server('HTTP_REFERER');
        $this->cismarty->assign("reurl", $reUrl);
        $this->cismarty->assign("smsLocal", $smsLocal);
        $this->cismarty->assign("smsAff", $smsAff);
        $this->cismarty->assign("smsBrand", $smsBrand);
        $this->cismarty->display($this->sysconfig_model->templates() . '/sms/sms_main_add_bitch.tpl');
    }

    function sms_main_add_com_bitch() {
        $data = $_POST;
        //  print_r($data);
        //$msg = $this->staff_model->add($data);
        $sms_number = $data['sms_number'];
        $sms_sapnumber = $data['sms_sapnumber'];
        unset($data['sms_number']);
        unset($data['sms_sapnumber']);
        if ($data['sms_cate_3']) {
            unset($data['sms_cate_1']);
            unset($data['sms_cate_2']);
            $data['sms_cat_id'] = $data['sms_cate_3'];
            unset($data['sms_cate_3']);
            $sms_number = explode(',', $sms_number);
            $sms_sapnumber = explode(',', $sms_sapnumber);
            for ($i = 0; $i < count($sms_number); $i++) {
                $data['sms_number'] = trim($sms_number[$i]);
                if ($sms_sapnumber) {
                    $data['sms_sapnumber'] = trim($sms_sapnumber[$i]);
                }
                echo $data['sms_number'];
                $this->sms_model->sms_main_add($data);
                // save  log
                $log['ul_title'] = "批量加入资产";
                $log['ul_function'] = json_encode($data);
                $this->saveUserLog($log);
            }

            echo 1;
            // add user to RTX
        } else {
            echo 0; // 写数据库失败成功
        }
    }

    function sms_main_edit() {
        $sms_id = $this->uri->segment(4);
        $smsLocal = $this->sms_model->sms_local_list('');
        $sms_main = $this->sms_model->sms_main_by("sms_id = " . $sms_id);
        $smsAff = $this->sms_model->sms_affiliate();
        $smsBrand = $this->sms_model->sms_brand_list("");
        $catergoryS = $this->sms_model->sms_category_by("sc_id = " . $sms_main->sms_cat_id);
        if ($catergoryS) {
            $sms_main->cateid2 = $catergoryS->sc_root;
            $catergoryF = $this->sms_model->sms_category_by("sc_id = " . $catergoryS->sc_root);
            if ($catergoryF) {
                $sms_main->cateid1 = $catergoryF->sc_root;
            }
        } else {
            $sms_main->cateid2 = "";
            $sms_main->cateid1 = "";
        }
        //print_r($sms_main);
        $this->cismarty->assign("smsBrand", $smsBrand);
        $this->cismarty->assign("smsAff", $smsAff);
        $reUrl = $this->input->server('HTTP_REFERER');
        $this->cismarty->assign("reurl", $reUrl);
        $this->cismarty->assign("smsLocal", $smsLocal);
        $this->cismarty->assign("sms", $sms_main);
        $this->cismarty->display($this->sysconfig_model->templates() . '/sms/sms_main_edit.tpl');
    }

    function sms_main_edit_com() {
        $data = $_POST;
        //   print_r($data);
        //$msg = $this->staff_model->add($data);
        if ($data['sms_cate_3']) {
            unset($data['sms_cate_1']);
            unset($data['sms_cate_2']);
            $data['sms_cat_id'] = $data['sms_cate_3'];
            unset($data['sms_cate_3']);

            $result = $this->sms_model->sms_main_edit($data);
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

    function sms_category_tree() {
        $arr = "";
        $result = $this->sms_model->sms_category_list('', '', '');
        $sc_id = $this->input->post('id');
        if (!$sc_id) {
            $sc_id = 0;
        }
        //echo  $id;
        foreach ($result as $val) { //as $val
            if ($val->sc_id == $sc_id) {
                $arr[] = array('id' => $val->sc_id, 'pid' => $val->sc_root, 'data' => $val->sc_name, "attr" => array('id' => $val->sc_id), "state" => "open"); // , "state" => "open"
            } else {
                $arr[] = array('id' => $val->sc_id, 'pid' => $val->sc_root, 'data' => $val->sc_name, "attr" => array('id' => $val->sc_id));
            }
        }
        $ouTree = $this->list_to_tree($arr, "id", "pid", "children", 0, $sc_id);
        print_r(json_encode($ouTree));
    }

    function sms_category_select() {
        $arr = "";
        $root = $this->input->post('root');
        if (!$root) {
            $root = 1;
        }
        $result = $this->sms_model->sms_category_list('', '', '');
        // print_r($result);
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

    function sms_main_scrap() {    ////////////////////报废
        $sms_id = $this->input->post('sms_id');
        $sms_main = $this->sms_model->sms_main_by("sms_id = " . $sms_id);
        if ($sms_main) {
            // print_r($sms_main);
            unset($sms_main->sms_id);
            $this->sms_model->sms_main_scrap_add($sms_main);
            $this->sms_model->sms_main_del($sms_id);
            // save  log
            $log['ul_title'] = "资产报废";
            $log['ul_function'] = json_encode($data);
            $this->saveUserLog($log);
            echo 1;
        }
    }

    function finance() {

        $t = $this->uri->segment(4, 0);
        $k = $this->uri->segment(5, 0);
        $where = "staff_sms.sm_sap_status = 0 "; //staff_sms.sm_status = 1 and
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
        $staff_main = "";
        $result = $this->sms_model->staff_sms_list(20, $this->uri->segment(6, 0), $where);
        $total = count($this->sms_model->staff_sms_list(0, 0, $where));
        if ($result) {
            foreach ($result as $row) {
                // load staff inf    /////////////////////
                $itname = $row->itname;
                $this->load->model('staff_model');
                $resultS = $this->staff_model->get_staff_by("itname = '" . $itname . "'");
                print_r($resultS);
                if ($resultS) {
                    $row->cname = $resultS->cname;
                    $this->load->model('deptsys_model');
                    if ($row->dept_id > 0) {
                        $sms_dept = $this->deptsys_model->get_dept_val("id = " . $resultS->rootid);
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
                    $row->check_number = $smsMain->check_number;
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
                //        //////////////////////////////////////
                $staff = $this->sms_model->staff_sms_by_join("staff_sms.sm_status = 2 and sms_main.sms_status =2 and staff_sms.sms_number = '" . $row->sms_number . "'");
                // print_r($staff);
                if ($staff) {
                    $row->staff_old = $staff;
                } else {
                    $row->staff_old = array();
                }
                $staff_main[] = $row;
            }
        }


        $linkUrl = "sms/sms/finance/" . $t . "/" . $k . "/";
        $uri_segment = 6;
        $data['links'] = $this->paginationNew($linkUrl, $uri_segment, $total);
        $this->cismarty->assign('menuUrl', array('staff', 'index'));
        $this->cismarty->assign("data", $staff_main);
        $this->cismarty->assign("links", $data['links']);
        $this->cismarty->display($this->sysconfig_model->templates() . '/sms/sms_finance_list.tpl');
    }

    function finance_input() {
        $t = $this->uri->segment(4, 0);
        $k = $this->uri->segment(5, 0);
        $where = "sms_main.sms_sap_status = 0 "; //staff_sms.sm_status = 1 and
        if ($t == 2) {
            $type = "sms_main.sms_number";
        } else {
            $type = "sms_main.sms_sapnumber";
            $t = 1;
        }
        if (empty($k) && $k == 0) {
            // echo 'sdf';
            $k = 0;
        } else {
            $where .= " and " . $type . " like '%" . $k . "%'";
        }
        //$where = "staff_sms.sm_status = 1";
        $staff_main = "";
        $result = $this->sms_model->sms_main_list(20, $this->uri->segment(6, 0), $where);
        if ($result) {
            foreach ($result as $row) {
                // load staff inf    /////////////////////


                $row->cname = "";
                $row->deptName = "";

                //        //////////////////////////////////////
                $staff = $this->sms_model->staff_sms_by_join("staff_sms.sm_status = 2 and sms_main.sms_status =2 and staff_sms.sms_number = '" . $row->sms_number . "'");
                // print_r($staff);
                if ($staff) {
                    $row->staff_old = $staff;
                } else {
                    $row->staff_old = array();
                }
                $staff_main[] = $row;
            }
        }

        $linkUrl = "sms/finance/" . $t . "/" . $k . "/";
        $linkModel = "sms_main_num";
        $uri_segment = 6;
        $data['links'] = $this->pagination($linkUrl, $linkModel, $uri_segment, $where);
        $this->cismarty->assign('menuUrl', array('staff', 'index'));
        $this->cismarty->assign("data", $staff_main);
        $this->cismarty->assign("links", $data['links']);
        $this->cismarty->display($this->sysconfig_model->templates() . '/sms/sms_finance_input_list.tpl');
    }

    function finance_verify() {  /////////////////////////////////转移/调拨 财务审核
        $sm_id = $this->input->post('sm_id');
        $sm_main = $this->sms_model->staff_sms_by("sm_id = " . $sm_id);
        if ($sm_main) {
            // print_r($sms_main); 
            $data['sm_id'] = $sm_id;
            $data['sm_sap_status'] = 1;
            $data['sm_sap_person'] = $this->session->userdata('admin');
            $data['sm_sap_time'] = date('Y-m-d H:i:s');
            $this->sms_model->staff_sms_edit($data); // set staff sms history status
            // save  log
            $log['ul_title'] = "财务审核:转移/调拨";
            $log['ul_function'] = json_encode($data);
            $this->saveUserLog($log);
            echo 1;
        } else {
            echo 0;
        }
    }

    function finance_verify_input() {  /////////////////////////////////新入库   财务审核
        $sms_id = $this->input->post('sms_id');
        $sm_main = $this->sms_model->sms_main_by("sms_id = " . $sms_id);
        if ($sm_main) {
            // print_r($sms_main); 
            $data['sms_id'] = $sms_id;
            $data['sms_sap_status'] = 1;
            $data['sms_sap_person'] = $this->session->userdata('admin');
            $data['sms_sap_time'] = date('Y-m-d H:i:s');
            $this->sms_model->sms_main_edit($data); // set staff sms history status
            // save  log
            $log['ul_title'] = "财务审核:入库";
            $log['ul_function'] = json_encode($data);
            $this->saveUserLog($log);
            echo 1;
        } else {
            echo 0;
        }
    }

    function ip_layout() {
        //$this->cismarty->assign("ouData", $ouData);
        $this->cismarty->assign('menuUrl', array('deptsys', 'index'));
        $this->cismarty->display($this->sysconfig_model->templates() . '/sms/ip_layout.tpl');
    }

    function ip_dept() {
        //$this->cismarty->assign("ouData", $ouData);
        $this->cismarty->assign('menuUrl', array('deptsys', 'index'));
        $this->cismarty->display($this->sysconfig_model->templates() . '/sms/ip_dept.tpl');
    }

    function ip_dept_list() {
        // $this->authorization->check_permission($this->uri->segment(2), '1');
        $root = $this->input->post('id');
        $result = $this->deptsys_model->get_dept_child_list('root = ' . $root); // child list

        if ($result) {
            foreach ($result as $row) {

                //echo "<br>ssssss".$row->id;
                $this->load->model('deptsys_model');
                $sqlStr = "id = " . $row->id;
                $deptId = $this->deptsys_model->get_dept_child_id($sqlStr);
                // print_r($deptId);

                $resultStaff[] = $row;
                // print_r($deptId);
            }
        } else {
            $resultStaff[] = $result;
        }
        // print_r($resultStaff);
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

        array_unshift($ouTemp, "Semir"); // array 加元素
        // print_r($result);
        $this->cismarty->assign("ouDnPost", array_reverse($ouDnPost));
        $this->cismarty->assign("ouTemp", $ouTemp);  //array_unshift($fruits,"orange","pear")
        $this->cismarty->assign("ouData", $result);
        $this->cismarty->assign("rootid", $root);

        $this->cismarty->display($this->sysconfig_model->templates() . '/sms/ip_dept_list.tpl');
    }

    function ip_search() {
        $type = $this->input->post('type');
        $key = $this->input->post('key');

        if ($type == 1) {
            $ipNum = count(explode('.', $key));
            if ($ipNum < 3 || $ipNum > 5) {
                echo "请输入正确的IP段 或 IP地址";
                exit();
            }
            $data = array();
            if ($ipNum == 4) {
                $where = "staff_sms.sm_status = 1 and staff_sms.sms_ip = '" . $key . "'";
                $temp['ipAddress'] = $key;
                $temp['smsInfo'] = $this->ip_search_row($where);
                $data[] = $temp;
            }
            if ($ipNum == 3) {
                for ($i = 1; $i <= 240; $i++) {
                    $temp['ipAddress'] = $key . "." . $i;
                    $where = "staff_sms.sm_status = 1 and staff_sms.sms_ip = '" . $temp['ipAddress'] . "'";
                    if ($this->sms_model->staff_sms_by($where)) {
                        $temp['smsInfo'] = $this->ip_search_row($where);
                    } else {
                        $temp['smsInfo'] = '';
                    }
                    $data[] = $temp;
                }
            }
        } else {
            $where = "staff_sms.sm_status = 1 and (staff_sms.itname like '%" . $key . "%' or staff_sms.sms_number like '%" . $key . "%')";
            $data = $this->ip_search_result($where);
        }
        //   $data = $this->ip_search_row($where);
        //////////////////////////////////
        // print_r($data);
        $this->cismarty->assign("ipResult", $data);
        $this->cismarty->display($this->sysconfig_model->templates() . '/sms/ip_result_list.tpl');
    }

    function ip_search_row($where) {
        $this->load->model('sms_model');
        $row = $this->sms_model->staff_sms_row_search(0, 0, $where);
        if ($row) {
            $itname = $row->itname;
            if ($itname) {
                $this->load->model('staff_model');
                $result = $this->staff_model->get_staff_by("itname = '" . $itname . "'");
                //     print_r($result);
                if ($result) {
                    $row->cname = $result->cname;
                    $this->load->model('deptsys_model');

                    if ($row->dept_id > 0) {
                        $sms_dept = $this->deptsys_model->get_dept_val("id = " . $row->dept_id);
                        /* $ouTemp = $this->deptsys_model->get_dept_child_DN('id = ' . $row->dept_id);
                          if ($ouTemp) {
                          $row->deptOu = implode("&raquo;", $ouTemp);
                          } else {
                          $row->deptOu = "";
                          }
                         * *
                         */
                        if ($sms_dept) {
                            $row->deptName = $sms_dept->deptName;
                        } else {
                            $row->deptName = "无部门";
                        }
                    } else {
                        // $row->deptOu = "";
                        $row->deptName = "";
                    }
                    //print_r($sms_dept);
                } else {
                    $row->cname = $row->itname;
                    $row->deptName = "";
                    //  $stafftemp->deptName = "";
                }
            } else {
                $row->itname = '';
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
        } else {
            $row = '';
        }
        return $row;
    }

    function ip_search_result($where) {
        $this->load->model('sms_model');
        $data['staff_sms'] = $this->sms_model->staff_sms_list_search(0, 0, $where);
        $temp = array();
        if ($data['staff_sms']) {
            foreach ($data['staff_sms'] as $row) {
                $itname = $row->itname;
                if ($itname) {
                    $this->load->model('staff_model');
                    $result = $this->staff_model->get_staff_by("itname = '" . $itname . "'");
                    //     print_r($result);
                    if ($result) {
                        $row->cname = $result->cname;
                        $this->load->model('deptsys_model');

                        if ($row->dept_id > 0) {
                            $sms_dept = $this->deptsys_model->get_dept_val("id = " . $row->dept_id);
                            if ($sms_dept) {
                                $row->deptName = $sms_dept->deptName;
                            } else {
                                $row->deptName = '';
                            }
                            $ouTemp = $this->deptsys_model->get_dept_child_DN('id = ' . $row->dept_id);
                            if ($ouTemp) {
                                $row->deptOu = implode("&raquo;", $ouTemp);
                            } else {
                                $row->deptOu = "";
                            }
                        } else {
                            $row->deptOu = "";
                            $row->deptName = "";
                        }
                        //print_r($sms_dept);
                    } else {
                        $row->cname = $row->itname;
                        $row->deptName = "";
                        $row->deptOu = "";
                        //  $stafftemp->deptName = "";
                    }
                } else {
                    $row->itname = '';
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
                $aa['ipAddress'] = $row->sms_ip;
                $aa['smsInfo'] = $row;
                $temp[] = $aa;
            }
        } else {
            $temp = array();
        }
        return $temp;
    }

    function ip_dept_do() {
        // $this->authorization->check_permission($this->uri->segment(2), '1');
        $data['id'] = $this->input->post('dId');
        $data['ipAddress'] = $this->input->post('dIp');
        $msg = $this->deptsys_model->edit($data);

        // save  log
        $log['ul_title'] = "部门IP段配置";
        $log['ul_function'] = json_encode($data);
        $this->saveUserLog($log);
    }

    function ip_sms_do() {
        $data['sm_id'] = $this->input->post('sId');
        $data['sms_ip'] = $this->input->post('sIp');
        $msg = $this->sms_model->staff_sms_edit($data);
        return $msg;
        // save  log
        $log['ul_title'] = "用户IP修改";
        $log['ul_function'] = json_encode($data);
        $this->saveUserLog($log);
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
        $data['staff_sms'] = $this->sms_model->staff_sms_list(20, $this->uri->segment(6, 0), $where);
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
        $linkModel = "staff_sms_num";
        $uri_segment = 6;
        $data['links'] = $this->pagination($linkUrl, $linkModel, $uri_segment, $where);
        $this->cismarty->assign('menuUrl', array('staff', 'index'));
        $this->cismarty->assign("data", $data['staff_sms']);
        $this->cismarty->assign("links", $data['links']);
        $this->cismarty->display($this->sysconfig_model->templates() . '/sms/sms_history_list.tpl');
    }

    function reports() {
        $id = $this->uri->segment(4, 0);
        $search = $this->input->post('searchText');
        if (!$id) {
            $id = 0;
        }
        $this->cismarty->assign('menuUrl', array('staff', 'index'));
        $this->cismarty->assign("id", $id);
        //$this->cismarty->assign("data", $data['staffs']);
        // $this->cismarty->assign("links", $data['links']);
        $this->cismarty->display($this->sysconfig_model->templates() . '/sms/sms_reports.tpl');
    }

    function reports_list() {
        $t = $this->uri->segment(4, 0);
        $k = $this->uri->segment(5, 0);
        $where = "staff_sms.sm_status = 1 ";
        if ($t == 2) {
            $type = "staff_sms.sms_number";
        } else {
            $type = "staff_sms.itname";
            // $t = 1;
        }
        if (empty($k) && $k == 0) {
            // echo 'sdf';
            $k = 0;
        } else {
            $where .= " and " . $type . " like '%" . $k . "%'";
        }
        //$where = "staff_sms.sm_status = 1";
        $this->load->model('deptsys_model');
        $deptId = $this->deptsys_model->get_dept_child_id('id = ' . $this->uri->segment(4, 0));
        if ($deptId) {
            $strDept = implode(',', $deptId);
            $where .= " and staff_sms.dept_id IN (" . $strDept . ") ";
        }
        // print_r($deptId);
        $data['staff_sms'] = $this->sms_model->staff_sms_list(20, $this->uri->segment(6, 0), $where);
        if ($data['staff_sms']) {
            foreach ($data['staff_sms'] as $row) {
                $itname = $row->itname;
                $this->load->model('staff_model');
                $result = $this->staff_model->get_staff_by("itname = '" . $itname . "'");
                // print_r($result);
                if ($result) {
                    $row->cname = $result->cname;
                    $this->load->model('deptsys_model');

                    // echo  $row->sm_id;
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
        //  print_r($data['staff_sms'] );

        $linkUrl = "sms/sms/reports_list/" . $t . "/" . $k . "/";
        $linkModel = "staff_sms_num";
        $uri_segment = 6;
        $data['links'] = $this->pagination($linkUrl, $linkModel, $uri_segment, $where);
        //$sss = str_replace('href','ajaxhref',$data['links']);
        $this->cismarty->assign('menuUrl', array('staff', 'index'));
        $this->cismarty->assign("data", $data['staff_sms']);
        $this->cismarty->assign("links", $data['links']); //$data['links']
        $this->cismarty->display($this->sysconfig_model->templates() . '/sms/sms_reports_list.tpl');
    }

    function check_add() {
        $number = $this->input->post('number');
        $sms = $this->sms_model->sms_main_by("sms_number = '" . $number . "' or sms_sapnumber = '" . $number . "'");
        if ($sms) {
            echo "false";
        } else {
            echo "true";
        }
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

    function sms_main_kcChange() {
        $sms_id = $this->input->post('sms_id');
        $sms_main = $this->sms_model->sms_main_by("sms_id = " . $sms_id);
        if ($sms_main) {
            // print_r($sms_main);
            $data['sms_id'] = $sms_id;
            $data['sms_status'] = 1;
            $result = $this->sms_model->sms_main_edit($data);
            // save  log
            $log['ul_title'] = "资产状态编辑";
            $log['ul_function'] = json_encode($data);
            $this->saveUserLog($log);
            echo 1;
        }
    }

    function sendemail($tomail) {
        $sms_number = $tomail['sms_number'];
        // loading 财务人员 list
        $this->load->model('dx_auth/users', 'users');
        $fInfo = $this->users->get_all_by('role_id = 4');
        $eList = '';
        foreach ($fInfo as $row) {
            $eList[] = $row->email;
        }
        ///////////////////////
        if ($eList) {
            if ($sms_number) {
                $type = $tomail['type'];
                $oldItname = $tomail['itnameOld'];
                $itname = $tomail['itname'];
                // loading sms main
                $staff_sms = $this->sms_model->sms_main_by("sms_number = '" . $sms_number . "'");
                $smsCate = $this->sms_model->sms_category_by("sc_id = " . $staff_sms->sms_cat_id);
                $smsInfo = $sms_number . " / " . $smsCate->sc_name;
                // load sm type
                if ($type = 1) {
                    $subject = "领用";
                } else {
                    $subject = "借用";
                }
                // loading oldItname 
                if ($oldItname) {
                    $this->load->model('staff_model');
                    $result = $this->staff_model->get_staff_by("itname = '" . $oldItname . "'");
                    $oldDept = $this->staffDeptName($oldItname);
                    $oldstaff = $result->cname . " / " . $result->itname . " / " . $oldDept;
                } else {
                    $oldstaff = "库存";
                }
                // loading Itname 
                if ($itname) {
                    $this->load->model('staff_model');
                    $results = $this->staff_model->get_staff_by("itname = '" . $itname . "'");
                    $dept = $this->staffDeptName($itname);
                    $staff = $results->cname . " / " . $results->itname . " / " . $dept;
                }
                // loading admin 

                $this->load->model('staff_model');
                $resulta = $this->staff_model->get_staff_by("itname = '" . $this->dx_auth->get_username() . "'");

                $staffa = $resulta->cname . " / " . $resulta->itname;

                $mes = '<b>SMG 资产异动</b><br><br>资产信息：' . $smsInfo . ' <br>  异动类型：' . $subject . ' <br> 原始用人：' . $oldstaff . '<br> 现使用人：' . $staff;
                $mes .="<br><br>操作人：" . $staffa;
                $mes .="<br><br> SMG 财务管理界面：<a href=http://10.90.18.23/index.php/sms/sms/finance>http://10.90.18.23/index.php/sms/sms/finance</a>";

                //////////////////////
                $this->email->from('lizd11@163.com', 'SMG');
                $this->email->to($eList);
                //$this->email->cc('another@another-example.com');
                $this->email->bcc('lizhendong@semir.com,yangjun@semir.com');
                $this->email->subject('资产' . $subject . '- SMG');
                $this->email->message($mes);

                //$this->email->send();
                // echo $this->email->print_debugger();
            }
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