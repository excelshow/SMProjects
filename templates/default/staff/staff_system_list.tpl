<script type="text/javascript">
    //<![CDATA[
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
					var key = $('input[name="searchText"]').val();
					if(url!='undefined'){
						$.post(url,{ key: key},function(data){
							$('#staffshow').html(data)
						});
					}
				});
    });
    //]]>
</script>

 <div class="pageNav">{%$links%}</div>
    <table  class="treeTable" id="treeTable">
      <thead>
        <tr>
         <!-- <th width="40"><input id="all_check" type="checkbox"/></th>-->
          <th>姓名/帐号</th>
          <th>部门</th>
          <th>用户状态</th>
          <th>系统权限</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
      
      {%if ($data)%}
      {%foreach from=$data item=row%}
      <tr id="{%$row->id%}">
      <!--  <td><input class="all_check" type="checkbox" name="staff_id_{%$row->id%}" value="{%$row->id%}"/></td>-->
        <td>{%$row->cname%}<br />
        {%$row->itname%}</td>
        <td>{%$row->deptname%}  </td>
        <td> {%if $row->enabled == 1 %}
          活跃
         
          {%/if%}
          {%if $row->enabled == 0 %}
          暂停
           
          {%/if%} </td>
        <td>
        <div 
         {%if count($row->systeminfo)>5%}
        title="{%section name=n loop=$row->systeminfo%}{%$row->systeminfo[n]%},{%/section%}"
        {%/if%}
        >
           {%section name=n loop=$row->systeminfo max=5%}
               {%$row->systeminfo[n]%}&nbsp;&nbsp;
           {%/section%}
          {%if count($row->systeminfo)>5%}
        	...
        {%/if%}
          
          </div>
        	 
         </td>
        <td><button class="button" name="edit" type="button" value="{%$row->id%}">编辑</button>
           </td>
      </tr>
      {%/foreach%}
      
      {%else%}
      <tr>
        <td colspan="6">暂无记录！</td>
      </tr>
      {%/if%}
        </tbody>
      
    </table>
 <div class="pageNav">{%$links%}</div>