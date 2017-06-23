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
	 
		$('button[name="move"]').bind("click",function(){
         		window.location = "{%site_url('staff/staffmove')%}/"+$(this).val();
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
		
				 $("#allCheck").bind("click",function() {
 	                $('input[name="staff_id[]"]').attr("checked",this.checked);
 	            });
 	            var $subBox = $("input[name='staff_id[]']");
 	            $subBox.bind("click",function(){
                 $("#allCheck").attr("checked",$subBox.length == $("input[name='staff_id[]']:checked").length ? true : false);
 	            });
		 
    });
    //]]>
</script>
 <div style="padding:5px;" >共有记录： {%$total%} 条</div>
    <table  class="treeTable" id="treeTable">
      <thead>
        <tr>
           <th width="40"><input type="checkbox" id="allCheck" checked="checked"/></th> 
          <th>姓名</th> 
          <th>登录帐号</th>
          <th>部门</th>
          <th>用户状态</th>
           
        </tr>
      </thead>
      <tbody>
      
      {%if ($data)%}
      {%foreach from=$data item=row%}
      <tr id="{%$row->id%}">
        <td><input name="staff_id[]" type="checkbox" class="all_check" value="{%$row->id%}" checked="checked"/></td> 
        <td>{%$row->cname%}</td>
         <td>{%$row->itname%}</td>

        <td>
        <div title="{%implode(" &raquo; ", $row->deptOu)%}">{%$row->deptname%}...</div>
         
        
        </td>
        <td> {%if $row->enabled == 1 %}
          活跃
         
          {%/if%}
          {%if $row->enabled == 0 %}
          禁用
         
          {%/if%} </td>
       
      </tr>
      {%/foreach%}
      
      {%else%}
      <tr>
        <td colspan="6">暂无记录！</td>
      </tr>
      {%/if%}
        </tbody>
      
    </table>
 
   