{%include file="../header.tpl"%} 
<script type="text/javascript" src="{簊e_url()%}assets/javascript/uploadify/ajaxupload.js"></script> 
<script language="JavaScript" src="{簊e_url()%}assets/calendar.js"></script> 
<script type="text/javascript" src="{簊e_url()%}assets/xheditor-1.1.6/xheditor-1.1.6-zh-cn.min.js"></script> 
<script type="text/javascript">
    $(pageInit);
    function pageInit()
    {
        $('#content').xheditor({upImgUrl:"{%site_url('product/uploadHtmlPic')%}",upImgExt:"jpg,jpeg,gif,png",tools:'full'});
		 
    }
</script> 
<script type="text/javascript">
    //<![CDATA[
    var Alert=ymPrompt.alert;
    $(document).ready(function(){
        $("table:first tr:odd").addClass('even');
        $('"table:first tr').hover(
        function () {
            $(this).addClass("hover");
        },
        function () {
            $(this).removeClass("hover");
        }
    );

            
        $('button[name="edit"]').click(function(){
            window.location = "{%site_url('staff/editstaff')%}/" + $(this).val();
        });
        $('button[name="del"]').click(function(){
            $this = $(this).val();
            ymPrompt.confirmInfo('信息确认框功能测试',null,null,null,handler);
            function handler(tp){
                if(tp=='ok'){
                    $.ajax({
                        type: "POST",
                        url: "{%site_url('staff/physical_del')%}",
                        data: "staff_id="+$this,
                        success: function(msg){
                            //alert(msg);
                            if(msg=="ok"){
                                // $("tr#"+n).remove();
                                ymPrompt.succeedInfo({message:'操作成功！请稍候, 正在刷新页面....'});
                                setInterval(function(){window.location.reload();},1000);
                                //window.location = "{site_url('staff/') ?>";
									
                            }else{
                                //alert(msg);
                            }
                        }
							   
                    });

                    return false;
						
                }
            }
        });
             
			
            
 
			
    });
    //]]>
</script>
<div class="pad10">
  <div class="fleft mainleft">
    <div class="title" >用户管理</div>
    <div class="  pad5">
    <div > <a href="{%site_url("staff/staffadd")%}" ><span class="addStaff"> 新增用户 </span></a> </div>
     {%$showmenu%}
     </div>
  </div>
  <div class="mainRight"  style=" ">
  
  <form action="{%site_url('staff/multi_del')%}" method="post">
    <table  class="treeTable" id="treeTable">
      <thead>
        <tr>
          <th width="40"><input id="all_check" type="checkbox"/></th>
          <th>姓名</th>
          <th>IT帐号</th>
          <th>部门</th>
          <th>IP</th>
          <th>AD域状态</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
      
      {%foreach from=$data item=row%}
      <tr id="{%$row->id%}">
        <td><input class="all_check" type="checkbox" name="staff_id_{%$row->id%}" value="{%$row->id%}"/></td>
        <td>{%$row->cname%}</td>
        <td>{%$row->itname%}</td>
        <td>{%$row->rootid%} [更改]</td>
        <td>{%$row->ip1%}.{%$row->ip2%}.{%$row->ip3%}.{%$row->ip4%}</td>
        <td>{%$row->UserAccountControl%}</td>
        <td><button class="edit" name="edit" type="button"
                                    value="{%$row->id%}"></button>
          <button class="delete" name="del" type="button"
                                    value="{%$row->id%}"></button></td>
      </tr>
      {%/foreach%}
      <tr>
        <td><input type="submit" value="   submit" name="submit"  class="delete"/></td>
        <td colspan="5"><div align="center">{%$links%}</div></td>
      </tr>
        </tbody>
      
    </table>
  </form>
  </div>
  </div>
</div>
{%include file="../foot.tpl"%}