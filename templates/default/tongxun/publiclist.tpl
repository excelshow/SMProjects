{%include file="../header.tpl"%} 
 <link rel="stylesheet" href="{%base_url()%}assets/kindeditor/themes/default/default.css" />
	<link rel="stylesheet" href="{%base_url()%}assets/kindeditor/plugins/code/prettify.css" />
<script charset="utf-8" src="{%base_url()%}assets/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="{%base_url()%}assets/kindeditor/lang/en.js"></script>
<script charset="utf-8" src="{%base_url()%}assets/kindeditor/plugins/code/prettify.js"></script>
<script>
		KindEditor.ready(function(K) {
				editor = K.create('textarea[name="article_con"]', {
					resizeType : 1,
					allowPreviewEmoticons : false,
					allowImageUpload : false,
					items : [
						'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
						'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
						'insertunorderedlist', '|', 'emoticons', 'image', 'link']
				});
			});

	</script>
<script type="text/javascript">
   
    //<![CDATA[
     
    $(document).ready(function(){
		 
	// del
   $('button[name="del"]').bind("click", function(){
				$this = $(this).val();
				hiConfirm('确认删除此信息？',null,function(tp){
					if(tp){
						$.ajax({
							type: "POST",
							url: "{%site_url('tongxun/tongxun/publicDel')%}",
							data: "id="+$this,
							success: function(msg){
								//alert(msg);
								if(msg=="ok"){
									// $("tr#"+n).remove();
									jSuccess("操作成功! 正在刷新页面...",{
										VerticalPosition : 'center',
										HorizontalPosition : 'center',
										TimeShown : 1000,
									});
							        setInterval(function(){window.location.reload();},1000);
									 
								}else{
									hiAlert(msg);
								}
							}
								   
						});
						return false;
							
					}
				});
			});
	  
       
    });
    //]]>
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
    
  	<table  class="treeTable" id="treeTable">
      <thead>
        <tr>
          <th>标题</th>
          <th>排序</th>
          <th>内容</th>
           <th>管理</th>
          </tr>
      </thead>
      <tbody>
      
      {%if ($data)%}
      {%foreach from=$data item=row%}
      <tr id="{%$row->sap_id%}">
      
        <td>{%$row->sap_name%}</td> 
         <td>{%$row->sap_sort%}</td>
         <td>{%$row->sap_info%}</td> 
        <td>
          {%if ($sysPermission["tongxun_edit"] == 1)%}
            <a href="{%site_url('tongxun/tongxun/publicEdit')%}/{%$row->sap_id%}" class="buttom" >编辑</a>
          
          <button class="button"  name="del" type="button" value="{%$row->sap_id%}">删除</button>
            {%/if%}
          </td> 
        
        </tr>
      {%/foreach%}
      {%/if%}
     </tbody>
      
    </table>
   
  </div>
  </div>
</div>{%include file="../foot.tpl"%}