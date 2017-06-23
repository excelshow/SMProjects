{%include file="../header.tpl"%} 
 <link rel="stylesheet" href="{%base_url()%}assets/kindeditor/themes/default/default.css" />
	<link rel="stylesheet" href="{%base_url()%}assets/kindeditor/plugins/code/prettify.css" />
<script charset="utf-8" src="{%base_url()%}assets/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="{%base_url()%}assets/kindeditor/lang/en.js"></script>
<script>
		KindEditor.ready(function(K) {
				editor = K.create('textarea[name="sap_info"]', {
					resizeType : 1,
					allowPreviewEmoticons : false,
					allowImageUpload : false,
					items : [
						'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
						'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
						'insertunorderedlist', '|', 'emoticons', 'image', 'link'],
					 afterBlur: function(){this.sync();}
				});
				 
			});
$(document).ready(function(){
  var fromAct = {
            rules: {
				sap_name:{required: true} 
            },
            messages: {
                sap_name:{required: "名称必填"} 
            },
			submitHandler : function(){
						   //表单的处理
						   var post_data = $("#publicAdd").serializeArray();
						   url = "{%site_url('tongxun/tongxun/publicEditDo')%}";
						   hiClose();
						   $.ajax({
								 type: "POST",
									url: url,
									async:false,
									data:post_data,
									success: function(msg){
										if (msg == 'ok'){
											 jSuccess("操作成功"+msg+"! 正在刷新页面...",{
												VerticalPosition : 'center',
												HorizontalPosition : 'center',
												TimeShown : 1000
											});
										// setInterval(function(){window.location="{%site_url('tongxun/tongxun/publiclist')%}";},1000);
											 
										}else{
											jError("操作失败! ",{
												VerticalPosition : 'center',
												HorizontalPosition : 'center',
												TimeShown : 1000
											});
									   }
									}
								});
						   return false;//阻止表单提交
				}
        };
		$('#publicAdd').validate(fromAct);
	});
	</script>
    <div id="showLayout" style="display:none"></div>
<div class=""  style=" "> 
<div class="pad10">
 
   {%if ($sysPermission["tongxun_edit"] == 1)%}
     <div class="fright " style="background:#F7F7F7; padding:3px 20px 4px 20px;">
    
    <a href="{%site_url('tongxun/tongxun/publicAdd')%}" class="buttom" >新增公共联系信息</a>
     
     
     </div>
      {%/if%}
  <div  class="pageTitleTop">通讯录 &raquo; 公共联系方式 &raquo; </div>
  	<div class="h5"></div>
  	<div class="h10"></div>
  <div id="staffshow">
  <div class="staffadd pad5 " style="  ">
    
    <!--begin form -->
    <form id="publicAdd" method="post" action="" name="publicAdd" >
    
    <!--begin form -->
    <div class="staffformInfo fleft">
 
          <div  class="formLab">名称</div>
          <div class="formcontrol">
            <input name="sap_name"  class="inputText" type="text" id="sap_name"   value="{%$data->sap_name%}" />
          </div>
          <div class="formLine  clearb" ></div>
          <div  class="formLab">排序</div>
      <div class="formcontrol">
        <input name="sap_sort"  class="inputText" type="text" id="sap_sort"    value="{%$data->sap_sort%}" />
      </div>
          <div class="formLine clearb " ></div>
           <div  class="formLab">内容</div>
          <div class="formcontrol">
            <textarea name="sap_info" cols="80" rows="10" class="inputText" id="sap_info">{%$data->sap_info%}</textarea>
          </div>
          <div class="formLine clearb " ></div>
          <div  class="formLab">&nbsp;</div>
          <div class="formcontrol">
            <input name="sap_id" id="sap_id" type="hidden" value="{%$data->sap_id%}" />
             
            <input name="addcomplete" class="buttom" type="submit" value="提交完成" />
            &nbsp;&nbsp;
            <input type="button" onclick=" " class="a_close buttom" value="放弃" />
          </div>
      
    </div>
    <div class=" clearb"> </div>
    </form>
    <!--end form --> 
   
   </div>
  </div>
</div>{%include file="../foot.tpl"%}