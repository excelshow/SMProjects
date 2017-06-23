<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Item extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('item_model');
        $this->sysconfig_model->sysInfo(); // set sysInfo 
        $navAction = "";
        $this->cismarty->assign("navAction", $navAction);
    }

    function pagination($linkUrl, $linkModel, $uri_segment, $condition = "") {
        $this->load->library('pagination');
        $config['base_url'] = site_url($linkUrl);
        $config['total_rows'] = $this->item_model->$linkModel($condition);
        $config['per_page'] = '20';
        $config['uri_segment'] = $uri_segment;
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }

    function index() {
        $this->authorization->check_auth();
        // load menu start 
        $key = $this->input->get("keyword");
        if ($key) {
            $where['key'] = $key;
        } else {
            $where['key'] = "";
        }

        $type = $this->uri->segment(4, 0);
        if ($type > 0) {
            if ($type == 1) {
                $where['type'] = "是";
            } else {
                $type = 2;
                $where['type'] = "否";
            }
        } else {
            $type = 0;
            $where['type'] = '';
        }
        // load menu end
        $data['list'] = $this->item_model->get_result(20, $this->uri->segment(5, 0), $where);
        $linkUrl = "admin/item/index/" . $type . "\?keyword=" . $key;
        $linkModel = "get_num_rows";

        $uri_segment = 5;

        $data['links'] = $this->pagination($linkUrl, $linkModel, $uri_segment, $where);
        $reUrl = $this->input->server('HTTP_REFERER');
        $this->cismarty->assign("type", $type);
        $this->cismarty->assign("key", $key);
        $this->cismarty->assign("data", $data);
        $this->cismarty->assign("links", $data['links']);

        // exit();
        $this->cismarty->display('admin/item.tpl');
    }

    function log_view() {
        $this->authorization->check_auth(); 
        $where ="";
        $data['list'] = $this->item_model->get_log_result(20, $this->uri->segment(5, 0), $where);
        $linkUrl = "admin/item/log_view/";
        $linkModel = "get_log_num_rows";

        $uri_segment = 5;

        $data['links'] = $this->pagination($linkUrl, $linkModel, $uri_segment, $where);
        $reUrl = $this->input->server('HTTP_REFERER');
          $this->cismarty->assign("type", 1);
        $this->cismarty->assign("data", $data);
        $this->cismarty->assign("links", $data['links']);
        // exit();
        $this->cismarty->display('admin/log_view.tpl');
    }

}
