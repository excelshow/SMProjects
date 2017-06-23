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
							  url: "{%site_url('sms/sms/sms_main_yufen_return')%}",
							  data: "so_id="+$this,
							  success: function(msg){
								  //alert(msg);
								  if(msg==1){
								   
									jSuccess("操作成功!正在刷新页面，请稍候...",{
										  VerticalPosition : 'center',
										  HorizontalPosition : 'center',
										  TimeShown : 1000,
									  });
									 location.reload();
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
		var t = 0;
		var k = $("#k").val()
		window.location = "{%site_url('sms/sms/sms_main_yufen/')%}/0/"+k;
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
  <div  class="pageTitleTop">资产管理 &raquo; 领用分配 &raquo; </div>
  	<div class="h5"></div>
  	 <div  class="searchBox"  style=" " >
       <span class="fleft">&nbsp;</span><input name="k"  id="k" class="searchTopinput fleft" fs="sdfsdf" type="text" /> <input name="searchBut" type="button" class="searchTopbuttom fleft" value=""  />
      <div class="clearb"></div>
    </div>
 
  <div id="showLayout" style="display:none;"></div>
  <div class="h10"></div>
  <div id="staffshow">
   <div class="pageNav">{%$links%}</div>
  	 <table  class="treeTable" id="treeTable">
      <thead>
        <tr>
          <th>OA编号</th><th>申请人 </th>
           <th>类别</th>
           <th>主机</th>
         
           <th>显示器</th>
            <th>一体机</th>
         
         <th>笔记本</th> 
           <th>申请日期</th>
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
        <td>{%$row->oa_number%} </td>
        <td title="{%$row->deptOu%}">
        {%$row->cname%}/{%$row->itname%}
           
        </td> 
         <td width="150">
           {%if ($row->reg_type==1)%}
          领用
           {%else%}
          长期借用
         {%/if%}
          <div class="funShow"  style=" float:right;display:none;">
             <div style=" position:absolute;  margin-left:-80px;">
               {%if ($sysPermission["sms_return"] == 1)%}
               <button class="button" name="return" id="return" type="button" value="{%$row->so_id%}">收回</button>
               {%/if%}
                
              </div>
            </div>
           </td>
         <td>
         {%$row->sms_number_4%} {%$row->sms_ip%}
         
         </td> 
       
        <td>{%$row->sms_number_8%}</td> 
        <td  >
        	{%$row->sms_number_11%}
            </td>
        
       
        <td>{%$row->sms_number_19%}  </td>
         <td>
         
        	{%$row->reg_time%} 
         </td>
         <td>{%$row->so_itname%} </td>
          
      </tr>
      {%/foreach%}
     
      {%else%}
      <tr>
        <td colspan="13">暂无信息！</td>
      </tr>
      {%/if%}
        </tbody>
      
    </table>
  <div class="pageNav">{%$links%}</div>
  </div>
  </div>
</div>
 
{%include file="../foot.tpl"%}