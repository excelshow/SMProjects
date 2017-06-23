<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Log extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('Form_validation');
        $this->load->model('log_model');
        $this->load->library('DX_Auth');
        $this->load->model('dx_auth/users', 'users');
        $this->sysconfig_model->sysInfo();
    }

    function index() {
        if ($this->dx_auth->is_logged_in()) {
            $this->cismarty->display($this->sysconfig_model->templates() . '/login.tpl');
        } else {
            redirect('home');
        }
    }

    function login() {

        if (!$this->dx_auth->is_logged_in()) {
            $val = $this->form_validation;
//	 $data['username'] = $this->input->post('username');
// $data['userpass'] = md5($this->input->post('userpass'));
// Set form validation rules
            $val->set_rules('username', 'Username', 'trim|required|xss_clean');
            $val->set_rules('password', 'Password', 'trim|required|xss_clean');
            $val->set_rules('remember', 'Remember me', 'integer');

// Set captcha rules if login attempts exceed max attempts in config
            if ($this->dx_auth->is_max_login_attempts_exceeded()) {
                $val->set_rules('captcha', 'Confirmation Code', 'trim|required|xss_clean|callback_captcha_check');
            }

            if ($val->run() AND $this->dx_auth->login($val->set_value('username'), $val->set_value('password'), $val->set_value('remember'))) {
// Redirect to homepage
                redirect('', 'location');
            } else {
// Check if the user is failed logged in because user is banned user or not
                if ($this->dx_auth->is_banned()) {
// Redirect to banned uri
                    $this->dx_auth->deny_access('banned');
                } else {
// Default is we don't show captcha until max login attempts eceeded
                    $data['show_captcha'] = FALSE;

// Show captcha if login attempts exceed max attempts in config
                    if ($this->dx_auth->is_max_login_attempts_exceeded()) {
// Create catpcha						
                        $this->dx_auth->captcha();

// Set view data to show captcha on view file
                        $data['show_captcha'] = TRUE;
                    }

// Load login page view
                    redirect(site_url('home'));
                }
            }
        } else {
            echo '////';
//  redirect(site_url('home'));
        }
    }
      
    function changepw() {
        if ($this->dx_auth->is_logged_in()) {
// print_r($this->session);
            $this->load->library('DX_Auth');
            $id = $this->session->userdata('DX_user_id');
            if ($id) {
                $userinfo = $this->users->get_user_by_id($id);
                //print_r($userinfo);
                $this->cismarty->assign("user", $userinfo);
                $this->cismarty->display($this->sysconfig_model->templates() . '/public/userpw.tpl');
            } else {
                echo "Error!";
            }
        }
    }

    function changepw_save() {

        $id = $this->input->post('uid');
        $password = $this->input->post('npass');
        $date['password'] = crypt($this->dx_auth->_encode($password));
        if ($this->users->set_user($id, $date)) {
            echo 'ok';
        }
    }

    function logout() {
        $this->dx_auth->logout();
        $data['auth_message'] = 'You have been logged out.';
//$this->load->view($this->dx_auth->logout_view, $data);
//  echo "111";
        redirect(site_url(''));
    }

}
