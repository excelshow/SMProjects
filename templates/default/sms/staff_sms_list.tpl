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
				  //alert();
				  $(this).children("td").children(".funShow").css("display","block");
				   //$(this).children("td").children("div").css("display","block");
			},
			function () {
				$(this).removeClass("hover");
				 
				 $(this).children("td").children(".funShow").css("display","none");
			}
		);
 	
	$("button[name=smsadd]").click(function(){
		window.location = "{%site_url('sms/sms/staff_sms_add')%}/"+$(this).val();
	});
	/*$("#searchForm").keypress(function(e){
		  if (e.which == 13) {
			    var t = 0;
				var k = $("#k").val() 
				window.location = "{%site_url('sms/sms/index/')%}/"+t+"/"+k;
				return false; 
			}
		});*/
	 
	$("button[name=edit]").click(function(){
		window.location = "{%site_url('sms/sms/sms_main_edit')%}/"+$(this).val();
	});
	$("button[name=return]").click(function(){
		    $this = $(this).val();
            hiConfirm('确认要回收此资产？',null,function(r){ 
			  if(r){
				 
                    $.ajax({
							  type: "POST",
							  url: "{%site_url('sms/sms/staff_sms_return')%}",
							  data: "sm_id="+$this,
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

	$("button[name=move]").click(function(){
		 window.location = "{%site_url('sms/sms/staff_sms_move')%}/"+$(this).val(); 	   
	});
	 
	$("button[name=smschuku]").click(function(){
		 window.location = "{%site_url('sms/sms/staff_sms_chuku')%}/"; 	   
	});
	 $("button[name='page']").bind("click",function(){
					var url = $(this).val();
					if(url!='undefined'){
						window.location=url;
						 
					}
				});

		
$("button[name='remark']").click(function(){
				 var val = $(this).val();
				  {%if ($sysPermission["sms_return"] == 1)%}
              			var t = 1;
				 {%else%} 
				 		var t = 2;		
                  {%/if%}
					$.ajax({
						type: "POST",
						url: "{%site_url('sms/sms/staff_sms_remark')%}",
						cache:false,
						data: "sm_id="+val+"&t="+t,
						success: function(msg){
					   
							$("#showLayout").html(msg);  
							hiBox('#showLayout','备注信息',550,'','','.a_close');
							$('#hiAlertform').bind("invalid-form.validate").validate(sRemark); 
							 
							
						},
						error:function(){
							hiAlert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
						}
					});		
					 	 
					 
			});
		var  sRemark = { 
            submitHandler:function(){
               var post_data = $("#hiAlertform").serializeArray();
              
			  // return false;
                $.ajax({
                    type: "POST",
                    url: "{%site_url('sms/sms/staff_sms_remark_do')%}",
                    cache:false,
                    data: post_data,
                    success: function(msg){ 
					 hiClose();
						if(msg == 1){	 
							jSuccess("操作成功!...",{
									VerticalPosition : 'center',
									HorizontalPosition : 'center',
									TimeShown : 500
								});
                               // setInterval(function(){window.location.reload();},1000);	
                             
						};
					  
  
                    },
                    error:function(){
                        hiAlert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
                    }
                });
			 
				return false;
                
            }
		};

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
      
     <button class="buttom" name="smschuku" type="button" value="">资产出库</button>
   <!-- {%if ($sysPermission["staff_sms_chuku"] == 1)%} {%/if%}-->
     </div>
  <div  class="pageTitleTop">资产管理 &raquo; 用户资产 &raquo; </div>
  	<div class="h5"></div>
  	 <div  class="searchBox"  style=" " >
    <form id="searchForm" method="post" > 
       <span class="fleft">&nbsp;</span><input name="k" type="text" class="searchTopinput fleft"  id="k" size="40" fs="请输入资产编号或用户账号关键字" /> 
       <input type="submit" name="searchBut" id="searchBut"  class="searchTopbuttom fleft"  value=" " />
        
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
          <th>管理编号</th><th>财务编号 </th>
           <th>名称</th>
           <th>品牌</th>
           <th>使用人</th>
            <th>使用状态</th>
          <th>IP</th>
         <th>使用部门</th>
          <th>所在地资产归属</th>
           <th>出库日期</th>
           <th>装机人</th>
           <th>领取人</th>
          <th>出库人</th>
          {%if $t==2%}
           <th>借用周期</th>
           {%/if%}
        </tr>
      </thead>
      <tbody>
      
      {%if ($data)%}
      {%foreach from=$data item=row%}
      <tr id="{%$row->sm_id%}"
       {%if $t==2 && $row->timeOut >90 %}
            style="color:#900"
        {%/if%}
      >
        <td>{%$row->sms_number%} </td>
        <td>{%$row->sms_sapnumber%}</td> 
         <td>
         
           <div class="funShow"  style=" float:right;display:none;">
             <div style=" position:absolute;  margin-left:-80px;">
               {%if ($sysPermission["sms_edit"] == 1)%}
              <button class="button" name="edit" type="button" value="{%$row->sms_id%}">编辑</button>
              {%/if%} 
               {%if ($sysPermission["sms_move"] == 1)%}
               <button class="button" name="move" type="button" value="{%$row->sm_id%}">转移</button>
               {%/if%}
               {%if ($sysPermission["sms_return"] == 1)%}
               <button class="button" name="return" id="return" type="button" value="{%$row->sm_id%}">收回</button>
               {%/if%}
                <button class="button" name="remark" type="button" value="{%$row->sm_id%}">备注</button>
              </div>
            </div>
          {%$row->sc_name%}</td> 
         <td>{%$row->sms_brand%}</td> 
        <td><span title="{%$row->itname%}">{%$row->cname%}</span></td> 
        <td  >
        	{%if $row->sm_type == 1%}
            	领用
            {%/if%}
            {%if $row->sm_type == 2%}
            	借用
            {%/if%}
			{%if $row->sm_type == 3%}
            	长期借用
            {%/if%}
{%if $row->sm_type == 4%}
            	转移
            {%/if%}
            </td>
        <td  >
       
          {%if ($sysPermission["sms_ip_dept"] == 1)%} 
         <div class="ipFun">
         {%else%}
          <div >
         {%/if%}  
        {%if $row->sms_ip%}
        {%$row->sms_ip%}
          <!-- img src="{%$base_url%}templates/{%$web_template%}/images/ip.png" title="{%$row->sms_ip%}" / -->
        {%else%}
          --
          <!-- img src="{%$base_url%}templates/{%$web_template%}/images/ipw.png" title="" / -->
         {%/if%}  
        </div>
        </td>
        <td title="{%$row->deptOu%}">{%$row->deptName|truncate:10:"..."%}</td>
        <td>{%$row->sl_name%}-{%$row->sa_name%}  </td>
         <td>
         <span title="{%$row->use_time%}">{%$row->use_time|date_format:'%Y-%m-%d'%}</span>
         </td>
         <td>{%$row->so_itname%}</td>
         <td>{%$row->lingqu_itname%}</td>
          <td>{%$row->op_user%} </td>
           {%if $t==2%}
           <td>{%$row->timeOut%}</td>
           {%/if%}
      </tr>
      {%/foreach%}
     
      {%else%}
      <tr>
        <td colspan="10">请输入查询条件</td>
      </tr>
      {%/if%}
        </tbody>
      
    </table>
  <div class="pageNav">{%$links%}</div>
  </div>
  </div>
</div>
 
{%include file="../foot.tpl"%}