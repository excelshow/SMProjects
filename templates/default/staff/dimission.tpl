{%include file="../header.tpl"%} 
 
<script type="text/javascript">
    // JavaScript Document
 $(document).ready(function(){
	// function adduser start
	 jQuery.validator.addMethod("sms_number", function(value, element) {   
			return this.optional(element) || /^([S,L,B,M,W,Y,T,R]{1})?([0-9]{6})$/.test(value);   
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
			    depart_code:{required: true}
            },
		
            messages: {
                itname:{required: "用户登录帐号必填",remote:"无此登录帐号，请确认用户登录帐号"},
				depart_code:{required: "事业部必填"} 
            },
			submitHandler : function(){
					 //表单的处理
			  hiConfirm('确认要回收此机房资产？',null,function(r){ 
			  if(r){
					 var post_data = $("#smsaddform").serializeArray();
					 url = "{%site_url('staff/staff/todoOa')%}";  
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
									$("input[name=todoOa]").hide();
									load_id=setInterval(loadSms,5000);	
									$('#intval').val(load_id);
								  }else{
									  jError("操作失败! 请输入资产编号.... ",{
										  VerticalPosition : 'center',
										  HorizontalPosition : 'center',
										  TimeShown : 1000,
									  });
								 }
							  }
						  });
						  return false;
			  }
			  });
			  }
				
        };
	
 
	 
	/////////////////////////////
	
			$('#smsaddform').validate(adduserjs);
			 
				 
				 
				 
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
											loadSms();
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
 /*
		locading deptIp
	*/
	function loadSms(){
		var itname = $("#itname").val();
		if(itname){
		  $.ajax({
						   type: "POST",
							  url: "{%site_url('staff/staff/dimission_sms')%}",
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
									   flag = msg.substr(0,1);
									   if(flag == '-'){
										   clearInterval($("#intval").val());	
									   }
									   $("#ip1").val(msg);
									   $("#show_ip1").html(msg);
								  }
							  }
						  });
		}
	}
	///////////////////////////////
 });
    //]]>
  
	 function sendEmail(){
			var itname = $("#itname").val();
			if(itname){
			  $.ajax({
							   type: "POST",
								  url: "{%site_url('staff/staff/todoEmail')%}",
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
										  $("input[name=todoEmail]").hide();
										  alert("邮件发送成功，操作完成！");
									 }
								  }
							  });
			}
	 }
</script>
 
 
<div id="showLayout" style="display:none;"></div>
<div class=""  style=" ">
  <div class="pad10">
    <div  class="pageTitleTop">用户管理 &raquo; 离职处理</div>
    <div class="h10"></div>
    
    <!--begin form -->
    <div class="staffadd pad5 " style=" ">
      <div class="staffformInfo ">
        <form id="smsaddform"  >
          <div  class="formLab" >用户信息</div>
          <div  class="formcontrol"> 
          <div  class="formLab" style="width:48px;">帐号：</div>
          <div  class="formLabi">
           <input id="intval" value=""  hidden="hidden"/>
            <input name="itname" class="inputText" type="text" id="itname" value="" size="20" />
            <label class="error" for="itname" generated="true" style="margin-right : 20px">用户登录帐号必填</label>
            所属事业部 :
           
            <select name="depart_code" id="depart_code">
            <option value="">请选择</option>
            <option value="1">森马股份</option>
            <option value="2">巴拉巴拉、Mongdodo、MarColor</option>
            <option value="3">女装事业部</option>
            <option value="4">投资公司</option>
            </select>
            <label class="error" for="depart_code" generated="true">所属事业部必填</label>
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
                	 
          </div>
          </div>
          <div class=" formLine clearb"> </div>
          <div  class="formLab">资产信息</div>
          <div  class="formcontrol"  > 
          	<div id="show_ip1">请输入账号</div>
          <div class="clearb " ></div> 
         
          
          </div>
           
         
          
         
        </form>
      </div>
      <div class="clearb"></div>
    </div>
    <!--end form --> 
    
  </div>
</div>

{%include file="../foot.tpl"%}