 
    
    
    <!--begin form -->
    <div class="staffadd pad5 " style=" ">
      <div class="staffformInfo ">
           
          <div  class="formLab">资产类别</div>
          <div  class="formcontrol"> 
            
            <select class="inputText" name="spc_id" >
          {%foreach from=$category item=rown%}
           <option value="{%$rown->spc_id %}" {%if $rown->spc_id == $data->spc_id%} selected="selected" {%/if%}   >
            
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
            {%$data->sp_number%} 
            <input name="sp_number" id="sp_number"  class="inputText" type="hidden" value="{%$data->sp_number%}" size="20"    />
          </div>
          <div class="clearb h10"></div>
          <div  class="formLab">名称：</div>
          <div  class="formLabi">
            <input name="sp_name" id="sp_name"  class="inputText" type="text" value="{%$data->sp_name%}" size="20" maxlength="40"  />
            
          </div>
          <div class="clearb h10"></div>
           <div  class="formLab">数量：</div>
          <div  class="formLabi">
            <input name="sp_total" id="sp_total"  class="inputText" type="text" value="{%$data->sp_total%}" size="20" maxlength="40"  />
            
          </div>
          <div class="clearb h10"></div>
          <div  class="formLab">仓库：</div>
          <div  class="formLabi">
            <input name="sp_ck" id="sp_ck"  class="inputText" type="text" value="{%$data->sp_ck%}" size="20" maxlength="40"  />
            
          </div>
          <div class="clearb h10"></div>
          <div  class="formLab">所在地：</div>
          <div  class="formLabi">
            <input name="sp_local" id="sp_local"  class="inputText" type="text" value="{%$data->sp_local%}" size="20" maxlength="40"  />
            
          </div>
          <div class="clearb h10"></div>
          </div>
           
          <div class="formLine clearb " ></div>
          <div  class="formLab">&nbsp;
           
          </div>
          <div class="formcontrol">
             <input name="sp_id" id="sp_id"  class="inputText" type="hidden" value="{%$data->sp_id%}" size="20" maxlength="40"  />
            <input   type="submit"  class="buttom" value="提交完成" />
            &nbsp;&nbsp;
            <input type="button" value="放弃"  class="buttom a_close" />
          </div>
       </div>
      <div class="clearb"></div> 
    <!--end form --> 
  