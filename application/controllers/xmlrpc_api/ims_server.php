<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// API 接口
class Ims_server extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('xmlrpc');
        $this->load->library('xmlrpcs');
        $this->load->model('imsapi_model');
    }

    function index() {
        $this->cismarty->display($this->sysconfig_model->templates() . '/ims_api/guide.tpl');
    }

///////////////// 用户状态查询/////////////////////////////////////////////////////////////////////////
    function userseach() {
        $config['functions']['Greetings'] = array('function' => 'Ims_server.user_com');
        // print_r();
        $this->xmlrpcs->initialize($config);
        $this->xmlrpcs->serve();
    }

    function user_com($request) {
        $parameters = $request->output_parameters();
        //  print_r($parameters);
        //  exit();
        // ////////////////////////////////////////////////////////////////////////////////////
        $where = "staff_main.itname = '" . $parameters[0] . "'";
        $result = $this->imsapi_model->staff_info_by($where);
        $this->load->model("deptsys_model"); // load deptinfo
        $ouTemp = $this->deptsys_model->get_dept_child_DN('id = ' . $result->rootid);
        $deptOu = implode(',', $ouTemp);
//        ////
        $system_id = explode(',', $result->system_id);   // load system 
        if ($system_id) {
            for ($i = 0; $i < count($system_id); $i++) {
                //  echo $system_id[$i];
                $sysTemp = $this->imsapi_model->system_code_by("FIND_IN_SET(" . (int) $system_id[$i] . " ,ss_key)");
                if ($sysTemp) {
                    $systemTemp[] = $sysTemp->codetext;
                } else {
                    $systemTemp = '';
                }
            }
            if ($systemTemp) {
                $systemInfo = implode(',', array_unique($systemTemp));
            } else {
                $systemInfo = 'Null';
            }
        } else {
            $systemInfo = 'Null';
        }
        // 
        $response = array(
            array(
                $result->cname, //'$result->cname',
                $deptOu,
                $systemInfo
            ),
            'struct');
        return $this->xmlrpc->send_response($response);
    }

///////////////// 用户登录/////////////////////////////////////////////////////////////////////////
    function userLogin() {
        $config['functions']['Greetings'] = array('function' => 'Ims_server.user_login_com');
        // print_r();
        $this->xmlrpcs->initialize($config);
        $this->xmlrpcs->serve();
    }

    /////  
    function user_login_com($request) {
        $parameters = $request->output_parameters();

      //  $where = "itname =  '" . $parameters[0] . "'";
        $this->load->library('adldaplibrary');
        $adldap = new adLDAP();
        $loginTrue = $adldap->user()->authenticate($parameters[0], $parameters[1]);
        if ($loginTrue){
		  $response = array(
                array('1','true'),
                'struct');
            //  print_r($resultTemp);
            ///  exit();
            return $this->xmlrpc->send_response($response);
        }else{
            return FALSE;
        }
         
        
    }

///////////////// 用户更新查询/////////////////////////////////////////////////////////////////////////
    function load_user() {
        $config['functions']['Greetings'] = array('function' => 'Ims_server.load_user_com');
        // print_r();
        $this->xmlrpcs->initialize($config);
        $this->xmlrpcs->serve();
    }

    ///// 读取 表 staff_system_api 信息
    function load_user_com($request) {
        $where = "state = 0";
        $result = $this->imsapi_model->load_staff_system_api($where);
        if ($result) {
            foreach ($result as $val) {
                $resultTemp[] = implode('$', $val);
            }
            $response = array(
                $resultTemp,
                'struct');
            //  print_r($resultTemp);
            ///  exit();
            return $this->xmlrpc->send_response($response);
        }
    }

    ////////////////////////////////////////////////////////////////////////////////
    function process($request) {
        $parameters = $request->output_parameters();
        //  print_r($parameters);
        // exit();
        $response = array(
            $parameters,
            'struct');

        return $this->xmlrpc->send_response($response);
    }

}
