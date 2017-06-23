<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo base_url()?>assets/css/main.css" /> <!-- MAIN STYLE SHEET -->
<link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo base_url()?>assets/css/style.css" />
 
  
    <!-- GRAPHIC THEME -->
    <script type="text/javascript" src="<?php echo base_url()?>assets/javascript/jquery-1.4.1.min.js"></script>

  <script type="text/javascript" src="<?php echo base_url()?>assets/javascript/jquery.validate.pack.js"></script>
  <script type="text/ecmascript" language="javascript">
  $(document).ready(function(){
                
                var validation1 = {
                        rules: {username: {required: true,minlength: 2},
					            userpass: {required: true,minlength: 5},
								authcode_input: {required: true,minlength: 4}
								},
						messages: {username: {  required: "请输入用户名！",
												minlength: "至少2个字符！"},
								   userpass: {  required: "请输入密码！",
												minlength: "至少需要5个字符"},
								   authcode_input: {required: "请输入验证码",
								   					minlength: "至少4个字符"}
								}
				};
 
				$('#form1').validate(validation1);
				//$('#edit_user').validate(validation2);
        });
  </script>

<title><?php echo web_title(); ?> - WMS:网站管理系统</title>
</head>

<body>

<div id="main" style="padding-top:100px;">
      <div style="padding:0 0 0 100px;">
        <img  src="<?php echo base_url()?>/assets/images/LOGO.png" /> 
        </div>
<div  class="login">
		<div class="login_txt">
        <h1>用户登录</h1>
        <div class="loginForm">
        <form id="form1" name="form1" method="post" action="<?php echo site_url('admin/log/login')?>">
          <dt > 
          <label class="labelF">用户名:</label><input name="username" type="text" class="inputbox" id="username"  maxlength="10"  /></dt>
          <div style="height:5px;"></div>
            
          <dt> 
            <label class="labelF">密 码:</label><input type="password" name="userpass" id="userpass" class="inputbox"  />  </dt>
            <div style="height:5px;"></div>
            
           <dt><label class="labelF">验证码:</label><input type="text" name="authcode_input" id="authcode_input" onblur="ajaxauth()" class="inputbox"  /></dt>
           	<dt style=""><label class="labelF"> </label> <a href="javascript:void(0)">
<img id="authcode"src="<?php echo site_url()?>/imgauthcode/show" onClick="refresh('/imgauthcode/show')"/></a>
<a href="javascript:void(0)" onClick="refresh()">刷新验证码</a>

<span id="authcode_result"></span>
           </dt>
<script lang="javascript">
function refresh()
{
var url='<?php echo  site_url()."/imgauthcode/show/";?>'+Math.random();
$('#authcode').attr('src', url);
}
function ajaxauth()
{
var authcode = $('#authcode_input').val();
$.get("<?php echo site_url()."/imgauthcode/check/";?>"+authcode, function(data){
  if(data)
  {
	$('#authcode_result').text("正确");
  }
  else
  {
	$('#authcode_result').text("错误");
  }
}); 
}
</script>
    
     
          <dt> <label class="labelF"> </label>
            <input type="submit" name="button" id="button" value="登录 &gt;&gt;" class="buttom" />
          
          </dt> 
        </form>
        </div>
        </div>
     </div>
    <!-- Footer -->
	<div style="  font-size:12px; padding-bottom:10px; text-align:center; " >

	&copy; <?php echo date('Y');?> <a href="<?php echo web_link();?>" target="_blank"><?php echo web_copyright();?></a>, All Rights Reserved &reg;<br />
推荐使用IE7+浏览器以获得最佳效果<br />
  </div> <!-- /footer -->

</div> <!-- /main -->

</body>
</html>