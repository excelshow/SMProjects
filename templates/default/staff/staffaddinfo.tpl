{%include file="../header.tpl"%} 
<script type="text/javascript">
   
    //<![CDATA[ 
	jQuery.validator.addMethod("checkname",  //addMethod第1个参数:方法名称
        function(value, element, params) {     //addMethod第2个参数:验证方法，参数（被验证元素的值，被验证元素，参数）
			   userid = ""; //$("#logon_name").val();
			  $.ajax({
                    type: "POST",
                    url: "{%site_url('staff/staff/check_logon_name')%}",
					async:false,
                    data: "logonname="+value+"&id="+userid,
                    success: function(msg){
  							// alert(msg);
							//Alert(msg);
						if (value.toUpperCase() == msg.toUpperCase()){   // toUpperCase  大小写转换
							temp_type=false;  
							}else{
							temp_type=true; 
							$('#email').val(value);	 
						}
                    }
                });
				return temp_type; 
			   
			                   //测试是否匹配
        },
        "组织名不能重复！");    //addMethod第3个参数:默认错误信息
		
		
    $(document).ready(function(){
		  // function adduser start
			 var adduserjs = {
            rules: {
				surname:{required: true,maxlength: 20},
				firstname:{required: true,maxlength: 20},
                logon_name: {required: true,minlength: 2,checkname:''},
				email:{required: true,minlength: 2,checkname:''},
				password:{required: true,minlength: 8},
            },
            messages: {
                surname:{required: "用户姓必填",minlength: "最多20个字符"},
				firstname:{required: "用户名必填",minlength: "最多20个字符"},
				logon_name: {required: " 请输入IT登录名",minlength: "至少2个字符",checkname:'此登录已经存在'},
				email:{required: " 请输入Email地址",minlength: "至少2个字符",checkname:'此email已经存在'},
				password:{required: " 请输入密码",minlength: "至少8个字符"},
            } 
        };
 	$('#adduserform').validate(adduserjs);
			// function adduser end
    });
    //]]>
</script>
 
<div class=""  style=" ">
<div class="pad10">
  <div class="pageTitleTop">用户管理 &raquo; 新增用户</div>
  <div class="h10"></div>
  <div class="staffadd pad5 " style="  ">
    <div class="staffAddSetp">1: 组织/应用选择  -> 2: 基本信息填写  -> 3: 添加完成</div>
    
    <!--begin form -->
    <div class="staffformInfo ">
      <form id="adduserform" action="{%site_url('staff/staff/staffaddcomplete')%}" method="post">
        <dt>
          <div  class="formLab">组织部门</div>
          <div class="formcontrol">
            <div style="line-height:22px;"> <span class="ouzhuzhi">{%$container%}</span><br>
              <span class="ouDn">AD DN：{%$adOuShow%}</span> </div>
            <input type="hidden" name="rootid" id="rootid" value="{%$rootid%}" />
            <input name="adOuShow" id="adOuShow" type="hidden" value="{%$adOuShow%}" />
            <input name="container" id="container" type="hidden" value="{%$container%}" />
          </div>
        </dt>
        <div class="formLine clearb" ></div>
        <div  class="formLab">应用系统</div>
        <div class="formcontrol">
           <div   >
          {%if in_array("ad", explode(',',$applist)) %}
         <input name="appstore[]" type="checkbox" value="ad" checked="checked" />
            AD 域 
            {%/if%}
            &nbsp;&nbsp;&nbsp;
 
           {%if in_array("rtx",  explode(',',$applist)) %}
            <input name="appstore[]" type="checkbox" value="rtx" checked="checked" />
            RTX 
            {%/if%}
            &nbsp;&nbsp;&nbsp;
           {%if in_array("eyou",  explode(',',$applist)) %}
            <input name="appstore[]" type="checkbox" value="eyou" checked="checked" />
            邮件系统
            {%/if%}
              &nbsp;&nbsp;&nbsp;
           {%if in_array("bqq",  explode(',',$applist)) %}
            <input name="appstore[]" type="checkbox" value="bqq"   />
            企业QQ
            {%/if%}
          </div>
        </div>
        <div class="formLine  clearb" ></div>
        <div  class="formLab">基本信息</div>
        <div  class="formLabt">姓：</div>
        <div  class="formLabi">
          <input name="surname" class="inputText" type="text" id="surname" value="" size="4" maxlength="6" />
          (中文) </div>
        <div  class="formLabt">名：</div>
        <div  class="formLabi">
          <input name="firstname" class="inputText" id="firstname" type="text" value="" size="6" maxlength="10"  />
          (中文) </div>
          <div  class="formLabt">性别：</div>
        <div  class="formLabi">
          <input name="gender" type="radio" id="gender" value="0" checked="checked" />男&nbsp;&nbsp;&nbsp;&nbsp;
          <input name="gender" type="radio" id="gender" value="1" />女
          </div>
             <div class="h10 clearb"> </div>
             <div  class="formLab">&nbsp;</div>
        <div  class="formLabt">帐号：</div>
        <div  class="formLabi">
          <input name="logon_name" class="inputText" id="logon_name" type="text" value="" size="20" maxlength="20"  />
          (英文或数字) </div>
        <div  class="formLabt">密码：</div>
        <div  class="formLabi">
          <input name="password" class="inputText" id="password" type="text" value="{%$password%}" size="12" maxlength="20"  />
        </div>
        <div class="h10 clearb"> </div>
        <div  class="formLab">&nbsp;</div>
        <div  class="formLabt">邮箱：</div>
        <div  class="formLabi">
          <input name="email"  class="inputText" type="text" id="email" value="" size="15"/>
          <select id="domain" name="domain"   class="inputText">
            <option>balabala.com.cn</option>
            <option selected="selected">semir.com</option>
            <option>vip.semir.com</option>
            <option>minette.com.cn</option>
          </select>
        </div>
        <div  class="formLabt">端口号：</div>
        <div  class="formLabi">
          <input name="portnumber" class="inputText" id="portnumber" type="text" size="12" maxlength="12"  />
        </div>
         <div class="h10 clearb"> </div>
        <div  class="formLab">&nbsp;</div>
        <div  class="formLabt">工号：</div>
        <div  class="formLabi">
         	<input name="jobnumber" id="jobnumber"  class="inputText" type="text" value="" size="20" maxlength="40"  />
        </div>
         <div  class="formLabt">岗位：</div>
        <div  class="formLabi">
         	<input name="station" id="station"  class="inputText" type="text" value="" size="20" maxlength="40"  />
        </div>
         <div class="h10 clearb"> </div>
        <div  class="formLab">&nbsp;</div>
        <div  class="formLabt">工作地：</div>
        <div  class="formLabi">
         	<input name="location" type="text"  class="inputText" id="location" value="" size="4" maxlength="40"  />
        </div>
         <div  class="formLabt">手机：</div>
        <div  class="formLabi">
         	<input name="mobtel" id="mobtel"  class="inputText" type="text" value="" size="12" maxlength="12"  />
        </div>
        <div class="formLine clearb " ></div>
        <div  class="formLab">&nbsp;</div>
        <div class="formcontrol">
          <input name="action" type="hidden" value="" />
          <input name="addcomplete" type="submit"  class="buttom" value="提交完成" />
          &nbsp;&nbsp;
          <input name="按钮" type="button" onclick="javascript:history.go(-1);" value="&laquo; 上一步"  class="buttom" />
          <input type="button" value="放弃"   class="buttom" />
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