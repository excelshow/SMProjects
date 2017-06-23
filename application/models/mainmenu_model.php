<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mainmenu_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->library('DX_Auth');
    }

    function showMenu() {
        $menu = NULL;
        $isUrl = $this->uri->rsegment(1);
        $conResult = $this->sysconfig_model->get_controller();
        if ($conResult) {
            if ($this->dx_auth->is_role('admin')) {
                foreach ($conResult as $row){
                        if($isUrl == $row->scUri){
                            $css = 'Current';
                        }else{
                           $css =''; 
                        }
                        $row->menuInfo = "<li  class=$css ><a href='" . site_url($row->scUrl) . "' ><span>$row->scName</span></a>";
                        $menu[] =$row;  
                }
            }else{
                foreach ($conResult as $row){
                    $pTrue = $this->dx_auth->check_controller_permissions($row->scUri);
                    if ($pTrue) {
                        if($isUrl == $row->scUri){
                            $css = 'Current';
                        }else{
                           $css =''; 
                        }
                        $row->menuInfo = "<li  class=$css ><a href='" . site_url($row->scUrl) . "' ><span>$row->scName</span></a>";
                        $menu[] =$row;
                    }
                }
            }
        } else {
            echo '功能模块无法加载！';
        }
        //print_r($menu);
        $this->cismarty->assign("mainmenu", $menu);
    }

    function menuShow($type = '') {


        $var['mtools'] = " <li  ><a href='" . site_url("mtools") . "' ><span>管理员工具</span></a>
                        <ul> 
                              <li><a href=" . site_url("temp/tempstaff") . ' target=_blank>数据同步</a></li>
                              <li><a href=' . site_url("mtools/outdata") . ' target=_blank >数据导出</a></li>
                              <li><a href=' . site_url("xmlrpc_api/ims_client/index") . " target=_blank>Webservice</a></li>
                            </ul>
                       </li>";

        $var['system'] = " <li  ><a href='" . site_url("system") . "' ><span>系统配置</span></a>
                            <ul>

                                  <li><a href=" . site_url("system/userlist") . " >管理员配置</a></li>
                                  <li><a href=" . site_url("system/group") . " >管理员分组</a></li>
                                  <li><a href=" . site_url("system") . " >系统配置</a></li>
                                </ul>
                          </li>";
        $var['sms'] = " <li ><a href=" . site_url("sms/sms/index") . " >资产管理</a>
                            <ul>
                       <li
                       
                       ><a href=" . site_url("sms/sms/index") . " >用户资产</a></li>
                       <li
                        class=current

                       ><a href=" . site_url("sms/sms/sms_main_list") . " >资产信息</a></li>
                       <li ><a href=" . site_url("sms/sms/finance") . " >财务审核</a></li>
                       <li><a href=" . site_url("sms/sms/history_list") . " >历史报表</a></li>
                       <li ><a href=" . site_url("sms/sms/reports") . " >统计报表</a></li>
                        <li><a href=" . site_url("sms/config") . " >资产配置</a></li>
                     </ul>

                       </li>";
        $var['jf_sms'] = " <li ><a href=" . site_url("permissions/sms/jf_sms") . " >机房资产</a></li>";
       $var['permissions'] = " <li ><a href=" . site_url("permissions/index/staff_system") . " >用户权限</a></li>";
        $var['staff'] = " <li ><a href=" . site_url("staff/staff/index") . " >用户管理</a></li>";
        $var['dept'] = " <li ><a href=" . site_url("dept/deptsys") . " >组织架构</a>
                        <ul><li><a href='" . site_url("dept/deptsys") . "' >系统组织架构</a></li>
                            <li><a href=" . site_url("dept/admanager/dept_ad") . " >AD组织架构</a></li>
                            </ul></li>";
        $var['home'] = "<li> 
                            <a href=" . site_url("home") . ">后台首页</a>
                            </li>";
        if ($type) {
            return $var[$type];
        } else {
            return $var;
        }
    }

    function sysInfo() {
        $this->cismarty->assign("base_url", $this->syscon()->domain);
        $this->cismarty->assign("web_title", $this->syscon()->title);
        $this->cismarty->assign("web_keyword", $this->syscon()->keyword);
        $this->cismarty->assign("web_contents", $this->syscon()->contents);
        $this->cismarty->assign("web_template", $this->syscon()->templates);
        $this->cismarty->assign("applist", $this->syscon()->applist);
        $this->cismarty->assign("web_copyright", $this->syscon()->copyright);
        $this->cismarty->assign("web_copyrighturl", $this->syscon()->copyrighturl);
    }

    function templates() {
        return $this->syscon()->templates;
    }

}
