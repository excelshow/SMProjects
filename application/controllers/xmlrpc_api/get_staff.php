<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Get_staff extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('xml');
    }

    function staff_info() {
        // 报修平台获取用户信息
        //header("Access-Control-Allow-Origin：*");
        header("Content-Type:text/xml");

        $this->load->model('xmlrpc_model');
        $query = $this->xmlrpc_model->get_staff_address(0, 0, 'del_show = 0 ');
        // $query = $this->db->get("staff_dept");
        // print_r($query);

        if (!$query) {
            return false;
            exit();
        }
        $xml = '<?xml version="1.0" encoding="utf-8"?> ';
        $xml .= '<root><user>';
        $address = '';
        foreach ($query as $row) {
            //$this->load->model("deptsys_model");
            $deptName = '';
           /*  if ($row->rootid) {
                // loading dept
                $dept = $this->deptsys_model->get_dept_val("id = " . $row->rootid);
                if ($dept) {
                    // $row->deptOu = $dept->deptName;
                    $deptName = htmlspecialchars($dept->deptName); //Rsj("itname")&"/"&Rsj("cname")&"/"&Rsj("saff_dept")&"/"&Rsj("email")&","
                } else {
                    $deptName = '';
                }
            }
            // loading address
           $this->load->model('tongxun_model');
            $address = $this->tongxun_model->staffs_addree_row("itname = '" . $row->itname . "'");
            if ($address) {
                $addr = $address->sa_tel;
            } else {
                $addr = '';
            }
            * 
            */
            $xml .= '<u>' . $row->itname . '/' . $row->cname . '/' . htmlspecialchars($row->station."-".$row->deptName)  . '/' . $row->sa_tel   .'/' . $row->email  . '</u>';

            // print_r($fields);
        }
        $xml .= '</user></root>';
        echo $xml;
    }

    function deptStaffOu($rootId = '') {
        $this->load->model("deptsys_model");
        $root = $rootId;
        if (!$root) {
            $root = 0;
        }
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
        return $ouTemp;
    }

}
