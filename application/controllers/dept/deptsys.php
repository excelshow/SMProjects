<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Deptsys extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('DX_Auth');
        $this->dx_auth->check_uri_permissions();
        $this->sysconfig_model->sysInfo(); // set sysInfo
        $this->sysconfig_model->set_sys_permission(); // set controller permission
        $this->mainmenu_model->showMenu();

        $model = $this->load->model("deptsys_model");
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

        //$this->cismarty->assign("ouData", $ouData);
        $this->cismarty->assign('menuUrl', array('deptsys', 'index'));
        $this->cismarty->display($this->sysconfig_model->templates() . '/dept/dept_sys.tpl');
    }

    function deptsys_tree() {
        $arr = "";
        $result = $this->deptsys_model->get_deptall();
        $id = $this->input->post('id');
        if (!$id) {
            $id = 0;
        }
        //echo  $id;
        foreach ($result as $val) { //as $val
            if ($val->id == $id) {
                $arr[] = array('id' => $val->id, 'pid' => $val->root, 'data' => $val->deptName, "attr" => array('id' => $val->id), "state" => "open"); // , "state" => "open"
            } else {
                $arr[] = array('id' => $val->id, 'pid' => $val->root, 'data' => $val->deptName, "attr" => array('id' => $val->id));
            }
        }
        $ouTree = $this->list_to_tree($arr, "id", "pid", "children", 0, $id);
        print_r(json_encode($ouTree));
    }

    function deptsys_tree_sms() {
        $arr = "";
        $result = $this->deptsys_model->get_deptall();
        $id = $this->input->post('id');
        if (!$id) {
            $id = 0;
        }
        //print_r($result);
        //echo  $id;
        foreach ($result as $val) { //as $val
            if ($val->id == $id) {
                if ($val->dt_id < 6) {
                    $arr[] = array('id' => $val->id, 'pid' => $val->root, 'data' => $val->deptName, "attr" => array('id' => $val->id), "state" => "open"); // , "state" => "open"
                }
            } else {
                if ($val->dt_id < 6) {
                    $arr[] = array('id' => $val->id, 'pid' => $val->root, 'data' => $val->deptName, "attr" => array('id' => $val->id));
                }
            }
        }
        //   print_r($arr);
        $ouTree = $this->list_to_tree($arr, "id", "pid", "children", 0, $id);
        // print_r($ouTree);
        print_r(json_encode($ouTree));
    }

    function deptsys_list() {
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
                if ($deptId) {
                    $strDept = implode(',', $deptId);
                    $whereNum = "staff_main.rootid IN (" . $strDept . ") ";
                    $this->load->model('staff_model');
                    // echo "<br>ssssss".$strDept;
                    $row->staffNum = $this->staff_model->get_num_rows($whereNum);
                } else {
                    $row->staffNum = 0;
                }
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
        //    print_r($result);
        $this->cismarty->assign("ouDnPost", array_reverse($ouDnPost));
        $this->cismarty->assign("ouTemp", $ouTemp);  //array_unshift($fruits,"orange","pear")
        $this->cismarty->assign("ouData", $result);
        $this->cismarty->assign("rootid", $root);

        $this->cismarty->display($this->sysconfig_model->templates() . '/dept/deptsys_list.tpl');
    }

    function deptsys_add() {

        $dept_type = $this->deptsys_model->get_dept_type_list(); // child list
        //print_r($result);
        $this->cismarty->assign("dept_type", $dept_type);
        $this->cismarty->assign("action", "add");
        $this->cismarty->display($this->sysconfig_model->templates() . '/dept/deptsys_add.tpl');
    }

    function deptsys_edit() {

        $dept_type = $this->deptsys_model->get_dept_type_list(); // child list
        //print_r($result);
        $id = $this->input->post('id');
        if ($id) {
            $dept = $this->deptsys_model->get_dept_val('id = ' . $id);
            $this->cismarty->assign("dept_type", $dept_type);
            $this->cismarty->assign("dept", $dept);
            $this->cismarty->assign("action", "edit");
            $this->cismarty->display($this->sysconfig_model->templates() . '/dept/deptsys_edit.tpl');
        } else {
            echo "Error!";
        }
    }

    function check_dept_name() {
        $deptname = $this->input->post('deptname');
        $id = $this->input->post('id');
        if ($id) {
            $row = $this->deptsys_model->get_dept_val("deptName = '" . $deptname . "' and id <> " . $id);
            if ($row) {
                echo $row->deptName;
            } else {
                echo "Semir";
            }
        } else {
            $row = $this->deptsys_model->get_dept_val("deptName = '" . $deptname . "'");
            if ($row) {
                echo $row->deptName;
            } else {
                echo "Semir";
            }
        }
    }

    function dept_name_save() {
        $postdata = $this->get_post();
        //  print_r($postdata);
        $app = $postdata["uptype"];
        $tempdata["deptName"] = $postdata["ou_name"];
        $tempdata["root"] = $postdata["rootid"];
        $tempdata["sortBy"] = $postdata["sortBy"];
        if ($postdata["detail"]) {
            $tempdata["detail"] = $postdata["detail"];
        } else {
            $tempdata["detail"] = $postdata["ou_name"];
        }
        $tempdata["dt_id"] = $postdata["dt_id"];
        $tempdata['datetime'] = date('Y-m-d H:i:s');
        if ($postdata["action"] == "edit") {
            // edit
            $tempdata["id"] = $postdata["id"];
            $deptData = $this->deptsys_model->get_dept_val("id = " . $tempdata['id']);
            $msg = $this->deptsys_model->edit($tempdata);
            //print_r($tempdata);
            if ($msg ) {
                //  print_r($postdata["uptype"]);
                if (in_array("ad", $postdata["uptype"])) {  // 判断推送系统 $postdata["uptype"]
                    $this->load->library('adldaplibrary');
                    $adldap = new adLDAP();
                    $tempad["ou_name"] = $postdata["ou_name"];
                    $tempad["container"] = explode(",", $postdata["container"]);
                    // print_r($tempad);
                    $result = $adldap->folder()->rename($deptData->deptName, $tempad["ou_name"], $tempad['container']);
                    //var_dump($result);
                    if ($result) {
                        echo 1; // 写数据库 / AD 成功
                    } else {
                        echo 2; // 写数据库成功
                    }
                }
                if (in_array("rtx", $postdata["uptype"])) {  // 判断RTX推送系统 $postdata["uptype"]
                    $this->load->model("rtx_model");
                    $this->rtx_model->deptModify($deptData->deptName, $tempad["ou_name"]);
                }
            } else {
                echo 0; // 写数据库失败成功
            }
        }
        if ($postdata["action"] == "add") {
            // news add
            $msg = $this->deptsys_model->add($tempdata);
            if ($msg && $app) {
                if (in_array("ad", $postdata["uptype"])) {  // 判断推送系统 $postdata["uptype"]
                    $this->load->library('adldaplibrary');
                    $adldap = new adLDAP();
                    $tempad["ou_name"] = $postdata["ou_name"];
                    $tempad["container"] = explode(",", $postdata["container"]);
                    // print_r($tempad);
                    $result = $adldap->folder()->create($tempad);
                    //var_dump($result);
                    if ($result) {
                        echo 3; // 写数据库 / AD 成功
                    } else {
                        echo 1; // 写数据库成功
                    }
                }
                if (in_array("rtx", $postdata["uptype"])) {  // 判断推送系统 $postdata["uptype"]
                    $this->load->model("rtx_model"); //  RTX
                    if ($tempdata["root"] == 0) {
                        $this->rtx_model->deptAdd($tempdata["deptName"], "");
                    } else {
                        $deptData = $this->deptsys_model->get_dept_val("id = " . $tempdata["root"]);
                        $this->rtx_model->deptAdd($tempdata["deptName"], $deptData->deptName);
                    }
                }
            } else {
                echo 2; // 写数据库失败成功
            }
        }
    }

    function dept_name_del() {

        $id = $this->input->post('id');
        $childData = $this->deptsys_model->get_child_num($id);
        if ($childData) {
            echo 0; // 有下属组织结构，禁止删除！
        } else {
            $deptData = $this->deptsys_model->get_dept_val("id = " . $id);
            // print_r($deptData);
            //$this->deptsys_model->del($data);
            //   $this->deptsys_model->del("id = " . $id);  // 删除数据库
            //   $this->load->model("rtx_model"); // 删除 RTX
            //   $this->rtx_model->deptDel($deptData->deptName);
            //  echo 1; // 删除据库 / AD 成功
            if ($deptData) {  // 判断推送系统 $postdata["uptype"]
                $this->load->library('adldaplibrary');

                $adldap = new adLDAP();
                $ou_dn = "OU=" . $deptData->deptName . "," . $this->input->post('addn');
                // echo $ou_dn;
                $result = $adldap->folder()->delete($ou_dn);
                // var_dump($result);
                $msg = $this->deptsys_model->del("id = " . $id);  // 删除数据库
                //var_dump($msg);
                if ($result) {
                    $deptData->datetime = date('Y-m-d H:i:s');
                    $this->deptsys_model->add_scrap($deptData); //保存删除表
                    $msg = $this->deptsys_model->del("id = " . $id);  // 删除数据库
                    //   $this->load->model("rtx_model"); // 删除 RTX
                    //   $this->rtx_model->deptDel($deptData->deptName);
                    echo 3; // 删除据库 / AD 成功
                    if ($result) {
                        
                    } else {
                        echo 1; // 删除ad域失败
                    }
                } else {
                    echo 2; //删除数据库失败
                }
                echo 4; // 删除据库 / AD 成功
            }
        }
    }

    function get_post() {
        $data['rootid'] = $this->input->post('rootid');
        $data['dt_id'] = $this->input->post('dt_id');
        $data['container'] = $this->input->post('container');
        $data['addn'] = $this->input->post('addn');
        $data['ou_name'] = $this->input->post('ou_name');
        $data['detail'] = $this->input->post('detail');
        $data['sortBy'] = $this->input->post('sortBy');
        $data['uptype'] = $this->input->post('uptype');
        $data['action'] = $this->input->post('action');
        $data['id'] = $this->input->post('id');
        return $data;
    }

    function move($from, $to) {

        if (isset($from) && isset($to))
            $this->menu_model->move_category($from, $to);
    }

    function edit() {

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
        if ($msg) {
            echo $msg;
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

}
