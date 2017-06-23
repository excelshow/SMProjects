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
 	 
	 
	$("button[name=return]").click(function(){
		    $this = $(this).val();
            hiConfirm('确认要回收此机房资产？',null,function(r){ 
			  if(r){
				 
                    $.ajax({
							  type: "POST",
							  url: "{%site_url('sms/sms_jf/sms_jf_return')%}",
							  data: "sms_id="+$this,
							  success: function(msg){
								  //alert(msg);
								  if(msg==1){
								   
									jSuccess("操作成功!正在刷新页面，请稍候...",{
										  VerticalPosition : 'center',
										  HorizontalPosition : 'center',
										  TimeShown : 1000,
									  });
									 setInterval(function(){window.location.reload();},1000);	
								  }else{
									  alert(msg);
								  }
							  },
							   
						  });
                    return false;		
                }
			}); 
	});
//// 编辑 part
		$("button[name='manager']").click(function(){
				$.ajax({
						type: "POST",
						url: '{%site_url("sms/sms_parts/staff_sms_jieyong_edit")%}',
						cache:false,
						data: 'ss_id='+$(this).val(),
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
				 
                type: {required: true},
				number:{required: true,digits:true} 
            },
            messages: {
              
				 type: {required: "类型"},
				number:{required: "填写数量",digits:"整数"} 
            },
			submitHandler : function(){
					 //表单的处理
					 var post_data = $("#hiAlertform").serializeArray();
					 url = "{%site_url('sms/sms_parts/staff_sms_jieyong_edit_com')%}";
					  
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
									 alert(msg)
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
     <!--<div class="fright " style="background:#F7F7F7; padding:3px 20px 4px 20px;">
     <button class="buttom" name="partadd" type="button" value="">新增流水</button>  
     </div>-->
     
      {%/if%}
  <div  class="pageTitleTop">借用资产 &raquo; 借用流水 &raquo; </div>
  	<div class="h5"></div>
  	 <div  class="searchBox"  style=" " >
       <form id="searchForm" method="post" >
       <input name="k" type="text" class="searchTopinput fleft"  id="k" size="40" fs="输入管理编号或领用人itname" />
       <input name="searchBut" type="button" class="searchTopbuttom fleft" value=""  />
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
          <th colspan="2">OA编号</th>
          <th>资产编号</th>
          <th>资产名称</th>
           <th>借用人</th>
           <!-- <th >使用人</th>
          <th>部门</th>-->
          <th>借用部门</th>
         
         
          <th>领用日期</th>
             <th>操作人</th>
              <th>借用周期</th>
          </tr>
      </thead>
      <tbody>
      
      {%if ($data)%}
      {%foreach from=$data item=row%}
      <tr id="{%$row->ssj_id%}"
      {%if $row->timeOut >90 %}
            style="color:#900"
        {%/if%}
      >
      
        <td colspan="2">{%$row->oa_number%}</td>
        <td> {%$row->sj_number%}</td> 
         <td>
          
          {%$row->jieyong%}
           <div style=" float:right; background:#CCC;display:none;">
             <div  class="funShow" style=" display:none; position:absolute; margin-left:-40px;">          
               {%if ($sysPermission["sms_jieyong"] == 1)%}
               <button class="button" name="manager" type="button" value="{%$row->ssj_id%}">编辑流水</button>
               {%/if%} 
               
              </div>
            </div>
          </td> 
        <td>
          
          {%$row->cname%}
          {%$row->itname%}</td> 
         
         <td>
         <div title="{%$row->deptOu%}">{%$row->deptName%}</div>
        </td>
       
         <td>{%$row->use_time%}</td>
         <td>{%$row->op_user%}</td>
         
         <td title="" >
         {%$row->timeOut%}
         
          
         </td>
         </tr>
      {%/foreach%}
     
      {%else%}
      <tr>
        <td colspan="13">请输入查询条件</td>
      </tr>
      {%/if%}
        </tbody>
      
    </table>
  <div class="pageNav">{%$links%}</div>
  </div>
  </div>
</div>
 
{%include file="../foot.tpl"%}