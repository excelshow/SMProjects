<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" />
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo base_url() ?>assets/css/admin/reset.css" /> <!-- RESET -->
    <link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo base_url() ?>assets/css/admin/main.css" /> <!-- MAIN STYLE SHEET -->
    
    <!--[if lte IE 6]><link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo base_url() ?>assets/css/admin/main-ie6.css" /><![endif]--> <!-- MSIE6 -->
    
    <link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo base_url() ?>assets/css/admin/superfish.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery.treeTable.css" type="text/css" />
   
    <!-- GRAPHIC THEME -->
    <script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/jquery-1.4.1.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/switcher.js"></script>

    <script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/jquery.validate.pack.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/javascript/superfish.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/javascript/supersubs.js"></script>
   <!-- loading ymPromt  -->
    <script type="text/javascript" src="<?php echo base_url() ?>assets/ymPrompt/ymPrompt.js"></script>
    <link rel="stylesheet"  type="text/css" href="<?php echo base_url() ?>assets/ymPrompt/skin/black/ymPrompt.css" />
 


    <script type="text/javascript">

        $(document).ready(function(){
            $("ul.sf-menu").supersubs({
                minWidth:    10,   // minimum width of sub-menus in em units
                maxWidth:    27,   // maximum width of sub-menus in em units
                extraWidth:  1     // extra width can ensure lines don't sometimes turn over
                // due to slight rounding differences and font-family
            }).superfish();  // call supersubs first, then superfish, so that subs are
            // not display:none when measuring. Call before initialising
            // containing tabs for same reason.
        });

    </script>

    <title><?php // echo web_title; ?> - 网站管理系统</title>
</head>

<body>
  <div id="main">

        <!-- Tray -->
        <div id="tray" class="box">

            <p class="f-left box">
               <img src="<?php echo base_url() ?>assets/images/adminLogo.png" />
            </p>

            <p class="f-right">当前用户: <strong><?php echo $this->session->userdata('admin') ?> </strong>&nbsp;&nbsp;&nbsp;&nbsp;<!--<a href="/cn/index.php/admin/home">中文版</a> | <a href="/en/index.php/admin/home">英文版</a> -->&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong><a href="<?php echo site_url('admin/log/logout') ?>" id="logout">退出</a></strong></p>

        </div> <!--  /tray -->

        <!-- Menu -->
        <div  id="menu" >
 			<ul id="sample-menu-5" class="sf-menu" >

                <li><a href="<?php echo site_url("admin/home") ?>" >后台首页</a></li>
				 <li><a href="<?php echo site_url("admin/staff") ?>" >员工管理</a></li>
                 <li><a href="<?php echo site_url("admin/admanager") ?>" >组织架构</a></li>
                <li class="current"><a href="<?php echo site_url("admin/user") ?>" ><span>系统管理</span></a>
                    <ul>
                        <li><a href="<?php echo site_url("admin/user") ?>" >管理员配置</a></li>
                        <li><a href="<?php echo site_url("admin/group") ?>" >管理员分组</a></li>
                    </ul>
                </li>
                 
            <!--  <li><a href="<?php echo site_url("admin/attachment/list_files") ?>" >附件管理</a></li>-->
            </ul>
        </div> <!-- /header -->
        <div class="clearb h5"></div>
