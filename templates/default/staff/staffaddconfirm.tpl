{%include file="../header.tpl"%} 
<script src="{簊e_url()%}assets/treeweb/jquery.easing.1.3.js" type="text/javascript"></script> 
<script src="{簊e_url()%}assets/treeweb/jquery.adubytree.js" type="text/javascript"></script>
<link rel="StyleSheet" href="{簊e_url()%}assets/treeweb/themes/adubytree.css" type="text/css" />
<script type="text/javascript">
   
    //<![CDATA[
 
    $(document).ready(function(){
		 
    });
    //]]>
</script>
<div class="pad10">
  <div class="fleft mainleft" >
    <div class="title" >用户管理</div>
    <div class="  pad5">
      <div > <a href="{%site_url("staff/staffadd")%}" ><span class="addStaff"> 新增用户 </span></a> </div>
      {%$showmenu%} </div>
  </div>
</div>
<div class="fleft mainRight"  style=" ">
  <div class="title">新增用户</div>
  <div class="staffadd pad5 " style="  ">
    <div class="staffAddSetp">1: 组织/应用选择  -> 2: 基本信息填写  -> 3: 添加完成</div>
    
    <!--begin form -->
    <div class="staffformInfo ">
      <form action="{%site_url("staff/staffaddconfirm")%}" method="post">
        <dt>
          <div  class="formLab">所属组织</div>
          <div class="formcontrol">
            <div style="line-height:22px;"> <span class="ouzhuzhi">{%$adOuShow%}</span><br>
              <span class="ouDn">AD DN：{%$adOudn%}</span> </div>
            <input name="adOuShow" id="adOuShow" type="hidden" value="{%$adOuShow%}" />
            <input name="adOudn" id="adOudn" type="hidden" value="{%$adOudn%}" />
          </div>
        </dt>
        <div class="formLine clearb" ></div>
        <div  class="formLab">应用系统</div>
        <div class="formcontrol">
          <div   > {%if $appstore =="appAd" %}
            <input name="appstore" type="hidden" value="appAd" />
            AD 域
            {%/if%} </div>
        </div>
        <div class="formLine  " ></div>
        
          <div  class="formLab">基本信息</div>
          <div  class="formLabt">姓：</div>
          <div  class="formLabi">
            <input name="surname" type="text" id="surname" value="" size="4" maxlength="6" />(中文)
        </div>
          <div  class="formLabt">名：</div>
          <div  class="formLabi">
            <input name="firstname" id="firstname" type="text" value="" size="6" maxlength="10"  />(中文)
        </div>
          <div  class="formLabt">IT帐号：</div>
          <div  class="formLabi">
            <input name="logon_name" id="logon_name" type="text" value="" size="20" maxlength="20"  />(英文或数字)
        </div>
          <div  class="formLabt">密码：</div>
          <div  class="formLabi">
            <input name="password" id="password" type="text" value="888888" size="12" maxlength="20"  />
          </div>
         <div class="h10 clearb"> </div>
         
        <div  class="formLab">&nbsp;</div>
        <div  class="formLabt">邮箱：</div>
        <div  class="formLabi">
          <input name="email" type="text" id="email" value="" size="15"/> 
          <select id="domain" name="domain" class="sel">
						
			<option>balabala.com.cn</option>
<option>semir.com</option>
<option>vip.semir.com</option>
<option>minette.com.cn</option>
					</select>
        </div>
        
        <div class="formLine clearb " ></div>
        <div  class="formLab">&nbsp;</div>
        <div class="formcontrol">
          <input name="提交" type="submit" value="下一步》》" />
          &nbsp;&nbsp;
          <input name="按钮" type="button" onclick="javascript:history.go(-1);" value="上一步》》" />
          <input type="button" value="放弃" />
        </div>
      </form>
    </div>
    <!--end form --> 
    <!--begin dept --> 
    
    <!--end dept -->
    <div class="clearb"></div>
  </div>
  <div class="clearb"></div>
</div>
</div>
{%include file="../foot.tpl"%}