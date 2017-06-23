<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class System extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('Form_validation');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('DX_Auth');
        $this->load->library('DX_Auth_system');

        $this->dx_auth->check_uri_permissions();
        $this->sysconfig_model->sysInfo(); // set sysInfo
        $this->mainmenu_model->showMenu();
        $this->load->model('dx_auth/users', 'users');
        $menuCurrent = $this->showConMenu();
        $this->cismarty->assign("menuController", $menuCurrent);
        $this->cismarty->assign("urlF", $this->uri->segment(2));
        $this->cismarty->assign("urlS", $this->uri->segment(3));
        $this->cismarty->assign("pageTitle", '系统配置 - ');
    }

    function pagination() {
        $this->load->library('pagination');
        $config['base_url'] = site_url('user/view');
        $config['total_rows'] = $this->user_model->get_num_rows();
        $config['per_page'] = '50';
        $config['uri_segment'] = 4;
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }

    function showConMenu() {
        $showmenu = "";
        $showmenu .= "  <li><a href=" . site_url("system/system/userlist") . " >管理员配置</a></li>
                        <li><a href=" . site_url("system/system/roles") . " >角色管理</a></li>
                        <li><a href=" . site_url("system/system/permissions") . " >角色权限</a></li>
                        <li><a href=" . site_url("system") . " >系统配置</a></li>";

        return $showmenu;
    }

// user function
    function index() {
        $this->load->model('sysconfig_model');
        $result = $this->sysconfig_model->syscon();
        $this->cismarty->assign("data", $result);
        $this->cismarty->display($this->sysconfig_model->templates() . '/system/system_syscon.tpl');
    }

    function userlist() {

        // Search checkbox in post array
        foreach ($_POST as $key => $value) {
            // If checkbox found
            if (substr($key, 0, 9) == 'checkbox_') {
                // If ban button pressed
                if (isset($_POST['ban'])) {
                    // Ban user based on checkbox value (id)
                    $this->users->ban_user($value);
                }
                // If unban button pressed
                else if (isset($_POST['unban'])) {
                    // Unban user
                    $this->users->unban_user($value);
                } else if (isset($_POST['reset_pass'])) {
                    // Set default message
                    $data['reset_message'] = 'Reset password failed';

                    // Get user and check if User ID exist
                    if ($query = $this->users->get_user_by_id($value) AND $query->num_rows() == 1) {
                        // Get user record				
                        $user = $query->row();

                        // Create new key, password and send email to user
                        if ($this->dx_auth->forgot_password($user->username)) {
                            // Query once again, because the database is updated after calling forgot_password.
                            $query = $this->users->get_user_by_id($value);
                            // Get user record
                            $user = $query->row();

                            // Reset the password
                            if ($this->dx_auth->reset_password($user->username, $user->newpass_key)) {
                                $data['reset_message'] = 'Reset password success';
                            }
                        }
                    }
                }
            }
        }

        /* Showing page to user */

        // Get offset and limit for page viewing
        $offset = (int) $this->uri->segment(3);
        // Number of record showing per page
        $row_count = 100;

        // Get all users
        $data['users'] = $this->users->get_all($offset, $row_count)->result();
        //  print_r($data); 
        $this->load->model('dx_auth/roles', 'roles');
        $data['roles'] = $this->roles->get_all()->result();
        $this->cismarty->assign("data", $data);
        $this->cismarty->display($this->sysconfig_model->templates() . '/system/userlist.tpl');
        //$this->load->view('user',$data);
    }

    function roles() {
        $this->load->model('dx_auth/roles', 'roles');
        $this->load->model('dx_auth/permissions', 'permissions');
        /* Database related */
        // If Add role button pressed
        if ($this->input->post('add')) {
            // Create role
            if ($this->input->post('role_name')) {
                $this->roles->create_role($this->input->post('role_name'), $this->input->post('role_parent'));
            }
        } else if ($this->input->post('delete')) {
            // Loop trough $_POST array and delete checked checkbox
            foreach ($_POST as $key => $value) {
                // If checkbox found
                if (substr($key, 0, 9) == 'checkbox_') {
                    // Delete role
                    $this->roles->delete_role($value);
                }
            }
        }

        // Get all roles from database
        $data = '';
        $result = $this->roles->get_all_by('id > 1')->result();
        //  print_r($result);
        foreach ($result as $row) {
            $row->allowed_uris = $this->permissions->get_permission_value($row->id, 'uri');
            $data[] = $row;
        }
        // print_r($data);
        $this->cismarty->assign("data", $data);
        $this->cismarty->display($this->sysconfig_model->templates() . '/system/roles.tpl');
    }

    function permissions() {

        function trim_value(&$value) {
            $value = trim($value);
        }

        $this->load->model('dx_auth/roles', 'roles');
        $this->load->model('dx_auth/dx_permissions', 'dx_permissions');

        if ($this->input->post('save')) {
            // Convert back text area into array to be stored in permission data
            // save contollar
            //  echo "////";
            $allowed_uris = $this->input->post('conTrue');
            if ($allowed_uris) {
                array_walk($allowed_uris, 'trim_value');
                $this->dx_permissions->set_permission_value($this->input->post('role'), 'uri', $allowed_uris);
            }

            //save contollar permession
            $fTrue = $this->input->post();
            $permission_data = $this->dx_permissions->get_permission_data($this->input->post('role'));
            $scPerTemp = $this->sysconfig_model->get_controller_permission();
            if ($scPerTemp) {
                foreach ($scPerTemp as $rowSc) {
                    if ($this->input->post($rowSc->scpValue)) {
                        $permission_data[$rowSc->scpValue] = 1;
                    } else {
                        $permission_data[$rowSc->scpValue] = 0;
                    }
                }
            }

            $this->dx_permissions->set_permission_data($this->input->post('role'), $permission_data);
        }

        /* Showing page to user */

        // Default role_id that will be showed
        $role_id = $this->input->post('role') ? $this->input->post('role') : 2;
        // Get all role from database
        $data['roles'] = $this->roles->get_all_by('id > 0')->result();
        $data['roles_perm'] = $this->dx_auth->get_role_data($role_id);
        //  print_r($data);
        // Get allowed uri permissions
        $data['conResult'] = '';
        $conList = array();
        $conTemp = $this->sysconfig_model->get_controller('scType = 1');
        // print_r($conTemp);

        foreach ($conTemp as $rowt) {
            $scPer = $this->sysconfig_model->get_controller_permission('scId = ' . $rowt->scId);
            //  print_r($scPer);
            $scPermission = array();
            if ($scPer) {
                foreach ($scPer as $rowsc) {

                    if ($this->dx_permissions->get_permission_value($role_id, $rowsc->scpValue)) {
                        $rowsc->scTrue = 1;
                    } else {
                        $rowsc->scTrue = 0;
                    }
                    $scPermission[] = $rowsc;
                }
            }
            $rowt->scPerArra = $scPermission;
            $conList[] = $rowt;
        }
        //   print_r($conList);

        $data['allowed_uris'] = $this->dx_permissions->get_permission_value($role_id, 'uri');
        // echo "////////";
        //print_r($data['allowed_uris']);
        $data['conResult'] = '';
        foreach ($conList as $rowc) {
            $rowc->uriTrue = '';
            $rowc->uriTrue = 0;
            //echo $rowc->scUri;
            $uriTemp = $this->dx_auth_system->check_controller_permissions($rowc->scUri, $role_id); //"$rowc->scUri";
            //  echo "////////";
            //  echo $uriTemp;
            //    echo "/$rowc->scUri/";
            //  print_r( $this->session->userdata());
            // echo $uriTemp;
            if ($data['allowed_uris']) {
                if ($rowc->scUri) {
                    if ($uriTemp == 1) {
                        //  echo $rowc->scUri;
                        $rowc->uriTrue = 1;
                    } else {
                        if ($data['allowed_uris']) {
                            if (in_array("/$rowc->scUri/", $data['allowed_uris'])) {
                                $rowc->uriTrue = 1;
                            } else {
                                $rowc->uriTrue = 0;
                            }
                        }
                    }
                }
            }
            $data['conResult'][] = $rowc;
        }
        // print_r( $data['conResult']);
        $this->cismarty->assign("roleId", $role_id);
        $this->cismarty->assign("data", $data);
        $this->cismarty->display($this->sysconfig_model->templates() . '/system/permissions.tpl');
    }

    function user_get_post() {
        $data['username'] = $this->input->post('username');
        if ($this->uri->segment(2) == "add")
            $data['userpass'] = md5($this->input->post('userpass'));
        $data['group_id'] = $this->input->post('user_group');
        //$data['group_id'] = $this->input->post('user_group');
        $data['email'] = $this->input->post('email');
        $data['mid'] = $this->input->post('mid');
        if ($this->uri->segment(2) == "user_edit")
            $data['uid'] = $this->input->post('uid');
        return $data;
    }

    function get_post_pass() {
        $data['userpass'] = md5($this->input->post('b_userpass'));

        //$data['group_id'] = $this->input->post('user_group');

        $data['uid'] = $this->input->post('uid');
        //print_r($data);
        return $data;
    }

    function user_add() {

        if ($this->input->post('submit'))
        //   print_r($this->get_post());
        //   exit();
            $data['username'] = $this->input->post('username');
        $password = $this->input->post('b_userpass');
        $date['password'] = crypt($this->dx_auth->_encode($password));
        $data['email'] = $this->input->post('email');
        $this->dx_auth->register($data['username'], $date['password'], $data['email']);
        echo $ok;
    }

    function user_edit() {

        if ($this->input->post('submit'))
        // print_r($this->user_get_post());
            $id = $this->input->post('uid');
        $date['email'] = $this->input->post('email');
        $date['role_id'] = $this->input->post('user_group');
        $date['username'] = $this->input->post('username');

        if ($this->users->set_user($id, $date))
            echo 'ok';
    }

    function user_editpass() {
        if ($this->input->post('submit')) {
            $id = $this->input->post('uid');
            $password = $this->input->post('b_userpass');
            $date['password'] = crypt($this->dx_auth->_encode($password));
            if ($this->users->set_user($id, $date))
                echo 'ok';
        }
    }

    function user_del() {
        if ($uid = $this->input->post('uid')) {
            $id = $uid;
            if ($msg = $this->users->delete_user($id)) {
                echo $msg;
            } else {
                echo "删除操作失败,原因可能是当前记录不存在！";
            }
        }
    }

    function get_post() {
        $data['username'] = $this->input->post('username');
        if ($this->uri->segment(3) == "user_add")
            $data['userpass'] = md5($this->input->post('userpass'));
        $data['group_id'] = $this->input->post('user_group');
        //$data['group_id'] = $this->input->post('user_group');
        $data['email'] = $this->input->post('email');
        $data['mid'] = $this->input->post('mid');
        if ($this->uri->segment(3) == "edit")
            $data['uid'] = $this->input->post('uid');
        return $data;
    }

// user function end
// group function
    function group() {

        $data['groups'] = $this->group_model->get_groups(10, $this->uri->segment(4, 0));
        $data['links'] = $this->pagination();

        $this->cismarty->assign("groups", $data['groups']);
        $this->cismarty->assign("links", $data['links']);

        $this->cismarty->display($this->sysconfig_model->templates() . '/group.tpl');
        // $this->load->view('group', $data);
    }

    function group_get_post() {
        $data['group_name'] = $this->input->post('group_name');
        $data['permissions'] = $this->input->post('permission');
        $data['makes'] = $this->input->post('makes');
        if ($this->uri->segment(2) == "group_edit")
            $data['group_id'] = $this->input->post('group_id');
        return $data;
    }

    function group_add() {

        if ($this->input->post('submit'))
            if ($msg = $this->group_model->add($this->group_get_post()))
                echo $msg;
    }

    function group_edit() {

        if ($this->input->post('submit'))
            if ($msg = $this->group_model->edit($this->group_get_post()))
                echo $msg;
    }

    function group_del() {

        if ($group_id = $this->input->post('group_id')) {
            $data['group_id'] = $group_id;
            if ($msg = $this->group_model->del($data)) {
                echo $msg;
            } else {
                echo "删除操作失败,原因可能是当前记录不存在！";
            }
        }
    }

    // group function end
}
