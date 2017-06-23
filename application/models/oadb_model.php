<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Oadb_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->DBOA = $this->load->database("oadb", true);
    }
    function sms_category_add($data) {
        date_default_timezone_set("PRC");
        if ($this->DBOA->insert("sms_category", $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function sms_category_edit($key, $data) {
         $this->DBOA = $this->load->database("oadb", true);
        date_default_timezone_set("PRC");
        $sc_id = @$key;

        $this->DBOA->where('sc_id', $sc_id);
        if ($this->DBOA->update('sms_category', $data)) {
            return "ok-oadb";
        } else {
            return false;
        }
    }

    function sms_category_del($data) {
        $this->DBOA->where_in('sc_id', $data);
        $query = $this->DBOA->delete('sms_category');
        return true;
    }

}
