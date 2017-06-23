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

                   $('button[name="edit"]').click(function(){
						window.location = "{%site_url('dept/admanager')%}" + $(this).val();
            	});
		});
</script>

<div  class="pad5">
  <div class="fright pad5"  > 
  <a href="{%site_url("admanager/dept_synctosys")%}" ><span class="tongbu">同步组织机构到系统</span></a>
   <a href="{%site_url("admanager/dept_synctosys_user")%}" ><span class="tongbu">同步用户到系统</span></a>
  <!-- {%if ($sysPermission["dept_into"] == 1)%}-->
 
<!--  {%/if%}-->
   <!--{%if ($sysPermission["dept_inuser"] == 1)%}-->
 
 <!-- {%/if%}-->
  </div>
  <div class="showDn"> <span class="ouzhuzhi">组织: {%implode(" &raquo; ", $ouTemp)%}</span><br>
    <span class="ouDn">AD DN：{%$ouDnPost%}</span> </div>
  <div id="ouShow" style=" " >
    <form action="{%site_url('staff/multi_del')%}" method="post">
     <table  class="treeTable" id="treeTable">
        <thead>
          <tr>
            <th><input id="all_check" type="checkbox"/></th>
            <th>名称</th>
            <th>类型</th>
            <th>描述</th>
            <th>状态</th>
            <!--<th>操作</th>-->
          </tr>
        </thead>
        <tbody>
        
        {%if $ouData %}
        {%foreach from=$ouData item=row%}
        <tr id="{%$row['ouType']%}">
          <td><input class="all_check" type="checkbox" name="staff_id_{%$row['ouDN']%}" value="{%$row['ouDN']%}"/></td>
          <td> {%if $row['ouType'] == 'OU' %}
            <div class="fleft IcoDept" > </div>
            &nbsp;
            {%else%}
            <div class="fleft IcoUser" > </div>
            &nbsp;
            {%/if%} 
            {%$row['ouName']%} </td>
          <td> {%if $row['ouType'] == 'OU'%}
            组织单位
            {%/if%}
            {%if $row['ouType'] == 'CN'%}
            AD用户 
            {%/if%} </td>
          <td></td>
          <td></td>
        <!--  <td><button class="edit" name="edit" type="button"
			value="{%$row['ouDN']%}"></button>
            <button class="delete" name="del" type="button"
			value="{%$row['ouDN']%}"></button></td>-->
        </tr>
        {%/foreach%}
        {%else%}
        <tr>
          <td colspan=6 >暂无信息！</td>
        </tr>
        {%/if%}
        </tbody>
        
      </table>
    </form>
  </div>
</div>
