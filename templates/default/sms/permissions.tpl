{%include file="../header.tpl"%} 
<script src="{%base_url()%}assets/jstree/jquery.jstree.js" type="text/javascript"></script> 
  
<script type="text/javascript">
    // JavaScript Document
 $(document).ready(function(){
	 // 浏览器的高度和div的高度  
     var height = $(window).height();  
	// var divHeight = $("#localJson").height();  
    $("#localJson").height(height - 185); 
	$("#localJson").css("overflow","auto"); 
    //div高度大于屏幕高度把屏幕高度赋给div，并出现滚动条  
     $("#tbalemenu").treeTable({expandable:false});
        $("tr:odd").addClass('even');
        $("tr").hover(
        function () {
            $(this).addClass("hover");
        },
        function () {
            $(this).removeClass("hover");
        }
    );
   // add and edit  menu start
        $("button[name='new']").click(function(){
            //$("#form")[0].reset();
			 hiBox('#showLayout','编辑用户系统权限','','','','.a_close');
            //$('#showLayout').show();
        });
  
		
    });
    //]]>
   
</script>
<div id="showLayout" style="display:none;">
      <div class="staffadd pad5 " style="  ">
    
    <!--begin form -->
    <div class="staffformInfo fleft">
 
          <div  class="formLab">应用系统</div>
          <div class="formcontrol">
            <div   >
            
                         <input name="appstore[]" type="checkbox" style="display:none;" value="ad" checked="checked" />
            AD 域
                        &nbsp;&nbsp;&nbsp;
            </div>
          </div>
          <div class="formLine  clearb" ></div>
          <div  class="formLab">基本信息</div>
          <div  class="formLabt">姓：</div>
          <div  class="formLabi">
            <input name="surname"  class="inputText" type="text" id="surname"   size="4" maxlength="6" value="安" />
            (中文) </div>
          <div  class="formLabt">名：</div>
          <div  class="formLabi">
            <input name="firstname" class="inputText" id="firstname" type="text"  size="6" maxlength="10" value="丽婕" />
            (中文) </div>  <div  class="formLabt">性别：</div>
        <div  class="formLabi">
          <input name="gender" type="radio" id="gender" value="0"  />男&nbsp;&nbsp;&nbsp;&nbsp;
          <input name="gender" type="radio" id="gender" value="1"  />女
            </div>
             
          <div class="h10 clearb"> </div>
          <div  class="formLab">&nbsp;</div>
          <div  class="formLabt">IT帐号：</div>
          <div  class="formLabi">
            <input name="logon_name" class="inputText" id="logon_name" type="text" value="anlijie" size="20" maxlength="20"  />
            <input name="username" class="inputText" id="username" type="hidden" value="anlijie" size="20" maxlength="20"  />
            (英文或数字) </div>
          <div  class="formLabt">密码：</div>
          <div  class="formLabi">
            <input name="password" class="inputText" id="password" type="text" value="" size="12" maxlength="20"  />
          </div>
          <div class="h10 clearb"> </div>
          <div  class="formLab">&nbsp;</div>
          <div  class="formLabt">邮箱：</div>
          <div  class="formLabi">
            <input name="email" class="inputText" type="text" id="email" value="anlijie" size="15"/>
            <select id="domain" name="domain"  class="inputText">
              <option  selected="selected" >semir.com</option>
              <option    >balabala.com.cn</option>
              <option >semir.com</option>
              <option>vip.semir.com</option>
              <option>minette.com.cn</option>
            </select>
          </div>
           <div class="h10 clearb"> </div>
        <div  class="formLab">&nbsp;</div>
        <div  class="formLabt">岗位：</div>
        <div  class="formLabi">
         	<input name="station" class="inputText" id="station" type="text" value="" size="20" maxlength="20"  />
        </div>
          <div class="formLine clearb " ></div>
          <div  class="formLab">&nbsp;</div>
          <div class="formcontrol">
            <input name="id" id="id" type="hidden" value="1424" />
            <input name="action" type="hidden" value="modify" />
            <input name="addcomplete" class="buttom" type="submit" value="提交完成" />
            &nbsp;&nbsp;
            <input type="button" onclick=" " class="a_close buttom" value="放弃" />
          </div>
      
    </div>
    <div class=" clearb"> </div>
    </div>
    <!--end form --> 
   
</div>
<div class="sidebarLeft ">
  
    <!--begin dept -->
  <div class="pad10">
    <div class="ouTreeTitle" >配置选择</div>
    <div class="ouTree ">
      <div id="localJson">
      {%$showmenu%}
      </div>
    </div>
  </div>
  
  <!--end dept --> 
</div>
<div class="sidebarMainTo"  style=" ">
<div class="pad10">
<div  class="pageTitleTop">资产管理 &raquo; 配置管理 &raquo; 资产类别</div>
 
 <div class="h5"></div>
 
  <div id="staffshow" >
      <table id="tbalemenu" >
            <thead><tr><th></th><th>显示顺序</th><th>操作选项</th></tr></thead>
            <tr id="node-root">
                <td><span class="root">资产管理
                   
                </span></td>
                <td></td>
                <td>
                    <button class="add" name="new" type="button" value="0"></button>
                </td>
            </tr>
   	 
     {%foreach from=$data item=row%}
                        <tr id="node-{%$row->sc_id%}"	{%if ($row->sc_root)%}	class="child-of-node-{%$row->sc_root%}"    {%else%}    class="child-of-node-root"	{%/if%}	>
                                    <td>
                                        <span class={%if $row->children%} "folder" {%else%} "file" {%/if%}>{%$row->sc_name%}</span>
                                    </td>
                                    <td>
                                        <span class="sequence" id="optional_{%$row->sc_id%}">{%$row->sc_sort%}</span>
                                    </td>
                                    <td>

                                        <button class="add" name="new" type="button" value="{%$row->sc_id%}" title="添加栏目"></button>
                                        <button class="action edit" name="edit" type="button" value="{%$row->sc_id%}" title="修改栏目"></button>
            {%if (!$row->children)%}
                                    <button class="action delete" name="del" type="button" value="{%$row->sc_id%}" title="删除栏目" ></button>
            {%/if%}
                                </td>
                            </tr>
    {%/foreach%}
                                </table>
  </div>
  </div>
</div>
 
{%include file="../foot.tpl"%}