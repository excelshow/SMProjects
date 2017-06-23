{%include file="../header.tpl"%} 
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
							hiConfirm('确认锁定此用户?',null,function(r){
								if(r){
									$.ajax({
										type: "POST",
										url: "{%site_url('staff/staff/staffdisable')%}",
										data: "id="+$this,
										success: function(msg){
											//alert(msg);
											if(msg=="ok"){
											 
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
								//alert(msg);
								if(msg=="ok"){
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
				surname:{required: true,maxlength: 4},
				firstname:{required: true,maxlength: 4},
                logon_name: {required: true,minlength: 2},//
				email:{required: true,minlength: 2} //,checkname:''
            },
            messages: {
                surname:{required: "用户姓必填",minlength: "最多4个字符"},
				firstname:{required: "用户名必填",minlength: "最多4个字符"},
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
						
        });
		 
		//// 批量分配QQ号码
		$("input[name='tools_status']").click(function(){					   
				  // return false;
				  	var qqhm = $("#qq").val();
					$.ajax({
						type: "POST",
						url: "{%site_url('bqq/bqq/tools_status_do')%}",
						cache:false,
						data: "qq="+qqhm,
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
				 
				
				 			
			});
		 
		//$('#all_check').bind("click",all_check);
		  
		//////////////
		 
	////page 
	 
    });
    //]]>
</script>
<div class="pageNav"></div>
     <table  class="treeTable" id="treeTable">
      <thead>
        <tr>
          <th width="34">序号</th>
         
          <th width="56">功能</th>
           <th width="466">操作</th>
        </tr>
      </thead>
      <tbody>
      <tr id="">
       <td>1</td>
         
        <td>QQ</td>
            <td><label for="qq"></label>
              QQ号码:
                <input name="qq" type="text" id="qq" value="" />
              <input type="button" name="tools_status" id="tools_status" value="提交" /></td>
        </tr>
     
      
    
        </tbody>
      
    </table>
  
  <div class="pageNav"></div>
{%include file="../foot.tpl"%}