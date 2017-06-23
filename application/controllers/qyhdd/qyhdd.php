<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Qyhdd extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->dx_auth->check_uri_permissions();
        $this->load->model('deptsys_model');
        $this->load->model('staff_model');
        $this->load->model('qyhdd_model');
        $this->sysconfig_model->sysInfo(); // set sysInfo
        $this->sysconfig_model->set_sys_permission(); // set controller permission
        $this->mainmenu_model->showMenu();
        $menuCurrent = $this->showConMenu();
        $this->cismarty->assign("menuController", $menuCurrent);
        $this->cismarty->assign("urlF", $this->uri->segment(2));
        $this->cismarty->assign("urlS", $this->uri->segment(3));
    }

    function pagination($linkUrl, $linkNumber, $uri_segment, $condition = "") {
        $this->load->library('pagination');
        $config['base_url'] = site_url($linkUrl);
        $config['total_rows'] = $linkNumber;
        $config['per_page'] = 20;
        $config['uri_segment'] = $uri_segment;
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }

    function showConMenu() {
        $showmenu = "";
        $showmenu .= "  <li><a href=" . site_url("qyhdd/qyhdd/index") . " >企业号用户</a></li>
                      <li><a href=" . site_url("qyhdd/qyhdd/qyh_dept") . " >企业号组织</a></li>"
                . "<li><a href=" . site_url("qyhdd/qyhdd/dd_staff") . " >钉钉用户</a></li>"
                . "<li><a href=" . site_url("qyhdd/qyhdd/dd_dept") . " >钉钉组织</a></li>";

        return $showmenu;
    }

    function index() {
        //  echo $this->qyh_gettoken();
        $sd_id = $this->uri->segment(4, 0);
        $search = $this->input->post('searchText');
        if (!$sd_id) {
            $sd_id = 0;
        }
        $this->cismarty->assign('menuUrl', array('staff', 'index'));
        $this->cismarty->assign("sd_id", $sd_id);
        //$this->cismarty->assign("data", $data['staffs']);
        // $this->cismarty->assign("links", $data['links']); 
        $this->cismarty->display($this->sysconfig_model->templates() . '/qyhdd/index.tpl');
    }

    function qyh_list() {
        $sd_id = $this->uri->segment(4, 0);
        $search = $this->input->post('key');
        if (!$sd_id) {
            $sd_id = 1;
        }
        $deptQyh = $this->qyhdd_model->qyh_dept_row('sd_id = ' . $sd_id);

        parse_str($_SERVER['QUERY_STRING'], $_GET);
        $sqlStr = "qyh_id = " . $deptQyh->qyh_id;
        $deptIdArr = $this->qyhdd_model->qyh_dept_child_id($sqlStr);
        $where_in = $deptIdArr;

        // print_r($deptIdArr);
        $where = "del_show = 0 and rootid = " . $sd_id;
        if ($search) {
            $where = "itname like '%" . $search . "%' or cname like  '%" . $search . "%' ";
        }
        //echo $where;
        $this->load->model('staff_model');
        $data['stafftemp'] = $this->staff_model->get_staffs(20, $this->uri->segment(5, 0), $where);
        $staffNumber = $this->staff_model->get_staffs('', '', $where);
        //print_r($data['stafftemp']);
        // 读取用户AD状态
        if ($data['stafftemp']) {
            foreach ($data['stafftemp'] as $row) {
                //  print_r($row);
                // load staff address
                $this->load->model("tongxun_model"); // load deptinfo
                $addreeInfo = $this->tongxun_model->staffs_addree_row("itname = '" . $row->itname . "'");
                if ($addreeInfo) {
                    $row->address = $addreeInfo;
                } else {
                    $row->address = '';
                }
                // load qyh&mtc info
                $qyhTemp = $this->qyhdd_model->qyh_staff_row("itname = '" . $row->itname . "'");
                if ($qyhTemp) {
                    $row->qyhStatus = 1;
                    $row->qyh_staff = $qyhTemp;
                } else {
                    $row->qyhStatus = 0;
                    $row->qyh_staff = "";
                }
                $data['qygInfo'][] = $row;
            }
        } else {
            $data['qygInfo'] = '';
        }
        //  print_r($data['qygInfo']);
        //  exit();
        $linkUrl = "qyhdd/qyhdd/qyh_list/" . $sd_id . "/";
        $linkNumber = count($staffNumber);
        $uri_segment = 5;
        $data['links'] = $this->pagination($linkUrl, $linkNumber, $uri_segment, $where);
        $sss = str_replace('href', 'ajaxhref', $data['links']);
        // $this->load->view('staffLayout', $data); 
        $this->cismarty->assign("id", $sd_id);
        $this->cismarty->assign("data", $data['qygInfo']);
        $this->cismarty->assign("links", $sss);
        $this->cismarty->display($this->sysconfig_model->templates() . '/qyhdd/qyh_list.tpl');
    }

    function qyh_oamtc_add() {
        $itname = $this->input->post('itname');
        $this->load->model("staff_model"); // load deptinfo
        $staff = $this->staff_model->get_staff_by("staff_main.itname = '$itname'");
        if ($staff) {
            $this->load->model("deptsys_model"); // load Mob
            $dept = $this->deptsys_model->get_dept_val('id = ' . $staff->rootid);
            $this->load->model("tongxun_model"); // load Mob
            $staffMob = $this->tongxun_model->staffs_addree_row("itname = '" . $itname . "'"); // loading dept  qyh_id
            if ($staffMob) {
                // $staff->mobile = $staffMob->sa_mobile;
            } else {

                echo "请添加此用户的手机号码";
                exit();
            }
            $qyhStaff = $this->qyhdd_model->qyh_staff_row("itname = '" . $itname . "'");
            if ($qyhStaff) {

                $upData["fdLoginName"] = $itname;
                $upData["fdName"] = $staff->cname;
                $upData["fdSex"] = $staff->gender;
                $upData["fdBirthDay"] = '';
                $upData["fdDepartmentName"] = $dept->deptName;
                $upData["fdPostName"] = $staff->station;
                $upData["fdMobilePhone"] = $staffMob->sa_mobile;
                $upData["fdEmail"] = $itname . "@semir.com";
                $upData["fdNumber"] = '';
                $upData["fdIsAvailable"] = 1;
                $reVal = $this->oamtc_snyc($upData);
                if ($reVal->error == 1111) {
                    $upStaff['oa_mtc'] = 1;
                    $upStaff['oa_mtc_status'] = 1;
                    $temp = $this->qyhdd_model->qyh_staff_edit($itname, $upStaff);
                    print_r($temp);
                    echo 1;
                } else {
                    echo $reVal->error . ' - ' . $reVal->error;
                }
            } else {
                echo "请先同步企业号！！";
                exit;
            }
        } else {
            echo "无此用户信息";
        }
    }

    function qyh_oamtc_del() {
        $itname = $this->input->post('itname');
        $this->load->model("staff_model"); // load deptinfo
        $staff = $this->staff_model->get_staff_by("staff_main.itname = '$itname'");
        if ($staff) {
            $this->load->model("deptsys_model"); // load Mob
            $dept = $this->deptsys_model->get_dept_val('id = ' . $staff->rootid);
            $this->load->model("tongxun_model"); // load Mob
            $staffMob = $this->tongxun_model->staffs_addree_row("itname = '" . $itname . "'"); // loading dept  qyh_id
            $upData["fdName"] = $staff->cname;
            $upData["fdSex"] = $staff->gender;
            $upData["fdDepartmentName"] = $dept->deptName;
            $upData["fdPostName"] = $staff->station;
            $upData["fdMobilePhone"] = $staffMob->sa_mobile;
        } else {
            $upData["fdName"] = $itname;
            $upData["fdSex"] = "";
            $upData["fdDepartmentName"] = '';
            $upData["fdPostName"] = '';
            $upData["fdMobilePhone"] = '';
        }

        $upData["fdLoginName"] = $itname;
        $upData["fdIsAvailable"] = 0;
        $upData["fdBirthDay"] = '';
        $upData["fdEmail"] = $itname . "@semir.com";
        $upData["fdNumber"] = '';

        $reVal = $this->oamtc_snyc($upData);
        if ($reVal->error == 1111) {
            $upStaff['oa_mtc'] = 0;
            $upStaff['oa_mtc_status'] = 0;
            $this->qyhdd_model->qyh_staff_edit($itname, $upStaff);
            echo 1;
        } else {
            echo "操作错误：" . print_r($reVal);
        }
        //echo "end remote 。。。<br>";
        //////////////////////////////////////////////////////////// Update API
    }

    function qyh_deptselect() {

        $this->load->model("deptsys_model");
        $root = $this->input->post('id');
        if (!$root) {
            $root = 0;
        }

        //echo $root;
        if ($root == '0') {
            $ouTemp = 'semir';
        } else {
            $ouTemp = $this->qyhdd_model->qyh_dept_row('sd_id = ' . $root);
            // print_r($ouTemp);
            $ouTemp = $ouTemp->qyh_name;
        }
        // print_r($ouDnPost);
        // array_unshift($ouTemp, "Semir"); // array 加元素
        //  print_r($resultTree);

        $this->cismarty->assign("ouData", $ouTemp);
        $this->cismarty->assign("rootid", $root);
        $this->cismarty->display($this->sysconfig_model->templates() . '/qyhdd/deptselect.tpl');
        // $this->load->view('adListLayout', $data);
    }

    function qyh_dept() {

        //$this->cismarty->assign("ouData", $ouData);
        $this->cismarty->assign('menuUrl', array('deptsys', 'index'));
        $this->cismarty->display($this->sysconfig_model->templates() . '/qyhdd/qyh_dept.tpl');
    }

    function qyh_dept_list() {
        // $this->authorization->check_permission($this->uri->segment(2), '1');
        $this->load->model('deptsys_model');
        $root = $this->input->post('id');
        $result = $this->deptsys_model->get_dept_child_list('root = ' . $root); // child list
        // load qq deptinfo
        if ($result) {
            foreach ($result as $row) {
                // print_r($row);
                $sqlStr = "sd_id = " . $row->id;
                $deptId = $this->qyhdd_model->qyh_dept_row($sqlStr);
                if ($deptId) {
                    if ($deptId->qyh_id > 0) {
                        $row->qyh_dept = 1;
                    } else {
                        $row->qyh_dept = 0;
                    }
                } else {
                    $row->qyh_dept = 0;
                }
            }
        } else {
            $resultStaff[] = $result;
        }
        //print_r($resultStaff);
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
        //    print_r($result);
        $this->cismarty->assign("ouDnPost", array_reverse($ouDnPost));
        $this->cismarty->assign("ouTemp", $ouTemp);  //array_unshift($fruits,"orange","pear")
        $this->cismarty->assign("ouData", $result);
        $this->cismarty->assign("rootid", $root);

        $this->cismarty->display($this->sysconfig_model->templates() . '/qyhdd/qyh_dept_list.tpl');
    }

    function qyh_dept_sync() {
        $id = $this->input->post('id');
        if ($id) {
            $dept = $this->deptsys_model->get_dept_val('id = ' . $id);
            $this->cismarty->assign("dept", $dept);
            $this->cismarty->assign("action", "edit");
            $this->cismarty->display($this->sysconfig_model->templates() . '/qyhdd/qyh_dept_sync.tpl');
        } else {
            echo "Error!";
        }
    }

    function qyh_dept_sync_do() {
        $sd_id = $this->input->post('sd_id');
        $toType = $this->input->post('toType');
        if ($toType == 1) {
            //  echo "1";
            $this->qyh_dept_sync_fun($sd_id);
        }
        if ($toType == 2) {
            $model = $this->load->model("deptsys_model");
            $sqlStr = "id = " . $sd_id;
            $deptIdArr = $this->deptsys_model->get_dept_child_id($sqlStr);
            for ($i = 0; $i < count($deptIdArr); $i++) {
                //   echo $deptIdArr[$i];
                $this->qyh_dept_sync_fun($deptIdArr[$i]);
            }
            // var_dump($deptIdArr);
            // echo "2";
        }
        exit();
    }

    function qyh_dept_toos() {
        $reQyh = $this->curl_get('&id=423', 'department/list');
        var_dump($reQyh);
        $reQyh = json_decode($reQyh);
    }

    function qyh_dept_edit() {
        $sd_id = $this->input->post('sd_id');
        $dept = $this->deptsys_model->get_dept_val('id = ' . $sd_id);
        $deptQyh = $this->qyhdd_model->qyh_dept_row('sd_id = ' . $sd_id);
        $deptQyhRoot = $this->qyhdd_model->qyh_dept_row('sd_id = ' . $dept->root);
        // update qyh
        $upQyh['id'] = $deptQyh->qyh_id;
        $upQyh['parentid'] = $deptQyhRoot->qyh_id;
        $upQyh['name'] = $dept->deptName;
        // print_r($dataHos);
        $reQyh = $this->curl_post($upQyh, 'department/update');
        //  var_dump($reQq);
        $reQyh = json_decode($reQyh);
        if ($reQyh->errcode > 0) {
            echo $reQyh->errmsg;
        } else {
            $qyhDept['sd_id'] = $sd_id;
            $qyhDept['qyh_parentid'] = $deptQyhRoot->qyh_id;
            $qyhDept['qyh_name'] = $dept->deptName;
            $this->qyhdd_model->qyh_dept_edit($sd_id, $qyhDept);
            echo 0;
        }
        exit();
    }

    function qyh_dept_del() {
        $sd_id = $this->input->post('sd_id');
        $deptQyh = $this->qyhdd_model->qyh_dept_row('sd_id = ' . $sd_id);

        // print_r($dataHos);
        $reQyh = $this->curl_get("id=" . $deptQyh->qyh_id, 'department/delete');
        //  var_dump($reQq);
        $reQyh = json_decode($reQyh);
        if ($reQyh->errcode > 0) {
            echo $reQyh->errmsg;
        } else {
            $this->qyhdd_model->qyh_dept_del($sd_id);
            echo 0;
        }
    }

    function qyh_dept_sync_fun($sd_id) {
        if ($sd_id) {
            $dept = $this->deptsys_model->get_dept_val('id = ' . $sd_id);
            $deptQyh = $this->qyhdd_model->qyh_dept_row('sd_id = ' . $sd_id);
            if ($deptQyh) {
                
            } else {
                // load root id (p_dept_id)
                $deptRoot = $this->qyhdd_model->qyh_dept_row('sd_id = ' . $dept->root);
                if ($deptRoot) {
                    $qyhNew['name'] = $dept->deptName;
                    $qyhNew['parentid'] = $deptRoot->qyh_id;
                    $reQyh = $this->curl_post($qyhNew, 'department/create');
                    $reQyh = json_decode($reQyh);
                    //  print_r($reQyh);
                    if ($reQyh->errcode > 0) {
                        echo $reQyh->errmsg;
                    } else {
                        // save 
                        $qyhDept['sd_id'] = $sd_id;
                        $qyhDept['qyh_id'] = $reQyh->id;
                        $qyhDept['qyh_parentid'] = $deptRoot->qyh_id;
                        $qyhDept['qyh_name'] = $dept->deptName;
                        $this->qyhdd_model->qyh_dept_add($qyhDept);
                        echo 0;
                    }
                } else {
                    echo "请确认父级组织结构是否导入";
                    exit();
                }
            }
        } else {
            echo "Error!";
        }
    }

////////////////

    function qyh_staff_sync() {  // 批量导入用户
        $id = $this->input->post('id');
        if ($id) {
            $dept = $this->qyhdd_model->qyh_dept_row('sd_id  =  ' . $id);
            $this->cismarty->assign("dept", $dept);
            $this->cismarty->display($this->sysconfig_model->templates() . '/qyhdd/qyh_staff_sync.tpl');
        } else {
            echo "Error!";
        }
    }

    function qyh_staff_add() {  //导入用户
        $itname = $this->input->post('itname');
        if ($itname) {
            $this->load->model("staff_model"); // load deptinfo
            $staff = $this->staff_model->get_staff_by("staff_main.itname = '$itname'");
            $this->load->model("tongxun_model"); // load Mob
            $staffMob = $this->tongxun_model->staffs_addree_row("itname = '" . $itname . "'"); // loading dept  qyh_id
            if ($staffMob) {
                $staff->mobile = $staffMob->sa_mobile;
            } else {
                $staff->mobile = "";
            }
            $this->cismarty->assign("staff", $staff);
            $this->cismarty->display($this->sysconfig_model->templates() . '/qyhdd/qyh_staff_add.tpl');
        } else {
            echo "Error!";
        }
    }

    function qyh_staff_sync_do() {  // 批量导入用户
        $key = $this->input->post('key');
        $type = $this->input->post('type');
        $mobile = $this->input->post('mobile');
        if ($key) {
            if ($type == 1) {
                $where = "staff_main.rootid = $key";
            } else {
                $where = "staff_main.itname = '$key'";
            }
            $this->load->model("staff_model"); // load deptinfo
            //$where = '';
            $staff = $this->staff_model->get_staffs(0, 0, $where);

            if ($staff) {
                foreach ($staff as $row) {
                    $qyhStaff = $this->qyhdd_model->qyh_staff_row("qyh_staff.itname = '" . $row->itname . "'");
                    if ($qyhStaff) {
                        // 同步更改组织
                        $qyhStaffDept = $this->qyhdd_model->qyh_dept_row("qyh_id = " . $qyhStaff->qs_qyh_id);
                        if ($row->rootid != $qyhStaffDept->sd_id) {
                            $qyhStaffDeptNew = $this->qyhdd_model->qyh_dept_row("sd_id = " . $row->rootid);
                            ////////////////// move
                            $upQyh['userid'] = $row->itname;
                            $upQyh['department'] = array($qyhStaffDeptNew->qyh_id);
                            // print_r($upQq);
                            $reQyh = $this->curl_post($upQyh, 'user/update');
                            $reQyh = json_decode($reQyh);
                            if ($reQyh->errcode > 0) {
                                echo $reQyh->errmsg;
                            } else {
                                // save  
                                $qyhStaff['qs_qyh_id'] = $qyhStaffDeptNew->qyh_id;
                                ////////////////// edit QQ   
                                $this->qyhdd_model->qyh_staff_edit($row->itname, $qyhStaff);
                                echo 0;
                            }
                            ////////////////// move 
                        }
                    } else {
                        // 同步微信
                        ////////////////// add
                        $upQyh['userid'] = $row->itname;
                        $upQyh['name'] = $row->cname;
                        $upQyh['email'] = $row->email;
                        $qyhStaffDept = $this->qyhdd_model->qyh_dept_row("sd_id = " . $row->rootid); // loading dept  qyh_id
                        $upQyh['department'] = array($qyhStaffDept->qyh_id);
                        if ($type == 1) {
                            $this->load->model("tongxun_model"); // load Mob
                            $staffMob = $this->tongxun_model->staffs_addree_row("itname = '" . $row->itname . "'"); // loading dept  qyh_id
                            if ($staffMob) {
                                if ($staffMob->sa_mobile) {
                                    $mobile = $staffMob->sa_mobile;
                                    // echo $row->itname . " 无手机号码！";
                                } else {
                                    $mobile = "";
                                }
                            } else {
                                $mobile = "";
                            }
                        } else {
                            $data['itname'] = $row->itname;
                            $data['sa_mobile'] = $mobile;
                            $this->load->model("tongxun_model");
                            $this->tongxun_model->edit_address($data); //lizd11
                        }
                        if ($mobile) {
                            $upQyh['mobile'] = $mobile;
                            $reQyh = $this->curl_post($upQyh, 'user/create');
                            $reQyh = json_decode($reQyh);
                            //  print_r($reQyh);
                            if ($reQyh->errcode > 0) {
                                if ($reQyh->errcode == 60102) {   // 已经存在的账号更新
                                    $upQyh['userid'] = $row->itname;
                                    $upQyh['department'] = array($qyhStaffDept->qyh_id);
                                    // print_r($upQq);
                                    $reQyh = $this->curl_post($upQyh, 'user/update');

                                    $qyhStaff['itname'] = $row->itname;
                                    $qyhStaff['qs_qyh_id'] = $qyhStaffDept->qyh_id;
                                    $this->qyhdd_model->qyh_staff_add($qyhStaff);

                                    echo 1;
                                } else {
                                    echo $reQyh->errmsg;
                                }
                            } else {
                                // save  
                                $qyhStaff['itname'] = $row->itname;
                                $qyhStaff['qs_qyh_id'] = $qyhStaffDept->qyh_id;
                                $this->qyhdd_model->qyh_staff_add($qyhStaff);

                                $yaoqing['userid'] = $row->itname;
                                $yq = $this->curl_post($yaoqing, 'invite/send'); // 邀请关注
                                //  print_r(json_decode($yq));
                                echo 1;
                            }
                        } else {
                            $upQyh['mobile'] = "";
                            echo $row->itname . " 无手机号码！";
                        }
                    }
                    //print_r($staff);
                    // echo "1";
                }
            } else {
                echo "本组织结构下无用户！！";
            }
        } else {
            echo "Error!";
        }
    }

/////
    function qyh_oamtc_sync() {  // 批量导入用户
        $id = $this->input->post('id');
        if ($id) {
            $dept = $this->deptsys_model->get_dept_val('id  =  ' . $id);
            $this->cismarty->assign("dept", $dept);
            $this->cismarty->display($this->sysconfig_model->templates() . '/qyhdd/qyh_oamtc_sync.tpl');
        } else {
            echo "Error!";
        }
    }

    ///
    function qyh_oamtc_sync_do() {  // 批量导入用户
        $key = $this->input->post('key');
        $type = $this->input->post('type');
        $mobile = $this->input->post('mobile');

        if ($key) {
            if ($type == 1) {
                $where = "staff_main.rootid = $key";
            } else {
                $where = "staff_main.itname = '$key'";
            }
            $this->load->model("staff_model"); // load deptinfo
            // $where ='';
            $qyhStaff = $this->qyhdd_model->qyh_staffs_result(0, 0, $where);
            if ($qyhStaff) {
                foreach ($qyhStaff as $row) {
                    //  print_r($row);

                    $staff = $this->staff_model->get_staff_by("itname = '" . $row->itname . "'");
                    if ($staff) {
                        $this->load->model("deptsys_model"); // load Mob
                        $dept = $this->deptsys_model->get_dept_val('id = ' . $staff->rootid);
                        $this->load->model("tongxun_model"); // load Mob
                        $staffMob = $this->tongxun_model->staffs_addree_row("itname = '" . $row->itname . "'"); // loading dept  qyh_id
                        $upData["fdLoginName"] = $row->itname;
                        $upData["fdName"] = $staff->cname;
                        $upData["fdSex"] = $staff->gender;
                        $upData["fdBirthDay"] = '';
                        $upData["fdDepartmentName"] = $dept->deptName;
                        $upData["fdPostName"] = $staff->station;
                        $upData["fdMobilePhone"] = $staffMob->sa_mobile;
                        $upData["fdEmail"] = $row->itname . "@semir.com";
                        $upData["fdNumber"] = '';
                        $upData["fdIsAvailable"] = 1;
                        $reVal = $this->oamtc_snyc($upData);
                        if ($reVal->error == 1111) {
                            $upStaff['oa_mtc'] = 1;
                            $upStaff['oa_mtc_status'] = 1;
                            $this->qyhdd_model->qyh_staff_edit($row->itname, $upStaff);
                        } else {
                            //  echo $reVal->error . ' - ' . $reVal->error;
                        }
                    } else {
                        echo "请先同步企业号！！";
                    }
                    //print_r($staff);
                    // echo "1";
                }
                echo 1;
            } else {
                echo "本组织结构下无用户！！";
            }
        } else {
            echo "Error!";
        }
    }

    function qyh_staff_del() {
        $itname = $this->input->post('itname');
        if ($itname) {
            $qyhStaff = $this->qyhdd_model->qyh_staff_row("qyh_staff.itname = '" . $itname . "'");
            if ($qyhStaff) {
                $reQyh = $this->curl_get("userid=" . $itname, 'user/delete');
                $reQyh = json_decode($reQyh);
                // print_r($reQyh);
                if ($reQyh->errcode > 0) {
                    echo $reQyh->errmsg;
                } else {
                    ////////////////// del qyh_staff
                    $this->qyhdd_model->qyh_staff_del($itname);
                    echo 0;
                }
            } else {
                echo "Error!";
            }
        } else {
            echo "Error!";
        }
    }

    function qyh_dept_tree() {
        $arr = "";
        $result = $this->qyhdd_model->qyh_dept_result('');
        $sd_id = $this->input->post('sd_id');
        if ($sd_id) {
            
        } else {
            $sd_id = 1;
        }
        // echo  $sd_id;
        // print_r($result);
        foreach ($result as $val) { //as $val
            $deptSys = $this->deptsys_model->get_dept_val('id = ' . $val->sd_id);
            $arr[] = array('qyh_id' => $val->qyh_id, 'qyh_parentid' => $val->qyh_parentid, 'data' => $val->qyh_name, "attr" => array('sd_id' => $val->sd_id));
        }
        $ouTree = $this->list_to_tree($arr, "qyh_id", "qyh_parentid", "children", 1, $sd_id);
        print_r(json_encode($ouTree));
    }

    function tools() {
        $this->cismarty->display($this->sysconfig_model->templates() . '/bqq/tools.tpl');
    }

    /**
     * 测试工具 tools
     */
    /*
     * tools  更新DD用户
     */
    function tool_get_dd_staff() {
        $staff = $this->qyhdd_model->dd_staff_result(100, 2200, "");
        $i = 0;
        foreach ($staff as $row) { //as $val
            $i++;
            $staff = $this->staff_model->get_staff_by("itname = '" . $row->itname . "'");
            if ($staff) {
                $this->load->model("tongxun_model"); // load Mob
                $staffMob = $this->tongxun_model->staffs_addree_row("itname = '" . $row->itname . "'");
                // save
                if ($staffMob) {
                    $upDd['userid'] = $staff->itname;
                    $upDd['name'] = $staff->cname;
                    // print_r($staffMob);
                    if (strlen($staffMob->sa_tel) == 7 || strlen($staffMob->sa_tel) == 8) {
                        $bgTel = $staffMob->sa_code . '-' . $staffMob->sa_tel;
                    } else {
                        $bgTel = '';
                    }
                    $upDd['tel'] = '';
                    $upDd['extattr'] = array('办公电话' => $bgTel, '内线号码' => $staffMob->sa_tel_short);
                  //  print_r($upDd);
                    
                    $reQyh = $this->curl_post_dd($upDd, 'user/update');
                    $reQyh = json_decode($reQyh);
                    if ($reQyh->errcode > 0) {
                        echo $reQyh->errcode . "-60003=" . $row->itname . $reQyh->errmsg;
                    } else {
                        // save   
                        echo $i;
                    }
                    /* * 
                     */
                    echo "$staff->itname<br>";
                }
            }
        }
    }

    /*
     * tools  检测导入qyh 失败用户
     */

    function tool_get_qyhdd_staff() {
        $staff = $this->qyhdd_model->qyh_staffs_result(0, 0, '');
        foreach ($staff as $row) { //as $val
            $url = "user/get";
            $data = "&userid=" . $row->itname;
            $reQyh = $this->curl_get($data, $url);
            $reQyh = json_decode($reQyh);

            if ($reQyh->errcode > 0) {

                echo $row->itname;
                echo ',';
                // $this->qyhdd_model->qyh_staff_del($row->itname);
            } else {
                ////////////////// del qyh_staff
                //  print_r($row);
            }
        }
    }

    function tools_dd_user() {
        /*
          $this->db->from('sheet1');
          $this->db->order_by("itname", 'asc');
          $query = $this->db->get();
          foreach ($query->result() as $row) {
          // print_r($row);
          if ($row->itname) {
          $staff = $this->staff_model->get_staff_by("itname = '" . $row->itname . "'");
          if($staff){
          $data['jobnumber']=$row->jobnumber;
          $data['station']=$row->station;
          $this->db->where('itname', $row->itname);
          $this->db->update('staff_main', $data);
          }else{
          echo '系统无此用户:'.$row->cname.$row->itname.'</br>';
          }
          } else {
          echo '无itname:'.$row->cname.'</br>';
          }
          }
          exit;
         * 
         */
        // $url = "user/get";
        // $data = "&userid=lizhendong";
        //$reQyh = $this->curl_get_dd($data, $url);
        // $this->db->where("itname = 'jiangzhanwei'");
        $this->db->limit(1000, 1100);
        $this->db->from('qyh_dd_staff');
        $this->db->order_by("itname", 'asc');
        $query = $this->db->get();
        $i = 100;
        foreach ($query->result() as $row) {
            $i++;
            $upDd['userid'] = $row->itname;
            $staff = $this->staff_model->get_staff_by("itname = '" . $row->itname . "'");
            if ($staff) {
                if ($staff->jobnumber) {
                    $upDd['jobnumber'] = $staff->jobnumber;
                } else {
                    $upDd['jobnumber'] = "-";
                }
                $upDd['position'] = $row->station;
            }
            $this->load->model('tongxun_model');
            $add = $this->tongxun_model->staffs_addree_row("itname = '" . $row->itname . "'");
            if ($add) {
                if (strlen($add->sa_tel) == 7 || strlen($add->sa_tel) == 8) {
                    $bgTel = $add->sa_code . '-' . $add->sa_tel;
                    // $upDd['extattr'] = array('办公电话' => $bgTel);
                }
            }

            $reQyh = $this->curl_post_dd($upDd, 'user/update');
            $reQyh = json_decode($reQyh);
            if ($reQyh->errcode > 0) {
                echo 'Error:' . $row->itname . "<br>";
                print_r($reQyh);
            } else {
                echo $row->itname . "<br>";
                print_r($reQyh);
            }
            /**             * 
             */
        }
        echo $i;
    }

    function list_to_tree($list, $pk = 'id', $pid = 'data', $child = 'children', $root = "OU=Semir", $nowid = 1) {
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
                        //echo  $parent["id"]."/";
                        //echo $temPid."<br>";
//                      if ( $temPid == $parent["id"]){
//                            $parent["state"] = "open";
//                             $temPid = $parent["pid"];
//                            }

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

    function get_staff_info($itname) {
        $this->load->model("staff_model"); // load deptinfo
        $staff = $this->staff_model->get_staff_by("staff_main.itname = '" . $itname . "'");
        if ($staff) {
            $this->load->model("tongxun_model"); // load deptinfo
            $addreeInfo = $this->tongxun_model->staffs_addree_row("itname = '" . $itname . "'");
            if ($addreeInfo) {
                $staff->address = $addreeInfo;
            } else {
                $staff->address = '';
            }
        }
        return $staff;
    }

    /*
     * 钉钉 功能类
     * 
     */

    function dd_staff() {
        //  echo $this->qyh_gettoken();
        $sd_id = $this->uri->segment(4, 0);
        $search = $this->input->post('searchText');
        if (!$sd_id) {
            $sd_id = 0;
        }
        $this->cismarty->assign('menuUrl', array('staff', 'index'));
        $this->cismarty->assign("sd_id", $sd_id);
        //$this->cismarty->assign("data", $data['staffs']);
        // $this->cismarty->assign("links", $data['links']); 
        $this->cismarty->display($this->sysconfig_model->templates() . '/qyhdd/dd_staff.tpl');
    }

    function dd_staff_list() {
        $sd_id = $this->uri->segment(4, 0);
        $search = $this->input->post('key');
        if (!$sd_id) {
            $sd_id = 6;
        }
        $deptDd = $this->qyhdd_model->dd_dept_row('sd_id = ' . $sd_id);

        parse_str($_SERVER['QUERY_STRING'], $_GET);
        $sqlStr = "dd_id = " . $deptDd->dd_id;
        $deptIdArr = $this->qyhdd_model->dd_dept_child_id($sqlStr);
        $where_in = $deptIdArr;

        // print_r($deptIdArr);
        $where = "del_show = 0 and rootid = " . $sd_id;
        if ($search) {
            $where = "itname like '%" . $search . "%' or cname like  '%" . $search . "%' ";
        }
        //echo $where;
        $this->load->model('staff_model');
        $data['stafftemp'] = $this->staff_model->get_staffs(20, $this->uri->segment(5, 0), $where);
        $staffNumber = $this->staff_model->get_staffs('', '', $where);
        //print_r($data['stafftemp']);
        // 读取用户AD状态
        if ($data['stafftemp']) {
            foreach ($data['stafftemp'] as $row) {
                //  print_r($row);
                // load staff address
                $this->load->model("tongxun_model"); // load deptinfo
                $addreeInfo = $this->tongxun_model->staffs_addree_row("itname = '" . $row->itname . "'");
                if ($addreeInfo) {
                    $row->address = $addreeInfo;
                } else {
                    $row->address = '';
                }
                // load qyh&mtc info
                $qyhTemp = $this->qyhdd_model->dd_staff_row("itname = '" . $row->itname . "'");
                if ($qyhTemp) {
                    $row->ddStatus = 1;
                    $row->dd_staff = $qyhTemp;
                } else {
                    $row->ddStatus = 0;
                    $row->dd_staff = "";
                }
                $data['ddInfo'][] = $row;
            }
        } else {
            $data['ddInfo'] = '';
        }
        //  print_r($data['qygInfo']);
        //  exit();
        $linkUrl = "qyhdd/qyhdd/dd_staff_list/" . $sd_id . "/";
        $linkNumber = count($staffNumber);
        $uri_segment = 5;
        $data['links'] = $this->pagination($linkUrl, $linkNumber, $uri_segment, $where);
        $sss = str_replace('href', 'ajaxhref', $data['links']);
        // $this->load->view('staffLayout', $data); 
        $this->cismarty->assign("id", $sd_id);
        $this->cismarty->assign("data", $data['ddInfo']);
        $this->cismarty->assign("links", $sss);
        $this->cismarty->display($this->sysconfig_model->templates() . '/qyhdd/dd_staff_list.tpl');
    }

    function dd_staff_sync() {  // 批量导入用户
        $id = $this->input->post('id');
        if ($id) {
            $dept = $this->deptsys_model->get_dept_val('id  =  ' . $id);
            $this->cismarty->assign("dept", $dept);
            $this->cismarty->display($this->sysconfig_model->templates() . '/qyhdd/dd_staff_sync.tpl');
        } else {
            echo "Error!";
        }
    }

    function dd_staff_add() {  //导入用户
        $itname = $this->input->post('itname');
        if ($itname) {
            $this->load->model("staff_model"); // load deptinfo
            $staff = $this->staff_model->get_staff_by("staff_main.itname = '$itname'");
            $this->load->model("tongxun_model"); // load Mob
            $staffMob = $this->tongxun_model->staffs_addree_row("itname = '" . $itname . "'"); // loading dept  qyh_id
            if ($staffMob) {
                $staff->mobile = $staffMob->sa_mobile;
            } else {
                $staff->mobile = "";
            }
            $this->cismarty->assign("staff", $staff);
            $this->cismarty->display($this->sysconfig_model->templates() . '/qyhdd/dd_staff_add.tpl');
        } else {
            echo "Error!";
        }
    }

    function dd_staff_del() {
        $itname = $this->input->post('itname');
        if ($itname) {
            $ddStaff = $this->qyhdd_model->dd_staff_row("itname = '" . $itname . "'");
            if ($ddStaff) {
                $reQyh = $this->curl_get_dd("userid=" . $itname, 'user/delete');
                $reQyh = json_decode($reQyh);
                // print_r($reQyh);
                if ($reQyh->errcode > 0) {
                    echo $reQyh->errmsg;
                } else {
                    ////////////////// del qyh_staff
                    $this->qyhdd_model->dd_staff_del($itname);
                    echo 0;
                }
            } else {
                echo "Error!";
            }
        } else {
            echo "Error!";
        }
    }

    function dd_staff_sync_do() {  // 导入（单个或批量）用户
        $this->load->model("tongxun_model"); // load deptinfo
        $key = $this->input->post('key');
        $type = $this->input->post('type');
        // $mobile = $this->input->post('mobile');

        if ($key) {
            if ($type == 1) {
                $where = "staff_main.rootid = $key";
            } else {
                $where = "staff_main.itname = '$key'";
            }
            $this->load->model("staff_model"); // load deptinfo
            //$where = '';
            $staff = $this->staff_model->get_staffs(0, 0, $where);
            if ($staff) {
                foreach ($staff as $row) {
                    $ddStaff = $this->qyhdd_model->dd_staff_row("itname = '" . $row->itname . "'");
                    if ($ddStaff) {
                        // 同步更改组织
                        if ($ddStaff->dd_id) {
                            $ddStaffDept = $this->qyhdd_model->dd_dept_row("dd_id = " . $ddStaff->dd_id);
                            $sd_id = $ddStaffDept->sd_id;
                        } else {
                            $sd_id = '';
                        }
                        //if ($row->rootid != $sd_id) {
                        $ddStaffDeptNew = $this->qyhdd_model->dd_dept_row("sd_id = " . $row->rootid);
                        ////////////////// move
                        $upDd['userid'] = $row->itname;
                        $upDd['name'] = $row->cname;
                        $upDd['position'] = $row->station;
                        if ($row->jobnumber) {
                            $upDd['jobnumber'] = $row->jobnumber;
                        } else {
                            $upDd['jobnumber'] = "-";
                        }
                        // loading  tel 
                        $staffMob = $this->tongxun_model->staffs_addree_row("itname = '" . $row->itname . "'");
                        // save
                        if ($this->input->post('mobile')) {

                            $data['itname'] = $row->itname;
                            $data['sa_mobile'] = $this->input->post('mobile');
                            $this->load->model("tongxun_model");
                            //  $this->tongxun_model->edit_address($data);
                        }
                        //  $upDd['tel'] = $staffMob->sa_tel_short; 
                        // print_r($staffMob);
                        if (strlen($staffMob->sa_tel) == 7 || strlen($staffMob->sa_tel) == 8) {
                            $bgTel = $staffMob->sa_code . '-' . $staffMob->sa_tel;
                        } else {
                            $bgTel = '';
                        }
                        // 更改手机号码 

                        $upDd['mobile'] = $staffMob->sa_mobile;



                        $upDd['extattr'] = array('办公电话' => $bgTel, '内线号码' => $staffMob->sa_tel_short);

                        $upDd['department'] = array($ddStaffDeptNew->dd_id);

                        $reQyh = $this->curl_post_dd($upDd, 'user/update');
                        $reQyh = json_decode($reQyh);
                        if ($reQyh->errcode > 0) {
                            echo $reQyh->errcode . "-60003=" . $row->itname . $reQyh->errmsg;
                        } else {
                            // save  
                            $editStaff['dd_id'] = $ddStaffDeptNew->dd_id;
                            ////////////////// edit QQ   
                            $this->qyhdd_model->dd_staff_edit($row->itname, $editStaff);
                            echo 0;
                        }
                        ////////////////// move 
                        // }

                        /*
                          if ($mobile) {
                          $upDd['userid'] = $row->itname;
                          $upDd['name'] = $row->cname;
                          $upDd['mobile'] = $mobile;
                          $upDd['position'] = $row->station;
                          if ($row->jobnumber) {
                          $upDd['jobnumber'] = $row->jobnumber;
                          } else {
                          $upDd['jobnumber'] = "-";
                          }
                          //load  办公电话 / 分机  tel
                          $this->load->model('tongxun_model');
                          $staffMob = $this->tongxun_model->staffs_addree_row("itname = '" . $row->itname . "'");
                          //$upDd['tel'] = $staffMob->sa_tel_short;
                          if (strlen($staffMob->sa_tel) == 7 || strlen($staffMob->sa_tel) == 8) {
                          $bgTel = $staffMob->sa_code . '-' . $staffMob->sa_tel;
                          } else {
                          $bgTel = '';
                          }
                          $upDd['extattr'] = array('办公电话' => $bgTel, '内线号码' => $staffMob->sa_tel_short);


                          $reQyh = $this->curl_post_dd($upDd, 'user/update');
                          $reQyh = json_decode($reQyh);
                          if ($reQyh->errcode > 0) {
                          echo $reQyh->errcode . "-60002/$mobile/=" . $row->itname . $reQyh->errmsg;
                          } else {
                          // save
                          $data['itname'] = $row->itname;
                          $data['sa_mobile'] = $mobile;
                          $this->load->model("tongxun_model");
                          $this->tongxun_model->edit_address($data); //lizd11

                          echo 1;
                          }
                          } */
                    } else {
                        // 同步dingding
                        ////////////////// add
                        $upDd['userid'] = $row->itname;
                        $upDd['name'] = $row->cname;
                        $upDd['email'] = $row->email;
                        $upDd['position'] = $row->station;
                        if ($row->jobnumber) {
                            $upDd['jobnumber'] = $row->jobnumber;
                        } else {
                            $upDd['jobnumber'] = "-";
                        }
                        $ddStaffDept = $this->qyhdd_model->dd_dept_row("sd_id = " . $row->rootid); // loading dept  qyh_id
                        $upDd['department'] = array($ddStaffDept->dd_id);
                        $bgTel = '';
                        $tel = "";
                        $mobile = "";
                        if ($type == 1) {
                            $this->load->model("tongxun_model"); // load Mob
                            $staffMob = $this->tongxun_model->staffs_addree_row("itname = '" . $row->itname . "'"); // loading dept  qyh_id 
                            if ($staffMob) {
                                if ($staffMob->sa_mobile) {
                                    $mobile = $staffMob->sa_mobile;
                                    $tel = $staffMob->sa_tel_short;
                                    if (strlen($staffMob->sa_tel) == 7 || strlen($staffMob->sa_tel) == 8) {
                                        $bgTel = $staffMob->sa_code . '-' . $staffMob->sa_tel;
                                    } else {
                                        $bgTel = '';
                                    }
                                    // echo $row->itname .  
                                }
                            }
                        } else {
                            $data['itname'] = $row->itname;
                            $data['sa_mobile'] = $this->input->post('mobile');
                            $mobile = $this->input->post('mobile');
                            $this->load->model("tongxun_model");
                            $this->tongxun_model->edit_address($data); //lizd11
                        }
                        if ($mobile) {
                            $upDd['mobile'] = $mobile;
                            $upDd['extattr'] = array('办公电话' => $bgTel, '内线号码' => trim($tel));
                            // $upDd['tel'] = trim($tel);
                            //$upDd['isHide'] = true;
                            // $upDd['isLeader'] = true;
                            $reQyh = $this->curl_post_dd($upDd, 'user/create');
                            $reQyh = json_decode($reQyh);
                            //  print_r($reQyh);
                            if ($reQyh->errcode > 0) {
                                if ($reQyh->errcode == 60102 || $reQyh->errcode == 60104) {   // 已经存在的账号更新
                                    $upDd['userid'] = $row->itname;
                                    $upDd['department'] = array($ddStaffDept->dd_id);

                                    // print_r($upQq);
                                    $reQyh = $this->curl_post_dd($upDd, 'user/update');
                                    $ddStaff['itname'] = $row->itname;
                                    $ddStaff['dd_id'] = $ddStaffDept->dd_id;

                                    $this->qyhdd_model->dd_staff_add($ddStaff);

                                    echo 1;
                                } else {
                                    echo $reQyh->errcode . '-60001=' . $row->itname . $reQyh->errmsg;
                                }
                            } else {
                                // save  
                                $ddStaff['itname'] = $row->itname;
                                $ddStaff['dd_id'] = $ddStaffDept->dd_id;

                                $this->qyhdd_model->dd_staff_add($ddStaff);
                                echo 1;
                            }
                        } else {
                            $upQyh['mobile'] = "";
                            echo $row->itname . " 无手机号码！";
                        }
                    }
                    //print_r($staff);
                    // echo "1";
                }
            } else {
                echo "本组织结构下无用户！！";
            }
        } else {
            echo "Error!";
        }
    }

    function dd_dept() {

        //$this->cismarty->assign("ouData", $ouData);
        $this->cismarty->assign('menuUrl', array('deptsys', 'index'));
        $this->cismarty->display($this->sysconfig_model->templates() . '/qyhdd/dd_dept.tpl');
    }

    function dd_dept_list() {
        $this->load->model('deptsys_model');
        $root = $this->input->post('id');
        $result = $this->deptsys_model->get_dept_child_list('root = ' . $root); // child list
        // load qq deptinfo
        if ($result) {
            foreach ($result as $row) {
                // print_r($row);
                $sqlStr = "sd_id = " . $row->id;
                $deptId = $this->qyhdd_model->dd_dept_row($sqlStr);
                if ($deptId) {
                    if ($deptId->dd_id > 0) {
                        $row->dd_dept = 1;
                    } else {
                        $row->dd_dept = 0;
                    }
                } else {
                    $row->dd_dept = 0;
                }
            }
        } else {
            $resultStaff[] = $result;
        }
        //print_r($resultStaff);
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
        //    print_r($result);
        $this->cismarty->assign("ouDnPost", array_reverse($ouDnPost));
        $this->cismarty->assign("ouTemp", $ouTemp);  //array_unshift($fruits,"orange","pear")
        $this->cismarty->assign("ouData", $result);
        $this->cismarty->assign("rootid", $root);

        $this->cismarty->display($this->sysconfig_model->templates() . '/qyhdd/dd_dept_list.tpl');
    }

    function dd_dept_sync() {
        $id = $this->input->post('id');
        if ($id) {
            $dept = $this->deptsys_model->get_dept_val('id = ' . $id);
            $this->cismarty->assign("dept", $dept);
            $this->cismarty->assign("action", "edit");
            $this->cismarty->display($this->sysconfig_model->templates() . '/qyhdd/dd_dept_sync.tpl');
        } else {
            echo "Error!";
        }
    }

    function dd_dept_sync_do() {
        $sd_id = $this->input->post('sd_id');
        $toType = $this->input->post('toType');
        if ($toType == 1) {
            //  echo "1";
            $this->dd_dept_sync_fun($sd_id);
        }
        if ($toType == 2) {
            $model = $this->load->model("deptsys_model");
            $sqlStr = "id = " . $sd_id;
            $deptIdArr = $this->deptsys_model->get_dept_child_id($sqlStr);
            for ($i = 0; $i < count($deptIdArr); $i++) {
                //   echo $deptIdArr[$i];
                $this->dd_dept_sync_fun($deptIdArr[$i]);
            }
            // var_dump($deptIdArr);
            // echo "2";
        }
        exit();
    }

    function dd_dept_edit() {
        $sd_id = $this->input->post('sd_id');
        $dept = $this->deptsys_model->get_dept_val('id = ' . $sd_id);
        $deptDd = $this->qyhdd_model->dd_dept_row('sd_id = ' . $sd_id);
        $deptDdRoot = $this->qyhdd_model->dd_dept_row('sd_id = ' . $dept->root);
        // update qyh
        $upDd['id'] = $deptDd->dd_id;
        $upDd['parentid'] = $deptDdRoot->dd_id;
        $upDd['name'] = $dept->deptName;
        // print_r($upDd);
        $reQyh = $this->curl_post_dd($upDd, 'department/update');
        //  var_dump($reQq);
        $reQyh = json_decode($reQyh);
        if ($reQyh->errcode > 0) {
            echo $reQyh->errmsg;
        } else {
            $qyhDept['sd_id'] = $sd_id;
            $qyhDept['dd_parentid'] = $deptDdRoot->dd_id;
            $qyhDept['dd_name'] = $dept->deptName;
            $this->qyhdd_model->dd_dept_edit($sd_id, $qyhDept);
            echo 0;
        }
        exit();
    }

    function dd_dept_del() {
        $sd_id = $this->input->post('sd_id');
        $deptDd = $this->qyhdd_model->dd_dept_row('sd_id = ' . $sd_id);

        // print_r($dataHos);
        $reQyh = $this->curl_get_dd("id=" . $deptDd->dd_id, 'department/delete');
        //  var_dump($reQq);
        $reQyh = json_decode($reQyh);
        if ($reQyh->errcode > 0) {
            echo $reQyh->errmsg;
        } else {
            $this->qyhdd_model->dd_dept_del($sd_id);
            echo 0;
        }
    }

    function dd_dept_sync_fun($sd_id) {
        if ($sd_id) {
            $dept = $this->deptsys_model->get_dept_val('id = ' . $sd_id);
            $deptQyh = $this->qyhdd_model->dd_dept_row('sd_id = ' . $sd_id);
            if ($deptQyh) {
                
            } else {
                // load root id (p_dept_id)
                $deptRoot = $this->qyhdd_model->dd_dept_row('sd_id = ' . $dept->root);
                if ($deptRoot) {
                    $qyhNew['name'] = $dept->deptName;
                    $qyhNew['parentid'] = $deptRoot->dd_id;

                    $reDd = $this->curl_post_dd($qyhNew, 'department/create');
                    $reDd = json_decode($reDd);
                    //  print_r($reQyh);
                    if ($reDd->errcode > 0) {
                        if ($reDd->errcode == 60008) {

                            $qyhDept['sd_id'] = $sd_id;
                            $qyhDept['dd_id'] = $reDd->id;
                            $qyhDept['dd_parentid'] = $deptRoot->dd_id;
                            $qyhDept['dd_name'] = $dept->deptName;
                            $this->qyhdd_model->dd_dept_add($qyhDept);
                        } else {
                            echo $reDd->errcode . ':' . $reDd->errmsg;
                        }
                    } else {
                        // save 
                        $qyhDept['sd_id'] = $sd_id;
                        $qyhDept['dd_id'] = $reDd->id;
                        $qyhDept['dd_parentid'] = $deptRoot->dd_id;
                        $qyhDept['dd_name'] = $dept->deptName;
                        $this->qyhdd_model->dd_dept_add($qyhDept);
                        echo 0;
                    }
                } else {
                    echo "请确认父级组织结构是否导入";
                    exit();
                }
            }
        } else {
            echo "Error!";
        }
    }

    function dd_dept_tree() {
        $arr = "";
        $result = $this->qyhdd_model->dd_dept_result('');
        $sd_id = $this->input->post('sd_id');
        if ($sd_id) {
            
        } else {
            $sd_id = 1;
        }
        // echo  $sd_id;
        // print_r($result);
        foreach ($result as $val) { //as $val
            // print_r($val);
            $deptSys = $this->deptsys_model->get_dept_val('id = ' . $val->sd_id);
            $arr[] = array('dd_id' => $val->dd_id, 'dd_parentid' => $val->dd_parentid, 'data' => $val->dd_name, "attr" => array('sd_id' => $val->sd_id));
            //  $arr[] = array('qyh_id' => $val->qyh_id, 'qyh_parentid' => $val->qyh_parentid, 'data' => $deptSys->deptName, "attr" => array('sd_id' => $val->sd_id));
        }
        $ouTree = $this->list_to_tree($arr, "dd_id", "dd_parentid", "children", 1, $sd_id);
        print_r(json_encode($ouTree));
    }

    /*
     * curl function lizd11 20150916
     */

    function qyh_gettoken() {
        $ch = curl_init();
        $timeout = 5;
        $corpid = "wxdd4a8419cffdd0ea";
        $corpsecret = "577S1zIlBkUxscgeHH1fXoEa1TA_oA0_Mdnq1tTNz4XgfQ7tOPq4kcveAqql0NYz"; //   正式企业号信息
        curl_setopt($ch, CURLOPT_URL, 'https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=' . $corpid . '&corpsecret=' . $corpsecret);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 获取数据返回  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        // curl_setopt($ch, CURLOPT_BINARYTRANSFER, true); // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回  
        $output = curl_exec($ch);
        curl_close($ch);
        $return = json_decode($output);
        if ($return->access_token) {
            return $return->access_token;
        } else {
            echo "1";
            exit();
        }
    }

    function curl_post($data, $url) {
        $ch = curl_init();
        $timeout = 5;
        //  $code = json_encode($data);
        $code = json_encode($data, JSON_UNESCAPED_UNICODE);
        // $code = preg_replace("#\\\u([a-f]+)#ie", "iconv('UCS-2', 'UTF-8', pack('H4', '\\1'))", $code);
        // print_r($code);
        $aToken = $this->qyh_gettoken();
        curl_setopt($ch, CURLOPT_URL, "https://qyapi.weixin.qq.com/cgi-bin/" . $url . "?access_token=" . $aToken);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $code);
        $file_contents = curl_exec($ch);
        curl_close($ch);
        //   print_r($file_contents);
        return $file_contents;
    }

    function curl_get($data, $url) {
        $ch = curl_init();
        $timeout = 5;
        // print_r($code);
        $aToken = $this->qyh_gettoken();
        curl_setopt($ch, CURLOPT_URL, "https://qyapi.weixin.qq.com/cgi-bin/" . $url . "?access_token=" . $aToken . "&" . $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 获取数据返回  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        $file_contents = curl_exec($ch);
        curl_close($ch);
        // print_r($file_contents);
        return $file_contents;
    }

    /*
     * 
     * ///// dd apI
     */

    function dd_gettoken() {
        $ch = curl_init();
        $timeout = 5;
        $corpid = "ding6b7ba421ab4bac3b";
        $corpsecret = "vwPKkZnTEkBR85k9LkZIsUc-bXV0yEk-NMFU90C1qKWnYeiNQsiy2ApqoXsQFCS-"; //   测试企业号信息

        curl_setopt($ch, CURLOPT_URL, 'https://oapi.dingtalk.com/gettoken?corpid=' . $corpid . '&corpsecret=' . $corpsecret);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 获取数据返回  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        // curl_setopt($ch, CURLOPT_BINARYTRANSFER, true); // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回  
        $output = curl_exec($ch);
        curl_close($ch);
        $return = json_decode($output);
        //    var_dump($return);
        if ($return->access_token) {
            // echo $return->access_token;
            return $return->access_token;
        } else {
            echo "1";
            exit();
        }
    }

    function qyh_gettoken_dd() {   //正式系统
        $ch = curl_init();
        $timeout = 5;
        $corpid = "dingbf6fa52cc4e8549e";
        $corpsecret = "Fb815crEEVBFYyK0zfzoElRzdJnAJNCKtXLEeZ1y7_GQxkR4G0pYgGZayJ1Mvt3a"; //   dd正式信息
        curl_setopt($ch, CURLOPT_URL, 'https://oapi.dingtalk.com/gettoken?corpid=' . $corpid . '&corpsecret=' . $corpsecret);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 获取数据返回  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        // curl_setopt($ch, CURLOPT_BINARYTRANSFER, true); // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回  
        $output = curl_exec($ch);
        curl_close($ch);
        $return = json_decode($output);
        //  var_dump($return);
        //   exit;
        if ($return->access_token) {
            // echo $return->access_token;
            return $return->access_token;
        } else {
            echo "1";
            exit();
        }
    }

    function curl_post_dd($data, $url) {

        $ch = curl_init();
        $header = array(
            'Content-Type: application/json',
        );
        $timeout = 5;
        $code = json_encode($data, JSON_UNESCAPED_UNICODE);
        //  json_encode($data)
        //$code = preg_replace("#\\\u([a-f]+)#ie", "iconv('UCS-2', 'UTF-8', pack('H4', '\\1'))", $code);
        // print_r($code);
        $aToken = $this->qyh_gettoken_dd();
        curl_setopt($ch, CURLOPT_URL, "https://oapi.dingtalk.com/" . $url . "?access_token=" . $aToken);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $code);
        $file_contents = curl_exec($ch);
        curl_close($ch);
        // print_r($file_contents);
        return $file_contents;
    }

    function curl_get_dd($data, $url) {
        $ch = curl_init();
        $timeout = 5;
        // print_r($code);
        $aToken = $this->qyh_gettoken_dd();
        curl_setopt($ch, CURLOPT_URL, "https://oapi.dingtalk.com/" . $url . "?access_token=" . $aToken . "&" . $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 获取数据返回  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        $file_contents = curl_exec($ch);
        curl_close($ch);
        // print_r($file_contents);
        return $file_contents;
    }

    /*
     * dd Tools    
     */

    function dd_dept_list_temp() {
        $data = 'id=';
        $url = 'department/list';
        $temp = $this->curl_get_dd($data, $url);
        $a = json_decode($temp);
        print_r($a);
        exit;
        foreach ($a->department as $row) {
            $up['dd_id'] = $row->id;
            $up['dd_name'] = $row->name;
            if ($row->id == 1) {
                $up['dd_parentid'] = 0;
            } else {
                $up['dd_parentid'] = $row->parentid;
            }
            //  $this->qyhdd_model->dd_dept_add($up);
        }
    }

    function dd_staff_list_temp() {
        $dept = $this->qyhdd_model->dd_dept_result();
        count($dept);
        foreach ($dept as $row) {
            $data = "&department_id=" . $row->dd_id;
            $url = 'user/list';
            $temp = $this->curl_get_dd($data, $url);
            $a = json_decode($temp);
            print_r($a);
        }
        print_r($dept);
    }

    function dd_dept_temp() {
        $a = $this->qyhdd_model->dd_dept_result();
        foreach ($a as $row) {
            echo $row->dd_name;
            $dept = $this->qyhdd_model->get_dept_val("deptName = '" . trim($row->dd_name) . "'");
            print_r($dept);
            $sd_id['sd_id'] = $dept->id;
            // $this->qyhdd_model->dd_dept_edit($row->qd_id, $sd_id);
        }
    }

    /*
     * dd Tools     end
     * 
     */

    function oamtc_snyc($data) {
        header("content-type:text/html;charset=utf-8");
        $this->load->library('Nusoap');
        // 要访问的webservice路径
        $NusoapWSDL = "http://wxapp.semir.com.cn:8081/webservice/MtcCommonUserWebService?wsdl"; ///  //http://10.90.18.75:8016/Pages/webservice/WSuserrights.asmx?WSDL
        //$NusoapWSDL = "http://ums.zj165.com:8888/sms_hb/services/Sms?wsdl";
        $nusoap_client = new SoapClient($NusoapWSDL);
        $nusoap_client->soap_defencoding = 'utf-8';
        $nusoap_client->decode_utf8 = false;
        $nusoap_client->xml_encoding = 'utf-8';
        $param = $data;
        $result = $nusoap_client->send($param);
        return json_decode($result->return);
    }

}
