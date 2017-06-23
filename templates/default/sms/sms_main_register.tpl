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
				  $(this).children("td").children(".funShow").css("display","block");
				   //$(this).children("td").children("div").css("display","block");
			},
			function () {
				$(this).removeClass("hover");
				 
				 $(this).children("td").children(".funShow").css("display","none");
			}
		);
 	
	 
	$("button[name=return]").click(function(){
		    $this = $(this).val();
            hiConfirm('确认要回收此资产？',null,function(r){ 
			  if(r){
				 
                    $.ajax({
							  type: "POST",
							  url: "{%site_url('sms/sms/staff_sms_register_return')%}",
							  data: "sms_number="+$this,
							  success: function(msg){
								  //alert(msg);
								  if(msg==1){
								   
									jSuccess("操作成功!正在刷新页面，请稍候...",{
										  VerticalPosition : 'center',
										  HorizontalPosition : 'center',
										  TimeShown : 1000,
									  });
									  window.location.reload();
								  }else{
									  alert(msg);
								  }
							  },
							   
						  });
                    return false;		
                }
			}); 
	});

	$("button[name=move]").click(function(){
		 window.location = "{%site_url('sms/sms/staff_sms_yufen_add')%}/"+$(this).val();
		 
			   
	});
	 
	
	 $("button[name='page']").bind("click",function(){
					var url = $(this).val();
					if(url!='undefined'){
						window.location=url;
						 
					}
				});

		
 $("input[name=searchBut]").click(function(){
		var t = $("#t").val();
		var k = $("#k").val()
		window.location = "{%site_url('sms/sms/sms_main_register/')%}/"+t+"/"+k;
	});

 });
    //]]>
   
</script>
 
<div id="showLayout" style="display:none;">
</div>
<div class=""  style=" ">
<div class="pad10">
 
   <div class="fright " style="background:#F7F7F7; padding:3px 20px 4px 20px;">
    {%if ($sysPermission["staff_sms_add"] == 1)%}
     <button class="buttom" name="smsadd" type="button" value="">新增用户资产</button>
     {%/if%}
     </div>
  <div  class="pageTitleTop">资产管理 &raquo; 入职分配历史 &raquo; </div>
  	<div class="h5"></div>
  	 <div  class="searchBox"  style=" " >
      <select name="t" id="t" class="searchTopinput fleft">
        <option value="1">用户帐号</option>
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
          <th>管理编号</th><th>财务编号 </th>
           <th>名称</th>
           <th>状态</th>
         
           <th>申请人</th>
            <th>使用状态</th>
         
         <th>使用部门</th>
          <th>所在地资产归属</th>
           <th>申请日期</th>
           <th>入职日期</th>
           <th>装机人</th>
          
        </tr>
      </thead>
      <tbody>
      
      {%if ($data)%}
      {%foreach from=$data item=row%}
      <tr id="{%$row->so_id%}"
       {%if ($row->timeOut > 5)%}
         style="color:#FF0000"
        {%/if%}
       
      >
        <td>{%$row->sms_number%} </td>
        <td>{%$row->sms_sapnumber%}</td> 
         <td width="150">
           {%if ($row->status==0)%}
           <div class="funShow"  style=" float:right;display:none;">
             <div style=" position:absolute;  margin-left:-80px;">
               {%if ($sysPermission["sms_return"] == 1)%}
               <button class="button" name="return" id="return" type="button" value="{%$row->sms_number%}">收回</button>
               {%/if%}
                
              </div>
            </div>
         {%/if%}
          
          {%$row->sc_name%}</td>
         <td>
         {%if ($row->status==1)%}
         	待发放
         {%else%}
         <span style="color:#060;">
          
         	装机中
             
              </span>
         {%/if%}
         
         </td> 
       
        <td>{%$row->cname%}/{%$row->itname%} </td> 
        <td  >
        	 OA 申请
            </td>
        
        <td title="{%$row->deptOu%}">{%$row->deptName|truncate:10:"..."%}</td>
        <td>{%$row->sl_name%}-{%$row->sa_name%}  </td>
         <td>
         
        	{%$row->reg_time%} 
         </td>
         <td>{%$row->injob_time%} </td>
         <td>{%$row->so_cname%} </td>
          
      </tr>
      {%/foreach%}
     
      {%else%}
      <tr>
        <td colspan="14">暂无信息！</td>
      </tr>
      {%/if%}
        </tbody>
      
    </table>
  <div class="pageNav">{%$links%}</div>
  </div>
  </div>
</div>
 
{%include file="../foot.tpl"%}