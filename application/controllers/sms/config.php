<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// 资产管理模块 lzd 20130108
class Config extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('DX_Auth');
        $this->dx_auth->check_uri_permissions();
        $this->load->model('sms_model');
        $this->sysconfig_model->sysInfo(); // set sysInfo
        $this->mainmenu_model->showMenu();
          $this->cismarty->assign("menuController", $this->showConMenu());
        $this->cismarty->assign("urlF", $this->uri->segment(1));
        $this->cismarty->assign("urlS", $this->uri->segment(2));
    }
 function showConMenu() {
        $showmenu = NULL;
        $showmenu .= "<li><a href=" . site_url("sms/sms/index") . " >用户资产</a></li>";
        $showmenu .= "<li><a href=" . site_url("sms/sms/sms_main_list") . " >资产信息</a></li>";
        $showmenu .="<li><a href=" . site_url("sms/sms/finance") . " >财务审核</a></li>";
        $showmenu .="<li><a href=" . site_url("sms/sms/history_list") . " >历史报表</a></li>";
        $showmenu .="<li><a href=" . site_url("sms/sms/reports") . " >统计报表</a></li>";
        $showmenu .="<li><a href=" . site_url("sms/config") . " >资产配置</a></li>";
       
        return $showmenu;
    }
    function showmenu() {
        $showmenu = "<ul class=leftmenu>";
        $showmenu .="<li><a href=" . site_url("sms/config/number") . " >资产编号</a></li>";
        $showmenu .= "<li><a href=" . site_url("sms/config/index") . " >资产类别</a></li>";
        $showmenu .= "<li><a href=" . site_url("sms/config/location") . " >地点管理</a></li>";
       // $showmenu .="<li><a href=" . site_url("sms/config/permissions") . " >管理权限</a></li>";
        $showmenu .="</ul>";
        return $showmenu;
    }

    function pagination($linkUrl, $linkModel, $uri_segment, $condition = "") {
        $this->load->library('pagination');
        $config['base_url'] = site_url($linkUrl);
        $config['total_rows'] = $this->sms_model->$linkModel($condition);
        $config['per_page'] = 50;
        $config['uri_segment'] = $uri_segment;
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }

    function config() {
       
        $data['category'] = $this->sms_model->get_category();
        $this->cismarty->assign('menuUrl', array('sms', 'index'));
        $this->cismarty->assign("data", $data['category']);
        $this->cismarty->assign("showmenu", $this->showmenu());
        $this->cismarty->display($this->sysconfig_model->templates() . '/sms/category.tpl'); //permissions
         
    }

    function category_add() {
     
        $sc_root = $this->uri->segment(4);
        $this->cismarty->assign("sc_root", $sc_root);
        $this->cismarty->display($this->sysconfig_model->templates() . '/sms/category_add.tpl');
        //print_r($sms_dept);
    }

    function category_add_save() {
      
        $data['sc_root'] = $this->input->post('sc_root');
        $data['sc_name'] = $this->input->post('sc_name');
        $data['sc_type'] = $this->input->post('sc_type');
        $data['sc_sort'] = $this->input->post('sc_sort');
        $result = $this->sms_model->sms_category_add($data);
        if ($result) {
            if($this->input->post('tooa') == 1){
                 $this->load->model('oadb_model');
                 $resultOa = $this->oadb_model->sms_category_add($data);
                 if(!$resultOa){
                      echo 2;
                     exit();
                 }
            }
            echo 1;
        } else {
            echo 0;
        }
        //print_r($sms_dept);
    }

    function category_edit() {
    
        $sc_id = $this->uri->segment(4);
        $sms_main = $this->sms_model->sms_category_by("sc_id = " . $sc_id);
        // print_r($sms_main);
        if ($sms_main) {
            $this->cismarty->assign("data", $sms_main);
            $this->cismarty->display($this->sysconfig_model->templates() . '/sms/category_edit.tpl');
        } else {
            echo 0;
        }
        //print_r($sms_dept);
    }

    function category_edit_save() {
   
        $sc_id = $this->input->post('sc_id');
        $data['sc_name'] = $this->input->post('sc_name');
        $data['sc_sort'] = $this->input->post('sc_sort');
        $data['sc_type'] = $this->input->post('sc_type');
     //   echo $this->input->post('tooa');
       // exit();
        $result = $this->sms_model->sms_category_edit($sc_id, $data);
        if ($result) {
             if($this->input->post('tooa') == 1){
                 $this->load->model('oadb_model');
                 $resultOa = $this->oadb_model->sms_category_edit($sc_id,$data);
               //  print_r($resultOa);
                 if(!$resultOa){
                      echo 2;
                     exit();
                 } 
            }
            echo 1;
        } else {
            echo 0;
        }
        //print_r($sms_dept);
    }

    function category_del() {
    
        $sc_id = $this->input->post('sc_id');
        $result = $this->sms_model->sms_category_del($sc_id);
        if ($result) {
              $this->load->model('oadb_model');
                 $resultOa = $this->oadb_model->sms_category_del($sc_id);
                 if(!$resultOa){
                      echo 2;
                     exit();
                 }
            echo 1;
        } else {
            echo 0;
        }
        //print_r($sms_dept);
    }

    function location() {
     
        $data = $this->sms_model->location_list();
        //print_r($data);
        $this->cismarty->assign('menuUrl', array('sms', 'config'));
        $this->cismarty->assign("data", $data);
        $this->cismarty->assign("showmenu", $this->showmenu());
        $this->cismarty->display($this->sysconfig_model->templates() . '/sms/location.tpl'); //permissions
    }

    function location_add() {
     
        $sc_root = $this->uri->segment(4);
        $this->cismarty->assign("sc_root", $sc_root);
        $this->cismarty->display($this->sysconfig_model->templates() . '/sms/location_add.tpl');
        //print_r($sms_dept);
    }

    function location_add_save() {
         $data['sl_name'] = $this->input->post('sl_name');
        $data['sl_sort'] = $this->input->post('sl_sort');
        $result = $this->sms_model->sms_location_add($data);
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
        //print_r($sms_dept);
    }

    function location_edit() {
      $sl_id = $this->uri->segment(4);
        $sms_local = $this->sms_model->sms_location_by("sl_id = " . $sl_id);
        // print_r($sms_main);
        if ($sms_local) {
            $this->cismarty->assign("data", $sms_local);
            $this->cismarty->display($this->sysconfig_model->templates() . '/sms/location_edit.tpl');
        } else {
            echo 0;
        }
        //print_r($sms_dept);
    }

    function location_edit_save() {
       $sl_id = $this->input->post('sl_id');
        $data['sl_name'] = $this->input->post('sl_name');
        $data['sl_sort'] = $this->input->post('sl_sort');
        $result = $this->sms_model->sms_location_edit($sl_id, $data);
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
        //print_r($sms_dept);
    }

    function location_del() {
        $sl_id = $this->input->post('sl_id');
        $result = $this->sms_model->sms_location_del($sl_id);
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
        //print_r($sms_dept);
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