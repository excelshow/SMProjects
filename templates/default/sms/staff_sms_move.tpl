{%include file="../header.tpl"%} 
<script type="text/javascript">
    // JavaScript Document
 $(document).ready(function(){
	// $('#smsmoveform').validate(addjs);
	
	 var addjs = {
	        rules: {
				itname:{required: true,remote:{
								url: "{%site_url('sms/sms/staff_main_check')%}/"+$("#itname").val(),
								type: "post",
								async:false,
								dataType:"json", 
							//alert($("#useremail").html());
								data: {
									   itname: function () {
                                 	   return $("#itname").val();  
                               		 }
								} 
							}
				},
				sm_remark:{required: true}
			},
			messages: {
                itname:{required: "用户登录帐号必填",remote:"无此登录帐号，请确认用户登录帐号"},
				sm_remark:{required: "输入OA流程地址"}
			},
			submitHandler : function(){
				 //表单的处理
				  
					 var post_data = $("#smsmoveform").serializeArray();
					 url = "{%site_url('sms/sms/staff_sms_move_com')%}";
					 $.ajax({
						   type: "POST",
							  url: url,
							  async:false,
							  data:post_data,
							  success: function(msg){
								  
								  if (msg == 1 ){
									   jSuccess("操作成功!正在刷新页面，请稍候...",{
										  VerticalPosition : 'center',
										  HorizontalPosition : 'center',
										  TimeShown : 1000,
									  });
									 
									 setInterval(function(){window.location.reload();},1000);	
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
	 $('#smsmoveform').validate(addjs);
	/*
		locading deptIp
	*/
	function loadIp(){
		var itname = $("#itname").val();
		if(itname){
		  $.ajax({
						   type: "POST",
							  url: "{%site_url('sms/sms/staffIpcheck')%}",
							  async:false,
							  data:"itname="+itname,
							  success: function(msg){
								  
								  if (msg == 0 ){
									  jError("操作失败! ",{
										  VerticalPosition : 'center',
										  HorizontalPosition : 'center',
										  TimeShown : 1000,
									  });
								  }else{
									   $("#ip1").val(msg);
									   $("#show_ip1").html(msg);
								 }
							  }
						  });
		}
	}
	///////////////////////////////
 	// function autocomplete end	
			 $.ajax({
                    type: "POST",
                    url: "{%site_url('staff/staff/staffAllJason')%}",
					async:false, 
					dataType: "json",//返回json格式的数据
                    success: function(msg){
						//alert(msg);
  						$( "#itname" ).autocomplete({
								source:  msg ,
								focus: function( event, ui ) {
											$( "#itname" ).val( ui.item.label );
											return false;
										},
								select: function( event, ui ) {
											$( "#itname" ).val( ui.item.label );
											$( "#cname" ).html( ui.item.value );
											$( "#staffshow" ).show();
										     $.ajax({
													type: "POST",
													url: "{%site_url('sms/sms/deptSmsList')%}",
													async:false, 
												 	data:"itname="+ui.item.label,
													success: function(note){
														//alert(note);
														loadIp();
														$( "#sms_dept" ).html( note );
														
													}
												});
												return false;
										}
						}).data( "autocomplete" )._renderItem = function( ul, item ) {
							return $( "<li>" )
							.data( "item.autocomplete", item )
							.append( "<a>" + item.label + "<br>" + item.value + "</a>" )
							.appendTo( ul );
							};
                    }
                });
			 
		 // function autocomplete end
		 
 });
    //]]>
   
</script>
<div id="showLayout" style="display:none;"></div>
<div class=""  style=" ">
  <div class="pad10">
    <div  class="pageTitleTop">资产管理 &raquo; 资产管理 &raquo; 新增用户资产</div>
    <div class="h10"></div>
    
    <!--begin form -->
    <div class="staffadd pad5 " style=" ">
      <div class="staffformInfo ">
<form  id="smsmoveform" name="smsmoveform"  >	 
<div class=""  style=" ">
  <div  >
   
    
    <!--begin form -->
    
      <div class="staffformInfo ">
         
        
          <div  class="formLab">资产信息</div>
          <div  class="formcontrol"> 
          <div  class="formLab">编号：</div>
          <div  class="formLabi">
          <input name="sms_number" id="sms_number" type="hidden" value="{%$staff_sms->sms_number%}" readonly="readonly" />
           {%$staff_sms->sms_number%} &nbsp;&nbsp;&nbsp;&nbsp; {%$smsCate->sc_name%}&nbsp;&nbsp;&nbsp;&nbsp;{%$staff_sms->sms_ip%} 
          </div>
          <div class="clearb h10" ></div>
           <div  class="formLab">详细：</div>
          <div  class="formLabi">
            {%$sms_main->sms_size%}&nbsp;&nbsp;&nbsp;&nbsp; {%$sms_main->sms_cat_id%}&nbsp;&nbsp;&nbsp;&nbsp; {%$sms_main->sms_type%}&nbsp;&nbsp;&nbsp;&nbsp;￥{%$sms_main->sms_fee%}
          </div>
          
          <div class="clearb " ></div>
          </div>
           <div class=" formLine clearb"> </div>
             <div  class="formLab">用户信息</div>
          <div  class="formcontrol"> 
          <div  class="formLab">帐号：</div>
          <div  class="formLabi">
            <input name="itnameOld" id="itnameOld" type="hidden" value="{%$staff_sms->itname%}" readonly="readonly" />
            {%$staff_sms->itname%}&nbsp;
            {%if $staff_info%}
            {%$staff_info->cname%}
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			{%$staff_info->station%} - {%$deptName%}
            {%else%}
            	已经离职
            {%/if%}
             
          </div>
          </div>
         
          
          <div class=" formLine clearb"> </div>
          <div  class="formLab">使用类别</div>
          <div  class="formcontrol"> 
           <input name="sm_type" type="radio" id="sm_type" value="1" checked="checked" />领用
            &nbsp;&nbsp;
            <input type="radio" name="sm_type" id="sm_type" value="2" />借用
             &nbsp;&nbsp;
            <input type="radio" name="sm_type" id="sm_type" value="3" />长期借用
              &nbsp;&nbsp;
            <input type="radio" name="sm_type" id="sm_type" value="4" />转移
          </div>
          <div class="formLine clearb " ></div>
          <div  class="formLab">新用户</div>
          <div  class="formcontrol"> 
          <div  class="formLab">帐号：</div>
          <div  class="formLabi">
            
            <input name="itname" class="inputText" type="text" id="itname" value="" size="20" />
            <label class="error" for="itname" generated="true">用户登录帐号必填</label>
            <span id="cname"></span>
            <div id="sms_dept"></div>
          </div>
          </div>
           <div class="clearb " ></div>
          <div style="padding-top:5px" >
          <div  class="formLab">IP 地址：</div>
                 
                  <div  class="formLabi">
                    <input name="ipType" type="radio" value="1" />系统分配： 
                    <span id="show_ip1"></span>
                  </div>
                   <div class="clearb " ></div>
                  <div  class="formLab">&nbsp;</div>
               
                  <div  class="formLabi">
                    <input name="ipType" type="radio" value="2" />延用原IP： <span id="oldIpshow">{%$staff_sms->sms_ip%}</span> <input name="ip2" id="ip2"  class="inputText" type="hidden" value="{%$staff_sms->sms_ip%}" size="20" maxlength="40"  /> 
                   
              </div>
          </div>
           <div class="formLine clearb " ></div>
          <div  class="formLab">备注</div>
          <div  class="formcontrol"> 
             <textarea name="sm_remark" cols="80" class="inputText" id="sm_remark"></textarea>
             <label class="" for="sm_remark" generated="true">可输入OA流程地址或其他说明信息</label>
             
          </div>
          <div class="formLine clearb " ></div>
           <div  class="formLab">操作人</div>
          <div  class="formcontrol"> 
             <input name="op_user" id="op_user"  class="inputTextRead" readonly="readonly" type="text" value="{%$smarty.session.DX_username%}" size="20"    />
          </div>
           <div class="formLine clearb " ></div>
          <div  class="formLab">&nbsp;
           
          </div>
          <div class="formcontrol">
            <input name="sms_id" type="hidden" value="{%$staff_sms->sm_id%}" />
            <input name="addcomplete" type="submit"  class="buttom" value="提交完成" />
            &nbsp;&nbsp;
            <input type="button" value="放弃" name="close"  id="close"  class="buttom a_close" />
          </div>
         
      </div>
      <div class="clearb"></div>
   
    <!--end form --> 
    
  </div>
</div>
</form>

 </div>
      <div class="clearb"></div>
    </div>
    <!--end form --> 
    
  </div>
</div>
 {%include file="../foot.tpl"%}