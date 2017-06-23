{%include file="./header.tpl"%} 
<script type="text/javascript">
   
    
		
    $(document).ready(function(){
		  // function adduser start
			 var adduserjs = {
            rules: {
				surname:{required: true,maxlength: 4},
				firstname:{required: true,maxlength: 4},
                logon_name: {required: true,minlength: 2,checkname:''},
				email:{required: true,minlength: 2,checkname:''},
				password:{required: true,minlength: 8},
            },
            messages: {
                surname:{required: "用户姓必填",minlength: "最多4个字符"},
				firstname:{required: "用户名必填",minlength: "最多4个字符"},
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
  <div class="pageTitleTop">系统配置 &raquo; 基本配置</div>
  <div class="h10"></div>
  <div class="staffadd pad5 " style="  ">
    <!--begin form -->
    <div class="staffformInfo ">
      <form id="syscomForm" action="" method="post">
        
        <div  class="formLab">公司名称</div>        
        <div  class="formcontrol">
          <input name="copyright" class="inputText" type="text" id="copyright" value="{%$data->copyright%}" size="50" maxlength="50" />
          <label class="error" for="title" generated="true">最多50个字符</label>
         </div>
         <div class="h10 clearb"> </div>
         <div  class="formLab">公司网址</div>        
        <div  class="formcontrol">
          <input name="copyrighturl" class="inputText" type="text" id="copyrighturl" value="{%$data->copyrighturl%}" size="50" maxlength="50" />
          <label class="error" for="title" generated="true">最多50个字符</label>
         </div>
         <div class="h10 clearb"> </div>
         <div  class="formLab">系统标题</div>
         <div  class="formcontrol">
          <input name="title" class="inputText" type="text" id="title" value="{%$data->title%}" size="50" maxlength="50" />
          <label class="error" for="title" generated="true">最多50个字符</label>
            </div>
        
             <div class="h10 clearb"> </div>
        <div  class="formLab">页面模板</div>
        
        <div  class="formcontrol">
          <select id="templates" name="templates"   class="inputText">
            <option value="default">default</option>
          </select>
          </div>
        
        <div class="h10 clearb"> </div>
        <div  class="formLab">系统Logo</div>
        
        <div  class="formcontrol">
          <input name="email"  class="inputText" type="text" id="email" value="" size="15"/>
           在线上传LOGO，最好是透明PNG图标!
        </div>
         
        
        <div class="formLine clearb " ></div>
        <div  class="formLab">&nbsp;</div>
        <div class="formcontrol">
          <input name="action" type="hidden" value="" />
          <input name="addcomplete" type="submit"  class="buttom" value="提交完成" />
         
         
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
{%include file="./foot.tpl"%}