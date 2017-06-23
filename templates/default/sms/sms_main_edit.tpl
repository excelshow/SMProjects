{%include file="../header.tpl"%} 
 <script src="{%base_url()%}assets/javascript/jquery.select.js" type="text/javascript"></script> 
 <script type="text/javascript" src="{%base_url()%}assets/timepicker/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript">
    // JavaScript Document
 $(document).ready(function(){
 	 $('#check_time').datepicker({
		   dateFormat:"yy-mm-dd"

		});
	// //////////////////////////////////
	 $.ajax({
            type: "POST",
            url: "{%site_url('sms/sms/sms_category_select')%}",
            data: "root=1",
            dataType:'json',
            success: function(msg){
                //data = eval(msg); 
                $("#sms_select").citySelect({
				url:{"citylist": msg},
				prov:"{%$sms->cateid1%}",
				city:"{%$sms->cateid2%}",
				dist:"{%$sms->sms_cat_id%}",
				nodata:"None"
			});
												 
			}
        });
		
	 //form validator//////////////////////////////////////////////////////////////
	 
	  
	  var addjs = {
            rules: {
				 
              /*  sms_fee: {required: true,number:true},
				check_time:{dateISO:true}*/
            },
            messages: {
                
				/*sms_fee: {required: "",number: ""},
				check_time:{dateISO:""}*/
            },
			submitHandler : function(){
					 //表单的处理
					 var post_data = $("#smsaddform").serializeArray();
					 url = "{%site_url('sms/sms/sms_main_edit_com')%}";
					  
					 $.ajax({
						   type: "POST",
							  url: url,
							  async:false,
							  data:post_data,
							  success: function(msg){
								  
								  if (msg == 1 ){
									   jSuccess("Success, current page is being refreshed",{
										  VerticalPosition : 'center',
										  HorizontalPosition : 'center',
										  TimeShown : 1000,
									  });
									location.href = "{%$reurl%}";	
									 //setInterval(function(){window.location = "{%$reurl%}";},1000);	
								  }else{
									  jError("操作失败! ",{
										  VerticalPosition : 'center',
										  HorizontalPosition : 'center',
										  TimeShown : 1000,
									  });
								 }
							  }
						  });
					 return false;//阻止表单提交
				}
        };
 	$('#smsaddform').validate(addjs);
	
	////////////////////////////////////////////////////////////////////////////////////////	
	 

 });
    //]]>
   
</script>
 
 
<div id="showLayout" style="display:none;"></div>
<div class=""  style=" ">
  <div class="pad10">
    <div  class="pageTitleTop">资产管理 &raquo; 资产信息 &raquo; 修改资产信息</div>
    <div class="h10"></div>
    
    <!--begin form -->
    <div class="staffadd pad5 " style=" ">
      <div class="staffformInfo ">
        <form id="smsaddform" action="" method="post">
          <div  class="formLab">资产类别</div>
          <div  class="formcontrol"> 
           
            <div id="sms_select">
            <div  class="formLabi">
            <select class="prov inputText" name="sms_cate_1" ></select>
		  <select class="city inputText" name="sms_cate_2" disabled="disabled">
           
          </select>
          </div>
           <div  class="formLab">资产名称：</div>
          <div  class="formLabi">
		  <select class="dist inputText" name="sms_cate_3" id="sms_cate_3" disabled="disabled">
         
          </select>
          </div>
          <div  class="formLab">资产归属：</div>
          <div  class="formLabi">
		 	 <select class="inputText" name="sa_id" >
              {%foreach from=$smsAff item=rown%}
               <option value="{%$rown->sa_id %}"  {%if ($rown->sa_id == $sms->sa_id) %}  selected="selected" {%/if%} >
                
               {%$rown->sa_name %}
               
               </option>
               {%/foreach%}
              </select>
          </div>
            </div>
          
          </div>
           
          <div class=" formLine clearb"> </div>
          <div  class="formLab">资产信息</div>
          <div  class="formcontrol"> 
          <div  class="formLab">资产编号：</div>
          <div  class="formLabi">
            <input name="sms_number" id="sms_number"  class="inputTextRead" type="text" value="{%$sms->sms_number%}" size="20" maxlength="40"  />
          </div>
          <div  class="formLab">财务编号：</div>
          <div  class="formLabi">
            <input name="sms_sapnumber" id="sms_sapnumber"  class="inputTextRead" type="text" value="{%$sms->sms_sapnumber%}" size="20" maxlength="40"  />
          </div>
          <div  class="formLab">所在地：</div>
          <div  class="formLabi">
           <select class="inputText" name="sms_local" >
            {%foreach from=$smsLocal item=row%}
           		<option value="{%$row->sl_id%}" {%if ($row->sl_id == $sms->sms_local)%} selected="selected" {%/if%} >{%$row->sl_name%}</option>
            {%/foreach%}
           </select>
            <input name="sms_local_other" id="sms_local_other"  class="inputText" type="text" value="{%$sms->sms_local_other%}" size="20" maxlength="40"  />
          </div>
          <div class="clearb h10" ></div>
          
          <div  class="formLab">备注名称：</div>
          <div  class="formLabi">
            <input name="sms_bname" id="sms_bname"  class="inputText" type="text" value="{%$sms->sms_bname%}" size="20" maxlength="40"  />
            
          </div>
           <div  class="formLab">品牌：</div>
          <div  class="formLabi">
            
            <select class="inputText" name="sms_brand" style="width:153px;"  >
             <option value="0">无</option>
            {%foreach from=$smsBrand item=row%}
           		<option value="{%$row->sb_id%}" {%if ($row->sb_id == $sms->sms_brand)%} selected="selected" {%/if%}  >{%$row->sb_name%}</option>
            {%/foreach%}
           </select>
          </div>
          <div  class="formLab">规格：</div>
          <div  class="formLabi">
            <input name="sms_size" id="sms_size"  class="inputText" type="text" value="{%$sms->sms_size%}" size="20" maxlength="40"  />
            
          </div>
          <div class="clearb h10" ></div>
           <div  class="formLab">单位：</div>
          <div  class="formLabi" style="width:153px;">
            
             <select class="inputText" name="sms_unit" style="width:60px;" >
            <option class="select-cmd" value="台"  {%if ($sms->sms_unit == '台')%} selected="selected" {%/if%} >台</option>
            <option class="select-cmd" value="本" {%if ($sms->sms_unit == '本')%} selected="selected" {%/if%} >本</option>
            <option class="select-cmd" value="个" {%if ($sms->sms_unit == '个')%} selected="selected" {%/if%} >个</option>
            <option class="select-cmd" value="支" {%if ($sms->sms_unit == '支')%} selected="selected" {%/if%} >支</option>
            <option class="select-cmd" value="盒" {%if ($sms->sms_unit == '盒')%} selected="selected" {%/if%} >盒</option>
            <option class="select-cmd" value="张" {%if ($sms->sms_unit == '张')%} selected="selected" {%/if%} >张</option>
            <option class="select-cmd" value="包" {%if ($sms->sms_unit == '包')%} selected="selected" {%/if%} >包</option>
            <option class="select-cmd" value="块" {%if ($sms->sms_unit == '块')%} selected="selected" {%/if%} >块</option>
            <option class="select-cmd" value="筒" {%if ($sms->sms_unit == '筒')%} selected="selected" {%/if%} >筒</option>
            <option class="select-cmd" value="把" {%if ($sms->sms_unit == '把')%} selected="selected" {%/if%} >把</option>
            <option class="select-cmd" value="套" {%if ($sms->sms_unit == '套')%} selected="selected" {%/if%} >套</option>
            <option class="select-cmd" value="辆" {%if ($sms->sms_unit == '辆')%} selected="selected" {%/if%} >辆</option>
            <option class="select-cmd" value="卷" {%if ($sms->sms_unit == '卷')%} selected="selected" {%/if%} >卷</option>
            <option class="select-cmd" value="条" {%if ($sms->sms_unit == '条')%} selected="selected" {%/if%} >条</option>
            <option class="select-cmd" value="双" {%if ($sms->sms_unit == '双')%} selected="selected" {%/if%} >双</option>
            <option class="select-cmd" value="只" {%if ($sms->sms_unit == '只')%} selected="selected" {%/if%} >只</option>
            <option class="select-cmd" value="刀" {%if ($sms->sms_unit == '刀')%} selected="selected" {%/if%} >刀</option>
            <option class="select-cmd" value="节" {%if ($sms->sms_unit == '节')%} selected="selected" {%/if%} >节</option>
            <option class="select-cmd" value="箱" {%if ($sms->sms_unit == '箱')%} selected="selected" {%/if%} >箱</option>
            <option class="select-cmd" value="捆" {%if ($sms->sms_unit == '捆')%} selected="selected" {%/if%} >捆</option>
            <option class="select-cmd" value="瓶" {%if ($sms->sms_unit == '瓶')%} selected="selected" {%/if%} >瓶</option>
            <option class="select-cmd" value="提" {%if ($sms->sms_unit == '提')%} selected="selected" {%/if%} >提</option>
            <option class="select-cmd" value="米" {%if ($sms->sms_unit == '米')%} selected="selected" {%/if%} >米</option>
            <option class="select-cmd" value="根" {%if ($sms->sms_unit == '根')%} selected="selected" {%/if%} >根</option>
           </select>
          </div>
          <div  class="formLab">价格：</div>
          <div  class="formLabi">
           ￥ <input name="sms_fee" id="sms_fee"  class="inputText" type="text" value="{%$sms->sms_fee%}"   style="width:131px" />
            
          </div>
          <div  class="formLab">详细配置：</div>
          <div  class="formLabi">
            <input name="sms_detail" id="sms_detail"  class="inputText" type="text" value="{%$sms->sms_detail%}" size="29" maxlength="180"  />
            
          </div>
          <div class="clearb " ></div>
          </div>
          
            <div class=" formLine clearb"> </div>
          <div  class="formLab">版权信息</div>
          <div  class="formcontrol"> 
        

            <div  class="formLab">操作系统：</div>
          <div  class="formLabi">
            <input name="sms_cdkey" type="text" class="inputText" id="sms_cdkey" value="{%$sms->sms_cdkey%}" size="55" />
            
          </div>
           <div class="clearb h10" ></div>
           <div  class="formLab">Mind manager：</div>
          <div  class="formLabi">
            <input name="sms_cdkey1" type="text" class="inputText" id="sms_cdkey1" value="{%$sms->sms_cdkey1%}" size="55" />
            
          </div>
           <div class="clearb h10" ></div>
           <div  class="formLab">Office：</div>
          <div  class="formLabi">
            <input name="sms_cdkey2" type="text" class="inputText" id="sms_cdkey2" value="{%$sms->sms_cdkey2%}" size="55" />
            
          </div>
           <div class="clearb h10" ></div>
           <div  class="formLab">Corel DRAW：</div>
          <div  class="formLabi">
            <input name="sms_cdkey3" type="text" class="inputText" id="sms_cdkey3" value="{%$sms->sms_cdkey3%}" size="55" />
            
          </div>
           <div class="clearb h10" ></div>
           

 
 


		<div  class="formLab">Vision：</div>
          <div  class="formLabi">
            <input name="sms_cdkey4" type="text" class="inputText" id="sms_cdkey4" value="{%$sms->sms_cdkey4%}" size="55" />
            
          </div>
           <div class="clearb h10" ></div>
           <div  class="formLab">Photo shop：</div>
          <div  class="formLabi">
            <input name="sms_cdkey5" type="text" class="inputText" id="sms_cdkey5" value="{%$sms->sms_cdkey5%}" size="55" />
            
          </div>
           <div class="clearb h10" ></div>
           <div  class="formLab">Illustrator：</div>
          <div  class="formLabi">
            <input name="sms_cdkey6" type="text" class="inputText" id="sms_cdkey6" value="{%$sms->sms_cdkey6%}" size="55" />
            
          </div>
           <div class="clearb h10" ></div>
           <div  class="formLab">Auto CAD：</div>
          <div  class="formLabi">
            <input name="sms_cdkey7" type="text" class="inputText" id="sms_cdkey7" value="{%$sms->sms_cdkey7%}" size="55" />
            
          </div>
           <div class="clearb h10" ></div>
            <div  class="formLab">3D MAX：</div>
          <div  class="formLabi">
            <input name="sms_cdkey8" type="text" class="inputText" id="sms_cdkey8" value="{%$sms->sms_cdkey8%}" size="55" />
            
          </div>
           <div class="clearb h10" ></div>
            <div  class="formLab">MS SQL ：</div>
          <div  class="formLabi">
            <input name="sms_cdkey9" type="text" class="inputText" id="sms_cdkey9" value="{%$sms->sms_cdkey9%}" size="55" />
            
          </div>
           
           <div class="clearb h10" ></div>
          </div>
           <div class=" formLine clearb"> </div>
          <div  class="formLab">财务信息</div>
          <div  class="formcontrol"> 
           <div  class="formLab">发票日期：</div>
          <div  class="formLabi">
            <input name="check_time" id="check_time"  class="inputText" type="text" value="{%$sms->check_time%}" size="20"    />
            
          </div>
          <div  class="formLab">发票号：</div>
          <div  class="formLabi">
            <input name="check_number" id="check_number"  class="inputText" type="text" value="{%$sms->check_number%}" size="20" maxlength="40"  />
            
          </div>
          <div  class="formLab">发票抬头：</div>
          <div  class="formLabi">
            <input name="check_title" id="check_title"  class="inputText" type="text" value="{%$sms->check_number%}" size="20" maxlength="40"  />
            
          </div>
          </div>
          <div class="formLine clearb " ></div>
           <div  class="formLab">操作人</div>
          <div  class="formcontrol"> 
           <div  class="formLab">入库人：</div>
          <div  class="formLabi">
            <input name="sms_input" id="sms_input"  class="inputTextRead" readonly="readonly" type="text" value="{%$smarty.session.DX_username%}" size="20"    />
            
          </div>
          <div  class="formLab">入库时间：</div>
          <div  class="formLabi">
            <input name="sms_input_time" id="sms_input_time"  class="inputTextRead" type="text" value="{%date("Y-m-d")%}" size="20" maxlength="40"  />
            
          </div>
          </div>
          <div class="formLine clearb " ></div>
          <div  class="formLab">&nbsp;
           
          </div>
          <div class="formcontrol">
             <input   type="hidden" name="sms_id"  value="{%$sms->sms_id%}" />
            <input   type="submit"  class="buttom" value="提交完成" />
            &nbsp;&nbsp;
            <input type="button" value="放弃" onclick="javascript:history.go(-1);"   class="buttom" />
          </div>
        </form>
      </div>
      <div class="clearb"></div>
    </div>
    <!--end form --> 
    
  </div>
</div>
<script type="text/javascript">
    // JavaScript Document
 $(document).ready(function(){
	 
 });
 </script>
{%include file="../foot.tpl"%}