 <div class=" fleft" style=" width:30%; padding-right:5px; font-size:16px; text-align:right; padding-right:20px; color:#060">
 <dl>搜索结果</dl>
 </div>
<div class="searchResult fleft" style=" width:60%;">
      {%if ($data)%}
      {%foreach from=$data item=row%}
     	<dl>
         <span class="resultTitle">姓名</span><span class="resultInfo">{%$row->cname%}</span>
         </dl>
         <dl>
         <span class="resultTitle">帐号</span><span class="resultInfo">{%$row->itname%}</span>
         </dl>
        <dl>
         <span class="resultTitle">部门</span><span class="resultInfo">{%$row->deptname%}</span>
         </dl>
          <dl>
         <div style=" border-bottom:1px solid #CCC ;"></div>
          </dl>
           <dl>
         <span class="resultTitle">状态</span><span class="resultInfo"> {%if $row->enabled == 1 %}
          活跃
         
          {%/if%}
          {%if $row->enabled == 0 %}
          暂停
           
          {%/if%} </span>
         </dl>
         <dl>
         <span class="resultTitle">权限</span><span class="resultInfo">{%section name=n loop=$row->systeminfo%}{%$row->systeminfo[n]%}，{%/section%}</span>
         </dl>
        
      {%/foreach%}
      
      {%else%}
      		<br />
         无您所查询的结果，请确认您的查询条件！
      		<br /><br /><br />
      {%/if%}
        
</div> 