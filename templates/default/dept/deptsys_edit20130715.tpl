 
       
          <div class="formLab">名称：</div>
          <div class="formLabi">
            <input type="text"  class="inputText" name="ou_name" id="ou_name"  value="{%$dept->deptName%}"  />
            <input type="hidden" class="inputText" name="id" id="id" value="{%$dept->id%}" />
            
          </div>
            <div class="h10 clearb"> </div>
          <div class="formLab">类别：</div>
          <div class="formLabi">
           
            <select name="dt_id" class="inputText" id="dt_id"  >
        
       {%foreach from=$dept_type item=rown%}
       <option value="{%$rown->dt_id %}" {%if ($rown->dt_id == $dept->dt_id)%} selected="selected" {%/if%}  >
        
	   {%$rown->dt_name %}
       
       </option>
       {%/foreach%}
       </select>
          </div>
       
         
             <div class="h10 clearb"> </div>
          <div class="formLab">说明：</div>
          <div class="formLabi">
            <input name="detail" class="inputText" type="text" id="detail" value="{%$dept->detail%}" />
            
          </div>
           <div class="h10 clearb"> </div>
           <div class="formLab">更新：</div>
          <div class="formLabi">
            <input name="uptype[]" type="checkbox" value="ad" checked="checked"   />
            AD 域
            <input name="uptype[]" type="checkbox" value="rtx" disabled="disabled"    />
            RTX
            <input name="uptype[]" type="checkbox" value="oa" disabled="disabled"   />
            OA </div>
        
         <input type="hidden" name="action" id="action" value="{%$action%}" />
        