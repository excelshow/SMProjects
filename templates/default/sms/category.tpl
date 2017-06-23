{%include file="../header.tpl"%} 
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
     $("#tbalemenu").treeTable({expandable:true});
        $("tr:odd").addClass('even');
        $("tr").hover(
        function () {
            $(this).addClass("hover");
        },
        function () {
            $(this).removeClass("hover");
        }
    );
   // add and edit  menu start
        $("button[name='new']").click(function(){
			  $.ajax({
                        type: "POST",
                        url: "{%site_url('sms/config/category_add')%}/" + $(this).val(),
                        success:function(msg){
                            //alert(msg);
						   if (msg == 0){
								jError("操作失败! ",{
									VerticalPosition : 'center',
									HorizontalPosition : 'center',
									TimeShown : 1000,
								});
							}else{
								 $("#showLayout").html(msg);
								 hiBox('#showLayout','新加资产类别',400,'','','.a_close');	
								  $('#hiAlertform').bind("invalid-form.validate").validate(addjs);
							}
                        }	   
                    });
                    return false;  
        });
  
  	var addjs = {
            rules: {
				sc_name:{required: true,maxlength: 20},
				sc_sort:{digits:true} 
            },
            messages: {
                sc_name:{required: "类别名称必填",minlength: "最多20个字符"},
				sc_sort:{digits:"必须整数"} 
            },
			submitHandler : function(){
						   //表单的处理
						   var post_data = $("#hiAlertform").serializeArray();
						   url = "{%site_url('sms/config/category_add_save')%}";
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
		 $("button[name='edit']").click(function(){
			  $.ajax({
                        type: "POST",
                        url: "{%site_url('sms/config/category_edit')%}/" + $(this).val(),
                        success:function(msg){
                            //alert(msg);
						   if (msg == 0){
								jError("操作失败! ",{
									VerticalPosition : 'center',
									HorizontalPosition : 'center',
									TimeShown : 1000,
								});
							}else{
								 $("#showLayout").html(msg);
								 hiBox('#showLayout','新加资产类别',400,'','','.a_close');	
								  $('#hiAlertform').bind("invalid-form.validate").validate(editjs);
							}
                        }	   
                    });
                    return false;  
        });
  
  	var editjs = {
            rules: {
				sc_name:{required: true,maxlength: 20},
				sc_sort:{digits:true} 
            },
            messages: {
                sc_name:{required: "类别名称必填",minlength: "最多20个字符"},
				sc_sort:{digits:"必须整数"} 
            },
			submitHandler : function(){
						   //表单的处理
						   var post_data = $("#hiAlertform").serializeArray();
						   url = "{%site_url('sms/config/category_edit_save')%}";
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
											  setTimeout(function(){window.location.reload();},600);	
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
		
		////////////////////////////////////////////////
		$('button[name="del"]').bind("click", function(){
				$this = $(this).val();
				hiConfirm('确认删除此类别？','删除信息',function(tp){
					if(tp){
						$.ajax({
							type: "POST",
							url: "{%site_url('sms/config/category_del')%}",
							data: "sc_id="+$this,
							success: function(msg){
								//alert(msg);
								if(msg==1){
									// $("tr#"+n).remove();
									jSuccess("操作成功! 正在刷新页面...",{
										VerticalPosition : 'center',
										HorizontalPosition : 'center',
										TimeShown : 500,
									}); 
									 setTimeout(function(){window.location.reload();},600);
									//window.location = "{site_url('staff/') ?>";
										
								}else{
									jError("操作失败! ",{
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
		);
    });
    //]]>
   
</script>
<div id="showLayout" style="display:none;">
   
   
</div>
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
<div  class="pageTitleTop">资产管理 &raquo; 配置管理 &raquo; 资产类别</div>
 
 <div class="h5"></div>
 
  <div id="staffshow" >
      <table id="tbalemenu" >
            <thead><tr><th></th>
              <th>类别</th>
            <th>ID</th><th>显示顺序</th><th>操作选项</th></tr></thead>
            <tr id="node-root">
              
                <td><span class="root">资产管理
                   
                </span></td>
                <td>&nbsp;</td>
                <td>&nbsp; </td>
                <td></td>
                <td>
                    <button class="add" name="new" type="button" value="0"></button>
                </td>
            </tr>
   	 
     {%foreach from=$data item=row%}
                        <tr id="node-{%$row->sc_id%}"	{%if ($row->sc_root)%}	class="child-of-node-{%$row->sc_root%}"    {%else%}    class="child-of-node-root"	{%/if%}	>
                       
                                    <td>
                                        <span class={%if $row->children%} "folder" {%else%} "file" {%/if%}>{%$row->sc_name%}</span>
                                    </td>
                                    <td>
                                    {%if ($row->sc_type == 1)%}
                                    	固定资产
                                    {%else%}
                                    	<span class="fontGreen">耗材资产</span>
                                    {%/if%}
                                    </td>
                                     <td>{%$row->sc_id%}</td>
                                    <td>
                                        <span class="sequence" id="optional_{%$row->sc_id%}">{%$row->sc_sort%}</span>
                                    </td>
                                    <td>

                                        <button class="add" name="new" type="button" value="{%$row->sc_id%}" title="添加栏目"></button>
                                        <button class="action edit" name="edit" type="button" value="{%$row->sc_id%}" title="修改栏目"></button>
            {%if (!$row->children)%}
                                    <button class="action delete" name="del" type="button" value="{%$row->sc_id%}" title="删除栏目" ></button>
            {%/if%}
                                </td>
                            </tr>
    {%/foreach%}
                                </table>
  </div>
  </div>
</div>
 
{%include file="../foot.tpl"%}