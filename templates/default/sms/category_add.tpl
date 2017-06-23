   <div class="staffadd pad5 " style="  ">
    
    <!--begin form -->
    <div class="staffformInfo ">
   		  <input name="sc_root" id="sc_root" type="hidden" value="{%$sc_root%}" />
      <input name="id" id="id" type="hidden"  />
       <div  class="formLab">资产类别:</div>
          <div  class="formLabt">
          	<select name="sc_type" class="inputText">
          	  <option value="1">固定资产</option>
              <option value="2">耗材资产</option>
            </select> 
          </div>
     
          <div class="h10 clearb"> </div>
          <div  class="formLab">资产名称:</div>
          <div  class="formLabt"> <input name="sc_name"  class="inputText" type="text" id="sc_name"   /></div>
     
          <div class="h10 clearb"> </div>
          <div  class="formLab">排序:</div>
          <div  class="formLabt"><input name="sc_sort" type="text"  class="inputText" id="sc_sort" value="1"   /></div>
           <div class="h10 clearb"> </div>
          <div  class="formLab">同步系统:</div>
          <div  class="formLabi"><input name="tooa" type="checkbox" checked="checked"    value="1" /> OA系统</div>
          <div class="  clearb"> </div>
          
          <div class="formLine clearb " ></div>
          <div  class="formLab">&nbsp;</div>
          <div class="formcontrol">
            
           
            <input name="addcomplete" class="buttom" type="submit" value="提交完成" />
            &nbsp;&nbsp;
            <input type="button" onclick=" " class="a_close buttom" value="放弃" />
          </div>
      
    </div>
    <div class=" clearb"> </div>
    </div>
    <!--end form --> 