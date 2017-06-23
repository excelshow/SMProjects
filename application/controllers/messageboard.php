<?php
class Messageboard extends Controller{
		var $q = "";
		var $v = "-1";
		var $mode = "normal";
		function __construct(){
			parent::Controller();
			$this->authorization->check_auth();
			 
		}
		
		function index(){
			$this->view();
		}
 
		function pagination($condition=""){
			$this->load->library('pagination');
			$config['base_url'] = site_url('messageboard/view')."?q=$this->q&v=$this->v&mode=$this->mode";
			$config['total_rows'] = $this->db->count_all_results('message_board');
			$config['per_page'] = '50';
			$config['uri_segment'] = 3;
			$this->pagination->initialize($config);
			return $this->pagination->create_links();
		}
		
		
		function view(){
			$this->authorization->check_permission($this->uri->segment(2),'1');
			$data['title'] = "管理中心:京乌江化工有限公司" ;
			$data['copyright'] = "京乌江化工有限公司";
			$data['link'] = "http://www.njwjhg.com/";
			$where = "info.is_del = 0 ";
                        
			parse_str($_SERVER['QUERY_STRING'], $_GET);
			if(isset($_GET['mode']))
				$this->mode = $_GET['mode'];
			if(isset($_GET['q']))
				$this->q = $_GET['q'];
			if(isset($_GET['v']))
				$this->v = $_GET['v'];
			//if($this->mode!="normal")
				 
			
			$this->db->select('*');
			 
				$this->db->limit(50, $this->uri->segment(3,0));
			 $this->db->order_by("id",'desc');
		 
			$this->db->from('message_board');
		 
			$query = $this->db->get();
			 
			$data['mblist'] =$query->result();;
			$data['links'] = $this->pagination();
			$data['action'] = "view";

			$data['q'] = $this->q;
			$data['v'] = $this->v;
			$data['mode'] = $this->mode;
			$this->load->view('messageboard_layout',$data);
		}
		
	   
		 
		
		function del(){
			$this->authorization->check_permission($this->uri->segment(2),'4');
			if($info_id = $this->input->post('info_id')){
				$data['info_id'] = $info_id;
				if($msg = $this->info_model->del($data)){
					echo $msg;
				}else{
					echo "删除操作失败,原因可能是当前记录不存在！";
				}
			}
		}
		
 
	}