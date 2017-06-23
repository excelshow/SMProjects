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
      <li  class="Current"><a href="{%site_url('tongxun/show/show_my')%}">我的部门</a></li>
       <li><a href="{%site_url('tongxun/show/show_sreach')%}">搜索</a></li>
       <li><a href="{%site_url('tongxun/show/myinfo')%}" >修改我的信息</a></li>
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
       <option value="1">姓名</option>
       <option value="2">部门名称</option>
        <option value="3"  >号码</option>
     </select>&nbsp;
     <input name="searchText"  id="searchText" class="searchTopinput  " type="text"/>
     <input name="searchBut" type="submit" class="searchTopbuttom  " value=""  /> 
        
      </div>
 	</form>
  <div id="staffshow" class="staffTonxunList" >
     <div class="staffadd pad10 ">
            <div class="staffformInfo ">
             <h2>用户登录</h2> 
             <div></div>      
             <form id="form1" name="form1" method="post" action="{%site_url('system/auth/login')%}">
                          <div class="formLab" >
                            <label class="labelF">用户名:</label>
                            </div>
                            <div class="formcontrol" >
                            <input name="username" type="text" class="inputbox" id="username"  />
                          </div>
                          <div class="clearb h10"></div>
                          <div class="formLab" >
                            <label class="labelF">密 码:</label>
                              </div>
                            <div class="formcontrol" >
                            <input type="password" name="password" id="password" class="inputbox"  />
                         </div>
                         <div class=" formLine clearb"> </div>
                          
                            <div class="formLab" >
                            &nbsp;
                              </div>
                            <div class="formcontrol" >
                            <label class="labelF"> </label>
                            <input type="submit" name="button" id="button" value="登录 &raquo; " class="buttom" />
                           </div>
               </form>
                 </div>     
             </div>
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