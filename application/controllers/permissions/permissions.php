<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Permissions extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->dx_auth->check_uri_permissions();
        $this->load->model('staff_model');
        $this->load->library('api_eyou');
        $this->sysconfig_model->sysInfo(); // set sysInfo
        $this->sysconfig_model->set_sys_permission(); // set controller permission

        $this->load->model('permissions_model');

        $this->mainmenu_model->showMenu();
        $menuCurrent = $this->showConMenu();
        $this->cismarty->assign("menuController", $menuCurrent);
        $this->cismarty->assign("urlF", $this->uri->segment(2));
        $this->cismarty->assign("urlS", $this->uri->segment(3));
        $this->cismarty->assign("pageTitle", '用户权限 - ');
    }

    function pagination($linkUrl, $linkModel, $uri_segment, $condition = "") {
        $this->load->library('pagination');
        $config['base_url'] = site_url($linkUrl);
        $config['total_rows'] = $this->staff_model->$linkModel($condition);
        $config['per_page'] = 30;
        $config['uri_segment'] = $uri_segment;
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }

    function showConMenu() {
        $showmenu = NULL;
        $showmenu .= "<li><a href=" . site_url("permissions/permissions") . " >用户权限</a></li>";
        $showmenu .= "<li><a href=" . site_url("permissions/permissions/staff_system_scrap") . " >历史权限</a></li>";
        $showmenu .= "<li><a href=" . site_url("permissions/permissions/staff_permission_dg_sync") . " >加密岗位、密级同步</a></li>";
        return $showmenu;
    }

    function index() {
        $this->staff_system();
    }

    function load_dg() {
        $dg_quarters = $this->permissions_model->get_dg_quarters();
        $dg_doctype = $this->permissions_model->get_dg_doctype();
        $this->cismarty->assign("quarters", $dg_quarters);
        $this->cismarty->assign("doctype", $dg_doctype);
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

        //
        //
        // $this->load->view('staffLayout', $data);
        $this->cismarty->assign("id", $id);
        //   echo $this->sysconfig_model->templates();
        $this->cismarty->display($this->sysconfig_model->templates() . '/permissions/staff_system.tpl');

        exit();
        ////检查业务系统 ////////////
        //  header("content-type:text/html;charset=utf-8");

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
    }

    function staff_system_list() {
        $this->load_dg();
        $id = $this->uri->segment(4, 0);
        $search = $this->input->post('key');
        if (!$id) {
            $id = 0;
        }
        parse_str($_SERVER['QUERY_STRING'], $_GET);
        $where = "rootid = " . $id;
        if ($search) {
            if ($id == 0) {
                $where = "itname like '%" . $search . "%' or cname like  '%" . $search . "%' ";
            } else {
                $where .= " and itname like '%" . $search . "%' or cname like  '%" . $search . "%' ";
            }
        }
        //echo $where;
        $data['stafftemp'] = $this->staff_model->get_staffs(100, $this->uri->segment(5, 0), $where);
        //print_r($data['staffs']);
        // 读取用户AD状态
        if ($data['stafftemp']) {
            foreach ($data['stafftemp'] as $row) {
                // load staff dg
                $sg = $this->permissions_model->staff_dg_join_row("itname = '" . $row->itname . "'");
                if ($sg) {
                    $row->dg_info = $sg->quarters_name . "-" . $sg->doctype_name;
                } else {
                    $row->dg_info = '无加密权限信息';
                }

                // load dept
                $this->load->model("deptsys_model"); // load deptinfo
                $dept = $this->deptsys_model->get_dept_val("id = " . $row->rootid);
                if ($dept) {
                    $row->deptname = $dept->deptName;
                } else {
                    $row->deptname = "暂无";
                }
                // load IP
                $this->load->model("sms_model");
                $smsIp = $this->sms_model->staff_sms_by("itname = '" . $row->itname . "' and sms_ip <> '' and sms_number <> '' and sm_status =1 ");
                if ($smsIp) {
                    $row->sms_ip = $smsIp->sms_ip;
                } else {
                    $row->sms_ip = "--";
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
                // load OA 历史记录 
                $oaList = $this->permissions_model->get_staffs_oa_top("itname = '" . $row->itname . "'");
                if ($oaList) {
                    $row->oa_list = 1;
                } else {
                    $row->oa_list = 0;
                }

                $data['staffs'][] = $row;
            }
        } else {
            $data['staffs'] = "";
        }

        // print_r($data['staffs']);
        $linkUrl = "permissions/permissions/staff_system_list/" . $id . "/";
        $linkModel = "get_num_rows";
        $uri_segment = 5;
        $data['links'] = $this->pagination($linkUrl, $linkModel, $uri_segment, $where);

        // $this->load->view('staffLayout', $data);
        $this->cismarty->assign("id", $id);
        $this->cismarty->assign("data", $data['staffs']);
        $this->cismarty->assign("links", $data['links']);
        $this->cismarty->display($this->sysconfig_model->templates() . '/permissions/staff_system_list.tpl');
    }

    function staff_system_scrap() {

        $search = $this->input->post('key');
        if ($search) {
            $where = "itname like '%" . $search . "%' or cname like  '%" . $search . "%' ";
        } else {
            $where = '';
        }

        //echo $where;
        $data['stafftemp'] = $this->staff_model->get_staffs_scrap(0, 0, $where);
        //print_r($data['staffs']);
        // 读取用户AD状态
        if ($data['stafftemp']) {
            foreach ($data['stafftemp'] as $row) {

                // load staff dg
                $sg = $this->permissions_model->staff_dg_join_row("itname = '" . $row->itname . "'");
                if ($sg) {
                    $row->dg_info = $sg->quarters_name . "-" . $sg->doctype_name;
                } else {
                    $row->dg_info = '无加密权限信息';
                }

                // load dept
                $this->load->model("deptsys_model"); // load deptinfo
                $dept = $this->deptsys_model->get_dept_val("id = " . $row->rootid);
                if ($dept) {
                    $row->deptname = $dept->deptName;
                } else {
                    $row->deptname = "暂无";
                }
                // load IP
                $this->load->model("sms_model");
                $smsIp = $this->sms_model->staff_sms_by("itname = '" . $row->itname . "' and sms_ip <> '' ");
                if ($smsIp) {
                    $row->sms_ip = $smsIp->sms_ip;
                } else {
                    $row->sms_ip = "--";
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
        // $this->load->view('staffLayout', $data);
        // $this->cismarty->assign("id", $id);
        $this->cismarty->assign("data", $data['staffs']);
        // $this->cismarty->assign("links", $data['links']);
        $this->cismarty->display($this->sysconfig_model->templates() . '/permissions/staff_system_list_scrap.tpl');
    }

    function systemedit() {
        $this->load_dg();
        $data['action'] = "edit";
        $staff = $this->staff_model->get_staff_by("id = " . $this->input->post('id'));
        $sg = $this->permissions_model->staff_dg_row("itname = '" . $staff->itname . "'");
        // print_r($sg);
        if ($sg) {
            $staff->quarters_id = $sg->quarters_id;
            $staff->doctype_id = $sg->doctype_id;
        } else {
            $staff->quarters_id = 1;
            $staff->doctype_id = 0;
        }
        // print_r($staff);

        $_SESSION['modify'] = true;
        $data['system1'] = $this->staff_model->get_systems('', '', 'type = 1');
        $data['system2'] = $this->staff_model->get_systems('', '', 'type = 2');
        $data['system3'] = $this->staff_model->get_systems('', '', 'type = 3');
        $data['system4'] = $this->staff_model->get_systems('', '', 'type = 4');
        $data['system5'] = $this->staff_model->get_systems('', '', 'type = 5');
        $data['system6'] = $this->staff_model->get_systems('', '', 'type = 6');
        $data['system7'] = $this->staff_model->get_systems('', '', 'type = 7');
        $data['system8'] = $this->staff_model->get_systems('', '', 'type = 8');
        $data['systemf'] = $this->staff_model->get_systems('', '', 'type = 999');
        // load menu end
        $this->cismarty->assign("systemf", $data['systemf']);
        $this->cismarty->assign("system1", $data['system1']);
        $this->cismarty->assign("system2", $data['system2']);
        $this->cismarty->assign("system3", $data['system3']);
        $this->cismarty->assign("system4", $data['system4']);
        $this->cismarty->assign("system5", $data['system5']);
        $this->cismarty->assign("system6", $data['system6']);
        $this->cismarty->assign("system7", $data['system7']);
        $this->cismarty->assign("system8", $data['system8']);
        $this->cismarty->assign("staff", $staff);
        $this->cismarty->display($this->sysconfig_model->templates() . '/permissions/staff_systemedit.tpl');
        // $this->load->view('staff', $data);
    }

    function systemView() {
        $this->load_dg();
        $data['action'] = "edit";
        $staff = $this->staff_model->get_staff_by("id = " . $this->input->post('id'));
        $sg = $this->permissions_model->staff_dg_row("itname = '" . $staff->itname . "'");
        //  print_r($sg);
        if ($sg) {
            $staff->quarters_id = $sg->quarters_id;
            $staff->doctype_id = $sg->doctype_id;
        } else {
            $staff->quarters_id = 1;
            $staff->doctype_id = 0;
        }
        //print_r($staff);
        $_SESSION['modify'] = true;
        $data['system1'] = $this->staff_model->get_systems('', '', 'type = 1');
        $data['system2'] = $this->staff_model->get_systems('', '', 'type = 2');
        $data['system3'] = $this->staff_model->get_systems('', '', 'type = 3');
        $data['system4'] = $this->staff_model->get_systems('', '', 'type = 4');
        $data['system5'] = $this->staff_model->get_systems('', '', 'type = 5');
        $data['system6'] = $this->staff_model->get_systems('', '', 'type = 6');
        $data['system7'] = $this->staff_model->get_systems('', '', 'type = 7');
        $data['system8'] = $this->staff_model->get_systems('', '', 'type = 8');
        $data['systemf'] = $this->staff_model->get_systems('', '', 'type = 999');
        // load menu end
        $this->cismarty->assign("systemf", $data['systemf']);
        $this->cismarty->assign("system1", $data['system1']);
        $this->cismarty->assign("system2", $data['system2']);
        $this->cismarty->assign("system3", $data['system3']);
        $this->cismarty->assign("system4", $data['system4']);
        $this->cismarty->assign("system5", $data['system5']);
        $this->cismarty->assign("system6", $data['system6']);
        $this->cismarty->assign("system7", $data['system7']);
        $this->cismarty->assign("system8", $data['system8']);
        $this->cismarty->assign("staff", $staff);
        $this->cismarty->display($this->sysconfig_model->templates() . '/permissions/staff_systemView.tpl');
        // $this->load->view('staff', $data);
    }

    function staff_systemedit_save() {
        $data['id'] = $this->input->post('id');
        if (@$_POST['system_id']) {
            $systemp = $_POST['system_id'];
            $data['system_id'] = implode(',', $systemp);
        } else {
            $systemp = array();
            $data['system_id'] = "";
        }

        // print_r($data);
        $msg = $this->staff_model->edit($data);   // 更新用户权限
        //
        // ///////////////////更新同步临时表 staff_system_api /////////////
        $where = 'id = ' . $data['id'];
        $result = $this->staff_model->get_staff_by($where); // 获取 staff info
        // //更新eyou /////
        //  print_r($systemp);
        if (in_array("41", $systemp)) {
            //  echo 'you';
        } else {
            //   echo "mei";
        }
        //  exit();
		//print_r($systemp);
        if (in_array("41", $systemp)) {
            print_r($this->api_eyou->user_edit($result->itname, 'has_remote', 1));
        } else {
            print_r($this->api_eyou->user_edit($result->itname, 'has_remote', 0));
        }
        if (in_array("42", $systemp)) {
            print_r($this->api_eyou->user_edit($result->itname, 'has_pop', 1));
        } else {
            print_r($this->api_eyou->user_edit($result->itname, 'has_pop', 0));
        }
		
        if ($data['system_id']) {

            $system_code = array();
            foreach ($systemp as $key) {
                $this->load->model("deptsys_model"); // load deptinfo
                $where = "FIND_IN_SET('" . $key . "', ss_key) ";
                if ($sysCode = $this->staff_model->get_system_code($where)) {
                    $system_code[] = $sysCode->code;
                }
            }
            $msText = implode(',', $system_code);
        } else {
            $msText = '';
        }
        $api['itname'] = $result->itname;
        $api['msText'] = $msText;
        $api['msType'] = 0;
        $api['state'] = 0;
        $this->staff_model->upsystem_api($api); // 写入 API表
        // 更新同步临时表 staff_system_api //////////////////////////////////////////
        // 
        // 
        /////update staff_dg ////
        $dg['itname'] = $result->itname;
        $dg['quarters_id'] = $this->input->post('quarters_id');
        $dg['doctype_id'] = $this->input->post('doctype_id');
        $dg['op_user'] = $this->session->userdata('DX_username');
        $sg = $this->permissions_model->staff_dg_row("itname = '" . $result->itname . "'");
        if ($sg) {
            $this->permissions_model->staff_dg_edit($dg);
        } else {
            $this->permissions_model->staff_dg_add($dg);
        }
        ///// 同步 到 DG系统
        $quarters = $this->dg_curl($result->itname . "@semir.cn&quartersid=" . $dg['quarters_id'] . "&doctypeid=" . $dg['doctype_id'], 'set_user_info');
        
		foreach ($quarters as $row) {
          //  var_dump($row);
            if ($row->error == 200) {
                echo 1;
            } else {
                var_dump($row);
                echo 2;
            }
        }
        ////

        if ($msg) {
            
        } else {
            echo 0;
        }
        $log['ul_title'] = "用户权限修改";
        $log['ul_function'] = json_encode($dg);
        $this->saveUserLog($log);
    }

    function del() {

        if ($staff_id = $this->input->post('id')) {
            $data['id'] = $staff_id;
            if ($msg = $this->staff_model->del($data)) {
                echo $msg;
            } else {
                echo "删除操作失败,原因可能是当前记录不存在！";
            }
        }
    }

    function tempLoadSystem() {
        // 数组导入专用
        $this->authorization->check_permission($this->uri->segment(2), '4');
        $result = $this->staff_model->get_temps('', '', '');
        foreach ($result as $row) {
            echo $row->system_id;
//            $data['id'] = $row->id;
//            $data['surname'] = ''; // $this->cut_str($row->cname, 1, 0, 'UTF-8');
//            $data['firstname'] = ''; //$this->cut_str($row->cname, 10, 1, 'UTF-8');;
//            $this->staff_model->edit($data);
            $staff = $this->staff_model->get_staff_by("itname = '" . $row->itname . "'");
            if ($staff) {
                $data['id'] = $staff->id;

                /* //load user cname
                  echo $row->cname;
                  echo '/';
                  echo $this->cut_str($row->cname, 10, 1, 'UTF-8');
                  $data['cname'] = $row->cname;
                  $data['firstname'] = $this->cut_str($row->cname, 10, 1, 'UTF-8');
                  $data['surname'] = $this->cut_str($row->cname, 1, 0, 'UTF-8');; // $this->cut_str($row->cname, 1, 0, 'UTF-8');
                  $msg = $this->staff_model->edit($data);
                  //echo $data['firstname'];
                 */
                /*                 * * */
                // load system
                $system_id = explode(',', $staff->system_id);

                if (in_array($row->system_id, $system_id)) {
                    echo "sss";
                } else {
                    $system_id[] = $row->system_id;
                    $tempId = $system_id;
                    echo $row->system_id;
                    echo implode(',', $tempId) . "<br>";
                    $data['system_id'] = implode(',', $tempId);
                    $this->staff_model->edit($data);
                }

                //
            }
        }
    }

    function tempLoad() {
        // 数组导入专用
        $this->authorization->check_permission($this->uri->segment(2), '4');
        $result = $this->staff_model->get_temps('', '', '');

        foreach ($result as $row) {

            $staff = $this->staff_model->get_staff_by("cname = '" . $row->itname . "'");
            if ($staff) {

                $data['sm_id'] = $staff->id;

                echo $staff->itname;
                //   echo '/';

                $data['itname'] = $staff->itname;
                $this->staff_model->editTemp($data);
            } else {
                //  echo $row->itname;
            }
        }
    }

    function stafftemp() {

        $renzi = $this->db->query("SELECT * FROM staff_temp_renzi "); //from('staff_temp');where itname=''
        $temp = $this->db->query("SELECT * FROM staff_temp");
        $system = $this->db->query("SELECT * FROM staff_main");
        // print_r($renzi->result());
        $i = 0;
        foreach ($system->result() as $row) {
            //echo $row->cname;
            //    echo '<br>';
            $temp = $this->db->query("SELECT * FROM staff_temp_renzi where itname = '" . $row->itname . "'");
            if ($temp->row()) {
                //  print_r($temp->row());
                // str_replace(" ","",$temp->row()->itname);
//            $itname = explode('@',$temp->row()->itname);
//            // echo $row->cname;
//           echo $itname[0].'<br>';
//              $data['itname'] = $itname[0];
//               $this->db->where('cname',$row->cname);
//  	     $this->db->update('staff_temp_renzi', $data);
            } else {
                echo $row->cname . $row->itname;
                echo '<br>';
                $i++;
            }
            // echo $row->cname."<br>";   
        }
        echo $i;
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

    function multi_del() {
        $this->authorization->check_permission($this->uri->segment(2), '4');
        if ($data = $this->get_staff_id()) {
            if ($msg = $this->staff_model->multi_del($data)) {
                $this->view();
            } else {
                show_error("删除操作失败,原因可能是当前记录不存在！");
            }
        }
    }

    function physical_del() {
        $this->authorization->check_permission($this->uri->segment(2), '4');
        if ($data = $this->get_staff_id()) {
            if ($this->staff_model->physical_del($data)) {
                //$this->view();
                echo "ok";
            } else {
                show_error("删除操作失败,原因可能是当前记录不存在！");
            }
        }
    }

    function staff_system_oa_list() {
        $itname = $this->input->post('itname');
        if ($itname) {
            // load OA 历史记录 
            $oaList = $this->permissions_model->get_staffs_oa_list("itname = '" . $itname . "'");
            if ($oaList) {
                $this->cismarty->assign("data", $oaList);
                $this->cismarty->display($this->sysconfig_model->templates() . '/permissions/staff_system_oa_list.tpl');
            } else {
                echo "无记录！！";
            }
        } else {
            echo "请输入正确的用户账号！！！";
        }
    }

    function staff_permission_dg_sync() {

        $data['dg_quarters'] = $this->permissions_model->get_dg_quarters('');
        $data['dg_doctype'] = $this->permissions_model->get_dg_doctype('');

        $this->cismarty->assign("data", $data);
        $this->cismarty->display($this->sysconfig_model->templates() . '/permissions/staff_permission_dg_sync.tpl');
    }

    function staff_permission_dg_sync_true() {
        /// sync quarters
        $quarters = $this->dg_curl('all', 'get_quarters_info');
        foreach ($quarters as $row) {
            $data['quarters_id'] = $row->ID;
            $data['quarters_name'] = $row->NAME;
            $temp = $this->permissions_model->get_dg_quarters_row('quarters_id = ' . $row->ID);
            if ($temp) {
                $this->permissions_model->dg_quarters_edit($data);
            } else {
                $this->permissions_model->dg_quarters_add($data);
            }
        }
        /// sync doctype
        $doctype = $this->dg_curl('all', 'get_doctype_info');
        foreach ($doctype as $row) {
            $datad['doctype_id'] = $row->ID;
            $datad['doctype_name'] = $row->NAME;
            $temp = $this->permissions_model->get_dg_doctype_row('doctype_id = ' . $row->ID);
            if ($temp) {
                $this->permissions_model->dg_doctype_edit($datad);
            } else {
                $this->permissions_model->dg_doctype_add($datad);
            }
        }
    }

    /*     * *
     * 初始化同步用户的所有权限
     */

    function staff_permission_dg_user_sync_true() {
        /// sync quarters
        $staff = $this->staff_model->get_staffs(0, 0, '');
        // print_r($staff->itname);
        foreach ($staff as $row1) {

            $quarters = $this->dg_curl($row1->itname . '@semir.cn', 'get_user_quarters_doctype_info');

            foreach ($quarters as $row) {
                // var_dump($row);
                if ($row->error == 1) {
                    $data['itname'] = $row1->itname;
                    $data['quarters_id'] = $row->quarters_id;
                    $data['doctype_id'] = $row->doctype_id;
                    $data['op_user'] = 'system';
                    $data['op_time'] = date("Y-m-h H:i:s");
                    $sg = $this->permissions_model->staff_dg_row("itname = '" . $row1->itname . "'");
                    if ($sg) {
                        $this->permissions_model->staff_dg_edit($data);
                    } else {
                        $this->permissions_model->staff_dg_add($data);
                    }
                } else {
                    echo $row1->itname;
                    echo "<br>";
                }
            }
        }
    }

    /*     * *
     * 分离原系统staff 的 dg 记录编号 system_id
     */

    function staff_system_id_sync() {
        /// sync quarters
        $staff = $this->staff_model->get_staffs(0, 0, '');
        // print_r($staff->itname);
        foreach ($staff as $row) {
            $id = explode(",", $row->system_id);
            $nid = array();
            for ($i = 0; $i < count($id); $i++) {
                // echo $id[$i];
                if ($id[$i] > 30) {
                    $nid[] = $id[$i];
                }
            }
            $data['id'] = $row->id;
            $data['system_id'] = implode(",", $nid);
            $msg = $this->staff_model->edit($data);
        }
    }

    function dg_curl($key, $data) {
        $ch = curl_init();
        $timeout = 5;
		//echo $data;
		//echo "<=>".$key;
        curl_setopt($ch, CURLOPT_URL, 'http://10.90.18.38:81/api/GetUserInfo/' . $data . '?loginname=' . $key); //10.90.18.38:81  lizd11
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 获取数据返回  
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true); // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回  
        $output = curl_exec($ch);
        curl_close($ch);
		//print_r($output);
        return json_decode($output);
    }

    /////
    function saveUserLog($data) {
        $data['ul_username'] = $this->session->userdata('DX_username');
        $data['ul_time'] = date('Y-m-d H:i:s');
        $data['ul_model'] = '用户权限管理';
        $this->sysconfig_model->sys_user_log($data);
    }

}
