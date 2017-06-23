<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Logsm extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('Form_validation');
        $this->load->library('session');
        $this->load->library('DX_Auth');
        $this->load->model('dx_auth/users', 'users');
        $this->sysconfig_model->sysInfo();
    }

    function index() {
        // echo ;
        if ($this->session->userdata('logined')) {
              redirect(site_url('public/sms_out'));
        } else {
            $this->cismarty->display($this->sysconfig_model->templates() . '/login_sm.tpl');
        }
    }

    function login() {

        if ($this->session->userdata('logined')) {
             redirect(site_url('public/sms_out'));
        } else {
            $val = $this->form_validation;
            $val->set_rules('username', 'Username', 'trim|required|xss_clean');
            $val->set_rules('password', 'Password', 'trim|required|xss_clean');
            if ($this->form_validation->run() == FALSE) {
                $this->cismarty->display($this->sysconfig_model->templates() . '/login_sm.tpl');
            } else {
                if ($this->input->post('submit')) {


                    $username = $this->input->post('username');
                    $pass = $this->dx_auth->_encode($this->input->post('password'));

                    $result = $this->users->get_user_by_username($username);
                    $userinfo = $result->row();
                    $stored_hash = $userinfo->password;
                    if (crypt($pass, $stored_hash) === $stored_hash) {
                        $array_items = array('username' => $username, 'logined' => TRUE);
                        $this->session->set_userdata($array_items); 
                        redirect(site_url('public/sms_out'));
                    } else {
                        echo 'Error!';
                    }
                } else {
                    echo 'Error!';
                }
            }
        }
    }

    function logout() {
        $this->dx_auth->logout();
        $data['auth_message'] = 'You have been logged out.';
//$this->load->view($this->dx_auth->logout_view, $data);
//  echo "111";
        redirect(site_url('logsm'));
    }

}
