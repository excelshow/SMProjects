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
             <BR>
                修改成功！
                <br>
             <br>
        </div> 
            

    </div>
</div>
 
<?php
 include("foot.php")
?>
