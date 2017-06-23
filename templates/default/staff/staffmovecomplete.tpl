{%include file="../header.tpl"%} 
<script type="text/javascript">
//禁止用F5键          
          
    //<![CDATA[
   
    $(document).ready(function(){
		 
    });
    //]]>
</script>
<div class="sidebarLeft ">
  <div class="pad10">
    <div class="titleLeft" >用户管理</div>
    <div class="menuLeft">
      <div class="menuLink fright" ><a href="{%site_url("staff/staffadd")%}" ><span class="colw"> 新增用户 </span></a> </div>
      {%$showmenu%} </div>
  </div>
</div>
<div class="sidebarMainTo"  style=" ">
<div class="pad10">
  <div class="title">更改用户所属组织</div>
  <div class="staffadd pad5 " style="  ">
    <div class="staffAddSetp"> 
    {%$message%}  
    <a href="{%site_url("staff/")%}" >返回</a>
    </div>
    
    <!--begin form -->
    <div class="staffformInfo ">
      <form id="adduserform" action="{%site_url("staff/staffaddcomplete")%}" method="post">
        <dt>
          <div  class="formLab">所属组织</div>
          <div class="formcontrol">
            <div style="line-height:22px;"> <span class="ouzhuzhi">{%$ShowData['container']%}</span><br>
              <span class="ouDn">AD DN：{%$ShowData['adOuShow']%}</span> </div>
           
          </div>
        </dt>
        <div class="formLine clearb" ></div>
        <div  class="formLab">应用系统</div>
        <div class="formcontrol">
          <div   > {%if $staff->appstore =="appAd" %}
            
            AD 域
            {%/if%} </div>
        </div>
        <div class="formLine  clearb" ></div>
        
          <div  class="formLab">基本信息</div>
          <div  class="formLabt">姓名：</div>
          <div  class="formLabi">
            {%$staff->surname%}{%$staff->firstname%}
        </div>
          
          <div  class="formLabt">IT帐号：</div>
          <div  class="formLabi">
           {%$staff->itname%}  
        </div>
          
         <div class="h10 clearb"> </div>
         
        <div  class="formLab">&nbsp;</div>
        <div  class="formLabt">邮箱：</div>
        <div  class="formLabi">
         {%$staff->email%} 
        </div>
        
        <div class="formLine clearb " ></div>
        <div  class="formLab">&nbsp;</div>
        <div class="formcontrol">
          
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