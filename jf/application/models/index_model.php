<?php

class index_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table = 'ag_log';
    }

     
    

    function insert_log($data) {
        if ($ins = $this->db->insert($this->table, $data)) {
            //  var_dump($ins);
            return "true";
        } else {
            return false;
        }
    }
    function insert_item($data) {
        if ($ins = $this->db->insert('ag_item', $data)) {
            //  var_dump($ins);
            return "true";
        } else {
            return false;
        }
    }

   

    // laod menu end 
}
