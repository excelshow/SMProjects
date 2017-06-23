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
    <!-- loading hiAlert  -->
    <script type="text/javascript" src="{%$base_url%}assets/hialert/jquery.hiAlerts-min.js"></script>
    <link rel="stylesheet" href="{%$base_url%}assets/hialert/jquery.hiAlerts.css" type="text/css" />
    <script type="text/javascript" src="{%$base_url%}assets/jnotify/jNotify.jquery.js"></script>
    <link rel="stylesheet" href="{%$base_url%}assets/jnotify/jNotify.jquery.css" type="text/css" />
    
 <script type="text/javascript" src="{%$base_url%}assets/javascript/jquery.validate.pack.js"></script>
    <script type="text/javascript">

        $(document).ready(function(){
            
		   var validation1 = {
                        rules: {username: {required: true,minlength: 2},
					            password: {required: true,minlength: 5}
								},
						messages: {username: {  required: "请输入用户名！",
												minlength: "至少2个字符！"},
								   password: {  required: "请输入密码！",
												minlength: "至少5个字符"}
								},
			submitHandler : function(){
						   //表单的处理
						   var post_data = $("#form1").serializeArray();
						   url = "{%site_url('tongxun/show/login')%}"; 
						   $.ajax({
								 type: "POST",
									url: url,
									async:false,
									data:post_data,
									success: function(msg){
										if (msg == 'ok'){
											 jSuccess("操作成功! 正在刷新页面...",{
												VerticalPosition : 'center',
												HorizontalPosition : 'center',
												TimeShown : 1000
											});
											 setInterval(function(){window.location.reload();},1000);
										}else{
											jError("操作失败! ",{
												VerticalPosition : 'center',
												HorizontalPosition : 'center',
												TimeShown : 1000
											});
									   }
									}
								});
						   return false;//阻止表单提交
			}
				};
 
				$('#form1').validate(validation1);
			
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
      <p class="f-left box">
      <span style="float:left;" ><img src="{%$base_url%}templates/{%$web_template%}/images/logo.png" height="25" /></span>
      <span style="font-size:20px; margin:0; display:inline-block;">&nbsp;&nbsp;&#8226;&nbsp;&nbsp;通讯录</span>
     </p>
      <p class="f-right">
      {%if (isset($smarty.session.userLogin))%}
      当前用户:<strong>{%$smarty.session.cname%} / {%$smarty.session.itname%}</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <!-- <a href="{%site_url('tongxun/show/myinfo')%}"   >我的信息</a> &nbsp;&nbsp;
      <strong><a href="#" id="logout" class="logout">安全退出</a></strong>
      <script type="text/javascript">
    //<![CDATA[   
    $(document).ready(function(){
		// Add
		 
	// del
   $('.logout').click(function(){
				 
				hiConfirm('确认退出系统？',null,function(tp){

					if(tp){
						$.ajax({
							type: "POST",
							url: "{%site_url('tongxun/show/logout')%}",
							 
							success: function(msg){
								//alert(msg);
								if(msg=="ok"){
									// $("tr#"+n).remove();
									jSuccess("操作成功! 正在刷新页面...",{
										VerticalPosition : 'center',
										HorizontalPosition : 'center',
										TimeShown : 1000,
									});
							        setInterval(function(){window.location.reload();},1000);
									 
								}else{
									hiAlert(msg);
								}
							}
								   
						});
						return false;
							
					}
				});
			});
	  
       
    });
    //]]>
</script>-->
      {%else%}
        <a id="logout" href="{%site_url('tongxun/show/show_my')%}">用户登录</a>
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
      <li class="Current"><a href="{%site_url('tongxun/show/show_sreach')%}">搜索</a></li> 
      <li><a href="{%site_url('tongxun/show/myinfo')%}"   >修改我的信息</a></li>
  </ul>
</div>

<!--<div class="menuChildDiv" >
<ul class="menuChild">
 
</ul>
</div>-->

<!-- /header -->
<div class="clearb" ></div>
 
<div id="showLayout" style="display:none;"></div>
 
<div class=" "  style=" ">
<div class="">
    <form id="deptform" method="post" action="{%site_url('tongxun/show/show_sreach')%}" name="deptform">
  	 <div id="ouShow" class="pageTitle"  style=" padding:10px;" >
     搜索：
     <select name="type" class="searchTopinput  " >
       <option value="1" {%if $type==1%} selected="selected" {%/if%}>姓名</option>
       <option value="2" {%if $type==2%} selected="selected" {%/if%}>部门名称</option>
       <option value="3" {%if $type==3%} selected="selected" {%/if%}>号码</option>
     </select>&nbsp;
     <input name="searchText"  id="searchText" class="searchTopinput  " type="text" value="{%$search%}"/>
     <input name="searchBut" type="submit" class="searchTopbuttom  " value=""  /> 
        
      </div>
 	</form>
 
      <div class="h10"></div> 
      {%if ($data)%}
      {%$rootDeptname = ''%}
      <div class="showStaffList">
      <div class="showTitle">
      <div class="searchTop fleft" >
          <ul class="">
          <li class="searchTab0"><strong>部门</strong></li>
            <li class="searchTab1"><strong>姓名</strong></li>
            <li class="searchTab2"><strong>电话</strong></li>
            <li class="searchTab3"><strong>手机</strong></li>
            <li class="searchTab4"><strong>Email</strong></li>
          </ul>       
      </div>
      
       <div class="searchTop fright" style="border-left:2px solid #CCC;" >
          <ul class=" ">
          <li class="searchTab0"><strong>部门</strong></li>
            <li class="searchTab1"><strong>姓名</strong></li>
            <li class="searchTab2"><strong>电话</strong></li>
            <li class="searchTab3"><strong>手机</strong></li>
            <li class="searchTab4"><strong>Email</strong></li>
          </ul>     
      </div>
       <div class="clearb"></div>
      </div>
        <div class="clearb"></div>
        {%counter start=1 assign="cnt" print=false%}
      {%foreach from=$data item=row key%}
    	  {%if $cnt is div by 2%}
          <div class="searchTop fright list"  style="border-left:2px solid #CCC;" >
          {%else%}
         <div class="searchTop fleft list" >
         {%/if%}
          
              <ul class=" ">
               <li class="searchTab0 colorG" title="{%$row->deptname%}">{%$row->deptname|truncate:8:"...":true%}</li>
                <li class="searchTab1">{%if $row->cname%}{%$row->cname%} {%else%}{%$row->itname%}{%/if%}</li>
                {%if $row->address %}
              
                    <li class="searchTab2"> 
                     {%$row->address->sa_code%}-{%$row->address->sa_tel%} / {%$row->address->sa_tel_short%} </li>
                    <li class="searchTab3">-</li>
                    
                   {%else%}
                    <li class="searchTab2">--</li>
                    <li class="searchTab3">-</li>
                {%/if%}  
                <li class="searchTab4 colorG" title="{%$row->address->sa_email%}">{%$row->address->sa_email|truncate:20:"...":true%}</li>
                 <div class="clearb"></div>  
              </ul>  
              <div class="clearb"></div>   
          </div>
         
      	   {%counter assign="cnt" print=false%}
      {%/foreach%}
      <div class="clearb"></div>
       </div>
      {%else%}
     	请输入正确的搜索关键字，支持模糊搜索。。。。
      {%/if%}
  
   
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