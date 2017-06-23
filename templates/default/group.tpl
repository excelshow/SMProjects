{%include file="./header.tpl"%} 
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
				
				$("button[name='edit']").click(function(){
						var tr = $(this).parents('tr');
						var tds = tr.find('td');
						$("#edit_group input[name='group_name']").focus().val($(tds[0]).html());
						$("#edit_group input[name='permission']").val($(tds[1]).html());
						$("#edit_group input[name='makes']").val($(tds[2]).html());
						$("#edit_group input[name='group_id']").val(tr.attr('id'));
				});
				$("button[name='del']").click(function(){
					var tr = $(this).parents('tr');
					ymPrompt.confirmInfo('你确定要删除这条记录吗?',null,null,'删除确认',function(r){
							if(r =="ok"){
								$.ajax({
									type: "POST",
									url: "{%site_url('system/group_del')%}",
									cache:false,
									data: 'group_id='+tr.attr('id'),
									success: function(msg){
										flag = (msg=="ok");
										if(flag){
											tr.remove();
											act_on_tr();
										}else{
											ymPrompt.alert(msg);
										}
									},
									error:function(){
										ymPrompt.alert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
									}
								}); 
							}
					});
			});
		}
		
		
		
        $(document).ready(function(){
                act_on_tr();
				 
                var validation1 = {
                		rules: {group_name: {required: true}},
						messages: {group_name: {  required: "组名需要填写"}},
						submitHandler:function(){
									   var post_data = $("#new_group").serializeArray();
										$.ajax({
											type: "POST",
											url: $("#new_group").attr("action"),
											cache:false,
											data: post_data,
											success: function(msg){
												flag = /ok/g.test(msg);
												if(flag){
													html = "<tr id='"+msg.replace(/ok/g,"")+"'><td>"+$("#new_group input[name='group_name']").val()+"</td><td>"+$("#new_group input[name='permission']").val()+"</td><td><button class='edit' name='edit' type='button' ></button>&nbsp;<button class='delete' name='del' type='button' ></button></td>";
													$("#treeTable tr:last").after(html);
													$("#new_group input[type='text']").val("");
													act_on_tr();
												}else{
													ymPrompt.alert(msg);
												}
											},
											error:function(){
												ymPrompt.alert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
											}
										}); 
										return false;
						}
				};
				var validation2 = {
						rules: {group_name: {required: true},
								group_id :{required:true}},
						messages: {group_name: {  required: "组名需要填写"},group_id:{required:"请选择一个要编辑的用户组"}},
						submitHandler:function(){
									   var post_data = $("#edit_group").serializeArray();
										$.ajax({
											type: "POST",
											url: $("#edit_group").attr("action"),
											cache:false,
											data: post_data,
											success: function(msg){
												flag = (msg=="ok");
												if(flag){
													var tr = $("tr#"+$("#edit_group input[name='group_id']").val());
													var tds = tr.find('td');
													$(tds[0]).html($("#edit_group input[name='group_name']").val());
													$(tds[1]).html($("#edit_group input[name='permission']").val());
													$(tds[2]).html($("#edit_group input[name='makes']").val());
													$("#edit_group input[type='text']").val("");
												}else{
													ymPrompt.alert(msg);
												}
											},
											error:function(){
												ymPrompt.alert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
											}
										}); 
										return false;
						}
				};
				$('#new_group').validate(validation1);
				$('#edit_group').validate(validation2);
        });
    //]]>
</script> 

<!--view begin-->
<div class="sidebarLeft ">
	<div class="pad10">
    <div class="titleLeft" >系统管理</div>
    <div class=" menuLeft"> {%$showmenu%} </div>
  </div>
</div>
 <div class="sidebarMainTo"  style=" ">
<div class="pad10">
    <div class="title">管理员分组</div>
    <table id="treeTable" class="treeTable">
      <thead>
        <tr>
          <th>用户组名称</th>
          <th>用户组权限</th>
          <th>用户组说明</th>
          <th>操作</th>
        </tr>
      </thead>
      {%foreach from = $groups  item = row %}
      <tr id="{%$row->group_id%}">
        <td>{%$row->group_name%}</td>
        <td>{%($row->permissions)%}</td>
        <td>{%($row->makes)%}</td>
        <td><button class="edit" name="edit" type="button"></button>
          <button class="delete" name="del" type="button"></button></td>
      </tr>
      {%/foreach%}
    </table>
    <div align="center">{%$links%}</div>
    <!--end of view-->
    <table width="100%" cellspacing="0" >
      <tr>
        <td width="50%" valign="top" bgcolor="#FFFFFF"><form id="new_group" method="post" action="{%site_url('system/group_add')%}">
            <fieldset>
              <legend>添加一个新的用户组</legend>
              <span class="beforeinput">组名称：</span>
              <input type="text" name="group_name" class="inputbox"  />
              <br />
              <span class="beforeinput">组权限：</span>
              <input name="permission" type="text" class="inputbox" size="50"  />
              <br />
              <span class="beforeinput">组说明：</span>
              <input name="makes" type="text" class="inputbox" size="50"  />
              <br />
              <span class="beforeinput">&nbsp;</span>
              <input type="submit" name="submit" value="确定添加" />
            </fieldset>
          </form></td>
        <td valign="top" bgcolor="#FFFFFF"><form id="edit_group" method="post" action="{%site_url('system/group_edit')%}">
            <fieldset>
              <legend>编辑所选用户组</legend>
              <span class="beforeinput">组名称：</span>
              <input type="text" name="group_name" class="inputbox"  />
              <br />
              <span class="beforeinput">组权限：</span>
              <input name="permission" type="text" class="inputbox" size="50"  />
              <br />
              <span class="beforeinput">组说明：</span>
              <input name="makes" type="text" class="inputbox" size="50"  />
              <br />
              <span class="beforeinput">&nbsp;</span>
              <input type="submit" name="submit" id="edit_button" value="确定添加" />
              <input type="hidden" value="" name="group_id" />
            </fieldset>
          </form></td>
      </tr>
    </table>
    <!--end of view--> 
    
  </div>
  <div class="clearb"></div>
</div>
{%include file="./foot.tpl"%} 