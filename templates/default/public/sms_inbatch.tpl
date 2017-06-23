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
    $("#sms_cat_id").change(function(){
	   var oa = $("#oa_number").val();
	   if (oa){
	   		ajaxFun(oa,$(this).val());
	   }
	  ///////////////
	});
   $("#oa_number").change(function(){
	   var cate_id = $("#sms_cat_id").val();
	   ajaxFun($(this).val(),cate_id);
	  ///////////////
	});
	//////////////////////////////
	$('#inform').validate(injs); 
});
 
 function ajaxFun(oa,cat){
	 $.ajax({					
		type: "POST",
		  url: "{%site_url('public/sms_out/in_batch_check')%}/",
		  cache:false,
		  dataType:"json",
		  data: "oa_number="+oa+"&sms_cat_id="+cat,//
		  success: function(msg){
				  //var obj=$.parseJSON(msg); 
				 // alert(msg.staff.staff.cname);
					  if (msg.status ==1){ 
					  	  $("#scb_id").val(msg.sms.scb_id);
						  $("#sms_number").val(msg.sms.sms_number);
						   $("#sms_sapnumber").val(msg.sms.sap_number);
						  $("#sms_size").val(msg.sms.sms_size);
						  $("#sms_detail").val(msg.sms.sms_detail); 
						  $("#sms_unit").find("option[text="+msg.sms.sms_unit+"]").attr("selected",true);
						  
						    
					  }else{
						  hiAlert(msg.sms,"错误信息");
						  $("#scb_id").val(""); 
						  $("#sms_sapnumber").val("");
						  $("#sms_number").val("");
						  $("#sms_size").val("");
						  $("#sms_detail").val(""); 
						  $("#sms_unit").find("option[text="+msg.sms.sms_unit+"]").attr("selected",true);
							 return false;
					  }
		  },
		  error:function(){
			  hiAlert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决","操作错误"); 
		  }
	  }); 
 }
 /////////////////////////////
  
 var injs = {
            rules: {
				oa_number: {required: true},
				sms_number: {required: true,minlength:7},
				sms_cat_id: {required: true}, 
				sms_bname: {required: true}
            },
            messages: {
				oa_number: {required: "请选择正确的OA流程单编号"},
				sms_number: {required: true,minlength: "请选择正确的资产编号"},
				sms_cat_id: {required: "请选择正确的资产类别"},
				sms_bname: {required: "请选择正确的资产名称"}
            },
            submitHandler:function(){
               var post_data = $("#inform").serializeArray(); 
			  // return false;
                $.ajax({
                    type: "POST",
                    url: "{%site_url('public/sms_out/sms_inbatch_true')%}",
                    cache:false,
                    data: post_data,
                    success: function(msg){ 
							 	var obj=$.parseJSON(msg); 
							if (obj.code ==1){
							//alert(obj.username);
								hiAlert(obj.msg,"操作完成");
							    $("#infochuku").prepend("<div class=cks>"+obj.msg+"</div>"); 
								$('#inform')[0].reset();  
							}else{
								hiAlert("出库失败！！","操作错误");
								$("#password").focus();
								$("#infochuku").prepend("<div class=cke>"+obj.msg+"</div>"); 
							}
						 
                    },
                    error:function(){
                        hiAlert("出错啦111，刷新试试，如果一直出现，可以联系开发人员解决","操作错误");
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
       <li><a href="{%site_url('/public/sms_out/sms_inlinyong')%}">领用入库</a></li>
        <li class="active"><a href="{%site_url('/public/sms_out/sms_inbatch')%}">批量入库</a></li>
         <div class="clearb"></div>
  </ul>
  </div>
  <div class="h10"></div>
  <div class="showLayout" > 
    
    <!--begin form -->
    <div  style="">
      <div class="staffformInfo staffadd">
        <form id="inform" name="inform" action="" method="post" >
         <div  class="formLab">资产类别</div>
          <div  class="formcontrol">
            <div id="sms_select">
              <div  class="formLabi">
               
                 <select class="inputText" name="sms_cat_id" id="sms_cat_id" > 
           			<option value=""   >选择资产类别</option>
                  <option value="4"   >联想电脑主机</option>
                  <option value="8"   >液晶显示器</option>
          		  <option value="19"   >笔记本</option>
           		 <option value="11"   >一体机</option>
                  <option value="39"   >手绘板</option>
                </select>
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
           <div class="formLine clearb"> </div>
          <div class="">
            <div class="searchform"> <span class="number" >OA流程单编号</span>
              <input name="oa_number" id="oa_number" type="text" fs="请输入资产编号" class="styleInput"  />
            </div>
            <div class=" h5"></div>
          </div>
           <div class="formLine clearb"> </div>
          <div  class="formLab">资产编码</div>
          <div  class="formcontrol">
           	<textarea name="sms_number" cols="80" rows="1" class="inputTextRead" readonly="readonly" id="sms_number"></textarea>
           </div>
           <div class="formLine clearb"> </div>
          <div  class="formLab">财务编号</div>
          <div  class="formcontrol">
          	<textarea name="sms_sapnumber" cols="80" rows="1" class="inputText" id="sms_sapnumber"></textarea>
                    </div>
          <div class="formLine clearb"> </div>
          <div class=" h5"></div> 
          <div  class="formLab">资产信息</div>
          <div  class="formcontrol">
            <div  class="formLab">名称：</div>
            <div  class="formLabi">
              <input name="sms_bname" id="sms_bname"  class="inputText" type="text" value="" size="19" maxlength="40"  />
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
              <input name="sms_fee" id="sms_fee"  class="inputText" type="text" value=""  /> ￥
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
           
          <div  class="formLab">操作人</div>
          <div  class="formcontrol">
            <div  class="formLab">入库人：</div>
            <div  class="formLabi">
              <input name="sms_input" id="sms_input"  class="inputTextRead" readonly="readonly" type="text" value="{%$smarty.session.username%}" size="20"    />
            </div>
            
          </div>
          <div class="formLine clearb " ></div>
          <div  class="formLab">&nbsp; </div>
          <div class="formcontrol">
           <input name="scb_id" id="scb_id"  class="inputTextRead" readonly="readonly" type="hidden" value="" size="20"    />
            <input   type="submit"  class="buttom" value="提交完成" />
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