{%include file="../header.tpl"%} 
 <script src="{簊e_url()%}assets/javascript/jquery.select.js" type="text/javascript"></script> 
<script type="text/javascript">
    // JavaScript Document
 $(document).ready(function(){
 
	// //////////////////////////////////
	  
	 
		 

 });
    //]]>
   
</script>
 
 
<div id="showLayout" style="display:none;"></div>
<div class=""  style=" ">
  <div class="pad10">
    <div  class="pageTitleTop">资产管理 &raquo; 资产信息 &raquo; 新增资产</div>
    <div class="h10"></div>
    
    <!--begin form -->
    <div class="staffadd pad5 " style=" ">
      <div class="staffformInfo ">
        <form id="smsaddform" action="" method="post">
          <div  class="formLab">资产类别</div>
          <div  class="formcontrol"> 
           
            <div id="">
            <select class="inputText" id="sms_cate_1">
            
            </select>
		  	<select class="inputText" id="sms_cate_2" ></select>
		  	<select class="inputText" id="sms_cate_3" ></select>
            <script type="text/javascript">
						
						$(function(){ 
						$.ajax({
								type: "POST",
								url: "{%site_url('sms/sms_category_list')%}",
								data: "sc_id="+1,
								dataType:'json',
								success: function(json){
									// alert(json);
									 $("option",$("#sms_cate_1")).remove(); //清空原有的选项
									 $.each(json,function(index,array){ 
									
									var option = "<option value='"+array['sc_id']+"'>"+array['sc_name']+"</option>"; 
									$("#sms_cate_1").append(option); 
								}); 
								},
								// complete: function() { alert("complete"); }   
							});
							getSelectVal(); 
							getSelectValEnd();
							$("#sms_cate_1").change(function(){ 
								getSelectVal(); 
								getSelectValEnd();
							}); 
						}); 
						function getSelectVal(){
							$.ajax({
								type: "POST",
								url: "{%site_url('sms/sms_category_list')%}",
								data: "sc_id="+$("#sms_cate_1").val(),
								dataType:'json',
								success: function(json){
									 
									 $("option",$("#sms_cate_2")).remove(); //清空原有的选项
									 $.each(json,function(index,array){ 
									
									var option = "<option value='"+array['sc_id']+"'>"+array['sc_name']+"</option>"; 
									$("#sms_cate_2").append(option); 
								}); 
								},
								// complete: function() { alert("complete"); }   
							}); 
						} 
						function getSelectValEnd(){
							$.ajax({
								type: "POST",
								url: "{%site_url('sms/sms_category_list')%}",
								data: "sc_id="+$("#sms_cate_2").val(),
								dataType:'json',
								success: function(json){
									 
									 $("option",$("#sms_cate_3")).remove(); //清空原有的选项
									 $.each(json,function(index,array){ 
									
									var option = "<option value='"+array['sc_id']+"'>"+array['sc_name']+"</option>"; 
									$("#sms_cate_3").append(option); 
								}); 
								},
								// complete: function() { alert("complete"); }   
							});
							 
						} 
						</script>
            </div>
          
          </div>
          <div class=" clearb"> </div>
          <div id="staffshow" style="display:none;">
           <div class="h10"></div>
          <div  class="formLab">&nbsp;</div>
          
          <div  class="formcontrol" >  
                <div  class="formLab">详细：</div>
                <div  class="formLabi">
                	<span id="cname"></span>
                </div>
                  <div class="clearb h10"> </div>
                 <div  class="formLab">部门闲置：</div>
                	<div id="sms_dept"  class="formLabi">
                	  
                </div>
          </div>
          </div>
          <div class=" formLine clearb"> </div>
          <div  class="formLab">资产信息</div>
          <div  class="formcontrol"> 
          <div  class="formLab">主机编号：</div>
          <div  class="formLabi">
            <input name="sms_number1" id="sms_number1"  class="inputText" type="text" value="" size="20" maxlength="40"  />
            <span id="sms_mian1">
            </span>
          </div>
          <div class="clearb h10" ></div>
           <div  class="formLab">显示器：</div>
          <div  class="formLabi">
            <input name="sms_number2" id="sms_number2"  class="inputText" type="text" value="" size="20" maxlength="40"  />
            <span id="sms_mian2"></span>
          </div>
          <div class="clearb h10" ></div>
           <div  class="formLab">其他设备：</div>
          <div  class="formLabi">
            <input name="sms_number3" id="sms_number3"  class="inputText" type="text" value="" size="20" maxlength="40"  />
            <span id="sms_mian3"></span>
          </div>
          <div class="clearb " ></div>
          </div>
           <div class=" formLine clearb"> </div>
          <div  class="formLab">使用类别</div>
          <div  class="formcontrol"> 
           <input name="sm_type" type="radio" id="sm_type" value="1" checked="checked" />领用
            &nbsp;&nbsp;
            <input type="radio" name="sm_type" id="sm_type" value="2" />借用
          </div>
          <div class="formLine clearb " ></div>
          <div  class="formLab">&nbsp;
           
          </div>
          <div class="formcontrol">
            <input name="action" type="hidden" value="" />
            <input name="addcomplete" type="submit"  class="buttom" value="提交完成" />
            &nbsp;&nbsp;
            <input type="button" value="放弃"   class="buttom" />
          </div>
        </form>
      </div>
      <div class="clearb"></div>
    </div>
    <!--end form --> 
    
  </div>
</div>
{%include file="../foot.tpl"%}