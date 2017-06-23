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
                            $ipstaff = $this->sms_model->staff_sms_by($where);
                            $ip_sms_oa = $this->sms_model->staff_sms_oa_row("sms_ip = '" . $temp['ipAddress'] . "'");
                            if ($ipstaff || $ip_sms_oa) {
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

   
    /* //////////////////////////////////
     *  OA 获取 资产编号
     * *///////////////////////////////////////

    function sms_number_check() {
        $jsonBack = $_REQUEST["jsoncallback"];
        //$cate_id = $this->input->post('cate');
        $type = $_REQUEST['type'];

        /// $itname = 'lizhendong';
        if ($type) {
            //  echo "1";
            $this->load->model('sms_model');
            $reNumber = $this->sms_model->sms_number_by("sms_status = 1 and sms_number like '" . $type . "%'"); //and sms_status = 1
            // print_r($reNumber);
            if ($reNumber) {
                echo $jsonBack . "([{'sms_number':'" . $reNumber->sms_number . "'}])"; ////////////////////out sms_number
                 
                      //update sms_number
                      $up['sms_status'] = 2;
                      $this->sms_model->sms_number_edit($reNumber->sms_number,$up);
                
                // echo $jsonBack . "([{'sms_number':'已无资产编号资源1'}])";
            } else {
                echo $jsonBack . "([{'sms_number':'已无资产编号资源'}])";
                // echo "已无资产编号资源";
            }
        } else {
            echo $jsonBack . "([{'sms_number':'请选择资产类别'}])";
            // echo "请选择资产类别";
        }
        //  print_r( $this->session->userdata('tNumber'));
    }

    /* //////////////////////////////////
     *  OA 批量获取 资产编号
     * *///////////////////////////////////////

    function sms_number_batch_check() {
        $jsonBack = $_REQUEST["jsoncallback"];
        //$cate_id = $this->input->post('cate');
        $type = $_REQUEST['type'];
        $total = $_REQUEST['total'];
        /// $itname = 'lizhendong';
        if ($type) {
         if ((int)$total <= 0 ){
             echo $jsonBack ."([{'sms_number':'请输入采购数量'}])";
         }else{
              $this->load->model('sms_model');
              $reNumber = $this->sms_model->sms_number_total($total,0,"sms_status = 1 and sms_number like '" . $type . "%'"); //and sms_status = 1
               $sms_number =array();
              if ($total > count($reNumber)){
                  echo $jsonBack . "([{'sms_number':'缺少资产编号资源'}])";
              }else{ 
                   foreach ($reNumber as $row) {
                      $sms_number[] = $row->sms_number;
                      //update sms_number
                      $up['sms_status'] = 2;
                      $this->sms_model->sms_number_edit($row->sms_number,$up);
                   }
                   //implode(',', $sms_number);
                  echo $jsonBack . "([{'sms_number':'". implode(',', $sms_number)."'}])";
              }
         }
               
        } else {
            echo $jsonBack . "([{'sms_number':'请选择资产归属 '}])";
            // echo "请选择资产类别";
        }
        //  print_r( $this->session->userdata('tNumber'));
    }

   function sendSMS(){
        $this->load->model('sms_model');
		$this->load->model('staff_model');
    	$oarequst= $this->sms_model->get_newstaff_oanumber();
    	if(!$oarequst && !($oarequst->oanumber)){
    		exit;
    	}
    	$oanumber = $oarequst->oanumber;
        $freshmen = $this->sms_model->get_newstaff_namelist($oanumber);
        foreach($freshmen as $fresh){
        	$phonenum = $fresh->sa_mobile;
        	$cname = $fresh->cname;
        	$itname = $fresh->reg_itname;
        	$defaultPasswd ="88888888";
			$where = array("itname "=>$itname);
	        $main_user = $this->staff_model->get_staff_by($where);
        	if($main_user){
        		$defaultPasswd = $main_user->password;
        	}
	    	//$msg = $cname.",您好!欢迎您即将加入森马大家庭！您的 OA、AD、DFS、邮件、钉钉均已建立，平台账号：{$itname}，初始默认密码：{$defaultPasswd}（首次进入系统后，请修改设置具有一定复杂性的密码，您对自己的账号在相应系统内的所有活动负责，该活动记录视为您本人签字）";
	    	$msg =  $cname.",您好:欢迎您加入森马大家庭！您在森马的应用系统帐号已开通(OA、AD、DFS、邮件),账号：{$itname}，初始随机密码：{$defaultPasswd} 请在首次登录系统后,修改密码(字符+数字组合)(您对自己的账号在相应系统内的所有活动负责，该活动记录视为您本人签字)";
			$mes = mb_convert_encoding($msg, "gbk", "UTF-8");
	    	$timeout = 5;
	    	$url = "http://smsapi.ums86.com:8888/sms/Api/Send.do";
	    	//$post_data = array("SpCode"=>"003031","LoginName"=>"WZ_SM_PI","Password"=>"SM9527","MessageContent"=> $mes ,"UserNumber"=>"18049987585","SerialNumber"=>"31345678901234567899","ScheduleTime"=>"","f"=>"1");
	    	$post_data = "SpCode=003031&LoginName=WZ_SM_PI&Password=SM9527&MessageContent=" . $mes . "&UserNumber=".$phonenum."&SerialNumber=31345678901234562311&ScheduleTime=&f=1";
	    
	    	//$contents = mb_convert_encoding($contents, "UTF-8", "gb2312");
	    	$useragent = "Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.56 Safari/537.17";
	    	//初始化
	    	$ch = curl_init();
	    	//设置抓取的url
	    	$header = array(
	    			"content-type: application/x-www-form-urlencoded; charset=gb2312"
	    	);
	    	curl_setopt($ch, CURLOPT_URL, $url);
	    	//设置头文件的信息作为数据流输出
	    	//curl_setopt($ch, CURLOPT_URL, "https://oapi.dingtalk.com/" . $url . "?access_token=" . $aToken);
	    	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    	curl_setopt($ch, CURLOPT_SSLVERSION, 3);
	    	curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
	    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
	    	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	    	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	    	curl_setopt($ch, CURLOPT_POST, true);
	    	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	    	$file_contents = curl_exec($ch);
	    	//  print_r($ch);
	    	curl_close($ch);
    }
    $data['oanumber'] = $oanumber;
    $data['sendstatus'] = 2;
    $this->sms_model->update_newstaff_sms($data);
    	//  print_r($file_contents);
    }
    /////////////////////////
}
