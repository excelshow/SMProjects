<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" />
<head>
<title>公共查询 - {%$web_title%}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" media="screen,projection" type="text/css" href="{%$base_url%}templates/{%$web_template%}/css/main.css" />
<link rel="stylesheet" media="screen,projection" type="text/css" href="{%$base_url%}templates/{%$web_template%}/css/public.css" />
 

<!-- GRAPHIC THEME -->
<script type="text/javascript" src="{%$base_url%}assets/javascript/jquery-1.8.js"></script>
<script type="text/javascript" src="{%$base_url%}assets/javascript/jquery.validate.pack.js"></script>
<!-- loading hiAlert  -->
<script type="text/javascript" src="{%$base_url%}assets/hialert/jquery.hiAlerts-min.js"></script>
<link rel="stylesheet" href="{%$base_url%}assets/hialert/jquery.hiAlerts.css" type="text/css" />
<script type="text/javascript" src="{%$base_url%}assets/jnotify/jNotify.jquery.js"></script>
<script type="text/javascript" src="{%$base_url%}assets/javascript/jquery.inputDefault.js"></script>
<link rel="stylesheet" href="{%$base_url%}assets/jnotify/jNotify.jquery.css" type="text/css" />
<script type="text/javascript">
  
    window.onresize = resize;
  function resize(){
    var h = (window.innerHeight || (window.document.documentElement.clientHeight || window.document.body.clientHeight));
    $("#showLayout").css({"min-height":h-180});
	}
$(document).ready(function(){
	$('[fs]').inputDefault();
 	
   	$('input[name="publicSearch"]').click(function(){
			key = $('input[name="publicKey"]').val();
			if (key){
				///////////// search sms starte
				$("#showLayout").html("查询中。。。");
					 $.ajax({
						type: "POST",
						url: "{%site_url('public/search/doSearchStaff')%}",
						cache:false,
						
						data: 'key='+key,
						success: function(msg){
							$("#showLayout").html(msg);	  
							// alert(val);          
						},
						error:function(){
							jError("出错啦，刷新试试，如果一直出现，可以联系开发人员解决",{
								VerticalPosition : 'center',
								HorizontalPosition : 'center',});
							 
						}
					});
			}
		return false;	 
	});
  
});
</script>
</head>
<body>
<div id="main"> 
  
  <!-- Tray -->
  <div id="tray" class="box">
    <p class="fleft box"><img src="{%$base_url%}templates/{%$web_template%}/images/adminLogo.png" /></p>
    <p class="fright"><a href="/" id="logout">管理登录</a></p>
     <div class="clearb" ></div>
  </div>
   
  <!-- Menu -->
  
  <div class="searchbox" >
  <form  id="searchForm"  runat="server" onsubmit="return false;">
  <div class="searchNav">
  	<div class="searchform">
   
  <input name="publicKey" id="publicKey" type="text" fs="可输入员工帐号或姓名查询" class="styleInput" st />
    </div>
    <div class="searchButton"><input type="submit" name="publicSearch" id="publicSearch" class="submitButton" value="搜索" /></div>
    <div class="clearb"></div>
    </div>
    </form>
  </div>
  
  <!-- /header -->
  <div class="clearb"></div>
  <!-- content --> 
  <div class="  pad10" id="showLayout"  style=" padding:10px; font-size:16px; ">
 			请输入完整的姓名或IT帐号查询。
 <div class="clearb"></div>
  </div>
  <!-- /content -->
  
  <div class="clearb h5"></div>
  <!-- Footer -->
  <div id="footer" class="box">
    <p class="f-left">&copy; {%date('Y')%} <a href="{%$web_copyrighturl%}" target="_blank">{%$web_copyright%}</a>, All Rights Reserved &reg;</p>
    <p class="f-right">推荐使用IE7+浏览器以获得最佳效果<br />
      Power by 森马IT服务科</p>
  </div>
  <!-- footer --> 
  
</div>
<!-- /main -->

</body>
</html>