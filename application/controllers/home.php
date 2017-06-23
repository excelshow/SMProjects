<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('DX_Auth');
       // $this->dx_auth->check_uri_permissions();
        if (!$this->dx_auth->is_logged_in()) {
            echo '您无操作权限请勿操作！！';
            exit();
        }
        $this->sysconfig_model->sysInfo(); // set sysInfo
        $this->mainmenu_model->showMenu();
        $menuCurrent = $this->showConMenu();
        $this->cismarty->assign("menuController", $menuCurrent);
        $this->cismarty->assign("urlF", $this->uri->segment(2));
        $this->cismarty->assign("urlS", $this->uri->segment(3));
        $this->cismarty->assign("pageTitle", '管理中心 - ');
    }

    function showConMenu() {
        $showmenu = '';
        return $showmenu;
    }

    function index() {
        //  $this->authorization->check_permission($this->uri->segment(1), '1');
        // echo "<br>";
        // var_dump($this->authorization->permission("staff", '1'));
        //print_r($this->session->userdata('DX_permission'));
        //  var_dump($this->dx_auth->check_controller_permissions('sms'));
        $data = "";
        $data['z_v'] = zend_version();
        $data['mysqlC'] = function_exists('mysql_close') ? "是" : "否";
        $data['mysqlG'] = @get_cfg_var("mysql.allow_persistent") ? "是" : "否";
        $data['mysqlB'] = @get_cfg_var("mysql.max_links") == -1 ? "不限" : @get_cfg_var("mysql.max_links");
        $data['uploadB'] = @get_cfg_var("upload_max_filesize") ? get_cfg_var("upload_max_filesize") : "不允许上传附件";
        $data['exTime'] = @get_cfg_var("max_execution_time") . "秒";
        $data['memoryLi'] = @get_cfg_var("memory_limit") ? get_cfg_var("memory_limit") : "无";
        $this->cismarty->assign('menuUrl', array('home', 'index'));
        $this->cismarty->assign("phpInfo", $data);
        $this->cismarty->assign("sessionname", $this->session->userdata('admin'));
        $this->cismarty->display($this->sysconfig_model->templates() . '/index.tpl');
        //$this->load->view('index',$data);
    }

    function server() {
        $data['title'] = "管理中心:";
        $this->load->view('server', $data);
    }

    function extractExcel() {
        $this->load->model('deptsys_model');
        $query = $this->deptsys_model->get_dept_temp("");
        // $query = $this->db->get("staff_dept");
        //  print_r($query);
        if (!$query)
            return false;

        // Starting the PHPExcel library
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");

        $objPHPExcel->setActiveSheetIndex(0);

        // Field names in the first row
        $fields = $this->db->list_fields('staff_dept');
        // $fields = array("pla_first_name","pla_last_name","pla_middle","pla_gender","pla_relation","pla_returning","pla_grade","pla_school","gua_first_name","gua_last_name","gua_email","gua_phone","gua_work_phone","gro_name","cla_name","cla_fee","pay_status");
        // $titles =array("player first name","player last name","Middle Initial","Gender","Relation to you","Returning Player","Grade","School","guardian first name","guardian last name","E-mail","Cell Phone","Home Phone","Group","Class","Fee","Pay status");
        // print_r($fields);
        $col = 0;
        foreach ($fields as $field) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
            $col++;
        }

        // Fetching the table data
        $row = 2;
        foreach ($query as $data) {
            $col = 0;
            // print_r($data);
            foreach ($fields as $field) {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
                $col++;
            }

            $row++;
        }

        $objPHPExcel->setActiveSheetIndex(0);

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');

        // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Player_' . date('dMy') . '.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter->save('php://output');
    }

}
