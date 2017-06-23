<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo base_url()?>assets/css/main.css" /> <!-- MAIN STYLE SHEET -->
<link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo base_url()?>assets/css/style.css" />


    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/jquery.hiAlerts.css" type="text/css" />
  
    <!-- GRAPHIC THEME -->
    <script type="text/javascript" src="<?php echo base_url()?>assets/javascript/jquery-1.4.1.min.js"></script>


     <script type="text/javascript" src="<?php echo base_url()?>assets/javascript/jquery.hiAlerts-min.js"></script>
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

<title><?php echo $title ?></title>
</head>

<body>

<div id="main">
    <br /><br />
<br /><br />
<div  class="login">
		<div class="login_txt">
        <form id="form1" name="form1" method="post" action="<?php echo site_url('loginlayout/login')?>">
          <dd > 
          <input name="username" type="text" class="inputbox" id="username"  maxlength="10"  /></dd>
          <div style="height:5px;"></div>
            
          <dd> 
            <input type="password" name="userpass" id="userpass" class="inputbox"  />  </dd>
            <div style="height:5px;"></div>
            
           <dd><input type="text" name="authcode_input" id="authcode_input" onblur="ajaxauth()" class="inputbox"  /></dd>
           	<dd style="padding-left:3px;"> <a href="javascript:void(0)">
<img id="authcode"src="<?php echo site_url().'imgauthcode/show';?>" onClick="refresh('/imgauthcode/show')"/></a>
<a href="javascript:void(0)" onClick="refresh()">刷新验证码</a>

<span id="authcode_result"></span>
           </dd>
        
           

<script lang="javascript">
function refresh()
{
var url='<?php echo site_url()."/imgauthcode/show/";?>'+Math.random();
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
    
        <dt>&nbsp;</dt>
          <dd>  <label>
              <input type="submit" name="button" id="button" value="登录 &gt;&gt;" class="buttom" />
            </label>
           </dd> 
        </form>
        </div>
     </div>
    <!-- Footer -->
     
	<div id="footer"   style="  font-size:12px; padding-bottom:10px; text-align:center; " >

	 &copy; <?php echo date("Y")?> <a href="http://www.balabala.com.cn/" target="_blank">Balabala</a>, All Rights Reserved &reg;<br />
推荐使用IE7+浏览器以获得最佳效果 

  </div> <!-- /footer -->

</div> <!-- /main -->

</body>
</html>