<?php
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 require_once( APPPATH . 'libraries/Smarty/Smarty.class.php' );
 
 class Cismarty extends smarty {
 
     var $CI;
 
     public function __construct()
     {
        parent::__construct();
       $this->CI =& get_instance();
	      $this->template_dir = "templates"; //.web_template()模板存放目录
                $this->compile_dir =  "templates_c"; //编译目录
                $this->cache_dir =  "cache";//缓存目录
                $this->caching = 0;
                //$this->cache_lifetime = 120; //缓存更新时间
                $this->debugging = false;
                $this->compile_check = true; //检查当前的模板是否自上次编译后被更改；如果被更改了，它将重新编译该模板。
                //$this->force_compile = true; //强制重新编译模板
                //$this->allow_php_templates= true; //开启PHP模板
                $this->left_delimiter = "{%"; //左定界符
                $this->right_delimiter = "%}"; //右定界符
       
     }
 
 }