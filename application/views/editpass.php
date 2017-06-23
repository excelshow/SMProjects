<?php
	include("header.php")
?>
<script type="text/ecmascript" language="javascript">
  $(document).ready(function(){
                
                var validation1 = {
                        rules: { 
					            userpass: {required: true,minlength: 5},
								confirm_userpass: {required: true,minlength: 5,equalTo:"#userpass"}
								},
						messages: { 
								   userpass: {  required: "请输入密码！",
												minlength: "至少需要5个字符"},
								   confirm_userpass: {required: "确认密码需要填写",
								   					minlength: "至少5个字符",
													equalTo: "2次输入的密码需要一致"}
								}
				};
 
				$('#form1').validate(validation1);
				//$('#edit_user').validate(validation2);
        });
  </script>
<div id="layout_main" >
    <div class="left1">
    <h1> </h1>
    
    </div>

    <div style="width:500px; padding:40px;" >
        <h1>用户修改密码</h1>
         <!-- edit password-->
         <div id="editpass" style=" padding:5px; margin:5px; border:#090 1px solid; background-color:#FFF;">
		<form id="form1" name="form1" method="post" action="<?php echo site_url('welcome/editpass/sub')?>">
		<fieldset><legend><strong>编辑所选用户</strong></legend>
		<dd><span class="beforeinput">用户名称：</span><?php echo $this->session->userdata('layoutname')?>  <input type="text" name="username" value="<?php echo $this->session->userdata('layoutname')?>" readonly="readonly" />
		  
          </dd>
          <dd><span class="beforeinput">          
		  用户邮箱：</span><?php echo $email;?><input type="text" name="email" readonly="readonly" /> 
		 
          </dd>
          
          <dd>
	    <span class="beforeinput">新 密 码：</span><input type="password" name="userpass" id="userpass" />
		</dd>
        <dd>
		  <span class="beforeinput">确认密码：</span><input type="password" name="confirm_userpass"  />
		 
		  <input type="submit" name="submit" id="edit_passbut" value="编辑密码" />
			<input type="hidden" value="<?php echo $this->session->userdata('layoutuid')?>" name="uid" />
		    </dd>
		</fieldset>
		</form>
        </div> 
            

    </div>
</div>
 
<?php
 include("foot.php")
?>
