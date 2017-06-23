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
				 
			},
			function () {
				$(this).removeClass("hover");
				 
			}
		);
 	
	 $("input[name=searchBut]").click(function(){
		var t = $("#t").val();
		var k = $("#k").val()
		window.location = "{%site_url('sms/sms/history_list/')%}/"+t+"/"+k;
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
 

<div class=""  style=" ">
<div class="pad10">
  
  <div  class="pageTitleTop">资产管理 &raquo; 资产历史 &raquo; </div>
  	<div class="h5"></div>
  	 <div  class="searchBox"  style=" " >
      <select name="t" id="t" class="searchTopinput">
        <option value="1">用户帐号</option>
        <option value="2">资产编号</option>
      </select> <input name="k"  id="k" class="searchTopinput" type="text" /> <input name="searchBut" type="button" class="searchTopbuttom" value=""  />
    </div>
 
  <div id="showLayout" style="display:none;"></div>
  <div id="staffshow">
  <div class="h10"></div>
   <div class="pageNav">{%$links%}</div>
  	<table  class="treeTable" id="treeTable">
      <thead>
        <tr>
          <th>管理编号</th><th>财务编号 </th>
           <th >资产名称</th>
           <th>资产类别</th>
           <th>资产品牌</th>
           <th>资产规格</th>
            <th>状态</th>
          <th>使用人</th>
         <th>登录帐号</th>
          <th>使用部门</th>
          <th>领用日期</th>
          <th>归还日期</th>
        </tr>
      </thead>
      <tbody>
      
      {%if ($data)%}
      {%foreach from=$data item=row%}
      <tr id="{%$row->sm_id%}">
        <td>{%$row->sms_number%} </td>
        <td>{%$row->sms_sapnumber%}</td> 
         <td>
          
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
           借用
          {%/if%}
          <!--{%if $row->sm_status == 1 %}
           使用中
           {%else%}
          	历史
          {%/if%}-->
          </td>
        <td>{%$row->cname%} {%$row->sms_ip%}</td>
        <td>{%$row->itname%}</td>
        <td>{%$row->deptName%}  </td>
        
        <td>
         
        	{%$row->use_time%} 
         </td>
          <td>
           {%$row->return_time%} 
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
  <div class="pageNav">{%$links%}</div>
  </div>
  </div>
</div>
 
{%include file="../foot.tpl"%}