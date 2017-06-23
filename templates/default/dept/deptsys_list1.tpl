<script type="text/javascript">
 	//<![CDATA[
	jQuery.validator.addMethod("checkname",  //addMethod第1个参数:方法名称
        function(value, element, params) {     //addMethod第2个参数:验证方法，参数（被验证元素的值，被验证元素，参数）
             
			//var exp = new RegExp(params);     //实例化正则对象，参数为传入的正则表达式
            //return exp.test(value); 
			//alert(exp.test(value));
			 deptId = $("#add_dept_sys input[name='id']").val();
			  $.ajax({
                    type: "POST",
                    url: "{%site_url('deptsys/check_dept_name')%}",
					async:false,
                    data: "deptname="+value+"&id="+deptId,
                    success: function(msg){
  							// alert(msg);
							//Alert(msg);
						if (value.toUpperCase() == msg.toUpperCase()){   // toUpperCase  大小写转换
							temp_type=false; 
							  
							}else{
							temp_type=true; 	 
						}
                    }
                });
				return temp_type; 
			   
			                   //测试是否匹配
        },
        "组织名不能重复！");    //addMethod第3个参数:默认错误信息

	
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
		var adddept = {
            rules: {
                ou_name: {required: true,minlength: 2,checkname:''}//
            },
            messages: {
                ou_name: {required: " 请输入组织结构名称",minlength: "至少2个字符",checkname:"组织名不能重复！"}//"
            },
            submitHandler:function(){
               var post_data = $("#add_dept_sys").serializeArray();
               var subType = $("#action").val();
			   
                $.ajax({
                    type: "POST",
                    url: "{%site_url('deptsys/dept_name_save')%}",
                    cache:false,
                    data: post_data,
                    success: function(msg){
                        
                            $("#adddept").html("操作完成！正在刷新页面....");
							jSuccess("操作成功! 正在刷新页面...",{
									VerticalPosition : 'center',
									HorizontalPosition : 'center',
									TimeShown : 500,
								});
                               // setInterval(function(){window.location.reload();},1000);	
                            postdnAjax($("#rootid").val());
 
                     /* if(msg == 3){
							}else{
                            hiAlert(msg);
                        }*/
                    },
                    error:function(){
                        hiAlert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
                    }
                });
				//deptname = $("#ou_name").val();
				//checkDeptname(deptname);  // check dept name
				//alert(checkdeptname);
				return false;
                
            }
        };

			$('#add_dept_sys').validate(adddept);
			// function product end
			
			// edit deptname begin
			$("button[name='edit']").click(function(){
				$.ajax({
						type: "POST",
						url: '{%site_url("deptsys/deptsys_edit")%}',
						cache:false,
						data: 'id='+ $(this).val(),
						success: function(msg){
					   //  $("#ouShow").html(msg);
							// alert(val);
							$("#action").val('add'); 
							$("#addInfo").html(msg);  
							//hiBox('#adddept','编辑组织','','','','.a_close');  
							 $("#adddept").show();   
							
						},
						error:function(){
							hiAlert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
						}
					});
				
				 			
			});
			
			// del deptname begin
			$("button[name='del']").click(function(){
				var tr = $(this).parents('tr');
				hiConfirm('你确定要删除这条记录吗?<br>系统也将删除此组织结构下属的组织机构和用户!!!',null,function(r){
					if(r){
						$.ajax({
							type: "POST",
							url: "{%site_url('deptsys/dept_name_del')%}",
							cache:false,
							data: 'id='+tr.attr('id')+'&addn='+ $('#addn').val(),
							success: function(msg){ 
								if(msg==3){
									 tr.remove();
									 // $("#adddept").html("操作成功！正在刷新页面....");
									  jSuccess("操作成功! 正在刷新页面...",{
									VerticalPosition : 'center',
									HorizontalPosition : 'center',
									TimeShown : 2000,
									});
									  postdnAjax($("#rootid").val());
									 
								};
								if(msg==2){
									hiAlert("删除数据库错误,请确认删除信息!");
								}
								if(msg==1){
									hiAlert("删除AD域错误,请确认删除信息!");
								}
								if(msg==0){
									hiAlert("此组织结构有下属组织,请先删除下属组织结构!");
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
			$("#canceladd").click(function(){
				
				$("#add_dept_sys input[name='ou_name']").val("");
				$("#add_dept_sys input[name='detail']").val("");
				$("#add_dept_sys input[name='id']").val("");
				 $("#add_dept_sys input[name='action']").val("");
				$("#adddept").hide();
			});
			$("#addDeptLink").click(function(){
				 $.ajax({
                type: "POST",
                url: '{%site_url("deptsys/deptsys_add")%}',
                cache:false,
                data: 'id='+ $(this).val(),
                success: function(msg){
               //  $("#ouShow").html(msg);
                    // alert(val);
					$("#action").val('add'); 
					$("#addInfo").html(msg);    
					$("#adddept").show();   
					
                },
                error:function(){
                    hiAlert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
                }
            });
				
			});
			
		});
		 function postdnAjax(val){
            $.ajax({
                type: "POST",
                url: '{%site_url("deptsys/deptsys_list")%}',
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
    <div class="fright pad5"  ><span id="addDeptLink" class="addDept">新增组织</span> </div>
    <div class="showDn"> <span class="ouzhuzhi">组织:{%implode(" &raquo; ", $ouTemp)%} </span>
      
      <br>
      <span class="ouDn">AD DN：{%implode(",", $ouDnPost)%}</span>
       
    </div>
     <div class="h10 clearb"> </div>
   
    <div id="adddept" style="display:none; " >
    	<input type="hidden" name="rootid" id="rootid" value="{%$rootid%}" />
    	<input type="hidden" name="container" id="container" value="{%implode(",", $ouTemp)%}" />
    	<input type="hidden" name="addn" id="addn" value="{%implode(",", $ouDnPost)%}" />
    	<fieldset><legend><strong>新增组织结构</strong></legend>
        <div id="addInfo">
         ....
        </div>
        <div class="h10 clearb"> </div>
        <div class="formLab">&nbsp;</div>
        <div class="formLabi">
         
          <input class="buttom" type="submit" name="submit" id="new_button" value="确定" />
          <input class="buttom" type="button" name="canceladd" id="canceladd" value="取消" />
        </div>
         
     </fieldset>
     
    </div>
    
    <div id="ouShow" style=" " >
      <table  class="treeTable" id="treeTable">
        <thead>
          <tr>
            <th>名称</th>
            <th>说明</th>
            <th>类型</th>
            <th>用户</th>
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
          <td>{%$row->dt_name%}</td>
          <td>&nbsp;</td>
          <td><button class="edit" name="edit" type="button"
			value="{%$row->id%}"></button>
            <button class="delete" name="del" type="button"
			value="{%$row->id%}"></button></td>
        </tr>
        {%/foreach%}
        {%else%}
        <tr>
          <td colspan=7 >暂无信息！</td>
        </tr>
        {%/if%}
          </tbody>
        
      </table>
    </div>
  </div>

