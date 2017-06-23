<?php

class Sysconfig_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->table = 'ag_sys_config';
    }

    function syscon() {

        $this->db->select('*');
        $query = $this->db->from($this->table);
        $query = $this->db->get();
        //return $query->result();
        return $query->row();
       // print_r($query->row());
    }

    function sysInfo() {
        $this->cismarty->assign("base_url", $this->syscon()->domain);
        $this->cismarty->assign("web_title", $this->syscon()->title);
        $this->cismarty->assign("web_keyword", $this->syscon()->keyword);
        $this->cismarty->assign("web_contents", $this->syscon()->contents);
        $this->cismarty->assign("web_template", $this->syscon()->templates);
        $this->cismarty->assign("web_copyright", $this->syscon()->copyright);
        $this->cismarty->assign("web_copyrighturl", $this->syscon()->copyrighturl);
    }

    function templates() {
        return $this->syscon()->templates;
    }

    function menu_all($con = false) {
        // admin  menu show

        $records = array();
        $this->load->model('menu_model');
        if ($con) {
            $where = 'parent_id = 0 and ' . $con;
        } else {
            $where = 'parent_id = 0 ';
        }
        $menut = $this->menu_model->get_menu_by($where);
        foreach ($menut as $row) {
            if ($con) {
                $wheret = 'parent_id = '.$row->id.' and ' . $con;
            } else {
                $wheret = 'parent_id = '.$row->id;
            }
            $row->menuTh = $this->menu_model->get_menu_by($wheret);
            $records[] = $row;
        }
       // print_r($records);
        //return $records;
        //  echo "sdfsdfsdf";
        $this->cismarty->assign("menuAll", $records);
    }

}
