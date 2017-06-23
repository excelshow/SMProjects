<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" />
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $page_title ?> - <?php echo web_title() ?></title>
    <meta name="Generator" content="PHP CI">
    <meta name="KEYWords" content="<?php
	if(isset($seoKeyword)){
		echo $seoKeyword;
		}else{
			echo web_keyword();
			}
	  ?>">
    <meta name="Description" content="<?php
	if(isset($seoDescription)){
		echo $seoDescription;
		}else{
			echo web_contents();
			}
	  ?>">
    <meta name="Author" content="<?php echo web_title() ?>">
    <meta name="Robots" content= "all">
    <link rel="icon" type="image/gif" href="/favicon.jpg">
    <link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo base_url() ?>assets/css/main.css" /> <!-- MAIN STYLE SHEET -->
    <link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo base_url() ?>assets/css/superMenu.css" />
    <script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/jquery-1.4.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/assets/jquery.hiAlerts.css"/>
    <script type="text/javascript" src="/assets/jquery.hiAlerts-min.js"></script> 
    <script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/jquery.pngFix.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/superfish.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/supersubs.js"></script>
    <!-- Load auto complete -->
    <script type='text/javascript' src='<?php echo base_url() ?>assets/javascript/autocomplete/jquery.autocomplete.js'></script>
    <script type='text/javascript' src='<?php echo base_url() ?>assets/javascript/autocomplete/localdata.js'></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/javascript/autocomplete/jquery.autocomplete.css" />
  
    <script type="text/javascript">
        $(document).ready(function(){
			 
            $(document).pngFix();
            $("ul.sf-menu").supersubs({
                minWidth:    10,   // minimum width of sub-menus in em units
                maxWidth:    27,   // maximum width of sub-menus in em units
                extraWidth:  1     // extra width can ensure lines don't sometimes turn over
                // due to slight rounding differences and font-family
            }).superfish();  // call supersubs first, then superfish, so that subs are
  			
			
            $("#keyword").autocomplete(cities);
      
	  
        });	
    </script>

</head> 
<body>   <!-- oncontextmenu=self.event.returnValue=false  -->
    <div class="page">
        <div class="topNav">
            <div class="topRight floatRight" >
           服务热线：<strong>025 - 6859 4193 | </strong><a href="<? echo site_url('info/index/contact') ?>">在线留言</a> | 
            
           
        </div>
            <div class="logo" style="padding:20px 0 0 20px">
                <img src="/assets/images/logo.png"  />
            </div>
            
        </div>   
       
        <!-- Menu -->
        <div class="menu_back" >
		<?php $this->load->view("search"); ?>
        <div id="menu" >
                <ul id="sample-menu-5" class="sf-menu" >

                    <?php
                    $index = 0;
                    //print_r($menu);
                    foreach ($menu as $row):
                    ?>
                    <?php if ($row->parent_id == 0): ?>
                            <li> <a href="<?php echo site_url('info/index/' . $row->menuUrl); ?>" > <?php echo $row->menuName ?></a>
							<?php 
							
								if ($row->children > 0){
							?>
                            <ul>
                          			<?php
									$menuCh = $this->menu_model->get_child_byId($row->id);
									//print_r($menuaaa);
									
									 foreach ($menuCh as $rowCh):
									 ?>
                           			 <li> 
                                     <a href="<?php echo site_url('info/index/' . $rowCh->menuUrl); ?>" > <?php echo $rowCh->menuName ?></a>
                                     </li>
                    				<?php endforeach ?>
                   			 </ul>
                             <?php
								}
							 ?>
                    </li>
                    <?php endif; ?>
                    <?php
                            endforeach
                    ?>
                
                </ul>

            </div>
        </div>
        
        <div class="clear"></div>
 <div id="main" />