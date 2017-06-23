<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mtools extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->dx_auth->check_uri_permissions();
        $this->sysconfig_model->sysInfo(); // set sysInfo
        $this->mainmenu_model->showMenu();
        $menuCurrent = $this->showConMenu();
        $this->load->model('staff_model');
        $this->cismarty->assign("menuController", $menuCurrent);
        $this->cismarty->assign("urlF", $this->uri->segment(2));
        $this->cismarty->assign("urlS", $this->uri->segment(3));
        $this->cismarty->assign("pageTitle", '管理员工具 - ');
    }

    function showConMenu() {
        $showmenu = "";
        $showmenu = "<li><a href=" . site_url("mtools/userLogList") . " target=_blank>操作日志</a></li><li><a href=" . site_url("mtools/search") . " target=_blank>数据查询</a></li>"
                . "<li><a href=" . site_url("temp/tempstaff") . " target=_blank>数据同步</a></li>
                              <li><a href=" . site_url("mtools/outdata") . " target=_blank >数据导出</a></li>
                              <li><a href=" . site_url("xmlrpc_api/ims_client/index") . " target=_blank>Webservice</a></li>";

        return $showmenu;
    }

    function index() {
        $this->cismarty->display($this->sysconfig_model->templates() . '/mtools/index.tpl');
    }

    function outdata() {
        $this->cismarty->display($this->sysconfig_model->templates() . '/mtools/index.tpl');
    }

    function search() {
        $this->cismarty->display($this->sysconfig_model->templates() . '/mtools/search.tpl');
    }

    function searchByDeptId() {
        $id = $this->uri->segment(3);
        // $id = 107;
        if (!$id) {
            $id = 6;
        }
        parse_str($_SERVER['QUERY_STRING'], $_GET);
        $model = $this->load->model("deptsys_model");
        $model = $this->load->model("tongxun_model");
        $sqlStr = "id = " . $id;
        $deptIdArr = $this->deptsys_model->get_dept_child_id($sqlStr);
        $where_in = $deptIdArr;

        // print_r($result);
        $where = "del_show = 0 and enabled = 1";


        //echo $where;
        $data['stafftemp'] = $this->tongxun_model->get_staffs_where_in(0, 0, $where, $where_in);

        //print_r($data['staffs']);
        // 读取用户AD状态
        echo count($data['stafftemp']);
        if ($data['stafftemp']) {
            foreach ($data['stafftemp'] as $row) {
                echo $row->itname . "<br>";
            }
        } else {
            $data['staffs'][] = '';
        }
    }

    function userLogList() {
        $data = array();
        $this->load->model("sysconfig_model"); // load deptinfo
        $k = $this->input->post('k');
        if ($k) {
            $where = "ul_username like '%" . $k . "%' or ul_model like '%" . $k . "%' or ul_title like '%" . $k . "%' or ul_function like '%" . $k . "%'";
        } else {
            $where = "";
        }
        $data = $this->sysconfig_model->sys_user_result(20, 0, $where);
        //  print_r($dept);
        //  exit;
        $i = 0;
        foreach ($data as $row) {
            //  print_r($row->ul_function); 
            $ul = json_decode($row->ul_function);
            // print_r($ul);
            if ($ul) {
                // $b = (array) $ul;
                // $row->ul_function1 = implode(";", $b);
            } else {
                // @$row->ul_function1 = "";
            }
        }

        // $this->load->view('staffLayout', $data); 
        $this->cismarty->assign("total", $i);
        $this->cismarty->assign("data", $data);
        $this->cismarty->display($this->sysconfig_model->templates() . '/mtools/userLogList.tpl');
    }

    function deptlistBatch() {
        $data = array();
        $this->load->model("deptsys_model"); // load deptinfo
        $dept = $this->deptsys_model->get_deptall();
        //    print_r($dept);
        //exit;
        $i = 0;
        foreach ($dept as $row) {
            // print_r($row);
            if ($row) {
                $deptSend = $this->deptsys_model->get_dept_val("root = " . $row->id);
                if ($deptSend) {
                    
                } else {
                    $result = $this->staff_model->get_staff_by('rootid = ' . $row->id);
                    if ($result) {
                        
                    } else {
                        $ouTemp = $this->deptsys_model->get_dept_child_DN('id = ' . $row->id);
                        $row->deptOu = $ouTemp;
                        $row->deptname = $row->deptName;
                        $i++;
                        $data[] = $row;
                        $ou = implode('>', $ouTemp);
                        echo $row->id . "-" . $ou . '<br>';
                    }
                }
            }
        }
        echo $i;
        exit();
        // $this->load->view('staffLayout', $data); 
        $this->cismarty->assign("total", $i);
        $this->cismarty->assign("data", $data);
        $this->cismarty->display($this->sysconfig_model->templates() . '/mtools/stafflistbatch.tpl');
    }

    function stafflistBatch() {

        $data = "";
        $t = $this->input->post('t');
        $search = explode("\n", $this->input->post('key'));
        // $search = explode(',', $this->input->post('key'));
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
                        $result->deptOu = "Null";
                        $result->deptname = "暂无";
                    }
                    $i++;
                    $data[] = $result;
                } else {
                    $result['id'] = 0;
                    $data[] = (Object) $result;
                }
            }
        }
        // print_r($data);
        // $this->load->view('staffLayout', $data); 
        $this->cismarty->assign("total", $i);
        $this->cismarty->assign("data", $data);
        $this->cismarty->display($this->sysconfig_model->templates() . '/mtools/stafflistbatch.tpl');
    }

    function smsToSmg() {
        // Starting the PHPExcel library
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
        $PHPExcel = new PHPExcel();
        $PHPReader = new PHPExcel_Reader_Excel2007();
        $fileName = 'sms.xlsx';
        $path = './tempfile/';
        $filePath = $path . $fileName;
        if (!$PHPReader->canRead($filePath)) {
            $PHPReader = new PHPExcel_Reader_Excel5();
            if (!$PHPReader->canRead($filePath)) {
                echo 'no Excel';
                return;
            }
        }
        $PHPExcel = $PHPReader->load($filePath);
        $currentSheet = $PHPExcel->getSheet(1);
        /*         * 取得一共有多少列 */
        $allColumn = $currentSheet->getHighestColumn();
        /*         * 取得一共有多少行 */
        $allRow = array($currentSheet->getHighestRow());
        // echo $allColumn;
        for ($currentRow = 2; $currentRow <= $allRow; $currentRow++) {
//            for ($currentColumn = 'A'; $currentColumn <= $allColumn; $currentColumn++) {
//                $address = $currentColumn . $currentRow;
//
//                echo $currentSheet->getCell($address)->getValue() . "<br>";
//            }
            $val['sms_number'] = $currentSheet->getCell('B' . $currentRow)->getValue();
            $val['sms_sapnumber'] = $currentSheet->getCell('A' . $currentRow)->getValue();
            $val['sms_cat_id'] = $currentSheet->getCell('C' . $currentRow)->getValue();
            $val['sms_bname'] = $currentSheet->getCell('E' . $currentRow)->getValue();
            $val['sms_status'] = 2; // 1= 库存 , 2 = 使用中
            $val['sms_input'] = 'system';
            $val['sms_input_time'] = date('Y-m-d');
            /*             * 
              $val['sm_sap_status'] = 1; // 0= no , 2 = yes
              $val['sm_sap_person'] = 'system'; // 0= no , 2 = yes
              $val['use_time'] = date('Y-m-d');
              $val['itname'] = $currentSheet->getCell('D' . $currentRow)->getValue(); */
            if ($val['sms_number']) {
                $this->load->model('sms_model');
                $this->sms_model->sms_main_add($val);
                /* $this->load->model('staff_model');
                  $result = $this->staff_model->get_staff_by("itname = '" . $val['itname'] . "'");
                  // print_r($result);
                  if ($result) {
                  $this->load->model('deptsys_model');
                  if ($result->rootid > 0) {
                  $ouTemp = $this->deptsys_model->get_dept_parent_ou('id = ' . $result->rootid);
                  //print_r($ouTemp);
                  //  $deptName = $ouTemp[0]['deptName'];
                  if ($ouTemp) {
                  $val['dept_id'] = $ouTemp[0]['deptId'];
                  } else {
                  $val['dept_id'] = 0;
                  }
                  } else {
                  $val['dept_id'] = 0;
                  }
                  // print_r($val);
                  $this->load->model('sms_model');
                  //$this->sms_model->sms_main_add($val);
                  $this->sms_model->staff_sms_add($val);
                  } else {
                  echo $val['itname'].'<br>';
                  }
                 * 
                 */
            }
            // echo "-<br>";
        }
    }

    function outdataDo() {
        $this->load->model('staff_model');
        $query = $this->staff_model->get_staffs(0, 0, "enabled = 1");
        // $query = $this->db->get("staff_dept");
        //  print_r($query);
        if (!$query)
            return false;

        // Starting the PHPExcel library
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");

        $objPHPExcel->setActiveSheetIndex(0);

        // Field names in the first row
        $fields = $this->db->list_fields('staff_main');
        $fields = array("cname", "itname", "location", "rootid");
        $titles = array("姓名", "账号", "地点", "部门");
        // print_r($fields);
        $col = 0;
        foreach ($titles as $title) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $title);
            $col++;
        }

        // Fetching the table data
        $row = 2;
        foreach ($query as $data) {
            $col = 0;
            // print_r($data);
            foreach ($fields as $field) {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
                $col++;
            }

            $row++;
        }

        $objPHPExcel->setActiveSheetIndex(0);

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');

        // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Player_' . date('dMy') . '.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter->save('php://output');
    }

    function doStaffMain() {
        $this->load->model('staff_model');
        $query = $this->staff_model->get_staffs(0, 1, "enabled = 1");
        // $query = $this->db->get("staff_dept");
        //  print_r($query);
        $staffList = array();
        if (!$query) {
            return false;
            exit();
        }
        foreach ($query as $row) {
            $dept = $this->deptStaffOu($row->rootid);
            $row->deptOu = implode(",", $dept);
            // loading address
            $this->load->model('tongxun_model');
            $addreeInfo = $this->tongxun_model->staffs_addree_row("itname = '" . $row->itname . "'");
            if ($addreeInfo) {
                $row->moblie = $addreeInfo->sa_mobile;
            } else {
                $row->moblie = "";
            }
            $staffList[] = $row;
        }
        //   print_r($staffList);
        // Starting the PHPExcel library
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");

        $objPHPExcel->setActiveSheetIndex(0);

        // Field names in the first row
        // $fields = $this->db->list_fields('staff_main');

        $fields = array("itname", "cname", "station", "jobnumber", "moblie", "location", "deptOu");
        $titles = array("帐号", "姓名", "岗位", "工号", "手机号码", "工作地", "部门");
        // print_r($fields);
        $col = 0;
        foreach ($titles as $title) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $title);
            $col++;
        }

        // Fetching the table data
        $row = 2;
        foreach ($staffList as $data) {
            $col = 0;
            // print_r($data);
            foreach ($fields as $field) {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
                $col++;
            }
            $row++;
        }

        $objPHPExcel->setActiveSheetIndex(0);

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');

        // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Staff_' . date('dmy') . '.xls"');
        header('Cache-Control: max-age=0');
        ob_clean();
        $objWriter->save('php://output');
    }

    function doStaffSms() {
        $this->load->model('sms_model');
        $query = $this->sms_model->staff_sms_list(0, 0, "staff_sms.sm_status = 1");
        if ($query) {
            foreach ($query as $row) {
                //load staff   /////////////////////// 
                $itname = $row->itname;
                $this->load->model('staff_model');
                $result = $this->staff_model->get_staff_by("itname = '" . $itname . "'");
                // print_r($result);
                if ($result) {
                    $row->cname = $result->cname;
                    $this->load->model('deptsys_model');
                    if ((int) $row->dept_id > 0) {
                        $sms_dept = $this->deptsys_model->get_dept_val("id = " . $result->rootid);
                        ////
                        ///
                        if ($sms_dept) {
                            $ouTemp = $this->deptsys_model->get_dept_child_DN('id = ' . $result->rootid);
                            if ($ouTemp) {
                                $row->deptOu = implode("&raquo;", $ouTemp);
                            } else {
                                $row->deptOu = "";
                            }
                            $row->deptName = $sms_dept->deptName;
                        } else {
                            $row->deptOu = "";
                            $row->deptName = "";
                        }
                    } else {
                        $row->deptOu = "";
                        $row->deptName = "";
                    }
                    // $row->deptName = $this->staffDeptName($itname);
                    //print_r($sms_dept);
                } else {
                    $row->cname = $row->itname;
                    $row->deptOu = "";
                    $row->deptName = "";
                }
                //load sms main  /////////////////////// 
                $smsMain = $this->loadSmsMain($row->sms_number);

                if ($smsMain) {
                    $row->sms_id = $smsMain->sms_id;
                    $row->sms_sapnumber = $smsMain->sms_sapnumber;
                    $row->sc_name = $smsMain->sc_name;
                    if ($row->sm_type == 1) {
                        $row->sm_type = "领用";
                    }
                    if ($row->sm_type == 2) {
                        $row->sm_type = "借用";
                    }
                    if ($row->sm_type == 3) {
                        $row->sm_type = "长期借用";
                    }
                    if ($row->sm_type == 4) {
                        $row->sm_type = "转移";
                    }
                    $row->category_name = $smsMain->category_name;
                    $row->sms_brand = $smsMain->sms_brand;
                    $row->sms_size = $smsMain->sms_size;
                    $row->sl_name = $smsMain->sl_name;
                    $row->sa_name = $smsMain->sa_name;
                } else {
                    $row->sms_id = '';
                    $row->sm_type = "";
                    $row->sms_sapnumber = "";
                    $row->sc_name = "";
                    $row->category_name = "";
                    $row->sms_brand = "";
                    $row->sms_size = "";
                    $row->sl_name = "";
                    $row->sa_name = "";
                }
                // print_r($row);
                //  exit();
            }
        }
        // $query = $this->db->get("staff_dept");
        // print_r($query);
        // exit();
        if (!$query)
            return false;

        // Starting the PHPExcel library
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");

        $objPHPExcel->setActiveSheetIndex(0);
        // Field names in the first row
        $fields = array("sms_number", "sms_sapnumber", "sc_name", "sm_type", "sms_ip", "cname", "itname", "deptOu");
        $titles = array("资产编号", "财务编号", "类别/名称", "使用状态", "IP", "姓名", "账号", "部门");
        // print_r($fields);
        $col = 0;
        foreach ($titles as $title) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $title);
            $col++;
        }
        // Fetching the table data
        $row = 2;
        foreach ($query as $data) {
            $col = 0;
            // print_r($data);
            foreach ($fields as $field) {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
                $col++;
            }

            $row++;
        }

        $objPHPExcel->setActiveSheetIndex(0);

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');

        // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="SMS_' . date('dmy') . '.xls"');
        header('Cache-Control: max-age=0');
        ob_clean();
        $objWriter->save('php://output');
    }

    function loadSmsMain($sms_number) {
        $data = $this->sms_model->sms_main_by("sms_number = '" . $sms_number . "'");
        if ($data) {
            if ($data->sms_cat_id) {
                $category = $this->sms_model->sms_category_by("sc_id =" . $data->sms_cat_id);
                if ($category) {
                    $data->sc_name = $category->sc_name;
                    $categoryRoot = $this->sms_model->sms_category_by("sc_id =" . $category->sc_root);
                    if ($categoryRoot) {
                        $data->category_name = $categoryRoot->sc_name;
                    } else {
                        $data->category_name = '';
                    }
                } else {
                    $data->sc_name = "";
                    $data->category_name = '';
                }
            } else {
                $data->sc_name = "";
                $data->category_name = '';
            }
            //////
            if ($data->sms_brand) {
                $brand = $this->sms_model->sms_brand_by("sb_id =" . $data->sms_brand);
                $data->sms_brand = $brand->sb_name;
            } else {
                $data->sms_brand = "无";
            }
            //////
            if ($data->sms_local) {
                $location = $this->sms_model->sms_location_by("sl_id =" . $data->sms_local);
                $data->sl_name = $location->sl_name;
            } else {
                $data->sl_name = "";
            }
            //////
            if ($data->sa_id) {
                $location = $this->sms_model->sms_affiliate_by("sa_id =" . $data->sa_id);
                $data->sa_name = $location->sa_name;
            } else {
                $data->sa_name = "";
            }
        } else {
            
        }
        return $data;
    }

    function doStaffSystem() {
        $this->load->model('staff_model');
        $query = $this->staff_model->get_staffs(0, 1, "enabled = 1");
        // $query = $this->db->get("staff_dept");
        //  print_r($query);
        $staffList = array();
        if (!$query) {
            return false;
            exit();
        }
        foreach ($query as $row) {
            $dept = $this->deptStaffOu($row->rootid);
            $row->deptOu = implode(",", $dept);
            $staffList[] = $row;
        }

        //   print_r($staffList);
        // Starting the PHPExcel library
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");

        $objPHPExcel->setActiveSheetIndex(0);

        // Field names in the first row
        // $fields = $this->db->list_fields('staff_main');

        $fields = array("itname", "cname", "systemlist", "deptOu");
        $titles = array("帐号", "姓名", "权限", "部门");
        // print_r($fields);
        $col = 0;
        foreach ($titles as $title) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $title);
            $col++;
        }

        // Fetching the table data
        $row = 2;
        foreach ($staffList as $data) {
            $col = 0;
            $sys = $data->system_id;
            $sysName = "";
            if ($sys) {
                $sysId = explode(',', $sys);
                $systName = array();
                for ($i = 0; $i < count($sysId); $i++) {
                    // echo $sysId[$i];
                    $this->load->model('staff_model');
                    $sysTemp = $this->staff_model->get_system_by("keynumber = " . (int) $sysId[$i] . "");
                    if ($sysTemp) {
                        $systName[] = $sysTemp->sysName;
                    }
                }
                // print_r($systName);
                if ($systName) {
                    $sysName = implode(',', $systName);
                } else {
                    $sysName = '';
                }
            }
            $this->load->model('permissions_model');
            $sg = $this->permissions_model->staff_dg_join_row("itname = '" . $data->itname . "'");
            if ($sg) {
                $sysDg = $sg->quarters_name . "-" . $sg->doctype_name;
            } else {
                $sysDg = '无加密权限信息';
            }
            $data->systemlist = $sysDg . ',' . $sysName;

            // print_r($data);
            // exit;
            foreach ($fields as $field) {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
                $col++;
            }
            $row++;
        }

        $objPHPExcel->setActiveSheetIndex(0);

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');

        // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Staff_' . date('dmy') . '.xls"');
        header('Cache-Control: max-age=0');
        ob_clean();
        $objWriter->save('php://output');
    }

    function deptStaffOu($rootId = '') {
        $this->load->model("deptsys_model");
        $root = $rootId;
        if (!$root) {
            $root = 0;
        }
        $ouTemp = array();
        //echo $root;
        if ($root == '0') {
            $ouTemp = array();
        } else {
            $ouTemp = $this->deptsys_model->get_dept_child_DN('id = ' . $root);
            foreach ($ouTemp as $val) {
                $ouDnPost[] = 'OU=' . $val;
            }
        }
        return $ouTemp;
    }

    /*
     * 临时工具   
     * 
     */

    function tools() {
        // load  
        $this->db->select('*');
        //   $this->db->limit(1, 0);
        //  $this->db->where("itname = 'lujingjing'");
        $this->db->from('sheet1');
        $this->db->order_by("itname", 'asc');
        $query = $this->db->get();
        $arr = $query->result();
        $i = 0;
        foreach ($arr as $row) {
            //  print_r($row);
            $itname = $row->itname;
            $cname = $row->cname;
            $this->load->model('staff_model');
            $staff = $this->staff_model->get_staff_by("itname = '" . $itname . "' and cname ='" . $cname . "'");
            if ($staff) {
                $data['id'] = $staff->id;
                $data['jobnumber'] = $row->jobnumber;
                $data['station'] = $row->station;
                $staff = $this->staff_model->editTemp($data);
            } else {
                $i++;
                echo $itname . $cname . "<br>";
            }
        }
        echo $i;
    }

}
