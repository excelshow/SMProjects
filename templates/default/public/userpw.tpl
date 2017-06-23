 <!-- edit password-->
 <div class="staffadd " >
    <div class="staffformInfo">

          <div><span class="beforeinput">用户名称：</span>{%$smarty.session.DX_username%}
            <input type="hidden" name="username" readonly="readonly" value="{%$smarty.session.DX_username%}" />
            <input type="hidden" name="uid" readonly="readonly" value="{%$smarty.session.DX_user_id%}" />
      </div>
            <div class="h10 "> </div>
          <div>
          <span class="beforeinput">旧密码：</span>
            <input type="password" class="inputText" name="opass" id="opass" />
             </div>
            <div class="h10 "> </div>
          <div>
             <span class="beforeinput">新密码：</span>
            <input type="password" class="inputText" name="npass" id="npass" />
             </div>
            <div class="h10 "> </div>
          <div>
            
            <span class="beforeinput">确认密码：</span>
            <input type="password" class="inputText" name="cpass" id="cpass"  />
          </div>
            <div class="h10 "> </div>
          <div>
          <span class="beforeinput">&nbsp;</span>
            <input type="submit" class="buttom" name="submit" id="edit_passbut" value="编辑密码" />
            
<input class="a_close buttom" type="button" value="放弃">
          </div>
      
    </div>
   </div>
    <!-- --> 