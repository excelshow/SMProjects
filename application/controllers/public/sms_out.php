<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// 资产管理模块 lzd 20130108
class Sms_out extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('email');
        $this->load->model('sms_model');
        $this->load->model("deptsys_model");
        $this->load->model('staff_model');
        $this->sysconfig_model->sysInfo(); // set sysInfo
    }

    //////////////////////
    function index() {
        if (!$this->session->userdata('logined')) {
            $this->cismarty->display($this->sysconfig_model->templates() . '/login_sm.tpl');
            exit();
        } else {

            $op_user = $this->session->userdata('username');

            $data['staff_sms'] = $this->sms_model->itname_chuku("status = 1 and (sms_number_4 <> '' or sms_number_8 <> '' or sms_number_19 <> '' or sms_number_11 <> '' or sms_number_39 <> '') ");
            //  print_r($data['staff_sms']);
            if ($data['staff_sms']) {
                foreach ($data['staff_sms'] as $row) {
                    $itname = $row->reg_itname;
                    $result = $this->staff_model->get_staff_by("itname = '" . $itname . "'");
                    if ($result) {
                        $row->itname = $result->itname;
                        $row->cname = $result->cname;
                    }
                }
            }
            //    print_r($data['staff_sms']);
            ///////////
            $itname = $this->uri->segment(4, 0);
            if ($itname) {
                $row = $this->sms_model->itname_chuku_row("reg_itname =  '" . $itname . "' and (sms_number_4 <> '' or sms_number_8 <> '' or sms_number_19 <> '' or sms_number_11 <> ''  or sms_number_39 <> '')");
                if ($row) {
                    $itname = $row->reg_itname;
                    $result = $this->staff_model->get_staff_by("itname = '" . $itname . "'");
                    if ($result) {
                        $staff['status'] = 1;
                        $staff['info'] = $result;
						//统计资产数量
						$condition =  "status = 1 and reg_itname='".$itname."'";
                        $countList = $this->sms_model->staff_sms_oa(0, 0,$condition);
                        $num = 0;
						$sn_list = '';
                        foreach ($countList as $cl){
                        	if($cl -> sms_number_4){
                        		$num++;
								$sn_list .= $cl ->sms_number_4 .' ; ';
                        	}
                        	if($cl -> sms_number_8){
                        		$num++;
								$sn_list .= $cl ->sms_number_8 .' ; ';
                        	}
                        	if($cl -> sms_number_19){
                        		$num++;
								$sn_list .= $cl ->sms_number_19 .' ; ';
                        	}
                        	if($cl -> sms_number_11){
                        		$num++;
								$sn_list .= $cl ->sms_number_11 .' ; ';
                        	}
                        	if($cl -> sms_number_39){
                        		$num++;
								$sn_list .= $cl ->sms_number_39 .' ; ';
                        	}
                        }
                        $result->num = $num ;
						$result->snlist = $sn_list;
                        //load deptinfo
                        $this->load->model('deptsys_model');
                        if ((int) $result->rootid > 0) {
                            $sms_dept = $this->deptsys_model->get_dept_val("id = " . $result->rootid);

                            if ($sms_dept) {
                                $ouTemp = $this->deptsys_model->get_dept_child_DN('id = ' . $result->rootid);
                                if ($ouTemp) {
                                    $result->deptOu = implode("&raquo;", $ouTemp);
                                } else {
                                    $result->deptOu = "";
                                }
                                $result->deptName = $sms_dept->deptName;
                            } else {
                                $result->deptOu = "";
                                $result->deptName = "";
                            }
                        } else {
                            $result->deptOu = "";
                            $result->deptName = "";
                        }
                        /////////////////////////////
                    } else {
                        $staff['status'] = 4;
                        $staff['message'] = "系统正不存在此员工信息！！";
                    }
                } else {
                    $staff['status'] = 3;
                    $staff['message'] = "请确认申请人是否正确！！";
                }
            } else {
                $staff['status'] = 2;
                $staff['message'] = "请选择申请资产姓名！";
            }

            // print_r($staff);
            $this->cismarty->assign("data", $data);
            $this->cismarty->assign("staff", $staff);

            $this->cismarty->display($this->sysconfig_model->templates() . '/public/sms_out.tpl');
        }
    }

    //////////////////////
    function sms_return() {
        if (!$this->session->userdata('logined')) {
            $this->cismarty->display($this->sysconfig_model->templates() . '/login_sm.tpl');
            exit();
        } else {

            $op_user = $this->session->userdata('username');

            $data['staff_sms'] = $this->sms_model->staff_sms_oa_return_list(0, 0, "sms_number <> '' ");

            // print_r($data['staff_sms']);
            if ($data['staff_sms']) {

                foreach ($data['staff_sms'] as $row) {
                    $itname = $row->st_itname;
                    $result = $this->staff_model->get_staff_by("itname = '" . $itname . "'");
                    if ($result) {
                        $row->cname = $result->cname;
                    } else {
                        $row->cname = '无账号信息(已离职?)';
                    }
                }
            }
            //    print_r($data['staff_sms']);
            ///////////
            $itname = $this->uri->segment(4, 0);
            if ($itname) {
                $row = $this->sms_model->staff_sms_oa_return_row("st_itname = '" . $itname . "'");
                if ($row) {
                    $itname = $row->st_itname;
                    $result = $this->staff_model->get_staff_by("itname = '" . $itname . "'");
                    if ($result) {
                        $staff['status'] = 1;
                        $staff['info'] = $result;
                        //load deptinfo
                        $this->load->model('deptsys_model');
                        if ((int) $result->rootid > 0) {
                            $sms_dept = $this->deptsys_model->get_dept_val("id = " . $result->rootid);

                            if ($sms_dept) {
                                $ouTemp = $this->deptsys_model->get_dept_child_DN('id = ' . $result->rootid);
                                if ($ouTemp) {
                                    $result->deptOu = implode("&raquo;", $ouTemp);
                                } else {
                                    $result->deptOu = "";
                                }
                                $result->deptName = $sms_dept->deptName;
                            } else {
                                $result->deptOu = "";
                                $result->deptName = "";
                            }
                        } else {
                            $result->deptOu = "";
                            $result->deptName = "";
                        }
                        /////////////////////////////
                    } else {
                        $staff['status'] = 4;
                        $staff['message'] = "系统正不存在此员工信息！！";
                    }
                } else {
                    $staff['status'] = 3;
                    $staff['message'] = "请确认申请人是否正确！！";
                }
            } else {
                $staff['status'] = 2;
                $staff['message'] = "请选择申请资产姓名！";
            }

            // print_r($staff);
            $this->cismarty->assign("data", $data);
            $this->cismarty->assign("staff", $staff);

            $this->cismarty->display($this->sysconfig_model->templates() . '/public/sms_return.tpl');
        }
    }

    /////////////////////////////////
    function sms_return_do() {
        if (!$this->session->userdata('logined')) {
            $this->cismarty->display($this->sysconfig_model->templates() . '/login_sm.tpl');
            exit();
        } else {

            $itname = $this->input->post('itname');
            $sms_number = $this->input->post('chuku');

            if ($sms_number) {
			    $sms_number = strtoupper($sms_number);
                $row = $this->sms_model->staff_sms_oa_return_row("st_itname = '" . $itname . "' and sms_number like '%" . $sms_number . "%'");
                if ($row) {
                    $staffsms = $this->sms_model->staff_sms_by("itname = '" . $itname . "' and sms_number = '" . $sms_number . "'");

                    $temp_number = explode(";", $row->sms_number);
                    /// return sms

                    $main['sms_number'] = $sms_number;
                    $main['sms_status'] = 1;
                    if ($staffsms->sm_type == 2) {
                        $main['sms_kuwei'] = 3;
                    } else {
                        $main['sms_kuwei'] = 0;
                    }
                    $main['sms_sap_status'] = 0;
                    $this->sms_model->sms_main_editbyNumber($main); //set sms main status
                    // save  log
                    $log['ul_title'] = "资产退仓(OA)";
                    $log['ul_function'] = json_encode($main);
                    $this->saveUserLog($log);

                    $dept['sms_number'] = $sms_number;
                    $dept['itname'] = $itname;

                    $dept['sm_id'] = $staffsms->sm_id;
                    $dept['sm_status'] = 2;
                    $dept['op_user'] = $this->session->userdata('username');
                    $dept['return_time'] = date('Y-m-d H:i:s');
                    $this->sms_model->staff_sms_edit($dept); // set staff sms history status
                    // save  log
                    $log['ul_title'] = "资产退仓(OA)";
                    $log['ul_function'] = json_encode($dept);
                    $this->saveUserLog($log);

                    ////array_search('day',$arr)
                    $key = array_search($sms_number, $temp_number);
                    unset($temp_number[$key]);
                    $save['st_id'] = $row->st_id;
                    $save['sms_number'] = implode(";", $temp_number);
                    $this->sms_model->staff_sms_oa_return_edit($save);

                    $return['code'] = 1;
                    $return['msg'] = $sms_number . " 退仓成功！";
                } else {
                    $return['code'] = 0;
                    $return['msg'] = $sms_number . " 使用人和产品编号不匹配！";
                }
            } else {
                $return['code'] = 0;
                $return['msg'] = $sms_number . " 产品编号错误！";
            }
            print_r(json_encode($return));
        }
    }

    ///////////////////////////////////////////
    function sms_out_do() {
        if (!$this->session->userdata('logined')) {
            $this->cismarty->display($this->sysconfig_model->templates() . '/login_sm.tpl');
            exit();
        } else {

            $itname = $this->input->post('itname');
            $sms_number = $this->input->post('chuku');
            $pw = $this->input->post('pw');
			$so_id_backup = $this->input->post('so_id_backup');			
            //print_r($sms_number);
            if ($sms_number) {
                $so_id = '';
                $nKey = strtoupper($sms_number);
				$hasdone = strpos($so_id_backup,$nKey);
			    if($hasdone){
			   	  $return['code'] = 0;
                  $return['msg'] = "资产编号 : {$nKey},已经添加，请勿重复操作！";
				  print_r(json_encode($return));
				  return;
			    }
                $row = $this->sms_model->itname_chuku_row("reg_itname = '" . $itname . "' and  (sms_number_4 = '" . $nKey . "' or sms_number_8 = '" . $nKey . "' or sms_number_19 = '" . $nKey . "' or sms_number_11 = '" . $nKey . "'  or sms_number_39 = '" . $nKey . "')");
                if ($row) {
                       // $so_id[] = array('so_id' => $row->so_id, 'sms_number' => $nKey);
			        $so_id = $row->so_id.','.$nKey.';';
                        //   $so_id = $soinfo;
					$data1 = $this->sms_model->sms_main_by("sms_number = '" . $nKey . "'");
					if ($data1) {
					   if ($data1->sms_cat_id) {
                         $category = $this->sms_model->sms_category_by("sc_id =" . $data1->sms_cat_id);
                         $numArray = explode(';',$so_id_backup);
                         $num = sizeof($numArray);
						 $info =  $num.'. 资产匹配成功：'.$category->sc_name.' ; 资产编号：'.$nKey.' ; 使用人-'.$itname;
					   }
				     }
                }
                if ($so_id) {
                    $return['code'] = 1;
                    $return['msg'] = $so_id;
                    $return['sms_number'] = $sms_number;
					$return['info'] = $info;
                } else {
                    $return['code'] = 0;
                    $return['msg'] = " 使用人和产品编号不匹配！"; //$sms_number .
                }
            } else {
                $return['code'] = 0;
                $return['msg'] = " 产品编号错误！"; //$sms_number . 
            }
            print_r(json_encode($return));
        }
    }

    function sms_out_do_true() {
        if (!$this->session->userdata('logined')) {
            $this->cismarty->display($this->sysconfig_model->templates() . '/login_sm.tpl');
            exit();
        } else {
            $return = array();
            $op_user = $this->session->userdata('username');
            $username = $this->input->post('username');
            //$soInfo = json_decode($this->input->post('so_id'));
			$soInfo = $this->input->post('so_id');
            // $sms_number = strtoupper($this->input->post('sms_number_true'));
            $pw = $this->input->post('password');

            $adUser = TRUE; // $this->adUserCheck($username, $pw);
            if ($adUser) {
                $_SESSION['outTure'] = false;
                //$smsInfo = $soInfo->msg;
				$smsInfo = explode(';',$soInfo);
                //print_r($smsInfo);
                foreach ($smsInfo as $rowso) {
                    //$so_id = $rowso->so_id;
                    //$sms_number = $rowso->sms_number;
                    //print_r($rowso);
					$rowso = explode(',',$rowso);
                    $so_id = $rowso[0];
                    if(empty($so_id)){
                    	continue;
					}
                    $sms_number = $rowso[1];			
                    $row = $this->sms_model->itname_chuku_row("so_id = " . $so_id);
                    if ($row) {
                        $sms_field = @array_keys((array) $row, $sms_number);
                        ////////////////// type loading
                        $type = $sms_field[0];
                        // echo $type;
                        switch ($type) {
                            case 'sms_number_8':
                                $row->sms_ip = "";
                                break;
                        }

                        // update staff_sms

                        $staff = $this->staff_model->get_staff_by("itname = '" . $row->reg_itname . "'");
                        $data['dept_id'] = $staff->rootid;
                        $data['sm_status'] = 1;
                        $data['sm_sap_status'] = 0;
                        $data['sm_type'] = $row->sm_type;
                        // echo "1111";
                        // $data['use_time'] = date('Y-m-d H:i:s');
                        $data['op_time'] = date('Y-m-d H:i:s');
                        $data['use_time'] = date('Y-m-d H:i:s');
                        $data['op_user'] = $this->session->userdata('username');
                        $data['lingqu_itname'] = $username;
                        $data['sms_ip'] = $row->sms_ip;
                        $data['sms_number'] = $sms_number;
                        $data['so_itname'] = $row->so_itname;
                        $data['itname'] = $row->reg_itname;
                        // add staff add///////////////////////////////
                        $this->sms_model->staff_sms_add($data);
                        // echo "sss";
                        // update staff_sms_oa
                        $so['so_id'] = $so_id;
                        $so[$type] = '';
                        $this->sms_model->staff_sms_oa_edit($so);

                        // update staff_sms_oa_register
                        $upsa['sms_number'] = $sms_number;
                        $upsa['so_status'] = 2;
                        $this->sms_model->staff_sms_oa_register_editbyNumber($upsa);

                        // save  log
                        $log['ul_title'] = "资产出库-新使用人";
                        $log['ul_function'] = json_encode($data);
                        $this->saveUserLog($log);

                        $reMsg[] = $sms_number . " 出库成功！！";
                    } else {
                        $reMsg[] = $sms_number . " 资产编号是否正确，请确认！";
                    }
                }

                $return['code'] = 1;
                $return['msg'] = implode('<br>', $reMsg);
            } else {
                $return['code'] = 0;
                $return['msg'] = " 领取人密码错误！";
            }
            print_r(json_encode($return));
        }
    }

    function sms_inlinyong() {
        if (!$this->session->userdata('logined')) {
            $this->cismarty->display($this->sysconfig_model->templates() . '/login_sm.tpl');
            exit();
        } else {
            $smsLocal = $this->sms_model->sms_local_list('');
            $smsAff = $this->sms_model->sms_affiliate();
            $smsBrand = $this->sms_model->sms_brand_list("");
            $this->cismarty->assign("smsLocal", $smsLocal);
            $this->cismarty->assign("smsAff", $smsAff);
            $this->cismarty->assign("smsBrand", $smsBrand);
            $this->cismarty->display($this->sysconfig_model->templates() . '/public/sms_inlinyong.tpl');
        }
    }

    function sms_inbatch() {
        if (!$this->session->userdata('logined')) {
            $this->cismarty->display($this->sysconfig_model->templates() . '/login_sm.tpl');
            exit();
        } else {
            $smsLocal = $this->sms_model->sms_local_list('');
            $smsAff = $this->sms_model->sms_affiliate();
            $smsBrand = $this->sms_model->sms_brand_list("");
            $this->cismarty->assign("smsLocal", $smsLocal);
            $this->cismarty->assign("smsAff", $smsAff);
            $this->cismarty->assign("smsBrand", $smsBrand);
            $this->cismarty->display($this->sysconfig_model->templates() . '/public/sms_inbatch.tpl');
        }
    }

    function sms_inbatch_true() {
        $data = $_POST;
        //  print_r($data);
        //$msg = $this->staff_model->add($data);
        $sms_number = $data['sms_number'];
        $sms_sapnumber = $data['sms_sapnumber'];
        unset($data['sms_number']);
        unset($data['sms_sapnumber']);

        if ($data['sms_cat_id']) {
            $data['sms_cat_id'] = $data['sms_cat_id'];
            $sms_number = explode(',', $sms_number);
            if ($sms_sapnumber) {
                $sms_sapnumber = explode(',', $sms_sapnumber);
            }
            $msg = "";
            for ($i = 0; $i < count($sms_number); $i++) {
                $data['sms_number'] = trim($sms_number[$i]);
                $sms_main = $this->sms_model->sms_main_by("sms_number = '" . $data['sms_number'] . "'");
                if ($sms_main) {
                    $msg .= $data['sms_number'] . "  资产已经存在<br>";
                } else {
                    if ($sms_sapnumber) {
                        $data['sms_sapnumber'] = trim($sms_sapnumber[$i]);
                    }
                    $data['sms_input_time'] = date('Y-m-d H:i:s');
                    unset($data['oa_number']);
                    unset($data['scb_id']);
                    $this->sms_model->sms_main_add($data);

                    // save  log
                    $log['ul_title'] = "批量加入资产";
                    $log['ul_function'] = json_encode($data);
                    $this->saveUserLog($log);
                }
                /////delect sms_number 
                $smsNumber = $data['sms_number'];
                $this->sms_model->sms_number_del($smsNumber);

                //// delect sms_oa_caigou_batch
                $this->sms_model->sms_oa_caigou_batch_del($smsNumber);
            }


            $return['code'] = 1;
            $return['msg'] = " 批量出库操作完成！！<br>" . $msg;
        } else {
            $return['code'] = 0;
            $return['msg'] = " 请填写正确的出库信息！！";
        }
        print_r(json_encode($return));
    }

    function in_number_check() {
        $sms_number = $this->input->post('sms_number');
        // echo $sms_number;
        $sms = $this->sms_model->sms_oa_caigou_by("sms_number_4 = '" . $sms_number . "' or sms_number_8 = '" . $sms_number . "' or sms_number_19 = '" . $sms_number . "' or sms_number_11 = '" . $sms_number . "'  or sms_number_39 = '" . $sms_number . "'");
        if ($sms) {
            $data['status'] = 1;
            //$sms->sms_ip = "";
            $sms_field = @array_keys((array) $sms, $sms_number);
            ////////////////// type loading
            $type = $sms_field[0];
            switch ($type) {
                case 'sms_number_4':
                    $sms->cate_id = 4;
                    $sms->cate_name = "联想主机";
                    $sms->sap_number = $sms->sap_number_4;
                    break;
                case 'sms_number_8':
                    $sms->cate_id = 8;
                    $sms->cate_name = "液晶显示器";
                    $sms->sms_ip = "";
                    $sms->sap_number = $sms->sap_number_8;
                    break;
                case 'sms_number_19':
                    $sms->cate_id = 19;
                    $sms->cate_name = "笔记本";
                    $sms->sap_number = $sms->sap_number_19;
                    break;
                case 'sms_number_11':
                    $sms->cate_id = 11;
                    $sms->cate_name = "苹果一体机";
                    $sms->sap_number = $sms->sap_number_11;
                    break;
                case 'sms_number_39':
                    $sms->cate_id = 39;
                    $sms->cate_name = "手绘板";
                    $sms->sap_number = $sms->sap_number_39;
                    break;
            }
            ////////////////////staff loading/
            $result = $this->staff_model->get_staff_by("itname = '" . $sms->reg_itname . "'");
            if ($result) {
                $staff['status'] = 1;
                $sms->cname = $result->cname;
                //load deptinfo
                $this->load->model('deptsys_model');
                if ((int) $result->rootid > 0) {
                    $sms_dept = $this->deptsys_model->get_dept_val("id = " . $result->rootid);

                    if ($sms_dept) {
                        $ouTemp = $this->deptsys_model->get_dept_child_DN('id = ' . $result->rootid);
                        if ($ouTemp) {
                            $result->deptOu = implode("&raquo;", $ouTemp);
                        } else {
                            $result->deptOu = "";
                        }
                        $result->deptName = $sms_dept->deptName;
                    } else {
                        $result->deptOu = "";
                        $result->deptName = "";
                    }
                } else {
                    $result->deptOu = "";
                    $result->deptName = "";
                }
                $staff['staff'] = $result;
                /////////////////////////////
            } else {
                $staff['status'] = 0;
                $staff['message'] = "系统正不存在此员工信息！！";
            }
            $data['sms'] = $sms;
            $data['staff'] = $staff;
        } else {
            $staff['status'] = 0;
            $data['status'] = 0;
            $data['sms'] = "";
            $data['staff'] = $staff;
        }
        print_r(json_encode($data));
    }

    function in_batch_check() {
        $oa_number = $this->input->post('oa_number');
        $sms_cat_id = $this->input->post('sms_cat_id');
        if ($oa_number && $sms_cat_id) {
            $batch = $this->sms_model->sms_oa_caigou_batch_by("oa_number = '" . $oa_number . "' and sms_cat_id = " . $sms_cat_id);
            if ($batch) {
                $data['status'] = 1;
                //$sms->sms_ip = ""; 
                $data['sms'] = $batch;
            } else {
                $data['status'] = 0;
                $data['sms'] = "此单号或类别无采购信息！！";
            }
        } else {

            $data['status'] = 0;
            $data['sms'] = "请输入正确的OA单号 和 资产类别！！";
        }
        print_r(json_encode($data));
    }

    function sms_inlinyong_true() {
        if (!$this->session->userdata('logined')) {
            $this->cismarty->display($this->sysconfig_model->templates() . '/login_sm.tpl');
            exit();
        } else {
            $op_user = $this->session->userdata('username');
            $username = $this->input->post('lingqu_itname');
            $pw = $this->input->post('password');
            $adUser = $this->adUserCheck($username, $pw);
            if ($adUser) {
                $data['sms_number'] = $this->input->post('sms_number');
                $sms_main = $this->sms_model->sms_main_by("sms_number = '" . $data['sms_number'] . "'");

                if ($sms_main) {
                    $return['code'] = 0;
                    $return['msg'] = " 此资产已经存在！！";
                } else {
                    // inset staff_sms
                    $data['itname'] = $this->input->post('reg_itname');
                    $data['dept_id'] = $this->input->post('rootid');
                    $data['sm_status'] = 1;
                    $data['sms_ip'] = $this->input->post('sms_ip');
                    $data['sms_number'] = $data['sms_number'];
                    $data['sm_sap_status'] = 0;
                    $data['use_time'] = date('Y-m-d H:i:s');
                    $data['op_user'] = $op_user;
                    $data['op_time'] = date('Y-m-d H:i:s');
                    $data['so_itname'] = $this->input->post('so_itname');
                    $data['lingqu_itname'] = $this->input->post('lingqu_itname');
                    $this->sms_model->staff_sms_add($data);
                    //
                    // inset sms_main
                    $smsMain = $this->input->post();
                    unset($smsMain['sms_cate_name']);
                    unset($smsMain['reg_itname']);
                    unset($smsMain['reg_cname']);
                    unset($smsMain['lingqu_itname']);
                    unset($smsMain['rootid']);
                    unset($smsMain['password']);
                    unset($smsMain['scg_id']);
                    $smsMain['sms_cat_id'] = $smsMain['sms_cate_3'];
                    unset($smsMain['sms_cate_3']);
                    unset($smsMain['sms_ip']);
                    unset($smsMain['so_itname']);
                    $smsMain['sms_input'] = $op_user;
                    $smsMain['sms_input_time'] = date('Y-m-d H:i:s');
                    $smsMain['sms_status'] = 2;
                    $this->sms_model->sms_main_add($smsMain);

                    ///update sms_oa_caigou
                    $cg['scg_id'] = $this->input->post('scg_id');
                    $type = $smsMain['sms_cat_id'];
                    switch ($type) {
                        case 4:
                            $cg['sms_number_4'] = "";
                            break;
                        case 8:
                            $cg['sms_number_8'] = "";
                            break;
                        case 19:
                            $cg['sms_number_19'] = "";
                            break;
                        case 11:
                            $cg['sms_number_11'] = "";
                            break;
                        case 39:
                            $cg['sms_number_39'] = "";
                            break;
                    }
                    $this->sms_model->sms_oa_caigou_edit($cg);

                    // delect  sms_number
                    $sms_number = $this->input->post('sms_number');
                    $this->sms_model->sms_number_del($sms_number);

                    // update staff_sms_oa
                    // save  log
                    $log['ul_title'] = "资产出库-零星采购用人";
                    $log['ul_function'] = json_encode($data);
                    $this->saveUserLog($log);

                    $return['code'] = 1;
                    $return['msg'] = $data['sms_number'] . " 入库领取成功！！";
                }
            } else {
                $return['code'] = 0;
                $return['msg'] = " 领取人密码错误！";
            }

            print_r(json_encode($return));
        }
    }

    function adUserCheck($username, $password) {
        // load AD 
        // $this->load->library('adldaplibrary');
        //  $adldap = new adLDAP();
        $ldapconn = ldap_connect("10.90.18.3");        //连接ad服务
        ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);    //设置参数
        $ldap_bd = @ldap_bind($ldapconn, "AppSystem", "Semir@app");                    //打开ldap，正确则返回true。登陆
        //  var_dump($ldap_bd);
        if ($ldap_bd) {
            $bd = @ldap_bind($ldapconn, $username . '@semir.cn', $password);
            if ($bd) {
                return TRUE;
            } else {
                return FALSE;
            }
            ldap_close($ldapconn); //关闭
        } else {
            return FALSE;
        }
    }

    function adUserCheckTest() {
        // load AD 
        // $this->load->library('adldaplibrary');
        //  $adldap = new adLDAP();
        $ldapconn = ldap_connect("10.90.18.3");        //连接ad服务
        ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);    //设置参数
        $ldap_bd = @ldap_bind($ldapconn, "AppSystem", "Semir@app");                    //打开ldap，正确则返回true。登陆
        //  var_dump($ldap_bd);
        if ($ldap_bd) {
            $bd = @ldap_bind($ldapconn, 'lixumin@semir.cn', '030510');
            var_dump($bd);
            if ($bd) {
                return TRUE;
            } else {
                return FALSE;
            }
            ldap_close($ldapconn); //关闭
        } else {
            return FALSE;
        }
    }

    function saveUserLog($data) {
        $data['ul_username'] = $this->session->userdata('username');
        $data['ul_time'] = date('Y-m-d H:i:s');
        $data['ul_model'] = '资产管理';
        $this->sysconfig_model->sys_user_log($data);
    }

    /*
     * 批量出哭测试
     */

    function BitchChuKu() {
        $smsInfo = $this->sms_model->staff_sms_oa(0,0,"reg_itname 11111 =  'lihui' and  sms_number_8 <> '' ");
      //  print_r($smsInfo);
       //  exit;
        foreach ($smsInfo as $rowso) {
            $so_id = $rowso->so_id;
            $sms_number = $rowso->sms_number_8;
          //  print_r($rowso);
            $row = $this->sms_model->itname_chuku_row("so_id = " . $so_id);
            if ($row) {
                $sms_field = @array_keys((array) $row, $sms_number);
                ////////////////// type loading
                $type = $sms_field[0];
                // echo $type;
                switch ($type) {
                    case 'sms_number_8':
                        $row->sms_ip = "";
                        break;
                }

                // update staff_sms

                $staff = $this->staff_model->get_staff_by("itname = '" . $row->reg_itname . "'");
                $data['dept_id'] = $staff->rootid;
                $data['sm_status'] = 1;
                $data['sm_sap_status'] = 0;
                $data['sm_type'] = $row->sm_type;
                // echo "1111";
                // $data['use_time'] = date('Y-m-d H:i:s');
                $data['op_time'] = date('Y-m-d H:i:s');
                $data['use_time'] = date('Y-m-d H:i:s');
                $data['op_user'] = $this->session->userdata('username');
                $data['lingqu_itname'] = 'nieanzhen';
                $data['sms_ip'] = $row->sms_ip;
                $data['sms_number'] = $sms_number;
                $data['so_itname'] = $row->so_itname;
                $data['itname'] = $row->reg_itname;
                print_r($data);
                // add staff add///////////////////////////////
                  $this->sms_model->staff_sms_add($data);
                // echo "sss";
                // update staff_sms_oa
                $so['so_id'] = $so_id;
                $so[$type] = '';
                print_r($so);
                 $this->sms_model->staff_sms_oa_edit($so);
                // update staff_sms_oa_register
                $upsa['sms_number'] = $sms_number;
                $upsa['so_status'] = 2;
          $this->sms_model->staff_sms_oa_register_editbyNumber($upsa);


                echo $sms_number . " 出库成功！！";
            } else {
                echo $sms_number . " 资产编号是否正确，请确认！";
            }
        }
    }

}

?>