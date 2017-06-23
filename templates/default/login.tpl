<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" media="screen,projection" type="text/css" href="{%$base_url%}templates/{%$web_template%}/css/main.css" />
<!-- MAIN STYLE SHEET -->
<link rel="stylesheet" media="screen,projection" type="text/css" href="{%$base_url%}templates/{%$web_template%}/css/login.css" />

<!-- GRAPHIC THEME -->
<script type="text/javascript" src="{%$base_url%}assets/javascript/jquery-1.8.js"></script> 
 <script type="text/javascript" src="{%$base_url%}assets/javascript/picback.js"></script> 
 <script type="text/javascript" src="{%$base_url%}assets/javascript/jquery.validate.pack.js"></script>
<script type="text/ecmascript" language="javascript">
  $(document).ready(function(){
                
                var validation1 = {
                        rules: {username: {required: true,minlength: 2},
					            Password: {required: true,minlength: 5},
								authcode_input: {required: true,minlength: 4}
								},
						messages: {username: {  required: "请输入用户名！",
												minlength: "至少2个字符！"},
								   Password: {  required: "请输入密码！",
												minlength: "至少5个字符"},
								   authcode_input: {required: "请输入验证码",
								   					minlength: "至少4个字符"}
								}
				};
 
				$('#form1').validate(validation1);
				//$('#edit_user').validate(validation2);
        });
  </script>
 
<title>管理登录 - {%$web_title%}</title>
</head>
<body>
<div id="page" style="padding-top:100px;">
<div style="height:420px;">
 
   		<!-- jQuery handles to place the header background images -->
	<div id="headerimgs">
		<div id="headerimg1" class="headerimg"></div>
		<div id="headerimg2" class="headerimg"></div>
	</div>
	<!-- Top navigation on top of the images --><!-- Slideshow controls -->
	 
	<!-- jQuery handles for the text displayed on top of the images -->
	 
     <!-- jQuery  end -->
      <div class="topNav">
   	    <div class="logo floatLeft" > <img  src="{%$base_url%}templates/{%$web_template%}/images/logocolor.png" /> </div>
         <div class="topcontent floatRight" >
         		  
           <div class="login_txt">
             <h1>管理登录</h1>
                      
             <form id="form1" name="form1" method="post" action="{%site_url('system/auth/login')%}">
                          <dt >
                            <label class="labelF">用户名:</label>
                            <input name="username" type="text" class="inputbox" id="username"  />
                          </dt>
                          <div style="height:5px;"></div>
                          <dt>
                            <label class="labelF">密 码:</label>
                            <input type="password" name="password" id="password" class="inputbox"  />
                          </dt>
                          <div style="height:5px;"></div>
                          
                            <label class="labelF"> </label>
                            <input type="submit" name="button" id="button" value="登录 &raquo; " class="buttom" />
                          </dt>
               </form>
                      
             </div>
             <div style="padding:20px; border-bottom:2px solid #CCC;"></div>
             <br />
             
            <ul>
				<!--<li><a href="#">修改密码</a></li>-->
                 <li><a href="{%site_url("logsm") %}" target="_blank">资产出入库</a></li>
                <li><a href="{%site_url("tongxun/show") %}" target="_blank">通讯录</a></li>
             
                <li><a href="{%site_url("public/search") %}" target="_blank">自助查询</a></li>
                <li><a href="http://itsm.semir.cn/" target="_blank" >IT报修</a></li>
            </ul>   
        </div>
      </div>
      
    </div>
  <!-- Footer -->
  <div style="  font-size:12px; padding-bottom:10px; text-align:center; " > &copy; {%date('Y')%} <a href="{%$web_copyrighturl%}" target="_blank">{%$web_copyright%}</a>, All Rights Reserved &reg;<br />
    推荐使用IE7+浏览器以获得最佳效果<br />
  </div>
  <!-- /footer --> 
  
</div>
<!-- /main -->

</body>
</html>