{%include file="../header.tpl"%} 
<script type="text/javascript">
    // JavaScript Document
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
				  var tds = $(this).find('td');
				   
				  $(this).children("td").children("div").children(".funShow").css("display","block");
				   //$(this).children("td").children("div").css("display","block");
			},
			function () {
				$(this).removeClass("hover");
				 
				 $(this).children("td").children("div").children(".funShow").css("display","none");
			}
		);
 	 
	 
	 
	//// 编辑 part
		$("button[name='manager']").click(function(){
				$.ajax({
						type: "POST",
						url: '{%site_url("staff/staff/emailconfig_edit")%}',
						cache:false,
						data: 'id='+$(this).val(),
						success: function(msg){
							$("#showLayout").html(msg);  
							hiBox('#showLayout','修改邮件配置信息',500,'','','.a_close'); 
							$('#hiAlertform').bind("invalid-form.validate").validate(formvam); 
							//$("#adddept").show();   
							
						},
						error:function(){
							hiAlert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
						}
					});
				
				 			
			});
	///
 var formvam = {
            rules: {
                sendto: {required: true},
            },
            messages: {
            	sendto: {required: "填写收件人"},
            },
			submitHandler : function(){
					 //表单的处理
					 var post_data = $("#hiAlertform").serializeArray();
					 url = "{%site_url('staff/staff/emailconfig_edit_do')%}";
					  
					 $.ajax({
						   type: "POST",
							  url: url,
							  async:false,
							  data:post_data,
							  success: function(msg){
								  hiClose();
								  if (msg == "ok" ){
									   jSuccess("Success, current page is being refreshed",{
										  VerticalPosition : 'center',
										  HorizontalPosition : 'center',
										  TimeShown : 1000,
									  });
									  window.location.reload();	
								  }else{
									  jError("操作失败! ",{
										  VerticalPosition : 'center',
										  HorizontalPosition : 'center',
										  TimeShown : 1000,
									  });
								 }
							  }
						  });
					 return false;//阻止表单提交
				}
        };
		
		/////////////////////
	 //// 新加 part
		$("button[name='partadd']").click(function(){
				$.ajax({
						type: "POST",
						url: '{%site_url("staff/staff/emailconfig_add")%}',
						cache:false,
						data: '',
						success: function(msg){
							$("#showLayout").html(msg);  
							hiBox('#showLayout','新加邮件配置信息',500,'','','.a_close'); 
							$('#hiAlertform').bind("invalid-form.validate").validate(formva); 
							//$("#adddept").show();   
							
						},
						error:function(){
							hiAlert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
						}
					});
				
				 			
			});
	///
 var formva = {
            rules: {
                type: {required: true},
                sendto: {required: true}
            },
            messages: {
                type:{required: "填写邮件类型",remote:"此编号已经存在"},
				sendto: {required: "填写收件人"},
            },
			submitHandler : function(){
					 //表单的处理
					 var post_data = $("#hiAlertform").serializeArray();
					 url = "{%site_url('staff/staff/emailconfig_add_do')%}";
					  
					 $.ajax({
						   type: "POST",
							  url: url,
							  async:false,
							  data:post_data,
							  success: function(msg){
								  hiClose();
								  if (msg == "ok" ){
									   jSuccess("Success, current page is being refreshed",{
										  VerticalPosition : 'center',
										  HorizontalPosition : 'center',
										  TimeShown : 1000,
									  });
									  window.location.reload();	
								  }else{
									  jError("操作失败! ",{
										  VerticalPosition : 'center',
										  HorizontalPosition : 'center',
										  TimeShown : 1000,
									  });
								 }
							  }
						  });
					 return false;//阻止表单提交
				}
        };
		
		/////////////////////
	 $("button[name='page']").bind("click",function(){
					var url = $(this).val();
					if(url!='undefined'){
						window.location=url;
						 
					}
				});

	 

 });
    //]]>
   
</script>
<style>
 table{table-layout: fixed;}
 tr{width:100%;}
 td {text-overflow: ellipsis; white-space: nowrap; overflow: hidden; }
</style>
<div id="showLayout" style="display:none;">
</div>
<div class=""  style=" ">
<div class="pad10">
     <div class="fright " style="background:#F7F7F7; padding:3px 20px 4px 20px;">
     <button class="buttom" name="partadd" type="button" value="">新增邮件配置</button>  
     </div>
  <div  class="pageTitleTop">用户管理 &raquo; 邮箱配置 &raquo; </div>
  	<div class="h5"></div>
<!--   	 <div  class="searchBox"  style=" " > -->
<!--       <select name="t" id="t" class="searchTopinput fleft">  -->
<!--         <option value="2">邮件类型</option> -->
<!--       </select><span class="fleft">&nbsp;</span><input name="k"  id="k" class="searchTopinput fleft" type="text" /> <input name="searchBut" type="button" class="searchTopbuttom fleft" value=""  /> -->
<!--       <div class="clearb"></div> -->
<!--     </div> -->
 
  <div id="showLayout" style="display:none;"></div>
  <div class="h10"></div>
  <div id="staffshow">
  		<table  class="treeTable" id="treeTable">
      <thead>
        <tr>
          <th>邮件类型</th>
          <th>收件人</th>
           <th>抄送</th>
          <th>密送</th>
          <th>来自</th>
          </tr>
      </thead>
      <tbody>
      
      {%if ($data)%}
      {%foreach from=$data item=row%}
      <tr id="{%$row->id%}">
      
        <td>{%$row->type%}</td> 
         <td>
          
          {%$row->sendto%}</td> 
        <td>
          
          {%$row->cc%} </td> 
        
       
         <td>{%$row->bcc%}
         <td>{%$row->from%}
           <div style=" float:right; background:#CCC;">
             <div  class="funShow" style=" display:none; position:absolute; margin-left:-50px;">          
               <button class="button" name="manager" type="button" value="{%$row->id%}">编辑</button>
              </div>
            </div>
         </td>
         </tr>
      {%/foreach%}
     
      {%else%}
      <tr>
        <td colspan="12">请输入查询条件</td>
      </tr>
      {%/if%}
        </tbody>
      
    </table>
  </div>
  </div>
</div>
 
{%include file="../foot.tpl"%}