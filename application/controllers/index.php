<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Index extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->sysconfig_model->sysInfo(); // set sysInfo
        $this->load->library('DX_Auth');
    }

    function index() {
        // redirect('log');
//        $arr = array(1 => 'zhang', 2 => 'xing', 3 => 'wang');
        //      $this->cismarty->assign("myarray", $arr);
        // $this->cismarty->display( $this->sysconfig_model->templates().'/index.tpl');
        if ($this->dx_auth->is_logged_in()) {
          
            redirect('home'); 
        }else{
          
            $this->cismarty->display($this->sysconfig_model->templates() . '/login.tpl');
        }
    }

}
