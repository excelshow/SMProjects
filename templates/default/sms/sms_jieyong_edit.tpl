    <!--begin form -->
    <div class="staffadd pad5 " style=" ">
      <div class="staffformInfo ">
           
          <div  class="formLab">资产类别</div>
          <div  class="formcontrol"> 
            
            <select class="inputText" name="spc_id" >
            
              <option value="1" {%if $data->spc_id == 1%} selected="selected" {%/if%}  >笔记本</option> 
           <option value="2"  {%if $data->spc_id == 2%} selected="selected" {%/if%}   >其他</option> 
          
           </option> 
          </select>
           
          </div>
           <div class=" formLine clearb"> </div>
          <div  class="formLab">配件详细</div>
          <div  class="formcontrol"> 
           <div  class="formLab">编号：</div>
          <div  class="formLabi">
            {%$data->sj_number%} 
            <input name="sj_number" id="sj_number"  class="inputText" type="hidden" value="{%$data->sj_number%}" size="20"    />
          </div>
          <div class="clearb h10"></div>
          <div  class="formLab">名称：</div>
          <div  class="formLabi">
            <input name="sj_name" id="sj_name"  class="inputText" type="text" value="{%$data->sj_name%}" size="20" maxlength="40"  />
            
          </div>
          <div class="clearb h10"></div>
            
          <div  class="formLab">仓库：</div>
          <div  class="formLabi">
            <input name="sj_ck" id="sj_ck"  class="inputText" type="text" value="{%$data->sj_ck%}" size="20" maxlength="40"  />
            
          </div>
          <div class="clearb h10"></div>
          <div  class="formLab">所在地：</div>
          <div  class="formLabi">
            <input name="sj_local" id="sj_local"  class="inputText" type="text" value="{%$data->sj_local%}" size="20" maxlength="40"  />
            
          </div>
          <div class="clearb h10"></div>
          </div>
           
          <div class="formLine clearb " ></div>
          <div  class="formLab">&nbsp;
           
          </div>
          <div class="formcontrol">
             <input name="sj_id" id="sj_id"  class="inputText" type="hidden" value="{%$data->sj_id%}" size="20" maxlength="40"  />
            <input   type="submit"  class="buttom" value="提交完成" />
            &nbsp;&nbsp;
            <input type="button" value="放弃"  class="buttom a_close" />
          </div>
       </div>
      <div class="clearb"></div> 
    <!--end form --> 
  