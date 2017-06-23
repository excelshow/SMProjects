<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Apioa extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('string');
        //$this->load->library('DX_Auth');
        // $this->dx_auth->check_uri_permissions();
        $this->sysconfig_model->sysInfo(); // set sysInfo
        $model = $this->load->model("deptsys_model");
        $this->load->library('session');
        $this->cismarty->assign("urlF", $this->uri->segment(2));
        $this->cismarty->assign("urlS", $this->uri->segment(3));
    }

    function ipcheck() {
        //获取编号
        //echo ."([{"name":"test","_regionId":134}])";
        //print_r($temp);
        // $aa = array('itname' => "lizhendong");
        //$temp = $this->input->get("jsoncallback");
        //$itname = $this->input->get('itname');
        // $bb = json_encode($aa);
        //  echo $temp."([{'ip':'".$itname."'}])";
        $temp = $_REQUEST["jsoncallback"];
        $itname = $_REQUEST['itname'];
        // echo $temp;
        // echo $itname;
        //   exit();
        if ($itname) {
            $this->load->model('staff_model');
            $staff = $this->staff_model->get_staff_by("itname ='" . $itname . "'");
            // print_r($staff);
            if ($staff) {
                $tt['temp'] = $temp;
                $tt['rootid'] = $staff->rootid;
                $tempIp = $this->loadDeptIp($tt);
                //  print_r($temp . "([{'ip':'" . $this->loadDeptIp($staff->rootid) . "'}])");
            } else {
                echo $temp . "([{'ip':'0.0.0.0'}])";
            }
        } else {
            echo $temp . "([{'ip':'0.0.0.0'}])";
            //echo "0.0.0.0";
        }
    }

    function loadDeptIp($tt) {

        $deptRow = $this->deptsys_model->get_dept_val("id = " . $tt["rootid"]);

        // exit();
        if ($deptRow) {
            if ($deptRow->ipAddress == '0') {
                $tt["rootid"] = $deptRow->root;
                $this->loadDeptIp($tt);
                // echo "0.0.0.0";
            } else {

                $ipArr = explode(',', $deptRow->ipAddress);
                $iplist = array();
                for ($ii = 0; $ii < count($ipArr); $ii++) {
                    if ($ipArr[$ii]) {
                        $ipTemp = $ipArr[$ii];
                        $ipNum = count(explode('.', $ipTemp));
                        for ($i = 1; $i <= 240; $i++) {
                            $temp['ipAddress'] = $ipTemp . "." . $i;
                            $where = "staff_sms.sm_status = 1 and staff_sms.sms_ip = '" . $temp['ipAddress'] . "'";
                            $this->load->model('sms_model');
                            if ($this->sms_model->staff_sms_by($where)) {
                                //  echo "0.0.0.0";
                            } else {
                                $tip = $this->session->userdata('tempip');
                                //  print_r($tip);
                                if ($tip) {
                                    if (in_array($temp['ipAddress'], $tip)) {
                                        // echo "eded";
                                        continue;
                                    } else {
                                        echo $tt["temp"] . "([{'ip':'" . $temp['ipAddress'] . "'}])"; ////////////////////out Ip
                                        $tip[] = $temp['ipAddress'];
                                        $tempIp['tempip'] = $tip;
                                        $this->session->set_userdata($tempIp);
                                        break;
                                    }
                                } else {
                                    echo $tt["temp"] . "([{'ip':'" . $temp['ipAddress'] . "'}])"; ////////////////////out Ip
                                    $tip[] = $temp['ipAddress'];
                                    $tempIp['tempip'] = $tip;
                                    $this->session->set_userdata($tempIp);
                                    break;
                                }
                            }
                        }
                    }
                }
            }
        }
    }

//////////////////////////
    function sms_number_check() {
        $cate_id = $this->input->post('cate');
        $type = $this->input->post('type');
        // echo $cate_id.$type;
        /// $itname = 'lizhendong';
        if ($type && $cate_id) {
            //  echo "1";
            $this->load->model('sms_model');
            $smsFirst = $this->sms_model->sms_oa_caigou_by("sms_number like '" . $type . "%'");
            if ($smsFirst) {
                // $temp =increment_string($smsFirst->sms_number,'',6);
                $temp = @substr($smsFirst->sms_number, 1);
                $tempNumber = sprintf('%06s', $temp + 1);
                //  echo "2";
                // $trueNumber = 
            } else {
                // echo "3";
                $smsFf = $this->sms_model->sms_main_by("sms_number like '" . $type . "%'");
                //  $temp =increment_string($smsFf->sms_number,'',6);
                $temp = @substr($smsFf->sms_number, 1);
                $tempNumber = @sprintf('%06s', $temp + 1);
            }
            // 插入到表sms_oa_caigou
            echo $type . $tempNumber;
            $data['sms_number'] = $type . $tempNumber;
            $data['scg_type'] = 1;
            $this->sms_model->sms_oa_caigou_add($data);
        } else {
            echo "请选择资产类别";
        }
    }

    /////////////////////////
    function up_sms_lizhi() {
        ////   //  header("Content-Type:text/html;charset=utf-8"); 
        include("/application/controllers/public/FromOA.class.php");

        ini_set("soap.wsdl_cache_enabled", "0"); ////测试时打开防止soap缓存
        $server = new \SoapServer('./WSDL/UpLizhiFromOA.wsdl', array('soap_version' => SOAP_1_1)); ##此处的Service.wsdl文件是上面生成的, array('soap_version' => SOAP_1_2) , array('soap_version' => SOAP_1_2)
        $server->setClass('FromOA'); //注册Service类的所有方法   
        $server->handle(); //处理请求  
    }


    /**
      +----------------------------------------------------------
     * 功能：  testing 
      +----------------------------------------------------------
     */
    function soaptest() {
        

        header("Content-Type:text/html;charset=utf-8");

        /////////////////////////////////////////////////////////
        //testing  soap
        /////////////////////
        $soapURL = "./WSDL/UpLizhiFromOA.wsdl"; //"http://localhost:8082/MI_OA2SAP_Psc_Send.wsdl"; //
        //  $soapParameters = Array('login' => "piappluser", 'password' => "vfr45tgb");
        // $soapParameters = Array('login' => "zhangtingt", 'password' => "900123456");
        //  vendor('nusoap.nusoap');
        // import('Vendor.nusoap.nusoap');
        $soap = new \SoapClient($soapURL); //nusoap_client
        // print_r($soap);
        print_r($soap->__getFunctions());

        $params = array('oa_number' => 'lz201704260003', 'oa_status' => 1);
        //  print_r($soap->Up400Do($params));
        // $array = $soap->__soapCall('UpLizhiDo', $params);
        $array = $soap->UpLizhiDo($params);
//print_r(get_object_vars($array));
        var_dump($array);
        exit;
        //print_r($soapClient);
        //////
    }

}
