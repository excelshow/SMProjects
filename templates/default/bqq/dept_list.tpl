<script type="text/javascript">
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
			 // function adddept start
		var deptToQQ = {
            submitHandler:function(){
               var post_data = $("#hiAlertform").serializeArray();
               var subType = $("#action").val();
			   
			  // return false;
                $.ajax({
                    type: "POST",
                    url: "{%site_url('bqq/bqq/dept_toqq_do')%}",
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
						if(msg == 0){
							$.jNotify._close();	 
							jSuccess("操作成功! 正在刷新页面...",{
									VerticalPosition : 'center',
									HorizontalPosition : 'center',
									ShowOverlay : true,   //是否显示遮罩层（遮罩层即半透明黑色背景
									TimeShown : 500,
									ShowOverlay : true,   //是否显示遮罩层（遮罩层即半透明黑色背景）
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
                        hiAlert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
                    }
                });
				return false;
                
            }
        };
			// into qq
			$("button[name='inToqq']").click(function(){
				$.ajax({
						type: "POST",
						url: '{%site_url("bqq/bqq/dept_toqq")%}',
						cache:false,
						data: 'id='+ $(this).val(),
						success: function(msg){
					   //  $("#ouShow").html(msg);
							// alert(val);
							$("#action").val('add'); 
							$("#addInfo").html(msg);  
							hiBox('#adddept','导入组织到QQ',450,'','','.a_close'); 
							$('#hiAlertform').bind("invalid-form.validate").validate(deptToQQ); 
							//$("#adddept").show();   
							
						},
						error:function(){
							hiAlert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
						}
					});
				
				 			
			});
			// update qq
			$("button[name='upDateqq']").click(function(){						// return false;
						  $.ajax({
							  type: "POST",
							  url: "{%site_url('bqq/bqq/dept_upqq_do')%}",
							  cache:false,
							  data: 'sd_id='+ $(this).val(),
							    beforeSend: function(){
								  hiClose();
								  jNotify("后台正在努力处理中，请稍后..",{
											  VerticalPosition : 'center',
											  HorizontalPosition : 'center'
										  });
								},							
							  success: function(msg){
								  if(msg == 0){	 
									  jSuccess("操作成功! ...",{
											  VerticalPosition : 'center',
											  HorizontalPosition : 'center',
											  TimeShown : 500,
										  });
										 
								  }else{
									   hiAlert(msg);
								  }
							  },
							  error:function(){
								  hiAlert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
							  }
						  });
						  return false;	 
				 			
			});
			// del deptname begin
			$("button[name='delQq']").click(function(){
				var tr = $(this).parents('tr');
				hiConfirm('你确定从QQ服务器删除这个组织结构吗？',null,function(r){
					if(r){
						$.ajax({
							type: "POST",
							url: "{%site_url('bqq/bqq/dept_delqq')%}",
							cache:false,
							data: 'sd_id='+tr.attr('id'),
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
								if(msg==0){
									$.jNotify._close();	 
									 tr.remove();
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
 			// cancel 
		  
		});
		 function postdnAjax(val){
            $.ajax({
                type: "POST",
                url: '{%site_url("bqq/bqq/dept_list")%}',
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
  
  <div  class="pad5">
    
    <div class="showDn"> <span class="ouzhuzhi">组织:{%implode(" &raquo; ", $ouTemp)%} </span>
      
      <br>
      <span class="ouDn">AD DN：{%implode(",", $ouDnPost)%}</span>
      
    </div>
     <div class="h10 clearb"> </div>
    <div id="massege" style="display:none; "> 添加成功正在刷新页面。。。。 </div>
    <div id="adddept" style="display:none; " >
    <input type="hidden" name="rootid" id="rootid" value="{%$rootid%}" />
    <input type="hidden" name="container" id="container" value="{%implode(",", $ouTemp)%}" />
     <input type="hidden" name="addn" id="addn" value="{%implode(",", $ouDnPost)%}" />
    	 
        <div id="addInfo">
         ....
        </div>
        <div class="h10 clearb"> </div>
        <div class="formLab">&nbsp;</div>
        <div class="formLabi">
         
          <input class="buttom" type="submit" name="submit" id="new_button" value="确定" />
          <input class="a_close buttom" type="button" name="canceladd" id="canceladd" value="取消" />
        </div>
 
    </div>
   
    <div id="ouShow" style=" " >
      <table  class="treeTable" id="treeTable">
        <thead>
          <tr>
            <th>组织名称</th>
            <th>说明</th>
            <th>同步状态</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
        
        {%if $ouData %}
        {%foreach from=$ouData item=row%}
        <tr id="{%$row->id%}">
          <td><div class="fleft IcoDept" > </div>
            &nbsp; <span>{%$row->deptName%}</span></td>
            <td>{%$row->detail%}</td>
          <td>
          {%if ($row->bqq_dept == 1)%}
         	<span class="fontRed " >已同步</span>
           {%else%}
           <span class="fontGreen ">未同步</span>
             {%/if%}
          </td>
          <td>
          
          {%if ($sysPermission["bqq_dept"] == 1)%}
             {%if ($row->id > 6)%}
                      {%if ($row->bqq_dept == 1)%}
                      
                        <button class="button" name="upDateqq" type="button" value="{%$row->id%}">更新到QQ</button>
                         <button class="buttonOt" name="delQq" type="button" value="{%$row->id%}">从QQ分离</button>
                      {%else%}
                      <button class="button" name="inToqq" type="button" value="{%$row->id%}">同步到QQ</button>
                        
                      {%/if%}
          
            {%/if%}  
            
          {%/if%}</td>
        </tr>
        {%/foreach%}
        {%else%}
        <tr>
          <td colspan=6 >暂无信息！</td>
        </tr>
        {%/if%}
          </tbody>
        
      </table>
    </div>
  </div>

