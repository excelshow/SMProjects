{%include file="../header.tpl"%} 
 <link rel="stylesheet" media="screen,projection" type="text/css" href="{%$base_url%}templates/{%$web_template%}/sms/css/stlye.css" />
<script type="text/javascript">
    // JavaScript Document
 $(document).ready(function(){
	// function adduser start
	 jQuery.validator.addMethod("sms_number", function(value, element) {   
			return this.optional(element) || /^([S,L,B,M,W,Y,T]{1})?([0-9]{6})$/.test(value);   
			},
			"请输入正确的资产编号");
	 
			 var adduserjs = {
				success: function (label,val) {
                    //正确时的样 label.text("").addClass("success");
                },
            rules: {
				itname:{required: true,remote:{
								url: "{%site_url('sms/sms/staff_main_check')%}/"+$("#itname").val(),
								type: "post",
								async:false,
								dataType:"json",
								data: {
										itname: function () {
                                 	     return $("#itname").val(); 
                               		    }
								} 
							}
					 },
				sms_number1:{sms_number: true,remote:{
								url: "{%site_url('sms/sms/sms_main_check')%}/"+$("#sms_number1").val(),
								type: "post",
								async:false,
								dataType:"json", 
							//alert($("#useremail").html());
								data: {
										sms_number: function () {
                                 	   return $("#sms_number1").val();
									    $("#sms_mian1").html()
                               		 }
									},
								dataFilter: function(val) {
										var a = eval( '(' + val + ')' );
										if (a.type == 1) {
											$("#sms_mian1").html(a.msg)
											loadIp();
											return 'true';
										}
										else {
											$("#sms_mian1").html(a.msg)
											return 'false';
										} 
									}
								} 
							},
				
				sms_number2:{sms_number: true,remote:{
								url: "{%site_url('sms/sms/sms_main_check')%}/"+$("#sms_number2").val(),
								type: "post",
								async:false,
								dataType:"json", 
							//alert($("#useremail").html());
								data: {
										sms_number: function () {	 
                                 	   return $("#sms_number2").val();
									   
                               		 }
									},
								dataFilter: function(val) {
										var a = eval( '(' + val + ')' );
										if (a.type == 1) {
											 //alert(val);
											  $("#sms_mian2").html(a.msg)
											return 'true';
										}
										else {
											//result.Result = result.Result == "1" ? true : false;
											
											$("#sms_mian2").html("")
											return 'false';
										} 
									}
								}},
				sms_number3:{sms_number: true,remote:{
								url: "{%site_url('sms/sms/sms_main_check')%}/"+$(this).val(),
								type: "post",
								async:false,
								dataType:"json", 
							//alert($("#useremail").html());
								data: {
										sms_number: function () { 
                                 	   return $("#sms_number3").val();
                               		 }
									},
								dataFilter: function(val) {
										var a = eval( '(' + val + ')' );
										if (a.type == 1) {
											 //alert(val);
											  $("#sms_mian3").html(a.msg)
											return 'true';
										}
										else {
											//result.Result = result.Result == "1" ? true : false;
											$("#sms_mian3").html("")
											return 'false';
										} 
									}
								}},
						oldSmsNumber:{sms_number: true,remote:{
								url: "{%site_url('sms/sms/oldSmsNumberIpcheck')%}/",
								type: "post",
								async:false,
								dataType:"json", 
							//alert($("#useremail").html());
								data: {
										sms_number: function () {
                                 	   return $("#oldSmsNumber").val();
                               		 }
									},
								dataFilter: function(val) {
										if(val == 0){
											$("#oldIpshow").html("");
											$("#oldSmsNumber").val("");
											return 'false';
										}else{
											$("#oldIpshow").html(val);
											$("#ip2").val(val)
											return 'true';
										}
									}
							}},
					sm_remark:{required: true}
            },
		
            messages: {
                itname:{required: "用户登录帐号必填",remote:"无此登录帐号，请确认用户登录帐号"},
				oldSmsNumber:{sms_number: "请输入正确的资产编号",remote:"请确认资产编号"},
				sms_number1:{sms_number: "请输入正确的资产编号",remote:"此编号不存在或正在使用中"},
				sms_number2:{sms_number: "请输入正确的资产编号",remote:"此编号不存在或正在使用中"},
				sms_number3:{sms_number: "请输入正确的资产编号",remote:"此编号不存在或正在使用中"},
				sm_remark:{required: "输入OA流程地址"}
            },
			submitHandler : function(){
					 //表单的处理
					 var ipType = $('input[name="ipType"]:checked').val();
					  if(ipType==1){
						 if($('input[name="ip1"]').val() == ''){
							 hiAlert("此用户所属组织没有分配IP端或IP资源用完，请管理员确认！！");
							  return false;//阻止表单提交
						 }
					 }
					 if(ipType==2){
						 if($('input[name="ip2"]').val() == ''){
							 hiAlert("请输入原资产编号！！");
							  return false;//阻止表单提交
						 }
					 }
					 var post_data = $("#smsaddform").serializeArray();
					 url = "{%site_url('sms/sms/staff_sms_add_com')%}";
					  
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
									// alert("{%$reurl%}");
									 // location.href = "{%$reurl%}";	
									 setInterval(function(){window.location = "{%$reurl%}";},1000);	
								  }else{
									  jError("操作失败! 请输入资产编号.... ",{
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
	/*
		locading old SmsNumber Ip
	*/
	 
	/////////////////////////////
	
			$('#smsaddform').validate(adduserjs);
			$('#sms_number1').change(function(e) {
				//alert('sss');
                 /* $.ajax({
                    type: "POST",
                    url: "{%site_url('staff/staffAllJason')%}",
					async:false, 
					dataType: "json",//返回json格式的数据
                    success: function(msg){
						
					}
				  });*/
            });
			 $('#sms_number1').keypress(function(event) {
				 
				var key = event.which;//event.keyCode
				if (key >= 97 && key <= 122) {//找到输入是小写字母的ascII码的范围
				event.preventDefault();//取消事件的默认行为
				$(this).val($(this).val() + String.fromCharCode(key - 32));//转换
				}
				 
				});
				$('#sms_number1').blur(function() {
				$(this).val($(this).val().toUpperCase());
				});
			$('#sms_number2').keypress(function(event) {
				 
				var key = event.which;//event.keyCode
				if (key >= 97 && key <= 122) {//找到输入是小写字母的ascII码的范围
				event.preventDefault();//取消事件的默认行为
				$(this).val($(this).val() + String.fromCharCode(key - 32));//转换
				}
				 
				});
				$('#sms_number2').blur(function() {
				$(this).val($(this).val().toUpperCase());
				});
				$('#sms_number3').keypress(function(event) {
				 
				var key = event.which;//event.keyCode
				if (key >= 97 && key <= 122) {//找到输入是小写字母的ascII码的范围
				event.preventDefault();//取消事件的默认行为
				$(this).val($(this).val() + String.fromCharCode(key - 32));//转换
				}
				 
				});
				$('#sms_number3').blur(function() {
				$(this).val($(this).val().toUpperCase());
				});
				$('#oldSmsNumber').keypress(function(event) {
				 
				var key = event.which;//event.keyCode
				if (key >= 97 && key <= 122) {//找到输入是小写字母的ascII码的范围
				event.preventDefault();//取消事件的默认行为
				$(this).val($(this).val() + String.fromCharCode(key - 32));//转换
				}
				 
				});
				$('#oldSmsNumber').blur(function() {
				$(this).val($(this).val().toUpperCase());
				});
			// function autocomplete end	
			 
			 
		 // function autocomplete end
	 
	     /////////////
 });
    //]]>
   
</script>
 
 
<div id="showLayout" style="display:none;"></div>
<div class=""  style=" ">
  <div class="pad10">
    <div  class="pageTitleTop">资产管理 &raquo; 用户资产 &raquo; 资产出库</div>
    <div class="h10"></div>
    <!--sidebarLeft stat -->
    <div class="sidebarLeft ">
   	
		<div class="ouTreeTitle">待出库人员</div>
        <div class="ouTree pad5">
        <div id="localJson" class="jstree jstree-0 jstree-focused jstree-classic" style="height: 594px; overflow: auto;">
        	<ul class="chuku_ul">
              {%if ($data["staff_sms"])%}
              {%foreach from=$data["staff_sms"] item=row%}
              	<li><a href="{%site_url('sms/sms/staff_sms_chuku')%}/{%$row->itname%}" class="chuku" id="">{%$row->cname%} {%$row->itname%} </a></li>
              {%/foreach%}
              {%/if%}
            </ul>
            </div>
        </div>
       
    </div>
    <!--sidebarLeft end -->
    <!--begin form -->
    <div class="sidebarMainTo  " style=" ">
    <div  style="padding-left:10px;">
      <div class="staffformInfo staffadd">
      {%if $staff['status'] ==1%}
        <form id="smsaddform"  >
        <div class="formLine  clearb" ></div>
          <div  class="formLab">资产使用人</div>
          <div  class="formLabt">姓名：</div>
          <div  class="formLabi"> {%$staff['info']->surname%} {%$staff['info']->firstname%} </div>
          
          <div  class="formLabt">IT帐号：</div>
          <div  class="formLabi"> {%$staff['info']->itname%}
           
          </div>
          <div class="h10 clearb"> </div>
          
          
          
          
          <div  class="formLab">用户信息</div>
          <div  class="formcontrol"> 
          <div  class="formLab">帐号：</div>
          <div  class="formLabi">
            <input name="itname" class="inputText" type="text" id="itname" value="" size="20" />
            <label class="error" for="itname" generated="true">用户登录帐号必填</label>
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
            <span id="sms_mian1"></span>
          </div>
          <div class="clearb " ></div>
          <div style="padding-top:5px" >
              <div  class="formLab">IP 地址：</div>
                
                  <div  class="formLabi">
                    <input name="ipType" type="radio" value="1" checked="checked" />系统分配：
                    <span id="show_ip1"></span>
                  </div>
                   <div class="clearb " ></div>
                  <div  class="formLab">&nbsp;</div>
               
                  <div  class="formLabi">
                    <input name="ipType" type="radio" value="2" />延用原IP： <span id="oldIpshow"></span> &nbsp;&nbsp;&nbsp;&nbsp;输入原资产编号：<input name="ip2" id="ip2"  class="inputText" type="hidden" value="" size="20" maxlength="40"  /><input name="oldSmsNumber" id="oldSmsNumber"  class="inputText" type="text" value="" size="20" maxlength="40"  />
                   
              </div>
          </div>
          <div class="clearb formLine" ></div>
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
             &nbsp;&nbsp;
            <input type="radio" name="sm_type" id="sm_type" value="3" />长期借用
             &nbsp;&nbsp;
            <input type="radio" name="sm_type" id="sm_type" value="4" />转移
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
            <input name="action" type="hidden" value="" />
            <input name="addcomplete" type="submit"  class="buttom" value="提交完成" />
            &nbsp;&nbsp;
            <input type="button" value="放弃"   class="buttom" />
          </div>
        </form>
        {%else%}
        <h2>{%$staff['message']%}</h2>
        {%/if%}
      </div>
      <div class="clearb"></div>
      </div>
    </div>
    <!--end form --> 
    
  </div>
</div>
{%include file="../foot.tpl"%}