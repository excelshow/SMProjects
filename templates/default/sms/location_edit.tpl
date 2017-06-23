  <script type="text/javascript">
    // JavaScript Document
 $(document).ready(function(){
 
 });
 </script>
   <div class="staffadd pad5 " style="  ">
    
    <!--begin form -->
    <div class="staffformInfo fleft">
   		  
          <input name="sl_id" id="sl_id" type="hidden" value="{%$data->sl_id%}" />
          <div  class="formLab">地点名称:</div>
          <div  class="formLabt"> <input name="sl_name"  class="inputText" type="text" id="sl_name"  value="{%$data->sl_name%}" /></div>
     
          <div class="h10 clearb"> </div>
          <div  class="formLab">排序:</div>
          <div  class="formLabt"><input name="sl_sort"  class="inputText" type="text" id="sl_sort"  value="{%$data->sl_sort%}" /></div>
         
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