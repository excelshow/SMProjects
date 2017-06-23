{%include file="../header.tpl"%} 
<script type="text/javascript">
    // JavaScript Document
 $(document).ready(function(){
	  $('[fs]').inputDefault();
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
						url: '{%site_url("sms/sms_parts/sms_jieyong_edit")%}',
						cache:false,
						data: 'sj_id='+$(this).val(),
						success: function(msg){
							$("#showLayout").html(msg);  
							hiBox('#showLayout','修改配件信息',500,'','','.a_close'); 
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
				 
                sj_name: {required: true}
            },
            messages: {
              
				 sj_name: {required: "填写名称"}
            },
			submitHandler : function(){
					 //表单的处理
					 var post_data = $("#hiAlertform").serializeArray();
					 url = "{%site_url('sms/sms_parts/sms_jieyong_edit_com')%}";
					  
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
		$("button[name='jyadd']").click(function(){
				$.ajax({
						type: "POST",
						url: '{%site_url("sms/sms_parts/sms_jieyong_add")%}',
						cache:false,
						data: '',
						success: function(msg){
							$("#showLayout").html(msg);  
							hiBox('#showLayout','新加配件信息',500,'','','.a_close'); 
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
				sj_number:{required: true,remote:{
					 
								url: "{%site_url('sms/sms_parts/sms_jieyong_check')%}/",
								type: "post",
								async:false,
								dataType:"json", 
							//alert($("#useremail").html());
								data: {
									   number: function () {
                                 	   return $("#sj_number").val();
                               		 }
								} 
							}
					 }, 
                sj_name: {required: true}
            },
            messages: {
                sj_number:{required: "填写编号",remote:"此编号已经存在"},
				 sj_name: {required: "填写名称"}
            },
			submitHandler : function(){
					 //表单的处理
					 var post_data = $("#hiAlertform").serializeArray();
					 url = "{%site_url('sms/sms_parts/sms_jieyong_add_com')%}";
					  
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
 
<div id="showLayout" style="display:none;">
</div>
<div class=""  style=" ">
<div class="pad10">
  {%if ($sysPermission["sms_jieyong"] == 1)%}
     <div class="fright " style="background:#F7F7F7; padding:3px 20px 4px 20px;">
     <button class="buttom" name="jyadd" type="button" value="">新增借用资产</button>  
     </div>
     
      {%/if%}
  <div  class="pageTitleTop">借用管理 &raquo; 借用仓库 &raquo; </div>
  	<div class="h5"></div>
  	 <div  class="searchBox"  style=" " >
       <form id="searchForm" method="post" > <input name="k"  id="k" class="searchTopinput fleft" type="text" fs="输入搜索关键字" /> <input name="searchBut" type="submit" class="searchTopbuttom fleft" value=""  />
       </form>
      <div class="clearb"></div>
    </div>
 
  <div id="showLayout" style="display:none;"></div>
  <div class="h10"></div>
  <div id="staffshow">
   <div class="pageNav">{%$links%}</div>
  		<table  class="treeTable" id="treeTable">
      <thead>
        <tr>
          <th colspan="2">管理编号</th>
          <th>资产名称</th>
           <th>类别</th>
           
          <th>仓库</th>
             <th>地点</th>
          </tr>
      </thead>
      <tbody>
      
      {%if ($data)%}
      {%foreach from=$data item=row%}
      <tr id="{%$row->sj_id%}">
      
        <td colspan="2">{%$row->sj_number%}</td> 
         <td>
          
          {%$row->sj_name%} <div style=" float:right; background:#CCC;">
             <div  class="funShow" style=" display:none; position:absolute; margin-left:-40px;">          
               {%if ($sysPermission["sms_jieyong"] == 1)%}
               <button class="button" name="manager" type="button" value="{%$row->sj_id%}">编辑</button>
               {%/if%} 
               
              </div>
            </div>
            </td> 
        <td>
          
          {%$row->spc_name%} </td> 
        
       
         
         <td>{%$row->sj_ck%}</td>
         <td>{%$row->sj_local%}</td>
         </tr>
      {%/foreach%}
     
      {%else%}
      <tr>
        <td colspan="12">请输入查询条件</td>
      </tr>
      {%/if%}
        </tbody>
      
    </table>
  <div class="pageNav">{%$links%}</div>
  </div>
  </div>
</div>
 
{%include file="../foot.tpl"%}