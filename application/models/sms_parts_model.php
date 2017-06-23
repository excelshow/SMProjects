<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sms_parts_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->tableParts = "sms_parts";
        $this->tablePartsCategory = "sms_parts_category";
        $this->tablesStaffParts = "staff_sms_parts";
    }

    function sms_parts_result($limit = 0, $offset = 0, $condition = "") {

        $this->db->select('*');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from($this->tableParts);
        $this->db->order_by("sp_id", 'desc');
        $query = $this->db->get();
        // print_r($query);
        return $query->result();
    }

    function sms_parts_row($condition = "") {
        $this->db->select('*');

        if ($condition) {
            $this->db->where($condition);
        }

        $this->db->from($this->tableParts);

        $query = $this->db->get();
        return $query->row();
    }

    function sms_parts_add($data) {
        date_default_timezone_set("PRC");
        if ($this->db->insert($this->tableParts, $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function sms_parts_edit($data) {
        $sp_id = @$data['sp_id'];
        date_default_timezone_set("PRC");
        if ($sp_id) {
            $this->db->where("sp_id", $sp_id);
            $this->db->update($this->tableParts, $data);
            return "ok";
        } else {
            return false;
        }
    }

    function sms_parts_category_result($limit = 0, $offset = 0, $condition = "") {
        $this->db->select('*');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from($this->tablePartsCategory);
        $this->db->order_by("sc_sort", 'desc');
        $query = $this->db->get();
        // print_r($query);
        return $query->result();
    }

    function sms_parts_category_row($condition = "") {
        $this->db->select('*');

        if ($condition) {
            $this->db->where($condition);
        }

        $this->db->from($this->tablePartsCategory);

        $query = $this->db->get();
        return $query->row();
    }

    ////
    ///////////////////////////////////////////////////////
    function staff_sms_parts_result($limit = 0, $offset = 0, $condition = "") {

        $this->db->select('*');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from($this->tablesStaffParts);
        $this->db->order_by("use_time", 'desc');
        $query = $this->db->get();
        // print_r($query);
        return $query->result();
    }

    function staff_sms_parts_row($condition = "") {

        $this->db->select('*');

        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from($this->tablesStaffParts);
        $this->db->order_by("use_time", 'desc');
        $query = $this->db->get();
        // print_r($query);
        return $query->row();
    }

    function staff_sms_parts_edit($data) {
        $ss_id = @$data['ss_id'];
        date_default_timezone_set("PRC");
        if ($ss_id) {
            $this->db->where("ss_id", $ss_id);
            $this->db->update($this->tablesStaffParts, $data);
            return "ok";
        } else {
            return false;
        }
    }

    /*
     * 借用 
     * 
     */

    function sms_jieyong_result($limit = 0, $offset = 0, $condition = "") {

        $this->db->select('*');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('sms_jieyong');
        $this->db->order_by("sj_id", 'desc');
        $query = $this->db->get();
        // print_r($query);
        return $query->result();
    }

    function sms_jieyong_row($condition = "") {
        $this->db->select('*');

        if ($condition) {
            $this->db->where($condition);
        }

        $this->db->from('sms_jieyong');

        $query = $this->db->get();
        return $query->row();
    }

    function sms_jieyong_add($data) {
        date_default_timezone_set("PRC");
        if ($this->db->insert('sms_jieyong', $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function sms_jieyong_edit($data) {
        $sj_id = @$data['sj_id'];
        date_default_timezone_set("PRC");
        if ($sj_id) {
            $this->db->where("sj_id", $sj_id);
            $this->db->update('sms_jieyong', $data);
            return "ok";
        } else {
            return false;
        }
    }

    function sms_jieyong_edit_oa($sj_number, $data) {

        date_default_timezone_set("PRC");
        if ($sj_number) {
            $this->db->where("sj_number", $sj_number);
            $this->db->update('sms_jieyong', $data);
            return "ok";
        } else {
            return false;
        }
    }

    function staff_sms_jieyong_edit($condition, $data) {
        date_default_timezone_set("PRC");
        
        if ($condition) {
            $this->db->where($condition);
             $this->db->update('sms_jieyong', $data);
        }
        
    }

    function staff_sms_jieyong_result($limit = 0, $offset = 0, $condition = "") {

        $this->db->select('*');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_sms_jieyong');
        $this->db->order_by("use_time", 'desc');
        $query = $this->db->get();
        // print_r($query);
        return $query->result();
    }

    function staff_sms_jieyong_row($condition = "") {

        $this->db->select('*');

        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_sms_jieyong');
        $this->db->order_by("use_time", 'desc');
        $query = $this->db->get();
        // print_r($query);
        return $query->row();
    }

}

?>