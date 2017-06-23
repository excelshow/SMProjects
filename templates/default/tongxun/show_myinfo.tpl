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
            
		  ///
		 // 联系电话(手机/电话皆可)验证
		jQuery.validator.addMethod("isPhone", function(value,element) {
		  var length = value.length;
		  var mobile = /^(((1[0-9]{2})|(15[0-9]{1}))+\d{8})$/;
		  return this.optional(element) || mobile.test(value);
		
		}, "请输入正确的手机号码"); 
		 var addjs = {
            rules: {
				sa_code:{required: true,maxlength: 4},
				sa_tel:{required: true,maxlength: 13},
				sa_mobile:{required: true,isPhone: true},
				sa_mobile_yanzheng:{required: true}
            },
            messages: {
				sa_code:{required: "区号必填",maxlength:"输入正确的区号"},
                sa_tel:{required: "办公电话必填",minlength: "最多13个字符"},
				sa_mobile:{required: "请输入正确的手机号码",isPhone: "请输入正确的手机号码"},
				sa_mobile_yanzheng:{required: "手机验证码不能为空"}
            },
			submitHandler : function(){
						   //表单的处理
						   var post_data = $("#adform").serializeArray();
						   url = "{%site_url('tongxun/show/staffmodifycomplete')%}";
						   hiClose();
						   $.ajax({
								    type: "POST",
									url: url,
									async:false,
									data:post_data,
									success: function(msg){
										if (msg == "ok"){
											 jSuccess("操作成功"+msg+"! 正在刷新页面...",{
												VerticalPosition : 'center',
												HorizontalPosition : 'center',
												TimeShown : 3000
											});
										 setInterval(function(){window.location="{%site_url('tongxun/show/show_my')%}";},1000);
										}else{
											jError("操作失败! "+msg,{
												VerticalPosition : 'center',
												HorizontalPosition : 'center',
												TimeShown : 3000
											});
									   }
									}
								});
						   return false;//阻止表单提交
				}
        };
		$('#adform').validate(addjs);
		////////////////////
		$('input[name=changeMob]').click(function(){
			   $('input[name=changeMob]').hide();
			   $('input[name=qyMob]').show();
			    $('#showMob').show();
			   
			});
		/////////////////
		$('input[name=qyMob]').click(function(){
			 $('input[name=qyMob]').hide();
			   $('input[name=changeMob]').show();
			   $('#showMob').hide();
			});
		/////////////////
		 $('input[name=yzMob]').click(function(){
			 
			 var mob = $('#sa_mobile').val();
			 if(mob.length<11){
				alert('请输入正确的手机号码');
				return false;
			 }
			 $.ajax({
								 type: "POST",
									url: "{%site_url('tongxun/show/get_authentication_code')%}",
									async:false,
									data:'mob='+mob+"&uv_r="+$('#uv_r').val(),
									success: function(msg){
										//
										if (msg == 0){ 
											  $('input[name=yzMob]').hide();
											   				 $('#sendSuc').show();
												  var setTime;
												 var time=parseInt('60');
													setTime=setInterval(function(){
														if(time<=0){
															clearInterval(setTime);
															 $('input[name=yzMob]').show();
											   				 $('#sendSuc').hide();
															return;
														}
														time--;
														$("#time").text(time);
													},1000);
										}else{
											jError("验证码发送失败:"+msg,{
												VerticalPosition : 'center',
												HorizontalPosition : 'center',
												TimeShown :5000
											});
									   }
									}
								}); 
			});
		/////////////////
		 /*
  使用js获取cookie中ur_r唯一标识，如果不存在，生成唯一标识，js写入cookie，并将唯一标识赋给隐藏表单。
  */
   //唯一标识存入cookie
          var _uuid = getUUID();
          if(getCookie("_UUID_UV")!=null && getCookie("_UUID_UV")!=undefined)
         {
             _uuid = getCookie("_UUID_UV");
          }else{
             setCookie("_UUID_UV",_uuid);
         }
          $("#uv_r").val(_uuid);//赋给hidden表单
		  
          //生成唯一标识
          function getUUID()
          {
              
			  var uuid = new Date().getTime();
              var randomNum =parseInt(Math.random()*1000); 
              return uuid+randomNum.toString();
			  
          }
          //写cookie
          function setCookie(name,value)
          {
              var Days = 365;//这里设置cookie存在时间为一年
              var exp = new Date();
              exp.setTime(exp.getTime() + Days*24*60*60*1000);
              document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
          }
          //获取cookie
          function getCookie(name)
          {
              var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
              if(arr=document.cookie.match(reg))
                  return unescape(arr[2]);
              else
                 return null;
          }
		/////
        });

    </script>
    <title>管理首页 - {%$web_title%}</title>
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
     <!--<a href="{%site_url('tongxun/show/myinfo')%}"   >修改我的信息</a> &nbsp;&nbsp;
      <strong><a href="#" id="logout" class="logout">安全退出</a></strong>
      <script type="text/javascript">
    //<![CDATA[   
    $(document).ready(function(){
		// Add
		 
	// del
  
	  
       
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
      <li><a href="{%site_url('tongxun/show/show_sreach')%}">搜索</a></li> 
      <li  class="Current"><a href="{%site_url('tongxun/show/myinfo')%}"   >修改我的信息</a></li>
  </ul>
</div>

<!--<div class="menuChildDiv" >
<ul class="menuChild">
 
</ul>
</div>-->

<!-- /header -->
<div class="clearb" ></div>
  <div id="ouShow" class="pageTitle"  style=" padding:10px;" >
  	我的联系信息
  </div>
<div id="showLayout" style="display:none;"></div>

 <div class="h10"></div>
<div class="showStaffList pad10 "  style=" ">
 
    <form id="adform" method="post" action="" name="adform">
  	   
    <!--begin form -->
    <div class="staffformInfo fleft">
 
          <div  class="formLab">姓名：</div>
          <div class="formcontrol">
           <span class="font16"> {%$smarty.session.cname%} / {%$smarty.session.itname%}</span></div>
          <div class="formLine  clearb" ></div>
          <div  class="formLab">联系信息</div>
         
          <div  class="formLabt">E-Mail：</div>
          <div  class="formLabi">
             {%$addreeInfo->sa_email%} 
          </div> 
           <div class="h10 clearb"> </div>
       <div  class="formLab">&nbsp;</div>
      <div  class="formLabt">手机：</div>
        <div  class="formLabi">
          
          {%$addreeInfo->sa_mobile%} 
          <input name="changeMob" type="button" class="buttonOt" onclick=" " value="修改手机号码" id="changeMob" />
          <input name="qyMob" type="button" class="buttonOt"  value="取消修改" style="display:none" />
          <div id="showMob" style="display:none">
           <div class="h10 clearb"> </div>
           新手机号码：<input name="sa_mobile" class="inputText" id="sa_mobile" type="text"  size="16"  value="" />
           <input name="yzMob" type="button" class="buttom"  value="获取验证码" /><input type="hidden" name="uv_r" value="" id="uv_r">
           <span id="sendSuc" style="display:none; color:#F60">验证码发生成功！ <span id="time">60</span> 秒后可以再次发送。</span>
            <div class="h10 clearb"> </div>
           手机验证码：<input name="sa_mobile_yanzheng" class="inputText" id="sa_mobile" type="text"  size="14"  value="" />
              
          </div>
          
          
      </div>
            <div class="h10 clearb"> </div>
             <div  class="formLab">&nbsp;</div>
        <div  class="formLabt">区号：</div>
          <div  class="formLabi">
          <input name="sa_code"   class="inputText" type="text" id="sa_code"   size="4"  value="{%$addreeInfo->sa_code%}" />
           电话：
            <input name="sa_tel"   class="inputText" type="text" id="sa_tel"   size="12"  value="{%$addreeInfo->sa_tel%}" />
            </div>
            <div class="h10 clearb"> </div>
             <div  class="formLab">&nbsp;</div>
          <div  class="formLabt">分机：</div>
          <div  class="formLabi">
            <input name="sa_tel_short" class="inputText" id="sa_tel_short" type="text"  size="10"  value="{%$addreeInfo->sa_tel_short%}" />
      </div> 
     
            
        <!--  <div class="h10 clearb"> </div>
          <div  class="formLab">&nbsp;</div>
          <div  class="formLabt">地址：</div>
          <div  class="formLabi">
            <input name="sa_address" class="inputText" id="sa_address" type="text"  value="{%$addreeInfo->sa_address%}" size="50"  />
              </div>
          
      <div class="h10 clearb"> </div>
          <div  class="formLab">&nbsp;</div>
           
      <div  class="formLabt">备注：</div>
              <div  class="formLabi">
                <textarea name="sa_market" cols="50" rows="2" class="inputText" id="sa_market">{%$addreeInfo->sa_market%}</textarea>
                 
          </div>-->
    
       
       
      
      <div class="formLine clearb " ></div>
          <div  class="formLab">&nbsp;</div>
          <div class="formcontrol">
            <input name="itname" id="itname" type="hidden" value="{%$smarty.session.itname%}" />
             <input name="cname" id="cname" type="hidden" value="{%$smarty.session.cname%}" />
            <input name="addcomplete" class="buttom" type="submit" value="提交完成" />
            &nbsp;&nbsp;
            <input type="button" onclick=" " class="a_close buttom" value="放弃" />
          </div>
      
    </div>
    <div class=" clearb"> </div>
     
    <!--end form --> 
   
 	</form>
 
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