 
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
			},
			function () {
				$(this).removeClass("hover"); 
			}
		);
 	
	 $("button[name='page']").bind("click",function(){
					var url = $(this).val();
					if(url!='undefined'){
						$.post(url,function(data){
							$('#staffshow').html(data)
						});
					}
				});
	  $("input[name='searchBut']").bind("click",function(){
					var url = $(this).val();
					  $.ajax({
						type: "POST",
						url: "{%site_url('sms/sms/reports_list')%}/"+val,
						cache:false,
						
						data: 'key='+key,
						success: function(msg){
							$("#staffshow").html(msg);
							 
							 
							// alert(val);          
						},
						error:function(){
							jError("出错啦，刷新试试，如果一直出现，可以联系开发人员解决",{
								VerticalPosition : 'center',
								HorizontalPosition : 'center',});
							 
						}
					});
				});

 });
    //]]>
   
</script>
 
  <div class="pageNav">
  {%$links%}
  </div>
  <div id="staffshow"  style="min-width:500px; max-width:100%; " >
  	<table  class="treeTable" id="treeTable">
      <thead>
        <tr>
          <th>管理编号</th><th>财务编号 </th>
           <th>资产名称</th>
           <th>资产类别</th>
           <th>资产品牌</th>
           <th>资产规格</th>
            <th>状态</th>
          <th>使用人</th>
         <th>使用部门</th>
          <th>所在地</th>
           <th>资产归属</th>
          <th>领用日期</th>
          <th>财务审核</th>
        </tr>
      </thead>
      <tbody>
      
      {%if ($data)%}
      {%foreach from=$data item=row%}
      <tr id="{%$row->sm_id%}">
        <td>{%$row->sms_number%} </td>
        <td>{%$row->sms_sapnumber%}</td> 
         <td>
          <div  style=" float:right;display:none;">
        	 <div style=" position:absolute;  margin-left:-80px;">
          		 <button class="button" name="move" type="button" value="{%$row->sm_id%}">转移</button>
          		 <button class="button" name="return" id="return" type="button" value="{%$row->sm_id%}">收回</button>
         	</div>
         </div>
         {%$row->sc_name%}</td> 
         <td>
        
         {%$row->category_name%} </td> 
         <td>{%$row->sms_brand%}</td> 
        <td>
         
         {%$row->sms_size%} 
        </td> 
        <td> {%if $row->sm_type == 1 %}
           领用
           {%else%}
           转移
          {%/if%}
          <!--{%if $row->sm_status == 1 %}
           使用中
           {%else%}
          	历史
          {%/if%}-->
          </td>
        <td>{%$row->cname%} </td>
        <td>{%$row->deptName%}</td>
        <td>{%$row->sl_name%}  </td>
         <td>{%$row->sa_name%}  </td>
        <td>
         
        	{%$row->use_time%} 
         </td>
          <td>
            
          {%if $row->sm_sap_status == 1 %}
            已审核
           {%else%}
          	<span class=fontRed>	未审核</span>
          {%/if%}
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
  <div class="pageNav">
  {%$links%}
  
  </div>
  </div>
 