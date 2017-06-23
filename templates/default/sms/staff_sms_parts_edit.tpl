 
    
    
    <!--begin form -->
    <div class="staffadd pad5 " style=" ">
      <div class="staffformInfo ">
           
          <div  class="formLab">使用人：</div>
          <div  class="formcontrol">  
          <div  class="formLabi"> {%$data->cname%}-{%$data->itname%}            {%$data->deptName%}</div>
          </div>
           <div class=" formLine clearb"> </div>
          <div  class="formLab">配件详细</div>
          <div  class="formcontrol"> 
           <div  class="formLab">编号：</div>
          <div  class="formLabi">
            {%$data->sp_number%}
          </div> <div class="clearb  "></div>
          <div  class="formLab">名称：</div>
          <div  class="formLabi">
            {%$data->part%} 
            
          </div>
          <div class="clearb"></div>
           <div  class="formLab">当前数量：</div>
          <div  class="formLabi">
            {%$data->ss_total%} 
            
          </div>
          
          <div class="clearb  "></div>
          </div>
               <div class=" formLine clearb"> </div>
          <div  class="formLab">编辑</div>
          <div  class="formcontrol"> 
           <div  class="formLab">操作：</div>
          <div  class="formLabi">
             <input name="type" type="radio" value="1" checked="checked" />领用
             <input name="type" type="radio" value="2" />归还
          </div> <div class="clearb h10"></div>
          <div  class="formLab">数量：</div>
          <div  class="formLabi">
            <input name="number" type="text" class="inputText" size="4" />
          </div>
           <div class="clearb h10"></div>
          <div  class="formLab">备注：</div>
          <div  class="formLabi">
            <textarea name="ss_remark" cols="30" class="inputText">{%$data->ss_remark%}</textarea>
          </div>
          <div class="clearb "></div>
          </div>
           
          <div class="formLine clearb " ></div>
          <div  class="formLab">&nbsp;
           
          </div>
          <div class="formcontrol">
             <input name="ss_id" id="ss_id"  class="inputText" type="hidden" value="{%$data->ss_id%}" size="20" maxlength="40"  />
            <input   type="submit"  class="buttom" value="提交完成" />
            &nbsp;&nbsp;
            <input type="button" value="放弃"  class="buttom a_close" />
          </div>
       </div>
      <div class="clearb"></div> 
    <!--end form --> 
  