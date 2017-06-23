<?php
class Down extends Controller {
    var $q = "";
		var $v = "-1";
		var $mode = "normal";
	function __construct(){
			parent::Controller();
                        $this->load->helper('date');
                        $this->load->helper('array');
                        $this->load->library('pagination');
                        $this->load->model('downgallery_model');
                        $this->authorization->check_layout_auth();
		}

	function index()
	{
               $this->downlist();
		//echo $this->uri->segment(1);
	}

        function pagination($condition=""){
			$this->load->library('pagination');
			$config['base_url'] = site_url('down/downlist');
			$config['total_rows'] = $this->downgallery_model->get_num_rows($condition);
			$config['per_page'] = '20';
			$config['uri_segment'] = 2;
			$this->pagination->initialize($config);
			return $this->pagination->create_links();
		}

        function downlist()
	{           
                       // $this->authorization->check_permission($this->uri->segment(1),'1');
			$data['title'] = "下载中心:森马设计图下载系统" ;
			$data['copyright'] = "Semir";
			$data['link'] = "http://www.semir.com";
			
			parse_str($_SERVER['QUERY_STRING'], $_GET);
                       

                        $where = "downgallery.start_time < '".date('Y-m-d')."' and '".date('Y-m-d')."' < downgallery.end_time";
                       // $where = $where.' and1 '.$this->session->userdata('mid').' IN (downgallery.mid)';
                        $where = $where. " AND FIND_IN_SET(".$this->session->userdata('mid').", mid)";
                        $data['downgallerynew'] = $this->downgallery_model->get_downgallerys(10,0,$where);
			$data['downgallerys'] = $this->downgallery_model->get_downgallerys(20,$this->uri->segment(2,0),$where);
			$data['links'] = $this->pagination($where);
                        $this->load->model('mill_model');
                        $data['mill'] = $this->mill_model->get_mill_byid($this->session->userdata('mid'));
                        $this->load->library('pagination');
			 
                         $this->load->view('down',$data);
		//echo $this->uri->segment(1);
	}
       function downdetail()
	{
                       // $this->authorization->check_permission($this->uri->segment(1),'1');
			$data['title'] = "下载中心:森马设计图下载系统" ;
			$data['copyright'] = "Semir";
			$data['link'] = "http://www.semir.com";
                        $id = $this->uri->segment(3);
                        $where = "downgallery.start_time < '".date('Y-m-d')."' and '".date('Y-m-d')."' < downgallery.end_time";
                       // $where = $where.' and1 '.$this->session->userdata('mid').' IN (downgallery.mid)';
                        $where = $where. " AND FIND_IN_SET(".$this->session->userdata('mid').", mid)";
                         $data['downgallerynew'] = $this->downgallery_model->get_downgallerys(10,0,$where);
                        $where = $where. " AND downgallery_id = ". $id = $this->uri->segment(3);
                       
			$data['downgallerys'] = $this->downgallery_model->get_downgallerys(0,0,$where);
                        $this->load->model('mill_model');
                        $data['mill'] = $this->mill_model->get_mill_byid($this->session->userdata('mid'));
                        $this->load->model('gallery_model');
			$data['links'] = $this->pagination($where);

                        $this->load->library('pagination');

                         $this->load->view('downdetail',$data);
		//echo $this->uri->segment(1);
	}
	  function download()
	{
                       // $this->authorization->check_permission($this->uri->segment(1),'1');
			$data['title'] = "下载中心:森马设计图下载系统" ;
			$data['copyright'] = "Semir";
			$data['link'] = "http://www.semir.com";
                        $id = $this->uri->segment(3);
                        $where = "downgallery.start_time < '".date('Y-m-d')."' and '".date('Y-m-d')."' < downgallery.end_time";
                       // $where = $where.' and1 '.$this->session->userdata('mid').' IN (downgallery.mid)';
                        $where = $where. " AND FIND_IN_SET(".$this->session->userdata('mid').", mid)";
                         $data['downgallerynew'] = $this->downgallery_model->get_downgallerys(10,0,$where);
                        $where = $where. " AND downgallery_id = ". $id = $this->uri->segment(3);
			$data['downgallerys'] = $this->downgallery_model->get_downgallerys(0,0,$where);
                        $this->load->model('mill_model');
                        $data['mill'] = $this->mill_model->get_mill_byid($this->session->userdata('mid'));
                        $this->load->model('gallery_model');
			$data['links'] = $this->pagination($where);
                        $this->load->library('pagination');
                        $this->load->helper('download');
                        $data['fid'] = $this->uri->segment(4);
                        
                        $this->load->view('download',$data);
		//echo $this->uri->segment(1);
	}

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */