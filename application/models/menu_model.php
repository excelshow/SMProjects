<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Menu_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_menu_byid($id) {

        $this->db->select('*');

        $this->db->from('menu');
        $this->db->where('id', $id);
        $query = $this->db->get();
        // return $this->db->get($this->_product_table);
        return $query->row();
    }
    function get_menu_byUrl($url) {

        $this->db->select('*');

        $this->db->from('menu');
        $this->db->where('menuUrl', $url);
        $query = $this->db->get();
        // return $this->db->get($this->_product_table);
        return $query->row();
    }
    function upload() {
        if (!empty($_FILES)) {
            $name_array = explode("\.", $_FILES['userfile']['name']);
            date_default_timezone_set("PRC");
            $post_time = date("Y-m-d H:i:s");
            $file_type = $name_array[count($name_array) - 1];
            $realname = md5($post_time + rand(0, 100)) . "." . $file_type;
            $folder = date("Y-m-d");
            $mypath = str_replace("-", "/", $folder);
            $tempFile = $_FILES['userfile']['tmp_name'];
            $targetPath = realpath('./attachments/menu') . '/' . $mypath . '/';
            $targetFile = str_replace('//', '/', $targetPath) . $realname;
            if (!is_dir($targetPath))
                if (!mkdir(str_replace('//', '/', $targetPath), 0755, true))
                    die("目录创建不成功");
            if (!move_uploaded_file($tempFile, $targetFile))
                die("文件移动失败");


            $data['real_name'] = $realname;
            $data['original_name'] = $_FILES['userfile']['name'];
            $data['upload_time'] = $post_time;
            $data['path'] = '/' . $mypath;
            $data['file_type'] = $file_type;
            if ($this->db->insert('attachment', $data)) {
                $this->db->select_max('id');
                $query = $this->db->get('attachment');
                foreach ($query->result() as $row)
                    echo $row->id . "|" . $mypath . "/" . "|" . $realname;
            } else {
                echo "写入数据库不成功！";
            }
        }
    }

    function get_all() {
        $records = array();
        $query = $this->db->query('SELECT * FROM menu_type INNER JOIN menu ON (menu_type.id = menu.typeId) ORDER BY menuSort');
        foreach ($query->result() as $row) {
            $row->children = $this->get_child_num($row->id);
            $records[] = $row;
        }
        return $records;
    }

    function get_child_num($classid) {
        $query = $this->db->query("select count(*) as children from menu where parent_id='$classid'");
        foreach ($query->result() as $row) {
            return $row->children;
        }
    }

    function get_in_tree($array, $pid=0, $y, &$tdata=array()) {
        foreach ($array as $row) {
            if ($row->parent_id == $pid) {
                $n = $y + 1;
                $row->deep = $y;
                $tdata[] = $row;
                $this->get_in_tree($array, $row->id, $n, $tdata);
            }
        }
        return $tdata;
    }

    function get_menus() {
        return $this->get_in_tree($this->get_all(), 0, 0);
    }

    function get_menuTypes() {
        $records = array();
        $query = $this->db->query('SELECT * FROM menu_type ORDER BY id');
        foreach ($query->result() as $row) {

            $records[] = $row;
        }
        return $records;
    }
	function get_child_byId($parent_id) {
        $query = $this->db->query("select * from menu where parent_id='$parent_id'");
       return $query->result();
    }
    function move_menu($from, $to) {
        $data = array(
            'parent_id' => $to
        );
        $this->db->where('class_id', $from);
        $this->db->update('menu', $data);
        return true;
    }

    function insert($data) {
        if ($this->db->insert('menu', $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function update($id, $data) {
        $this->db->where('id', $id);
        if ($this->db->update('menu', $data)) {
            return "ok";
        } else {
            return false;
        }
    }

    function del($classid) {
        $this->db->where('id', $classid);
        $this->db->delete('menu');
    }

}