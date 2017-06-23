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
 	 
	$("input[name=searchBut]").click(function(){
		var t = $("#t").val();
		var k = $("#k").val()
		window.location = "{%site_url('sms/sms_jf/index/')%}/"+t+"/"+k;
	});
	 
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
  
  <div  class="pageTitleTop">仓库资产 &raquo; 在用列表 &raquo; </div>
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
           <th>资产规格</th>
          
          
          <!-- <th >使用人</th>
          <th>部门</th>-->
          <th>所在地</th>
         
          <th>入库日期</th>
          <th>入库人</th>
             <th>出库日期</th>
          <th>出库人</th>
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
              {%if ($sysPermission["sms_jf_return"] == 1)%}
              <button class="button" name="return" type="button" value="{%$row->sms_id%}">回收</button>
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
         {%$row->sms_local%} 
        </td>
       
         <td>{%$row->input_itname%}</td>
         <td>{%$row->input_time%}</td>
         <td>{%$row->out_itname%}</td>
         <td>{%$row->out_time%}</td>
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