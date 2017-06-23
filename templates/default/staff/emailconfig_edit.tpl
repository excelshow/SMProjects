  <!--begin form -->
    <div class="staffadd pad5 " style=" ">
      <div class="staffformInfo ">
           
          <div style="margin-left:105px;"> 
           <div  class="formLab">邮箱类型：</div>
          <div  class="formLabi">
       <input name="type" id="type"  class="inputText" type="text" value="{%$data->type%}" size="20" maxlength="60"  />
          </div>
          <div class="clearb h10"></div>
          <div  class="formLab">收件人：</div>
          <div  class="formLabi">
            <textarea name="sendto" id="sendto"  class="inputText"   value="{%$data->sendto%}" size="20" maxlength="2500"  >{%$data->sendto%}</textarea>
            
          </div>
          <div class="clearb h10"></div>
           <div  class="formLab">抄送：</div>
          <div  class="formLabi">
            <textarea name="cc" id="cc"  class="inputText"  value="{%$data->cc%}" size="20" maxlength="2500"  >{%$data->cc%}</textarea>
            
          </div>
          <div class="clearb h10"></div>
          <div  class="formLab">密送：</div>
          <div  class="formLabi">
            <textarea name="bcc" id="bcc"  class="inputText" value="{%$data->bcc%}" size="20" maxlength="2500" >{%$data->bcc%}</textarea>
            
          </div>
          <div class="clearb h10"></div>
          <div  class="formLab">来自：</div>
          <div  class="formLabi">
            <input name="from" id="from"  class="inputText" type="text" value="{%$data->from%}" size="20" maxlength="60"  />
            
          </div>
          <div class="clearb h10"></div>
          </div>
           
          <div class="formLine clearb " ></div>
          <div style="margin-left:36%;">
             <input name="id" id="id"  class="inputText" type="hidden" value="{%$data->id%}" size="20" maxlength="40"  />
            <input   type="submit"  class="buttom" value="提交完成" />
            &nbsp;&nbsp;
            <input type="button" value="放弃"  class="buttom a_close" />
          </div>
      <div class="clearb"></div> 
    <!--end form --> 
  