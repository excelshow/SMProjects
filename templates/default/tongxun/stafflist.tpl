<script type="text/javascript">
    //<![CDATA[
    $(document).ready(function(){
		 
		// addjs
		// check email
	 
		$('button[name="edit"]').bind("click",function(){
                     $.ajax({
                        type: "POST",
                        url: "{%site_url('tongxun/tongxun/staffmodify')%}/" + $(this).val(),
                        success:function(msg){
                            //alert(msg);
                            if(msg=="0"){
                                // $("tr#"+n).remove();
                                jError("操作成功! 正在刷新页面...",{
									VerticalPosition : 'center',
									HorizontalPosition : 'center',
									TimeShown : 2000,
								});
                              
                            }else{
                                 $("#showLayout").html(msg);
								  hiBox('#showLayout','编辑员工信息','','','','.a_close');
								  $('#hiAlertform').bind("invalid-form.validate").validate(addjs);
                            }
                        }	   
                    });

                    return false;
						
                }
		);
		 ///
		 
		 var addjs = {
            rules: {
				sa_tel:{required: true,maxlength: 13},
				sa_tel_short:{required: true,maxlength: 8}
            },
            messages: {
                sa_tel:{required: "办公电话必填",minlength: "最多13个字符"},
				sa_tel_short:{required: "分机必填",minlength: "最多8个字符"}
            },
			submitHandler : function(){
						   //表单的处理
						   var post_data = $("#hiAlertform").serializeArray();
						   url = "{%site_url('tongxun/tongxun/staffmodifycomplete')%}";
						   hiClose();
						   $.ajax({
								 type: "POST",
									url: url,
									async:false,
									data:post_data,
									success: function(msg){
										if (msg == "ok"){
											 jSuccess("操作成功"+msg+"! 正在刷新页面...",{
												VerticalPosition : 'center',
												HorizontalPosition : 'center',
												TimeShown : 1000
											});
											key = $('input[name="searchText"]').val();
											val = $('input[name="rootid"]').val();
											loadstaff(val,key)
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
		 
		 ///
		 $('div .staffInfo').hover(
			function () {
				 
				  //alert();
				  $(this).children(".staffName").children(".funShow").css("display","block");
				   //$(this).children("td").children("div").css("display","block");
			},
			function () {
				 $(this).children(".staffName").children(".funShow").css("display","none");
			}
		);
	  
		
		 
        
		// edit staff  end
		 
		$("button[name='page']").bind("click",function(){
					var url = $(this).val();
					var key = $('input[name="searchText"]').val();
					if(url!='undefined'){
						$.post(url,{ key: key},function(data){
							$('#staffshow').html(data)
						});
					}
				});
			 
    });
    //]]>
</script>
 <div class="pageNav">{%$links%}</div>
  <form name=""  method="post">
 
      {%if $data%}
      {%$rootDeptname = ''%}
      <ul class="txStaffList">
      {%foreach from=$data item=row key%}
    	{%if $row%}
        {%if $rootDeptname != $row->deptname%}
          
           <li class="deptName">{%$row->deptname%}</li>
           
        {%/if%}
       <li class="staffInfo"> 
       		<div class="staffName">
            	{%$row->cname%} 
                <div class="funShow" style=" display:none;">
                
           			{%if ($sysPermission["tongxun_edit"] == 1)%}
          				 <button class="button"  name="edit" type="button" value="{%$row->id%}">M</button>
           			{%/if%}
          		 
                </div>
           </div>
            <div class="staffTel">
       		{%if $row->address %}
               {%$row->address->sa_code%}-{%$row->address->sa_tel%} <br />
               {%$row->address->sa_mobile%}  
               {%else%}
               --
            {%/if%}  
               </div>
         <!-- {%$row->station%}-->
         
      </li>
      	{%$rootDeptname = $row->deptname%}
            {%else%}
          暂无记录！ 
          {%/if%}
      {%/foreach%}
      <div class="clearb"></div>
       </ul>
       
      {%else%}
      暂无记录！ 
      {%/if%}
       
  </form>
  <div class="pageNav">{%$links%}</div>
   