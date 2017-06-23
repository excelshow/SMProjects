<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ddgjapi extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('string');
        $model = $this->load->model("deptsys_model");
        $this->load->model('staff_model');
    }

    function getDepartment() {
        $skey = $this->input->post('skey');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        
        if ($skey != 'Ddgj2016') {
            $redate['result'] = 1;
            $redate['info'] = '7001:访问API密钥参数错误';
            echo json_encode($redate);
            exit;
        }
        if ($start_date && $end_date) {
            $list = array();
            $where = "datetime > '" . $start_date . "' and  datetime < '" . $end_date . "'";
            $result = $this->deptsys_model->get_deptall_result(0, 0, $where); //  
            if ($result) {
                foreach ($result as $row) {
                    $data['type'] = 1;
                    $data['id'] = $row->id;
                    $data['name'] = $row->deptName;
                    $data['parent_id'] = $row->root;
                    $data['create_time'] = time();
                    $list[] = $data;
                }
            }

            $result_scrap = $this->deptsys_model->get_deptall_result_scrap(0, 0, $where); // 删除
            if ($result_scrap) {
                foreach ($result_scrap as $row) {
                    $data['type'] = 2;
                    $data['id'] = $row->id;
                    $data['name'] = $row->deptName;
                    $data['parent_id'] = $row->root;
                    $data['create_time'] = time();
                    $list[] = $data;
                }
            }
            $redate['result'] = 0;
            $redate['info'] = count($list) . '件';
            $redate['department'] = $list;
            echo json_encode($redate);
        } else {
            $redate['result'] = 1;
            $redate['info'] = '7002:参数错误';
            echo json_encode($redate);
            exit;
        }
    }

    function getMember() {
        $skey = $this->input->post('skey');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $department_id = $this->input->post('department_id');
        if ($skey != 'Ddgj2016') {
            $redate['result'] = 1;
            $redate['info'] = '7001:访问API密钥参数错误-.skey = ' . $skey;
            echo json_encode($redate);
            exit;
        }
        if ($start_date && $end_date) {
            $list = array();
            $where = "modifytime > '" . $start_date . "' and  modifytime < '" . $end_date . "'";
            if ($department_id > 0) {
                $where .= "and rootid = " . $department_id;
            }
            $wherea = " or (sa_uptime > '" . $start_date . "' and  sa_uptime < '" . $end_date . "')";
            $result = $this->staff_model->get_staffs_join_address(0, 0, $where . $wherea); //  
            if ($result) {
                foreach ($result as $row) {
                    $data['type'] = 1;
                    $data['user_id'] = $row->itname;
                    $data['name'] = $row->cname;
                    $data['mobile'] = $row->sa_mobile;
                    $data['extattr'] = array('办公电话' => $row->sa_code . '-' . $row->sa_tel, '分机号码' => $row->sa_tel_short);
                    $data['email'] = $row->email;
                    $data['position'] = $row->station;
                    $data['jobnumber'] = $row->jobnumber;
                    $data['gender'] = $row->gender;
                    $data['department_id'] = $row->rootid;
                    $data['create_time'] = time();
                    $list[] = $data;
                }
            }
            $result_scrap = $this->staff_model->get_staffs_scrap(0, 0, $where); // 删除
            if ($result_scrap) {
                foreach ($result_scrap as $row) {
                    $data['type'] = 2;
                    $data['user_id'] = $row->itname;
                    $data['name'] = $row->cname;
                    $data['mobile'] = $row->mobtel;
                    $data['email'] = $row->email;
                    $data['position'] = $row->station;
                    $data['jobnumber'] = $row->jobnumber;
                    $data['gender'] = $row->gender;
                    $data['department_id'] = $row->rootid;
                    $data['create_time'] = time();
                    $list[] = $data;
                }
            }
            $redate['result'] = 0;
            $redate['info'] = count($list) . '件';
            $redate['member'] = $list;

            echo json_encode($redate);
        } else {
            $redate['result'] = 1;
            $redate['info'] = '7002:参数错误';
            echo json_encode($redate);
            exit;
        }
    }

    /*
     * curl function lizd11 20150916
     */
    /*
     * curl function lizd11 20150916
     */

    function test() {
        $ch = curl_init();
        $timeout = 50000;
       
        /*$key = 'J3ECG2sQ4Om6B1Mr';
        list($t1, $t2) = explode(' ', microtime()); 
        $data['long_time'] = $t2 .ceil(($t1 * 1000)); // date('Y-m-d H:i:s');
        $data['encrypt'] = md5($key . $data['long_time']);
        $data['user_id'] = 'test';
        print_r($data);
        curl_setopt($ch, CURLOPT_URL, 'http://dd.semir.cc/api/v1/orgDel');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 获取数据返回  
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
                //  'Content-Length: ' . strlen(json_encode($data))
                )
        );
        $output = curl_exec($ch);
        curl_close($ch);
        echo $output;
        exit;
/*
*/
        ////
        $ch = curl_init();
        $timeout = 50000;
        $data['skey'] = "Ddgj2016";
        $data['start_date'] = "2017-02-16";
        $data['end_date'] = "2017-02-17";
        $data['department_id'] = 0;
       // print_r($data);
      //  exit;
        curl_setopt($ch, CURLOPT_URL, 'http://10.90.18.23/index.php/public/ddgjapi/getMember');//getDepartment
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 获取数据返回  
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);
        curl_close($ch);
        echo $output;
        exit;
        $return = json_decode($output);
        if ($return->access_token) {
            return $return->access_token;
        } else {
            echo "1";
            exit();
        }
    }

    /* //////////////////////////////////
     *  OA 获取 资产编号
     * *///////////////////////////////////////
    /////////////////////////
}
