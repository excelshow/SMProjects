<?php include("header.php")?>

<script type="text/javascript" src="<?php echo base_url()?>assets/javascript/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/javascript/uploadify/jquery.uploadify.v2.1.0.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/javascript/uploadify/swfobject.js"></script>
 <script language="JavaScript" src="<?php echo base_url()?>assets/calendar.js"></script>


<script type="text/javascript">
    //<![CDATA[
	var Alert=ymPrompt.alert;
        $(document).ready(function(){
            $("table:first tr:odd").addClass('even');
            $('"table:first tr').hover(
					function () {
							$(this).addClass("hover");
					 },
					 function () {
							$(this).removeClass("hover");
					 }
			);

            <?php if($action=="view"):?>
            	$('button[name="edit"]').click(function(){
						window.location = "<?php echo site_url('admin/product/edit_product') ?>/" + $(this).val();
            	});
            	$('button[name="del"]').click(function(){
                	$this = $(this).val();
					 ymPrompt.confirmInfo('产品确认框功能测试',null,null,null,handler);
					 function handler(tp){
						 if(tp=='ok'){
							$.ajax({
							   type: "POST",
							   url: "<?php echo site_url('admin/product/physical_del')?>",
							   data: "product_id="+$this,
							   success: function(msg){
								   //alert(msg);
								   if(msg=="ok"){
									  // $("tr#"+n).remove();
									   ymPrompt.succeedInfo({message:'操作成功！请稍候, 正在刷新页面....'});
               							 setInterval(function(){window.location.reload();},1000);
										//window.location = "<?php echo site_url('admin/product/') ?>";
									
								   }else{
										//alert(msg);
								   }
							   }
							   
							}); 

							return false;
						
						 }
					 }
            	});
            	$('#all_check').click(function(){
						$("tr input[type='checkbox']").attr('checked',$(this).attr('checked'));
            	});
            	$("input[name='submit']").click(function(){
						if(!$(".all_check:checked").length){
							return false;
						}
						<?php //if($mode=="recycle"):?>
							if(!confirm('确定要删除这些产品吗？'))
								return false;
							else
								$("form").attr('action','<?php echo site_url('admin/product/physical_del') ?>?q=<?php echo $q; ?>&v=<?php echo $v; ?>&mode=<?php echo $mode; ?>');
						<?php // endif;?>
            	});

				            	
            	$("select[name='class_id']").change(function(){
							window.location = "<?php echo site_url('admin/product/view') ?>?q="+$(this).val()+"&v="+$("select[name='is_verified']").val()+"&mode=<?php echo $mode ?>";
            	});
            	$("select[name='is_verified']").change(function(){
					window.location = "<?php echo site_url('admin/product/view') ?>?q="+$("select[name='class_id']").val()+"&v="+$(this).val()+"&mode=<?php echo $mode ?>";
    			});
            <?php endif;?>
			
            
            // function articels start
			 var validation1 = {
            rules: {
                proName: {required: true,minlength: 2},
				classId: {required: true}
            },
            messages: {
                proName: {required: " 请输入产品标题",minlength: "产品标题至少2个字符"},
				classId: {required:"请选择产品的类别"}
            },
            submitHandler:function(){
                var post_data = $("#functionProduct").serializeArray();
                var post_url;
				var functionType = "<?php echo $action;?>";
				  
                if(functionType == "add"){
                    post_url = "<?php echo site_url('admin/product/add')?>";
                }else{
                    post_url = "<?php echo site_url('admin/product/edit')?>";
                }
				
                $.ajax({
                    type: "POST",
                    url: post_url,
                    cache:false,
                    data: post_data,
                    success: function(msg){
						 alert(post_data);
                        flag = (msg=="ok");
                        if(flag){
                            // $("#editbox").html("");
                            ymPrompt.succeedInfo({message:'操作成功！请稍候, 正在刷新页面....'})
                            setInterval(function(){
                            window.location = "<?php echo site_url('admin/product/') ?>";
                            },1000);
                            //  Alert(msg);
                        }else{
                            Alert(msg);
                        }
                    },
                    error:function(aaa,b){
						ymPrompt.errorInfo({message:b});
                        ymPrompt.errorInfo({message:"出错啦，刷新试试，如果一直出现，可以联系开发人员解决"});
                    }
                });


                return false;
            }
        };

			$('#functionProduct').validate(validation1);
            
			// function articels end
        });
        //upload Pic and PDF satart
			 new AjaxUpload('uploadPic', {
            action:  '<?php echo site_url('admin/product/uploadPicLink') ?>',
            name: 'userfile',
            responseType:false,
            onSubmit : function(file , ext){
                //alert(ext);
                if (!(ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
                    alert('未允许上传的文件格式!');
                    // cancel upload
                    return false;
                }
                $('#button4').text('' + file);
                this.disable();
            },
            onComplete: function(file, response){
                //  alert(response);
                //alert($(response.'#realname').html());
                $('#button4').html('选择文件：'+file +' ' + response); // 获取 上传文件名
                $('#Pic').val($('#realname').text()); // 给input 赋值
                
                $('#show_Pic').html("<img src='<?php echo site_url("attachments/product_category/") ?>/"+$('#realname').text()+"' height='50' />");
            }
        });

        // delet Pic
        $("#del_Pic").click(function(){
            ymPrompt.confirmInfo('信息确认框功能测试',null,null,null,handler);
            function handler(tp){
                if(tp=='ok'){
                    $('#show_Pic').html("");
                    $('#Pic').val("");
                    $('#del_Pic').text("");
                }
            }
        });

        new AjaxUpload('button5', {
            action:  '<?php echo site_url('admin/product_category/uploadPicLink') ?>',
            name: 'userfile',
            onSubmit : function(file , ext){
                // alert(ext);
                if (!(ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
                    alert('未允许上传的文件格式!');
                    return false;
                }
                $('#button5').text('上传中... ');
                this.disable();
            },
            onComplete: function(file, response){
                alert(response);
                $('#button5').html('选择文件：'+file+' '+response);
                $('#show_Backpic').html(response);
                $('#Backpic').val($('#show_Backpic').text());
                $('#show_Backpic').html("<img src='<?php echo site_url("attachments/product_category/") ?>/"+$('#show_Backpic').text()+"' width='80' />");
            }
        });

        // delet menuPic
        $("#del_Backpic").click(function(){
            ymPrompt.confirmInfo('信息确认框功能测试',null,null,null,handler);
            function handler(tp){
                if(tp=='ok'){
                    $('#show_Backpic').html("");
                    $('#Backpic').val("");
                    $('#del_Backpic').text("");
                }
            }
        });
		//upload Pic and PDF end
        tinyMCE.init({
        	theme : "advanced",
        	plugins : "safari,pagebreak,style,table,advhr,advimage,advlink,emotions,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras",
        	theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect,|,blockquote,forecolor,backcolor,|,styleprops",
        	theme_advanced_buttons3 : "tablecontrols,|,hr,|,replace,removeformat,visualaid,pagebreak,|,charmap,emotions,media,advhr,searchreplace,|,insertdate,inserttime,preview,||,preview,fullscreen,|,print",  
        	theme_advanced_toolbar_location : "top",
        	theme_advanced_toolbar_align : "left",
        	theme_advanced_statusbar_location : "bottom",
        	theme_advanced_resizing : true,
        	mode : "textareas",
        	relative_urls:false,  
        	remove_script_host:false, 
        	skin: "o2k7",
        	language: "zh" }
    	);
    	 
        
    //]]>
</script>
 
<?php if($action=="add") : ?>
<div style="padding:10px;">
<form id="functionProduct" action="" method="post">
<table width="100%"  class="treeTable">
	<thead><tr><th colspan="2">添加产品</th></tr></thead>
    <tr>
      <td>产品类别/Category</td>
      <td width="1177">
      <select id="classId" name="classId" >
      <option value=""> 请选择产品类别/select Product Category</option>
       <?php foreach ($category as $row): ?> 
       <option value="<?php echo $row->class_id ?>">
      			 <?php for($i=0;$i<$row->deep;$i++):?>
            		<?php echo "&nbsp"?>
            	<?php endfor;?>
	   <?php if ($row->parent_id): ?>  - <?php endif; ?> <?php echo $row->class_name ?>
       
       </option>
       <?php endforeach; ?>
       </select>
      </td>
    </tr>
    <tr>
      <td width="184">产品标题/Title</td><td><input name="proName" type="text" value="" size="50" /></td></tr>
    <tr>
      <td>产品图片/Photo</td>
      <td><a id="uploadPic">选择产品图片/ View photo</a> <a id="del_Pic"></a>
                <input type="hidden" name="proPic" id="proPic" value="" />(Stlye：PNG)</td>
    </tr>
     <tr>
      <td>PDF介绍/PDF File</td>
      <td><a id="uploadPdf">选择PDF格式文件 / Select PDF file</a> <a id="del_Pdf"></a>
                <input type="hidden" name="proPdf" id="proPdf" value="" /></td>
    </tr>
    <tr>
      <td>酒庄源链接/Link</td>
      <td>http://<input type="text" name="proUrl" value="" /></td>
    </tr>
    
    
      
    <tr>
      <td>产品内容/Infomation</td><td>
      <textarea  name="proContent" style="width:600px;height:400px;visibility:hidden;"></textarea>
    </td></tr>
    
    <tr>
    <tr>
      <td>产品详细内容/More Info</td>
      <td><textarea  name="proContentMore" style="width:600px;height:400px;visibility:hidden;"></textarea></td>
    </tr>
    <tr>
      <td>产品关键字/Keyword</td><td><input type="text" name="seo_keyword" value="" />(SEO)</td></tr>
    <tr>
    <tr>
      <td>产品简介/description</td><td><input name="seo_description" type="text" value="" size="50" />(SEO)</td></tr>
        <td>上传日期/Update</td><td><input type="text" name="update_time" value="<?php echo date("Y-m-d")?>" onFocus="calendar(event)" />
         </td></tr>
    <tr>
      <td>产品作者</td><td><input type="text" name="author" readonly="readonly" value="<?php echo $this->session->userdata('admin') ;?>" /></td></tr>
  
    <tr><td>产品编辑</td><td><input type="text" readonly="readonly" name="edit_author" value="<?php echo $this->session->userdata('admin') ;?>" /></td></tr>
  
    <tr><td colspan="2"><input type="submit" name="btn_add" id="btn_add" value=" 添加产品/Submit "  class="buttom" />
      <input type="reset" name="btn_cancel" id="btn_cancel" value=" 重新填写/Rewrite "  class="buttom" /> <input type="button" name="btn_back" id="btn_back" value=" 放弃添加/Cancel "  class="buttom" onClick="javascript:history.go(-1);" /></td></tr>
</table>
</form>
</div>
<?php endif;?>

<?php if($action=="edit") : ?>
<?php foreach ($product as $row):?>
<div style="padding:10px">
<form id="functionInfo" action="" method="post">
<table  class="treeTable">
	<thead><tr><th colspan="2">编辑产品</th></tr></thead>
     <tr>
      <td>产品类别</td>
      <td>
      <select id="classId" name="classId" >
      <option value="">请选择产品类别</option>
       <?php foreach ($menu as $rown): ?> 
       <option value="<?php echo $rown->id ?>" <?php if($rown->id == $row->classId) {?> selected="selected" <?php } ?> >
        <?php for($i=0;$i<$rown->deep;$i++):?>
            		<?php echo "&nbsp"?>
            	<?php endfor;?>
	   <?php if ($rown->parent_id): ?>  - <?php endif; ?><?php echo $rown->menuName ?>
       
       </option>
       <?php endforeach; ?>
       </select>
      </td>
    </tr>
    <tr><td width="100">产品标题</td><td><input type="text" name="title" value="<?php echo $row->title;?>" /></td></tr>
    <tr><td>产品简介</td><td><input name="description" type="text" value="<?php echo $row->description;?>" size="50" /></td></tr>
     
    <tr><td>产品内容</td><td>
      <textarea  name="product_con"  style="width:600px;height:300px;visibility:hidden;"><?php echo $row->content;?></textarea>
    </td></tr>
    <tr><td>产品关键字</td><td><input type="text" name="keyword" value="<?php echo $row->keyword;?>" /></td></tr>
    <tr>
      <td>上传日期</td><td><input type="text" name="post_time" value="<?php echo date("Y-m-d",strtotime($row->post_time))?>" onFocus="calendar(event)" />
        </td></tr>
    <tr><td>产品作者</td><td><input type="text" name="author" value="<?php echo $row->author;?>"  readonly="readonly"/></td></tr>
    
    <tr><td>产品编辑</td><td><input type="text" readonly="readonly" name="edit_author" value="<?php echo $this->session->userdata('admin') ;?>" /></td></tr>
   
    <tr><td colspan="2"><input type="submit" name="submit" value=" 编辑产品 "  class="buttom" /><input type="hidden" name="productId" value="<?php echo $row->productId;?>" />   <input type="reset" name="btn_cancel" id="btn_cancel" value=" 重新填写 "  class="buttom" /> <input type="button" name="btn_back" id="btn_back" value=" 放弃编辑 "  class="buttom" onClick="javascript:history.go(-1);" /></td></tr>
</table>
</form>
</div>
<?php endforeach;?>
<?php endif;?>

<?php if($action=="view"):?>
<div style="padding:10px" >
 <div style="padding:10px">
 <a href="<?php echo site_url("admin/product/add_product") ?>" ><span class="buttom"> 添加产品 </span></a>
 </div>
<form action="<?php echo site_url('admin/product/multi_del')?>?q=<?php echo $q; ?>&v=<?php echo $v; ?>&mode=<?php echo $mode; ?>" method="post">
	<table  class="treeTable" id="treeTable">
	<thead><tr><th width="40"><input id="all_check" type="checkbox"/></th><th>产品标题</th>
	  <th>简介</th><th>作者</th> <th>所属类别</th><th>操作</th></tr></thead>
	<?php foreach($products as $row):?>
	<tr id="<?php echo $row->productId;?>">
		<td><input class="all_check" type="checkbox" name="product_id_<?php echo $row->productId;?>" value="<?php echo $row->productId;?>"/></td>
		<td><?php echo $row->title;?></td>
		<td><?php echo $row->description;?></td>
		<td><?php echo $row->author?></td>
		 
		<td><?php echo $row->menuName;?></td>
		<td>
		<?php if($mode=="normal"):?>
		<button class="edit" name="edit" type="button"
			value="<?php echo $row->productId ; ?>"></button>
		<button class="delete" name="del" type="button"
			value="<?php echo $row->productId ; ?>"></button>
		<?php else:?>
		回收站中
		<?php endif;?>	
			</td>
	</tr>
	<?php endforeach;?>
	<tr>
		<td>
			<input type="submit" value="   submit" name="submit"  class="delete"/>
			<?php if($mode=="recycle"):?>
				&nbsp;<input type="submit" value="   submit" name="recover" id="recover" class="edit"/>
			<?php endif;?>
		</td>
		
		<!--<td><select name="class_id">
            <option value="" selected="selected">选择产品分类</option>
            <?php foreach($category as $row):?>
            <option value="<?php echo $row->class_id;?>" <?php echo $q==$row->class_id?"selected='selected'":""?>>
            	<?php for($i=0;$i<$row->deep;$i++):?>
            		<?php echo "&nbsp"?>
            	<?php endfor;?>
            	<?php echo $row->class_name;?>
            </option>
            <?php endforeach;?>
    </select>
    <select name="is_verified">
    <option value="-1" <?php echo $v=="-1"?'selected="selected"':""?>>全部</option>
    <option value="1" <?php echo $v==1?'selected="selected"':""?>>已审核</option>
    <option value="0" <?php echo $v==0?'selected="selected"':""?>>未审核</option>
    </select>
    </td>-->
		<td colspan="5"><div align="center"><?php echo $links;?></div></td>
	</tr>
	</table>
	</form>	
</div>
<?php endif;?>
<?php include("foot.php")?>