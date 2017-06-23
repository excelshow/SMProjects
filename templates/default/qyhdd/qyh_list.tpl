 
<script type="text/javascript">
 
    //<![CDATA[
    $(document).ready(function(){
		$("#treeTable").treeTable();
		$("table#treeTable tbody tr:odd").addClass('even');
		$("table#treeTable tbody tr").mousedown(function() {
		  $("tr.selected").removeClass("selected"); // Deselect currently selected rows
		  $(this).addClass("selected");
		});
         
		 
		//// 批量导入用户到企业号
		$("button[name='qyh_staff_sync']").click(function(){
				$.ajax({
						type: "POST",
						url: '{%site_url("qyhdd/qyhdd/qyh_staff_sync")%}',
						cache:false,
						data: 'id='+ $(this).val(),
						success: function(msg){
							$("#showLayout").html(msg);  
							hiBox('#showLayout','批量导入用！',450,'','','.a_close'); 
							$('#hiAlertform').bind("invalid-form.validate").validate(qyh_sync); 
							//$("#adddept").show();   
							
						},
						error:function(){
							hiAlert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
						}
					});
				
				 			
			});
	///
	//// 导入用户到企业号
		$("button[name='qyh_staff_add']").click(function(){
				$.ajax({
						type: "POST",
						url: '{%site_url("qyhdd/qyhdd/qyh_staff_add")%}',
						cache:false,
						data: 'itname='+ $(this).val(),
						success: function(msg){
							$("#showLayout").html(msg);  
							hiBox('#showLayout','导入用户！',450,'','','.a_close'); 
							$('#hiAlertform').bind("invalid-form.validate").validate(qyh_sync); 
							//$("#adddept").show();   
							
						},
						error:function(){
							hiAlert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
						}
					});
				
				 			
			});
	///
	//// 批量导入用户到OA MTC
		$("button[name='qyh_oamtc_sync']").click(function(){
				$.ajax({
						type: "POST",
						url: '{%site_url("qyhdd/qyhdd/qyh_oamtc_sync")%}',
						cache:false,
						data: 'id='+ $(this).val(),
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
							$("#showLayout").html(msg);  
							hiBox('#showLayout','批量导入用！',450,'','','.a_close'); 
							$('#hiAlertform').bind("invalid-form.validate").validate(oamtc_sync); 
							//$("#adddept").show();   
							
						},
						error:function(){
							hiAlert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
						}
					});
				
				 			
			});
	///
	////同步用户到 OA MTCqyh_oamtc_add
	$("button[name='qyh_oamtc_add']").click(function(){
				$.ajax({
						type: "POST",
						url: '{%site_url("qyhdd/qyhdd/qyh_oamtc_add")%}',
						cache:false,
						data: 'itname='+ $(this).val(),
						success: function(msg){
							 if(msg ==1){
								 jSuccess("操作成功! 正在刷新页面...",{
												VerticalPosition : 'center',
												HorizontalPosition : 'center',
												ShowOverlay : true,   //是否显示遮罩层（遮罩层即半透明黑色背景
												TimeShown : 500,
												ColorOverlay : '#000',   //遮罩层颜色
												OpacityOverlay : 0.3,   //遮罩层透明度，最大是1，最小是0.1
											});
										 
								  postdnAjax($("button[name=qyh_staff_sync]").val());
							 }else{
								 hiAlert(msg);
							 }
							
						},
						error:function(){
							hiAlert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
						}
					});
				
				 			
			});
	///
	// 联系电话(手机/电话皆可)验证
		jQuery.validator.addMethod("isPhone", function(value,element) {
		  var length = value.length;
		  var mobile = /^(((1[0-9]{2})|(15[0-9]{1}))+\d{8})$/;
		  return this.optional(element) || mobile.test(value);
		
		}, "请正确填写您的联系电话"); 
	   qyh_sync = {rules: {
                mobile: {required: true,isPhone:true}
            },
            messages: {
                mobile: {required: "请输入手机号码",isPhone: "至少5个字符"}
            },
						submitHandler:function(){
						   var post_data = $("#hiAlertform").serializeArray();
						   var subType = $("#action").val();
						  // return false;
							$.ajax({
								type: "POST",
								url: "{%site_url('qyhdd/qyhdd/qyh_staff_sync_do')%}",
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
									if(msg == 1){
										
										jSuccess("操作成功! 正在刷新页面...",{
												VerticalPosition : 'center',
												HorizontalPosition : 'center',
												ShowOverlay : true,   //是否显示遮罩层（遮罩层即半透明黑色背景
												TimeShown : 500,
												ColorOverlay : '#000',   //遮罩层颜色
												OpacityOverlay : 0.3,   //遮罩层透明度，最大是1，最小是0.1
											});
										   //  setInterval(function(){window.location.reload();},1000);	
										 postdnAjax($("button[name=qyh_staff_sync]").val());
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
					};
	//////
	oamtc_sync = {  submitHandler:function(){
						   var post_data = $("#hiAlertform").serializeArray();
						   var subType = $("#action").val();
						  // return false;
							$.ajax({
								type: "POST",
								url: "{%site_url('qyhdd/qyhdd/qyh_oamtc_sync_do')%}",
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
									if(msg == 1){
										
										jSuccess("操作成功! 正在刷新页面...",{
												VerticalPosition : 'center',
												HorizontalPosition : 'center',
												ShowOverlay : true,   //是否显示遮罩层（遮罩层即半透明黑色背景
												TimeShown : 500,
												ColorOverlay : '#000',   //遮罩层颜色
												OpacityOverlay : 0.3,   //遮罩层透明度，最大是1，最小是0.1
											});
										   //  setInterval(function(){window.location.reload();},1000);	
										 postdnAjax($("button[name=qyh_staff_sync]").val());
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

		 
	// del qyh_staff begin
	$("button[name='qyh_staff_del']").click(function(){
				var val = $(this).val();
				hiConfirm('你确定清除用户在企业号的信息吗?!!!',null,function(r){
					if(r){
						$.ajax({
							type: "POST",
							url: "{%site_url('qyhdd/qyhdd/qyh_staff_del')%}",
							cache:false,
							data: 'itname='+val,
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
							$.jNotify._close();	 
								if(msg==0){
									// tr.remove();
									 // $("#adddept").html("操作成功！正在刷新页面....");
								 jSuccess("操作成功! 正在刷新页面...",{
									VerticalPosition : 'center',
									HorizontalPosition : 'center',
									autoHide : true,
									TimeShown : 2000,
									});
									 postdnAjax($("button[name=qyh_staff_sync]").val());
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
			//// 锁定 qyh_oamtc_del
			$("button[name='qyh_oamtc_del']").click(function(){
				var val = $(this).val();
				hiConfirm('你确定锁定用户 OA MTC 的信息吗?!!!',null,function(r){
					if(r){
						$.ajax({
							type: "POST",
							url: "{%site_url('qyhdd/qyhdd/qyh_oamtc_del')%}",
							cache:false,
							data: 'itname='+val,
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
							$.jNotify._close();	 
								if(msg==1){
									// tr.remove();
									 // $("#adddept").html("操作成功！正在刷新页面....");
								 jSuccess("操作成功! 正在刷新页面...",{
									VerticalPosition : 'center',
									HorizontalPosition : 'center',
									autoHide : true,
									TimeShown : 2000,
									});
									 postdnAjax($("button[name=qyh_staff_sync]").val());
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
                url: '{%site_url("qyhdd/qyhdd/qyh_list")%}/'+val,
                cache:false,
                data: 'id='+val,
                success: function(msg){
					  $("#staffshow").html(msg);
                // $("#ouShow").html(msg);
                    // alert(val);       
                },
                error:function(){
                    hiAlert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
                }
            });
        }
</script>
      
 <div class="  " style=" padding:10px 0 0 0; text-align:right; ">
  
  
     {%if ($sysPermission["qyh_staff"] == 1)%}
     <button class="buttom" name="qyh_staff_sync" type="button" value="{%$id%}">同步所属用户到微信</button>
     <button class="buttom" name="qyh_oamtc_sync" type="button" value="{%$id%}">同步所属用户到OA-MTC</button>
     {%/if%}
      </div>
  {%if ($data)%}
 <div class="pageNav">{%$links%}</div>
  <form name=""  method="post">
    <table  class="treeTable" id="treeTable">
      <thead>
        <tr>
          
          <th>姓名</th> 
          <th>登录帐号</th>
          <th>手机</th>
          <th>企业号</th>
          <th>OA-MTC</th>
        </tr>
      </thead>
      <tbody>
      
     
      
      {%foreach from=$data item=row%}
      <tr id="">
      
       
           
           <td>{%$row->cname%}</td>
         <td>{%$row->itname%}</td>
        <td>
        {%if $row->address%}
        	{%$row->address->sa_mobile%}
         {%/if%}
        </td>
      
         
        <td>
         {%if $row->qyhStatus == 1%}
             {%if ($sysPermission["qyh_staff"] == 1)%}
         	 已同步 <button class="buttonOt"  name="qyh_staff_del" type="button" value="{%$row->itname%}">从企业号删除</button> 
          {%/if%}
         {%else%} 
        	未同步 <button class="buttonOt"  name="qyh_staff_add" type="button" value="{%$row->itname%}">同步到企业号</button>  
         {%/if%}
         
          </td>
            <td>
         {%if $row->qyhStatus == 1%}
            {%if $row->qyh_staff->oa_mtc == 1%}
                已同步 <button class="buttonOt"  name="qyh_oamtc_del" type="button" value="{%$row->itname%}">失效</button> 
            {%else%}
                未同步 <button class="buttonOt"  name="qyh_oamtc_add" type="button" value="{%$row->itname%}">激活MTC</button>
             {%/if%}
         {%else%}
        	未同步 
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