<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once(dirname(__FILE__) . '/adldap/src/adLDAp.php');

class CI_Adldaplibrary {

    function UserAccountControl($data) {
        $adldap = new adLDAP();
        $result = $adldap->user()->info($data, array("pwdlastset", "useraccountcontrol"));
        //print_r($result);
        if ($result[0]['useraccountcontrol'][0]) {
            if ($result[0]['useraccountcontrol'][0] == 514) {
                return "禁用";
            } else {
                return "正常";
            }
        } else {
            return "无帐号";
        }
//                            $collection = $adldap->user()->infoCollection("fengxiaoning");
//                            //print_r( $collection);
//                            echo "user info2<br>";
//                            print_r($collection->displayName);
    }
function UserAccountInfo($data) {
        $adldap = new adLDAP();
        $result =  $adldap->user()->infoCollection("fengxiaoning"); //$adldap->user()->info("lizhendong");
       // print_r($result);
        return $result;

//                            $collection = $adldap->user()->infoCollection("fengxiaoning");
//                            //print_r( $collection);
//                            echo "user info2<br>";
//                            print_r($collection->displayName);
    }
    // dept 组织结构list
    function OuList($data) {
        $adldap = new adLDAP();
        $result = $adldap->folder()->listing(array('Semir'), adLDAP::ADLDAP_FOLDER, true, "folder"); ///,adLDAP::ADLDAP_FOLDER, false
        //print_r ($result);
        return $result;
    }

    // user / staff  用户list
    function OuListUser($data) {
        $adldap = new adLDAP();
        $result = $adldap->folder()->listing(array('Semir'), adLDAP::ADLDAP_FOLDER, true, "user"); ///,adLDAP::ADLDAP_FOLDER, false
        //print_r ($result);
        return $result;
    }

}

?>