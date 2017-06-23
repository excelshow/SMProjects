<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sms_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function sms_main_list($limit = 0, $offset = 0, $condition = "") {
        $this->db->distinct();
        $this->db->select('sms_main.sms_number');
        $this->db->select('sms_main.*');
        $this->db->select('sms_category.*');
        $this->db->select('sms_local.*');
        $this->db->select('sms_affiliate.*');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('sms_main');
        $this->db->join('sms_category', 'sms_main.sms_cat_id = sms_category.sc_id', 'inner');
        $this->db->join('sms_local', 'sms_main.sms_local = sms_local.sl_id', 'inner');
        $this->db->join('sms_affiliate', 'sms_affiliate.sa_id = sms_main.sa_id', 'inner');
        $this->db->order_by("sms_main.sms_input_time", 'desc');
        $query = $this->db->get();
        // print_r($query);
        return $query->result();
    }

    function sms_jf_list($limit = 0, $offset = 0, $condition = "") {
        $this->db->select('*');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }

        if ($condition) {
            $this->db->where($condition);
        }

        $this->db->from('sms_jf_main');
        $this->db->order_by("sms_number", 'desc');
        $query = $this->db->get();
        return $query->result();
    }

//////////////////////////
    function sms_jf_category_by($condition = "") {
        $this->db->select('*');

        if ($condition) {
            $this->db->where($condition);
        }

        $this->db->from('sms_jf_category');

        $query = $this->db->get();
        return $query->row();
    }

///////////////
    function sms_jf_by($condition = "") {
        $this->db->select('*');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('sms_jf_main');
        $query = $this->db->get();
        return $query->row();
    }

    ////
    function sms_jf_editbyId($data) {
        $sms_id = @$data['sms_id'];
        date_default_timezone_set("PRC");
        if ($sms_id) {
            $this->db->where("sms_id", $sms_id);
            $this->db->update('sms_jf_main', $data);
            return "ok";
        } else {
            return false;
        }
    }

////////////////////////////////
    function sms_number_by($condition = "") {
        $this->db->select('*');

        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('sms_number');
        $this->db->order_by("sms_number", 'asc');
        $query = $this->db->get();
        return $query->row();
    }

////////////////////////////////
    function sms_number_list($condition = "") {
        $this->db->select('*');

        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('sms_number');
        $this->db->order_by("sms_number", 'asc');
        $query = $this->db->get();
        return $query->result();
    }

////////////////////////////////
    function sms_number_total($limit = 0, $offset = 0, $condition = "") {
        $this->db->select('*');

        $this->db->limit($limit, $offset);

        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('sms_number');
        $this->db->order_by("sms_number", 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function staff_sms_list($limit = 0, $offset = 0, $condition = "") {
        // $this->db->distinct();
        //  $this->db->select('staff_sms.sms_number');
        // $this->db->select('staff_main.cname');
        $this->db->select('staff_sms.*');

        //  $this->db->select('sms_category.*');
        // $this->db->select('staff_main.*');
        //   $this->db->select('staff_dept.deptName');
        //    $this->db->select('sms_local.sl_name');
        //   $this->db->select('sms_affiliate.sa_name');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_sms');
        // $this->db->join('staff_sms', 'sms_main.sms_number = staff_sms.sms_number', 'left');
        //   $this->db->join('sms_category', 'sms_main.sms_cat_id = sms_category.sc_id', 'inner');
        //  $this->db->join('staff_main', 'staff_main.itname = staff_sms.itname', 'inner');
        //    $this->db->join('staff_dept', 'staff_sms.dept_id = staff_dept.id', 'inner');
        //    $this->db->join('sms_local', 'sms_main.sms_local = sms_local.sl_id', 'inner');
        //     $this->db->join('sms_affiliate', 'sms_affiliate.sa_id = sms_main.sa_id', 'inner');
        $this->db->order_by("staff_sms.op_time desc,staff_sms.sms_number asc");
        $query = $this->db->get();
        return $query->result();
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function staff_sms_oa_register_list($limit = 0, $offset = 0, $condition = "") {

        $this->db->select('*');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_sms_oa_register');
        $this->db->order_by("reg_time Desc");
        $query = $this->db->get();
        return $query->result();
    }

    function staff_sms_oa_register_editbyNumber($data) {
        $sms_number = @$data['sms_number'];
        date_default_timezone_set("PRC");
        if ($sms_number) {
            $this->db->where("sms_number", $sms_number);
            $this->db->update('staff_sms_oa_register', $data);
            return "ok";
        } else {
            return false;
        }
    }

///////////////////////////////////////////////////////////
    function itname_chuku($condition = "") {
        $this->db->distinct();
        $this->db->select('reg_itname');
        //  $this->db->select('staff_sms_oa.*');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_sms_oa');
        $this->db->order_by("reg_time Desc");
        $query = $this->db->get();
        return $query->result();
    }

//////////////////
    function itname_chuku_row($condition = "") {
        //  $this->db->distinct();
        $this->db->select('');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_sms_oa');
        $this->db->order_by("reg_itname desc");
        $query = $this->db->get();
        return $query->first_row();
    }

///////////////////////////////////////////////////////////
    function staff_sms_oa_return_list($limit = 0, $offset = 0, $condition = "") {

        $this->db->select('*');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_sms_oa_tuicang');
        $this->db->order_by("st_itname desc");
        $query = $this->db->get();
        // print_r($query);
        return $query->result();
    }

    ///////////////////////////////////////////////////////////
    function staff_sms_oa_return_row($condition = "") {

        $this->db->select('*');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_sms_oa_tuicang');
        $query = $this->db->get();
        // print_r($query);
        return $query->row();
    }

    //////////////////
    function staff_sms_oa($limit = 0, $offset = 0, $condition = "") {

        $this->db->select('*');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_sms_oa');
        $this->db->order_by("reg_time desc");
        $query = $this->db->get();
        return $query->result();
    }

    //////////////////
    function staff_sms_oa_row($condition = "") {

        $this->db->select('*');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_sms_oa');

        //$this->db->order_by("reg_time asc");
        $query = $this->db->get();
        return $query->row();
    }

    ////////////////
    function staff_sms_oa_edit($data) {
        $so_id = @$data['so_id'];
        date_default_timezone_set("PRC");
        if ($so_id) {
            $this->db->where("so_id", $so_id);
            $this->db->update('staff_sms_oa', $data);
            return "ok";
        } else {
            return false;
        }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function staff_sms_history_list($limit = 0, $offset = 0, $condition = "") {

        $this->db->select('staff_sms.*');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_sms');
        $this->db->order_by("staff_sms.return_time desc,staff_sms.sms_number asc");
        $query = $this->db->get();
        return $query->result();
    }

    function sms_main_top($limit = 0, $offset = 0, $condition = "") {
        $this->db->select('*');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('sms_main');
        $query = $this->db->get();
        return $query->first_row();
    }

    function sms_main_by($condition = "") {
        $this->db->select('*');

        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('sms_main');
        $this->db->order_by("sms_id", 'desc');
        $query = $this->db->get();
        return $query->row();
    }

    function sms_main_num($condition = "") {
        if ($condition)
            $this->db->where($condition);
        return $this->db->count_all_results('sms_main');
    }

    function sms_main_add($data) {
        date_default_timezone_set("PRC");
        if ($this->db->insert("sms_main", $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function sms_jf_main_add($data) {
        date_default_timezone_set("PRC");
        if ($this->db->insert("sms_jf_main", $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function sms_main_scrap_add($data) {
        date_default_timezone_set("PRC");
        if ($this->db->insert("sms_main_scrap", $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function sms_main_edit($data) {
        $sms_id = @$data['sms_id'];
        date_default_timezone_set("PRC");
        if ($sms_id) {
            $this->db->where("sms_id", $sms_id);
            $this->db->update('sms_main', $data);
            return "ok";
        } else {
            return false;
        }
    }

    function sms_jf_main_edit($data) {
        $sms_id = @$data['sms_id'];
        date_default_timezone_set("PRC");
        if ($sms_id) {
            $this->db->where("sms_id", $sms_id);
            $this->db->update('sms_jf_main', $data);
            return "ok";
        } else {
            return false;
        }
    }

    function sms_main_editbyNumber($data) {
        $sms_number = @$data['sms_number'];
        date_default_timezone_set("PRC");
        if ($sms_number) {
            $this->db->where("sms_number", $sms_number);
            $this->db->update('sms_main', $data);
            return "ok";
        } else {
            return false;
        }
    }

    function sms_main_del($data) {
        $this->db->where_in('sms_id', $data);
        $query = $this->db->delete('sms_main');
        return true;
    }

    function sms_category_list($condition = "") {
        $this->db->select('*');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('sms_category');
        $this->db->order_by("sc_sort", 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function sms_jf_category_list($condition = "") {
        $this->db->select('*');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('sms_jf_category');
        $this->db->order_by("sc_sort", 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function sms_category_by($condition = "") {
        $this->db->select('*');

        if ($condition) {
            $this->db->where($condition);
        }

        $this->db->from('sms_category');

        $query = $this->db->get();
        return $query->row();
    }

    function sms_js_category_by($condition = "") {
        $this->db->select('*');

        if ($condition) {
            $this->db->where($condition);
        }

        $this->db->from('sms_category');

        $query = $this->db->get();
        return $query->row();
    }

    function sms_brand_list($condition = "") {
        $this->db->select('*');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('sms_brand');
        $this->db->order_by("sb_sort", 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function sms_brand_by($condition = "") {
        $this->db->select('*');

        if ($condition) {
            $this->db->where($condition);
        }

        $this->db->from('sms_brand');

        $query = $this->db->get();
        return $query->row();
    }

    function sms_category_add($data) {
        date_default_timezone_set("PRC");
        if ($this->db->insert("sms_category", $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function sms_category_edit($key, $data) {
        date_default_timezone_set("PRC");
        $sc_id = @$key;

        $this->db->where('sc_id', $sc_id);
        if ($this->db->update('sms_category', $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function sms_category_del($data) {
        $this->db->where_in('sc_id', $data);
        $query = $this->db->delete('sms_category');
        return true;
    }

    function sms_location_add($data) {
        date_default_timezone_set("PRC");
        if ($this->db->insert("sms_local", $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function sms_location_edit($key, $data) {
        date_default_timezone_set("PRC");
        $sl_id = @$key;

        $this->db->where('sl_id', $sl_id);
        if ($this->db->update('sms_local', $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function sms_location_del($data) {
        $this->db->where_in('sl_id', $data);
        $query = $this->db->delete('sms_local');
        return true;
    }

    function sms_local_list($condition) {
        $this->db->select('*');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('sms_local');
        $this->db->order_by("sl_sort", 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function sms_location_by($condition = "") {
        $this->db->select('*');

        if ($condition) {
            $this->db->where($condition);
        }

        $this->db->from('sms_local');

        $query = $this->db->get();
        return $query->row();
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function sms_affiliate() {
        $this->db->select('*');
        $this->db->from('sms_affiliate');
        $query = $this->db->get();
        return $query->result();
    }

    function sms_affiliate_by($condition = "") {
        $this->db->select('*');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('sms_affiliate');
        $query = $this->db->get();
        return $query->row();
    }

    //////////////////public search ///////////////////////////////////////////////////////////////////////////////////////////////
    function staff_sms_list_search($limit = 0, $offset = 0, $condition = "") {
        $this->db->distinct();
        $this->db->select('staff_sms.*');
        $this->db->select('sms_main.*');
        $this->db->select('sms_category.*');
        // $this->db->select('staff_main.cname');
        //    $this->db->select('staff_dept.deptName');
        $this->db->select('sms_local.*');
        $this->db->select('sms_affiliate.*');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_sms');
        $this->db->join('sms_main', 'staff_sms.sms_number = sms_main.sms_number', 'inner');
        $this->db->join('sms_category', 'sms_main.sms_cat_id = sms_category.sc_id', 'inner');
        //  $this->db->join('staff_main', 'staff_main.itname = staff_sms.itname', 'inner');
        //   $this->db->join('staff_dept', 'staff_sms.dept_id = staff_dept.id', 'inner');
        $this->db->join('sms_local', 'sms_main.sms_local = sms_local.sl_id', 'inner');
        $this->db->join('sms_affiliate', 'sms_affiliate.sa_id = sms_main.sa_id', 'inner');
        $this->db->order_by("staff_sms.use_time", 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    //////////////////public search ///////////////////////////////////////////////////////////////////////////////////////////////
    function staff_sms_row_search($limit = 0, $offset = 0, $condition = "") {
        $this->db->distinct();
        $this->db->select('staff_sms.*');
        $this->db->select('sms_main.*');
        $this->db->select('sms_category.*');
        // $this->db->select('staff_main.cname');
        //    $this->db->select('staff_dept.deptName');
        $this->db->select('sms_local.*');
        $this->db->select('sms_affiliate.*');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_sms');
        $this->db->join('sms_main', 'staff_sms.sms_number = sms_main.sms_number', 'inner');
        $this->db->join('sms_category', 'sms_main.sms_cat_id = sms_category.sc_id', 'inner');
        //  $this->db->join('staff_main', 'staff_main.itname = staff_sms.itname', 'inner');
        //   $this->db->join('staff_dept', 'staff_sms.dept_id = staff_dept.id', 'inner');
        $this->db->join('sms_local', 'sms_main.sms_local = sms_local.sl_id', 'inner');
        $this->db->join('sms_affiliate', 'sms_affiliate.sa_id = sms_main.sa_id', 'inner');
        $this->db->order_by("staff_sms.use_time", 'desc');
        $query = $this->db->get();
        return $query->row();
    }

    function staff_sms_num($condition = "") {
        if ($condition)
            $this->db->where($condition);
        return $this->db->count_all_results('staff_sms');
    }

    function staff_sms_by($condition = "") {
        $this->db->select('*');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_sms');
        $this->db->order_by("sm_id", 'desc');
        $query = $this->db->get();
        return $query->row();
    }

    function sms_oa_caigou_by($condition = "") {
        $this->db->select('*');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('sms_oa_caigou');
        $this->db->order_by("scg_id", 'desc');
        $query = $this->db->get();
        return $query->row();
    }

    function sms_oa_caigou_batch_list($limit = 0, $offset = 0, $condition = "") {

        $this->db->select('*');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('sms_oa_caigou_batch');
        // $this->db->order_by("reg_time desc");
        $query = $this->db->get();
        return $query->result();
    }

    function sms_oa_caigou_batch_by($condition = "") {
        $this->db->select('*');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('sms_oa_caigou_batch');
        $this->db->order_by("scb_id", 'desc');
        $query = $this->db->get();
        return $query->row();
    }

    function sms_oa_caigou_list($limit = 0, $offset = 0, $condition = "") {

        $this->db->select('*');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('sms_oa_caigou');
        $this->db->order_by("reg_time desc");
        $query = $this->db->get();
        return $query->result();
    }

    function sms_oa_caigou_add($data) {
        date_default_timezone_set("PRC");
        if ($this->db->insert("sms_oa_caigou", $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function sms_oa_caigou_edit($data) {
        $scg_id = @$data['scg_id'];
        date_default_timezone_set("PRC");
        if ($scg_id) {
            $this->db->where("scg_id", $scg_id);
            $this->db->update('sms_oa_caigou', $data);
            return "ok";
        } else {
            return false;
        }
    }

    function sms_number_del($data) {
        $this->db->where_in('sms_number', $data);
        $query = $this->db->delete('sms_number');
        return true;
    }

    function sms_oa_caigou_batch_del($sms_number) {
        $this->db->where_in('sms_number', $sms_number);
        $query = $this->db->delete('sms_oa_caigou_batch');
        return true;
    }

    function staff_sms_by_join($condition = "") {
        $this->db->distinct();
        $this->db->select('staff_sms.*');
        $this->db->select('sms_main.*');
        $this->db->select('staff_main.*');
        // $this->db->select('staff_dept.deptName');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_sms');
        $this->db->join('sms_main', 'staff_sms.sms_number = sms_main.sms_number', 'inner');
        $this->db->join('staff_main', 'staff_sms.itname = staff_main.itname', 'inner');
        // $this->db->join('staff_dept', 'staff_sms.dept_id = staff_dept.id', 'inner');
        //  

        $query = $this->db->get();
        return $query->row();
    }

    function get_sms_dept($condition = "") {
        // $this->db->select('*');
        $this->db->distinct();
        $this->db->select('staff_sms.*');
        //  $this->db->select('staff_sms.*');
        $this->db->select('sms_main.sms_number,sms_main.sms_name,sms_main.sms_cat_id,sms_main.sms_type,sms_main.sms_brand,sms_main.sms_size,sms_main.sms_unit');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('staff_sms');
        $this->db->join('sms_main', 'staff_sms.sms_number = sms_main.sms_number', 'inner');

        $this->db->order_by("staff_sms.sm_id", 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function staff_sms_add($data) {
        date_default_timezone_set("PRC");
        if ($this->db->insert("staff_sms", $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function staff_sms_edit($data) {
        $sm_id = @$data['sm_id'];
        $sms_number = @$data['sms_number'];
        $dept_id = @$data['dept_id'];
        date_default_timezone_set("PRC");
        if ($sm_id) {
            $this->db->where("sm_id", $sm_id);
        }
        if ($sms_number) {
            $this->db->where("sms_number", $sms_number);
        }
        // if ($dept_id) {
        //  $this->db->where("dept_id", $dept_id);
        //  }
        if ($this->db->update("staff_sms", $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function staff_sms_oa_return_add($data) { 
        date_default_timezone_set("PRC"); 
        if ($this->db->insert("staff_sms_oa_tuicang", $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function staff_sms_oa_return_edit($data) {
        $st_id = @$data['st_id'];
        date_default_timezone_set("PRC");
        if ($st_id) {
            $this->db->where("st_id", $st_id);
        }

        if ($this->db->update("staff_sms_oa_tuicang", $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function multi_del($data) {
        $this->db->where_in('sms_main_id', $data);
        if ($this->db->update('sms_main', array('is_del' => 1))) {
            return true;
        } else {
            return false;
        }
    }

    function physical_del($data) {
        $this->db->where_in('sms_main_id', $data);
        $query = $this->db->delete('sms_main');
        //$this->db->where_in('sms_main_id',$data);
        //$query = $this->db->delete('attachment');
        return true;
    }

    function recover($data) {
        $this->db->where_in('sms_main_id', $data);
        if ($this->db->update('sms_main', array('is_del' => 0))) {
            return true;
        } else {
            return false;
        }
    }

    // 导入数据专用

    function get_category_all() {
        $records = array();
        $query = $this->db->query('SELECT * FROM sms_category ORDER BY sc_sort');
        foreach ($query->result() as $row) {
            $row->children = $this->get_category_child_num($row->sc_id);
            $records[] = $row;
        }
        return $records;
    }

    function get_category_child_num($classid) {
        $query = $this->db->query("select count(*) as children from sms_category where sc_root='$classid'");
        foreach ($query->result() as $row) {
            return $row->children;
        }
    }

    function get_in_tree($array, $pid = 0, $y, &$tdata = array()) {
        foreach ($array as $row) {
            if ($row->sc_root == $pid) {
                $n = $y + 1;
                $row->deep = $y;
                $tdata[] = $row;
                $this->get_in_tree($array, $row->sc_id, $n, $tdata);
            }
        }
        return $tdata;
    }

    function get_category() {
        return $this->get_in_tree($this->get_category_all(), 0, 0);
    }

    function number_list($limit = 0, $offset = 0, $condition = "") {

        $this->db->select('*');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('sms_number');
        $this->db->order_by("sms_number", 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function number_list_by($condition = "") {
        $this->db->select('*');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('sms_number');
        $this->db->order_by("sms_number", 'desc');
        $query = $this->db->get();
        return $query->row();
    }

    function sms_number_add($data) {
        date_default_timezone_set("PRC");
        if ($this->db->insert("sms_number", $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function sms_number_edit($val, $data) {
        date_default_timezone_set("PRC");
        $this->db->where('sms_number', $val);
        if ($this->db->update('sms_number', $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function location_list($limit = 0, $offset = 0, $condition = "") {

        $this->db->select('sms_local.*');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('sms_local');
        $this->db->order_by("sl_sort", 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function sms_lizhi_add($data) {
        date_default_timezone_set("PRC");
        if ($this->db->insert("sms_lizhi", $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function sms_lizhi_edit($val, $data) {
        date_default_timezone_set("PRC");
        $this->db->where('oa_number', $val);
        if ($this->db->update('sms_lizhi', $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function sms_lizhi_row($where) {
        date_default_timezone_set("PRC");
        if ($where) {
            $this->db->where($where);
        }
        $this->db->from('sms_lizhi');
        $query = $this->db->get();
        return $query->row();
    }
 function get_email_configuration_row($where) {
    	date_default_timezone_set("PRC");
    	if ($where) {
    		$this->db->where($where);
    	}
    	$this->db->from('email_config');
    	$query = $this->db->get();
    	return $query->row();
    }

    function email_configuration_edit($data) {
    	$id = @$data['id'];
    	date_default_timezone_set("PRC");
    	if ($id) {
    		$this->db->where("id", $id);
    		$this->db->update('email_config', $data);
    		return "ok";
    	} else {
    		return false;
    	}
    }
    
    function email_configuration_add($data) {
    	date_default_timezone_set("PRC");
    	$result = 	$this->db->insert('email_config', $data);
    	if ($result) {   	
    		return "ok";
    	} else {
    		return false;
    	}
    }
    
    function get_email_configuration($where){
    	date_default_timezone_set("PRC");
    	if ($where) {
    		$this->db->where($where);
    	}
    	$this->db->from('email_config');
    	$query = $this->db->get();
    	return $query->result();
    }
	
    function get_newstaff_namelist($oanumber){
    	$this->db->select('staff_main.cname,staff_sms_oa_register.reg_itname,staff_address.sa_mobile');
    	$this->db->from('staff_sms_oa_register');
    	$this->db->join('staff_address', 'staff_sms_oa_register.reg_itname = staff_address.itname', 'inner');
    	$this->db->join('staff_main', 'staff_sms_oa_register.reg_itname = staff_main.itname', 'inner');
    	$this->db->where("staff_sms_oa_register.oa_number",$oanumber);
    	$this->db->group_by('staff_sms_oa_register.reg_itname');
    	$query = $this->db->get();
    	return $query->result();
    }
    
    function get_newstaff_oanumber(){
    	$this->db->select('id,oanumber');
    	$this->db->from('staff_newsms');
    	$this->db->where("sendstatus",1);
    	$this->db->order_by("sendtime", 'desc');
    	$query = $this->db->get();
    	return $query->row();
    }
    
    function update_newstaff_sms($data){
    	date_default_timezone_set("PRC");
    	$this->db->where('oanumber', $data['oanumber']);
    	if ($this->db->update('staff_newsms', $data)) {
    		return "ok";
    	} else {
    		return false;
    	}
    }

}

?>