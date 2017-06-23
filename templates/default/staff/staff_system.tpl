{%include file="../header.tpl"%} 
<script src="{%base_url()%}assets/jstree/jquery.jstree.js" type="text/javascript"></script> 
<script type="text/javascript">
    //<![CDATA[
    $(document).ready(function(){
		// 浏览器的高度和div的高度  
     var height = $(window).height();  
	// var divHeight = $("#localJson").height();  
    $("#localJson").height(height - 185); 
	$("#localJson").css("overflow","auto"); 
    //div高度大于屏幕高度把屏幕高度赋给div，并出现滚动条 
	 
     var key ="";
	 var val = "";        
	 postdn("{%$id%}");
	 loadstaff("{%$id%}",key);
	  
	 $.ajax({
             type: "POST",
            url: "{%site_url('dept/deptsys/deptsys_tree')%}",
            data: "id={%$id%}",
            dataType:'json',
            success: function(msg){
                //data = eval(msg);
               
                outree = {"data": "Semir", state : "open", "attr":{"id":"0"},children:  msg};
                //alert(msg);
                 
				$("#localJson").jstree({ 
					"json_data" : {
						"data" : [ outree ]
					},
					"themes" : {
					 	"theme" : "classic",
						"dots" : true,
						"icons" : true
					},
					"plugins" : [ "themes", "json_data", "ui" ]
				}).bind("select_node.jstree", function (e, data) { 
				  //window.location = "{%site_url('staff/staff_system')%}/" + data.rslt.obj.attr("id");
				   key = "";
				  postdn(data.rslt.obj.attr("id"));
				  loadstaff(data.rslt.obj.attr("id"),key);
				  //postdn(data.rslt.obj.attr("id"));
				 });
												 
			}
        });
		$('input[name="searchBut"]').click(function(){
			key = $('input[name="key"]').val();
			if (key){
				val = '';
				postdn(0);
				loadstaff(val,key);	
				}
			//loadstaff(data.rslt.obj.attr("id"),key);
		});
        function postdn(val){
			 $.ajax({
                type: "POST",
                url: '{%site_url("dept/admanager/deptselect")%}',
                cache:false,
                data: 'id='+val,
                success: function(msg){
                    $("#ouShow").html(msg);
                    // alert(val);
                            
                },
                error:function(){
					jError("出错啦，刷新试试，如果一直出现，可以联系开发人员解决",{
						VerticalPosition : 'center',
						HorizontalPosition : 'center',});
                     
                }
            });
        }
		function loadstaff(val,key){
			 $.ajax({
                type: "POST",
                url: "{%site_url('staff/staff/staff_system_list')%}/"+val,
                cache:false,
				
                data: 'key='+key,
                success: function(msg){
                    $("#staffshow").html(msg);
					  $('button[name="edit"]').bind("click",edit); 
                    // alert(val);          
                },
                error:function(){
					jError("出错啦，刷新试试，如果一直出现，可以联系开发人员解决",{
						VerticalPosition : 'center',
						HorizontalPosition : 'center',});
                     
                }
            });
        }		
        // edit system   
        var edit = function(){
               $this = $(this).val();
                    $.ajax({
                        type: "POST",
                        url: "{%site_url('staff/staff/systemedit')%}",
                        data: "id="+$this,
                        success: function(msg){
                           //  alert(msg);
                             if(msg=="0"){ 
							 	jError("操作失败! ",{
									VerticalPosition : 'center',
									HorizontalPosition : 'center',
									TimeShown : 1000,
								});
							 }else{
								  $("#showLayout").html(msg);
								  hiBox('#showLayout','编辑用户系统权限','','','','.a_close');
								  $('#hiAlertform').bind("invalid-form.validate").validate(addjs);
								 }
                        }	   

                    });
                    return false;	

        };
		 var addjs = {
            rules: {
				id:{required: true} 
            },
            messages: {
                id:{required: "用户姓必填"}
            },
			submitHandler : function(){
			 
								 //表单的处理
								 var post_data = $("#hiAlertform").serializeArray();
								 
									 url = "{%site_url('staff/staff/staff_systemedit_save')%}";

								 hiClose();
								 $.ajax({
											 type: "POST",
												url: url,
												async:false,
												data:post_data,
												success: function(msg){
													if (msg == 1){
													 jSuccess("Success, current page is being refreshed",{
														VerticalPosition : 'center',
														HorizontalPosition : 'center',
														TimeShown : 100,
													});
													val = $('input[name="rootid"]').val();
													loadstaff(val,key);	
													//setInterval(function(){  window.location.reload();},400);	
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
		// edit system end
		
    });
    //]]>
</script>
<div id="showLayout" style="display:none;">
</div>
<div class="sidebarLeft ">
  <div class="pad10">
     
      <!--begin dept -->
    <div class="ouTreeTitle" >组织结构</div>
    <div class="ouTree pad5">
      <div id="localJson"><img src="{%$base_url%}templates/{%$web_template%}/images/loading.gif" width="16" height="16" />Loading...</div>
    </div>
  <!--end dept --> 
  </div>
  
  
</div>
<div class="sidebarMainTo"  style=" ">
<div class="pad10">
   
  <div class="fright searchTop"><input name="adOudn" id="adOudn" type="hidden" /><input name="key"  id="key" class="searchTopinput" type="text" /> <input name="searchBut" type="submit" class="searchTopbuttom" value=""  /></div>
  <div  class="pageTitleTop">用户管 理 &raquo; 系统权限 &raquo; </div>
  <div id="ouShow" class="pageTitle"></div>
  
  <div id="staffshow">
     Load staff info....
  </div>
  </div>
</div>
 
{%include file="../foot.tpl"%}