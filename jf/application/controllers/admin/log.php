<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Log extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('log_model');
        $this->sysconfig_model->sysInfo();
    }

    function index() {
     
        if ($this->authorization->check_log()) {
           // $this->cismarty->display('admin/index.tpl');
             redirect(site_url('admin/item'));//admin/homepage
        } else {
            $this->cismarty->display('admin/login.tpl');
        }
    }

    function login() {
       
        $data['username'] = $this->input->post('username');
        $data['userpass'] = md5($this->input->post('userpass'));
     //   $this->load->library('authcode');
          if ($this->log_model->login($data)) {
                redirect(site_url('admin/item')); //admin/home
                // $this->cismarty->display( $this->sysconfig_model->templates().'/admin/index.tpl');
            } else {
                
                $this->index();
            }
        /** 
        if ($this->authcode->check($this->input->post('authcode_input'))) {
            if ($this->log_model->login($data)) {
                redirect(site_url('admin/home'));
                // $this->cismarty->display( $this->sysconfig_model->templates().'/admin/index.tpl');
            } else {
                $this->index();
            }
        } else {
            $this->session->set_flashdata('msg', '验证码错误。');

            $data['msg'] = '验证码错误';
            $this->cismarty->display('admin/login.tpl');
            //$this->load->view('admin/login',$data);
        }
         * 
         */
    }

    function logout() {
        $this->session->sess_destroy();

        redirect(site_url('admin/log'));
    }

}