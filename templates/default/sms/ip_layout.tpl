{%include file="../header.tpl"%}
<link rel="stylesheet" media="screen,projection" type="text/css" href="{%$base_url%}templates/{%$web_template%}/sms/css/stlye.css" />
<script src="{%base_url()%}assets/jstree/jquery.jstree.js" type="text/javascript"></script> 
<script type="text/javascript">
 
    $(document).ready(function(){
	 	$('input[name="publicSearch"]').click(function(){
			key = $('input[name="publicKey"]').val();
			type = $('select[name="publicType"]').val();
			 
				///////////// search sms starte
				$("#showLayout").html("<img src='{%$base_url%}templates/{%$web_template%}/images/loading.gif'  /> 查询中。。。");
				 
					 $.ajax({
						type: "POST",
						url: "{%site_url('sms/sms/ip_search')%}",
						cache:false,
						
						data: 'key='+key+'&type='+type,
						success: function(msg){
							$("#showLayout").html(msg);
							  
							// alert(val);          
						},
						error:function(){
							jError("出错啦，刷新试试，如果一直出现，可以联系开发人员解决",{
								VerticalPosition : 'center',
								HorizontalPosition : 'center',});
							 
						}
					});
			});		 
       
    });
    //]]>
</script>
<div class="sms_top">
  <ul class="sms_menu">
    <li><a href='{%site_url("sms/sms/ip_layout")%}' class="curren">IP查询</a></li>
    <li><a href='{%site_url("sms/sms/ip_dept")%}'>IP配置</a></li>
    <div class="clearb"></div>
  </ul>
</div>
<div class="clearb"></div>
  <div class="searchbox" >
  <form   runat="server" onsubmit="return false;">
  <div class="searchNav">
  	<div class="searchform">
   
    <select name="publicType" class="styleSelect" id="publicType" size="1" >
     <option value="1"  >IP地址</option>
     <option value="2"  selected="selected">资产编号/帐号</option>
  </select>
  <input name="publicKey" id="publicKey" type="text" fs="可输入员工帐号或姓名查询" class="styleInput" st />
    </div>
    <div class="searchButton"><input type="submit" name="publicSearch" id="publicSearch" class="submitButton" value="搜索" /></div>
    <div class="clearb"></div>
    </div>
    </form>
  </div>
  
  <!-- /header -->
  <div class="clearb"></div>
  <!-- content --> 
  <div class="  pad10" id="showLayout"  style=" padding:10px; font-size:16px; ">
 			请输入完整的姓名或IT帐号查询。
 <div class="clearb"></div>
  </div>
  <!-- /content -->
  
 {%include file="../foot.tpl"%}