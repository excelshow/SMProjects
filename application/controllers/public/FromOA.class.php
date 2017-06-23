<?php

//use Service\Common\CheckUserController;
class FromOA extends CI_Controller {

    public function UpLizhiDo($data) {
        //这里可以加些验证规则，实现一些特殊目的。如安全方面的。 
        header("Content-Type:text/html;charset=utf-8");
//         $ch = curl_init();
//         $timeout = 500;
//         $header = array(
//             'Content-Type: application/json',
//         );

        //  $result = json_encode($result); 
//         curl_setopt($ch, CURLOPT_URL, "http://10.90.18.23/index.php/staff/staff/up_sms_lizhi_do");
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//         curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
//         curl_setopt($ch, CURLOPT_HEADER, 0);
//         curl_setopt($ch, CURLOPT_POST, 1);
//         curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

//         $output = curl_exec($ch);
		$output =  $this->up_sms_lizhi_do($data);
        if ($output === FALSE) {
            $MESS_FLAG = 'F1';
            $MESSAGE = "API Error: " . curl_error($ch); // . curl_error($ch);
        } else {
            $reVal = json_decode($output);
            if ($reVal) {
                if ($reVal['val'] == 1) {
                    $MESS_FLAG = 'T';
                    //$MESSAGE = $reVal->msg;
                } else {
                    $MESS_FLAG = 'F2';
                }
            } else {
                $MESS_FLAG = 'F4';
            }
//             $MESS_FLAG = 'T';
            $MESSAGE = "成功！";
        }
        curl_close($ch);
        //   return  $data; //$data->AGENT_CODE,$data->LOAN_AMOUNT
        $result = array('MESS_FLAG' => $MESS_FLAG, 'MESSAGE' => $MESSAGE);
        // $result = json_encode($result);

        return $result;
    }
    
    function up_sms_lizhi_do($data) {
    	header("Content-Type:text/html;charset=utf-8");
    	//  $data = $this->input->post();
    	$res['val'] = 1;
    	$oa_number = $data->oa_number;
    	$updata['oa_status'] = $data->oa_status;
    	$this->load->model('sms_model');
    	$this->sms_model->sms_lizhi_edit($oa_number, $updata); //保存to lizhi
    	$row = $this->sms_model->sms_lizhi_row("oa_number = '" . $oa_number . "'");
    	$itname = $row->itname;
    	if (!$itname) {
    		exit;
    	}
    	//get sms list
    	$dataSms = $this->dimission_sms_get($itname);
    	// 借用资产处理
    	$jieyong = $dataSms["jieyong"];
    	$jp = array();
    
    	foreach ($jieyong as $row) {
    		$this->load->model('sms_parts_model');
    		//更新资产状态
    		$upj['sj_status'] = 1;
    		$this->sms_parts_model->sms_jieyong_edit_oa($row->sj_number, $upj);
    		//更新使用流水
    		$upsj['ssj_status'] = 2;
    		$this->sms_parts_model->staff_sms_jieyong_edit("sj_number = '" . $row->sj_number . "' and itname = '" . $itname, $upsj);
    	}
    	// 领用资产处理
    	$sms = $dataSms["data"];
    	$lp = array();
    	$upTc = '';
    	foreach ($sms as $rowa) {
    		$upTc['oa_number'] = $oa_number;
    		$upTc['st_itname'] = $itname;
    		$upTc['sms_number'] = $rowa->sms_number;
    		$this->sms_model->staff_sms_oa_return_add($upTc);
    	}
//     	print_r($res);
    	echo json_encode($res);
    }
	
	 function dimission_sms_get($itname) {
        //判断是否有资产
        $this->load->model('sms_model');
        $sms = $this->sms_model->staff_sms_list_search(0, 0, "itname = '" . $itname . "' and sm_status = 1");
        if ($sms) {
            foreach ($sms as $row) {
                //load sms category  /////////////////////// 
                $category = $this->sms_model->sms_category_by("sc_id =" . $row->sc_root);
                $row->category_name = $category->sc_name;
                //load sms category  /////////////////////// 
                if ($row->sms_brand == 0) {
                    $row->sms_brand = "无";
                } else {
                    $brand = $this->sms_model->sms_brand_by("sb_id =" . $row->sms_brand);
                    $row->sms_brand = $brand->sb_name;
                }
            }
        }
        $this->load->model('sms_parts_model');
        $jieyong = $this->sms_parts_model->staff_sms_jieyong_result(0, 0, "itname = '" . $itname . "' and ssj_status = 1");
        foreach ($jieyong as $row) {
            // load part 
            $rowt = $this->sms_parts_model->sms_jieyong_row("sj_number = '" . $row->sj_number . "'");
            if ($rowt) {
                $row->jieyong = $rowt->sj_name;
            } else {
                $row->jieyong = "已无名称";
            }
        }
        // print_r($jieyong);
        $data["jieyong"] = $jieyong;
        $data["data"] = $sms;
        return $data;
    }
}
