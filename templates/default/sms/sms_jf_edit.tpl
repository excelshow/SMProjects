{%include file="../header.tpl"%} 
 <script src="{%base_url()%}assets/javascript/jquery.select.js" type="text/javascript"></script> 
 <script type="text/javascript" src="{%base_url()%}assets/timepicker/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript">
    // JavaScript Document
 $(document).ready(function(){
 	  
	// //////////////////////////////////
	 $.ajax({
            type: "POST",
            url: "{%site_url('sms/sms_jf/sms_jf_category_select')%}",
            data: "root=1",
            dataType:'json',
            success: function(msg){
                //data = eval(msg); 
                $("#sms_select").citySelect({
				url:{"citylist": msg},
				prov:"{%$data->cateid1%}",
				city:"{%$data->cateid2%}",
				dist:"{%$data->sms_cat_id%}",
				nodata:"None"
			});
												 
			}
        });
		
	 //form validator//////////////////////////////////////////////////////////////
	 
	  
	  var addjs = {
            rules: {
				 
                sms_number: {required: true}
            },
            messages: {
                 sms_number: {required: "资产编号必填！"}
            },
			submitHandler : function(){
					 //表单的处理
					 var post_data = $("#smsaddform").serializeArray();
					 url = "{%site_url('sms/sms_jf/sms_jf_edit_com')%}";
					  
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
									// location.href = "{%$reurl%}";	
									 setInterval(function(){window.location = "{%$reurl%}";},1000);	
								  }else{
									  jError("操作失败! ",{
										  VerticalPosition : 'center',
										  HorizontalPosition : 'center',
										  TimeShown : 1000,
									  });
								 }
							  },
							error:function(){
								hiAlert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
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
    <div  class="pageTitleTop">机房资产 &raquo; 资产信息 &raquo; 修改资产信息</div>
    <div class="h10"></div>
    
    <!--begin form -->
    <div class="staffadd pad5 " style=" ">
      <div class="staffformInfo ">
        <form id="smsaddform" action="" method="post">
          <div  class="formLab">资产类别</div>
          <div  class="formcontrol"> 
           
            <div id="sms_select">
            <div  class="formLabi">
            <select class="prov inputText" name="sms_cate_1" ></select> -
		  <select class="city inputText" name="sms_cate_2" disabled="disabled">
           
          </select> -
           <select class="dist inputText" name="sms_cate_3" id="sms_cate_3" disabled="disabled">
         
          </select>
          </div> 
          
            </div>
          
          </div>
           
          <div class=" formLine clearb"> </div>
          <div  class="formLab">资产信息</div>
          <div  class="formcontrol"> 
          <div  class="formLab">资产编号：</div>
          <div  class="formLabi">
            <input name="sms_number" id="sms_number"  class="inputText" type="text" value="{%$data->sms_number%}" size="20" maxlength="40"  />
          </div>
          <div  class="formLab">财务编号：</div>
          <div  class="formLabi">
            <input name="sms_sapnumber" id="sms_sapnumber"  class="inputText" type="text" value="{%$data->sms_sapnumber%}" size="20" maxlength="40"  />
          </div>
          
          <div class="clearb h10" ></div>
          
          <div  class="formLab">名称：</div>
          <div  class="formLabi">
            <input name="sms_name" id="sms_name"  class="inputText" type="text" value="{%$data->sms_name%}" size="20" maxlength="40"  />
            
          </div>
            <div  class="formLab">品牌：</div>
          <div  class="formLabi">
             <input name="sms_brand" id="sms_brand"  class="inputText" type="text" value="{%$data->sms_brand%}" size="20" maxlength="40"  />
          </div>
           <div class="clearb h10" ></div>
          
         
          <div  class="formLab">规格：</div>
          <div  class="formLabi">
            <input name="sms_size" id="sms_size"  class="inputText" type="text" value="{%$data->sms_size%}" size="20" maxlength="40"  />
            
          </div> 
           <div  class="formLab">单位：</div>
          <div  class="formLabi" style="width:153px;">
            
             <select class="inputText" name="sms_unit" style="width:60px;" >
            <option class="select-cmd" value="台"  {%if ($data->sms_unit == '台')%} selected="selected" {%/if%} >台</option>
            <option class="select-cmd" value="本" {%if ($data->sms_unit == '本')%} selected="selected" {%/if%} >本</option>
            <option class="select-cmd" value="个" {%if ($data->sms_unit == '个')%} selected="selected" {%/if%} >个</option>
            <option class="select-cmd" value="支" {%if ($data->sms_unit == '支')%} selected="selected" {%/if%} >支</option>
            <option class="select-cmd" value="盒" {%if ($data->sms_unit == '盒')%} selected="selected" {%/if%} >盒</option>
            <option class="select-cmd" value="张" {%if ($data->sms_unit == '张')%} selected="selected" {%/if%} >张</option>
            <option class="select-cmd" value="包" {%if ($data->sms_unit == '包')%} selected="selected" {%/if%} >包</option>
            <option class="select-cmd" value="块" {%if ($data->sms_unit == '块')%} selected="selected" {%/if%} >块</option>
            <option class="select-cmd" value="筒" {%if ($data->sms_unit == '筒')%} selected="selected" {%/if%} >筒</option>
            <option class="select-cmd" value="把" {%if ($data->sms_unit == '把')%} selected="selected" {%/if%} >把</option>
            <option class="select-cmd" value="套" {%if ($data->sms_unit == '套')%} selected="selected" {%/if%} >套</option>
            <option class="select-cmd" value="辆" {%if ($data->sms_unit == '辆')%} selected="selected" {%/if%} >辆</option>
            <option class="select-cmd" value="卷" {%if ($data->sms_unit == '卷')%} selected="selected" {%/if%} >卷</option>
            <option class="select-cmd" value="条" {%if ($data->sms_unit == '条')%} selected="selected" {%/if%} >条</option>
            <option class="select-cmd" value="双" {%if ($data->sms_unit == '双')%} selected="selected" {%/if%} >双</option>
            <option class="select-cmd" value="只" {%if ($data->sms_unit == '只')%} selected="selected" {%/if%} >只</option>
            <option class="select-cmd" value="刀" {%if ($data->sms_unit == '刀')%} selected="selected" {%/if%} >刀</option>
            <option class="select-cmd" value="节" {%if ($data->sms_unit == '节')%} selected="selected" {%/if%} >节</option>
            <option class="select-cmd" value="箱" {%if ($data->sms_unit == '箱')%} selected="selected" {%/if%} >箱</option>
            <option class="select-cmd" value="捆" {%if ($data->sms_unit == '捆')%} selected="selected" {%/if%} >捆</option>
            <option class="select-cmd" value="瓶" {%if ($data->sms_unit == '瓶')%} selected="selected" {%/if%} >瓶</option>
            <option class="select-cmd" value="提" {%if ($data->sms_unit == '提')%} selected="selected" {%/if%} >提</option>
            <option class="select-cmd" value="米" {%if ($data->sms_unit == '米')%} selected="selected" {%/if%} >米</option>
            <option class="select-cmd" value="根" {%if ($data->sms_unit == '根')%} selected="selected" {%/if%} >根</option>
           </select>
          </div>
            <div class="clearb h10" ></div>
          
          <div  class="formLab">配置说明：</div>
          <div  class="formLabi">
            <textarea name="sms_detail" cols="55" rows="5" class="inputText" id="sms_detail">{%$data->sms_detail%}</textarea>
            
          </div>
          
          </div> 
         
          <div class="formLine clearb " ></div>
           <div  class="formLab">操作人</div>
          <div  class="formcontrol"> 
           <div  class="formLab">入库人：</div>
          <div  class="formLabi">
            <input name="input_itname" id="input_itname"  class="inputTextRead" readonly="readonly" type="text" value="{%$smarty.session.DX_username%}" size="20"    />
            
          </div>
          <div  class="formLab">入库时间：</div>
          <div  class="formLabi">
            <input name="input_time" id="input_time"  class="inputTextRead" type="text" value="{%date("Y-m-d H:i:s")%}" size="20" maxlength="40"  />
            
          </div>
          </div>
          <div class="formLine clearb " ></div>
          <div  class="formLab">&nbsp;
           
          </div>
          <div class="formcontrol">
             <input   type="hidden" name="sms_id"  value="{%$data->sms_id%}" />
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