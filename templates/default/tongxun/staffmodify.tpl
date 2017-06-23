<!--begin form -->

<div class="staffformInfo fleft">
  <div  class="formLab">姓名：</div>
  <div class="formcontrol"> <span class="font16"> {%$staff->cname%} 
    / {%$staff->itname%}</span></div>
  <div class="formLine  clearb" ></div>
  <div  class="formLab">联系信息</div>
  <div  class="formLabt">电话：</div>
  <div  class="formLabi">
     <input name="sa_code"   class="inputText" type="text" id="sa_code"   size="4"  value="{%$addreeInfo->sa_code%}" />-<input name="sa_tel"   class="inputText" type="text" id="sa_tel"   size="12"  value="{%$addreeInfo->sa_tel%}" />
  </div>
  <div class="h10 clearb"> </div>
  <div  class="formLab">&nbsp;</div>
  <div  class="formLabt">分机：</div>
  <div  class="formLabi">
    <input name="sa_tel_short" class="inputText" id="sa_tel_short" type="text"  size="10"  value="{%$addreeInfo->sa_tel_short%}" />
  </div>
  <div class="h10 clearb"> </div>
  <div  class="formLab">&nbsp;</div>
  <div  class="formLabt">手机：</div>
  <div  class="formLabi">
    <input name="sa_mobile" class="inputText" id="sa_mobile" type="text"  size="14"  value="{%$addreeInfo->sa_mobile%}" />
  </div>
  <div class="h10 clearb"> </div>
  <div  class="formLab">&nbsp;</div>
  <div  class="formLabt">E-Mail：</div>
  <div  class="formLabi">
    <input name="sa_email" class="inputText" id="sa_email" type="text"   value="{%$addreeInfo->sa_email%}"  />
  </div>
  <div class="h10 clearb"> </div>
  <div  class="formLab">&nbsp;</div>
  <div  class="formLabt">地址：</div>
  <div  class="formLabi">
    <input name="sa_address" class="inputText" id="sa_address" type="text"   value="{%$addreeInfo->sa_address%}" size="50"  />
  </div>
  <div class="h10 clearb"> </div>
  <div  class="formLab">&nbsp;</div>
  <div  class="formLabt">备注：</div>
  <div  class="formLabi">
    <textarea name="sa_market" cols="50" rows="2" class="inputText" id="sa_market">{%$addreeInfo->sa_market%}</textarea>
  </div>
  <div class="h10 formLine clearb"> </div>
  <div  class="formLab">查看权限</div>
  <div  class="formLabt">
    <input name="staff_level" type="radio" value="0" {%if $addreeInfo->
    sar_level==0%} checked="checked" {%/if%} /></div>
  <div  class="formLabi"> 普通员工<span style="font-size:12px;">（无需登录可以查询公司电话）</span> </div>
  <div class="h10 clearb"> </div>
  {%foreach from=$addressRose item=row key%}
  <div  class="formLab">&nbsp;</div>
  <div  class="formLabt">
    <input name="staff_level" type="radio" value="{%$row->sar_id%}" {%if $addreeInfo->
    sar_level==$row->sar_id%} checked="checked" {%/if%}  /></div>
  <div  class="formLabi"> {%$row->sar_name%} <span style="font-size:12px;">（{%$row->sar_mark%}）</span> </div>
  <div class="h10 clearb"> </div>
  {%/foreach%}
  <div class="formLine clearb " ></div>
  <div  class="formLab">&nbsp;</div>
  <div class="formcontrol">
    <input name="itname" id="itname" type="hidden" value="{%$staff->itname%}" />
    <input name="addcomplete" class="buttom" type="submit" value="提交完成" />
    &nbsp;&nbsp;
    <input type="button" onclick=" " class="a_close buttom" value="放弃" />
  </div>
</div>
<div class=" clearb"> </div>
</div>
<!--end form --> 

