<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Welcome extends  CI_Controller {

    function __construct() {
        parent::__construct();
                        $this->authorization->check_auth();
		}

                function index()
                {
                    
                   // $this->load->view('home',$data);
                    redirect('home');
                        //echo $this->uri->segment(1);
                }
      

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */