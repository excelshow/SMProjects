<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Homepage_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_adpics() {
        $this->db->select('*');
        $this->db->where("hType = 1");
        $this->db->from('homepage');
        $this->db->order_by("homepage.hSort", 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function get_newproducts() {
        $this->db->select('*');
        $this->db->where("hType = 2");
        $this->db->from('homepage');
        $this->db->order_by("homepage.hSort", 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function get_homepage_byid($id) {

        $this->db->select('*');

        $this->db->from('homepage');
        $this->db->where('hId', $id);
        $query = $this->db->get();
        // return $this->db->get($this->_product_table);
        return $query->row();
    }

    function get_num_rows($condition = "") {
        if ($condition)
            $this->db->where($condition);
        return $this->db->count_all_results('homepage');
    }

    function get_attachments($data) {
        $this->db->where($data);
        $query = $this->db->get('attachment');
        return $query->result();
    }

    function add($data) {
        date_default_timezone_set("PRC");
        $data['post_time'] = date("Y-m-d H:i:s");

        if ($this->db->insert("homepage", $data)) {
            return "ok";
        } else {
            return false;
        }
        //$query = $this->db->query("select max(gallery_id) as gallery_id from gallery");
//			foreach ($query->result() as $row) {
//				$this->get_links($row->gallery_id);
//			}
    }

    function edit($data) {
        $id = array_pop($data);
        date_default_timezone_set("PRC");

        $this->db->where('hId', $id);
        //$this->db->update('gallery',$data);
        //$this->get_links($gallery_id);
        if ($this->db->update('homepage', $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function physical_del($data) {
        $this->db->where_in('hId', $data);
        $query = $this->db->delete('homepage');
        $this->db->where_in('hId', $data);

        return true;
    }

    function recover($data) {
        $this->db->where_in('gallery_id', $data);
        if ($this->db->update('homepage', array('is_del' => 0))) {
            return true;
        } else {
            return false;
        }
    }

}