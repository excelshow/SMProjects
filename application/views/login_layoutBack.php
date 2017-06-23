  <script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/jquery-idealForms.js"></script>
    <link href="<?php echo base_url() ?>assets/css/idealForms.css" rel="stylesheet" type="text/css" media="screen"/> 
	<link href="<?php echo base_url() ?>assets/css/idealForms-theme-comix.css" rel="stylesheet" type="text/css" media="screen"/>
<script language="javascript" type="text/javascript">
$(function(){
$('#loginUser').idealForms();
$('#messageLayout').idealForms();
});
$(document).ready(function(){
 $("#userLogin").click(function(){
		  	if ($("#userName").val() == ""){
				 hiAlert("请输入您的帐号！");
				 $('#userName').focus();
				 return false;
				}else{
					$("#uName").val($("#userName").val()+"@njwjhg.com");
					};
			 
				if ($("#userPwd").val() == ""){
				hiAlert("请输入您的密码！");
				 $('#userPwd').focus();
				return false;
				};
			 $("#loginUser").submit();
		});
	});

</script>
<div class="userLingNav" > 
<h1>用户登录</h1> 
<form id="loginUser" name="loginUser" action="http://mail.njwjhg.com/servlet/LoginServlet" method="post" target=_blank>
<div class="idealWrap">
			<label>帐 号:</label>
			<input type="text" class="idealText" id="userName" name="userName" size="20" value="" />
            <input type="hidden" class="idealText" id="uName" name="uName" size="20" />
</div>
		 
<div class="idealWrap">
			<label>密 码:</label>
			<input type="password"  class="idealText"  id="userPwd" name="userPwd" size="20" value=""/>
		</div>	
	
		<div class="idealWrap">
			<label>系 统:</label>
			  <select id="osSelect" name="osSelect" title="企业邮箱" onchange="aaa();"  >
				<option selected="selected" value="1">企业邮箱</option>
				<option value='2'>企业ERP</option>
			</select>
		</div>
		<div class="idealWrap" style=" text-align:center;">
	     
			<input name="按钮" type="button" id="userLogin" value=" &nbsp; 登录 >> &nbsp; "/>
	    &nbsp;&nbsp;&nbsp;&nbsp;<a href="#">忘记密码？</a></div>

	</form>
</div>