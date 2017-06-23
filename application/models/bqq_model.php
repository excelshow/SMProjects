<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Bqq_model extends CI_Model {

    function __construct() {
        parent::__construct();
        
    }

    function bqq_dept_result($condition = "") {
        $this->db->select('*');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('bqq_dept');
        $query = $this->db->get();
        return $query->result();
    }

    function bqq_dept_row($condition = "") {
        $this->db->select('*');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('bqq_dept');
        $query = $this->db->get();
        return $query->row();
    }

    function bqq_staff_row($condition = "") {
        $this->db->select('*');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('bqq_staff');
        $this->db->order_by("bqq_staff.bs_qq", 'asc');
        $query = $this->db->get();
        return $query->row();
    }

    function get_staffs_where_in($limit = 0, $offset = 0, $condition = "", $arr) {
        $this->db->select('* ');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        if ($arr) {
            $this->db->where_in('bqq_staff.sd_rootid', $arr);
        }
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('bqq_staff');
        // $this->db->join('staff_main','staff_main.itname = bqq_staff.itname','INNER');
        $this->db->order_by("bqq_staff.bs_qq", 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function get_systems($limit = 0, $offset = 0, $condition = "") {
        $this->db->select('*');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_system');
        $this->db->order_by("staff_system.sortBy", 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function add_sd($data) {
        date_default_timezone_set("PRC");
        if ($this->db->insert("bqq_dept", $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function bqq_staff_add($data) {
        date_default_timezone_set("PRC");
        if ($this->db->insert("bqq_staff", $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function bqq_staff_edit($bs_qq, $data) {
        date_default_timezone_set("PRC");
        $this->db->where('bs_qq', $bs_qq);
        if ($this->db->update('bqq_staff', $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function edit_sd($sd_id, $data) {

        date_default_timezone_set("PRC");

        $this->db->where('sd_id', $sd_id);

        if ($this->db->update('bqq_dept', $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    /*
     * QQ 号码分配(QQ状态从停用修改为正常，并修改QQ号码的组织结构)
     * $sd_id = QQ号码新组织结构
     * $staffInfo = QQ对应的用户信息，包括itname，组织结构等
     * $qq 号码可为空
     */

    function user_bind_itname($sd_id, $staffInfo, $qq) {
        $staffTrue = $this->bqq_staff_row("bqq_staff.itname = '" . $staffInfo->itname . "'");
        if ($staffTrue) {
            echo "此用户已经有企业QQ号码！";
        } else {
           //echo $qq;
            if ($qq) {
                $SqlQQ = 'bqq_staff.bs_qq = ' . $qq;
            } else {
                $SqlQQ = 'bqq_staff.bs_status = 2 and bqq_staff.sd_rootid=6 ';
            }
           // echo $SqlQQ;
            $qqStaff = $this->bqq_staff_row($SqlQQ);
           // print_r($qqStaff);
            // exit();
            if ($qqStaff) {
                $qqhm = $qqStaff->bs_qq;

                $deptIdNew = $this->bqq_dept_row("sd_id = " . $sd_id);
                $upQq['open_id'] = $qqStaff->qq_open_id;
                //  print_r($deptId);
                //   ////////////////// 修改QQ号码状态
                $upQq['status'] = 1;
                $reQq = $this->curl_post($upQq, 'user_status');
              //  print_r($reQq);
                ////////////////// 修改QQ号码状态
                ////////////////// move

                $upQq['dept_id'] = 1;
                $upQq['new_dept_id'] = $deptIdNew->qq_dept_id;
                $reQq = $this->curl_post($upQq, 'user_move');
              //  print_r($reQq);
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
             //   print_r($reQq);
                ////////////////// edit QQ  
                if ($qqStaff->bs_status != 3) {
                    $aa['bs_status'] = 1;
                    $aa['sd_rootid'] = $sd_id;
                }
                $aa['itname'] = $staffInfo->itname;
                $this->bqq_staff_edit($qqhm, $aa);  ///////写入表 bqq_staff   
                return 0;
            } else {
                echo "所选QQ号码资源已经用完！";
            }
        }
    }

    /*
     * QQ 号码分离(QQ状态3,保留号码，清除用户信息；状态1=停用号码，清除用户信息)
     * $qq 号码可为空
     */

    function user_out_itname($qq) {
        $qqInfo = $this->bqq_staff_row('bqq_staff.bs_qq = ' . $qq);
        if ($qqInfo) {
            $upQq['open_id'] = $qqInfo->qq_open_id;
            if ($qqInfo->bs_status == 3) {
                $upQq['itname'] = 'semir'. rand(10, 9999);
                $upQq['cname'] = '岗位号码';
                $reQq = $this->curl_post($upQq, 'user_mod');
                $aa['itname'] = "";
                $this->bqq_staff_edit($qq, $aa);  ///////写入表 bqq_staff  
            } else {
                $upQq['itname'] = 'semir' . $qq;//rand(10, 9999);
                $upQq['cname'] = '集团帐号';
                $reQq = $this->curl_post($upQq, 'user_mod');
                
                $upQq['status'] = 2;
                $reQq = $this->curl_post($upQq, 'user_status');
                
                $aa['bs_status'] = 2;
                $aa['sd_rootid'] = 6;
                $aa['itname'] = "";
                $this->bqq_staff_edit($qq, $aa);  ///////写入表 bqq_staff  
            }
            echo 0;
        } else {
            echo "无此QQ号码";
        }
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
