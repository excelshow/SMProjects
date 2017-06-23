 
   <div class="staffadd pad5 " style="  ">
    
    <!--begin form -->
    <div class="staffformInfo ">
   		  <input name="sc_root" id="sc_root" type="hidden" value="" />
          <input name="sc_id" id="sc_id" type="hidden" value="{%$data->sc_id%}" />
            <div  class="formLab">资产类别:</div>
          <div  class="formLabt">
          	<select name="sc_type"  class="inputText">
          	  <option value="1" {%if ($data->sc_type==1)%} selected="selected" {%/if%} >固定资产</option>
              <option value="2" {%if ($data->sc_type==2)%} selected="selected" {%/if%} >耗材资产</option>
            </select> 
          </div>
     
          <div class="h10 clearb"> </div>
          <div  class="formLab">类别名称:</div>
          <div  class="formLabt"> <input name="sc_name"  class="inputText" type="text" id="sc_name"  value="{%$data->sc_name%}" /></div>
     
          <div class="h10 clearb"> </div>
          <div  class="formLab">排序:</div>
          <div  class="formLabt"><input name="sc_sort"  class="inputText" type="text" id="sc_sort"  value="{%$data->sc_sort%}" /></div>
          <div class="h10 clearb"> </div>
          <div  class="formLab">同步系统:</div>
          <div  class="formLabi"><input name="tooa" type="checkbox" checked="checked"   value="1" /> OA系统</div>
          <div class="h10 clearb"> </div>
          
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