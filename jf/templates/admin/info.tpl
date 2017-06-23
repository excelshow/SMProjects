 {%include file="../admin/header.tpl"%} 
 <script type="text/javascript" src="{%base_url()%}assets/javascript/uploadify/jquery.uploadify.v2.1.0.min.js"></script>
<script type="text/javascript" src="{%base_url()%}assets/javascript/uploadify/swfobject.js"></script>
 <script language="JavaScript" src="{%base_url()%}assets/calendar.js"></script>
<link rel="stylesheet" href="{%base_url()%}assets/javascript/uploadify/uploadify.css" type="text/css" />
<script type="text/javascript" src="{%base_url() %}assets/javascript/uploadify/ajaxupload.js"></script>
<script type="text/javascript">
    //<![CDATA[
 
        $(document).ready(function(){
             $("#treeTable").treeTable();

			$("table#treeTable tbody tr:odd").addClass('even');

			$("table#treeTable tbody tr").mousedown(function() {

			$("tr.selected").removeClass("selected"); // Deselect currently selected rows

			  $(this).addClass("selected");

			});

			 

			$('table#treeTable tbody tr').hover(

				function () {

					$(this).addClass("hover");

				},

				function () {

					$(this).removeClass("hover");

				}

			);

            {%if ($action=="view") %}
				$('button[name="infoadd"]').click(function(){
						window.location = "{%site_url('admin/info/add_info')%}/";
            	});
				$('#selectCla').change(function(){
					$this = $("#programSel").val();
						window.location = "{%site_url('admin/info/index')%}/"+$("#selectCla").val();
            	});
				
            	$('button[name="edit"]').click(function(){
						window.location = "{%site_url('admin/info/edit_info') %}/" + $(this).val();
            	});
            	$('button[name="del"]').click(function(){
                	$this = $(this).val();
					  hiConfirm('Confirm Delete?',null,function(tp){
					 
						 if(tp){
							$.ajax({
							   type: "POST",
							   url: "{%site_url('admin/info/physical_del')%}",
							   data: "article_id="+$this,
							   success: function(msg){
								   //alert(msg);
								   if(msg=="ok"){
									  // $("tr#"+n).remove();
									  jSuccess("Success, current page is being refreshed",{
														VerticalPosition : 'center',
														HorizontalPosition : 'center',
														TimeShown : 2000,
													});
               							 setInterval(function(){window.location.reload();},1000);
										//window.location = "{%site_url('admin/info/') %}";
									
								   }else{
										//alert(msg);
								   }
							   }
							   
							}); 

							return false;
						
						 }
					 
					 });
            	});
            	$('#all_check').click(function(){
						//$("tr input[type='checkbox']").attr('checked',$(this).attr('checked'));
						$("input[name='article_id']").each(function(){
						     $(this).attr("checked",!this.checked); 
						  });  
            	});
            	$("input[name='submit']").click(function(){
						if(!$(".all_check:checked").length){
							return false;
						}
						 
							  hiConfirm('Confirm Delete?',null,function(tp){
								 if(tp){
									 
									 var str="";  
										$("[name='article_id'][checked]").each(function(){  
										str+=$(this).val()+",";  
										alert($(this).val());  
										})  
										$.ajax({
										   type: "POST",
										   url: "{%site_url('admin/info/physical_del')%}",
										   data: "article_id="+str,
										   success: function(msg){
											   //alert(msg);
											   if(msg=="ok"){
												  // $("tr#"+n).remove();
												  jSuccess("Success, current page is being refreshed",{
																	VerticalPosition : 'center',
																	HorizontalPosition : 'center',
																	TimeShown : 2000,
																});
													 setInterval(function(){window.location.reload();},1000);
													//window.location = "{%site_url('admin/info/') %}";
												
											   }else{
													//alert(msg);
											   }
										   }
										   
										}); 
			
										return false;
								 }
							});
						 
            	});

				            	
            	 
            {%/if%}
			
            
            // function articels start
			 var validation1 = {
            rules: {
                title: {required: true,minlength: 2},
				classId: {required: true}
            },
            messages: {
                title: {required: "Please enter a title",minlength: "minimum 2 characters"},
				classId: {required:"Please select a category"}
            },
            submitHandler:function(){
                var post_data = $("#functionInfo").serializeArray();
                var post_url;
				var functionType = "{%$action%}";
				// alert("dddd");
                if(functionType == "add"){
                    post_url = "{%site_url('admin/info/add')%}";
                }else{
                    post_url = "{%site_url('admin/info/edit')%}";
                }
				
                $.ajax({
                    type: "POST",
                    url: post_url,
                    cache:false,
                    data: post_data,
                    success: function(msg){
						 
                        flag = (msg=="ok");
                        if(flag){
                            // $("#editbox").html("");
                             jSuccess("Success, current page is being refreshed",{
														VerticalPosition : 'center',
														HorizontalPosition : 'center',
														TimeShown : 2000,
													});
						 setInterval(function(){  window.location = "{%$reurl%}";},1000);
                            //  Alert(msg);
                        }else{
                            Alert(msg);
                        }
                    },
                    error:function(aaa,b){
						 jError("Error! Please contact system administrator",{

									VerticalPosition : 'center',

									HorizontalPosition : 'center',

									TimeShown : 1000,

								});
                    }
                });


                return false;
            }
        };

			$('#functionInfo').validate(validation1);
            
			// function articels end
			
			//upload Pic and PDF satart
			{%if ($action=="edit" || $action=="add")%}
			new AjaxUpload('buttonpic', {
            action: "{%site_url('admin/info/uploadPicLink')%}",
            name: 'userfile',
            responseType:false,
				onSubmit : function(file , ext){
					//alert(ext);
					if (!(ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
						Alert('This format is not allowed.');
						// cancel upload
						return false;
					}
					$('#buttonpic').text('' + file);
					this.disable();
				},
				onComplete: function(file, response){
					//  alert(response);
					//alert($(response.'#realname').html());
				   $('#buttonpic').html('Select File:'+file +' ' + response); // 获取 上传文件名
					 $('#article_pic').val($('#realname').text()); // 给input 赋值
					
					 $('#show_Pic').html("<img src='{%base_url()%}attachments/info/"+$('#realname').text()+"' />");
				}
       		});
			// delet Pic
			$("#del_Pic").click(function(){
				hiConfirm('Confirm Delete?',null,function(tp){
					if(tp){
					 
						$('#show_Pic').html("");
						$('#article_pic').val("");
						$('#del_Pic').text("");
					 
				}
				});
			});
			 
			{%/if%}
        
		//upload Pic and PDF end
        });
    	 
        
    //]]>
</script>
 
{%if ($action=="add")%}
<link rel="stylesheet" href="{%base_url()%}assets/kindeditor/themes/default/default.css" />
	<link rel="stylesheet" href="{%base_url()%}assets/kindeditor/plugins/code/prettify.css" />
<script charset="utf-8" src="{%base_url()%}assets/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="{%base_url()%}assets/kindeditor/lang/en.js"></script>
<script charset="utf-8" src="{%base_url()%}assets/kindeditor/plugins/code/prettify.js"></script>
<script>
		KindEditor.ready(function(K) {
			var editor1 = K.create('textarea[name="article_con"]', {
				cssPath : '{%base_url()%}assets/kindeditor/plugins/code/prettify.css',
				uploadJson : '{%base_url()%}assets/kindeditor/php/upload_json.php',
				fileManagerJson : '{%base_url()%}assets/kindeditor/php/file_manager_json.php',
				allowFileManager : true,
				allowPreviewEmoticons : false,
				allowImageUpload : true,
				afterBlur:function(){this.sync();},
				    //设置编辑器为简单模式
                    items : [
                        'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
                        'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
                        'insertunorderedlist', '|', 'emoticons', 'image', 'link','media','insertfile','source'],
			});
			prettyPrint();

		});

	</script>
<div style="padding:10px;">
<form id="functionInfo" action="" method="post">
<table>
	<thead><tr><th colspan="2">添加信息</th></tr></thead>
    <tr>
      <td>信息类别</td>
      <td> 
      <select id="classId" name="classId" >
      <option value=""> 请选择信息类别</option>
        
       {%foreach from=$data['menu'] item=row%}
       <option value="{%$row->id %}">
      	 {%section name=0 loop=$row->deep%}
          &nbsp
         {%/section%}
	   {%if ($row->parent_id) %}  - {%/if%} {%$row->menuName %}
       
       </option>
       {%/foreach%}
       </select>
      </td>
    </tr>
    <tr><td width="100">信息标题</td><td><input name="title" type="text" value="" size="40" /></td></tr>
    <tr><td valign="top">信息简介(Seo Description)</td><td><textarea name="description" cols="40"></textarea></td></tr>
        <tr><td>信息关键字(Seo Keyword)</td><td><input name="keyword" type="text" value="" size="40" /></td></tr>
 <tr>
      <td>图片/Photo</td>
      <td> 
     <div style=" margin-left:700px;position:absolute;text-align:right;">
     <div id="show_Pic" style=" "></div>  
     </div>
      <a href="javascript:;" id="buttonpic">Select a photo/ View photo</a> <a id="del_Pic"></a>
                <input type="hidden" name="proPic" id="proPic" value="" />(Stlye：PNG)</td>
    </tr>
    <tr><td>信息内容</td><td>
      <textarea  name="article_con" cols="100" rows="20" id="article_con" ></textarea>
    </td></tr>
    
    <tr>
  
    <tr>
      <td>上传日期</td><td><input type="text" name="post_time" value="{%date("Y-m-d")%}" onFocus="calendar(event)" />
         </td></tr>
    <tr><td>信息作者</td><td><input type="text" name="author" readonly="readonly" value="{%$smarty.session.admin%}" /></td></tr>
  
    <tr><td>信息编辑</td><td><input type="text" readonly="readonly" name="edit_author" value="{%$smarty.session.admin%}" /></td></tr>
  
    <tr><td>&nbsp;</td>
      <td height="40px;"><input type="submit" name="btn_add" id="btn_add" value=" 添加信息 "  class="infoAdd" />
      <input type="reset" name="btn_cancel" id="btn_cancel" value=" 重新填写 "  class="buttom" /> <input type="button" name="btn_back" id="btn_back" value=" 放弃添加 "  class="buttom" onclick="javascript:history.go(-1);" /></td>
    </tr>
</table>
</form>
</div>
{%/if%}
 
{%if ($action == "edit")%}
<link rel="stylesheet" href="{%base_url()%}assets/kindeditor/themes/default/default.css" />
	<link rel="stylesheet" href="{%base_url()%}assets/kindeditor/plugins/code/prettify.css" />
<script charset="utf-8" src="{%base_url()%}assets/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="{%base_url()%}assets/kindeditor/lang/en.js"></script>
<script charset="utf-8" src="{%base_url()%}assets/kindeditor/plugins/code/prettify.js"></script>
<script>
		KindEditor.ready(function(K) {
			var editor1 = K.create('textarea[name="article_con"]', {
				cssPath : '{%base_url()%}assets/kindeditor/plugins/code/prettify.css',
				uploadJson : '{%base_url()%}assets/kindeditor/php/upload_json.php',
				fileManagerJson : '{%base_url()%}assets/kindeditor/php/file_manager_json.php',
				allowFileManager : true,
				allowPreviewEmoticons : false,
				allowImageUpload : true,
				afterBlur:function(){this.sync();},
				    //设置编辑器为简单模式
                    items : [
                        'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
                        'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
                        'insertunorderedlist', '|', 'emoticons', 'image', 'link','media','insertfile','source'],
			});
			prettyPrint();

		});

	</script>
 {%foreach from=$data['info'] item=row%}
<div style="padding:10px">
<form id="functionInfo" action="" method="post">
<table  class="treeTable">
	<thead><tr><th colspan="2">编辑信息</th></tr></thead>
     <tr>
      <td>信息类别</td>
      <td>
       
      <select id="classId" name="classId" >
      <option value="">请选择信息类别</option>
        
       {%foreach from=$data['menu'] item=rown%}
       <option value="{%$rown->id %}" {%if ($rown->id == $row->classId)%} selected="selected" {%/if%} >
        {%section name=0 loop=$rown->deep%}
          &nbsp 
        {%/section%}
	   {%if ($rown->parent_id)%}  - {%/if%}{%$rown->menuName %}
       
       </option>
       {%/foreach%}
       </select>
      </td>
    </tr>
    <tr><td width="100">信息标题</td><td><input name="title" type="text" value="{%$row->title%}" size="40" /></td></tr>
    <tr>
      <td valign="top">信息简介(Seo Description)</td>
      <td><textarea name="description" cols="40" class="">{%$row->description%}</textarea></td>
      </tr>
      <tr>
        <td>信息关键字(Seo Keyword)</td>
        <td><input name="keyword" type="text" value="{%$row->keyword%}" size="40" /></td>
      </tr>
      <tr>
      <td>图片/Photo</td>
      <td> 
      <div style=" margin-left:700px;position:absolute;text-align:right;">
     <div id="show_Pic" style=" ">
     {%if ($row->article_pic != "")%}
     <img src='{%base_url("attachments/info/")%}/{%$row->article_pic%}' />
     {%/if%}
     </div>  
     </div>
      <a id="buttonpic">更换图片/ View photo</a>&nbsp;&nbsp; <a id="del_Pic"> -- 删除图片 / Delet Photo </a>
                <input type="hidden" name="article_pic" id="article_pic" value="{%$row->article_pic%}" />(Stlye：PNG)</td>
    </tr>
    <tr><td>信息内容</td><td>
      <textarea  name="article_con" cols="80" rows="20" id="article_con"  >{%$row->content%}</textarea>
    </td></tr>
   
    <tr>
      <td>上传日期</td><td><input type="text" name="post_time" value="{%date('Y-m-d',strtotime($row->post_time))%}" onFocus="calendar(event)" />
        </td></tr>
    <tr><td>信息作者</td><td><input type="text" name="author" value="{%$row->author%}"  readonly="readonly"/></td></tr>
    
    <tr><td>信息编辑</td><td><input type="text" readonly="readonly" name="edit_author" value="{%$smarty.session.admin%}" /></td></tr>
   
    <tr><td>&nbsp;</td>
      <td><input type="submit" name="submit" value=" 编辑信息 "  class="infoAdd" /><input type="hidden" name="article_id" value="{%$row->article_id%}" />   <input type="reset" name="btn_cancel" id="btn_cancel" value=" 重新填写 "  class="buttom" /> <input type="button" name="btn_back" id="btn_back" value=" 放弃编辑 "  class="buttom" onclick="javascript:history.go(-1);" /></td>
    </tr>
</table>
</form>
</div>
{%/foreach%}
{%/if%}

{%if ($action=="view")%}
<div style="padding:10px" >
  <div class="pad10">
  		<button class="infoAdd" name="infoadd">添加信息</button>
        &nbsp;&nbsp;
 		<select id="selectCla" name="selectCla"   >
        <option value="0" {%if ($classid == 0)%} selected="selected" {%/if%}>请选择信息类别</option>
        
       {%foreach from=$data['menu'] item=rown%}
       <option value="{%$rown->id %}" {%if ($rown->id == $classid)%} selected="selected" {%/if%} >
        {%section name=0 loop=$rown->deep%}
         &nbsp
        {%/section%}
	   {%if ($rown->parent_id)%} - {%/if%}{%$rown->menuName %}
       
       </option>
       {%/foreach%}
       </select>
    
	   </div>
   
 <div class="clearb"></div>
<form action="" method="post">
	<table  class="treeTable" id="treeTable">
	<thead><tr><th width="40"><input id="all_check" type="checkbox"/></th><th>信息标题</th>
	  <th>简介</th><th>作者</th> <th>所属类别</th><th>操作</th></tr></thead>
	 
     {%foreach from=$data['infos'] item=row%}
	<tr id="{%$row->article_id%}">
		<td><input class="all_check" type="checkbox" name="article_id" value="{%$row->article_id%}"/></td>
		<td>{%$row->title%}</td>
		<td>{%$row->description%}</td>
		<td>{%$row->author%}</td>
		 
		<td>{%$row->menuName%}</td>
		<td>
		 
		<button class="edit" name="edit" type="button"
			value="{%$row->article_id%}"></button>
		<button class="delete" name="del" type="button"
			value="{%$row->article_id%}"></button>
		 
		</td>
	</tr>
	{%/foreach%}
	<tr>
		<td>
			<input type="button" value="   submit" name="submit"  class="delete"/>
 
		</td>
		
		 <td>&nbsp;</td> 
		<td colspan="5">&nbsp;</td>
	</tr>
	</table>
	</form>	
    <div align="center">{%$links%}</div>
</div>
{%/if%}
{%include file="../admin/foot.tpl"%}