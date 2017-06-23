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
				url:{"citylist": msg
				},
				prov:"",
				city:"",
				dist:"",
				nodata:"none"
			});
												 
			}
        });
		
	 //form validator//////////////////////////////////////////////////////////////
	 
	  
	 
	  var addjs = {
            rules: {
			 
            },
            messages: {
                
            },
			submitHandler : function(){
					 //表单的处理
					 var post_data = $("#smsaddform").serializeArray();
					 url = "{%site_url('sms/sms/sms_main_add_com_bitch')%}";
					  
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
									 //setInterval(function(){location.href = "{%$reurl%}";},1000);	
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
    <div  class="pageTitleTop">资产管理 &raquo; 资产信息 &raquo; 新增资产信息</div>
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
		  <select class="city inputText" name="sms_cate_2" disabled="disabled"></select>
          </div>
           <div  class="formLab">资产名称：</div>
          <div  class="formLabi">
		  <select class="dist inputText" name="sms_cate_3" disabled="disabled"></select>
          </div>
       		 <div  class="formLab">资产归属：</div>
          <div  class="formLabi">
		  <select class="inputText" name="sa_id" >
          {%foreach from=$smsAff item=rown%}
           <option value="{%$rown->sa_id %}"   >
            
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
            <textarea name="sms_number" cols="80" rows="3" class="inputText" id="sms_number"></textarea><br />

            输入:T000001,T000002,T000003,.....

          </div>
           <div class="clearb h10" ></div>
          <div  class="formLab">财务编号：</div>
          <div  class="formLabi">
            <textarea name="sms_sapnumber" cols="80" rows="3" class="inputText" id="sms_sapnumber"></textarea><br />

            输入120000008495,120000008496,120000008497,... 无财务编号输入空。。

          </div>
           <div class="clearb h10" ></div>
          <div  class="formLab">所在地：</div>
          <div  class="formLabi">
           <select class="inputText" name="sms_local" >
            {%foreach from=$smsLocal item=row%}
           		<option value="{%$row->sl_id%}">{%$row->sl_name%}</option>
            {%/foreach%}
           </select>
            <input name="sms_local_other" id="sms_local_other"  class="inputText" type="text" value="" size="20" maxlength="40"  />
          </div>
          <div class="clearb h10" ></div>
          
          <div  class="formLab">备注名称：</div>
          <div  class="formLabi">
            <input name="sms_bname" id="sms_bname"  class="inputText" type="text" value="" size="20" maxlength="40"  />
            
          </div>
           <div  class="formLab">品牌：</div>
          <div  class="formLabi">
            
             <select class="inputText" name="sms_brand" style="width:153px;" >
             <option value="0">无</option>
            {%foreach from=$smsBrand item=row%}
           		<option value="{%$row->sb_id%}">{%$row->sb_name%}</option>
            {%/foreach%}
           </select>
          </div>
          <div  class="formLab">规格：</div>
          <div  class="formLabi">
            <input name="sms_size" id="sms_size"  class="inputText" type="text" value="" size="20" maxlength="40"  />
            
          </div>
          <div class="clearb h10" ></div>
           <div  class="formLab">单位：</div>
          <div  class="formLabi" style="width:153px;">
            
             <select class="inputText" name="sms_unit" style="width:60px;" >
            <option class="select-cmd" value="台">台</option>
            <option class="select-cmd" value="本">本</option>
            <option class="select-cmd" value="个">个</option>
            <option class="select-cmd" value="支">支</option>
            <option class="select-cmd" value="盒">盒</option>
            <option class="select-cmd" value="张">张</option>
            <option class="select-cmd" value="包">包</option>
            <option class="select-cmd" value="块">块</option>
            <option class="select-cmd" value="筒">筒</option>
            <option class="select-cmd" value="把">把</option>
            <option class="select-cmd" value="套">套</option>
            <option class="select-cmd" value="辆">辆</option>
            <option class="select-cmd" value="卷">卷</option>
            <option class="select-cmd" value="条">条</option>
            <option class="select-cmd" value="双">双</option>
            <option class="select-cmd" value="只">只</option>
            <option class="select-cmd" value="刀">刀</option>
            <option class="select-cmd" value="节">节</option>
            <option class="select-cmd" value="箱">箱</option>
            <option class="select-cmd" value="捆">捆</option>
            <option class="select-cmd" value="瓶">瓶</option>
            <option class="select-cmd" value="提">提</option>
            <option class="select-cmd" value="米">米</option>
            <option class="select-cmd" value="根">根</option>
           </select>
          </div>
          <div  class="formLab">价格：</div>
          <div  class="formLabi">
           ￥ <input name="sms_fee" id="sms_fee"  class="inputText" type="text" value=""   style="width:131px" />
            
          </div>
          <div  class="formLab">详细配置：</div>
          <div  class="formLabi">
            <input name="sms_detail" id="sms_detail"  class="inputText" type="text" value="" size="29" maxlength="180"  />
            
          </div>
          <div class="clearb " ></div>
          
          </div>
           <div class=" formLine clearb"> </div>
          <div  class="formLab">版权信息</div>
          <div  class="formcontrol"> 
           
          <div  class="formLabi">
            <textarea name="sms_cdkey" cols="80" rows="2" class="inputText" id="sms_cdkey"></textarea>
            
          </div>
          </div>
           <div class=" formLine clearb"> </div>
          <div  class="formLab">财务信息</div>
          <div  class="formcontrol"> 
           <div  class="formLab">发票日期：</div>
          <div  class="formLabi">
            <input name="check_time" id="check_time"  class="inputText" type="text" value="" size="20"    />
            
          </div>
          <div  class="formLab">发票号：</div>
          <div  class="formLabi">
            <input name="check_number" id="check_number"  class="inputText" type="text" value="" size="20" maxlength="40"  />
            
          </div>
           <div  class="formLab">发票抬头：</div>
          <div  class="formLabi">
            <input name="check_title" id="check_title"  class="inputText" type="text" value="" size="20" maxlength="40"  />
            
          </div>
          </div>
          <div class="formLine clearb " ></div>
           <div  class="formLab">操作人</div>
          <div  class="formcontrol"> 
           <div  class="formLab">入库人：</div>
          <div  class="formLabi">
            <input name="sms_input" id="sms_input"  class="inputTextRead"  type="text" value="" size="20"    />
            
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
{%include file="../foot.tpl"%}