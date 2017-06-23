<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tempstaff extends CI_Controller {

    /////////////////////////////////////////api   ////////////////////////////////
    // 导入数据专用
    function __construct() {
        parent::__construct();
        //    $this->dx_auth->check_uri_permissions();
        $this->load->model('temp_model');
    }

    function index() {

        if ($this->dx_auth->is_role('2', FALSE)) {
            $this->cismarty->display($this->sysconfig_model->templates() . '/temp/index.tpl');
        } else {
            //    redirect($this->config->item('DX_deny_uri'), 'location');
        }
    }

    function enabled() {  // 获取 离职人员列表
        if ($this->dx_auth->is_role('2', FALSE)) {
            redirect($this->config->item('DX_deny_uri'), 'location');
        }
        $system = $this->db->query("
                                        SELECT  *
                                      FROM
                                        staff_main
                                      where enabled = 0
                                    ");
        foreach ($system->result() as $row) {
            echo $row->itname;
            echo ",";
        }
    }

    function updateLoction() {
        if ($this->dx_auth->is_role('2', FALSE)) {
            redirect($this->config->item('DX_deny_uri'), 'location');
        }
        // Starting the PHPExcel library
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');

        $PHPExcel = new PHPExcel();
        $filePath = '1.xls';
        /*         * 默认用excel2007读取excel，若格式不对，则用之前的版本进行读取 */
        $PHPReader = new PHPExcel_Reader_Excel2007();
        if (!$PHPReader->canRead($filePath)) {
            $PHPReader = new PHPExcel_Reader_Excel5();
            if (!$PHPReader->canRead($filePath)) {
                echo 'no Excel';
                return;
            }
        }
        $PHPExcel = $PHPReader->load($filePath);
        /*         * 读取excel文件中的第一个工作表 */
        $currentSheet = $PHPExcel->getSheet(0);
        /*         * 取得最大的列号 */
        $allColumn = $currentSheet->getHighestColumn();
        /*         * 取得一共有多少行 */
        $allRow = $currentSheet->getHighestRow();
        $lc = '';
        /*         * 从第二行开始输出，因为excel表中第一行为列名 */
        $i = 0;
        for ($currentRow = 3; $currentRow <= $allRow; $currentRow++) {
            /*             * 从第A列开始输出 */
            // print_r($currentRow);
            //echo $currentSheet->getCellByColumnAndRow('B', $currentRow)->getValue();
            $cname = $currentSheet->getCellByColumnAndRow(ord('B') - 65, $currentRow)->getValue();

            $location = $currentSheet->getCellByColumnAndRow(ord('F') - 65, $currentRow)->getValue();
            // update loction
            echo $cname . "/" . $location;
            $temp = $this->db->query("SELECT * FROM staff_main where cname = '" . $cname . "'");

            if ($temp->row()) {
                $data['location'] = $location;
                //   $this->db->where('cname', $cname);
                $this->db->update('staff_main', $data);
                //  echo 'S';
            } else {
                //  echo $cname . "/" . $location;
                //  echo '<br>';
                //  $i++;
            }


            //   for ($currentColumn = 'A'; $currentColumn <= $allColumn; $currentColumn++) {
            //  echo $currentColumn;
            // echo $currentSheet->getCellByColumnAndRow(ord($currentColumn) - 65, $currentRow)->getValue();
//                $val = $currentSheet->getCellByColumnAndRow(ord($currentColumn) - 65, $currentRow)->getValue(); /*                 * ord()将字符转为十进制数 */
//                if ($currentColumn == 'A') {
//                    echo $val . "\t";
//                } else {
////echo $val;
//                    /*                     * 如果输出汉字有乱码，则需将输出内容用iconv函数进行编码转换，如下将gb2312编码转为utf-8编码输出 */
//                    echo iconv('utf-8', 'gb2312', $val) . "\t";
//                }
            //   }
        }
        echo $i;
//          $this->cismarty->assign("location", $lc);
//          $this->cismarty->display($this->sysconfig_model->templates() . '/temp/index.tpl');
    }

    function sms() {
        if ($this->dx_auth->is_role('2', FALSE)) {
            //   redirect($this->config->item('DX_deny_uri'), 'location');
        }
        //  $this->db->update('staff_sms', $data);
        // exit();

        $system = $this->db->query("
                                        SELECT  *
                                      FROM
                                        staff_temp
                                       order by id asc
                                    ");
        //    print_r($system->result());

        foreach ($system->result() as $row) {
            // echo $row->sms_number;
            //$rootId = $this->staffDeptName($row->itname);
            //   echo "$rootId<br>";
            $sms_number = $row->sms_number;
            $data['sms_ip'] = $row->ipAdrress;
            $this->db->where('sms_number', $sms_number);
            //  $this->db->update('staff_sms',$data);
            $this->db->from('staff_sms');
            $query = $this->db->get();
            if ($query->row()) {
                // echo $row->itname.'/'.$row->sms_number.'/'.$row->ipAdrress."<br>";
            } else {
                echo $row->itname . '/' . $row->sms_number . '/' . $row->ipAdrress . "<br>";
            }
            // $this->db->insert('staff_sms', $data1);
            //  
            if ($row->sms_number) {

                //   $data['sms_cat_id'] = 29;
                ////  $this->db->where('sms_number', $row->sms_number);
                // 
            }
        }
    }

    function staffAddress() {
        $system = $this->db->query("
                                        SELECT  *
                                      FROM
                                        staff_address
                                    ");
        foreach ($system->result() as $row) {
            $this->db->where('itname', $row->itname);
            $this->db->from('staff_main_temp_address');
            $query = $this->db->get();
            $staff = $query->row();
            if ($staff) {
                $data['sa_mobile'] = $staff->mob;
                $data['sa_tel'] = $staff->tel;
                $data['sa_tel_short'] = $staff->shortTel;
                $this->db->where('itname', $row->itname);
              //  $this->db->update('staff_address', $data);
            } else {
               $data['sa_mobile'] ='';
                $data['sa_tel'] = '';
                $data['sa_tel_short'] = '';
                $this->db->where('itname', $row->itname);
              //  $this->db->update('staff_address', $data);
            }
        }
    }
  function staffInAddress() {
        $system = $this->db->query("
                                        SELECT  *
                                      FROM
                                        staff_main
                                    ");
        foreach ($system->result() as $row) {

            
                $data['itname'] = $row->itname;
             
          //  $this->db->insert('staff_address', $data);
        }
    }
    function staffIpTemp() {
        if ($this->dx_auth->is_role('2', FALSE)) {
            //   redirect($this->config->item('DX_deny_uri'), 'location');
        }
        $system = $this->db->query("
                                        SELECT  *
                                      FROM
                                        sms_main_temp
                                       
                                    ");
        //    print_r($system->result());
        foreach ($system->result() as $row) {
            // echo $row->sms_number;
            //$rootId = $this->staffDeptName($row->itname);
            //   echo "$rootId<br>";
              $sms_number = $row->sms_number;
           // $data['itname'] = $row->itname;
          //  $data['sm_sap_status'] = 1;
          //  $data['sms_number'] = $row->sms_number;
         //   $data['sm_sap_person'] = 'Input';
         //   $data['sm_sap_time'] = date('Y-m-d');
            $data['sms_status'] = 2;
            //  $this->db->insert("staff_sms", $data);
            $this->db->where('sms_number', $sms_number);
              $this->db->update('sms_main',$data);
            /*  $this->db->from('sms_main');
              $query = $this->db->get();
              if ($query->row()) {
              // echo $row->itname.'/'.$row->sms_number.'/'.$row->ipAdrress."<br>";
              } else {
              echo $row->sms_number . '/' . $row->sms_ip . "<br>";
              $data['sms_number'] = $row->sms_number;
              $data['sms_cat_id'] = $row->sms_cat_id;
              $data['sms_input'] = 'system';
              $data['sms_input_time'] = '2014-0514';
              $this->db->insert('sms_main', $data);
              }
             * 
             */
            // $this->db->insert('staff_sms', $data1);
            //  
            if ($row->sms_number) {

                //   $data['sms_cat_id'] = 29;
                ////  $this->db->where('sms_number', $row->sms_number);
                // 
            }
        }
    }

    function staffDeptName($itname) {
        if ($this->dx_auth->is_role('2', FALSE)) {
            //  redirect($this->config->item('DX_deny_uri'), 'location');
        }
        $itname = $itname;
        $this->load->model('staff_model');
        $staff = $this->staff_model->get_staff_by("itname = '" . $itname . "'");
        // print_r($staff);
        if ($staff) {
            if ($staff->rootid) {
                $this->load->model('deptsys_model');
                $ouTemp = $this->deptsys_model->get_dept_val('id = ' . $staff->rootid);
                //print_r($ouTemp);
                $deptId = $ouTemp->id;
                if ($deptId) {
                    return $deptId;
                } else {
                    return 0;
                }
            } else {
                return 0;
            }
        } else {
            return 'null';
        }
        //print_r($sms_dept);
    }

    function smsqqq() {
        if ($this->dx_auth->is_role('2', FALSE)) {
            redirect($this->config->item('DX_deny_uri'), 'location');
        }
        //  $this->db->update('staff_sms', $data);
        // exit();
        $system = $this->db->query("
                                        SELECT 
                                      *
                                      FROM
                                        sms_main_temp
                                      
                                    ");
        // print_r($renzi->result());

        foreach ($system->result() as $row) {
            //  print_r($row);

            $query = $this->db->query("
                                        SELECT 
                                        staff_main.itname
                                      FROM
                                        staff_main
                                        where staff_main.cname = '$row->sms_cname';
                                    ");
            $staff = $query->row();
            print_r($staff);
            if ($staff) {
                $data['itname'] = $staff->itname;
            } else {
                $data['itname'] = '';
                if ($row->sms_cname == '公用') {
                    $data['itname'] = '公用';
                }
                if ($row->sms_cname == '森马宿舍') {
                    $data['itname'] = '森马宿舍';
                }
            }
            $data['sm_sap_status'] = 1;
            $data['sms_number'] = $row->sms_number;
            $data['sm_sap_person'] = 'Input';
            $data['sm_sap_time'] = date('Y-m-d');
            $data['use_time'] = date('Y-m-d');
            $this->db->insert("staff_sms", $data);
        }
    }

    function tempLoadSystem() {
        // 数组导入专用
        if ($this->dx_auth->is_role('2', FALSE)) {
            redirect($this->config->item('DX_deny_uri'), 'location');
        }
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

    function uptoad() {
        // 数组导入专用
        if ($this->dx_auth->is_role('2', FALSE)) {
            redirect($this->config->item('DX_deny_uri'), 'location');
        }
        $renzi = $this->db->query("SELECT * FROM staff_main order by  id   limit 3000,1000"); //from('staff_temp');where itname=''
        $i = 0;
        foreach ($renzi->result() as $row) {
            $this->load->library('adldaplibrary');
            $adldap = new adLDAP();
            // $collection = $adldap->user()->infoCollection($row->itname);

            $attributes = array(
                // "display_name" => $row->cname,
                //"office" => $row->location,
                "mobile" => "1" //$row->mobtel
            );


            $result = $adldap->user()->modify($row->itname, $attributes);
            if ($result) {
                echo "Suc<br>";
            } else {
                echo $row->id . $row->cname . $row->location . '<br>';
            }

            $i++;
            //  echo $i;
        }
        echo $i;
    }

    function pwtoad() {
        // 数组导入专用
        if ($this->dx_auth->is_role('2', FALSE)) {
            redirect($this->config->item('DX_deny_uri'), 'location');
        }
        $key = $this->input->post('key');
        //echo $key;
        if ($key) {
            $itnameArray = explode(',', $key);

            //echo $new;
            //exit(); 
            $i = 0;
            foreach ($itnameArray as $in) {
                // echo $row;
                if ($in) {
                    $renzi = $this->db->query("SELECT * FROM staff_main where itname = '$in' order by  id limit 0,1000"); //from('staff_temp');where itname=''
                    //  foreach ($renzi->result() as $row) {
                    //  print_r($row);
                    // }
                    //  echo "sdfsdf";
                    // exit();
                    $row = $renzi->row();
                    if ($row) {
                        $this->load->library('adldaplibrary');
                        $adldap = new adLDAP();
                        $collection = $adldap->user()->infoCollection($row->itname);
                        // print_r($collection);
                        $attributes = array(
                            // "display_name" => $row->cname,
                            "password" => $row->password, //$row->password,
                                //"change_password" => false  // 定义用户首次登陆是否强制修改密码
                        );
                        $result = $adldap->user()->modify($row->itname, $attributes);
                        if ($result) {
                            echo $row->itname . "/Suc<br>"; //.$row->password . '<br>';
                        } else {
                            echo $row->id . $row->cname . $row->password . '<br>';
                        }

                        $i++;
                        //  echo $i;
                    } else {
                        echo $in . "/itname is Null<br>"; //.$row->password . '<br>';
                    }
                }
            }
            echo $i;
        } else {
            echo "Please enter ITNAME!";
        }
    }

    function pwtoadAll() {
        // 数组导入专用
        if ($this->dx_auth->is_role('2', FALSE)) {
            redirect($this->config->item('DX_deny_uri'), 'location');
        }
        echo '批量处理工具，谨慎使用！<br>';
        echo '修改 /temp/tempstaff/pwtoadAll , 然后使用！';
        exit();

        $this->authorization->check_permission($this->uri->segment(2), '4');

        $renzi = $this->db->query("SELECT * FROM staff_main  limit 0,1000"); //from('staff_temp');where itname=''
        $i = 0;
        foreach ($renzi->result() as $row) {
            //  print_r($row);
            // }
            //  echo "sdfsdf";
            // exit();

            if ($row) {
                $this->load->library('adldaplibrary');
                $adldap = new adLDAP();
                $collection = $adldap->user()->infoCollection($row->itname);
                // print_r($collection);
                $attributes = array(
                    // "display_name" => $row->cname,
                    "password" => $row->password, //$row->password,
                        //"change_password" => false  // 定义用户首次登陆是否强制修改密码
                );
                $result = $adldap->user()->modify($row->itname, $attributes);
                if ($result) {
                    echo $row->itname . "/Suc<br>"; //.$row->password . '<br>';
                } else {
                    echo $row->id . $row->cname . $row->password . '<br>';
                }

                $i++;
                //  echo $i;
            } else {
                echo "/itname is Null<br>"; //.$row->password . '<br>';
            }
        }

        echo $i;
    }

    function stafftemp() {
        if ($this->dx_auth->is_role('2', FALSE)) {
            redirect($this->config->item('DX_deny_uri'), 'location');
        }
        $temp = $this->db->query("SELECT * FROM staff_main where password = ''");
        foreach ($temp->result() as $row) {
            $row->itname;
        }
        exit();
        $renzi = $this->db->query("SELECT * FROM staff_main_renzi limit 0,2000"); //from('staff_temp');where itname=''
        // print_r($renzi->result());
        $i = 0;
        foreach ($renzi->result() as $row) {
            //echo $row->cname;
            //    echo '<br>';

            $temp = $this->db->query("SELECT * FROM staff_main where itname = '" . $row->itname . "'");
            if ($temp->row()) {
                //  print_r($temp->row());
                // str_replace(" ","",$temp->row()->itname);
//            $itname = explode('@',$temp->row()->itname);
//            // echo $row->cname;
//           echo $itname[0].'<br>';
                $data['password'] = $row->password;
                $this->db->where('itname', $row->itname);
                $this->db->update('staff_main', $data);
            } else {
                echo $row->cname . " " . $row->itname . " " . $row->password;
                echo '<br>';
                $i++;
            }
            // echo $row->cname."<br>";   
        }
        echo $i;
    }

}
?>


