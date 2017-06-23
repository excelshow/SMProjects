{%include file="../header.tpl"%} 
 
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
				
        $("#addadmin").click(function(){
						 
            $("#adduser").show();
            $("#edituser").hide();
            $("#editpass").hide();
            $("#usermag").hide();
        });
        $("input[name='canceladd']").click(function(){
						 
            $("#adduser").hide();
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
            //alert(tr.attr('id'));
            $("#edituser").show();
            $("#adduser").hide("");
						
            $("#editpass").hide();
            $("#usermag").hide();
            //alert($(tds[2]).text());
            $("#edit_user input[name='username']").focus().val($(tds[0]).html());
            $("#edit_user input[name='email']").val($(tds[1]).html());
			
            $("#edit_user select[name='user_group'] option").each(function(){
                if($(this).html()==$(tds[2]).text()){
                    $(this).attr('selected','selected');
                    return false;
                }
            });
			$("#edit_user input[name='uid']").val(tr.attr('id'));
			
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
            hiConfirm('你确定要删除这条记录吗?',null,function(r){
                if(r){
                    $.ajax({
                        type: "POST",
                        url: "{%site_url('system/system/user_del')%}",
                        cache:false,
                        data: 'uid='+tr.attr('id'),
                        success: function(msg){
                            flag = (msg==1);
                            if(flag){
                                tr.remove();
                                act_on_tr();
                            }else{
                                hiAlert(msg);
                            }
                        },
                        error:function(){
                           hiAlert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
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
            messages: {username: {  required: "用户名需要填写",minlength: "用户名至少2个字符"},
                userpass: {  required: "密码需要填写",minlength: "密码至少需要5个字符"},
                confirm_userpass: { required: "确认密码需要填写",minlength: "密码至少需要5个字符",equalTo: "2次输入的密码需要一致"},
                uid: "请选择一个用户编辑后提交",user_group:"请选择一个分组",email: "请输入合法的Email地址"},
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
                             $("#edituser").html("操作成功！正在刷新页面....");
                            setInterval(function(){
								 window.location.reload();
                            },1000);
                        }else{
                            hiAlert(msg);
                        }
                    },
                    error:function(){
                        hiAlert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
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
                         
                        if(msg == 'ok'){
                            //  $("#mag").show("");
                            $("#edituser").html("操作成功！正在刷新页面....");
                            setInterval(function(){
								 window.location.reload();

                            },1000);

                        }else{
                            hiAlert(msg);
                        }
                    },
                    error:function(){
                        hiAlert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
                    }
                });

                //$("#edituser").hide("");
                //$("#usermag").show("");
                return false;
            }
        };
        var validation3 = {
						
            rules: {b_userpass: {required: true,minlength: 5},
                confirm_userpass: {required: true,minlength: 5,equalTo:"#b_userpass"}},
								 
            messages: {userpass: {  required: "密码需要填写",
                    minlength: "密码至少需要5个字符"},
                confirm_userpass: { required: "确认密码需要填写",
                    minlength: "密码至少需要5个字符",
                    equalTo: "2次输入的密码需要一致"}
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
                        hiAlert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
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
 

<div class=""  style=" ">
<div class="pad10">
   <span class="addAdmin fright" id="addadmin" >添加管理员</span>
    <div class="pageTitleTop">管理员配置</div>
    <div class="h10"></div>
    <!-- user manage begin  -->
    <div id="mag" style=" display: none;"> </div>
    <div id="usermag" style="display:none;"> 操作成功！
      <input type="button" name="canceladd" id="canceladd" value="关闭" />
    </div>
    <div id="adduser" style="display:none; " >
      <form id="new_user" method="post" action="{%site_url('system/system/user_add')%}">
        <fieldset>
          <legend><strong>添加一个新的用户</strong></legend>
          <dd><span class="beforeinput">用户名称：</span>
            <input type="text" name="username"  />
            <span class="beforeinput">登录密码：</span>
            <input type="password" name="userpass" id="userpass" />
            <span class="beforeinput">确认密码：</span>
            <input type="password" name="confirm_userpass"  />
          </dd>
          <dl>
          </dl>
          <dd> <span class="beforeinput">用户邮箱：</span>
            <input type="text" name="email" o />
            <span class="beforeinput">用户角色：</span>
            <select name="user_group" >
              <option value="0" selected="selected">选择一个分组</option>
                    {%foreach from=$data['roles'] item=rowr%}
              			<option value="{%$rowr->id%}">{%$rowr->name%}</option>
                    {%/foreach%}
                    
            
            
            </select>
            <input type="submit" name="submit" id="new_button" value="确定添加" />
            <input type="button" name="canceladd" id="canceladd" value="取消" />
            <span id="showmill" style="display:block; width:150px;" > </span> </dd>
        </fieldset>
      </form>
    </div>
    <!-- -->
    <div id="edituser" style="display:none; ">
      <form id="edit_user" method="post" action="{%site_url('system/system/user_edit')%}">
        <fieldset>
          <legend><strong>编辑所选用户</strong></legend>
          <dd><span class="beforeinput">用户名称：</span>
            <input type="text" name="username" />
            <span class="beforeinput">用户邮箱：</span>
            <input type="text" name="email" />
          </dd>
          <dl>
          </dl>
          <dd> <span class="beforeinput">用户角色：</span>
            <select name="user_group"  >
              <option value="" selected="selected">选择一个分组</option>
               {%foreach from=$data['roles'] item=rowr%}
              			<option value="{%$rowr->id%}">{%$rowr->name%}</option>
                    {%/foreach%}
            </select>
            <input type="hidden" name="uid" id="uid"  />
            <input type="submit" name="submit" id="edit_button" value="编辑用户" />
            <input type="hidden" value="" name="uid" />
          </dd>
        </fieldset>
      </form>
    </div>
    <!-- edit password-->
    <div id="editpass" style="display:none; ">
      <form id="edit_pass" method="post" action="{%site_url('system/system/user_editpass')%}">
        <fieldset>
          <legend><strong>修改用户密码</strong></legend>
          <dd><span class="beforeinput">用户名称：</span>
            <input type="text" name="username" readonly="readonly" />
            <span class="beforeinput">用户邮箱：</span>
            <input type="text" name="email" readonly="readonly" />
          </dd>
          <dl>
          </dl>
          <dd> <span class="beforeinput">登录密码：</span>
            <input type="password" name="b_userpass" id="b_userpass" />
            <span class="beforeinput">确认密码：</span>
            <input type="password" name="confirm_userpass"  />
            <input type="hidden" name="uid" id="uid"  />
            <input type="submit" name="submit" id="edit_passbut" value="编辑密码" />
            <input type="hidden" value="" name="uid" />
          </dd>
        </fieldset>
      </form>
    </div>
    <!-- --> 
    <!-- user manage end--> 
    <!--view begin-->
    <div >
      <table id="treeTable" class="treeTable">
        <thead>
          <tr>
            <th>用户名</th>
            <th>用户邮箱</th>
            <th>用户组</th>
            <th>操作</th>
          </tr>
        </thead>
        {%foreach from=$data['users']  item=row %}
        <tr id="{%$row->id%}">
          <td>{%$row->username%}</td>
          <td>{%$row->email%}</td>
          <td>{%$row->role_name%} </td>
          <td><button class="edit" name="edit" type="button"
                                                value="{%$row->id%}" ></button>
            &nbsp;&nbsp;&nbsp;
            <button class="editpass" name="editpass" type="button"
                                                value="{%$row->id%}"></button>
            &nbsp;&nbsp;
            <button class="delete" name="del" type="button"
                                                value="{%$row->id%}"></button></td>
        </tr>
        {%/foreach%}
      </table>
    </div>
    
    <!--end of view--> 
  </div>
</div>
{%include file="../foot.tpl"%} 