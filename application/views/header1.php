<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $page_title ?> - <?php echo web_title() ?></title>

<link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo base_url()?>assets/css/main.css" /> <!-- MAIN STYLE SHEET -->

     
<link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo base_url()?>assets/css/superfish.css" /> 
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/jquery.hiAlerts.css" type="text/css" />
    <!-- GRAPHIC THEME -->
    <script type="text/javascript" src="<?php echo base_url()?>assets/javascript/jquery-1.4.1.min.js"></script>

	 <script type="text/javascript" src="<?php echo base_url()?>assets/ddsmoothmenu.js"></script>
     <script type="text/javascript" src="<?php echo base_url()?>assets/javascript/jquery.hiAlerts-min.js"></script>
  	   <script type="text/javascript" src="<?php echo base_url()?>assets/javascript/superfish.js"></script>
     <script type="text/javascript" src="<?php echo base_url()?>assets/javascript/supersubs.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>assets/javascript/jquery.validate.pack.js"></script>

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

</head>

<body>
<div class="page">
<div id="main">

	<!-- Tray --> 
	<div id="tray" class="box">
		 
		<p class="f-left box" style="font-size:14px;">
			<img src="../../assets/fileico/vslog.jpg"  /> 
	  </p>
 
	</div> <!--  /tray -->
   
	<!-- Menu -->
	 
	<div  id="menu" >
 
		<ul id="sample-menu-5" class="sf-menu" >
			
		 
        <li><a href="<?php echo site_url("")?>" >首 页</a></li>
		  <li><a href="<?php echo site_url("news")?>" ><span>新闻中心</span></a></li>
          <li><a href="<?php echo site_url("down")?>" >下载中心</a></li> 		

               

             </ul> 
    </div>
	  <!-- /header -->
	<div style="height:10px;"></div>

