 
  <div class="staffadd pad5 " style="  ">
    
    <!--begin form -->
    <div class="staffformInfo fleft">
 
          <div  class="formLab">应用系统</div>
          <div class="formcontrol">
            <div   >
            
              {%if in_array("ad", explode(',',$staff->appstore)) %}
           <input name="appstore[]" type="checkbox" style="display:none;" value="ad" checked="checked" />
            AD 域
            {%/if%}
            &nbsp;&nbsp;&nbsp;
            {%if in_array("rtx",  explode(',',$staff->appstore)) %}
             <input name="appstore[]" style="display:none;" type="checkbox" value="rtx" checked="checked" />
           RTX
            {%/if%}</div>
          </div>
          <div class="formLine  clearb" ></div>
          <div  class="formLab">基本信息</div>
          <div  class="formLabt">姓：</div>
          <div  class="formLabi">
            <input name="surname"  class="inputText" type="text" id="surname"   size="4" maxlength="6" value="{%$staff->surname%}" />
            (中文) </div>
          <div  class="formLabt">名：</div>
          <div  class="formLabi">
            <input name="firstname" class="inputText" id="firstname" type="text"  size="6" maxlength="10" value="{%$staff->firstname%}" />
            (中文) </div>  <div  class="formLabt">性别：</div>
        <div  class="formLabi">
          <input name="gender" type="radio" id="gender" value="0"  />男&nbsp;&nbsp;&nbsp;&nbsp;
          <input name="gender" type="radio" id="gender" value="1"  />女
            </div>
             
          <div class="h10 clearb"> </div>
          <div  class="formLab">&nbsp;</div>
          <div  class="formLabt">IT帐号：</div>
          <div  class="formLabi">
            <input name="logon_name" class="inputText" id="logon_name" type="text" readonly="readonly" value="{%$staff->itname%}" size="20" maxlength="20"  />
            <input name="username" class="inputText" id="username" type="hidden" value="{%$staff->username%}" size="20" maxlength="20"  />
            (英文或数字) </div>
          <div  class="formLabt">密码：</div>
          <div  class="formLabi">
            <input name="password" class="inputText" id="password" type="text" value="" size="12" maxlength="20"  />
          </div>
          <div class="h10 clearb"> </div>
          <div  class="formLab">&nbsp;</div>
          <div  class="formLabt">邮箱：</div>
          <div  class="formLabi">
            <input name="email" class="inputText" type="text" id="email" value="{%$staff->email%}" size="15"/>
            <select id="domain" name="domain"  class="inputText">
              <option  selected="selected" >{%$staff->domain%}</option>
              <option    >balabala.com.cn</option>
              <option >semir.com</option>
              <option>vip.semir.com</option>
              <option>minette.com.cn</option>
            </select>
          </div>
		<div  class="formLabt">端口号：</div>
        <div  class="formLabi">
          <input name="portnumber" class="inputText" id="portnumber" type="text" size="12" maxlength="12"  value="{%$staff->port_number%}" />
        </div>
           <div class="h10 clearb"> </div>
        <div  class="formLab">&nbsp;</div>
        <div  class="formLabt">工号：</div>
        <div  class="formLabi">
         	<input name="jobnumber" id="jobnumber"  class="inputText" type="text" value="{%$staff->jobnumber%}" size="20" maxlength="40"  />
        </div>
        <div  class="formLabt">岗位：</div>
        <div  class="formLabi">
         	<input name="station" class="inputText" id="station" type="text" value="{%$staff->station%}" size="20" maxlength="20"  />
        </div>
         <div class="h10 clearb"> </div>
        <div  class="formLab">&nbsp;</div>
        <div  class="formLabt">工作地：</div>
        <div  class="formLabi">
         	<input name="location" type="text"  class="inputText" id="location" value="{%$staff->location%}" size="4" maxlength="40"  />
        </div>
         <div  class="formLabt">手机：</div>
        <div  class="formLabi">
         	<input name="mobtel" id="mobtel"  class="inputText" type="text" {%if $staff->mobtel%} value="***********"  disabled="disabled" {%/if%} size="12" maxlength="12"  />
        </div>
          <div class="formLine clearb " ></div>
          <div  class="formLab">&nbsp;</div>
          <div class="formcontrol">
            <input name="id" id="id" type="hidden" value="{%$staff->id%}" />
            <input name="action" type="hidden" value="modify" />
            <input name="addcomplete" class="buttom" type="submit" value="提交完成" />
            &nbsp;&nbsp;
            <input type="button" onclick=" " class="a_close buttom" value="放弃" />
          </div>
      
    </div>
    <div class=" clearb"> </div>
    </div>
    <!--end form --> 
   
 