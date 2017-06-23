{%include file="../header.tpl"%} 
<script src="{%base_url()%}assets/jstree/jquery.jstree.js" type="text/javascript"></script> 
<script type="text/javascript">
   
    //<![CDATA[
    $(document).ready(function(){
			 
        $.ajax({
             type: "GET",
            url: "{%site_url('public/deptlist/deptsys_tree')%}",
            data: "",
            dataType:'json',
            success: function(msg){
                //data = eval(msg);
                postdn(0);
                outree = {id : "0" , data: "Semir",  state : "open", children:  msg};
                //alert(msg);
               $("#localJson").jstree({ 
					"json_data" : {
						"data" : [ outree ]
					},
					"themes" : {
					 	"theme" : "classic",
						"dots" : true,
						"icons" : true
					},
					"plugins" : [ "themes", "json_data", "ui" ]
				}).bind("select_node.jstree", function (e, data) { 
				
				 postdn(data.rslt.obj.attr("id"));
				 });
									 
            }
        });
        function postdn(val){
			 $.ajax({
                type: "POST",
                url: '{%site_url("public/deptlist/deptselect")%}',
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
       
    });
    //]]>
</script>
<div class="sidebarLeft ">
  <div class="pad10">
    <div class="titleLeft" >用户管理</div>
    <div class="menuLeft">
      <div class="menuLink fright" ><a href="{%site_url("staff/staff/staffadd")%}" ><span class="colw"> 新增用户 </span></a> </div>
      {%$showmenu%} </div>
  </div>
</div>
<div class="sidebarMainTo"  style=" ">
<div class="pad10">
  <div class="title">新增用户</div>
  <div class="staffadd pad5 " style="  ">
    <div class="staffAddSetp">1: 组织/应用选择  -> 2: 基本信息填写  -> 3: 添加完成</div>
    
    <!--begin form -->
    <div class="staffform fleft">
      <form action="{%site_url("staff/staffaddinfo")%}" method="post">
        <div  class="formLab">组织部门</div>
        <div class="formcontrol">
          <div id="ouShow" style=" " >
            <div class="fright">请选择新用户所属组织部门 -></div>
          </div>
          <input name="adOudn" id="adOudn" type="hidden" />
        </div>
        <div class="formLine clearb" ></div>
        <div  class="formLab">应用系统</div>
        <div class="formcontrol">
          <div   >
          {%if in_array("ad", explode(',',$applist)) %}
         <input name="appstore[]" type="checkbox" value="ad" checked="checked" />
            AD 域 
            {%/if%}
            &nbsp;&nbsp;&nbsp;

            </div>
          <div   >
           {%if in_array("rtx",  explode(',',$applist)) %}
            <input name="appstore[]" type="checkbox" value="rtx" checked="checked" />
            RTX 
            {%/if%}
          </div>
           
        </div>
        <div class="formLine clearb" ></div>
        <div  class="formLab">&nbsp;</div>
        <div class="formcontrol">
          <input name="提交" class="buttom" type="submit" value="下一步  » " />
          <input type="button" class="buttom" value="放弃" />
        </div>
      </form>
    </div>
    <!--end form --> 
    <!--begin dept -->
    <div class=" fleft pad10">
      <div class="ouTreeTitle" >组织结构</div>
      <div class="ouTree pad5">
        <div id="localJson"><img src="{%$base_url%}templates/{%$web_template%}/images/loading.gif" width="16" height="16" />Loading...</div>
      </div>
    </div>
    <!--end dept -->
    <div class="clearb"></div>
  </div>
  <div class="clearb"></div>
</div>
</div>
{%include file="../foot.tpl"%}