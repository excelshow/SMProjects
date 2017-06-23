<!--begin form -->

<div class="staffformInfo">
  <div  class="formLab">资产编号：</div>
  <div class="formcontrol"> <span class="font16"> {%$data->sms_number%} 
  / {%$data->sms_sapnumber%}</span></div>
  <div class="clearb" ></div>
  <div  class="formLab">资产名称</div>
  <div  class="formcontrol">{%$data->sms_name%} - {%$data->sms_brand%} - {%$data->sms_size%}</div>
 
  <div class=" formLine clearb"> </div>
   <div  class="formLab">机房编号：</div>
 
  <div  class="formcontrol">
    <input name="sms_local_number" class="inputText" id="sms_local_number" type="text"  size="20"  value="" />
  </div>
  <div class=" h10 clearb"> </div>
  <div  class="formLab">使用机房：</div>
 
  <div  class="formcontrol">
    <input name="sms_local" class="inputText" id="sms_local" type="text"  size="20"  value="" />
  </div>
  <div class="formLine clearb"> </div>
  <div  class="formLab">出库人</div> 
    <div  class="formcontrol">
    {%$smarty.session.DX_username%}
  </div>
  <div class="h5 formLine clearb"> </div>
 
  
  <div  class="formLab">&nbsp;</div>
  <div class="formcontrol">
    <input name="sms_id" id="sms_id" type="hidden" value="{%$data->sms_id%}" />
    <input name="addcomplete" class="buttom" type="submit" value="提交完成" />
    &nbsp;&nbsp;
    <input type="button" onclick=" " class="a_close buttom" value="放弃" />
  </div>
</div>
<div class=" clearb"> </div>
</div>
<!--end form --> 

