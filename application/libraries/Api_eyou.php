<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * lizd11
 *

 */
class Api_eyou {

    var $auth_key = "api@semir.com";
    var $auth_secret = 'd919eaa118634ff9ecdcca8f34dadba5';
    var $host_name = 'https://mail.semir.com/';
    var $domain = 'semir.com';
    //
    var $_userpw = '67288599'; // 邮箱用户的默认密码
    var $_usersize = 2000; // 邮箱用户的默认容量

    //$post_data['auth_timestamp'] = time();
    //$post_data['auth_signature'] = md5("d919eaa118634ff9ecdcca8f34dadba5api@semir.com".time());  

    /**
     * Constructor - Sets Email Preferences
     *
     * The constructor can be passed an array of config values
     */
    public function __construct($config = array()) {
        $this->_auth_timestamp = time();
        $this->_auth_signature = md5($this->auth_secret . $this->auth_key . time());
    }

    // --------------------------------------------------------------------
    // --------------------------------------------------------------------

    /**
     * add user
     *
     * @access	public
     * @param	string
     * @param	string
     * @return	string
     */
    public function user_add($name, $cname) {
        $header = array();
        $header[] = "Authorization:simple auth_key=" . rawurlencode($this->auth_key) . ",auth_timestamp=" . $this->_auth_timestamp . ",auth_signature=" . $this->_auth_signature;
        $ch = curl_init();
		 curl_setopt($ch, CURLOPT_PORT, 443); //设置端口 
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查  
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在  
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_URL, $this->host_name . 'api/admin/domain/' . $this->domain . '/user');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->get_xml($name, $cname));
        $response = curl_exec($ch);
        // echo $this->get_xml($name);
        curl_close($ch);
        print_r($response);
    }

    public function user_edit($name, $key, $var = 0) {
        $header = array();
        $header[] = "Authorization:simple auth_key=" . rawurlencode($this->auth_key) . ",auth_timestamp=" . $this->_auth_timestamp . ",auth_signature=" . $this->_auth_signature;
        $ch = curl_init();
		    curl_setopt($ch, CURLOPT_PORT, 443); //设置端口 
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查  
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在  
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_URL, $this->host_name . 'api/admin/domain/' . $this->domain . '/user/' . $name);
		curl_setopt($ch, CURLOPT_PORT, 443); //设置端口 
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->get_xml_edit($name, $key, $var));
        $response = curl_exec($ch);
        //  print_r($response);
       // print_r($this->get_xml_edit($name, $key, $var));
        curl_close($ch);
        print_r($response);
		 
    }

    public function user_del($name) {
        $header = array();
        $header[] = "Authorization:simple auth_key=" . rawurlencode($this->auth_key) . ",auth_timestamp=" . $this->_auth_timestamp . ",auth_signature=" . $this->_auth_signature;
        $ch = curl_init();
		 curl_setopt($ch, CURLOPT_PORT, 443); //设置端口 
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查  
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在  
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_URL, $this->host_name . 'api/admin/domain/' . $this->domain . '/user/' . $name);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        $response = curl_exec($ch);
        // echo $this->get_xml($name);
        curl_close($ch);
        print_r($response);
    }

    // --------------------------------------------------------------------

    /**
     * Set Reply-to
     *
     * @access	public
     * @param	string
     * @param	string
     * @return	void
     */
    public function get_xml($name, $cname) {
        $add = "";
        $add.= "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
        $add.="<entry xmlns=\"http://www.w3.org/2005/Atom\" xmlns:eyou=\"" . $this->host_name . "/api\">";
        $add.="<title>" . $name . "</title>";
        $add.="<content>" . $cname . "</content>";
        $add.="<eyou:has_mailstatus_group>1</eyou:has_mailstatus_group>";
        $add.="<eyou:password>" . $this->_userpw . "</eyou:password>";
        $add.="<eyou:quota>" . $this->_usersize . "</eyou:quota>";
        $add.="</entry>";
        return $add;
    }

    public function get_xml_edit($name, $key, $var = 0) {
        $add = "";
        $add.= "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
        $add.="<entry xmlns=\"http://www.w3.org/2005/Atom\" xmlns:eyou=\"" . $this->host_name . "api\">";
        $add.="<title>" . $name . "</title>";
        if ($key == 'has_pop') {
            $add.="<eyou:has_pop>" . $var . "</eyou:has_pop>";
            $add.="<eyou:has_smtp>" . $var . "</eyou:has_smtp>";
        }
        if ($key == 'has_remote') {
            $add.="<eyou:has_remote>" . $var . "</eyou:has_remote>";
        }
        $add.="</entry>";
        return $add;
    }

    // --------------------------------------------------------------------
}

// END CI_Email class

/* End of file Email.php */
/* Location: ./system/libraries/Email.php */
