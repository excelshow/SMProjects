<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Rtx_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->helper('text');
    }

    public $serverIp = "192.168.0.100";
    public $serverPort = "8006";

    function userAdd($name, $pwd, $cname, $gender, $email, $dept, $olddept="") {
        $RootObj = new COM("RTXSAPIRootObj.RTXSAPIRootObj");
        $RootObj->ServerIP = $this->serverIp;
        $RootObj->ServerPort = $this->serverPort;
        $UserManagerObj = $RootObj->UserManager;

        $UserManagerObj->AddUser($this->utog($name), 0);
        $decode_pwd = $pwd;
        $UserManagerObj->SetUserPwd($this->utog($name), $this->utog($decode_pwd)); //设置用户密码
        $UserManagerObj->SetUserBasicInfo($this->utog($name), $this->utog($cname), $gender, "", $this->utog($email), "", 0);
        if ($dept) {
            $DeptManagerObj = $RootObj->DeptManager;
            $DeptManagerObj->AddUserToDept($this->utog($name), "", $this->utog($dept), false);
        }
    }

    function userModify($name, $pwd, $cname, $gender,$email, $dept, $olddept="") {
        $RootObj = new COM("RTXSAPIRootObj.RTXSAPIRootObj");
        $RootObj->ServerIP = $this->serverIp;
        $RootObj->ServerPort = $this->serverPort;
        $UserManagerObj = $RootObj->UserManager;
        // $UserManagerObj->AddUser($nick, 0);   //添加用户
        if ($pwd) {
            $decode_pwd = $pwd;
 
        $UserManagerObj->SetUserPwd($this->utog($name), $this->utog($decode_pwd)); //设置用户密码
           
           
        }
        $UserManagerObj->SetUserBasicInfo($this->utog($name), $this->utog($cname), $gender, "", $this->utog($email), "", 0);

        // print_r($UserManagerObj);
    }
     function userMove($name, $olddept, $dept) {
        $RootObj = new COM("RTXSAPIRootObj.RTXSAPIRootObj");
        $RootObj->ServerIP = $this->serverIp;
        $RootObj->ServerPort = $this->serverPort;
        $DeptManagerObj = $RootObj->DeptManager;
        if ($olddept){
             $DeptManagerObj->AddUserToDept($this->utog($name), $this->utog($olddept), $this->utog($dept),false);
        }else{
            $DeptManagerObj->AddUserToDept($this->utog($name),"", $this->utog($dept),false);
        }
    }
  function userDel($name) {
        $RootObj = new COM("RTXSAPIRootObj.RTXSAPIRootObj");
        $RootObj->ServerIP = $this->serverIp;
        $RootObj->ServerPort = $this->serverPort;
        $UserManagerObj = $RootObj->UserManager;
        $UserManagerObj->DeleteUser($this->utog($name)); // 修改部门
    }
    
    function deptAdd($deptName, $ParentDept="") {
        $RootObj = new COM("RTXSAPIRootObj.RTXSAPIRootObj");
        $RootObj->ServerIP = $this->serverIp;
        $RootObj->ServerPort = $this->serverPort;
        $DeptManagerObj = $RootObj->DeptManager;
        //echo $deptName."/".$ParentDept;
        $DeptManagerObj->AddDept($this->utog($deptName), $this->utog($ParentDept)); // Add部门
    }

    function deptModify($name, $newname) {
        $RootObj = new COM("RTXSAPIRootObj.RTXSAPIRootObj");
        $RootObj->ServerIP = "192.168.0.100";
        $RootObj->ServerPort = "8006";
        $DeptManagerObj = $RootObj->DeptManager;

        $DeptManagerObj->SetDeptName($this->utog($name), $this->utog($newname)); // 修改部门
    }

    function deptDel($name) {
        $RootObj = new COM("RTXSAPIRootObj.RTXSAPIRootObj");
        $RootObj->ServerIP = $this->serverIp;
        $RootObj->ServerPort = $this->serverPort;
        $DeptManagerObj = $RootObj->DeptManager;
        $DeptManagerObj->DelDept($this->utog($name), 1); // 修改部门
    }

    function utog($val) {
        //return iconv("UTF-8", "GBK//IGNORE", $val);
		return mb_convert_encoding($val, "GBK", "UTF-8");
    }

}