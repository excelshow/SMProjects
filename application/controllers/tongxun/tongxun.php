<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tongxun extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->dx_auth->check_uri_permissions();
        $this->load->model('staff_model');
        $this->load->model('tongxun_model');
        $this->sysconfig_model->sysInfo(); // set sysInfo
        $this->sysconfig_model->set_sys_permission(); // set controller permission
        $this->mainmenu_model->showMenu();
        $menuCurrent = $this->showConMenu();
        $this->cismarty->assign("menuController", $menuCurrent);
        $this->cismarty->assign("urlF", $this->uri->segment(2));
        $this->cismarty->assign("urlS", $this->uri->segment(3));
    }

    function pagination($linkUrl, $linkNumber, $uri_segment, $condition = "") {
        $this->load->library('pagination');
        $config['base_url'] = site_url($linkUrl);
        $config['total_rows'] = $linkNumber;
        $config['per_page'] = 100;
        $config['uri_segment'] = $uri_segment;
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }

    function showConMenu() {
        $showmenu = NULL;
        $showmenu .= "<li><a href=" . site_url("tongxun/tongxun") . " >员工联系信息</a></li>";
        $showmenu .= "<li><a href=" . site_url("tongxun/tongxun/publiclist") . " >公共联系信息</a></li>";

        return $showmenu;
    }

    function index() {
        $id = $this->uri->segment(4, 0);
        $search = $this->input->post('searchText');
        if (!$id) {
            $id = 0;
        }
        $this->cismarty->assign('menuUrl', array('tongxun', 'index'));
        $this->cismarty->assign("id", $id);
        //$this->cismarty->assign("data", $data['staffs']);
        // $this->cismarty->assign("links", $data['links']); 
        $this->cismarty->display($this->sysconfig_model->templates() . '/tongxun/index.tpl');
    }

    function stafflist() {

        $id = $this->uri->segment(4, 0);
        $search = $this->input->post('key');
        if (!$id) {
            $id = 6;
        }
        parse_str($_SERVER['QUERY_STRING'], $_GET);
        $this->load->model("deptsys_model");
        $sqlStr = "id = " . $id;
        $deptIdArr = $this->deptsys_model->get_dept_child_id($sqlStr);
        $where_in = $deptIdArr;

        // print_r($result);
        $where = "del_show = 0 and enabled = 1";

        if ($search) {
            if ($id == 0) {
                $where = "itname like '%" . $search . "%'";
            } else {
                $where .= " and itname like '%" . $search . "%'";
            }
        }
        //echo $where;
        $data['stafftemp'] = $this->tongxun_model->get_staffs_where_in(100, $this->uri->segment(5, 0), $where, $where_in);
        $staffNumber = $this->tongxun_model->get_staffs_where_in('', '', $where, $where_in);
        //print_r($data['staffs']);
        // 读取用户AD状态
        if ($data['stafftemp']) {
            foreach ($data['stafftemp'] as $row) {
                /* foreach ($result as $row) {
                  $addreeInfo = $this->tongxun_model->staffs_addree_row("itname = '".$row->itname."'");

                  }
                 * 
                 */
                $this->load->model("deptsys_model"); // load deptinfo
                $dept = $this->deptsys_model->get_dept_val("id = " . $row->rootid);
                if ($dept) {
                    $ouTemp = $this->deptsys_model->get_dept_child_DN('id = ' . $row->rootid);
                    if ($ouTemp) {
                        $row->deptOu = implode("&raquo;", $ouTemp);
                    } else {
                        $row->deptOu = "";
                    }
                    $row->deptname = $dept->deptName;
                } else {
                    $row->deptOu = "";
                    $row->deptname = "暂无";
                }
                $addreeInfo = $this->tongxun_model->staffs_addree_row("itname = '" . $row->itname . "'");

                if ($addreeInfo) {
                    $row->address = $addreeInfo;
                } else {
                    $row->address = '';
                }
                $data['staffs'][] = $row;
            }
        } else {
            $data['staffs'][] = '';
        }
        //print_r($data['staffs']);
        $linkUrl = "tongxun/tongxun/stafflist/" . $id . "/";
        $linkNumber = count($staffNumber);
        $uri_segment = 5;
        $data['links'] = $this->pagination($linkUrl, $linkNumber, $uri_segment, $where);
        $sss = str_replace('href', 'ajaxhref', $data['links']);
        // $this->load->view('staffLayout', $data);
        $this->cismarty->assign("id", $id);
        $this->cismarty->assign("data", $data['staffs']);
        $this->cismarty->assign("links", $sss);
        $this->cismarty->display($this->sysconfig_model->templates() . '/tongxun/stafflist.tpl');
    }

    function publiclist() {
        //echo "sdf";
        $data = $this->tongxun_model->publicResult();
        $this->cismarty->assign("data", $data);
        $this->cismarty->display($this->sysconfig_model->templates() . '/tongxun/publiclist.tpl');
    }

    function publicAdd() {
        //echo "sdf";

        $this->cismarty->display($this->sysconfig_model->templates() . '/tongxun/publicAdd.tpl');
    }

    function publicAddDo() {
        //echo "sdf";

        $data['sap_name'] = $this->input->post('sap_name');
        $data['sap_sort'] = $this->input->post('sap_sort');
        $data['sap_info'] = $this->input->post('sap_info');
        if ($this->tongxun_model->publicInster($data)) {
            echo 'ok';
        } else {
            return FALSE;
        }
    }

    function publicEdit() {
        //echo "sdf";
        $sap_id = $this->uri->segment(4, 0);
        $data = $this->tongxun_model->publicRow('sap_id = ' . $sap_id);
        // print_r($data);
        $this->cismarty->assign("data", $data);
        $this->cismarty->display($this->sysconfig_model->templates() . '/tongxun/publicEdit.tpl');
    }

    function publicEditDo() {
        //echo "sdf";
        $sap_id = $this->input->post('sap_id');
        $data['sap_name'] = $this->input->post('sap_name');
        $data['sap_sort'] = $this->input->post('sap_sort');
        $data['sap_info'] = $this->input->post('sap_info');
        if ($this->tongxun_model->publicEdit($sap_id, $data)) {
            echo 'ok';
        } else {
            return FALSE;
        }
    }

    function publicDel() {
        //echo "sdf";
        $sap_id = $this->input->post('id');

        if ($this->tongxun_model->del_public($sap_id)) {
            echo 'ok';
        } else {
            return FALSE;
        }
    }

    function staffmodify() {

        $staff = '';
        $result = $this->staff_model->get_staff_by("staff_main.id = " . $this->uri->segment(4));
        $addreeInfo = $this->tongxun_model->staffs_addree_row("itname = '" . $result->itname . "'");
        if ($addreeInfo) {
            $addreeInfo = $this->tongxun_model->staffs_addree_row("itname = '" . $result->itname . "'");
        } else {
            $inDate['itname'] = $result->itname;
            $inDate['sa_mobile'] = $result->mobtel;
            $this->tongxun_model->insert_address($inDate);
            $addreeInfo = $this->tongxun_model->staffs_addree_row("itname = '" . $result->itname . "'");
        }
        $addressRose = $this->tongxun_model->address_rose_result("");
        // print_r($addressRose);
        $_SESSION['modify'] = true;
        // load menu start
        // $data['menu'] = $this->staff_model->get_all();
        // load menu end
        $this->cismarty->assign('menuUrl', array('staff', 'index'));
        $this->cismarty->assign("addressRose", $addressRose);
        $this->cismarty->assign("addreeInfo", $addreeInfo);
        $this->cismarty->assign("staff", $result);
        $this->cismarty->display($this->sysconfig_model->templates() . '/tongxun/staffmodify.tpl');
        // $this->load->view('staff', $data);
    }

    function staffmodifycomplete() {

        $data['itname'] = $this->input->post('itname');
        $addreeInfo = $this->tongxun_model->staffs_addree_row("itname = '" . $data['itname'] . "'");
        if ($addreeInfo) {
            $data['sa_code'] = $this->input->post('sa_code');
            $data['sa_tel'] = $this->input->post('sa_tel');
            $data['sa_tel_short'] = $this->input->post('sa_tel_short');
            $data['sa_mobile'] = trim($this->input->post('sa_mobile'));
            $data['sa_email'] = $this->input->post('sa_email');
            $data['sa_address'] = $this->input->post('sa_address');
            $data['sa_market'] = $this->input->post('sa_market');
            $data['sar_level'] = $this->input->post('staff_level');
            $data['sa_uptime'] = date('Y-m-d h:i:s');
            $this->tongxun_model->edit_address($data);
            echo 'ok';
        } else {
            return FALSE;
        }
    }

    function staffAllJason() {
        $staffinfo = $this->staff_model->get_staffs_jason();
        //print_r($staffinfo);
        $stafflist = array();

        foreach ($staffinfo as $row) {

            $stafftemp['label'] = $row->itname;

            // print_r($ouTemp); '.$ouTemp[0]. '
            $stafftemp['value'] = $row->cname . ' ' . $row->station . ' ' . @$row->deptName;
            $stafflist[] = $stafftemp;
        }
        // print_r($staffinfo);
        // $stafflist ='{"val":"ss","sdf"}';  
        echo json_encode($stafflist);
    }

    function staffdisable() {

        $id = $this->input->post('id');
        $staffinfo = $this->staff_model->get_staff_by("id = " . $id);

        $data['id'] = $id;
        $data['enabled'] = 0;
        $msg = $this->staff_model->edit($data);
        //  echo 'appstore'. $staffinfo->appstore;
        //   exit();
        if ($msg) {
            ///// set api data /////////////////////////////
            $api['itname'] = $staffinfo->itname;
            $api['msText'] = "禁用";
            $api['state'] = 0;
            $api['msType'] = 1; //  //  0 权限，1 禁用，2 开启，3 删除，4 部门异动
            $this->staff_model->upsystem_api($api); // 写入 API表
            ///// set api data /////////////////////////////
            if (in_array("ad", explode(',', $staffinfo->appstore))) {  // 判断推送系统 $postdata["uptype"]
                $this->load->library('adldaplibrary');
                $adldap = new adLDAP();
                $result = $adldap->user()->disable($staffinfo->itname);
                //print_r($result);
                if ($result) {
                    //echo 3; // 写数据库 / AD 成功
                    echo "ok";
                } else {
                    echo "写数据库成功/写AD失败！";
                }
            }
        } else {
            echo "写数据库失败！"; // 写数据库失败成功
        }
    }

    function staffenabled() {

        $id = $this->input->post('id');
        $staffinfo = $this->staff_model->get_staff_by("id = " . $id);

        $data['id'] = $id;
        $data['enabled'] = 1;
        $msg = $this->staff_model->edit($data);
        //  echo 'appstore'. $staffinfo->appstore;
        //  exit();
        if ($msg) {
            ///// set api data /////////////////////////////
            $api['itname'] = $staffinfo->itname;
            $api['msText'] = "开启";
            $api['state'] = 0;
            $api['msType'] = 2; //  0 权限，1 禁用，2 开启，3 删除，4 部门异动
            $this->staff_model->upsystem_api($api); // 写入 API表
            ///// set api data /////////////////////////////
            if (in_array("ad", explode(',', $staffinfo->appstore))) {  // 判断推送系统 $postdata["uptype"]
                $this->load->library('adldaplibrary');
                $adldap = new adLDAP();
                $result = $adldap->user()->enable($staffinfo->itname);

                if ($result) {
                    //echo 3; // 写数据库 / AD 成功
                    echo "ok";
                } else {
                    echo "写数据库成功/写AD失败！";
                }
            }
        } else {
            echo "写数据库失败！"; // 写数据库失败成功
        }
    }

    function staff_system() {

        $id = $this->uri->segment(4, 0);
        $search = $this->input->post('searchText');
        if (!$id) {
            $id = 0;
        }
        ////检查api 临时表 及 读取 业务系统权限  开始  /////////////
        //检查本系统api表
        $apiSql = "state = 1";
        $this->load->model("imsapi_model"); // load deptinfo
        $result = $this->imsapi_model->system_api_check($apiSql);
        if ($result) {
            $result = $this->imsapi_model->load_system_api_del($apiSql);
        }
        ////检查业务系统 ////////////
        header("content-type:text/html;charset=utf-8");
        $this->load->library('xmlrpc');
        $this->load->library('Nusoap');
        $NusoapWSDL = "http://10.90.18.75:8012/Pages/webservice/WSuserrights.asmx?WSDL"; /// http://ums.zj165.com:8888/sms_hb/services/Sms?wsdl"; //http://10.90.18.75:8016/Pages/webservice/WSuserrights.asmx?WSDL
        $nusoap_client = new SoapClient($NusoapWSDL);
        $nusoap_client->soap_defencoding = 'utf-8';
        $nusoap_client->decode_utf8 = false;
        $nusoap_client->xml_encoding = 'utf-8';
        $result2 = $nusoap_client->GetUserUpdate();
        //print_r($result2);
        if ($result2) {
            //  print_r($result2);
            //  echo $result2->GetUserUpdateResult;
            $this->imsapi_model->api_up_yewu($result2->GetUserUpdateResult);
        } else {
            echo 'Null';
        }
        /// 检查api 临时表 及 读取 业务系统权限 结束  //////////////  
        //
        //
        // $this->load->view('staffLayout', $data);
        $this->cismarty->assign("id", $id);
        $this->cismarty->display($this->sysconfig_model->templates() . '/staff/staff_system.tpl');
    }

    function staff_system_list() {

        $id = $this->uri->segment(4, 0);
        $search = $this->input->post('key');
        if (!$id) {
            $id = 0;
        }
        parse_str($_SERVER['QUERY_STRING'], $_GET);
        $where = "rootid = " . $id;

        if ($search) {
            if ($id == 0) {
                $where = "itname like '%" . $search . "%'";
            } else {
                $where .= " and itname like '%" . $search . "%'";
            }
        }
        //echo $where;
        $data['stafftemp'] = $this->staff_model->get_staffs(100, $this->uri->segment(5, 0), $where);
        //print_r($data['staffs']);
        // 读取用户AD状态
        if ($data['stafftemp']) {
            foreach ($data['stafftemp'] as $row) {
                // load dept
                $this->load->model("deptsys_model"); // load deptinfo
                $dept = $this->deptsys_model->get_dept_val("id = " . $row->rootid);
                if ($dept) {
                    $row->deptname = $dept->deptName;
                } else {
                    $row->deptname = "暂无";
                }
                // load system
                $system_id = explode(',', $row->system_id);
                if ($system_id) {
                    for ($i = 0; $i < count($system_id); $i++) {
                        //  echo $system_id[$i];
                        $sysTemp = $this->staff_model->get_system_by("keynumber = " . (int) $system_id[$i] . "");
                        if ($sysTemp) {
                            $row->systeminfo[] = $sysTemp->sysName;
                        } else {
                            $row->systeminfo[] = '';
                        }
                    }
                } else {
                    $row->systeminfo[] = array();
                }
                $data['staffs'][] = $row;
            }
        } else {
            $data['staffs'] = "";
        }

        // print_r($data['staffs']);
        $linkUrl = "staff/staff/staff_system_list/" . $id . "/";
        $linkModel = "get_num_rows";
        $uri_segment = 5;
        $data['links'] = $this->pagination($linkUrl, $linkModel, $uri_segment, $where);

        // $this->load->view('staffLayout', $data);
        $this->cismarty->assign("id", $id);
        $this->cismarty->assign("data", $data['staffs']);
        $this->cismarty->assign("links", $data['links']);
        $this->cismarty->display($this->sysconfig_model->templates() . '/staff/staff_system_list.tpl');
    }

    function cut_str($string, $sublen, $start = 0, $code = 'UTF-8') {
        if ($code == 'UTF-8') {
            $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
            preg_match_all($pa, $string, $t_string);

            if (count($t_string[0]) - $start > $sublen)
                return join('', array_slice($t_string[0], $start, $sublen)) . "";
            return join('', array_slice($t_string[0], $start, $sublen));
        }
        else {
            $start = $start * 2;
            $sublen = $sublen * 2;
            $strlen = strlen($string);
            $tmpstr = '';

            for ($i = 0; $i < $strlen; $i++) {
                if ($i >= $start && $i < ($start + $sublen)) {
                    if (ord(substr($string, $i, 1)) > 129) {
                        $tmpstr.= substr($string, $i, 2);
                    } else {
                        $tmpstr.= substr($string, $i, 1);
                    }
                }
                if (ord(substr($string, $i, 1)) > 129)
                    $i++;
            }
            if (strlen($tmpstr) < $strlen)
                $tmpstr.= "...";
            return $tmpstr;
        }
    }

    function get_staff_id() {
        $data = array();
        foreach ($_POST as $key => $v)
            $data[$key] = $v;
        if ($this->input->post('is_verified'))
            array_pop($data);
        if ($this->input->post('class_id'))
            array_pop($data);
        if ($this->input->post('recover'))
            array_pop($data);
        if ($this->input->post('submit'))
            array_pop($data);
        if (count($data)) {
            return $data;
        } else {
            return false;
        }
    }

}
