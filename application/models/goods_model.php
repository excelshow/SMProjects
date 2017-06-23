<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Goods_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_goodss($limit = 0, $offset = 0, $condition = "") {
        $this->db->select('*');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('goods');
        $this->db->join('goods_category', "goods_category.class_id = goods.class_id");
        $query = $this->db->get();
        return $query->result();
    }

    function get_goods_byid($id) {

        $this->db->select('*');

        $this->db->from('goods');
        $this->db->where('goods_id', $id);
        $query = $this->db->get();
        // return $this->db->get($this->_product_table);
        return $query->row();
    }

    function get_num_rows($condition = "") {
        if ($condition)
            $this->db->where($condition);
        return $this->db->count_all_results('goods');
    }

    function get_attachments($data) {
        $this->db->where($data);
        $query = $this->db->get('attachment');
        return $query->result();
    }

    function get_links($goods_id) {
        if ($attachments = $this->input->post('attachment')) {
            $attachments .= "0";
            $attachment = explode("s", $attachments);
            $this->db->where_in('id', $attachment);
            $data['goods_id'] = $goods_id;
            $this->db->update('attachment', $data);
        }
    }

    function add($data) {
        date_default_timezone_set("PRC");
        $data['post_time'] = date("Y-m-d H:i:s");

        if ($this->db->insert("goods", $data)) {
            return "ok";
        } else {
            return false;
        }
        //$query = $this->db->query("select max(goods_id) as goods_id from goods");
//			foreach ($query->result() as $row) {
//				$this->get_links($row->goods_id);
//			}
    }

    function edit($data) {
        $goods_id = array_pop($data);
        date_default_timezone_set("PRC");
        $data['post_time'] = date("Y-m-d H:i:s");
        $this->db->where('goods_id', $goods_id);
        //$this->db->update('goods',$data);
        //$this->get_links($goods_id);
        if ($this->db->update('goods', $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function del($data) {
        $this->db->where($data);
        if ($this->db->update('goods', array('is_del' => 1))) {
            return "ok";
        } else {
            return false;
        }
    }

    function multi_del($data) {
        $this->db->where_in('goods_id', $data);
        if ($this->db->update('goods', array('is_del' => 1))) {
            return true;
        } else {
            return false;
        }
    }

    function physical_del($data) {
        $this->db->where_in('goods_id', $data);
        $query = $this->db->delete('goods');
        $this->db->where_in('goods_id', $data);

        return true;
    }

    function recover($data) {
        $this->db->where_in('goods_id', $data);
        if ($this->db->update('goods', array('is_del' => 0))) {
            return true;
        } else {
            return false;
        }
    }

}