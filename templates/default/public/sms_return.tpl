<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" />
<head>
<title>资产出库扫描 - {%$web_title%}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" media="screen,projection" type="text/css" href="{%$base_url%}templates/{%$web_template%}/css/main.css" />
<link rel="stylesheet" media="screen,projection" type="text/css" href="{%$base_url%}templates/{%$web_template%}/css/public.css" />
 
 <link rel="stylesheet" media="screen,projection" type="text/css" href="{%$base_url%}templates/{%$web_template%}/css/superfish.css" />
 <link rel="stylesheet" media="screen,projection" type="text/css" href="{%$base_url%}templates/{%$web_template%}/css/superfish-navbar.css" />

<!-- GRAPHIC THEME -->
<script type="text/javascript" src="{%$base_url%}assets/javascript/jquery-1.8.js"></script>
<script type="text/javascript" src="{%$base_url%}assets/javascript/jquery.validate.pack.js"></script>

<script type="text/javascript" src="{%$base_url%}assets/javascript/superfish.js"></script>
<script type="text/javascript" src="{%$base_url%}assets/javascript/supersubs.js"></script>
    
<!-- loading hiAlert  -->
<script type="text/javascript" src="{%$base_url%}assets/hialert/jquery.hiAlerts-min.js"></script>
<link rel="stylesheet" href="{%$base_url%}assets/hialert/jquery.hiAlerts.css" type="text/css" />
<script type="text/javascript" src="{%$base_url%}assets/jnotify/jNotify.jquery.js"></script>
<script type="text/javascript" src="{%$base_url%}assets/javascript/jquery.inputDefault.js"></script>
<link rel="stylesheet" href="{%$base_url%}assets/jnotify/jNotify.jquery.css" type="text/css" />
<script type="text/javascript">
 
$(document).ready(function(){

$("#outform").keypress(function(e) {
  if (e.which == 13) {
	  if ($("#chuku").val() == ""){
			
	  }else{
	  		var post_data = $("#outform").serializeArray(); 
			  $.ajax({
						type: "POST",
						url: "{%site_url('public/sms_out/sms_return_do')%}",
						cache:false,
						data: post_data,
						success: function(msg){ 
							var obj=$.parseJSON(msg); 
							if (obj.code ==1){
							//alert(obj.username);
							   // $("#infochuku").prepend("<div class=cks>"+obj.msg+"</div>");
							   jSuccess("资产退仓操作成功！！",{
								  	autoHide : true,
									ShowOverlay : false,  
									VerticalPosition : 'center',
									HorizontalPosition : 'center' 
								});
								 $("#infochuku").prepend("<div class=cks>"+obj.msg+"</div>");
								 
								//$("#chuku").val("");
								//$("#chuku").focus();
							}else{
								hiAlert("出库失败！！","操作错误");
								$("#chuku").val("");
								$("#chuku").focus();
								$("#infochuku").prepend("<div class=cke>"+obj.msg+"</div>"); 
								
							}
							
						},
						error:function(){
							hiAlert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决","操作错误");
						}
						 
					});
					 
			return false;
	  }
  }
});
});
	 	
</script>
<style>
.chuku_ul{
	padding:0 10px 0 0;
	margin:0;
	}
.chuku_ul li{
	list-style:none;
	font-size:14px;
	width:100%;
	}
.chuku_ul li a{
	padding:5px 10px;
	display:inline-block;
	width:98%;
	}
.chuku_ul li a:hover{
	background:#FFF;
	}
.ouTreeTitle{
	font-size:16px;
	padding:5px 10px;
}
.name{
	font-size:20px;
	color:#333;
}
.dept{
	font-size:14px;
	color:#666;
	padding-top:5px;
}
.number{
	border-right:1px solid #CCC;
	padding:5px;
	color:#666;
}
.cks{
	margin:5px 0;
	padding:15px;
	border:1px solid #BCE7CE;
	background:#ECFFFF;
	font-size:16px;
	color:#060
}
.cke{
	margin:5px 0;
	padding:15px;
	border:1px solid #FFD9D9;
	background: #FFF4F4;
	font-size:16px;
	color:#640000;
}
</style>
</head>
<body>
 
<div id="main"> 
  
  <!-- Tray -->
 <div id="tray" class="box">
    <p class="fleft box" style="padding:5px 4px;"><img src="{%$base_url%}templates/{%$web_template%}/images/adminLogo.png" /></p>
    <div class="fright" style="padding:5px 4px;">
   
    {%if $smarty.session.username%}
      当前用户:
		<strong>{%$smarty.session.username%}</strong> 
        <strong>
           <a id="logout" href="/index.php/logsm/logout">安全退出</a>
            </strong>
                    
      {%else%}
      <a href="/" id="logout">管理登录</a>
      {%/if%}
      </div>
     <div class="clearb" ></div>
  </div>
   
  <!-- Menu -->
  <div class="h10"></div>
   <div class="menuTab">
  <ul>
  	 <li><a href="{%site_url('/public/sms_out')%}">资产出库</a></li>
        <li class="active"><a href="{%site_url('/public/sms_out/sms_return')%}">资产退仓</a></li>
       <li><a href="{%site_url('/public/sms_out/sms_inlinyong')%}">领用入库</a></li>
        <li><a href="{%site_url('/public/sms_out/sms_inbatch')%}">批量入库</a></li>
         <div class="clearb"></div>
  </ul>
  </div>
  <div class="h10"></div>
  <div class="showLayout" >
   <!--sidebarLeft stat -->
    <div class="sidebarLeft ">
   	
		<div class="ouTreeTitle" >待退仓申请人</div>
        <div class="ouTree pad5">
        <div id="localJson" class="jstree jstree-0 jstree-focused jstree-classic" >
        	<ul class="chuku_ul">
              {%if ($data["staff_sms"])%}
              {%foreach from=$data["staff_sms"] item=row%}
              	<li><a href="{%site_url('public/sms_out/sms_return')%}/{%$row->st_itname%}" class="chuku" id="">{%$row->cname%} {%$row->st_itname%} </a></li>
              {%/foreach%}
              {%/if%}
            </ul>
            </div>
        </div>
       
    </div>
    <!--sidebarLeft end -->
      <!--begin form -->
    <div class="sidebarMainTo  " style=" ">
    <div  style="padding-left:10px;">
      <div class="staffformInfo staffadd">
      {%if $staff['status'] ==1%}
        <form id="outform" name="outform"  > 
           
          <div  class="name"> {%$staff['info']->surname%}{%$staff['info']->firstname%} / {%$staff['info']->itname%} </div> 
           <input name="itname" type="hidden" value="{%$staff['info']->itname%}" />
          <div  class="dept"> 
          {%$staff['info']->deptOu%}
          </div>
          <div class="formLine clearb"> </div> 
          <div class=" h5"></div>
          <div class="">
                
                 <div class=" clearb h5" style="height:20px;">&nbsp;<br /></div>
                  <div class="searchform">
                 
                 <span class="number" >请输入资产编号</span> 
              <input name="chuku" id="chuku" type="text" fs="请输入资产编号" class="styleInput"  />
                </div> 
                 <div class=" h5"></div>
          </div>
           
            <div class="formLine clearb"> </div> 
            <div class="infochuku" id="infochuku">
            </div>
              <div class=" h5"></div>
        </form>
        {%else%}
        <h2>{%$staff['message']%}</h2>
        {%/if%}
      </div>
      <div class="clearb"></div>
      </div>
    </div>
    <!--end form --> 
  
  </div>
  
  <!-- /header -->
  <div class="clearb"></div>
  <!-- content --> 
   
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