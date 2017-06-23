 
<input type="hidden" name="dept_id" id="dept_id" value="{%$deptName['deptId']%}" />
 
{%if $sms_dept%} 
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
 	
	 
 });
    //]]>
   
</script>
 	
  	<table  class="treeTable" id="treeTable" >
      <thead>
        <tr>
        <th  >选择</th>
          <th  >资产编号</th>
          <th  >名称</th>
           <th  >类别</th>
           <th  >规格</th>
            <th>状态</th>
          <th>使用日期</th>
        </tr>
      </thead>
      <tbody>
       
      {%foreach from=$sms_dept item=row%}
       
      <tr id="{%$row->sm_id%}">
       <td> 
         <input type="checkbox" name="sms_number[]" id="sms_number[]" value="{%$row->sms_number%}" /> 
          
        <td>{%$row->sms_number%}</td> 
         <td>{%$row->sms_name%}</td> 
        <td>
        {%$row->sms_cat_id%} {%$row->sms_type%}</td> 
         <td>
        {%$row->sms_brand%} <!--{%$row->sms_size%} {%$row->sms_unit%}-->
        </td> 
        <td> {%if $row->sm_type == 1 %}
           领用
           {%else%}
           借用
          {%/if%}
          {%if $row->sm_status == 1 %}
           使用中
           {%else%}
          	历史
          {%/if%}
          </td>
        <td>
         
        	{%$row->use_time%} 
         </td>
      </tr>
      {%foreachelse%}
     
      
      <tr>
        <td colspan="4">请输入查询条件</td>
      </tr>
       {%/foreach%}
        </tbody>
      
    </table>
     {%else%} 
     无
 {%/if%} 