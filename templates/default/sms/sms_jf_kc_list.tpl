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
				  //alert();
				  $(this).children("td").children("div").children(".funShow").css("display","block");
				   //$(this).children("td").children("div").css("display","block");
			},
			function () {
				$(this).removeClass("hover");
				 
				 $(this).children("td").children("div").children(".funShow").css("display","none");
			}
		);
 	
	$("button[name=smsadd]").click(function(){
		window.location = "{%site_url('sms/sms_jf/sms_jf_main_add')%}/"+$(this).val();
	});
	$("input[name=searchBut]").click(function(){
		var t = $("#t").val();
		var k = $("#k").val()
		window.location = "{%site_url('sms/sms_jf/kc_list/')%}/"+t+"/"+k;
	});
	$("button[name=edit]").click(function(){ 
		 window.location = "{%site_url('sms/sms_jf/sms_jf_edit')%}/"+$(this).val();
	}); 
	//////////////////chuku
		$("button[name=out]").click(function(){
		    $this = $(this).val();
                    $.ajax({
							  type: "POST",
							  url: "{%site_url('sms/sms_jf/sms_jf_out')%}",
							  data: "sms_id="+$this,
							  success: function(msg){
								  //alert(msg);
									 if(msg=="0"){
										// $("tr#"+n).remove();
										jError("操作失败! 请联系管理员...",{
											VerticalPosition : 'center',
											HorizontalPosition : 'center',
											TimeShown : 2000,
										});
									  
									}else{
										 $("#showLayout").html(msg);
										  hiBox('#showLayout','机房资产出库',400,'','','.a_close');
										  $('#hiAlertform').bind("invalid-form.validate").validate(jfjs);
									}
							  },
							   
						  });
                 
		});
		///////////////////// 报废机房资产
		$("button[name=scrap]").click(function(){
		    $this = $(this).val();
            hiConfirm('确认要报废此资产？',null,function(r){ 
			  if(r){
				 
                    $.ajax({
							  type: "POST",
							  url: "{%site_url('sms/sms_jf/sms_jf_main_scrap')%}",
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
	
	///////////////////////////////////////////////////
	 $("button[name='page']").bind("click",function(){
					var url = $(this).val();
					if(url!='undefined'){
						window.location=url;
						 
					}
				});

 

 });
//////////////////////////////////
 var jfjs = {
            rules: {
				sms_local:{required: true}, 
				sms_local_number:{required: true}
            },
            messages: {
                sms_local:{required: "使用机房必填！"},
				sms_local_number:{required:"机房编号必填！"}
            },
			submitHandler : function(){
						   //表单的处理
						   var post_data = $("#hiAlertform").serializeArray();
						   url = "{%site_url('sms/sms_jf/sms_jf_out_do')%}";
						   hiClose();
						   $.ajax({
								 type: "POST",
									url: url,
									async:false,
									data:post_data,
									success: function(msg){
										if (msg == 1){
											 jSuccess("操作成功"+msg+"! 正在刷新页面...",{
												VerticalPosition : 'center',
												HorizontalPosition : 'center',
												TimeShown : 1000
											});
											  setInterval(function(){window.location.reload();},1000);	
										}else{
											jError("操作失败! ",{
												VerticalPosition : 'center',
												HorizontalPosition : 'center',
												TimeShown : 1000
											});
									   }
									},
									error:function(){
										jError("操作失败! ",{
												VerticalPosition : 'center',
												HorizontalPosition : 'center',
												TimeShown : 1000
											});
									}
								});
						   return false;//阻止表单提交
				}
        };
   
</script>
 
<div id="showLayout" style="display:none;">
</div>
<div class=""  style=" ">
<div class="pad10">
  {%if ($sysPermission["sms_jf_add"] == 1)%}
     <div class="fright " style="background:#F7F7F7; padding:3px 20px 4px 20px;">
    
     <button class="buttom" name="smsadd" type="button" value="">新增机房资产</button>
     
     </div>
     
      {%/if%}
  <div  class="pageTitleTop">仓库资产 &raquo; 库存列表 &raquo; </div>
  	<div class="h5"></div>
  	 <div  class="searchBox"  style=" " >
      <select name="t" id="t" class="searchTopinput fleft"> 
        <option value="2">资产编号</option>
      </select><span class="fleft">&nbsp;</span><input name="k"  id="k" class="searchTopinput fleft" type="text" /> <input name="searchBut" type="button" class="searchTopbuttom fleft" value=""  />
      <div class="clearb"></div>
    </div>
 
  <div id="showLayout" style="display:none;"></div>
  <div class="h10"></div>
  <div id="staffshow">
   <div class="pageNav">{%$links%}</div>
  		<table  class="treeTable" id="treeTable">
      <thead>
        <tr>
          <th>管理编号</th>
          <th>财务编号</th>
          <th>资产名称</th>
           <th>资产类别</th>
           <th>资产品牌</th>
           <th>维保时间</th>
          
          
          <!-- <th >使用人</th>
          <th>部门</th>-->
          <th>所在地</th>
         
          <th>入库人</th>
          <th>入库日期</th>
             
        </tr>
      </thead>
      <tbody>
      
      {%if ($data)%}
      {%foreach from=$data item=row%}
      <tr id="{%$row->sms_id%}">
      
        <td>{%$row->sms_number%}</td> 
         <td>{%$row->sms_sapnumber%}</td>
         <td>
           <div style=" float:right; background:#CCC;">
         <div  class="funShow" style=" display:none; position:absolute; margin-left:-40px;">      
             
              {%if ($sysPermission["sms_jf_out"] == 1)%}
               <button class="button" name="out" type="button" value="{%$row->sms_id%}">出库</button>
              {%/if%} 
             
               {%if ($sysPermission["sms_jf_edit"] == 1)%}
              <button class="button" name="edit" type="button" value="{%$row->sms_id%}">编辑</button>
              {%/if%} 
               {%if ($sysPermission["sms_jf_baofei"] == 1)%}
              <button class="button" name="scrap" id="scrap" type="button" value="{%$row->sms_id%}">报废</button>
              {%/if%} 
              </div>
            </div>
         {%$row->sms_name%}</td> 
        <td>
          
         
          {%$row->sc_name%}
          
          
        </td> 
        <td>{%$row->sms_brand%} </td>
        <td>
           {%$row->sms_size%} 
        </td>
       
      <!--   
        <td>
          {%if ($row->staff)%}
          {%$row->staff->cname%} 
          {%/if%}
        </td>
        <td>
         {%if ($row->staff)%}
         {%$row->staff->itname%} 
         {%/if%}
        </td>
         <td>
         {%if ($row->staff)%}
         {%$row->staff->deptName%} 
         {%/if%}
        </td>-->
         <td>
         {%$row->sms_local%} {%$row->sms_local_number%} 
        </td>
       
         <td>{%$row->input_itname%}</td>
         <td>{%$row->input_time%}</td>
         
      </tr>
      {%/foreach%}
     
      {%else%}
      <tr>
        <td colspan="15">请输入查询条件</td>
      </tr>
      {%/if%}
        </tbody>
      
    </table>
  <div class="pageNav">{%$links%}</div>
  </div>
  </div>
</div>
 
{%include file="../foot.tpl"%}