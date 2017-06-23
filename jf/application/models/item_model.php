<?php

class item_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'ag_item';
    }

    function get_result($limit = 0, $offset = 0, $condition = "") {
        $where = "";
        $this->db->select('*');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        if ($condition) {
            if ($condition['type']) {
                //  $this->db->like('settype', $condition['type']); 
                $where = "settype like '%" . $condition['type'] . "%'";
            }
            if ($condition['key']) {
                /* $this->db->like('zznumber', $condition['key']);
                  $this->db->or_like('zzname', $condition['key']);
                  $this->db->or_like('yxarea', $condition['key']);
                  $this->db->or_like('mdnumber', $condition['key']);
                  $this->db->or_like('mdname', $condition['key']);
                  $this->db->or_like('settype', $condition['key']);
                  $this->db->or_like('pici', $condition['key']);
                 * 
                 */
                if ($where) {
                    $where .= " and ";
                } else {
                    $where = "";
                }
                $where .= "(zznumber  like '%" . $condition['key'] . "%' or zzname like '%" . $condition['key'] . "%' or  yxarea like '%" . $condition['key'] ."%' or  mdnumber like '%" . $condition['key'] ."%' or  mdname like '%" . $condition['key'] ."%' or  pici like '%" . $condition['key'] ."%' ) ";
            }
        }
        if ($where) {
            $this->db->where($where);
        }
        //explode($delimiter, $string)
        $this->db->from($this->table);

        //  $this->db->join('menu', "menu.id = article.classId");
        $this->db->order_by('id desc');
        $query = $this->db->get();
        return $query->result();
    }

    function get_item_row($condition = "") {
        $this->db->select('mdnumber');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->first_row();
    }

    function get_num_rows($condition = "") {
        $where ="";
         if ($condition) {
            if ($condition['type']) {
                //  $this->db->like('settype', $condition['type']); 
                $where = "settype like '%" . $condition['type'] . "%'";
            }
            if ($condition['key']) {
                /* $this->db->like('zznumber', $condition['key']);
                  $this->db->or_like('zzname', $condition['key']);
                  $this->db->or_like('yxarea', $condition['key']);
                  $this->db->or_like('mdnumber', $condition['key']);
                  $this->db->or_like('mdname', $condition['key']);
                  $this->db->or_like('settype', $condition['key']);
                  $this->db->or_like('pici', $condition['key']);
                 * 
                 */
                if ($where) {
                    $where .= " and ";
                } else {
                    $where = "";
                }
                $where .= "(zznumber  like '%" . $condition['key'] . "%' or zzname like '%" . $condition['key'] . "%' or  yxarea like '%" . $condition['key'] ."%' or  mdnumber like '%" . $condition['key'] ."%' or  mdname like '%" . $condition['key'] ."%' or  pici like '%" . $condition['key'] ."%' ) ";
            }
        }
        if ($where) {
            $this->db->where($where);
        }
        return $this->db->count_all_results($this->table);
    }
 function get_log_result($limit = 0, $offset = 0, $condition = "") {
        $where = "";
        $this->db->select('*');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
         
        if ($condition) {
            $this->db->where($condition);
        }
        //explode($delimiter, $string)
        $this->db->from("ag_log");

        //  $this->db->join('menu', "menu.id = article.classId");
        $this->db->order_by('id desc');
        $query = $this->db->get();
        return $query->result();
    }
    
     function get_log_num_rows($condition = "") {
         
        if ($condition) {
            $this->db->where($condition);
        }
        return $this->db->count_all_results("ag_log");
    }
    
    
    function item_insert($data) {
        if ($ins = $this->db->insert($this->table, $data)) {
            //  var_dump($ins);
            return "ok";
        } else {
            return false;
        }
    }

    function item_update($data) {
        $this->db->where('mdnumber', $data['mdnumber']);
        $set['settype'] = $data['settype'];
        $set['pici'] = $data['pici'];
        if ($this->db->update($this->table, $set)) {
            return "ok";
        } else {
            return false;
        }
    }

    function del($data) {
        $this->db->where($data);
        if ($this->db->update($this->table, array('is_del' => 1))) {
            return "ok";
        } else {
            return false;
        }
    }

    // laod menu end 
}
