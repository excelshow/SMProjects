
<script type="text/javascript">
    //<![CDATA[
    $(document).ready(function(){
		$("#treeTable").treeTable();
		$("table#treeTable tbody tr:odd").addClass('even');
		$("table#treeTable tbody tr").mousedown(function() {
		  $("tr.selected").removeClass("selected"); // Deselect currently selected rows
		  $(this).addClass("selected");
		});
         
       
		// addjs
		 
		//// 批量分配QQ号码
		$("button[name='bqq_edit_batch']").click(function(){
				$.ajax({
						type: "POST",
						url: '{%site_url("bqq/bqq/user_edit_batch")%}',
						cache:false,
						data: 'id='+ $(this).val(),
						success: function(msg){
							$("#showLayout").html(msg);  
							hiBox('#showLayout','批量分配QQ号码',450,'','','.a_close'); 
							$('#hiAlertform').bind("invalid-form.validate").validate({
												submitHandler:function(){
												   var post_data = $("#hiAlertform").serializeArray();
												   var subType = $("#action").val();
												   
												  // return false;
													$.ajax({
														type: "POST",
														url: "{%site_url('bqq/bqq/user_edit_batch_do')%}",
														cache:false,
														data: post_data,
														beforeSend: function(){
															hiClose(); // hiBox('#runShow','',450,'','','.a_close'); 
															jNotify("后台正在努力处理中，请稍后..",{
																		VerticalPosition : 'center',
																		HorizontalPosition : 'center',
																		autoHide : false,
																		ShowOverlay : true,   //是否显示遮罩层（遮罩层即半透明黑色背景）
																		ColorOverlay : '#000',   //遮罩层颜色
																		OpacityOverlay : 0.3,   //遮罩层透明度，最大是1，最小是0.1
																	});
														  },
														success: function(msg){
															$.jNotify._close();	 
															if(msg == 0){
																
																jSuccess("操作成功! 正在刷新页面...",{
																		VerticalPosition : 'center',
																		HorizontalPosition : 'center',
																		ShowOverlay : true,   //是否显示遮罩层（遮罩层即半透明黑色背景
																		TimeShown : 500,
																		ColorOverlay : '#000',   //遮罩层颜色
																		OpacityOverlay : 0.3,   //遮罩层透明度，最大是1，最小是0.1
																	});
																   //  setInterval(function(){window.location.reload();},1000);	
																postdnAjax($("#rootid").val());
															}else{
																  
																 hiAlert(msg);
															}
														},
														error:function(){
															$.jNotify._close();	 
															hiAlert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
														}
													});
													return false;
													
												}
											}); 
							//$("#adddept").show();   
							
						},
						error:function(){
							hiAlert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
						}
					});
				
				 			
			});
		 
		//////////////
		 $('button[name="bqq_add_auto"]').click(function(){
			$.ajax({
                        type: "POST",
                        url: "{%site_url('bqq/bqq/user_add_auto')%}/" + $(this).val(),
                        success:function(msg){
                                 $("#showLayout").html(msg);
								  hiBox('#showLayout','批量建立QQ号码','','','','.a_close');
								  $('#hiAlertform').bind("invalid-form.validate").validate(add_auto);
                            
                        }	   
                    });

                    return false;
		});	
		
		 var add_auto = {
            rules: {
				qqs:{required: true,digits:true }
            		},
            messages: {
                qqs:{required: "输入QQ号码个数",digits:"输入正确的QQ个数" }
            		},
			submitHandler : function(){
						   //表单的处理
						   var post_data = $("#hiAlertform").serializeArray();
						  
						   $.ajax({
								 type: "POST",
									 url: "{%site_url('bqq/bqq/user_add_auto_do')%}",
									async:false,
									data:post_data,
									beforeSend: function(){
										  hiClose();
						   				  jNotify("后台正在努力处理中，请稍后..",{
													VerticalPosition : 'center',
													HorizontalPosition : 'center',
													autoHide : false,
													ShowOverlay : true,   //是否显示遮罩层（遮罩层即半透明黑色背景）
													ColorOverlay : '#000',   //遮罩层颜色
													OpacityOverlay : 0.3,   //遮罩层透明度，最大是1，最小是0.1
												});
									  },
									success: function(msg){
										if(msg ==0){
											$.jNotify._close();	 
											jSuccess("操作成功! 正在刷新页面...",{
												VerticalPosition : 'center',
												HorizontalPosition : 'center',
												TimeShown : 1000,
											});
										}else{
											$.jNotify._close();	
											jError(msg,{
													VerticalPosition : 'center',
													HorizontalPosition : 'center',
													TimeShown : 1000,});
												 
										}
									}
								});
						   return false;//阻止表单提交
				}
        };
	////page 
	$("button[name='page']").bind("click",function(){
					var url = $(this).val();
					var key = $('input[name="searchText"]').val();
					if(url!='undefined'){
						$.post(url,{ key: key},function(data){
							$('#staffshow').html(data)
						});
					}
				});	

		 //////////bind itname
		$('button[name="user_bind_itname"]').bind("click",function(){
                     $.ajax({
                        type: "POST",
                        url: "{%site_url('bqq/bqq/user_bind_itname')%}/",
						data: 'qq='+ $(this).val(),
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
								  hiBox('#showLayout','QQ绑定用户','','','','.a_close');
								  $('#hiAlertform').bind("invalid-form.validate").validate({
									   			rules: {itname: {required: true,minlength: 2,}},
												messages: {itname: {required: " 请输入用户账号",minlength: "至少2个字符",}},
									  			submitHandler:function(){
												   var post_data = $("#hiAlertform").serializeArray();
												   var subType = $("#action").val();
												   
												  // return false;
													$.ajax({
														type: "POST",
														url: "{%site_url('bqq/bqq/user_bind_itname_do')%}",
														cache:false,
														data: post_data,
														beforeSend: function(){
															hiClose(); // hiBox('#runShow','',450,'','','.a_close'); 
															jNotify("后台正在努力处理中，请稍后..",{
																		VerticalPosition : 'center',
																		HorizontalPosition : 'center',
																		autoHide : false,
																		ShowOverlay : true,   //是否显示遮罩层（遮罩层即半透明黑色背景）
																		ColorOverlay : '#000',   //遮罩层颜色
																		OpacityOverlay : 0.3,   //遮罩层透明度，最大是1，最小是0.1
																	});
														  },
														success: function(msg){
															$.jNotify._close();	 
															if(msg == 0){
																
																jSuccess("操作成功! 正在刷新页面...",{
																		VerticalPosition : 'center',
																		HorizontalPosition : 'center',
																		ShowOverlay : true,   //是否显示遮罩层（遮罩层即半透明黑色背景
																		TimeShown : 500,
																		ColorOverlay : '#000',   //遮罩层颜色
																		OpacityOverlay : 0.3,   //遮罩层透明度，最大是1，最小是0.1
																	});
																   //  setInterval(function(){window.location.reload();},1000);	
																postdnAjax($("#rootid").val());
															}else{
																  
																 hiAlert(msg);
															}
														},
														error:function(){
															$.jNotify._close();	 
															hiAlert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
														}
													});
													return false;
													
												}
									  });
                            }
                        }	   
                    });

                    return false;	
        });
	// del deptname begin
			$("button[name='user_out_itname']").click(function(){
				var val = $(this).val();
				hiConfirm('你确定清除用户和QQ号码吗?<br>系统保留号码将清除用户信息，普通号码将放回QQ号码池!!!',null,function(r){
					if(r){
						$.ajax({
							type: "POST",
							url: "{%site_url('bqq/bqq/user_out_itname_do')%}",
							cache:false,
							data: 'qq='+val,
							beforeSend: function(){
														 
															jNotify("后台正在努力处理中，请稍后..",{
																		VerticalPosition : 'center',
																		HorizontalPosition : 'center',
																		autoHide : false,
																		ShowOverlay : true,   //是否显示遮罩层（遮罩层即半透明黑色背景）
																		ColorOverlay : '#000',   //遮罩层颜色
																		OpacityOverlay : 0.3,   //遮罩层透明度，最大是1，最小是0.1
																	});
														  },
							success: function(msg){ 
								if(msg==0){
									// tr.remove();
									 // $("#adddept").html("操作成功！正在刷新页面....");
								 jSuccess("操作成功! 正在刷新页面...",{
									VerticalPosition : 'center',
									HorizontalPosition : 'center',
									TimeShown : 2000,
									});
									 postdnAjax($("#rootid").val());
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
			/////////////////////////
});
 function postdnAjax(val){
            $.ajax({
                type: "POST",
                url: '{%site_url("bqq/bqq/bqqlist")%}/',
                cache:false,
                data: 'id='+val,
                success: function(msg){
                 $("#ouShow").html(msg);
                    // alert(val);       
                },
                error:function(){
                    hiAlert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
                }
            });
        }
</script>
      
 <div class="  " style=" padding:10px 0 0 0; text-align:right;">
  {%if ($id == 6)%}
     {%if ($sysPermission["bqq_add"] == 1)%}
     
     <button class="buttom" name="bqq_add_auto" type="button" value="">批量新开QQ号码</button>
     {%/if%}
 {%/if%}
  {%if ($id > 6)%}
     {%if ($sysPermission["bqq_add"] == 1)%}
     <button class="buttom" name="bqq_edit_batch" type="button" value="{%$id%}">批量分配QQ号码</button>
     {%/if%}
 {%/if%}    
     </div>
  {%if ($data)%}
 <div class="pageNav">{%$links%}</div>
  <form name=""  method="post">
    <table  class="treeTable" id="treeTable">
      <thead>
        <tr>
          <th>QQ号码</th>
         
          <th>状态</th>
          <th>角色</th>
           <th>部门</th>
          <th>姓名</th> 
          <th>登录帐号</th>
          <th>电话</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
      
     
      
      {%foreach from=$data item=row%}
      <tr id="{%$row->bs_qq%}">
       <td><span title="{%$row->qq_open_id%}" >{%$row->bs_qq%}</span></td>
         
        <td> 
          {%if $row->bs_status == 1 %}
         	 正常 
          {%/if%}
          {%if $row->bs_status == 2 %}
          	待分配
          {%/if%}
          {%if $row->bs_status == 3 %}
          	部门保留号码
          {%/if%}
         
          </td>
        <td>&nbsp;</td>
            <td><span title="{%$row->deptOu%}">{%$row->deptname%}</span></td>
            {%if $row->staffInfo %}
           <td>{%$row->staffInfo->cname%}</td>
         <td>{%$row->staffInfo->itname%}</td>
        <td>
        {%if $row->staffInfo->address%}
        	{%$row->staffInfo->address->sa_tel%}
         {%/if%}
        </td>
         {%else%}
        <td colspan="3">
        	--
        </td>
        {%/if%}
        <td>
          {%if $row->bs_status == 1  || ($row->bs_status == 3 &&  $row->staffInfo)%}
         	 <button class="buttonOt"  name="user_out_itname" type="button" value="{%$row->bs_qq%}">分离用户</button> 
          {%/if%}
          {%if $row->bs_status == 2 ||  $row->staffInfo==false%}
          <button class="button"  name="user_bind_itname" type="button" value="{%$row->bs_qq%}">绑定用户</button>
          {%/if%}
          </td>
      </tr>
      {%/foreach%}
      
    
        </tbody>
      
    </table>
  </form>
  <div class="pageNav">{%$links%}</div>
     {%else%}
    暂无记录
      {%/if%}