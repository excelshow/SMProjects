<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// Api 2013 5 22 
class Ims_client extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('xmlrpc');
    }

    function index() {
        $this->cismarty->display($this->sysconfig_model->templates() . '/ims_api/guide.tpl');
    }
///////////////// 用户登录 /////////////////////////////////////////////////////////////////////////
    function userLogin() {
        $server_url = site_url('xmlrpc_api/ims_server/userLogin'); // API server url
        //  echo $server_url;
        //  print_r($server_url); // return val
        // exit();
        $this->xmlrpc->server($server_url, 80); // server port
        $this->xmlrpc->method('Greetings'); // method type
        // $key =  trim($this->uri->segment(4));
        //$this->xmlrpc->set_debug(true);
        $itname = trim($_POST["itname"]); //trim('lizhendong'); //$_POST["itname"]
       $password = trim($_POST["password"]);
        // echo $key;
        // print_r($_POST);
        $data = array($itname, $password); // parameter , only arrar
        if ($data) {
            //print_r($request);
            $this->xmlrpc->request($data);

            if (!$this->xmlrpc->send_request()) {
                //   print_r($this->xmlrpc->display_response());
               // echo $this->xmlrpc->display_error(); // error message
                echo "无记录！"; //无记录！
            } else {
                $result = $this->xmlrpc->display_response();
                //  print_r($this->xmlrpc->display_response());
                echo implode('/', $result);
                // return $result;
                // print_r(json_encode($result)); //json_encode(
            }
        } else {
            echo "非法参数！"; //=参数不能为空！
        }
    }
///////////////// 用户状态查询 TEST/////////////////////////////////////////////////////////////////////////
    function userseach() {
        $server_url = site_url('xmlrpc_api/ims_server/userseach'); // API server url
        //  echo $server_url;
        //  print_r($server_url); // return val
        // exit();
        $this->xmlrpc->server($server_url, 80); // server port
        $this->xmlrpc->method('Greetings'); // method type
        // $key =  trim($this->uri->segment(4));
        //$this->xmlrpc->set_debug(true);
        $key = trim($_POST["itname"]); //trim('lizhendong'); //$_POST["itname"]
        // echo $key;
        // print_r($_POST);
        if ($key) {
            $request = array($key, 'string'); // parameter , only arrar
            //print_r($request);
            $this->xmlrpc->request($request);

            if (!$this->xmlrpc->send_request()) {
                //   print_r($this->xmlrpc->display_response());
               // echo $this->xmlrpc->display_error(); // error message
                echo "无记录！"; //无记录！
            } else {
                $result = $this->xmlrpc->display_response();
                //  print_r($this->xmlrpc->display_response());
                echo implode('/', $result);
                // return $result;
                // print_r(json_encode($result)); //json_encode(
            }
        } else {
            echo "非法参数！"; //=参数不能为空！
        }
    }

///////////////// 用户更新查询 TEST/////////////////////////////////////////////////////////////////////////
    function loaduser() {
        $server_url = site_url('xmlrpc_api/ims_server/load_user'); // API server url
        $this->xmlrpc->server($server_url, 80); // server port
        $this->xmlrpc->method('Greetings'); // method type
        $request = array('lizhendong', 'string'); // parameter , only arrar
        $this->xmlrpc->request($request);
        if (!$this->xmlrpc->send_request()) {
           //   print_r($this->xmlrpc->display_response());
           //  echo $this->xmlrpc->display_error(); // error message
            echo "0"; //=无记录！
        } else {
            $result = $this->xmlrpc->display_response();
            //   print_r($this->xmlrpc->display_response());
            echo implode('/', $result);
            // return $result;
            // print_r(json_encode($result)); //json_encode(
        }
    }

    function netApiTest() {
        header("content-type:text/html;charset=utf-8");
        $this->load->library('Nusoap');
        // 要访问的webservice路径
        $NusoapWSDL = "http://10.90.18.75:8012/Pages/webservice/WSuserrights.asmx?WSDL"; /// http://ums.zj165.com:8888/sms_hb/services/Sms?wsdl"; //http://10.90.18.75:8016/Pages/webservice/WSuserrights.asmx?WSDL
        //$NusoapWSDL = "http://ums.zj165.com:8888/sms_hb/services/Sms?wsdl";
        $nusoap_client = new SoapClient($NusoapWSDL);
        $nusoap_client->soap_defencoding = 'utf-8';
        $nusoap_client->decode_utf8 = false;
        $nusoap_client->xml_encoding = 'utf-8';
        echo '<pre>';
        print_r($nusoap_client->__getFunctions()); // 获取webservice提供的函数
        echo '</pre>';
        // echo "begin remote 。。。<br>";
        // 调用远程方法
        // $result = $client->call('Sms', array($param))
        //  $param = array('strname' => "", 'strtext' => '', 'strmemo' => '');
        //  $result = $nusoap_client->userupdate($param);
        //  print_r($result); 
        //echo "end remote 。。。<br>";
        //////////////////////////////////////////////////////////// Update API
      

        //////////////////////////////////////////////////////////// Update API
        echo "<br>GetUserUpdate API:<br>";

        $result2 = $nusoap_client->GetUserUpdate();
        print_r($result2);

        //////////////////////////////////////////////////////////// Update API
        echo "<br>Truncate API:<br>";

        //   $result3 = $nusoap_client->Truncate();
        //  print_r($result3);
        //echo "end remote ...br>";

        $this->cismarty->display($this->sysconfig_model->templates() . '/ims_api/guide.tpl');
    }

}