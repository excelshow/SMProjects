<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Show extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('login_model');
        // $this->dx_auth->check_uri_permissions();
        $this->load->model('staff_model');
        $this->load->model('tongxun_model');
        $this->load->library('session');
        $this->sysconfig_model->sysInfo(); // set sysInfo
        if ($this->session->userdata('userLogin')) {
            $itname = $this->session->userdata('itname');
            $staffInfo = $this->tongxun_model->get_staff_by("itname = '" . $itname . "'");
            $this->session->set_userdata('cname', $staffInfo->cname);
        }
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
        $showmenu = "";
        return $showmenu;
    }

    function index() {
        $this->publiclist();
        exit();
        // load all address
        $id = $this->uri->segment(4, 0);
        $search = $this->input->post('searchText');
        if (!$id) {
            $id = 0;
        }
        $deptAll = $this->tongxun_model->dept_get_all(0, 0, "root = 6");
        //  print_r($dept);
        $this->cismarty->assign('menuUrl', array('tongxun', 'index'));
        $this->cismarty->assign("id", $id);
        $this->cismarty->assign("deptList", $deptAll);
        // $this->cismarty->assign("links", $data['links']); 
        $this->cismarty->display($this->sysconfig_model->templates() . '/tongxun/show_index.tpl');
    }

    function show_my() {
        if ($this->session->userdata('userLogin')) {
            $itname = $this->session->userdata('itname');
            $staffInfo = $this->tongxun_model->get_staff_by("itname = '" . $itname . "'");
            $this->session->set_userdata('cname', $staffInfo->cname);
            $this->load->model('deptsys_model');
            $ouTemp = $this->deptsys_model->get_dept_parent_ou('id = ' . $staffInfo->rootid);
            // print_r($ouTemp);
            $this->session->set_userdata('deptName', $ouTemp[0]['deptName']);
            $staffList = $this->show_stafflist($ouTemp[0]['deptId']);

            //  print_r($data['staffs']);
            // $this->load->view('staffLayout', $data);

            $this->cismarty->assign("data", $staffList);

            $this->cismarty->display($this->sysconfig_model->templates() . '/tongxun/show_mydept.tpl');
        } else {
            $this->cismarty->display($this->sysconfig_model->templates() . '/tongxun/show_login.tpl');
        }
    }

    function myinfo() {
        if ($this->session->userdata('userLogin')) {
            $itname = $this->session->userdata('itname');
            $staffList = $this->tongxun_model->staffs_addree_row("itname = '" . $itname . "'");
            // print_r($staffList);
            $this->cismarty->assign("addreeInfo", $staffList);

            $this->cismarty->display($this->sysconfig_model->templates() . '/tongxun/show_myinfo.tpl');
        } else {
            $this->cismarty->display($this->sysconfig_model->templates() . '/tongxun/show_login.tpl');
        }
    }

    function show_sreach() {
        $type = trim($this->input->post('type'));
        $search = trim($this->input->post('searchText'));
        parse_str($_SERVER['QUERY_STRING'], $_GET);
//echo $type;
        if ($search) {
            $this->load->model("deptsys_model");
            if ($type == 2) {
                $deptIdArr = $this->deptsys_model->get_dept_child_id("deptName like '%" . $search . "%'");
                $where_in = $deptIdArr;
            } else {
                $where_in = '';
            }
            // print_r($result);
            $where = "del_show = 0 and enabled = 1";
            if ($type == 1) {
                $where .= " and (itname like '%" . $search . "%' or cname like '%" . $search . "%')";
            }
            if ($type == 3) {
                $wherea = "sa_tel like '%" . $search . "%' or sa_mobile like '%" . $search . "%'";
                $tempa = $this->tongxun_model->staffs_addree_result($wherea);
                $data['stafftemp'] = '';
                foreach ($tempa as $row) {
                    $data['stafftemp'][] = $this->tongxun_model->get_staffs_top("itname = '" . $row->itname . "'");
                }
            } else {
                $data['stafftemp'] = $this->tongxun_model->get_staffs_where_in(0, 0, $where, $where_in);
            }
            //echo $where;
            //print_r($data['staffs']); 
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
                    $addreeInfo = $this->tongxun_model->staffs_addree_row("itname = '" . $row->itname . "'");
                    if ($addreeInfo) {
                        $row->address = $addreeInfo;
                    } else {
                        $row->address = '';
                    }
                    $data['staffs'][] = $row;
                }
            } else {
                $data['staffs'] = "";
            }
        } else {
            $data['staffs'] = "";
            $type = '';
            $search = '';
        }
        // print_r($data['staffs']);
        $this->cismarty->assign("data", $data['staffs']);
        $this->cismarty->assign("type", $type);
        $this->cismarty->assign("search", $search);
        $this->cismarty->display($this->sysconfig_model->templates() . '/tongxun/show_search.tpl');
    }

    function oaurl() {
        $itname = $this->uri->segment(4, 0);
        //echo md5("lizhendong");
        $staff = $this->staff_model->get_staffs('', '', '');
        foreach ($staff as $row) {

            if ($itname == md5($row->itname)) {
                $this->session->set_userdata('userLogin', true);
                $this->session->set_userdata('itname', $row->itname);
                // $this->publiclist();
                redirect(site_url('tongxun/show'));
                break;
            }
        }
        // print_r($staff);
    }

    function oaurll() {
        $itname = $this->uri->segment(4, 0);
        //echo md5("lizhendong");
        $staff = $this->staff_model->get_staffs('', '', '');
        foreach ($staff as $row) {

            if ($itname == md5($row->itname)) {
                $this->session->set_userdata('userLogin', true);
                $this->session->set_userdata('itname', $row->itname);
                // $this->publiclist();
                redirect(site_url('tongxun/show/myinfo'));
                break;
            }
        }
        // print_r($staff);
    }

    function login() {
        $itname = trim($this->input->post('username'));
        $up = trim($this->input->post('password'));
        $data = array($itname, $up);
        // $data[] = 'lizd11';
        if ($this->userLogin($data)) {
            $this->session->set_userdata('userLogin', true);
            $this->session->set_userdata('itname', $data[0]);
            echo 'ok';
        } else {
            $this->session->sess_destroy();
            echo 1;
        }
    }

    function userLogin($data) {
        // $this->load->library('adldaplibrary');
        //  $adldap = new adLDAP();
        $ldapconn = ldap_connect("10.90.18.5");        //连接ad服务
        ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);    //设置参数
        $ldap_bd = @ldap_bind($ldapconn, "AppSystem", "Semir@app");                    //打开ldap，正确则返回true。登陆
        //  var_dump($ldap_bd);
        if ($ldap_bd) {
            $bd = @ldap_bind($ldapconn, $data[0] . '@semir.cn', $data[1]);
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

    function logout() {
        $this->session->sess_destroy();
        echo 'ok';
//redirect(site_url(''));
    }

    function show_stafflist($id) {

        //$id = $this->uri->segment(4, 0);
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
            $data['staffs'] = "";
        }
        // print_r($data['staffs']);
        return $data['staffs'];
    }

    function publiclist() {
        //echo "sdf";

        $deptAll = $this->tongxun_model->dept_get_all(0, 0, "root = 6");
        //  print_r($dept);
        // echo md5('123123');
        $this->cismarty->assign("deptList", $deptAll);
        $data = $this->tongxun_model->publicResult();
        $this->cismarty->assign("data", $data);
        $this->cismarty->display($this->sysconfig_model->templates() . '/tongxun/show_publiclist.tpl');
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

    function staffmodifycomplete() {
        if ($this->session->userdata('userLogin')) {
            $data['itname'] = $this->session->userdata('itname');
            $addreeInfo = $this->tongxun_model->staffs_addree_row("itname = '" . $data['itname'] . "'");
            if ($addreeInfo) {
                $data['sa_code'] = $this->input->post('sa_code');
                $data['sa_tel'] = $this->input->post('sa_tel');
                $data['sa_tel_short'] = $this->input->post('sa_tel_short');
                if ($this->input->post('sa_mobile')) {
                    $codeYz = $this->input->post('sa_mobile_yanzheng');
                    if ($codeYz == $_SESSION['item']) {
                        $_SESSION['item'] = '';
                        $data['sa_mobile'] = $this->input->post('sa_mobile');
                    } else {
                        echo '手机验证码错误！';
                        return;
                    }
                }
                $data['sa_uptime'] = date('Y-m-d h:i:s');
                $this->tongxun_model->edit_address($data);
                // log

                $data['cname'] = $this->session->userdata('cname');
                $this->tongxun_model->insert_address_log($data);
                echo 'ok';
            } else {
                echo '通讯信息不存在！';
            }
        } else {
            echo '请先登陆！';
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

    /*
     * 
     * //获取短信验证码操作（Ajax方法为好）
     * 
     */

    Public function get_authentication_code() {
        if ($this->input->post('uv_r') && trim($this->input->post('mob'))) {
            $ip = $_SERVER["REMOTE_ADDR"]; //ip
            $tel = trim($this->input->post('mob')); //电话
            $uv_r = $this->input->post('uv_r'); //ur_r标识
            if (empty($uv_r)) {
                $uv_r = 0;
            }
        }
        //判断数据是否超过了限制
        $uvr_num = $this->checkUvr($uv_r);
        $tel_num = $this->checkTel($tel);
        $ip_num = $this->checkIp($ip); 
        if ($uvr_num < 10 && $tel_num < 4 && $ip_num < 10) {
            /// Echo "发送验证码"; //符合发送条件，发送验证码的操作
            $data['mob'] = $tel;
            $data['code'] = rand(1000, 9999);
            $_SESSION['item'] = $data['code'];
            $reData = $this->sendSms($data); 
            if ($reData['result'] == 0) {
                echo 0;
            } else {
                echo $reData['result'].$reData['des'];
            }
        } else {
            Echo "不发送验证码,您今日获取短信验证码的次数过多";
//当不发送验证码时，将数据存入文件，用于方便查询
            $data = $tel . "|" . $ip . "|" . $uv_r . "|";
            if ($uv_r > 0 && $uvr_num >= 10) {
                $data = $data . "A@";
            }
            if ($tel_num >= 4) {
                $data = $data . "B@";
            }
            if ($ip_num >= 10) {
                $data = $data . "C@";
            }
            $this->wirteFile("", $data);
            //   $this->ajax_return(0, "您今日获取短信验证码的次数过多！"); //给用户返回信息 
        }
    }

    /*
     *  send sms
     */

    Private function sendSms($data) {
        header("Content-type: text/html; charset=UTF-8");
        $msg = "手机验证码:" . $data['code'] . "; 您正在使用通讯录修改手机号码,需要效验,请在10分钟内使用!";
        $mes = mb_convert_encoding($msg, "gb2312", "UTF-8");
        $timeout = 50; 
        $url = "http://smsapi.ums86.com:8888/sms/Api/Send.do";
        $post_data = "SpCode=003031&LoginName=WZ_SM_PI&Password=SM9527&MessageContent=" . $mes . "&UserNumber=" . $data['mob'] . "&SerialNumber=31345678901234562311&ScheduleTime=&f=1";

//$contents = mb_convert_encoding($contents, "UTF-8", "gb2312"); 
        $useragent = "Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.56 Safari/537.17";
//初始化
        $ch = curl_init();
//设置抓取的url
        $header = array(
            "content-type: application/x-www-form-urlencoded; charset=gb2312"
        );
        curl_setopt($ch, CURLOPT_URL, $url);
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
        curl_close($ch);
        //echo $file_contents;
        $temp = explode('&', $file_contents);
        $tempResult = explode('=', $temp[0]);
        $tempDes = explode('=', $temp[1]);
        $reData['result'] = $tempResult[1];
        $reData['des'] =  mb_convert_encoding($tempDes[1], "UTF-8", "gb2312").$data['mob'].'/////';
        return $reData;
        // echo 1; 
        exit;
    }

    /*
     *  send sms
     */

    function sendSmst($data) {
        header("Content-type: text/html; charset=UTF-8");
        $msg = "手机验证码:1232; 您正在使用通讯录修改手机号码,需要效验,请在10分钟内使用!";
        $mes = mb_convert_encoding($msg, "gb2312", "UTF-8");
        $timeout = 5;
        $url = "http://smsapi.ums86.com:8888/sms/Api/Send.do";
//$post_data = array("SpCode"=>"003031","LoginName"=>"WZ_SM_PI","Password"=>"SM9527","MessageContent"=> $mes ,"UserNumber"=>"18049987585","SerialNumber"=>"31345678901234567899","ScheduleTime"=>"","f"=>"1");
        $post_data = "SpCode=003031&LoginName=WZ_SM_PI&Password=SM9527&MessageContent=" . $mes . "&UserNumber=17301647585&SerialNumber=31345678901234562311&ScheduleTime=&f=1";

//$contents = mb_convert_encoding($contents, "UTF-8", "gb2312"); 
        $useragent = "Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.56 Safari/537.17";
//初始化
        $ch = curl_init();
//设置抓取的url
        $header = array(
            "content-type: application/x-www-form-urlencoded; charset=gb2312"
        );
        curl_setopt($ch, CURLOPT_URL, $url);
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
        curl_close($ch);
        $temp = explode('&', $file_contents);
        $tempResult = explode('=', $temp[0]);
        $tempDes = explode('=', $temp[1]);
        $reData['result'] = $tempResult[1];
        $reData['des'] = $tempDes[1]; 
        return $reData;

        // echo 1; 
        exit;
    }

//以下方法为私有方法
//检测ur_r在文件中出现的次数
    Private function checkUvr($data) {
        $fileName = "Uv_" . date("Ymd", time()) . ".dat";
        $filePath = './tempfile/' . $fileName; //组装要写入的文件的路径
        $c_sum = 0;
        if (file_exists($filePath)) {//文件存在获取次数并将此次请求的数据写入
            $arr = file_get_contents($filePath);
            $row = explode("|", $arr);
            $countArr = array_count_values($row);
            $c_sum = $countArr[$data];
            if ($c_sum < 10) {
                $this->wirteFile($filePath, $data . "|");
            }
            return $c_sum;
        } else {//文件不存在创建文件并写入本次数据，返回次数0
            $this->wirteFile($filePath, $data . "|");
            return $c_sum;
        }
    }

//检测Tel在文件中出现的次数
    Private function checkTel($data) {
        $fileName = "Tel_" . date("Ymd", time()) . ".dat";
        $filePath = './tempfile/' . $fileName;
        $c_sum = 0;
        if (file_exists($filePath)) {
            $arr = file_get_contents($filePath);
            $row = explode("|", $arr);
            $countArr = array_count_values($row);
            if (isset($countArr[$data])) {
                $c_sum = $countArr[$data];
                if ($c_sum < 4) {
                    $this->wirteFile($filePath, $data . "|");
                }
            } else {
                $this->wirteFile($filePath, $data . "|");
            }

            return $c_sum;
        } else {
            $this->wirteFile($filePath, $data . "|");
            return $c_sum;
        }
    }

//检测IP在文件中存在的次数
    Private function checkIp($data) {
        $fileName = "Ip_" . date("Ymd", time()) . ".dat";
        $filePath = './tempfile/' . $fileName;
        $c_sum = 0;
        if (file_exists($filePath)) {
            $arr = file_get_contents($filePath);
            $row = explode("|", $arr);
            $countArr = array_count_values($row);
            $c_sum = $countArr[$data];
            if ($c_sum < 10) {
                $this->wirteFile($filePath, $data . "|");
            }
            return $c_sum;
        } else {
            $this->wirteFile($filePath, $data . "|");
            return $c_sum;
        }
    }

    /**
     * 将数据写入本地文件
     * @param $filePath 要写入文件的路径
     * @param $data 写入的数据
     */
    Private function wirteFile($filePath, $data) {
        try {
            if (!is_dir('./tempfile/')) {//判断文件所在目录是否存在，不存在就创建
                mkdir('./tempfile/', 0777, true);
            }
            if ($filePath == "") {//此处是不发送验证码时，记录日志创建的文件
                $filePath = ('./tempfile/') . "N" . date("Ymd", time()) . ".dat";
            }
//写入文件操作
            $fp = fopen($filePath, "a+"); //得到指针
            fwrite($fp, $data); //写
            fclose($fp); //关闭
        } catch (Exception $e) {
            print $e->getMessage();
        }
    }

    /*
     * 
     * //获取短信验证码操作（Ajax方法为好）
     * 
     */
}
