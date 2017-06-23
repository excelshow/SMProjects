 
    
    
    <!--begin form -->
    <div class="staffadd pad5 " style=" ">
      <div class="staffformInfo ">
           
          <div  class="formLab">资产类别</div>
          <div  class="formcontrol"> 
            
            <select class="inputText" name="spc_id" >
          {%foreach from=$category item=rown%}
           <option value="{%$rown->spc_id %}"   >
            
           {%$rown->spc_name %}
           
           </option>
           {%/foreach%}
          </select>
           
          </div>
           <div class=" formLine clearb"> </div>
          <div  class="formLab">配件详细</div>
          <div  class="formcontrol"> 
           <div  class="formLab">编号：</div>
          <div  class="formLabi">
            <input name="sp_number" id="sp_number"  class="inputText" type="text" value="" size="20"    />
            
          </div>
          <div class="clearb h10"></div>
          <div  class="formLab">名称：</div>
          <div  class="formLabi">
            <input name="sp_name" id="sp_name"  class="inputText" type="text" value="" size="20" maxlength="40"  />
            
          </div>
          <div class="clearb h10"></div>
           <div  class="formLab">数量：</div>
          <div  class="formLabi">
            <input name="sp_total" id="sp_total"  class="inputText" type="text" value="" size="20" maxlength="40"  />
            
          </div>
          <div class="clearb h10"></div>
          <div  class="formLab">仓库：</div>
          <div  class="formLabi">
            <input name="sp_ck" id="sp_ck"  class="inputText" type="text" value="" size="20" maxlength="40"  />
            
          </div>
          <div class="clearb h10"></div>
          <div  class="formLab">所在地：</div>
          <div  class="formLabi">
            <input name="sp_local" id="sp_local"  class="inputText" type="text" value="" size="20" maxlength="40"  />
            
          </div>
          <div class="clearb h10"></div>
          </div>
           
          <div class="formLine clearb " ></div>
          <div  class="formLab">&nbsp;
           
          </div>
          <div class="formcontrol">
            
            <input   type="submit"  class="buttom" value="提交完成" />
            &nbsp;&nbsp;
            <input type="button" value="放弃"  class="buttom a_close" />
          </div>
       </div>
      <div class="clearb"></div> 
    <!--end form --> 
  