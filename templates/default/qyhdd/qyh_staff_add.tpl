 
       
          <div class="formLab">用户：</div>
          <div class="formLabi">
            {%$staff->cname%} {%$staff->itname%} 
            <input type="hidden" class="inputText" name="key" id="key" value="{%$staff->itname%} " />
            <input type="hidden" class="inputText" name="type" id="type" value="2" />
          </div>
               <div class="h10 clearb"> </div>
          
           
          <div class="formLab">手机号码：</div>
          <div class="formLabi">
            <input name="mobile" type="text" id="mobile" value="{%$staff->mobile%}"  class="inputText"  />
            
           </div>
            <div class="h10 clearb"> </div>
           
         
           <div class="h10 clearb formLine"> </div>
            <div class="formLab">&nbsp;</div>
          <div class="formLabi">
        <input class="buttom" type="submit" name="submit" id="new_button" value=" 确定 " />
          <input class="a_close buttom" type="button" name="canceladd" id="canceladd" value="取消" />
          </div>