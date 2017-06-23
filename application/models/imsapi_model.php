<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Imsapi_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // 查询 user 信息 //////////////////////////////////
    function staff_info_by($condition = "") {
        $this->db->select('*');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_main');
        $query = $this->db->get();
        return $query->row();
    }

    function system_code_by($condition = "") {
        $this->db->select('*');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_system_code');
        $query = $this->db->get();
        return $query->row();
    }

    // 查询 user权限 是否更新 //////////////////////////////////
    function system_api_check($condition = "") {

        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_system_api');
        $query = $this->db->get();

        return $query->result_array();
    }

    function load_staff_system_api($condition = "") {
        $this->db->select('itname,msText,msType');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_system_api');
        $query = $this->db->get();
        $this->db->update('staff_system_api', array("state" => 1)); // update 标识是否同步完成或查询
        return $query->result_array();
    }

    function load_system_api_del($condition = "") {
        if ($condition) {
            $this->db->where($condition);
            $query = $this->db->delete('staff_system_api');
        }
    }

    // 获取业务系统更改，更新本系统 //////////////////////////////////
    function api_up_yewu($data) {
        if ($data) {    ///////////////////////////////Array ( [0] => lijuan01;Sc03;S02 [1] => lijie;Sc02;S01,S02 [2] => tanghao;Sc02;S01 ) 
            $setInfo = explode('||', $data);

            foreach ($setInfo as $row) {
                $temp = explode(';', $row);
                $itname = $temp[0];
                //   echo $row;
                $system = explode(',', $temp[2]);
                $system_id = "";
                $system_id_new = array();
                // 获取system_id
                foreach ($system as $rows) {
                    $this->db->where("code = '" . $rows . "'");
                    $this->db->from('staff_system_code');
                    $query = $this->db->get();
                    $systemInfo = $query->row();
                    if ($systemInfo) {
                        $system_id .= $systemInfo->ss_key . ",";
                    } else {
                        $system_id = "";
                    }
                }
                $this->load->model("staff_model"); // load deptinfo
                $staffInfo = $this->staff_model->get_staff_by("itname = '" . $itname . "'");
                if ($staffInfo) {

                    $stId = explode(',', $staffInfo->system_id);
                    //  print_r($stIdarray);
                    //    echo array_search("9991", $stId);
                    if (in_array("9991", $stId)) {
                        unset($stId[array_search("9991", $stId)]); // 清空业务系统编号 9991，9992，9993，9994
                    }
                    if (in_array("9992", $stId)) {
                        unset($stId[array_search("9992", $stId)]); // 清空业务系统编号 9991，9992，9993，9994
                    }
                    if (in_array("9993", $stId)) {
                        unset($stId[array_search("9993", $stId)]); // 清空业务系统编号 9991，9992，9993，9994
                    }
                    if (in_array("9994", $stId)) {
                        unset($stId[array_search("9994", $stId)]); // 清空业务系统编号 9991，9992，9993，9994
                    }
                    $stIdtemp = implode(',', $stId);
                    //  echo $stIdtemp;
                    $system_id_temp = $system_id . ',' . $stIdtemp;

                    $system_id_new = explode(',', $system_id_temp);

                    array_unique($system_id_new); //删除相同元素
                    //array_filter($system_id_new); // 删除空元素
                    foreach ($system_id_new as $k => $v) {
                        if ($v == '') {
                            unset($system_id_new[$k]);
                        }
                    }
                    $result = $system_id_new;
                    // echo "<Br>";
                    //      print_r($result);
                    $staff['system_id'] = implode(',', $result);
                    $staff['id'] = $staffInfo->id;
                    $msg = $this->staff_model->edit($staff);   // 更新用户权限
                }
                //  echo $msg;
            }
        }
        //  echo $data;
    }

}