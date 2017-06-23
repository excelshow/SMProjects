<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" />
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" media="screen,projection" type="text/css" href="{%$base_url%}templates/{%$web_template%}/css/main.css" />
    <!-- MAIN STYLE SHEET -->
    <link rel="stylesheet" media="screen,projection" type="text/css" href="{%$base_url%}templates/{%$web_template%}/css/style.css" />
    <link rel="stylesheet" media="screen,projection" type="text/css" href="{%$base_url%}assets/javascript/jquery-ui.css" />
    <!--[if lte IE 6]><link rel="stylesheet" media="screen,projection" type="text/css" href="{ base_url() }assets/css/main-ie6.css" /><![endif]--><!-- MSIE6 -->
<link rel="stylesheet" href="{%$base_url%}templates/{%$web_template%}/tongxun/style.css" type="text/css" />
    <link rel="stylesheet" media="screen,projection" type="text/css" href="{%$base_url%}templates/{%$web_template%}/css/superfish.css" />
    <link rel="stylesheet" media="screen,projection" type="text/css" href="{%$base_url%}templates/{%$web_template%}/css/superfish-navbar.css" />
    <link rel="stylesheet" href="{%$base_url%}templates/{%$web_template%}/css/jquery.treeTable.css" type="text/css" />
    <!-- GRAPHIC THEME -->
    <script type="text/javascript" src="{%$base_url%}assets/javascript/jquery-1.8.js"></script>
    <script type="text/javascript" src="{%$base_url%}assets/javascript/jquery.ui.js"></script>
    <script type="text/javascript" src="{%$base_url%}assets/javascript/jquery.treeTable.min.js"></script>
    <script type="text/javascript" src="{%$base_url%}assets/javascript/switcher.js"></script>
    
    <script type="text/javascript" src="{%$base_url%}assets/javascript/superfish.js"></script>
    <script type="text/javascript" src="{%$base_url%}assets/javascript/supersubs.js"></script>
    <!-- loading hiAlert  -->
    <script type="text/javascript" src="{%$base_url%}assets/hialert/jquery.hiAlerts-min.js"></script>
    <link rel="stylesheet" href="{%$base_url%}assets/hialert/jquery.hiAlerts.css" type="text/css" />
    <script type="text/javascript" src="{%$base_url%}assets/jnotify/jNotify.jquery.js"></script>
    <link rel="stylesheet" href="{%$base_url%}assets/jnotify/jNotify.jquery.css" type="text/css" />
    <script type="text/javascript">

        $(document).ready(function(){
           $('#sample-menu').superfish({
				pathClass: 'current'
			});	
            // not display:none when measuring. Call before initialising
            // containing tabs for same reason.
		 
			
        });

    </script>
    <title>通讯录 - 森马</title>
    </head>
    <body>
<div id="main">
<div id="passshow" style="display:none;" >
</div>
<!-- Tray -->
<div id="tray" class="box">
      <p class="f-left box"><img src="{%$base_url%}templates/{%$web_template%}/images/adminLogo.png" /><span style="font-size:14px; padding-top:5px; display:inline-block;"> - 通讯录</span></p>
      <p class="f-right">
      {%if (isset($smarty.session.user))%}
      当前用户:<strong>{%$smarty.session.DX_username%} / {%$smarty.session.DX_role_name%}</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <a href="javascript:;"  id="changepw"  >修改密码</a> &nbsp;&nbsp;|&nbsp;&nbsp;
      <strong><a href="{%site_url('log/logout')%}" id="logout">安全退出</a></strong>
      {%else%}
        <a id="logout" href="/">管理登录</a>
      {%/if%}
    
      </p>
    </div>
<!--  /tray --> 

<!-- Menu -->
<div  id="menu" >
    <ul id="sample-menu" class="sf-menu  " >
   <!-- <li><a href="javascript:;" class="detpShow" rel="0">森马集团</a>
    <ul>
   		 {%foreach from=$deptList item=row key%}
          <li><a href="javascript:;" class="detpShow" rel="{%$row->id%}">{%$row->deptName%}</a>
         {%/foreach%}
    </ul>
    </li>-->
    <li><a href="{%site_url('tongxun/show/publiclist')%}">公共通讯</a></li>
      <li><a href="{%site_url('tongxun/show/show_my')%}">我的部门</a></li>
      
  </ul>
</div>

<!--<div class="menuChildDiv" >
<ul class="menuChild">
 
</ul>
</div>-->

<!-- /header -->
<div class="clearb" ></div>

 
<script src="{%base_url()%}assets/jstree/jquery.jstree.js" type="text/javascript"></script> 
  
<script type="text/javascript">
    // JavaScript Document
 $(document).ready(function(){
	 // 浏览器的高度和div的高度  
     var height = $(window).height();  
	// var divHeight = $("#localJson").height();  
    $("#localJson").height(height - 185); 
	$("#localJson").css("overflow","auto"); 
    //div高度大于屏幕高度把屏幕高度赋给div，并出现滚动条  
     var key ="";
	 var val = "";        
	 
	 loadstaff("{%$id%}",key);
	 function loadstaff(val,key){
			 $.ajax({
                type: "POST",
                url: "{%site_url('tongxun/show/show_stafflist')%}/"+val,
                cache:false,
				
                data: 'key='+key,
                success: function(msg){
                    $("#staffshow").html(msg);        
                },
                error:function(){
					jError("出错啦，刷新试试，如果一直出现，可以联系开发人员解决",{
						VerticalPosition : 'center',
						HorizontalPosition : 'center',});
                     
                }
            });
        }		
        
		 
		 $('.detpShow').click(function(){
			val = $(this).attr("rel");
		//	alert(key);
			if (val){
				//val = '';
				//postdn(0);
				loadstaff(val,key);	
				}
			//loadstaff(data.rslt.obj.attr("id"),key);
		});
        $('input[name="searchBut"]').click(function(){
			key = $('input[name="searchText"]').val();
			if (key){
				val = '';
				//postdn(0);
				loadstaff(val,key);	
				}
			//loadstaff(data.rslt.obj.attr("id"),key);
		});
		  
		
		/////////////////////////////////////////
		
		
    });
    //]]>
   
</script>
<div id="showLayout" style="display:none;"></div>
 
<div class=" "  style=" ">
<div class="">
 
   
   
   
     <form id="deptform" method="post" action="" name="deptform">
  	 <div id="ouShow" class="pageTitle"  style=" " >
     <div class="fright  "><input name="adOudn" id="adOudn" type="hidden" /><input name="searchText"  id="searchText" class="searchTopinput fleft" type="text"/><input name="searchBut" type="button" class="searchTopbuttom fleft" value=""  /></div>
  <div  class=" ">通讯录 &raquo; 森马 &raquo; </div>
        
      </div>
 	</form>
  <div id="staffshow" class="staffTonxunList" >
     Load staff info....
  </div>
  </div>
</div>
 
 <div class="clearb h5"></div>
	<!-- Footer -->
	<div id="footer" class="box">

		<p class="f-left">&copy; {%date('Y')%} <a href="{%$web_copyrighturl%}" target="_blank">{%$web_copyright%}</a>, All Rights Reserved &reg;</p>

		<p class="f-right">推荐使用IE7+浏览器以获得最佳效果<br /> Power by 森马IT服务科</p>

	</div> <!-- footer -->

</div> <!-- /main -->
 
</body>
</html>