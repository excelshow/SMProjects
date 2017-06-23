<?php

	class Loginlayout extends Controller{
		
		function __construct(){
			parent::Controller();
			 
		}
		
		function index(){
                    //$this->session->sess_destroy();
			//redirect(site_url('/'));

			redirect(site_url('index'));
		 
			$data['title'] = 'VS :: ';
			$this->load->view('login',$data);
		}
		
		function login(){
                   // echo 'sdf';
                    //die();
			$data['username'] = $this->input->post('username');
			$data['userpass'] = md5($this->input->post('userpass'));
			$this->load->library('authcode');
			if ($this->authcode->check($this->input->post('authcode_input')))
			{
				if($this->login_model->login($data))
				{
					redirect(site_url(''));
				}else{
					$this->index();
				}
			} 
			else 
			{
				$this->session->set_flashdata('msg','验证码错误。');
				$data['title'] = '用户登录';
				$data['msg'] = '验证码错误';
				$this->load->view('login',$data);
			}	
			
                         
		}
		
		function logout(){
			$this->session->sess_destroy();
			redirect(site_url(''));
		}
		
	}