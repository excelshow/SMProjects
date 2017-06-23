 
       
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
            
            仅此组织根目录用户<br />
            <input type="radio" name="toType" id="toType" value="2" /> 
            导入所有子组织目录用户</div>
            <div class="h10 clearb"> </div>
           
          <div class="formLab">QQ段：</div>
          <div class="formLabi">
          <input name="qqs" type="text" class="inputText" /> - <input name="qqe" type="text" class="inputText" /> 
            </div>
           <div class="h10 clearb formLine"> </div>
            <div class="formLab">&nbsp;</div>
          <div class="formLabi">
        <input class="buttom" type="submit" name="submit" id="new_button" value=" 确定 " />
          <input class="a_close buttom" type="button" name="canceladd" id="canceladd" value="取消" />
          </div>