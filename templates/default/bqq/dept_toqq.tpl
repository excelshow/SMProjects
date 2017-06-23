 
       
          <div class="formLab">名称：</div>
          <div class="formLabi">
            {%$dept->deptName%}
            <input type="hidden" class="inputText" name="sd_id" id="sd_id" value="{%$dept->id%}" />
            
          </div>
               <div class="h10 clearb"> </div>
          <div class="formLab">说明：</div>
          <div class="formLabi">
           {%$dept->detail%}
            
          </div>
           <div class="h10 clearb"> </div>
           
          <div class="formLab">同步范围：</div>
          <div class="formLabi">
            <input name="toType" type="radio" id="toType" value="1" checked="checked" />
            
            仅此组织<br />
            <input type="radio" name="toType" id="toType" value="2" /> 导入所有所属子组织
            
</div>
           <div class="h10 clearb"> </div>
        