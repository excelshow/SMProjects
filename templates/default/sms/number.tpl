{%include file="../header.tpl"%} 
<link rel="stylesheet" media="screen,projection" type="text/css" href="{%$base_url%}templates/{%$web_template%}/sms/css/stlye.css" />

<script type="text/javascript">
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='{%site_url('sms/sms/number')%}/"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>

<script src="{%base_url()%}assets/jstree/jquery.jstree.js" type="text/javascript"></script> 
  
<script type="text/javascript">
    // JavaScript Document
 $(document).ready(function(){
	 // 浏览器的高度和div的高度  
     var height = $(window).height();  
	// var divHeight = $("#localJson").height();  
    $("#localJson").height(height - 185); 
	$("#localJson").css("overflow","auto"); 
    //div高度大于屏幕高度把屏幕高度赋给div，并出现滚动条  
     
   // add and edit  menu start
        $("button[name='numberadd']").click(function(){
			   
				 hiBox('#form','新加资产编号',400,'','','.a_close');	
				 $('#hiAlertform').bind("invalid-form.validate").validate(addjs);
							 
        });
  
  	var addjs = {
            rules: {
				 
				number:{digits:true} 
            },
            messages: {
                
				number:{digits:"必须整数"} 
            },
			submitHandler : function(){
						   //表单的处理
						   var post_data = $("#hiAlertform").serializeArray();
						   url = "{%site_url('sms/sms/number_add_save')%}";
						   hiClose();
						   $.ajax({
								 type: "POST",
									url: url,
									async:false,
									data:post_data,
									success: function(msg){
										if (msg == 1 ){
											 jSuccess("操作成功! 正在刷新页面...",{
												VerticalPosition : 'center',
												HorizontalPosition : 'center',
												TimeShown : 500,
											});
											 setInterval(function(){window.location.reload();},600);	
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
		 
		
		 
    });
    //]]>
   
</script>

<div id="showLayout" style="display:none;">
   
   
</div>
<!-- form -->
<div class="staffadd pad5 " id="form" style=" display:none;">
    
    <!--begin form -->
    <div class="staffformInfo">
   	 
          <div  class="formLab">类别名称:</div>
          <div  class="formLabt"> 
          	<select name="type" id="type" class="searchTopinput ">
              <option value="S" {%if $type=='S'%} selected="selected" {%/if%}>股份、森马事业部、巴拉事业部</option>
              <option value="M" {%if $type=='M'%} selected="selected" {%/if%}>女装事业部</option>
                <option value="C" {%if $type=='C'%} selected="selected" {%/if%}>马卡乐</option> 
              <option value="L" {%if $type=='L'%} selected="selected" {%/if%}>森马上海零售部</option>
              <option value="B" {%if $type=='B'%} selected="selected" {%/if%}>巴拉上海分公司</option>
              <option value="T" {%if $type=='T'%} selected="selected" {%/if%}>天津物流部</option>
              <option value="Y" {%if $type=='Y'%} selected="selected" {%/if%}>意森服饰</option>
              <option value="W" {%if $type=='W'%} selected="selected" {%/if%}>路由器</option>
               <option value="P" {%if $type=='P'%} selected="selected" {%/if%}>网络打印机</option> 
               <option value="R" {%if $type=='R'%} selected="selected" {%/if%}>森睿</option> 
				<option value="X" {%if $type=='X'%} selected="selected" {%/if%}>盛夏</option> 
        
            </select>
          </div>
     
          <div class="h10 clearb"> </div>
          <div  class="formLab">编号数量:</div>
          <div  class="formLabt"><input name="number" type="text"  class="inputText" id="number" value="1"   /></div>
         
          <div class="h10 clearb"> </div>
          
          <div class="formLine clearb " ></div>
          <div  class="formLab">&nbsp;</div>
          <div class="formcontrol">
            
           
            <input name="addcomplete" class="buttom" type="submit" value="提交完成" />
            &nbsp;&nbsp;
            <input type="button" onclick=" " class="a_close buttom" value="放弃" />
          </div>
      
    </div>
    <div class=" clearb"> </div>
    </div>
  <!-- form end -->
<div class="sidebarLeft ">
  
    <!--begin dept -->
  <div class="pad10">
    <div class="ouTreeTitle" >配置选择</div>
    <div class="ouTree ">
      <div id="localJson">
      {%$showmenu%}
      </div>
    </div>
  </div>
  
  <!--end dept --> 
</div>
<div class="sidebarMainTo"  style=" ">
<div class="pad10">
<div class="fright" style="padding:2px 2px 0 0;">
  
    <select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu('parent',this,0)"  class="searchTopinput ">
      <option value="S" {%if $type=='S'%} selected="selected" {%/if%}>股份、森马事业部、巴拉事业部</option>
      <option value="M" {%if $type=='M'%} selected="selected" {%/if%}>女装事业部</option>
      <option value="C" {%if $type=='C'%} selected="selected" {%/if%}>马卡乐</option> 
      <option value="L" {%if $type=='L'%} selected="selected" {%/if%}>森马上海零售部</option>
      <option value="B" {%if $type=='B'%} selected="selected" {%/if%}>巴拉上海分公司</option>
      <option value="T" {%if $type=='T'%} selected="selected" {%/if%}>天津物流部</option>
      <option value="Y" {%if $type=='Y'%} selected="selected" {%/if%}>意森服饰</option>
      <option value="I" {%if $type=='I'%} selected="selected" {%/if%}>投资公司</option>
      <option value="C" {%if $type=='C'%} selected="selected" {%/if%}>马卡乐</option> 
      <option value="W" {%if $type=='W'%} selected="selected" {%/if%}>路由器</option> 
       <option value="P" {%if $type=='P'%} selected="selected" {%/if%}>网络打印机</option> 
<option value="R" {%if $type=='R'%} selected="selected" {%/if%}>森睿</option> 
<option value="X" {%if $type=='X'%} selected="selected" {%/if%}>盛夏</option> 
    </select>
   
</div>
<div  class="pageTitleTop">资产管理 &raquo; 配置管理 &raquo; 资产编号</div>
 
 <div class="h5"></div>
 
  <div id="staffshow" >
  	<div><button class="buttom" value="" type="button" name="numberadd">资产编号批量生成</button></div>
     <div class="h5"></div>
  	<ul class="number_list">
     {%foreach from=$data item=row%}
        <li>{%$row->sms_number%}</li>
    {%/foreach%}
    <div class="clearb"></div>
    </ul>                          
  </div>
  </div>
</div>
 
{%include file="../foot.tpl"%}