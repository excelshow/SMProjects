<script type="text/javascript">
    //<![CDATA[
    $(document).ready(function(){
		$("#treeTable").treeTable();
		$("table#treeTable tbody tr:odd").addClass('even');
		$("table#treeTable tbody tr").mousedown(function() {
		  $("tr.selected").removeClass("selected"); // Deselect currently selected rows
		  $(this).addClass("selected");
		});
         
        $('table#treeTable tbody tr').hover(
			function () {
				$(this).addClass("hover");
			},
			function () {
				$(this).removeClass("hover");
			}
		);
		$('button[name="disable"]').bind("click",function(){
							$this = $(this).val();
							hiConfirm('确认此用户离职?',null,function(r){
								if(r){
									$.ajax({
										type: "POST",
										url: "{%site_url('staff/staff/staffdisable')%}",
										data: "id="+$this,
										success: function(msg){
											//alert(msg);
											if(msg==1){
											 
											  jSuccess("操作成功!",{
													VerticalPosition : 'center',
													HorizontalPosition : 'center',
													TimeShown : 1000,
												});
												val = $('input[name="rootid"]').val();
												key = $('input[name="searchText"]').val();
												 loadstaff(val,key)
											   // setInterval(function(){window.location.reload();},1000);	
											}else{
												alert(msg);
											}
										},
										// complete: function() { alert("complete"); }   
									});
									return false;		
								}
							});
						} 
			);
		$('button[name="enabled"]').bind("click",function(){
				$this = $(this).val();
				hiConfirm('确认激活此用户',null,function(r){ 
				  if(r){
						$.ajax({
							type: "POST",
							url: "{%site_url('staff/staff/staffenabled')%}",
							data: "id="+$this,
							success: function(msg){
								// alert(msg);
								if(msg == 1){
									// $("tr#"+n).remove();
									//ymPrompt.succeedInfo({message:'操作成功！请稍候, 正在刷新页面....'});
									jSuccess("操作成功! 正在刷新页面...",{
										VerticalPosition : 'center',
										HorizontalPosition : 'center',
										TimeShown : 1000,
									});
									key = $('input[name="searchText"]').val();
									val = $('input[name="rootid"]').val();
									loadstaff(val,key)
								}else{
									alert(msg);
								}
							}	   
						});
						return false;		
					}
				});  
			}
		);
		// addjs
		// check email
	 
		 var addjs = {
            rules: {
				surname:{required: true,maxlength: 20},
				firstname:{required: true,maxlength: 20},
                logon_name: {required: true,minlength: 2},//
				email:{required: true,minlength: 2} //,checkname:''
            },
            messages: {
                surname:{required: "用户姓必填",minlength: "最多20个字符"},
				firstname:{required: "用户名必填",minlength: "最多20个字符"},
				logon_name: {required: " 请输入IT登录名",minlength: "至少2个字符",checkname:'此登录已经存在'},
				email:{required: " 请输入Email地址",minlength: "至少2个字符",checkname:'此email已经存在'}
            },
			submitHandler : function(){
						   //表单的处理
						   var post_data = $("#hiAlertform").serializeArray();
						   url = "{%site_url('staff/staff/staffmodifycomplete')%}";
						   hiClose();
						   $.ajax({
								 type: "POST",
									url: url,
									async:false,
									data:post_data,
									success: function(msg){
										if (msg == 1 || msg == 2){
											 jSuccess("操作成功"+msg+"! 正在刷新页面...",{
												VerticalPosition : 'center',
												HorizontalPosition : 'center',
												TimeShown : 1000
											});
											key = $('input[name="searchText"]').val();
											val = $('input[name="rootid"]').val();
											loadstaff(val,key)
										}else{
											jError("操作失败! ",{
												VerticalPosition : 'center',
												HorizontalPosition : 'center',
												TimeShown : 1000
											});
									   }
									}
								});
						   return false;//阻止表单提交
				}
        };
		 
		$('button[name="edit"]').bind("click",function(){
                     $.ajax({
                        type: "POST",
                        url: "{%site_url('staff/staff/staffmodify')%}/" + $(this).val(),
                        success:function(msg){
                            //alert(msg);
                            if(msg=="0"){
                                // $("tr#"+n).remove();
                                jError("操作成功! 正在刷新页面...",{
									VerticalPosition : 'center',
									HorizontalPosition : 'center',
									TimeShown : 2000,
								});
                              
                            }else{
                                 $("#showLayout").html(msg);
								  hiBox('#showLayout','编辑用户','','','','.a_close');
								  $('#hiAlertform').bind("invalid-form.validate").validate(addjs);
                            }
                        }	   
                    });

                    return false;
						
                }
		);
		$('button[name="del"]').bind("click", function(){
				$this = $(this).val();
				hiConfirm('确认删除此用户？',null,function(tp){
					if(tp){
						$.ajax({
							type: "POST",
							url: "{%site_url('staff/staff/staffdeleteTrue')%}",
							data: "id="+$this,
							success: function(msg){
								//alert(msg);
								if(msg==1){
									// $("tr#"+n).remove();
									jSuccess("操作成功! 正在刷新页面...",{
										VerticalPosition : 'center',
										HorizontalPosition : 'center',
										TimeShown : 1000,
									});
									key = $('input[name="searchText"]').val();
									val = $('input[name="rootid"]').val();
									loadstaff(val,key)
									//setInterval(function(){window.location.reload();},1000);
									//window.location = "{site_url('staff/') ?>";
										
								}else{
									hiAlert(msg);
								}
							}
								   
						});
						return false;
							
					}
				});
			}
		);
		$('button[name="move"]').bind("click",function(){
         		window.location = "{%site_url('staff/staff/staffmove')%}/"+$(this).val();
                }
			);
		//$('#all_check').bind("click",all_check);
	  
		
		 
        
		// edit staff  end
		 
		$("button[name='page']").bind("click",function(){
					var url = $(this).val();
					var key = $('input[name="searchText"]').val();
					if(url!='undefined'){
						$.post(url,{ key: key},function(data){
							$('#staffshow').html(data)
						});
					}
				});
			function loadstaff(val,key){
			 $.ajax({
                type: "POST",
                url: "{%site_url('staff/staff/stafflist')%}/"+val,
                cache:false,
				
                data: 'key='+key,
                success: function(msg){
                    $("#staffshow").html(msg);
					  // alert(val);          
                },
                error:function(){
					jError("出错啦，刷新试试，如果一直出现，可以联系开发人员解决",{
						VerticalPosition : 'center',
						HorizontalPosition : 'center',});
                     
                }
            });
        }		
    });
    //]]>
</script>
{%if $smarty.session.DX_role_name=='Manager' %}
<div style="float:right;"> <a href='{%site_url("staff/staff/staffOut/{%$id%}")%}' target="_blank" class="buttom">导出用户</a></div>
{%/if%}
 <div class="pageNav">{%$links%}</div>
  <form name=""  method="post">
    <table  class="treeTable" id="treeTable">
      <thead>
        <tr>
         <!-- <th width="40"><input id="all_check" type="checkbox"/></th>-->
          <th>姓名</th> 
          <th>登录帐号</th>
           <th>岗位</th>
          <th>部门</th>
         
          <th>用户状态</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
      
      {%if ($data)%}
      <div style="padding:4px;" >
      {%foreach from=$data item=row%}{%$row->itname%};{%/foreach%}
      </div>
      {%foreach from=$data item=row%}
      <tr id="{%$row->id%}">
       <!-- <td><input class="all_check" type="checkbox" name="staff_id" value="{%$row->id%}"/></td>-->
        <td>{%$row->cname%}</td>
         <td>{%$row->itname%}</td>
 <td>{%$row->station%} 
          </td>
        <td><span title="{%$row->deptOu%}">{%$row->deptname%}</span> 
         {%if ($sysPermission["staff_move"] == 1)%}
        <button class="button"  name="move" type="button" value="{%$row->id%}">调岗</button>
         {%/if%}
         <!--[<a href="{%site_url('staff/staffmove')%}/{%$row->id%}">更改</a>]--></td>
         
        <td> {%if $row->enabled == 1 %}
          在职
          {%if ($sysPermission["staff_disable"] == 1)%}
          <button class="button" name="disable" type="button"
                                    value="{%$row->id%}">离职</button>
                                     {%/if%}
          {%/if%}
          {%if $row->enabled == 0 %}
          离职
          {%if ($sysPermission["staff_disable"] == 1)%}
          <button class="buttonOt" name="enabled" type="button"
                                    value="{%$row->id%}">入职</button>
                                     {%/if%}
          {%/if%} </td>
        <td>
        {%if $row->enabled == 1 %}
        {%if ($sysPermission["staff_edit"] == 1)%}
          <button class="button"  name="edit" type="button" value="{%$row->id%}">编辑</button>
            {%/if%}
          {%/if%}
        {%if $row->enabled == 0 %}{%if ($sysPermission["staff_del"] == 1)%}
                                      <button class="buttonOt"  name="del" type="button" value="{%$row->id%}">删除</button>
                                       {%/if%}
                                      {%/if%}
          </td>
      </tr>
      {%/foreach%}
      
      {%else%}
      <tr>
        <td colspan="6">暂无记录！</td>
      </tr>
      {%/if%}
        </tbody>
      
    </table>
  </form>
  <div class="pageNav">{%$links%}</div>
   