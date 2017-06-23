<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->authorization->check_auth();
        $this->sysconfig_model->sysInfo(); // set sysInfo
         $this->sysconfig_model->menu_all(); // set sysInfo
    }

    function index() {
        $data = "";
        $data['z_v'] = zend_version();
        $data['mysqlC'] = function_exists('mysql_close') ? "Yes" : "No";
        $data['mysqlG'] = @get_cfg_var("mysql.allow_persistent") ? "Yes" : "No";
        $data['mysqlB'] = @get_cfg_var("mysql.max_links") == -1 ? "Unlimited" : @get_cfg_var("mysql.max_links");
        $data['uploadB'] = @get_cfg_var("upload_max_filesize") ? get_cfg_var("upload_max_filesize") : "Not to upload attachments";
        $data['exTime'] = @get_cfg_var("max_execution_time") . "Seconds";
        $data['memoryLi'] = @get_cfg_var("memory_limit")?get_cfg_var("memory_limit"):"Null";
        $this->cismarty->assign("phpInfo", $data);
        $this->cismarty->assign("sessionname", $this->session->userdata('admin'));
        $this->cismarty->display('admin/index.tpl');
        //$this->load->view('admin/index',$data);
    }

    

}