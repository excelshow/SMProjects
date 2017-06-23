<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Bqq extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->dx_auth->check_uri_permissions();
        $this->load->model('deptsys_model');
        $this->load->model('staff_model');
        $this->load->model('bqq_model');
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
        $showmenu .= "  <li><a href=" . site_url("bqq/bqq/index") . " >用户QQ</a></li>
                        <li><a href=" . site_url("bqq/bqq/dept") . " >组织结构</a></li><li><a href=" . site_url("bqq/bqq/tools") . " >QQ工具</a></li>";

        return $showmenu;
    }

    function index() {

        $sd_id = $this->uri->segment(4, 0);
        $search = $this->input->post('searchText');
        if (!$sd_id) {
            $sd_id = 0;
        }
        $this->cismarty->assign('menuUrl', array('staff', 'index'));
        $this->cismarty->assign("sd_id", $sd_id);
        //$this->cismarty->assign("data", $data['staffs']);
        // $this->cismarty->assign("links", $data['links']); 
        $this->cismarty->display($this->sysconfig_model->templates() . '/bqq/index.tpl');
    }

    function bqqlist() {
        $id = $this->uri->segment(4, 0);
        $search = $this->input->post('key');
        if (!$id) {
            $id = 1;
        }
        parse_str($_SERVER['QUERY_STRING'], $_GET);
        $model = $this->load->model("deptsys_model");
        $sqlStr = "id = " . $id;
        $deptIdArr = $this->deptsys_model->get_dept_child_id($sqlStr);
        $where_in = $deptIdArr;

        // print_r($result);
        $where = "";
        //echo $where;
        $data['stafftemp'] = $this->bqq_model->get_staffs_where_in(20, $this->uri->segment(5, 0), $where, $where_in);
        $staffNumber = $this->bqq_model->get_staffs_where_in('', '', $where, $where_in);
        //print_r($data['stafftemp']);
        // 读取用户AD状态
        if ($data['stafftemp']) {
            foreach ($data['stafftemp'] as $row) {
                $this->load->model("deptsys_model"); // load deptinfo
                $dept = $this->deptsys_model->get_dept_val("id = " . $row->sd_rootid);
                if ($dept) {
                    $ouTemp = $this->deptsys_model->get_dept_child_DN('id = ' . $row->sd_rootid);
                    if ($ouTemp) {
                        $row->deptOu = implode("&raquo;", $ouTemp);
                    } else {
                        $row->deptOu = "";
                    }
                    $row->deptname = $dept->deptName;
                } else {
                    $row->deptOu = "";
                    $row->deptname = "暂无";
                }
                // load staff info
                if ($row->itname) {
                    $row->staffInfo = $this->get_staff_info($row->itname);
                } else {
                    $row->staffInfo = '';
                }
                // load qq status

                $data['QqInfo'][] = $row;
            }
        } else {
            $data['QqInfo'] = '';
        }
        // print_r($data['QqInfo']);
        //  exit();
        $linkUrl = "bqq/bqq/bqqlist/" . $id . "/";
        $linkNumber = count($staffNumber);
        $uri_segment = 5;
        $data['links'] = $this->pagination($linkUrl, $linkNumber, $uri_segment, $where);
        $sss = str_replace('href', 'ajaxhref', $data['links']);
        // $this->load->view('staffLayout', $data);
        //    print_r($data['QqInfo']);
        $this->cismarty->assign("id", $id);
        $this->cismarty->assign("data", $data['QqInfo']);
        $this->cismarty->assign("links", $sss);
        $this->cismarty->display($this->sysconfig_model->templates() . '/bqq/bqqlist.tpl');
    }

    function dept() {

        //$this->cismarty->assign("ouData", $ouData);
        $this->cismarty->assign('menuUrl', array('deptsys', 'index'));
        $this->cismarty->display($this->sysconfig_model->templates() . '/bqq/dept.tpl');
    }

    function user_add_auto() {  // 批量新加QQ号码
        $this->cismarty->display($this->sysconfig_model->templates() . '/bqq/user_add_auto.tpl');
    }

    function user_add_auto_do() {
        $number = $this->input->post("qqs");
        if ($number) {
            for ($i = 0; $i < $number; $i++) {
                $data['account'] = 'semir' . $i . rand(10, 9999);
                $data['name'] = '集团帐号';
                $data['p_dept_id'] = 1;
                $reQq = $this->curl_post($data, 'user_add'); ////////////////////// 新开QQ
                $reQq = json_decode($reQq);
                if ($reQq->ret > 0) {
                    echo $reQq->msg;
                } else {
                    $dataLoc['bs_status'] = 2; // baoliu
                    $dataLoc['qq_open_id'] = $reQq->data->open_id;
                    $dataLoc['sd_rootid'] = 6;
                    $dataLoc['bs_qq'] = $reQq->qq->$dataLoc['qq_open_id'];
                    $dataLoc['itname'] = ''; // baoliu
                    // print_r($dataLoc);
                    $this->bqq_model->bqq_staff_add($dataLoc);  ///////写入表 bqq_staff   
                    $upQq['open_id'] = $reQq->data->open_id;
                    $upQq['status'] = 2;
                    $reQq = $this->curl_post($upQq, 'user_status'); ////////////////// 停用新开QQ号码
                    echo 0;
                }
            }
        } else {
            echo "Null";
        }
    }

    function user_edit_batch() {  // 批量为部门分配QQ号码
        $id = $this->input->post('id');
        if ($id) {
            $dept = $this->deptsys_model->get_dept_val('id  =  ' . $id);
            $this->cismarty->assign("dept", $dept);
            $this->cismarty->display($this->sysconfig_model->templates() . '/bqq/user_edit_batch.tpl');
        } else {
            echo "Error!";
        }
    }

    function user_edit_batch_do() {
        $sd_id = $this->input->post('sd_id');
        $toType = $this->input->post('toType');
        $qqs = $this->input->post('qqs');
        $qqe = $this->input->post('qqe');
        if ($toType == 1) {
            $this->load->model("staff_model"); // load deptinfo
            $staff = $this->staff_model->get_staffs(0, 0, "staff_main.rootid = $sd_id");

            if ($staff) {
                foreach ($staff as $row) {
                    $staffTrue = $this->bqq_model->bqq_staff_row("bqq_staff.itname = '" . $row->itname . "'");

                    if ($staffTrue) {
                        // 同步更改组织
                        echo $sd_id;
                        echo "/";
                        echo $staffTrue->sd_rootid;
                        if ($sd_id != $staffTrue->sd_rootid) {
                            $deptId = $this->bqq_model->bqq_dept_row("sd_id = " . $staffTrue->sd_rootid);
                            $deptIdNew = $this->bqq_model->bqq_dept_row("sd_id = " . $sd_id);
                            ////////////////// move
                            $upQq['open_id'] = $staffTrue->qq_open_id;
                            $upQq['dept_id'] = $deptId->qq_dept_id;
                            $upQq['new_dept_id'] = $deptIdNew->qq_dept_id;
                            // print_r($upQq);
                            $reQq = $this->curl_post($upQq, 'user_move');
                            ////////////////// move 
                             ////////////////// edit QQ  
                            $qqhm = $staffTrue->bs_qq;
                            $aa['sd_rootid'] = $sd_id; 
                            $this->bqq_model->bqq_staff_edit($qqhm, $aa);  
                        ///////写入表 bqq_staff 
                        }
                        
                    } else {
                        // 同步QQ号码
                        $staffInfo = $this->get_staff_info($row->itname);
                        $SqlQQ = 'bqq_staff.bs_status = 2 and bqq_staff.sd_rootid=6 ';
                        if ($qqs && $qqe) {
                            $SqlQQ .=' and ' . $qqs . ' < bqq_staff.bs_qq and bqq_staff.bs_qq <' . $qqe;
                        }
                        $qqStaff = $this->bqq_model->bqq_staff_row($SqlQQ);
                        if ($qqStaff) {
                            $qqhm = $qqStaff->bs_qq;
                            $sqlStr = "sd_id = " . $qqStaff->sd_rootid;
                            $deptId = $this->bqq_model->bqq_dept_row($sqlStr);
                            $deptIdNew = $this->bqq_model->bqq_dept_row("sd_id = " . $sd_id);
                            $upQq['open_id'] = $qqStaff->qq_open_id;
                            //  print_r($deptId);
                            //   ////////////////// 修改QQ号码状态
                            $upQq['status'] = 1;
                            $reQq = $this->curl_post($upQq, 'user_status');
                            ////////////////// 修改QQ号码状态
                            ////////////////// move
                            $upQq['dept_id'] = $deptId->qq_dept_id;
                            $upQq['new_dept_id'] = $deptIdNew->qq_dept_id;
                            $reQq = $this->curl_post($upQq, 'user_move');
                            ////////////////// move 
                            ////////////////// edit QQ 
                            // print_r($staffInfo);
                            $upQq['itname'] = $staffInfo->itname;
                            $upQq['cname'] = $staffInfo->cname;
                            if ($staffInfo->gender == 1) {
                                $upQq['gender'] = 2;
                            } else {
                                $upQq['gender'] = 1;
                            }
                            $reQq = $this->curl_post($upQq, 'user_mod');
                            //  print_r($reQq);
                            ////////////////// edit QQ  
                            $aa['bs_status'] = 1;
                            $aa['sd_rootid'] = $sd_id;
                            $aa['itname'] = $staffInfo->itname;
                            $this->bqq_model->bqq_staff_edit($qqhm, $aa);  ///////写入表 bqq_staff 
                        } else {
                            echo "所选QQ号码资源已经用完！";
                        }
                    }
                    //print_r($staff);
                    echo "1";
                }
            } else {
                echo "本组织结构下无用户！！";
            }
        }
        if ($toType == 2) {
            echo "功能开发中。。。。";
        }
    }

    /*
     * qq号码绑定 用户
     */

    function user_bind_itname() {  //  
        $qq = $this->input->post('qq');
        if ($qq) {
            $this->cismarty->assign("qq", $qq);
            $this->cismarty->display($this->sysconfig_model->templates() . '/bqq/user_bind_itname.tpl');
        } else {
            echo "Error!";
        }
    }

    /*
     * qq号码绑定 用户
     */

    function user_bind_itname_do() {  // 批量为部门分配QQ号码
        $qq = $this->input->post('qq');
        $itname = $this->input->post('itname');
        $staffInfo = $this->get_staff_info($itname);
        //print_r($staffInfo);
        if ($staffInfo) {
            $this->bqq_model->user_bind_itname($staffInfo->rootid, $staffInfo, $qq);
        } else {
            echo "无此用户！！";
        }
    }

    /*
     * qq 号码用户分离或回收
     */

    function user_out_itname_do() {  // 批量为部门分配QQ号码
        $qq = $this->input->post('qq');
        if ($qq) {
            $this->bqq_model->user_out_itname($qq);
        } else {
            echo "选择QQ！！";
        }
    }

    function user_edit_batch_do_back() {
        $sd_id = $this->input->post('sd_id');
        $toType = $this->input->post('toType');
        if ($toType == 1) {
            $this->load->model("staff_model"); // load deptinfo
            $staff = $this->staff_model->get_staffs(0, 0, "staff_main.rootid = $sd_id");
//                $upQq['dept_id'] = 1;
//                $upQq['new_dept_id'] = 2133111218;
//                $upQq['open_id'] = "53106459e3bce2f3e7665955b5b42891";
//                $reQq = $this->curl_post($upQq, 'user_move'); ////////////////// 停用新开QQ号码
//                 print_r($reQq);
//                 exit();
            for ($i = 2881167771; $i < 2881167789; $i++) {
                $qqStaff = $this->bqq_model->bqq_staff_row("bqq_staff.bs_status = 2 and bqq_staff.bs_qq = " . $i);
                // print_r($qqStaff);
                if ($qqStaff) {
                    $sqlStr = "sd_id = " . $qqStaff->sd_rootid;
                    $deptId = $this->bqq_model->bqq_dept_row($sqlStr);
                    $deptIdNew = $this->bqq_model->bqq_dept_row("sd_id = " . $sd_id);
                    $upQq['open_id'] = $qqStaff->qq_open_id;
                    //  print_r($deptId);
                    //   ////////////////// 修改QQ号码状态
                    $upQq['status'] = 1;
                    $reQq = $this->curl_post($upQq, 'user_status'); ////////////////// 停用新开QQ号码
                    ////////////////// 修改QQ号码状态
                    ////////////////// move
                    $upQq['dept_id'] = $deptId->qq_dept_id;
                    $upQq['new_dept_id'] = $deptIdNew->qq_dept_id;

                    $reQq = $this->curl_post($upQq, 'user_move'); ////////////////// 停用新开QQ号码
                    ////////////////// move 
                    $aa['bs_status'] = 1;
                    $aa['sd_rootid'] = $sd_id;
                    $this->bqq_model->bqq_staff_edit($i, $aa);  ///////写入表 bqq_staff   
                }
            }
            //print_r($staff);
            echo "1";
        }
        if ($toType == 2) {
            $model = $this->load->model("deptsys_model");
            $sqlStr = "id = " . $sd_id;
            $deptIdArr = $this->deptsys_model->get_dept_child_id($sqlStr);
            for ($i = 0; $i < count($deptIdArr); $i++) {
                echo $deptIdArr[$i];
            }
            // var_dump($deptIdArr);
            // echo "2";
        }
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

    function dept_list() {
        // $this->authorization->check_permission($this->uri->segment(2), '1');
        $this->load->model('deptsys_model');
        $root = $this->input->post('id');
        $result = $this->deptsys_model->get_dept_child_list('root = ' . $root); // child list
        // load qq deptinfo
        if ($result) {
            foreach ($result as $row) {
                $sqlStr = "sd_id = " . $row->id;
                $deptId = $this->bqq_model->bqq_dept_row($sqlStr);
                if ($deptId) {
                    if ($deptId->qq_dept_id > 0) {
                        $row->bqq_dept = 1;
                        $row->qq_dept_id = $deptId->qq_dept_id;
                        $row->qq_p_dept_id = 1;
                    } else {
                        $row->bqq_dept = 0;
                    }
                } else {
                    $row->bqq_dept = 0;
                }
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
        //    print_r($result);
        $this->cismarty->assign("ouDnPost", array_reverse($ouDnPost));
        $this->cismarty->assign("ouTemp", $ouTemp);  //array_unshift($fruits,"orange","pear")
        $this->cismarty->assign("ouData", $result);
        $this->cismarty->assign("rootid", $root);

        $this->cismarty->display($this->sysconfig_model->templates() . '/bqq/dept_list.tpl');
    }

    function dept_toqq() {
        $id = $this->input->post('id');
        if ($id) {
            $dept = $this->deptsys_model->get_dept_val('id = ' . $id);
            $this->cismarty->assign("dept", $dept);
            $this->cismarty->assign("action", "edit");
            $this->cismarty->display($this->sysconfig_model->templates() . '/bqq/dept_toqq.tpl');
        } else {
            echo "Error!";
        }
    }

    function dept_toqq_do() {
        $sd_id = $this->input->post('sd_id');
        $toType = $this->input->post('toType');
        if ($toType == 1) {
            //  echo "1";
            $this->dept_toqq_fun($sd_id);
        }
        if ($toType == 2) {
            $model = $this->load->model("deptsys_model");
            $sqlStr = "id = " . $sd_id;
            $deptIdArr = $this->deptsys_model->get_dept_child_id($sqlStr);
            for ($i = 0; $i < count($deptIdArr); $i++) {
                //   echo $deptIdArr[$i];
                $this->dept_toqq_fun($deptIdArr[$i]);
            }
            // var_dump($deptIdArr);
            // echo "2";
        }
        exit();
    }

    function dept_upqq_do() {
        $sd_id = $this->input->post('sd_id');
        $dept = $this->deptsys_model->get_dept_val('id = ' . $sd_id);
        $deptQq = $this->bqq_model->bqq_dept_row('sd_id = ' . $sd_id);

        // update bQQ
        $dataHos['deptName'] = $dept->deptName;
        $dataHos['dept_id'] = $deptQq->qq_dept_id;
        $dataHos['p_dept_id'] = $deptQq->qq_p_dept_id;
        // print_r($dataHos);
        $reQq = $this->curl_post($dataHos, 'dept_mod');
        //  var_dump($reQq);
        $reQq = json_decode($reQq);
        if ($reQq->ret > 0) {
            echo $reQq->msg;
        } else {
            echo 0;
        }
        exit();
    }

    function dept_delqq() {
        $sd_id = $this->input->post('sd_id');
        $deptQq = $this->bqq_model->bqq_dept_row('sd_id = ' . $sd_id);
        // update bQQ
        $dataHos['dept_id'] = $deptQq->qq_dept_id;

        // print_r($dataHos);
        $reQq = $this->curl_post($dataHos, 'dept_del');
        //  var_dump($reQq);
        $reQq = json_decode($reQq);
        if ($reQq->ret > 0) {
            echo $reQq->msg;
        } else {
            $dataLoc['qq_dept_id'] = 0;
            $dataLoc['qq_p_dept_id'] = 0;
            $this->bqq_model->edit_sd($sd_id, $dataLoc);
            echo 0;
        }
        exit();
    }

    function dept_toqq_fun($sd_id) {
        if ($sd_id) {
            $dept = $this->deptsys_model->get_dept_val('id = ' . $sd_id);
            $deptQq = $this->bqq_model->bqq_dept_row('sd_id = ' . $sd_id);
            if ($deptQq) {
                
            } else {
                // save bqq_dept
                $dataQ['sd_id'] = $sd_id;
                $dataQ['sd_root'] = $dept->root;
                $this->bqq_model->add_sd($dataQ);
            }
            // load root id (p_dept_id)
            $deptRoot = $this->bqq_model->bqq_dept_row('sd_id = ' . $dept->root);
            if ($deptRoot) {
                $dataLoc['qq_p_dept_id'] = $deptRoot->qq_dept_id;
                $dataHos['p_dept_id'] = $deptRoot->qq_dept_id;
                // into bQQ
                $dataHos['deptName'] = $dept->deptName;
                $reQq = $this->curl_post($dataHos, 'dept_add');
                $reQq = json_decode($reQq);
                if ($reQq->ret > 0) {
                    echo $reQq->msg;
                } else {
                    $dataLoc['qq_dept_id'] = $reQq->data->dept_id;
                    $this->bqq_model->edit_sd($sd_id, $dataLoc);
                    echo 0;
                }
            } else {
                echo "请确认父级组织结构是否导入";
                exit();
            }
        } else {
            echo "Error!";
        }
    }

    function qq_dept_tree() {
        $arr = "";
        $result = $this->bqq_model->bqq_dept_result('');
        $sd_id = $this->input->post('sd_id');
        if ($sd_id) {
            
        } else {
            $sd_id = 0;
        }
        // echo  $sd_id;
        //  print_r($result);
        foreach ($result as $val) { //as $val
            $deptSys = $this->deptsys_model->get_dept_val('id = ' . $val->sd_id);
            if ($deptSys) {
                if ($val->sd_id == $sd_id) {
                    $arr[] = array('sd_id' => $val->sd_id, 'sd_root' => $val->sd_root, 'data' => $deptSys->deptName, "attr" => array('sd_id' => $val->sd_id), "state" => "open"); // , "state" => "open"
                } else {
                    $arr[] = array('sd_id' => $val->sd_id, 'sd_root' => $val->sd_root, 'data' => $deptSys->deptName, "attr" => array('sd_id' => $val->sd_id));
                }
            } else {
                //  echo $val->sd_id;
            }
        }
        $ouTree = $this->list_to_tree($arr, "sd_id", "sd_root", "children", 0, $sd_id);
        print_r(json_encode($ouTree));
    }

    function tools() {
        $this->cismarty->display($this->sysconfig_model->templates() . '/bqq/tools.tpl');
    }

    /**
     * 修改QQ状态为启用
     */
    function tools_status_do() {
        $qq = $sd_id = $this->input->post('qq');
        $qqStaff = $this->bqq_model->bqq_staff_row("bqq_staff.bs_qq = " . $qq);
        // print_r($qqStaff);
        if ($qqStaff) {

            $upQq['open_id'] = $qqStaff->qq_open_id;
            //  print_r($deptId);
            //   ////////////////// 修改QQ号码状态
            $upQq['status'] = 1;
            $reQq = $this->curl_post($upQq, 'user_status');
            ////////////////// 修改QQ号码状态
            if ($qqStaff->bs_status != 3) {
                $aa['bs_status'] = 1;
                $this->bqq_model->bqq_staff_edit($qq, $aa);  ///////写入表 bqq_staff   
            }
            echo 0;
        }
    }

    /**
     * 修改QQ状态为启用
     */
    function tools_qq_do() {
        
    }

    function user_qq() {

        $open_ids = $this->input->post('open_ids');
        // print_r($dataHos);
        $reQq = $this->curl_post($dataHos, 'dept_mod');
        //  var_dump($reQq);
        $reQq = json_decode($reQq);
        if ($reQq->ret > 0) {
            echo $reQq->msg;
        } else {
            echo 0;
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

    function curl_post($data, $url) {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, 'http://smbqq.sinaapp.com/testapi/smgapi/' . $url . '.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $file_contents = curl_exec($ch);
        curl_close($ch);
        return $file_contents;
    }

}
