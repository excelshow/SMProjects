<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Deptlist extends CI_Controller {

    function __construct() {
        parent::__construct();
        //$this->load->library('DX_Auth');
        // $this->dx_auth->check_uri_permissions();
        $this->sysconfig_model->sysInfo(); // set sysInfo
        $model = $this->load->model("deptsys_model");
        $this->cismarty->assign("urlF", $this->uri->segment(2));
        $this->cismarty->assign("urlS", $this->uri->segment(3));
    }

    function ipcheck() {
        $itname = $this->input->post('itname');
        if ($itname) {
            echo $itname;
        } else {
            echo "0.0.0.0";
        }
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

    function deptselect() {

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

}
