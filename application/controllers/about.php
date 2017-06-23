<?php

class About extends Controller {

    function __construct() {
        parent::Controller();
        $this->load->model('menu_model');
		$this->load->model('info_model');
		$this->load->model('article_model');
    }

    function index() {
         
        //load Menu   layout for  header.php
         $data['menuType'] = $this->menu_model->get_menuTypes();
         $data['menu'] = $this->menu_model->get_menus();

		 /* load Nenu type 
		 	Menu's URL  to Menu Type 
		 	Type to load layout
		 */
		$menuUrl = $this->uri->segment(1);
		$data['menuInfo'] = $this->menu_model->get_menu_byUrl($menuUrl); 
		$menuType = $data['menuInfo']->typeId;  // 1 = informaiton, 2 = news,  3 = products, 4 = Gallery   from  tabale:menuType
		 $meunId = $data['menuInfo']->id;
		 $condition = "classid = ". (int)$meunId;
		 $data['Info'] = $this->info_model->get_info_byKey($condition);
		 $data['page_title'] = $data['menuInfo']->menuName;
		 $this->load->view('about_layout', $data);
	 
    }
 
}