<script type="text/javascript">
 	 
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
			 $(".ipFun").click(function(){ // 给页面中有caname类的标签加上click函数
                var objTD = $(this);
                var oldText = $.trim(objTD.text()); //  
				//alert(oldText);
                var input = $("<input name='dept_ip' type='text' class='searchTopinput' style=' width:80px;' value='"+oldText+"' />"); // 文本框的HTML代码
                
                objTD.html(input); // 当前td的内容变为文本框效
                 input.click(function() {
                      return false;
                 });
                // 设置文本框的样式
                input.trigger("focus");//.trigger("select"); // 全选
                // 文本框失去焦点时重新变为文本
                input.blur(function() {
                    var newText = $(this).val(); // 修改后的名称
                    var input_blur = $(this);
                    // 当老的类别名称与修改后的名称不同的时候才进行数据的提交操作
                    if (oldText != newText) {
                        // 获取该类别名所对应的ID(序号)
                        //alert(objTD.parents('ul').children('input').val());
                        var dId = objTD.parents('td').children('input[name=dId]').val();//$.trim(objTD.first().text());
                        var dIp = encodeURI(newText);
                         $.ajax({
                            type: "POST",
                            url: "{%site_url('sms/sms/ip_dept_do')%}",
                            cache:false,
                            data: 'dId='+dId+"&dIp="+dIp,
							contentType: "application/x-www-form-urlencoded; charset=utf-8", 
                            success: function(msg){
                                 objTD.html(newText);
                            },
                            error:function(){
                                  input_blur.trigger("focus").trigger("select"); // 文本框全选
                            }
                        });
                         
                    } else {
                        // 前后文本一致,把文本框变成标签
                        objTD.html(newText);
                    }
                });
             });
		 });
		 function postdnAjax(val){
            $.ajax({
                type: "POST",
                url: '{%site_url("dept/deptsys/deptsys_list")%}',
                cache:false,
                data: 'id='+val,
                success: function(msg){
                 $("#ouShow").html(msg);
                    // alert(val);       
                },
                error:function(){
                    hiAlert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
                }
            });
        }
	 
</script>

<div  class="pad5">
  <div class="showDn"> <span class="ouzhuzhi">组织:{%implode(" &raquo; ", $ouTemp)%} </span> <br>
    <span class="ouDn">AD DN：{%implode(",", $ouDnPost)%}</span> </div>
  <div class="h10 clearb"> </div>
  <div id="massege" style="display:none; "> 添加成功正在刷新页面。。。。 </div>
  <div id="adddept" style="display:none; " >
    <input type="hidden" name="rootid" id="rootid" value="{%$rootid%}" />
    <input type="hidden" name="container" id="container" value="{%implode(",", $ouTemp)%}" />
    <input type="hidden" name="addn" id="addn" value="{%implode(",", $ouDnPost)%}" />
    <div id="addInfo"> .... </div>
    <div class="h10 clearb"> </div>
    <div class="formLab">&nbsp;</div>
    <div class="formLabi">
      <input class="buttom" type="submit" name="submit" id="new_button" value="确定" />
      <input class="a_close buttom" type="button" name="canceladd" id="canceladd" value="取消" />
    </div>
  </div>
  <div id="ouShow" style=" " >
    <table  class="treeTable" id="treeTable">
      <thead>
        <tr>
          <th>名称</th>
          <th>说明</th>
          <th>类型</th>
          <th>IP 段</th>
        </tr>
      </thead>
      <tbody>
      
      {%if $ouData %}
      {%foreach from=$ouData item=row%}
      <tr id="{%$row->id%}">
        <td><div class="fleft IcoDept" > </div>
          &nbsp; <span>{%$row->deptName%}</span></td>
        <td>{%$row->detail%}</td>
        <td>{%$row->dt_name%}</td>
        <td width="200">
        <input type="hidden" name="dId" value="{%$row->id%}" />
        {%if ($sysPermission["sms_ip_dept"] == 1)%} 
       
         <div class="ipFun" style=''>
         {%else%}
          <div style=' '>
         {%/if%}  
          {%if $row->ipAddress%}
          	{%$row->ipAddress%}
           {%else%}
      --
      {%/if%}
       
        </div>
        
        </td>
      </tr>
      {%/foreach%}
      {%else%}
      <tr>
        <td colspan=6 >暂无信息！</td>
      </tr>
      {%/if%}
        </tbody>
      
    </table>
  </div>
</div>
