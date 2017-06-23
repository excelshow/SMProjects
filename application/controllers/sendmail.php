<?php
class Sendmail extends Controller {
    function __construct() {
        parent::Controller();
      $this->load->helper('email');   
	  
    }

    function sendMailContact(){
		
 
		// save data
		//print_r($_POST);
		//exit();
		$data['name'] = $this->input->post('sendname');
        $data['tel'] = $this->input->post('sendtel');
        $data['email'] = $this->input->post('sendemailad');
        $data['message'] = $this->input->post('sendmessage');
		$data['datetime'] =date("Y-m-d H:i:s"); 
	 	$this->db->insert('message_board', $data);
		
		// send email start
	//	$this->email->from('lizd11@163.com', 'vins-selection');
	//	$this->email->to('andy@yampotech.com,t.geffre@vins-selection.com.cn');  //vins-selection@vins-selection.com.cn
		//$this->email->cc('lizd11@163.com'); 
		//$this->email->bcc('them@their-example.com'); 
		
	//	$this->email->subject('Message from Website ');
		$mailCon = "姓名:\n".$_POST['sendname']."\n\n";
		$mailCon .= "电话:\n".$_POST['sendtel']."\n\n";
		$mailCon .= "E-mail:\n".$_POST['sendemailad']."\n\n";
		$mailCon .= "留言信息:\n".$_POST['sendmessage']."\n\n";
		$mailCon .= "这是来自网站的客户留言信息，你可以登录网站管理后台查看详细信息！\n\n";
	//	$this->email->message($mailCon); 
	//	$this->email->send();
	// send_email('peter@njwjhg.com', 'Message from Website', $mailCon);
	  send_email('peter@njwjhg.com', '网站留言', $mailCon);
		echo "ok"; 
		//echo $this->email->print_debugger();

		} 
}