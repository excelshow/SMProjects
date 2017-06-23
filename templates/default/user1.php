<?php include("header.php")?>
<style type="text/css" >
.error {
	color: red;
}
.inputbox{
	 
}
.beforeinput{
	 
	padding-left:10px;
}
form{
	padding:0px; margin:0px;}
</style>
<script type="text/javascript">
    function makes(value,aaa)
    {
        hiAlert(value, '说明:'+aaa);
    }
</script>
<script type="text/javascript">
    //<![CDATA[
		function act_on_tr(){
				$('#treeTable tr:even').addClass('even');
				$('#treeTable tr').hover(
						function () {
								$(this).addClass("hover");
						 },
						 function () {
								$(this).removeClass("hover");
						 }
				).click(function(){
						$('#treeTable tr').removeClass('selected');
						$(this).addClass('selected');
				});
				
				$("button[name='adduser']").click(function(){
						 
						$("#adduser").show();
						$("#edituser").hide();
						$("#editpass").hide();
						$("#usermag").hide("");
						});
				$("input[name='canceladd']").click(function(){
						 
						$("#adduser").hide("");
						$("#edituser").hide();
						$("#editpass").hide();
						$("#usermag").hide();
						});
				$("select[name='user_group']").bind('change',function(){
					//alert($(this).val());
					 
					if ($(this).val() == 3){
							$("select[name='mid']").show();
						
						}else{
							$("select[name='mid']").val(0);
							}
					});
				
				
				$("button[name='edit']").click(function(){
						var tr = $(this).parents('tr');
						var tds = tr.find('td');
						//alert($(tds[3]).html());
						$("#edituser").show("");
						$("#adduser").hide("");
						
						$("#editpass").hide();
						$("#usermag").hide();
						//alert($(tds[2]).text());
						$("#edit_user input[name='username']").focus().val($(tds[0]).html());
						$("#edit_user input[name='email']").val($(tds[1]).html());
						$("#edit_user input[name='uid']").val(tr.attr('id'));
						$("#edit_user select[name='user_group'] option").each(function(){ 
								if($(this).html()==$(tds[2]).text()){
									$(this).attr('selected','selected');
									return false;
								}
						});
						if ($("#edit_user select[name='user_group']").val() == 3){
							$("select[name='mid']").show();
								$("#edit_user select[name='mid']  option").each(function(){
									if($(this).html()==$(tds[3]).html()){
										$(this).attr('selected','selected');
										return false;
									}
								});
						}else{
							$("select[name='mid']").hide();
							$("select[name='mid']").val(0);
							}
						
				});
				// edit password begin
				$("button[name='editpass']").click(function(){
                                 
						var tr = $(this).parents('tr');
						var tds = tr.find('td');
						//alert($(tds[3]).html());
						$("#edituser").hide("");
						$("#adduser").hide("");
						
						$("#editpass").show();
						$("#usermag").hide();
						//alert($(tds[2]).text());
						$("#edit_pass input[name='username']").focus().val($(tds[0]).html());
						$("#edit_pass input[name='email']").val($(tds[1]).html());
						$("#edit_pass input[name='uid']").val(tr.attr('id'));
						 
						
				});
				// edit password end
				$("button[name='del']").click(function(){
					var tr = $(this).parents('tr');
					hiConfirm('你确定要删除这条记录吗?','确认',function(r){
							if(r){
								$.ajax({
									type: "POST",
									url: '<?php echo site_url('user/del')?>',
									cache:false,
									data: 'uid='+tr.attr('id'),
									success: function(msg){
										flag = (msg=="ok");
										if(flag){
											tr.remove();
											act_on_tr();
										}else{
											alert(msg);
										}
									},
									error:function(){
										alert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
									}
								}); 
							}
					});
			});
		}
		
		
		
        $(document).ready(function(){
                act_on_tr();
                var validation1 = {
                        rules: {username: {required: true,minlength: 2},
					            userpass: {required: true,minlength: 5},
								confirm_userpass: {required: true,minlength: 5,equalTo:"#userpass"},
								uid:{required:true},
								user_group:{required:true},
								email: {required: true,email: true}},
						messages: {username: {  required: "用户名需要填写",
												minlength: "用户名至少2个字符"},
								   userpass: {  required: "密码需要填写",
												minlength: "密码至少需要5个字符"},
								   confirm_userpass: { required: "确认密码需要填写",
													   minlength: "密码至少需要5个字符",
													   equalTo: "2次输入的密码需要一致"},
								   uid: "请选择一个用户编辑后提交",
								   user_group:"请选择一个分组",
								   email: "请输入合法的Email地址"},
						submitHandler:function(){
									   var post_data = $("#new_user").serializeArray();
										$.ajax({
											type: "POST",
											url: $("#new_user").attr("action"),
											cache:false,
											data: post_data,
											success: function(msg){
												flag = /ok/g.test(msg);
												if(flag){
													html = "<tr id='"+msg.replace(/ok/g,"")+"'><td>"+$("#new_user input[name='username']").val()+"</td><td>"+$("#new_user input[name='email']").val()+"</td><td>"+$("#new_user select[name='user_group'] option[value='"+$("#new_user select[name='user_group']").val()+"']").html()+"</td><td>"+$("#new_user select[name='mid'] option[value='"+$("#new_user select[name='mid']").val()+"']").html()+"</td><td><button class='edit' name='edit' type='button' ></button>&nbsp;<button class='delete' name='del' type='button' ></button></td>";
													$("#treeTable tr:last").after(html);
													$("#new_user input[type='text']").val("");
													$("#new_user input[type='password']").val("");
													act_on_tr();
												}else{
													alert(msg);
												}
											},
											error:function(){
												alert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
											}
										}); 
										return false;
						}
				};
				var validation2 = {
						
						rules: {username: {required: true,minlength: 2},
								uid:{required:true},
								user_group:{required:true},
								email: {required: true,email: true}},
						messages: {username: {  required: "用户名需要填写",
												minlength: "用户名至少2个字符"},
												   uid: "请选择一个用户编辑后提交",
												   user_group:"请选择一个分组",
												   email: "请输入合法的Email地址"},
						submitHandler:function(){
									   var post_data = $("#edit_user").serializeArray();
										$.ajax({
											type: "POST",
											url: $("#edit_user").attr("action"),
											cache:false,
											data: post_data,
											success: function(msg){
												flag = (msg=="ok");
												if(flag){
													var tr = $("tr#"+$("#edit_user input[name='uid']").val());
													var tds = tr.find('td');
													$(tds[0]).html($("#edit_user input[name='username']").val());
													$(tds[1]).html($("#edit_user input[name='email']").val());
													$(tds[2]).html($("#edit_user select[name='user_group'] option[value='"+$("#edit_user select[name='user_group']").val()+"']").html());
													$(tds[3]).html($("#edit_user select[name='mid'] option[value='"+$("#edit_user select[name='mid']").val()+"']").html());
													$("#edit_user input[type='text']").val("");
													$("#edit_user input[type='password']").val("");
												}else{
													alert(msg);
												}
											},
											error:function(){
												alert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
											}
										}); 
										$("#edituser").hide("");
										$("#usermag").show("");
										return false;
						}
				};
					var validation3 = {
						
						rules: {userpass: {required: true,minlength: 5},
								confirm_userpass: {required: true,minlength: 5,equalTo:"#b_userpass"},
								},
								 
						messages: {userpass: {  required: "密码需要填写",
												minlength: "密码至少需要5个字符"},
								   confirm_userpass: { required: "确认密码需要填写",
													   minlength: "密码至少需要5个字符",
													   equalTo: "2次输入的密码需要一致"},
								},
								  
						submitHandler:function(){
									   var post_data = $("#edit_pass").serializeArray();
										$.ajax({
											type: "POST",
											url: $("#edit_pass").attr("action"),
											cache:false,
											data: post_data,
											success: function(msg){
												flag = (msg=="ok");
												 
											},
											error:function(){
												alert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
											}
										}); 
										$("#editpass").hide();
										$("#usermag").show();
										return false;
						}
				};
				$('#new_user').validate(validation1);
				$('#edit_user').validate(validation2);
				$('#edit_pass').validate(validation3);
        });
    //]]>
</script>
<div style="padding:10px;">
<button  name="adduser" type="button" value="0" class="buttom" >添加新用户</button>
</div>

<!-- user manage begin  -->
	<div id="usermag" style="display:none; padding:15px; margin:5px; border:#090 1px solid; background-color:#FFF;">
    	操作成功！<input type="button" name="canceladd" id="canceladd" value="关闭" /> 
    </div>
	<div id="adduser" style="display:none; padding:5px; margin:5px; border:#090 1px solid; background-color:#FFF;">
		<form id="new_user" method="post" action="<?php echo site_url('user/add')?>">
		<fieldset><legend><strong>添加一个新的用户</strong></legend>
		<dd><span class="beforeinput">用户名称：</span><input type="text" name="username"  />
      
		  <span class="beforeinput">登录密码：</span>
		  <input type="password" name="userpass" id="userpass" />
		  <span class="beforeinput">确认密码：</span>
		  <input type="password" name="confirm_userpass"  />
          </dd>
          <dl></dl>
          <dd>
		 <span class="beforeinput">用户邮箱：</span><input type="text" name="email" o />
		  <span class="beforeinput">用户角色：</span>
		  <select name="user_group" >
		    <option value="0" selected="selected">选择一个分组</option>
		    <?php foreach ($groups as $row):?>
		    <option value="<?php echo $row->group_id;?>"><?php echo $row->group_name;?></option>
		    <?php endforeach;?>
	      </select>
          
		  <select name="mid" id="mid" style="display:none;" >
		    <option value="0" selected="selected">选择工厂</option>
		    <?php foreach ($mill as $row):?>
		    <option value="<?php echo $row->mid;?>"><?php echo $row->mill_name;?></option>
		    <?php endforeach;?>
	      </select>
         
	 		
		 <input type="submit" name="submit" id="new_button" value="确定添加" /> 
         <input type="button" name="canceladd" id="canceladd" value="取消" /> 
         <span id="showmill" style="display:block; width:150px;" > 
</span> </dd>
		</fieldset>
		</form>
		</div>
        <!-- -->
        <div id="edituser" style="display:none; padding:5px; margin:5px; border:#090 1px solid; background-color:#FFF;">
		<form id="edit_user" method="post" action="<?php echo site_url('user/edit')?>">
		<fieldset><legend><strong>编辑所选用户</strong></legend>
		<dd><span class="beforeinput">用户名称：</span><input type="text" name="username" />
		  <span class="beforeinput">用户邮箱：</span>
		  <input type="text" name="email" /> 
		 
          </dd>
          <dl></dl>
          <dd>
	    <span class="beforeinput">用户角色：</span><select name="user_group"  >
			<option value="" selected="selected">选择一个分组</option>
			<?php foreach ($groups as $row):?>
			<option value="<?php echo $row->group_id;?>"><?php echo $row->group_name;?></option>
			<?php endforeach;?>
		</select>
		  
		  <select name="mid" style="display:none;"  >
		    <option value="" selected="selected">选择工厂</option>
		    <?php foreach ($mill as $row):?>
		    <option value="<?php echo $row->mid;?>"><?php echo $row->mill_name;?></option>
		    <?php endforeach;?>
	      </select>
		 
		  <input type="submit" name="submit" id="edit_button" value="编辑用户" />
			<input type="hidden" value="" name="uid" />
		    </dd>
		</fieldset>
		</form>
        </div>
		 <!-- edit password-->
         	 <div id="editpass" style="display:none; padding:5px; margin:5px; border:#090 1px solid; background-color:#FFF;">
		<form id="edit_pass" method="post" action="<?php echo site_url('user/editpass')?>">
		<fieldset><legend><strong>编辑所选用户</strong></legend>
		<dd><span class="beforeinput">用户名称：</span><input type="text" name="username" readonly="readonly" />
		  <span class="beforeinput">用户邮箱：</span>
		  <input type="text" name="email" readonly="readonly" /> 
		 
          </dd>
          <dl></dl>
          <dd>
	    <span class="beforeinput">登录密码：</span>
		  <input type="password" name="b_userpass" id="b_userpass" />
		  <span class="beforeinput">确认密码：</span>
		  <input type="password" name="confirm_userpass"  />
		 
		  <input type="submit" name="submit" id="edit_passbut" value="编辑密码" />
			<input type="hidden" value="" name="uid" />
		    </dd>
		</fieldset>
		</form>
        </div>
         <!-- -->
<!-- user manage end-->
<!--view begin-->
<table id="treeTable" class="treeTable">
	<thead>
		<tr>
			<th>用户名</th>
			<th>用户邮箱</th>
			<th>用户组</th>
            <th>工厂浏览</th>
			<th>操作</th>
		</tr>
	</thead>
	<?php foreach ($users as $row):?>
	<tr id="<?php echo $row->uid;?>">
		<td><?php echo $row->username;?></td>
		<td><?php echo $row->email;?></td>
                <td><?php echo $row->group_name;?><span style="padding:15px 0 0 10px; margin:0px;" ><a href="#" onclick="makes('<? echo $row->makes; ?>','<?php echo $row->group_name;?>')"><img src="/assets/images/onFocus.gif" border="0" stlye=""></a></span></td>
                <td><?php
               // echo $row->mid;
                if ($row->mid == 0)
                        {
                       echo "--";
                }else
                    {
               $aa = $this->mill_model->get_mill_byid($row->mid);
              //  print_r($aa);
                echo $aa->mill_name;
               // print_r($row);
                    }
                ?></td>
		<td>
		<button class="edit" name="edit" type="button"
			value="<?php echo $row->uid ; ?>" ></button>&nbsp;&nbsp;&nbsp;
            <button class="editpass" name="editpass" type="button"
			value="<?php echo $row->uid ; ?>"></button> &nbsp;&nbsp;
		<button class="delete" name="del" type="button"
			value="<?php echo $row->uid ; ?>"></button>
		</td>
	</tr>
	<?php endforeach;?>
</table>
<div align="center"><?php echo $links;?></div>
<!--end of view--> 

<?php include("foot.php")?>
