 <div class="  " style="">
  <h4>领用资产</h4> 
 </div>
<div class="" style=" ">
 
      {%if ($data)%}
     
      <table width="100%" border="0" class="treeTable">
      <thead>
  <tr>
    <td><span class="resultTitle">编号</span></td>
    <td><span class="resultTitle">名称</span></td>
    <td><span class="resultTitle">类别</span></td>
    <td><span class="resultTitle">品牌</span></td>
    <td><span class="resultTitle">归属</span></td>
  </tr>
  </thead>
   {%foreach from=$data item=row%}
  <tr>
    <td>{%$row->sms_number%}</td>
    <td>{%$row->sc_name%}</td>
    <td>{%$row->category_name%}</td>
    <td>{%$row->sms_brand%}</td>
    <td>{%$row->sa_name%} / {%$row->sl_name%}</td>
  </tr>
   {%/foreach%}
</table>

     	 
      {%else%}
  <br />
          无领用资产
  <br /><br /><br />
      {%/if%}
        
</div> 
 <div class=" formLine clearb"> </div>
<div class="  " style="">
  <h4>借用资产</h4> 
 </div>
<div class="" style=" ">
 
      {%if ($jieyong)%}
     
      <table width="100%" border="0" class="treeTable">
      <thead>
  <tr>
    <td><span class="resultTitle">编号</span></td>
    <td><span class="resultTitle">名称</span></td>
    <td><span class="resultTitle">借用日期</span></td> 
  </tr>
  </thead>
   {%foreach from=$jieyong item=row%}
  <tr>
    <td>{%$row->sj_number%}</td>
    <td>{%$row->jieyong%}</td>
    <td>{%$row->use_time%}</td> 
  </tr>
   {%/foreach%}
</table>

     	 
      {%else%}
  <br />
          无借用资产
  <br /><br /><br />
      {%/if%} 
</div>
<div>
  {%if ($data || $jieyong)%}
   	 <input name="todoOa" type="submit"  class="buttom" value=" 发起OA流程 " />
   	{%else%}	
    <input name="todoEmail" type="button"  class="buttom" value=" 发送离职email "  onclick="sendEmail();"/> 
   {%/if%}     
</div>