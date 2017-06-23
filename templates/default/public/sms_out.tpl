<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" />
<head>
<title>资产出库扫描 - {%$web_title%}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" media="screen,projection" type="text/css" href="{%$base_url%}templates/{%$web_template%}/css/main.css" />
<link rel="stylesheet" media="screen,projection" type="text/css" href="{%$base_url%}templates/{%$web_template%}/css/public.css" />
 

<!-- GRAPHIC THEME -->
<script type="text/javascript" src="{%$base_url%}assets/javascript/jquery-1.8.js"></script>
<script type="text/javascript" src="{%$base_url%}assets/javascript/jquery.validate.pack.js"></script>
 
    
<!-- loading hiAlert  -->
<script type="text/javascript" src="{%$base_url%}assets/hialert/jquery.hiAlerts-min.js"></script>
<link rel="stylesheet" href="{%$base_url%}assets/hialert/jquery.hiAlerts.css" type="text/css" />
<script type="text/javascript" src="{%$base_url%}assets/jnotify/jNotify.jquery.js"></script>
<script type="text/javascript" src="{%$base_url%}assets/javascript/jquery.inputDefault.js"></script>
<link rel="stylesheet" href="{%$base_url%}assets/jnotify/jNotify.jquery.css" type="text/css" />
<script type="text/javascript">
 
$(document).ready(function(){
	$("#chuku").focus();
 $('.chuku').keypress(function(event) {
				 
				var key = event.which;//event.keyCode
				if (key >= 97 && key <= 122) {//找到输入是小写字母的ascII码的范围
				event.preventDefault();//取消事件的默认行为
				$(this).val($(this).val() + String.fromCharCode(key - 32));//转换
				}
				 
				});
				 
$("#outform").keypress(function(e) {
  if (e.which == 13) {
	       $("#so_id_backup").val($("#so_id").val()); 
	  		var post_data = $("#outform").serializeArray(); 
			  aa(post_data);
			return false; 
  }
});
	$('[fs]').inputDefault();
  /* $("#chuku").change(function(){
	    var post_data = $("#outform").serializeArray(); 
		 		aa(post_data);
					
			});*/
  
});
function aa(val){
	$.ajax({
						type: "POST",
						url: "{%site_url('public/sms_out/sms_out_do')%}",
						cache:false,
						data: val,
						success: function(msg){ 
						//alert(msg);
							var obj=$.parseJSON(msg); 
							if (obj.code ==1){
							//alert(obj.username);
							   // $("#infochuku").prepend("<div class=cks>"+obj.msg+"</div>"); 
								$("#so_id").val($("#so_id").val()+obj.msg); 
								$("#sms_number_true").val(obj.sms_number);
								//hiBox('#passshow','出库信息验证',450,'','','.a_close'); 
								//$('#hiAlertform').bind("invalid-form.validate").validate(adfd); 
								$("#chuku").val("");
								$("#chuku").focus();
								$("#infochuku").prepend("<div class=cks>"+obj.info+"</div>"); 
							}else{
								//alert("出库失败！！");
								//$("#chuku").val("");
								//$("#chuku").focus();
								$("#infochuku").prepend("<div class=cke>"+obj.msg+"</div>"); 
								
							}
							
						},
						error:function(){
							hiAlert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
						}
						 
					});
					 return false;
					 
 };
 /////////////////////////////
  jQuery.validator.addMethod("pw", function(value, element) {   

    var tel = /^[8]{8}$/;
	if(this.optional(element) || (tel.test(value))){
    return false;
	}else{
		return true;
	}

}, "密码不能为初始密码");
 var adfd = {
            rules: {
                username: {required: true},
				password: {required: true,minlength: 5,pw:true}
            },
            messages: {
                username: {required: "请输入OA账号信息"},
				password: {required: "请输入OA登陆密码",minlength: "密码至少需要5个字符",pw:"密码不能为初始密码"}
            },
            submitHandler:function(){
               var post_data = $("#hiAlertform").serializeArray();
               var subType = $("#action").val();
			   
			  // return false;
                $.ajax({
                    type: "POST",
                    url: "{%site_url('public/sms_out/sms_out_do_true')%}",
                    cache:false,
                    data: post_data,
					beforeSend:function(){ 
					 $("#infochuku").html("正在提交，请勿重复提交");
					 $(".chuku").attr("disabled",true);
					},
                    success: function(msg){
 							 hiClose();
							 	var obj=$.parseJSON(msg); 
							if (obj.code ==1){
							//alert(obj.username);
								 $("#infochuku").html("");
							     $("#infochuku").prepend("<div class=cks>"+obj.msg+"</div>"); 
								 $(".chuku").attr("disabled",false);
								 $(".chuku").val("");
								 $(".chuku").focus();
							}else{
								//alert("出库失败！！");
								//$("#chuku").val("");
								$(".chuku").attr("disabled",false);
								$(".chuku").focus();
								$("#infochuku").prepend("<div class=cke>"+msg+"</div>"); 
								
							}
						 
                    },
                    error:function(){
                        hiAlert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
                    }
                });
				
				return false;
                
            }
        };
		
	function confirmInfo(){
	       $validate_s = $("#so_id").val(); 
			if($validate_s == ""){
				alert("请先匹配资产！");
				return false;
			}
			hiBox('#passshow','出库信息验证',450,'','','.a_close'); 
			$('#hiAlertform').bind("invalid-form.validate").validate(adfd); 
	}	
</script>
<style>
.chuku_ul{
	padding:0 10px 0 0;
	margin:0;
	}
.chuku_ul li{
	list-style:none;
	font-size:14px;
	width:100%;
	}
.chuku_ul li a{
	padding:5px 10px;
	display:inline-block;
	width:98%;
	}
.chuku_ul li a:hover{
	background:#FFF;
	}
.ouTreeTitle{
	font-size:16px;
	padding:5px 10px;
}
.name{
	font-size:20px;
	color:#333;
}
.dept{
	font-size:14px;
	color:#666;
	padding-top:5px;
}
.number{
	border-right:1px solid #CCC;
	padding:5px;
	color:#666;
}
.cks{
	margin:5px 0;
	padding:15px;
	border:1px solid #BCE7CE;
	background:#ECFFFF;
	font-size:16px;
	color:#060
}
.cke{
	margin:5px 0;
	padding:15px;
	border:1px solid #FFD9D9;
	background: #FFF4F4;
	font-size:16px;
	color:#640000;
}
.hide{
	display:none;
}
.submitbutton{
	color:blue;
	float:left;
	margin:5px 0px 1px 20px;
}
.submitbutton button{
	width:80px;
	font-size:18px;
	color:white;
	border-radius:3px;
	background-color:#4c9f6a;
}
.showAN{
   margin-top: 50px;
   padding-left: 0px;
   padding-top: 5px;
   font-size: 20px
}
</style>
</head>
<body>
<div id="passshow" style="display:none;" >
	 <!-- edit password-->
 <div class="staffadd " >
    <div class="staffformInfo">
			<div style="font-size:16px; padding:0 0 10px 0;">领取人信息验证</div>
          <div><span class="beforeinput">OA账号：</span>
            <input type="text" name="username" class="inputText"  value="" />
            <input type="hidden" name="so_id" id="so_id" class="inputText" value="" />
            <input type="hidden" name="sms_number_true" id="sms_number_true" class="inputText" value="" /> 
      </div>
            <div class="h10 "> </div>
          
          <div>
            
            <span class="beforeinput">OA密码：</span>
            <input type="password" class="inputText" name="password" id="password"  />
          </div>
            <div class="h10 "> </div>
          <div>
          <span class="beforeinput">&nbsp;</span>
            <input type="submit" class="buttom" name="submit" id="edit_passbut" value="领用人验证" />
             <input class="a_close buttom" type="button" value="放弃">
          </div>
      
    </div>
   </div>
    <!-- --> 
</div>
<div id="main"> 
  
  <!-- Tray -->
  <div id="tray" class="box">
    <p class="fleft box" style="padding:5px 4px;"><img src="{%$base_url%}templates/{%$web_template%}/images/adminLogo.png" /></p>
    <div class="fright" style="padding:5px 4px;">
   
    {%if $smarty.session.username%}
      当前用户:
		<strong>{%$smarty.session.username%}</strong> 
        <strong>
            <a id="logout" href="/index.php/logsm/logout">安全退出</a>
            </strong>
                    
      {%else%}
      <a href="/" id="logout">管理登录</a>
      {%/if%}
      </div>
     <div class="clearb" ></div>
  </div>
   
  <!-- Menu -->
  <div class="h10"></div>
  <div class="menuTab">
  <ul>
  	 <li class="active"><a href="{%site_url('/public/sms_out')%}">资产出库</a></li>
        <li><a href="{%site_url('/public/sms_out/sms_return')%}">资产退仓</a></li>
       <li><a href="{%site_url('/public/sms_out/sms_inlinyong')%}">领用入库</a></li>
        <li><a href="{%site_url('/public/sms_out/sms_inbatch')%}">批量入库</a></li>
         <div class="clearb"></div>
  </ul>
  </div>
  <div class="h10"></div>
  <div class="showLayout" >
   <!--sidebarLeft stat -->
    <div class="sidebarLeft ">
   	
		<div class="ouTreeTitle" >待出库人员</div>
        <div class="ouTree pad5">
        <div id="localJson" class="jstree jstree-0 jstree-focused jstree-classic" >
        	<ul class="chuku_ul">
              {%if ($data["staff_sms"])%}
              {%foreach from=$data["staff_sms"] item=row%}
              	<li><a href="{%site_url('public/sms_out/index')%}/{%$row->itname%}" class="chuku" id="">{%$row->cname%} {%$row->itname%} </a></li>
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
        <form id="outform" name="outform" > 
           
          <div  class="name"> {%$staff['info']->surname%}{%$staff['info']->firstname%} / {%$staff['info']->itname%}  <span style="color:green;margin-left:30px;">未出库资产：</span> <span style="color:red;">{%$staff['info']->num%}</span></div> 
           <input name="itname" type="hidden" value="{%$staff['info']->itname%}" />
           <input name="so_id_backup" id="so_id_backup" type="hidden" />
          <div  class="dept"> 
          {%$staff['info']->deptOu%}
          </div>
          <div class="formLine clearb"> </div> 
          <div class=" h5"></div>
          <div class="">
                
                 <div class=" clearb h5" >&nbsp;<br /></div>
                  <div class="searchform">   
                 <span class="number" >请输入资产编号</span> 
              <input name="chuku" id="chuku" type="text"  placeholder="请输入资产编号" class="styleInput chuku"  />
            <!--  <button type="button" class="  addButton" data-template="chuku">添加</button> -->
                </div> 
                <div class="submitbutton"> <button onclick="confirmInfo();return false;" >出库</button></div>
                 <div class="showAN">未出库资产编号：{%$staff['info']->snlist%}</div>
                 <div class="form-group hide" id="chukuTemplate">
                      <div class="searchform">
                 <span class="number" >请输入资产编号</span> 
              <input   type="text"   class="styleInput chuku ckmore"  />
              <button type="button" class="btn btn-default btn-sm removeButton">删除</button>
                   </div>                
                  </div>
      
          </div>            <div class="formLine clearb"> </div>            
            <div class="infochuku" id="infochuku">
            </div>
              <div class=" h5"></div>
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
  
  <!-- /header -->
  <div class="clearb"></div>
  <!-- content --> 
   
  <!-- /content -->
  
  <div class="clearb h5"></div>
  <!-- Footer -->
  <div id="footer" class="box">
    <p class="f-left">&copy; {%date('Y')%} <a href="{%$web_copyrighturl%}" target="_blank">{%$web_copyright%}</a>, All Rights Reserved &reg;</p>
    <p class="f-right">推荐使用IE7+浏览器以获得最佳效果<br />
      Power by 森马IT服务科</p>
  </div>
  <!-- footer --> 
  
</div>
<!-- /main -->
<script type="text/javascript">
    $(document).ready(function() {
        $('.addButton').on('click', function() {
            var index = $(this).data('index');
            if (!index) {
                index = 1;
                $(this).data('index', 1);
            }
            index++;
            $(this).data('index', index);

            var template     = $(this).attr('data-template'),
                $templateEle = $('#' + template + 'Template'),
                $row         = $templateEle.clone().removeAttr('id').insertBefore($templateEle).removeClass('hide'),
                $el          = $row.find('input').eq(0).attr('name', template + '[]');
          //  $('#defaultForm').bootstrapValidator('addField', $el);

            // Set random value for checkbox and textbox
            if ('checkbox' == $el.attr('type') || 'radio' == $el.attr('type')) {
                $el.val('Choice #' + index)
                   .parent().find('span.lbl').html('Choice #' + index);
            } else {
                $el.attr('placeholder', '请输入资产编号' + index);
            }
			$('.ckmore').bind("keypress",function(event) {
				 
				var key = event.which;//event.keyCode
				if (key >= 97 && key <= 122) {//找到输入是小写字母的ascII码的范围
				event.preventDefault();//取消事件的默认行为
				$(this).val($(this).val() + String.fromCharCode(key - 32));//转换
				}
				 
				});
				 
				 
				 
            $row.on('click', '.removeButton', function(e) {
              //  $('#defaultForm').bootstrapValidator('removeField', $el);
                $row.remove();
            });
        });

      
    });
</script>
</body>
</html>