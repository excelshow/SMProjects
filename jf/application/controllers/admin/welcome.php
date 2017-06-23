<?php

class Welcome extends Controller {

	function __construct(){
			parent::Controller();
                        $this->authorization->check_auth();
		}

                function index()
                {
                    
                   // $this->load->view('admin/home',$data);
                    redirect('admin/home');
                        //echo $this->uri->segment(1);
                }
      

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */