{%include file="../header.tpl"%} 
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
   $('button[name="view"]').click(function(){
			  $this = $(this).val();
                    $.ajax({
                        type: "POST",
                        url: "{%site_url('permissions/permissions/systemView')%}",
                        data: "id="+$this,
                        success: function(msg){
                           //  alert(msg);
                             if(msg=="0"){ 
							 	jError("操作失败! ",{
									VerticalPosition : 'center',
									HorizontalPosition : 'center',
									TimeShown : 1000
								});
							 }else{
								  $("#showLayout").html(msg);
								  hiBox('#showLayout','编辑用户系统权限','','','','.a_close');
								  
								 }
                        }	   

                    });
		});
		
		$('button[name="delScrap"]').click(function(){
				 
				  $this = $(this).val();
				hiConfirm('确认删除此用户？',null,function(tp){
					if(tp){
						$.ajax({
							type: "POST",
							url: "{%site_url('staff/staff/staffdeleteScrapTrue')%}",
							data: "id="+$this,
							success: function(msg){
								//alert(msg);
								if(msg=="ok"){
									// $("tr#"+n).remove();
									jSuccess("操作成功! 正在刷新页面...",{
										VerticalPosition : 'center',
										HorizontalPosition : 'center',
										TimeShown : 1000,
									});
								 
								}else{
									hiAlert(msg);
								}
							}
								   
						});
						return false;
							
					}
				});
		});
    });
    //]]>
</script>
<div id="showLayout" style="display:none;"></div>
 <div class="h10"></div>
    <table  class="treeTable" id="treeTable">
      <thead>
        <tr>
         <!-- <th width="40"><input id="all_check" type="checkbox"/></th>-->
          <th>姓名/帐号</th>
          <th>部门</th>
          <th>用户状态</th>
          <th>IP</th>
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
        <td>{%$row->sms_ip%}</td>
        <td>
        <div 
         {%if count($row->systeminfo)>5%}
        title="{%section name=n loop=$row->systeminfo%}{%$row->systeminfo[n]%},{%/section%}"
        {%/if%}
        >
        {%$row->dg_info%} 
           {%section name=n loop=$row->systeminfo max=5%}
               {%$row->systeminfo[n]%}&nbsp;&nbsp;
           {%/section%}
          {%if count($row->systeminfo)>5%}
        	...
        {%/if%}
          
          </div>
        	 
         </td>
        <td>
        <button class="button" name="view" type="button" value="{%$row->id%}">权限</button>
        <button class="button" name="delScrap" type="button" value="{%$row->id%}">删除</button>
           </td>
      </tr>
      {%/foreach%}
      
      {%else%}
      <tr>
        <td colspan="7">暂无记录！</td>
      </tr>
      {%/if%}
        </tbody>
      
    </table>
 
 {%include file="../foot.tpl"%}