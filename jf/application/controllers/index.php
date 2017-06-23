<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Index extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->template = "ie8";
        $this->cismarty->assign("template", $this->template);
    }

    function index() {
       
        $itname = "";
        $this->cismarty->display($this->template . '/index.html');
                
        $this->LogViewDo($itname);
    }

    function LogViewDo($itname) {
        $this->load->model('index_model');
        $data['itname'] = $itname;
        $data['ipaddress'] = $this->input->ip_address();
        $data['logtime'] = date("Y-m-d h:i:s");
        $this->index_model->insert_log($data);
    }

    function getResult() {
        $data['itname'] = "";
        $data['ndDate'] = $this->input->post("ndDate");
        $data['zd'] = $this->input->post("zd");
        $data['amb'] = $this->input->post("amb");
        $data['rzrq'] = $this->input->post("rzrq");
        $data['gzd'] = $this->input->post("gzd");
        $data['fcs'] = $this->input->post("fcs");
        $data['cd'] = $this->input->post("cd");
        $data['jds'] = $this->input->post("jds");
        $data['bns'] = $this->input->post("bns");
        $data['nds'] = $this->input->post("nds");
        // echo date('Y', strtotime($data['ndDate']))-date('Y', strtotime($data['rzrq'])); 
        $f = 0;
        $zd = $data['zd'];
        // 职等分数计算
        $f += $this->zdjs($zd);
        // 工龄计算
        $f += $this->gljs($data['ndDate'], $data['rzrq']);
        // 特殊职位计算
        if ($data['amb'] == 1) {
            $f += 5;
        }
        // 房产计算
        if ($data['fcs'] == 0) {
            $f += 10;
        }
        // 绩效计算季度
        if ($data['jds'] > 0) {
            $f += 4;
        }
        // 绩效计算半年度
        if ($data['bns'] > 0) {
            $f += 8;
        }
        // 绩效计算年度
        if ($data['nds'] > 0) {
            $f += 16;
        }
        $data['total'] = $f;
        echo " " . $f . "";
        $this->submitDo($data);
    }

    function submitDo($data) {
        $this->load->model('index_model');
        $data['ipaddress'] = $this->input->ip_address();
        $data['subtime'] = date("Y-m-d h:i:s");
        $this->index_model->insert_item($data);
    }

    //工龄计算
    function gljs($nd, $rz) {
        $ndt = date('Y', strtotime($nd));
        $year = date('Y', strtotime($rz));
        $n = $ndt - $year;
        $f = 0;
        if ($n >= 10) {
            $f = 20;
        } else {
            switch ($n) {
                case 3:
                    $f = 6;
                    break;
                case 4:// 
                    $f = 8;
                    break;
                case 5:// 
                    $f = 10;
                    break;
                case 6:// 
                    $f = 12;
                    break;
                case 7:// 
                    $f = 14;
                    break;
                case 8:// 
                    $f = 16;
                    break;
                case 8:// 
                    $f = 18;
                    break;
                default:
                    $f = 0;
            }
        }
        return $f;
    }

    // 职等分数计算
    function zdjs($zd) {
        $f = 0;
        switch ($zd) {
            case 5:
                $f = 20;
                break;
            case 6:// 
                $f = 30;
                break;
            case 7:// 
                $f = 40;
                break;
            case 8:// 
                $f = 50;
                break;
            case 9:// 
                $f = 60;
                break;
            case 10:// 
                $f = 70;
                break;
            case 11:// 
                $f = 80;
                break;
            default:
                $f = 20;
        }
        return $f;
    }

}
