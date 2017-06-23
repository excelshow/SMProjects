 <div class=" fleft" style=" width:30%; padding-right:5px; font-size:16px; text-align:right; padding-right:20px; color:#060">
 <dl>搜索结果</dl>
 </div>
<div class="searchResult fleft" style=" width:65%;">

	 {%if ($staff)%}
		<dl>
         <span class="resultTitle">姓名</span><span class="resultInfo">{%$staff->cname%}</span>
         </dl>
         <dl>
         <span class="resultTitle">帐号</span><span class="resultInfo">{%$staff->itname%}</span>
         </dl>
        <dl>
         <span class="resultTitle">部门</span><span class="resultInfo">
         {%if ($data)%}
         {%$staff->deptName%}
          {%/if%}
         </span>
         </dl>
         <dl>
         <div style=" border-bottom:1px solid #CCC ;"></div>
          </dl>
	 {%/if%}
      {%if ($data)%}
      {%foreach from=$data item=row%}
     	<div style="float:left; width:50%">
           <dl>
         <span class="resultTitle">状态</span><span class="resultInfo"> 
         {%if ($row->sms_status == 1)%}
         	库存
         {%else%}
         	<span class="fontGreen">使用中</span>
         {%/if%}
          / {%$row->use_time%} 
          </span>
         </dl>
           <dl>
         <span class="resultTitle">编号</span><span class="resultInfo">{%$row->sms_number%} / {%$row->sms_sapnumber%}</span>
         </dl>
         <dl>
         <span class="resultTitle">名称</span><span class="resultInfo">{%$row->sc_name%}</span>
         </dl>
          <dl>
         <span class="resultTitle">类别</span><span class="resultInfo">{%$row->category_name%} </span>
         </dl>
         <dl>
         <span class="resultTitle">品牌</span><span class="resultInfo">{%$row->sms_brand%}</span>
         </dl>
         <dl>
         <span class="resultTitle">规格</span><span class="resultInfo">{%$row->sms_size%} </span>
         </dl>
          <dl>
         <span class="resultTitle">归属</span><span class="resultInfo"> {%$row->sa_name%} / {%$row->sl_name%} </span>
         </dl>
          <dl>
         <div style=" border-bottom:1px solid #CCC ;"></div>
          </dl>
          </div>
      {%/foreach%}
      
      {%else%}
      		<br />
         无您所查询的结果，请确认您的查询条件！
      		<br /><br /><br />
      {%/if%}
        
</div> 