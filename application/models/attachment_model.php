<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Attachment_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function upload() {

        if (!empty($_FILES)) {
            $name_array = explode("\.", $_FILES['Filedata']['name']);
            date_default_timezone_set("PRC");
            $post_time = date("Y-m-d H:i:s");
            $file_type = $name_array[count($name_array) - 1];
            $realname = md5($post_time + rand(0, 100)) . "." . $file_type;
            $folder = date("Y-m-d");
            $mypath = str_replace("-", "/", $folder);
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $targetPath = realpath('./attachments') . '/' . $mypath . '/';
            $targetFile = str_replace('//', '/', $targetPath) . $realname;
            if (!is_dir($targetPath))
                if (!mkdir(str_replace('//', '/', $targetPath), 0755, true))
                    die("目录创建不成功");
            if (!move_uploaded_file($tempFile, $targetFile))
                die("文件移动失败");
            $data['real_name'] = $realname;
            $data['original_name'] = $_FILES['Filedata']['name'];
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

    function del($id) {
        $data['id'] = $id;
        $query = $this->db->query("select * from attachment where id=$id");
        if ($query->num_rows()) {
            foreach ($query->result() as $row) {
                $path = realpath("./attachments" . $row->path . "/" . $row->real_name);
                if (file_exists($path)) {
                    if (!unlink($path)) {
                        return "Error when delete";
                    }
                }
                if ($this->db->delete('attachment', $data))
                    return "ok";
                else
                    return "删除失败";
            }
        }
        return "数据中没有此附件记录";
    }

    function cover($id, $value) {
        $data['id'] = $id;
        $query = $this->db->query("select * from attachment where id=$id");
        if ($query->num_rows()) {
            $this->db->where($data);
            if ($this->db->update('attachment', array("is_cover" => $value)))
                return "ok";
            else
                return "操作失败";
        }else {
            return "数据中没有此附件记录";
        }
    }

    function get_id_by_name($name) {
        $query = $this->db->query("select id,path from attachment where real_name = '$name'");
        if ($query->num_rows()) {
            $data['exists'] = true;
            foreach ($query->result() as $row) {
                $data['info'] = $row;
            }
        } else {
            $data['exists'] = false;
        }
        return $data;
    }

    function get_att($where) {
        $this->db->select('*');
        $this->db->where($where);
        $this->db->from('attachment');
        $query = $this->db->get();
        return $query->result();
    }

    function list_files($path) {
        $this->load->helper('directory');
        $this->load->helper('file');
        $path = realpath($path);
        $list = directory_map($path, TRUE);
        $files = array();
        foreach ($list as $row) {
            $info = "";
            $info['folder'] = is_dir($path . '/' . $row) ? 1 : 0;
            $info['property'] = get_file_info($path . '/' . $row);
            $arr = split("/", $info['property']['name']);
            $info['property']['realname'] = $arr[count($arr) - 1];
            if ($info['folder'] == 0)
                $info['database'] = $this->get_id_by_name($info['property']['realname']);
            array_push($files, $info);
        }
        sort($files);
        return $files;
    }

    function file_del($path) {
        $this->load->helper('file');
        if (is_dir($path)) {
            delete_files($path, true);
            return "ok";
        } else {
            if (file_exists($path)) {
                if (!unlink($path)) {
                    return "Error when delete";
                } else {
                    return "ok";
                }
            } else {
                return "文件不存在";
            }
        }
    }

}