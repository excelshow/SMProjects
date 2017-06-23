<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Qyhdd extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('qyhdd_model');
    }

    function index() {
        echo "Error!";
    }

    /*
     * 检查表 企业号 钉钉 组织机构同步 
     */

    function qydd_dept_snyc() {
        echo "企业号：<br>";
        $qyhDept = $this->qyhdd_model->qyh_dept_result('');
        if ($qyhDept) {
            foreach ($qyhDept as $row) {
                $upQyh = array();
                // echo $row->sd_id;
                $qyhDept = $this->qyhdd_model->get_dept_val('id = ' . $row->sd_id);
                if ($qyhDept) {
                    echo 1;
                } else {
                    //同步企业号   print_r($upQyh);
                    $upQyh['id'] = $row->qyh_id;
                    $reQyh = $this->curl_get('id=' . $row->qyh_id, 'department/delete');
                    $reQyh = json_decode($reQyh);
                    //print_r($reQyh);
                    if ($reQyh->errcode > 0) {
                        echo "同步企业号组织失败：";
                        echo $reQyh->errcode . '==' . $reQyh->errmsg;
                        print_r($row);
                        echo '<br>';
                    } else {
                        echo "同步企业号组织成功。";
                        $this->qyhdd_model->qyh_dept_del($row->sd_id);
                    }
                }
            }
        }

        /// dd
        echo "钉钉：<br>";
        $ddDept = $this->qyhdd_model->dd_dept_result('');
        if ($ddDept) {
            foreach ($ddDept as $row) {
                // echo $row->sd_id;
                $qyhDept = $this->qyhdd_model->get_dept_val('id = ' . $row->sd_id);
                if ($qyhDept) {
                    echo 1;
                } else {
                    //同步企业号   print_r($upQyh);
                    $upDd['id'] = $row->dd_id;
                    $reQyh = $this->curl_get_dd('id=' . $row->dd_id, 'department/delete');
                    $reQyh = json_decode($reQyh);
                    // print_r($reQyh);
                    if ($reQyh->errcode > 0) {
                        echo $reQyh->errcode . '==' . $reQyh->errmsg;
                        print_r($row);
                        echo '<br>';
                    } else {
                        echo "SU";
                        $this->qyhdd_model->dd_dept_del($row->sd_id);
                    }
                }
            }
        }
    }

    /*
     * 检查表 staff_address / staff_main / staff_scrap 一天的编号记录
     */

    function qyhmtc_snyc() {
        $this->load->model('staff_model');
        $this->load->model('tongxun_model');

        // 获取用户更新信息
        $staff = $this->staff_model->get_staffs(0, 0, "(TO_DAYS(NOW())-TO_DAYS(modifytime) <= 1)"); //(TO_DAYS(NOW())-TO_DAYS( modifytime) <= 4)
        if ($staff) {
            foreach ($staff as $row) {
                // 同步更改组织
                $this->load->model("tongxun_model"); // load Mob
                $staffMob = $this->tongxun_model->staffs_addree_row("itname = '" . $row->itname . "'"); // loading dept  qyh_id
                echo "<br>用户同步(企业号)：" . $row->itname . "<br>";
                //  print_r($row);
                // print_r($staffMob);
                if ($staffMob) {
                    if ($staffMob->sa_mobile) {
                        //echo "sss";
                        $this->qyh_snyc_do($row, trim($staffMob->sa_mobile));
                        $this->mtc_snyc_do($row, trim($staffMob->sa_mobile), 1);
                        // 钉钉
                        $this->dd_snyc_do($row, trim($staffMob->sa_mobile));
                    } else {
                        echo "用户信息修改，但无手机号码";
                    }
                }
            }
        }
        // print_r($staff);
        $staffScrap = $this->staff_model->get_staffs_scrap(0, 0, "(TO_DAYS(NOW())-TO_DAYS(modifytime) <= 1)");
        echo "<br>离职：";
        // print_r($staffScrap);
        if ($staffScrap) {
            foreach ($staffScrap as $row) {
                // 离职处理
                $this->qyh_snyc_del($row->itname);
                $this->mtc_snyc_do($row, "", 0);

                // 钉钉
                $this->dd_snyc_del($row->itname);
            }
        }

        $address = $this->tongxun_model->get_staffs_limit(0, 0, "(TO_DAYS(NOW())-TO_DAYS(sa_uptime) <= 1)");
        echo "<br>用户手机修改：";
        //   print_r($address);
        // exit;
        if ($address) {
            foreach ($address as $row) {
                if ($row->sa_mobile) {
                    $staff = $this->staff_model->get_staff_by("itname = '" . $row->itname . "'");

                    //企业号
                    $this->qyh_snyc_do($staff, trim($row->sa_mobile));
                    $this->mtc_snyc_do($staff, trim($row->sa_mobile), 1);

                    // 钉钉
                    $this->dd_snyc_do($staff, trim($row->sa_mobile));
                }
            }
        }
    }

    function qyh_snyc_do($data, $staffMob) {
        $row = $data;
        $upQyh['userid'] = $row->itname;
        $upQyh['name'] = $row->cname;
        $upQyh['email'] = $row->email;

        $upQyh['mobile'] = $staffMob;
        $qyhStaff = $this->qyhdd_model->qyh_staff_row("qyh_staff.itname = '" . $row->itname . "'");
        // print_r($upQyh);
        if ($qyhStaff) {
            // 更新组织机构
            $qyhDeptNew = $this->qyhdd_model->qyh_dept_row("sd_id = " . $row->rootid);
            $qyhDept['qs_qyh_id'] = $qyhDeptNew->qyh_id;
            $this->qyhdd_model->qyh_staff_edit($row->itname, $qyhDept);

            $qyhStaffDept = $this->qyhdd_model->qyh_dept_row("sd_id = " . $row->rootid); // loading dept  qyh_id
            $upQyh['department'] = array($qyhStaffDept->qyh_id);

            $reQyh = $this->curl_post($upQyh, 'user/update');
        } else {
            $qyhStaffDept = $this->qyhdd_model->qyh_dept_row("sd_id = " . $row->rootid); // loading dept  qyh_id
            $upQyh['department'] = array($qyhStaffDept->qyh_id);


            //同步企业号   print_r($upQyh);
            $reQyh = $this->curl_post($upQyh, 'user/create');
            $reQyh = json_decode($reQyh);
            // print_r($reQyh);
            if ($reQyh->errcode > 0) {
                echo "<br>新加企业号失败：" . $row->itname;
                echo $reQyh->errcode . '==' . $reQyh->errmsg;
                echo $upQyh['userid'] . '<br>';
            } else {
                echo "<br>新加企业号成功：" . $row->itname;
                $qyhStaff['itname'] = $row->itname;
                $qyhStaff['qs_qyh_id'] = $qyhStaffDept->qyh_id;
                $this->qyhdd_model->qyh_staff_add($qyhStaff);
            }
        }
    }

    function mtc_snyc_do($data, $staffMob, $key) {
        // 同步到OA MTC
        $row = $data;
        $this->load->model("deptsys_model"); // load Mob
        $dept = $this->deptsys_model->get_dept_val('id = ' . $row->rootid);
        $upData["fdLoginName"] = $row->itname;
        $upData["fdName"] = $row->cname;
        $upData["fdSex"] = $row->gender;
        $upData["fdBirthDay"] = '';
        $upData["fdDepartmentName"] = $dept->deptName;
        $upData["fdPostName"] = $row->station;
        $upData["fdMobilePhone"] = $staffMob;
        $upData["fdEmail"] = $row->itname . "@semir.com";
        $upData["fdNumber"] = '';
        $upData["fdIsAvailable"] = $key;
        $reVal = $this->oamtc_snyc($upData);
        if ($reVal->error == 1111) {
            $upStaff['oa_mtc'] = 1;
            $upStaff['oa_mtc_status'] = 1;
            $this->qyhdd_model->qyh_staff_edit($row->itname, $upStaff);
        }
    }

    /*
     * 同步删除企业号 
     */

    function qyh_snyc_del($itname) {
        $itname = $itname;
        //  echo $itname;
        if ($itname) {
            $qyhStaff = $this->qyhdd_model->qyh_staff_row("qyh_staff.itname = '" . $itname . "'");
            // print_r($qyhStaff);
            if ($qyhStaff) {
                $reQyh = $this->curl_get("userid=" . $itname, 'user/delete');
                $reQyh = json_decode($reQyh);
                // print_r($reQyh);
                if ($reQyh->errcode > 0) {
                    //  echo $reQyh->errmsg;
                } else {
                    ////////////////// del qyh_staff
                    $this->qyhdd_model->qyh_staff_del($itname);
                    // echo 0;
                }
            } else {
                echo "离职已经处理!";
            }
        } else {
            echo "Error11!";
        }
    }

    /*
     * curl function lizd11 20150916
     */

    function qyh_gettoken() {
        $ch = curl_init();
        $timeout = 5;
        $corpid = "wxdd4a8419cffdd0ea";
        $corpsecret = "577S1zIlBkUxscgeHH1fXoEa1TA_oA0_Mdnq1tTNz4XgfQ7tOPq4kcveAqql0NYz"; //   正式企业号信息
        curl_setopt($ch, CURLOPT_URL, 'https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=' . $corpid . '&corpsecret=' . $corpsecret);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 获取数据返回  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        // curl_setopt($ch, CURLOPT_BINARYTRANSFER, true); // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回  
        $output = curl_exec($ch);
        curl_close($ch);
        $return = json_decode($output);
        if ($return->access_token) {
            return $return->access_token;
        } else {
            echo "1";
            exit();
        }
    }

    function curl_post($data, $url) {
        $ch = curl_init();
        $timeout = 5;
        //  $code = json_encode($data);
        $code = json_encode($data, JSON_UNESCAPED_UNICODE);
        // $code = preg_replace("#\\\u([a-f]+)#ie", "iconv('UCS-2', 'UTF-8', pack('H4', '\\1'))", $code);
        // print_r($code);
        $aToken = $this->qyh_gettoken();
        curl_setopt($ch, CURLOPT_URL, "https://qyapi.weixin.qq.com/cgi-bin/" . $url . "?access_token=" . $aToken);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $code);
        $file_contents = curl_exec($ch);
        curl_close($ch);
        //   print_r($file_contents);
        return $file_contents;
    }

    function curl_get($data, $url) {
        $ch = curl_init();
        $timeout = 5;
        // print_r($code);
        $aToken = $this->qyh_gettoken();
        curl_setopt($ch, CURLOPT_URL, "https://qyapi.weixin.qq.com/cgi-bin/" . $url . "?access_token=" . $aToken . "&" . $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 获取数据返回  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        $file_contents = curl_exec($ch);
        curl_close($ch);
        // print_r($file_contents);
        return $file_contents;
    }

    function oamtc_snyc($data) {
        //      header("content-type:text/html;charset=utf-8");
        $this->load->library('Nusoap');
        // 要访问的webservice路径
        $NusoapWSDL = "http://wxapp.semir.com.cn:8081/webservice/MtcCommonUserWebService?wsdl"; ///  //http://10.90.18.75:8016/Pages/webservice/WSuserrights.asmx?WSDL
        //$NusoapWSDL = "http://ums.zj165.com:8888/sms_hb/services/Sms?wsdl";
        $nusoap_client = new SoapClient($NusoapWSDL);
        $nusoap_client->soap_defencoding = 'utf-8';
        $nusoap_client->decode_utf8 = false;
        $nusoap_client->xml_encoding = 'utf-8';
        $param = $data;
        $result = $nusoap_client->send($param);
        return json_decode($result->return);
    }

    /*
     * dingding tools
     * 
     */

    function tools_dd_staff_result() {
        $temp = $this->qyhdd_model->dd_staff_result(500, 1600, "");
        //print_r($temp);
        foreach ($temp as $row) {
            $this->load->model('tongxun_model');
            $staffMob = $this->tongxun_model->staffs_addree_row("itname = '" . $row->itname . "'");
            if ($staffMob) {
                $upDd['userid'] = $row->itname;
                $upDd['tel'] = $staffMob->sa_tel_short;
                //echo $upDd['tel']."/";
                /**
                  $reQyh = $this->curl_post_dd($upDd, 'user/update');
                  $reQyh = json_decode($reQyh);
                  if ($reQyh->errcode > 0) {
                  echo $reQyh->errcode . "=" . $reQyh->errmsg;
                  } else {
                  // save
                  echo 1;
                  }

                 */
            } else {
                echo $row->itname;
            }
        }
    }

    function dd_snyc_do($data, $staffMob) {
        $row = $data;
        $upDd['userid'] = $row->itname;
        $upDd['name'] = $row->cname;
        $upDd['position'] = $row->station;
        if ($row->jobnumber) {
            $upDd['jobnumber'] = $row->jobnumber;
        } else {
            $upDd['jobnumber'] = "-";
        }
        $upDd['email'] = $row->email;
        $upDd['position'] = $row->station;
        $upDd['mobile'] = $staffMob;

        $add = $this->tongxun_model->staffs_addree_row("itname = '" . $row->itname . "'");
        if ($add) {
            if (strlen($add->sa_tel) == 7 || strlen($add->sa_tel) == 8) {
                $bgTel = $add->sa_code . '-' . $add->sa_tel;
                $bTel = array('办公电话' => $bgTel);
            }
            //  $upDd['tel'] = trim($add->sa_tel_short);
            $fTel = array('内线号码' => $staffMob->sa_tel_short);
            $upDd['extattr'] = array_merge($bTel, $fTel);
        }

        $ddStaff = $this->qyhdd_model->dd_staff_row("itname = '" . $row->itname . "'");
        // print_r($row);
        if ($ddStaff) {
            // 更新组织机构
            $ddDeptNew = $this->qyhdd_model->dd_dept_row("sd_id = " . $row->rootid);
            $ddDept['dd_id'] = $ddDeptNew->dd_id;
            $this->qyhdd_model->dd_staff_edit($row->itname, $ddDept);

            $ddStaffDept = $this->qyhdd_model->dd_dept_row("sd_id = " . $row->rootid); // loading dept  qyh_id
            if ($ddStaffDept) {
                $upDd['department'] = array($ddStaffDept->dd_id);
            }
            $reQyh = $this->curl_post_dd($upDd, 'user/update');
        } else {
            $ddStaffDept = $this->qyhdd_model->dd_dept_row("sd_id = " . $row->rootid); // loading dept  qyh_id
            if ($ddStaffDept) {
                $upDd['department'] = array($ddStaffDept->dd_id);
                //同步企业号   print_r($upQyh);
                $reDD = $this->curl_post_dd($upDd, 'user/create');
                $reDD = json_decode($reDD);
                //print_r($reDD);
                if ($reDD->errcode > 0) {
                    echo "<br>同步DD用户失败：" . $row->itname;
                    echo $reDD->errcode . '==' . $reDD->errmsg;
                    // echo $reDD['userid'] . '<br>';
                } else {
                    echo "<br>同步DD用户成功：" . $row->itname;
                    $ddStaff['itname'] = $row->itname;
                    $ddStaff['dd_id'] = $ddStaffDept->dd_id;
                    $this->qyhdd_model->dd_staff_add($ddStaff);
                }
            } else {
                echo "钉钉无此组织";
            }
        }
    }

    function dd_snyc_del($itname) {
        $itname = $itname;
        echo $itname;
        if ($itname) {
            $ddStaff = $this->qyhdd_model->dd_staff_row("itname = '" . $itname . "'");
            // print_r($qyhStaff);
            if ($ddStaff) {
                $reQyh = $this->curl_get_dd("userid=" . $itname, 'user/delete');
                $reQyh = json_decode($reQyh);
                // print_r($reQyh);
                if ($reQyh->errcode > 0) {
                    echo '钉钉删除：' . $reQyh->errcode . $reQyh->errmsg;
                } else {
                    ////////////////// del qyh_staff
                    $this->qyhdd_model->dd_staff_del($itname);
                    // echo 0;
                }
            } else {
                echo "钉钉离职已经处理!";
            }
        } else {
            echo "Error11!";
        }
    }

    function curl_post_dd($data, $url) {

        $ch = curl_init();
        $header = array(
            'Content-Type: application/json',
        );
        $timeout = 50;
        $code = json_encode($data, JSON_UNESCAPED_UNICODE);
        //  json_encode($data)
        //$code = preg_replace("#\\\u([a-f]+)#ie", "iconv('UCS-2', 'UTF-8', pack('H4', '\\1'))", $code);
        // print_r($code);
        $aToken = $this->qyh_gettoken_dd();
        curl_setopt($ch, CURLOPT_URL, "https://oapi.dingtalk.com/" . $url . "?access_token=" . $aToken);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $code);
        $file_contents = curl_exec($ch);
        curl_close($ch);
        // print_r($file_contents);
        return $file_contents;
    }

    function curl_get_dd($data, $url) {
        $ch = curl_init();
        $timeout = 50;
        // print_r($code);
        $aToken = $this->qyh_gettoken_dd();
        curl_setopt($ch, CURLOPT_URL, "https://oapi.dingtalk.com/" . $url . "?access_token=" . $aToken . "&" . $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 获取数据返回  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        $file_contents = curl_exec($ch);
        curl_close($ch);
        // print_r($file_contents);
        return $file_contents;
    }

    function qyh_gettoken_dd() {
        $ch = curl_init();
        $timeout = 50;
        $corpid = "dingbf6fa52cc4e8549e";
        $corpsecret = "Fb815crEEVBFYyK0zfzoElRzdJnAJNCKtXLEeZ1y7_GQxkR4G0pYgGZayJ1Mvt3a"; //    
        curl_setopt($ch, CURLOPT_URL, 'https://oapi.dingtalk.com/gettoken?corpid=' . $corpid . '&corpsecret=' . $corpsecret);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 获取数据返回  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        // curl_setopt($ch, CURLOPT_BINARYTRANSFER, true); // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回  
        $output = curl_exec($ch);
        curl_close($ch);
        $return = json_decode($output);
        if ($return->access_token) {
            // echo $return->access_token;
            return $return->access_token;
        } else {
            echo "1";
            exit();
        }
    }

}
