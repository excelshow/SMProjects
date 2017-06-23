<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" />
<head>
<title>资产出库扫描 - {%$web_title%}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" media="screen,projection" type="text/css" href="{%$base_url%}templates/{%$web_template%}/css/main.css" />
<link rel="stylesheet" media="screen,projection" type="text/css" href="{%$base_url%}templates/{%$web_template%}/css/public.css" />
<link rel="stylesheet" media="screen,projection" type="text/css" href="{%$base_url%}templates/{%$web_template%}/css/superfish.css" />
<link rel="stylesheet" media="screen,projection" type="text/css" href="{%$base_url%}templates/{%$web_template%}/css/superfish-navbar.css" />

<!-- GRAPHIC THEME -->
<script type="text/javascript" src="{%$base_url%}assets/javascript/jquery-1.8.js"></script>
<script type="text/javascript" src="{%$base_url%}assets/javascript/jquery.validate.pack.js"></script>
<script type="text/javascript" src="{%$base_url%}assets/javascript/superfish.js"></script>
<script type="text/javascript" src="{%$base_url%}assets/javascript/supersubs.js"></script>

<!-- loading hiAlert  -->
<script type="text/javascript" src="{%$base_url%}assets/hialert/jquery.hiAlerts-min.js"></script>
<link rel="stylesheet" href="{%$base_url%}assets/hialert/jquery.hiAlerts.css" type="text/css" />
<script type="text/javascript" src="{%$base_url%}assets/jnotify/jNotify.jquery.js"></script>
<script type="text/javascript" src="{%$base_url%}assets/javascript/jquery.inputDefault.js"></script>
<link rel="stylesheet" href="{%$base_url%}assets/jnotify/jNotify.jquery.css" type="text/css" />
<script type="text/javascript">
 
$(document).ready(function(){
   $('#inform').validate(injs);
   $("#sms_number").change(function(){
	   
	    $.ajax({					
		type: "POST",
		  url: "{%site_url('public/sms_out/in_number_check')%}/",
		  cache:false,
		  dataType:"json",
		  data: "sms_number="+$(this).val(),//21232f297a57a5a743894ae4a801fc3
		  success: function(msg){
				  //var obj=$.parseJSON(msg); 
				 // alert(msg.staff.staff.cname);
					  if (msg.status ==1){ 
						  $("#sms_cate_3").val(msg.sms.cate_id);
						  $("#sms_cate_name").val(msg.sms.cate_name);
						   if(msg.staff.status == 1){
							   
								$("#sms_sapnumber").val(msg.sms.sap_number);
							   $("#scg_id").val(msg.sms.scg_id);
							   $("#lingqu_itname").val(msg.sms.reg_itname);
							   $("#so_itname").val(msg.sms.so_itname);
							   $("#sms_ip").val(msg.sms.sms_ip);
						  		$("#reg_itname").val(msg.staff.staff.itname);
								$("#reg_cname").val(msg.staff.staff.cname);
								$("#rootid").val(msg.staff.staff.rootid)
								$("#reg_show").html(msg.staff.staff.deptOu);
						   }else{
							   $("#sms_sapnumber").val("");
							   $("#scg_id").val("");
							    $("#lingqu_itname").val("");
								$("#so_itname").val("");
						  		$("#reg_itname").val("");
								$("#reg_cname").val("");
								$("#sms_ip").val("");
								$("#rootid").val("")
								$("#reg_show").html(msg.staff.message);
						   }
					  }else{
						  hiAlert("请确认资产编号是否正确！"); 
						  $("#scg_id").val("");
						  $("#sms_sapnumber").val("");
						 		 $("#sms_cate_3").val("");
								 $("#so_itname").val("");
						 		 $("#sms_cate_name").val("");
						   		$("#lingqu_itname").val("");
						  		$("#reg_itname").val("");
								$("#reg_cname").val("");
								$("#rootid").val("")
								$("#reg_show").html("");
					  }
		  },
		  error:function(){
			  hiAlert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决"); 
		  }
	  }); 
	  ///////////////
	});
	
	 
});
 
 /////////////////////////////
 jQuery.validator.addMethod("sms_number", function(value, element) {   
			return this.optional(element) || /^([S,L,B,M,W,Y,T,C,R]{1})?([0-9]{6})$/.test(value);   
			},
			"编号格式错误");
 
  jQuery.validator.addMethod("passw", function(value, element) {   

    var tel = /^[8]{8}$/;
	if(this.optional(element) || (tel.test(value))){
    return false;
	}else{
		return true;
	}

}, "密码不能为初始密码");
 var injs = {
            rules: {
				sms_number: {required: true,sms_number:true},
				sms_bname: {required: true},
				sms_cate_name: {required: true},
                lingqu_itname: {required: true},
				reg_itname: {required: true},
				password: {required: true,minlength: 5,passw:true}
            },
            messages: {
				sms_number: {required: true},
				sms_cate_name: {required: "请选择正确的资产编号"},
				sms_bname: {required: "请填写资产名称"},
                lingqu_itname: {required: "请输入OA账号信息"},
				reg_itname: {required: "申请人必填！"},
				password: {required: "请输入OA登陆密码",minlength: "密码至少需要5个字符",passw:"密码不能为初始密码"}
            },
            submitHandler:function(){
               var post_data = $("#inform").serializeArray(); 
			  // return false;
                $.ajax({
                    type: "POST",
                    url: "{%site_url('public/sms_out/sms_inlinyong_true')%}",
                    cache:false,
                    data: post_data,
                    success: function(msg){ 
							 	var obj=$.parseJSON(msg); 
							if (obj.code ==1){
							//alert(obj.username);
							    $("#infochuku").prepend("<div class=cks>"+obj.msg+"</div>"); 
								     $('#inform')[0].reset();  
							}else{
								alert("出库失败！！");
								$("#password").focus();
								$("#infochuku").prepend("<div class=cke>"+obj.msg+"</div>"); 
								
							}
						 
                    },
                    error:function(){
                        hiAlert("出错啦111，刷新试试，如果一直出现，可以联系开发人员解决");
                    }
                });
				
				return false;
                
            }
        };
		
		
</script>
<style>
.chuku_ul {
	padding: 0 10px 0 0;
	margin: 0;
}
.chuku_ul li {
	list-style: none;
	font-size: 14px;
	width: 100%;
}
.chuku_ul li a {
	padding: 5px 10px;
	display: inline-block;
	width: 98%;
}
.chuku_ul li a:hover {
	background: #FFF;
}
.ouTreeTitle {
	font-size: 16px;
	padding: 5px 10px;
}
.name {
	font-size: 20px;
	color: #333;
}
.dept {
	font-size: 14px;
	color: #666;
	padding-top: 5px;
}
.number {
	border-right: 1px solid #CCC;
	padding: 5px;
	color: #666;
}
.cks {
	margin: 5px 0;
	padding: 15px;
	border: 1px solid #BCE7CE;
	background: #ECFFFF;
	font-size: 16px;
	color: #060
}
.cke {
	margin: 5px 0;
	padding: 15px;
	border: 1px solid #FFD9D9;
	background: #FFF4F4;
	font-size: 16px;
	color: #640000;
}
</style>
</head>
<body>
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
  	 <li><a href="{%site_url('/public/sms_out')%}">资产出库</a></li>
        <li><a href="{%site_url('/public/sms_out/sms_return')%}">资产退仓</a></li>
       <li class="active"><a href="{%site_url('/public/sms_out/sms_inlinyong')%}">领用入库</a></li>
        <li><a href="{%site_url('/public/sms_out/sms_inbatch')%}">批量入库</a></li>
         <div class="clearb"></div>
  </ul>
  </div>
  <div class="h10"></div>
  <div class="showLayout" > 
    
    <!--begin form -->
    <div  style="">
      <div class="staffformInfo staffadd">
        <form id="inform" name="inform" action="" method="post" >
          <div class="">
            <div class="searchform"> <span class="number" >请输入资产编号</span>
              <input name="sms_number" id="sms_number" type="text" fs="请输入资产编号" class="styleInput"  />
            </div>
            <div class=" h5"></div>
          </div>
          <div class="formLine clearb"> </div>
          <div class=" h5"></div>
          <div  class="formLab">资产类别</div>
          <div  class="formcontrol">
            <div id="sms_select">
              <div  class="formLabi">
                <input name="sms_cate_name" id="sms_cate_name" type="text" class="inputTextRead" readonly="readonly"  />
                <input name="sms_cate_3" id="sms_cate_3" type="hidden" class="inputText"  />
              </div>
              <div  class="formLab">资产归属：</div>
              <div  class="formLabi">
                <select class="inputText" name="sa_id" >
                  
          {%foreach from=$smsAff item=rown%}
           
                  <option value="{%$rown->sa_id %}"   > {%$rown->sa_name %} </option>
                  
           {%/foreach%}
          
                </select>
              </div>
            </div>
          </div>
          <div class="h10  clearb"> </div>
          <div  class="formLab">资产信息</div>
          <div  class="formcontrol">
            <div  class="formLab">名称：</div>
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
            <div  class="formLabi"> ￥
              <input name="sms_fee" id="sms_fee"  class="inputText" type="text" value=""  />
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
              <textarea name="sms_cdkey" cols="80" rows="1" class="inputText" id="sms_cdkey"></textarea>
            </div>
          </div>
          <div class=" formLine clearb"> </div>
          <div  class="formLab">财务信息</div>
          <div  class="formcontrol">
            <div  class="formLab">财务编号：</div>
            <div  class="formLabi">
              <input name="sms_sapnumber" id="sms_sapnumber"  class="inputText" type="text" value="" size="15" maxlength="40"  />
            </div>
            <div  class="formLab">发票日期：</div>
            <div  class="formLabi">
              <input name="check_time" id="check_time"  class="inputText" type="text" value="" size="15"    />
            </div>
            <div  class="formLab">发票号：</div>
            <div  class="formLabi">
              <input name="check_number" id="check_number"  class="inputText" type="text" value="" size="15" maxlength="40"  />
            </div>
            <div  class="formLab">发票抬头：</div>
            <div  class="formLabi">
              <input name="check_title" id="check_title"  class="inputText" type="text" value="" size="20" maxlength="40"  />
            </div>
          </div>
          <div class="formLine clearb " ></div>
          <div  class="formLab">出库信息</div>
          <div  class="formcontrol">
            <div  class="formLab">申请人：</div>
            <div  class="formLabi">
            <input name="reg_cname" id="reg_cname"  class="inputTextRead" readonly="readonly" type="text" value="" size="20"    />
              <input name="reg_itname" id="reg_itname"  class="inputTextRead" readonly="readonly" type="text" value="" size="20"    />
               <input name="sms_ip" id="sms_ip"  class="inputTextRead" readonly="readonly" type="text" value="" size="20"    />
              <input name="rootid" id="rootid"  class="inputTextRead" readonly="readonly" type="hidden" value="" size="20"    />
            </div>
            <div  class="formLab"></div>
            <div  class="formLabi"> <div id="reg_show"></div> </div>
            <div class="clearb h10" ></div>
            <div  class="formLab">领取人：</div>
            <div  class="formLabi">
              <input name="lingqu_itname" id="lingqu_itname"  class="inputText" fs="领取人OA账号"  type="text" value="" size="20"    />
            </div>
            <div  class="formLab">密码：</div>
            <div  class="formLabi">
              <input name="password" id="password"  class="inputText" type="password" fs="领取人OA密码" value="" size="20" maxlength="40"  />
            </div>
          </div>
          <div class="formLine clearb " ></div>
          <div  class="formLab">操作人</div>
          <div  class="formcontrol">
            <div  class="formLab">装机人：</div>
            <div  class="formLabi">
              <input name="so_itname" id="so_itname"  class="inputTextRead" readonly="readonly" type="text" value="" size="20"    />
            </div>
            
          </div>
          <div class="formLine clearb " ></div>
          <div  class="formLab">&nbsp; </div>
          <div class="formcontrol">
           <input name="scg_id" id="scg_id"  class="inputTextRead" readonly="readonly" type="hidden" value="" size="20"    />
            <input   type="submit"  class="submitButton" value="提交完成" />
            &nbsp;&nbsp;
            <input name="重置" type="reset"   class="buttom"  value="放弃" />
          </div>
          <div class="formLine clearb"> </div>
          <div class="infochuku" id="infochuku"> </div>
          <div class=" h5"></div>
        </form>
      </div>
      <div class="clearb"></div>
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

</body>
</html>