<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_gallerys($limit = 0, $offset = 0, $condition = "") {
        $this->db->select('*');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from('gallery');
        $this->db->order_by('gallery_id', 'desc');
        $this->db->join('gallery_category', "gallery_category.class_id = gallery.class_id");
        $query = $this->db->get();
        return $query->result();
    }

    function get_gallerys_byClassId($id) {
        $this->db->select('*');

        $this->db->from('gallery');
        $this->db->where('class_id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    function get_gallery_top($id) {
        $this->db->select('*');
        $this->db->from('gallery');
        $this->db->where('class_id', $id);
        $query = $this->db->get();
        return $query->first_row();
    }

    function get_gallery_byid($id) {

        $this->db->select('*');

        $this->db->from('gallery');
        $this->db->where('gallery_id', $id);
        $query = $this->db->get();
        // return $this->db->get($this->_product_table);
        return $query->row();
    }

    function get_num_rows($condition = "") {
        if ($condition)
            $this->db->where($condition);
        return $this->db->count_all_results('gallery');
    }

    function get_attachments($data) {
        $this->db->where($data);
        $query = $this->db->get('attachment');
        return $query->result();
    }

    function get_links($gallery_id) {
        if ($attachments = $this->input->post('attachment')) {
            $attachments .= "0";
            $attachment = explode("s", $attachments);
            $this->db->where_in('id', $attachment);
            $data['gallery_id'] = $gallery_id;
            $this->db->update('attachment', $data);
        }
    }

    function add($data) {
        date_default_timezone_set("PRC");
        $data['post_time'] = date("Y-m-d H:i:s");

        if ($this->db->insert("gallery", $data)) {
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
        $gallery_id = array_pop($data);
        date_default_timezone_set("PRC");
        $data['post_time'] = date("Y-m-d H:i:s");
        $this->db->where('gallery_id', $gallery_id);
        //$this->db->update('gallery',$data);
        //$this->get_links($gallery_id);
        if ($this->db->update('gallery', $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function del($data) {
        $this->db->where($data);
        if ($this->db->update('gallery', array('is_del' => 1))) {
            return "ok";
        } else {
            return false;
        }
    }

    function multi_del($data) {
        $this->db->where_in('gallery_id', $data);
        if ($this->db->update('gallery', array('is_del' => 1))) {
            return true;
        } else {
            return false;
        }
    }

    function physical_del($data) {
        $this->db->where_in('gallery_id', $data);
        $query = $this->db->delete('gallery');
        $this->db->where_in('gallery_id', $data);

        return true;
    }

    function recover($data) {
        $this->db->where_in('gallery_id', $data);
        if ($this->db->update('gallery', array('is_del' => 0))) {
            return true;
        } else {
            return false;
        }
    }

}