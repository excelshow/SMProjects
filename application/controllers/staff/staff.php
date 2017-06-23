<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->dx_auth->check_uri_permissions();
        $this->load->model('staff_model');
        $this->load->library('api_eyou');
        $this->sysconfig_model->sysInfo(); // set sysInfo
        $this->sysconfig_model->set_sys_permission(); // set controller permission


        $this->mainmenu_model->showMenu();
        $menuCurrent = $this->showConMenu();
        $this->cismarty->assign("menuController", $menuCurrent);
        $this->cismarty->assign("urlF", $this->uri->segment(2));
        $this->cismarty->assign("urlS", $this->uri->segment(3));
    }

    function eyou() {
        $name = 'lizhendong';
        echo $this->api_eyou->user_edit($name, 'has_pop', 0);
        //$this->api_eyou->user_edit($name, 0, 0);
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
        $showmenu = "";
        $showmenu .= "  <li><a href=" . site_url("staff/staff") . " >基本信息</a></li>
                      <li><a href=" . site_url("staff/staff/dimission") . " >离职处理</a></li>
					  <li><a href=" . site_url("staff/staff/emailconfig") . " >邮箱配置</a></li>";
        return $showmenu;
    }

    function index() {

        $id = $this->uri->segment(4, 0);
        $search = $this->input->post('searchText');
        if (!$id) {
            $id = 0;
        }
        $this->cismarty->assign('menuUrl', array('staff', 'index'));
        $this->cismarty->assign("id", $id);
        //$this->cismarty->assign("data", $data['staffs']);
        // $this->cismarty->assign("links", $data['links']); 
        $this->cismarty->display($this->sysconfig_model->templates() . '/staff/staffLayout.tpl');
    }

    function stafflist() {

        $id = $this->uri->segment(4, 0);
        $search = $this->input->post('key');
        if (!$id) {
            $id = 0;
        }
        parse_str($_SERVER['QUERY_STRING'], $_GET);
        $where = "del_show = 0 and rootid = " . $id;

        if ($search) {
            if ($id == 0) {
                $where = "itname like '%" . $search . "%' or cname like  '%" . $search . "%' ";
            } else {
                $where .= " and itname like '%" . $search . "%' or cname like  '%" . $search . "%' ";
            }
        }
        //echo $where;
        $data['stafftemp'] = $this->staff_model->get_staffs(30, $this->uri->segment(5, 0), $where);
        //print_r($data['staffs']);
        // 读取用户AD状态
        if ($data['stafftemp']) {
            foreach ($data['stafftemp'] as $row) {

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
                $data['staffs'][] = $row;
            }
        } else {
            $data['staffs'] = "";
        }
        //  print_r($data['staffs']);
        $linkUrl = "staff/staff/stafflist/" . $id . "/";
        $linkModel = "get_num_rows";
        $uri_segment = 5;
        $data['links'] = $this->pagination($linkUrl, $linkModel, $uri_segment, $where);
        $sss = str_replace('href', 'ajaxhref', $data['links']);
        // $this->load->view('staffLayout', $data);
        $this->cismarty->assign("id", $id);
        $this->cismarty->assign("data", $data['staffs']);
        $this->cismarty->assign("links", $sss);
        $this->cismarty->display($this->sysconfig_model->templates() . '/staff/stafflist.tpl');
    }

    function staffOut() {
        $id = $this->uri->segment(4, 0);
        $search = $this->input->post('key');
        if (!$id) {
            $id = 6;
        }
        parse_str($_SERVER['QUERY_STRING'], $_GET);
        $model = $this->load->model("deptsys_model");
        $sqlStr = "id = " . $id;
        $deptIdArr = $this->deptsys_model->get_dept_child_id($sqlStr);
        $where_in = $deptIdArr;

        // print_r($result);
        $where = "del_show = 0 and enabled = 1";


        //echo $where;
        $data['stafftemp'] = $this->staff_model->get_staffs_where_in('', '', $where, $where_in);
        $staffNumber = $this->staff_model->get_staffs_where_in('', '', $where, $where_in);
        //print_r($data['staffs']);
        // 读取用户AD状态
        if ($data['stafftemp']) {
            foreach ($data['stafftemp'] as $row) {

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

                $data['staffs'][] = $row;
            }
        } else {
            $data['staffs'][] = '';
        }
        //print_r($data['staffs']);
        // $this->load->view('staffLayout', $data);
        $this->cismarty->assign("staffNumber", count($staffNumber));
        $this->cismarty->assign("data", $data['staffs']);
        $this->cismarty->display($this->sysconfig_model->templates() . '/staff/staffOut.tpl');
    }

    function stafflistBatch() {

        $data = "";
        $t = $this->input->post('t');
        $search = explode(',', $this->input->post('key'));
        //  print_r($search);
        $i = 0;
        foreach ($search as $row) {
            // echo $row;
            if ($row) {

                $where = "staff_main.cname like '%" . trim($row) . "%' or  staff_main.itname like '%" . trim($row) . "%'"; //lizd11 

                $result = $this->staff_model->get_staff_by($where);

                if ($result) {
                    $this->load->model("deptsys_model"); // load deptinfo
                    $dept = $this->deptsys_model->get_dept_val("id = " . $result->rootid);

                    if ($dept) {
                        $ouTemp = $this->deptsys_model->get_dept_child_DN('id = ' . $result->rootid);
                        $result->deptOu = $ouTemp;
                        $result->deptname = $dept->deptName;
                    } else {
                        $result->deptname = "暂无";
                    }
                    $i++;
                    $data[] = $result;
                }
            }
        }
        // print_r($data);
        // $this->load->view('staffLayout', $data); 
        $this->cismarty->assign("total", $i);
        $this->cismarty->assign("data", $data);
        $this->cismarty->display($this->sysconfig_model->templates() . '/staff/stafflistbatch.tpl');
    }

    function appstore() {

        $where = "staff.is_del = 0 ";
        parse_str($_SERVER['QUERY_STRING'], $_GET);
        $where = "";
        $data['stafftemp'] = $this->staff_model->get_staffs(20, $this->uri->segment(4, 0), $where);
        //print_r($data['staffs']);
        // 读取用户AD状态
        foreach ($data['stafftemp'] as $row) {
            $this->load->library('adldaplibrary');
            $row->UserAccountControl = $this->adldaplibrary->UserAccountControl($row->username);
            $data['staffs'][] = $row;
        }
        //print_r($data['staffs']);
        $data['links'] = $this->pagination($where);

        // $this->load->view('staffLayout', $data);
        $this->cismarty->assign("data", $data['staffs']);
        $this->cismarty->assign("links", $data['links']);
        $this->cismarty->display($this->sysconfig_model->templates() . '/staff/staffAppstore.tpl');
    }

    function staffadd() {

        $data['action'] = "add";
        $this->cismarty->assign('menuUrl', array('staff', 'staffadd'));
        $this->cismarty->assign("action", "add");
        $this->cismarty->display($this->sysconfig_model->templates() . '/staff/staffadd.tpl');
        // $this->load->view('staffadd', $data);
    }

    function staffaddinfo() {

        $_SESSION['post'] = true;
        $this->load->helper('string');
        $this->cismarty->assign("password", random_string('alnum',8));
        $this->cismarty->assign("adOuShow", $this->input->post('adOuShow'));
        $this->cismarty->assign("container", $this->input->post('container'));
        //  $this->cismarty->assign("appstore", $this->input->post('appstore'));
        $this->cismarty->assign("rootid", $this->input->post('rootid'));
        $this->cismarty->assign("action", "addinfo");
        $this->cismarty->assign('menuUrl', array('staff', 'staffaddinfo'));
        $this->cismarty->display($this->sysconfig_model->templates() . '/staff/staffaddinfo.tpl');
        // $this->load->view('staffadd', $data);
    }

    function staffaddcomplete() {

        $postdata = $this->get_post();
        // print_r($postdata);
        // news add ;
        if ($_SESSION['post']) { // 防止重复刷新
            $_SESSION['post'] = false;
            $data['rootid'] = $postdata['rootid'];
            $data['appstore'] = implode(',', $this->input->post('appstore'));
            $data['cname'] = trim($this->input->post('surname')) . trim($this->input->post('firstname'));
            $data['username'] = strtolower($this->input->post('logon_name'));
            $data['surname'] = trim($this->input->post('surname'));
            $data['firstname'] = trim($this->input->post('firstname'));
            $data['itname'] = strtolower(trim($this->input->post('logon_name')));
            $data['gender'] = $this->input->post('gender');
            $data['password'] = $this->input->post('password');
            $data['location'] = $this->input->post('location');
            $data['mobtel'] = trim($this->input->post('mobtel'));

            $data['email'] = strtolower(trim($this->input->post('email'))) . "@" . $this->input->post('domain');
            $data['station'] = $this->input->post('station');
            $data['jobnumber'] = trim($this->input->post('jobnumber'));
            $data['enabled'] = 1;
            $data['addtime'] = date('Y-m-d H:i:s');
            $data['modifytime'] = date("Y-m-d H:i:s");
            $msg = $this->staff_model->add($data);
            if ($msg) {
                // add to tongxun
                $tongxun['itname'] = $data['itname'];
                $tongxun['sa_email'] = $this->input->post('email') . "@" . $this->input->post('domain');
                $tongxun['sa_mobile'] = $this->input->post('mobtel');
                $this->load->model('tongxun_model');
                $this->tongxun_model->insert_address($tongxun);
                // add
                if (in_array("eyou", $postdata["appstore"])) {  // 判断推送系统eyou
                    $this->api_eyou->user_add($data['itname'], $data['cname']);
                }

                if (in_array("ad", $postdata["appstore"])) {  // 判断推送系统 $postdata["uptype"]
                    $this->load->library('adldaplibrary');
                    $adldap = new adLDAP();
                    $container = explode(",", $postdata["container"]);
                    $attributes = array(//////////////////////////// 和 ad对应字段名称请查看 src/adLDAP.PHP
                        "username" => $postdata["logon_name"],
                        "logon_name" => $postdata["logon_name"],
                        "firstname" => $postdata["firstname"],
                        "surname" => $postdata["surname"],
                        "display_name" => $postdata["surname"] . $postdata["firstname"],
                        "department" => $postdata["rootid"],
                        "mobile" => $postdata["mobtel"],
                        "office" => $postdata["loction"],
                        "email" => $postdata["email"],
                        "pager" => $postdata["jobnumber"],
                        "title" => $postdata["station"],
                        "container" => $container,
                        "enabled" => 1, // 用户是否禁用
                        "password" => $data['password'],
						"homephone" => $postdata["portnumber"],
                        "change_password" => false,
                    );
                    // print_r($tempad);

                    $result = $adldap->user()->create($attributes);
                    if ($result) {
                        //echo 3; // 写数据库 / AD 成功
                        /* if (in_array("rtx", $postdata["appstore"])) {
                          $this->load->model("rtx_model"); //  RTX
                          $container = explode(",", $postdata["container"]);
                          $olddept = "";
                          $this->rtx_model->userAdd($data['itname'], $data['password'], $data['cname'], $data['gender'], $data['email'], end($container), $olddept);
                          }
                         * */

                        $message = "新加用户成功！";
                    } else {
                        $message = "写数据库成功/写AD失败！";
                    }
                }
                // add user to RTX
            } else {
                $message = "写数据库失败！"; // 写数据库失败成功
            }
        } else {
            $message = "请勿重复刷新！"; // 请勿重复刷新
        }

        $this->cismarty->assign("ShowData", $postdata);
        $this->cismarty->assign("message", $message);
        $this->cismarty->assign('menuUrl', array('staff', 'staffaddinfo'));
        $this->cismarty->display($this->sysconfig_model->templates() . '/staff/staffaddcomplete.tpl');
        // $this->load->view('staffadd', $data);
    }

    function check_logon_name() {
        $logonname = $this->input->post('logonname');
        $id = $this->input->post('id');
        if ($id) {
            $row = $this->staff_model->get_staff_by("itname = '" . $logonname . "' and id <> " . $id);
            if ($row) {
                echo $row->itname;
            } else {
                echo "";
            }
        } else {
            $row = $this->staff_model->get_staff_by("itname = '" . $logonname . "'");
            if ($row) {
                echo $row->itname;
            } else {
                echo "Semir";
            }
        }
    }

    function staffmodify() {

        $data['action'] = "edit";
        $data['staff'] = $this->staff_model->get_staff_by("staff_main.id = " . $this->uri->segment(4));
        $email = explode("@", $data['staff']->email);
        if ($data['staff']->email) {
            $data['staff']->email = $email[0];
            $data['staff']->domain = $email[1];
            $this->load->model('tongxun_model');
            $add = $this->tongxun_model->staffs_addree_row("itname = '" . $data['staff']->itname . "'");
            if ($add) {
                $data['staff']->mobtel = $add->sa_mobile;
            }
        } else {
            $data['staff']->email = "";
            $data['staff']->domain = "";
        }
        //print_r($data['staff']);
        $_SESSION['modify'] = true;
        // load menu start
        // $data['menu'] = $this->staff_model->get_all();
        // load menu end
        $this->cismarty->assign('menuUrl', array('staff', 'index'));
        $this->cismarty->assign("staff", $data['staff']);
        $this->cismarty->display($this->sysconfig_model->templates() . '/staff/staffmodify.tpl');
        // $this->load->view('staff', $data);
    }

    function staffmodifycomplete() {

        $postdata = $this->get_post();
        // print_r($postdata);
        // news add
        //   exit();
        if ($_SESSION['modify']) { // 防止重复刷新
            $_SESSION['modify'] = false;
            $data['id'] = $postdata['id'];
            //  $data['rootid'] = $postdata['rootid'];
            $data['appstore'] = implode(',', $this->input->post('appstore'));
            $data['cname'] = $this->input->post('surname') . $this->input->post('firstname');
            $data['itname'] = strtolower(trim($this->input->post('logon_name')));
            $data['surname'] = trim($this->input->post('surname'));
            $data['firstname'] = trim($this->input->post('firstname'));
            $data['gender'] = $this->input->post('gender');
            $data['password'] = $this->input->post('password');
            $data['location'] = $this->input->post('location');
            $data['mobtel'] = trim($this->input->post('mobtel'));

            $data['email'] = strtolower(trim($this->input->post('email'))) . "@" . $this->input->post('domain');
            $data['station'] = $this->input->post('station');
            $data['jobnumber'] = trim($this->input->post('jobnumber'));
			$data['port_number'] = trim($this->input->post('portnumber'));
            $data['enabled'] = 1;

            $msg = $this->staff_model->edit($data);
            //  $msg = 's';
            if ($msg) {
                // set tongxun
                if (in_array("ad", $postdata["appstore"])) {  // 判断推送系统 $postdata["uptype"]
                    $this->load->library('adldaplibrary');
                    $adldap = new adLDAP();
                    //$container = explode(",", $postdata["container"]);
                    if ($data['password']) {
                        $attributes = array(//////////////////////////// 和 ad对应字段名称请查看 src/adLDAP.PHP
                            "logon_name" => $postdata["logon_name"],
                            "firstname" => $postdata["firstname"],
                            "surname" => $postdata["surname"],
                            "display_name" => $postdata["surname"] . $postdata["firstname"],
                            "department" => $postdata["rootid"],
                            "email" => $postdata["email"],
                            "company" => $postdata["rootid"],
                            "office" => $postdata["location"],
                            "pager" => $postdata["jobnumber"],
                            "title" => $postdata["station"],
							"homephone" => $postdata["portnumber"],
                            //"description"=>$postdata["rootid"],// 描述
                            "enabled" => 1, // 用户是否禁用
                            "password" => $data['password'],
                                //  "change_password" => true,
                        );
                        // echo 'ssdf';
                    } else {
                        $attributes = array(//////////////////////////// 和 ad对应字段名称请查看 src/adLDAP.PHP
                            "logon_name" => $postdata["logon_name"],
                            "firstname" => $postdata["firstname"],
                            "surname" => $postdata["surname"],
                            "display_name" => $postdata["surname"] . $postdata["firstname"],
                            "department" => $postdata["rootid"],
                            "email" => $postdata["email"],
                            "company" => $postdata["rootid"],
                            "office" => $postdata["location"],
                            "pager" => $postdata["jobnumber"],
							"homephone" => $postdata["portnumber"],
                            "title" => $postdata["station"],
                                //"description"=>$postdata["rootid"],// 描述
                                //  "enabled" => 1, // 用户是否禁用
                        );
                        // echo "aaaaa";
                    }
                    // set AD
                    //    print_r($attributes);
                    //  exit();
                    $result = $adldap->user()->modify($postdata['username'], $attributes);
                    //  print_r($result);
                    if ($result) {
                        //echo 3; // 写数据库 / AD 成功
                        if (in_array("rtx", $postdata["appstore"])) {
                            $this->load->model("rtx_model"); //  RTX
                            $container = explode(",", $postdata["container"]); //dept
                            $this->rtx_model->userModify($data['itname'], $data['password'], $data['cname'], $data['gender'], $data['email'], end($container), '');
                        }
                        echo 1; //"编辑用户成功！";
                    } else {
                        echo 2; //"写数据库成功/写AD失败！";
                    }
                }
            } else {
                echo 0; //"写数据库失败！"; // 写数据库失败成功
            }
        } else {
            echo "请勿重复刷新！"; // 请勿重复刷新
        }


        // $this->load->view('staffadd', $data);
    }

    function staffmove() {

        $data['staff'] = $this->staff_model->get_staff_by("id = " . $this->uri->segment(4));
        $email = explode("@", $data['staff']->email);
        if ($data['staff']->email) {
            $data['staff']->email = $email[0];
            $data['staff']->domain = $email[1];
        } else {
            $data['staff']->email = "";
            $data['staff']->domain = "";
        }
        //print_r($data['staff']);
        $_SESSION['move'] = true;
        // load menu start
        // $data['menu'] = $this->staff_model->get_all();
        // load menu end
        $this->cismarty->assign("staff", $data['staff']);
        $this->cismarty->display($this->sysconfig_model->templates() . '/staff/staffmove.tpl');
        // $this->load->view('staff', $data);
    }

    function staffmovecomplete() {

        $postdata = $this->get_post();
        //print_r($postdata)
        $staffinfo = $this->staff_model->get_staff_by("id = " . $postdata['id']);
        if ($_SESSION['move']) { // 防止重复刷新
            $_SESSION['move'] = false;
            $data['id'] = $postdata['id'];
            $data['rootid'] = $postdata['rootid'];
            $msg = $this->staff_model->edit($data);
            if ($msg) {
                ///// set api data /////////////////////////////
                $api['itname'] = $staffinfo->itname;
                $api['msText'] = "部门异动";
                $api['state'] = 0;
                $api['msType'] = 4; //  0 权限，1 禁用，2 开启，3 删除，4 部门异动
                $this->staff_model->upsystem_api($api); // 写入 API表
                ///// set api data /////////////////////////////
                if (in_array("ad", $postdata["appstore"])) {  // 判断推送系统 $postdata["uptype"]
                    $this->load->library('adldaplibrary');
                    $adldap = new adLDAP();
                    $container = explode(",", $postdata["container"]);
                    //  print_r($container);
                    $result = $adldap->user()->move($postdata['username'], $container);
                    // print_r($result);
                    if ($result) {
                        //echo 3; // 写数据库 / AD 成功

                        if (in_array("rtx", $postdata["appstore"])) {
                            $this->load->model("rtx_model"); //  RTX
                            if ($staffinfo->rootid == 0) {
                                $oldeDept = '';
                            } else {
                                $this->load->model("deptsys_model");
                                $deptData = $this->deptsys_model->get_dept_val("id = " . $staffinfo->rootid);
                                $oldeDept = $deptData->deptName;
                            }
                            $container = explode(",", $postdata["container"]); //dept
                            if (end($container) == "Semir") {
                                $Dept = '';
                            } else {
                                $Dept = end($container);
                            }
//                            echo $oldeDept;
//                            echo $Dept;
//                            exit();
                            $this->rtx_model->userMove($postdata['username'], $oldeDept, $Dept);
                        }
                        $message = "编辑用户成功！";
                    } else {
                        $message = "写数据库成功/写AD失败！";
                    }
                }
            } else {
                $message = "写数据库失败！"; // 写数据库失败成功
            }
        } else {
            $message = "请勿重复刷新！"; // 请勿重复刷新
        }

        $this->cismarty->assign("ShowData", $postdata);
        $this->cismarty->assign("staff", $staffinfo);
        $this->cismarty->assign("message", $message);
        $this->cismarty->display($this->sysconfig_model->templates() . '/staff/staffmovecomplete.tpl');
        // $this->load->view('staffadd', $data);
    }

    function staffmovebatch() {


        //print_r($data['staff']);
        $_SESSION['move'] = true;
        // load menu start
        // $data['menu'] = $this->staff_model->get_all();
        // load menu end
        $this->cismarty->assign("rootid", $this->input->post('rootid'));
        $this->cismarty->display($this->sysconfig_model->templates() . '/staff/staffmovebatch.tpl');
        // $this->load->view('staff', $data);
    }

    function staffmoveBatchcomplete() {

        $data['rootid'] = $this->input->post('rootid');
        $data['staff_id'] = $this->input->post('staff_id');
        $data['appstore'] = $this->input->post('appstore');
        $data['container'] = $this->input->post('container');
        $data['adOuShow'] = $this->input->post('adOuShow');

        $search = explode(';', $this->input->post('key'));
        //  print_r($search);
        if ($_SESSION['move']) { // 防止重复刷新
            $_SESSION['move'] = false;
            foreach ($data['staff_id'] as $id) {
                $staffinfo = $this->staff_model->get_staff_by("id = " . $id);

                $staff['id'] = $id;
                $staff['rootid'] = $data['rootid'];
                $msg = $this->staff_model->edit($staff);
                if ($msg) {
                    if (in_array("ad", $data["appstore"])) {  // 判断推送系统 $postdata["uptype"]
                        $this->load->library('adldaplibrary');
                        $adldap = new adLDAP();
                        $container = explode(",", $data["container"]);
                        // print_r($container);
                        $result = $adldap->user()->move($staffinfo->username, $container);
                        // print_r($result);
                        if ($result) {
                            //echo 3; // 写数据库 / AD 成功

                            if (in_array("rtx", $data["appstore"])) {
                                $this->load->model("rtx_model"); //  RTX
                                if ($staffinfo->rootid == 0) {
                                    $oldeDept = '';
                                } else {
                                    $this->load->model("deptsys_model");
                                    $deptData = $this->deptsys_model->get_dept_val("id = " . $staffinfo->rootid);
                                    $oldeDept = $deptData->deptName;
                                }
                                $container = explode(",", $data["container"]); //dept
                                if (end($container) == "Semir") {
                                    $Dept = '';
                                } else {
                                    $Dept = end($container);
                                }
//                            echo $oldeDept;
//                            echo $Dept;
//                            exit();
                                $this->rtx_model->userMove($data['username'], $oldeDept, $Dept);
                            }
                            $message = "编辑用户成功！";
                        } else {
                            $message = "写数据库成功/写AD失败！";
                        }
                    }
                } else {
                    $message = "写数据库失败！"; // 写数据库失败成功
                }
            }
        } else {
            $message = "请勿重复刷新！"; // 请勿重复刷新
        }

        $this->cismarty->assign("message", $message);
        $this->cismarty->display($this->sysconfig_model->templates() . '/staff/staffmovebatchcomplete.tpl');
        // $this->load->view('staffadd', $data);
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

    /*
     * 员工离职处理。。。。。
     */

    function staffdisable() {

        $id = $this->input->post('id');
        $staffinfo = $this->staff_model->get_staff_by("id = " . $id);
        $data['id'] = $id;
        $data['enabled'] = 0;

        //判断是否有资产
        $this->load->model('sms_model');
        $itname = $staffinfo->itname;
        $sms = $this->sms_model->staff_sms_by("itname = '" . $itname . "' and sm_status = 1");
        if ($sms) {
            echo "此员工还有资产没有退回！！";
            exit;
        }

        $msg = $this->staff_model->edit($data);
        //  echo 'appstore'. $staffinfo->appstore;
        //   exit();

        if ($msg) {

            ///// delet eyou user /////////////////////////////////////
            $eyou = $this->api_eyou->user_del($staffinfo->itname);
            ///// Bqq 处理 /////////////////////////////////////
            if (in_array("bqq", explode(',', $staffinfo->appstore))) {
                $this->load->model('bqq_model');
                $staffTrue = $this->bqq_model->bqq_staff_row("bqq_staff.itname = '" . $staffInfo->itname . "'");
                if ($staffTrue) {
                    $this->bqq_model->user_out_itname($staffTrue->bs_qq);
                }
            }


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
                    echo 1;
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
                    echo 1;
                } else {
                    echo "写数据库成功/写AD失败！";
                }
            }
        } else {
            echo "写数据库失败！"; // 写数据库失败成功
        }
    }

    function staffdelete() {

        $id = $this->input->post('id');
        $staffinfo = $this->staff_model->get_staff_by("id = " . $id);

        $data['id'] = $id;
        $data['del_show'] = 1;
        $msg = $this->staff_model->edit($data);
        if ($msg) {
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

    function staffdeleteTrue() {

        $id = $this->input->post('id');
        if ($id) {
            $data['id'] = $id;
            $staffinfo = $this->staff_model->get_staff_by("id = " . $id);
            $staffScrap = (array) $staffinfo;
            unset($staffScrap['id']);
            $this->staff_model->add_scrap($staffScrap);
            //  exit();
            // del tongxun
            $itname = $staffinfo->itname;
            $this->load->model('tongxun_model');
            $this->tongxun_model->del_address($itname);

            $msg = $this->staff_model->del($data);
            if ($msg) {
                ///// set api data /////////////////////////////
                $api['itname'] = $staffinfo->itname;
                $api['msText'] = "删除";
                $api['state'] = 0;
                $api['msType'] = 3; //  //  0 权限，1 禁用，2 开启，3 删除，4 部门异动
                $this->staff_model->upsystem_api($api); // 写入 API表
                //20170215  删除钉钉管家删除
                $this->delDdgj($api['itname']);
                ///// set api data /////////////////////////////
                if (in_array("ad", explode(',', $staffinfo->appstore))) {  // 判断推送系统 $postdata["uptype"]
                    $this->load->library('adldaplibrary');
                    $adldap = new adLDAP();
                    $result = $adldap->user()->delete($staffinfo->itname);
                    //print_r($result);
                    if ($result) {
                        //echo 3; // 写数据库 / AD 成功
                        // del 
                        if (in_array("rtx", explode(',', $staffinfo->appstore))) {
                            $this->load->model("rtx_model"); //  RTX
                            $this->rtx_model->userDel($staffinfo->itname);
                        }
                        echo 1;
                    } else {
                        echo "写数据库成功/写AD失败！";
                    }
                }
            } else {
                echo "删除操作失败,原因可能是当前记录不存在！";
            }
        }
    }

    /*
     * 20170215  删除钉钉管家用户调用
     */

    function delDdgj($itname) {
        // echo "deldd";
        $timeout = 50000;
        if ($itname) {
            $ch = curl_init();
            $timeout = 50000;

            $key = "J3ECG2sQ4Om6B1Mr";
            $data['user_id'] = $itname;
            // 13 位时间戳
            list($t1, $t2) = explode(' ', microtime());
            $data['long_time'] = (float) sprintf('%.0f', (floatval($t1) + floatval($t2)) * 1000);
            $data['encrypt'] = md5($key . $data['long_time']);
            /// print_r(json_encode($data));
            //  exit;
            curl_setopt($ch, CURLOPT_URL, 'http://dd.semir.cc/api/v1/orgDel');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 获取数据返回  
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen(json_encode($data))
                    )
            );
            $output = curl_exec($ch);
            curl_close($ch);
            //  echo $output;
            //    exit;
        }
    }

    function staffdeleteScrapTrue() {
        $id = $this->input->post('id');
        if ($id) {
            $data['id'] = $id;

            //  exit();
            $msg = $this->staff_model->del_scrap($data);
            echo 'ok';
        } else {
            echo "删除操作失败,原因可能是当前记录不存在！";
        }
    }

    function get_post() {
        $data['rootid'] = $this->input->post('rootid');
        $data['id'] = $this->input->post('id');
        $data['appstore'] = $this->input->post('appstore');
        $data['cname'] = trim($this->input->post('surname')) . trim($this->input->post('firstname'));
        $data['itname'] = strtolower(trim($this->input->post('itname')));
        $data['username'] = strtolower(trim($this->input->post('username')));
        $data['container'] = $this->input->post('container');
        $data['adOuShow'] = $this->input->post('adOuShow');
        $data['surname'] = trim($this->input->post('surname'));
        $data['firstname'] = trim($this->input->post('firstname'));
        $data['logon_name'] = strtolower(trim($this->input->post('logon_name')));
        $data['location'] = $this->input->post('location');
        $data['mobtel'] = $this->input->post('mobtel');

        $data['password'] = $this->input->post('password');
        $data['email'] = $this->input->post('email') . "@" . $this->input->post('domain');
        $data['station'] = $this->input->post('station');
        $data['jobnumber'] = $this->input->post('jobnumber');
        $data['addtime'] = date('Y-m-d H:i:s');
        $data['action'] = $this->input->post('action');
        $data['portnumber'] = $this->input->post('portnumber');

        return $data;
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

    function systemedit() {

        $data['action'] = "edit";
        $data['staff'] = $this->staff_model->get_staff_by("id = " . $this->input->post('id'));

        //print_r($data['staff']);
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
        $this->cismarty->assign("staff", $data['staff']);
        $this->cismarty->display($this->sysconfig_model->templates() . '/staff/staff_systemedit.tpl');
        // $this->load->view('staff', $data);
    }

    function staff_systemedit_save() {
        $data['id'] = $this->input->post('id');
        if (@$_POST['system_id']) {
            $systemp = $_POST['system_id'];
            $data['system_id'] = implode(',', $systemp);
        } else {
            $data['system_id'] = "";
        }

        // print_r($data);
        $msg = $this->staff_model->edit($data);   // 更新用户权限
        // ///////////////////更新同步临时表 staff_system_api /////////////
        $where = 'id = ' . $data['id'];
        $result = $this->staff_model->get_staff_by($where); // 获取 staff info
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
        if ($msg) {
            echo 1;
        } else {
            echo 0;
        }
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

        if ($data = $this->get_staff_id()) {
            if ($msg = $this->staff_model->multi_del($data)) {
                $this->view();
            } else {
                show_error("删除操作失败,原因可能是当前记录不存在！");
            }
        }
    }

    function physical_del() {

        if ($data = $this->get_staff_id()) {
            if ($this->staff_model->physical_del($data)) {
                //$this->view();
                echo "ok";
            } else {
                show_error("删除操作失败,原因可能是当前记录不存在！");
            }
        }
    }

    /*
     * temp tools
     */

    function tools_job() {
        $this->load->library('adldaplibrary');
        $adldap = new adLDAP();
        $where = ""; //"itname = 'zhuyilai'";
        $result = $this->staff_model->get_staffs(1000, 2500, $where);

        foreach ($result as $row) {
            //  print_r($row);
            $attributes = array(//////////////////////////// 和 ad对应字段名称请查看 src/adLDAP.PHP
                "pager" => $row->jobnumber,
                "title" => $row->station
            );
            // echo "aaaaa";
            //  $result = $adldap->user()->modify($row->itname, $attributes);
            //  print_r($result);
            if ($result) {
                echo "1";
            } else {
                echo $row->itname;
                var_dump($result);
            }
        }
    }

    /*
     * Dimission
     */

    function dimission() {
        $this->cismarty->display($this->sysconfig_model->templates() . '/staff/dimission.tpl');
    }

    function dimission_sms() {
        //判断是否有资产

        $itname = $this->input->post('itname');
        $data = $this->dimission_sms_get($itname);
        $jieyong = $data["jieyong"];
        $sms = $data["data"];
        // print_r($jieyong);
		if(!$jieyong && !$sms){
	        echo '-';
        }
        $this->cismarty->assign("jieyong", $jieyong);
        $this->cismarty->assign("data", $sms);
        $this->cismarty->display($this->sysconfig_model->templates() . '/staff/dimission_sms.tpl');
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
		//$data = null;
        return $data;
    }

    function up_sms_lizhi_do() {
        header("Content-Type:text/html;charset=utf-8");
        //  $data = $this->input->post();
        $res['val'] = 1;
        $oa_number = $this->input->post('oa_number');
        $updata['oa_status'] = $this->input->post('oa_status');
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
        // print_r($res);
        // echo json_encode($res);
    }

    function todoOa() {

        // $soapParameters = Array('login' => "piappluser", 'password' => "vfr45tgb"); 
        $itname = $this->input->post('itname');

        $toData['docSubject'] = "离职退仓 - " . $itname; // 投诉类别+店名+
        $toData['code'] = 'lizhi'; // 流程编号
        $toData['fdLoginName'] = $this->session->userdata('DX_username');  //SMG操作人
        $data['com_user'] = $itname; //资产使用人ID
        $data['type'] = "退仓"; ////退仓归还类型，  退仓、归还
        $data['depart_code'] = $this->input->post('depart_code'); //事业部品牌
        //get sms list
        $dataSms = $this->dimission_sms_get($itname);
        // 借用资产处理
        $jieyong = $dataSms["jieyong"];
        $jp = array();
        foreach ($jieyong as $row) {
            $jp[] = $row->sj_number;
        }
        // 领用资产处理
        $sms = $dataSms["data"];
        $lp = array();
        foreach ($sms as $rowa) {
            $lp[] = $rowa->sms_number;
        }

        $p1 = implode(',', $lp);
        $p2 = implode(',', $jp);
        $data['fd_ComputerAssets'] = $p1; //退仓资产
        $data['fd_NotebookAssets'] = $p2; ////归还资产
        $data['fd_reason'] = "离职退仓归还";  //退仓理由，可以写死

        $toData['formJson'] = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); // 投诉信息
        //   print_r($toData);
        //exit;
        $soapURL = "http://10.90.18.32:8081/webservice/PscReviewWebService?wsdl";
        $soapFunction = "start";
        $soapFunctionParameters = $toData;
        $soapClient = new \soapClient($soapURL);
        $soapResult = $soapClient->$soapFunction($soapFunctionParameters);
        //  print_r($soapResult);
        $return = json_decode($soapResult->return);
        // print_r($return);
        if ($return->rtnStatus == 1) {
            $updata['itname'] = $itname;
            $updata['sub_itname'] = $this->session->userdata('DX_username');
            $updata['oa_number'] = $return->flowNo;
            $updata['oa_status'] = 0;
            $updata['uptime'] = date('Y-m-d H:i:s');

            $this->load->model('sms_model');
            $result = $this->sms_model->sms_lizhi_add($updata); //保存to lizhi
			if($result)
				echo 1;
        }
        //echo 1;
        if (is_array($soapResult) && isset($soapResult['start'])) {
            // Process result.
            // print_r($soapResult);
        } else {
            // Unexpected result
            if (function_exists("debug_message")) {
                // debug_message("Unexpected soapResult for {$soapFunction}: " . print_r($soapResult, TRUE));
            }
        }
        ////////////////////////
    }
 
    function todoEmail(){
		$itname = $this->input->post('itname');
    	$this->load->library('email');
    	$this->load->model('sms_model');
    	$data['type'] = '离职邮件';
    	$result = $this->sms_model->get_email_configuration($data);
    	if(!$result){
    		echo 2;
    		exit;
    	}
    	$this->load->model('staff_model');
    	$user = $this->staff_model->get_staff_by(array('itname'=>$itname));
    	$parentDept = $user->rootid;
    	$this->load->model('deptsys_model');
    	$dept_name = array($user->station);
    	for($i=1;$i<6;$i++){
    		if($parentDept > 0){
    			$dept = $this->deptsys_model->get_dept_val(array("id"=>$parentDept));
    			$dept_name[]= $dept->deptName;
    			$parentDept = $dept->root;
    		}
    	}
    	$dept = array_reverse($dept_name);
    	$dept_detail="";
    	foreach ($dept as $k=>$val){
    		if($k == 0){
    			$dept_detail = $val;
    		}
    		else{
    			$dept_detail .= '>>'.$val;
    		}
    	}
    	$date_l = date('Y-m-d',time());
    	//end
		foreach ($result as $k=>$e){
			$this->email->from('lizhi@vip.semir.com', empty($e->from) ? '系统提示信息' : $e->from);
			$this->email->to($e->sendto);
			$this->email->cc($e->cc);
			$this->email->bcc($e->bcc);
			
			$this->email->subject('离职通知');
			$this->email->message('<h3>人员 :  '.$user->cname.'</h3><h4 style="color:gray">部门：'.$dept_detail.'</h4>  <br/><h4>离职日期：'.$date_l.'</h4>');
			$result  = $this->email->send();	
		}
		if($result)
			echo 1;
		else
    	    echo 0;
    }
    
    function emailconfig(){
    	$this->load->model('sms_model');
    	$result = $this->sms_model->get_email_configuration('');
    	$this->cismarty->assign("data", $result);
        $this->cismarty->display($this->sysconfig_model->templates() . '/staff/emailconfig.tpl');
    }
    
    function emailconfig_edit(){
    	$id = $this->input->post('id');
    	$this->load->model('sms_model');
    	$data['id'] = $id;
    	$result = $this->sms_model->get_email_configuration_row($data);
    	$this->cismarty->assign("data", $result);
    	$this->cismarty->display($this->sysconfig_model->templates() . '/staff/emailconfig_edit.tpl');
    }
    
    function emailconfig_add(){
    	$this->cismarty->display($this->sysconfig_model->templates() . '/staff/emailconfig_add.tpl');
    }
    
    function emailconfig_edit_do(){
    	$data['id'] = $this->input->post('id');
    	$data['type'] = strtoupper(trim($this->input->post('type')));
    	$data['sendto'] = $this->input->post('sendto');
    	$data['cc'] = $this->input->post('cc');
    	$data['bcc'] = $this->input->post('bcc');
    	$data['from'] = $this->input->post('from');
    	$this->load->model('sms_model');
    	echo $this->sms_model->email_configuration_edit($data);
    }
    
    function emailconfig_add_do(){
    	$data['type'] = strtoupper(trim($this->input->post('type')));
    	$data['sendto'] = $this->input->post('sendto');
    	$data['cc'] = $this->input->post('cc');
    	$data['bcc'] = $this->input->post('bcc');
    	$data['from'] = $this->input->post('from');
    	$this->load->model('sms_model');
    	echo $this->sms_model->email_configuration_add($data);
    }
}
