  
   
    <!--begin form -->
    <div class="staffadd pad5 " style=" ">
      <div class="staffformInfo "> 
          <div  class="formLab">编号</div>
          <div  class="formcontrol"> 
           {%$data->sms_number%}<input name="sm_id" type="hidden" value="{%$data->sm_id%}" />
          </div>          
           <div class="   clearb"> </div>
          <div  class="formLab">使用人</div>
          <div  class="formcontrol"> 
           {%$data->itname%}
          </div>
           {%if $t==1%}
           <div class="formLine clearb " ></div>
          <div  class="formLab">备注</div>
          <div  class="formcontrol">
          
            <textarea name="sm_remark" cols="50" class="inputText" id="sm_remark">{%$data->sm_remark%}</textarea><br />

             <label class="" for="sm_remark" generated="true">可输入OA流程地址或其他说明信息</label>
        </div>
          <div class="formLine clearb " ></div>
           <div  class="formLab">操作人</div>
          <div  class="formcontrol"> 
             <input name="op_user" id="op_user"  class="inputTextRead" readonly="readonly" type="text" value="{%$smarty.session.DX_username%}" size="20"    />
          </div>
          <div class="formLine clearb " ></div>
          <div  class="formLab">&nbsp;
           
          </div>
          <div class="formcontrol">
            <input name="action" type="hidden" value="" />
            <input name="addcomplete" type="submit"  class="buttom" value="提交完成" />
            &nbsp;&nbsp;
            <input type="button" value="放弃"   class="buttom a_close" />
          </div> 
      </div>
       {%else%}
        <div class="formLine clearb " ></div>
          <div  class="formLab">备注</div>
          <div  class="formcontrol">
          {%$data->sm_remark%}
        </div>
        {%/if%}
      <div class="clearb"></div>
    </div>
    <!--end form --> 
  