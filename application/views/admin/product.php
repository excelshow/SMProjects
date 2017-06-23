<?php include("header.php")?>
<script type="text/javascript" src="<?php echo base_url()?>assets/xheditor-1.1.6/xheditor-1.1.6-zh-cn.min.js"></script>
<script type="text/javascript">
	$(pageInit);
	function pageInit()
	{
		$('#proContent').xheditor({upImgUrl:"<?php echo site_url('admin/product/uploadHtmlPic') ?>",upImgExt:"jpg,jpeg,gif,png",tools:'full'});
			$('#proContentMore').xheditor({upImgUrl:"<?php echo site_url('admin/product/uploadHtmlPic') ?>",upImgExt:"jpg,jpeg,gif,png",tools:'full'});
	}
</script>
<?php if($action=="edit" || $action=="add"):?>
  <script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/uploadify/ajaxupload.js"></script>
  <?php endif;?>
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
					 ymPrompt.confirmInfo('确定要删除产品吗？',null,null,null,handler);
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
			
            
            // function product start
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
						// alert(post_data);
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
            
      
			// function product end
			
			//upload Pic and PDF satart
			<?php if($action=="edit" || $action=="add"):?>
			new AjaxUpload('buttonpic', {
            action:  '<?php echo site_url('admin/product/uploadPicLink') ?>',
            name: 'userfile',
            responseType:false,
				onSubmit : function(file , ext){
					//alert(ext);
					if (!(ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
						Alert('未允许上传的文件格式!');
						// cancel upload
						return false;
					}
					$('#buttonpic').text('' + file);
					this.disable();
				},
				onComplete: function(file, response){
					 // alert(response);
					//alert($('#realname').text());
				   $('#buttonpic').html('选择文件：'+file +' ' + response); // 获取 上传文件名
					 $('#proPic').val($('#realname').text()); // 给input 赋值
					 $('#show_Pic').html("<img src='<?php echo base_url()."attachments/product"; ?>/"+$('#realname').text()+"' />");
				}
       		});
			// delet Pic
			$("#del_Pic").click(function(){
				ymPrompt.confirmInfo('信息确认框功能测试',null,null,null,handler);
				function handler(tp){
					if(tp=='ok'){
						$('#show_Pic').html("");
						$('#proPic').val("");
						$('#del_Pic').text("");
					}
				}
			});
			// upload Food PIC
			new AjaxUpload('foodpic', {
            action:  '<?php echo site_url('admin/product/uploadPicLink') ?>',
            name: 'userfile',
            responseType:false,
				onSubmit : function(file , ext){
					//alert(ext);
					if (!(ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
						Alert('未允许上传的文件格式!');
						// cancel upload
						return false;
					}
					$('#foodpic').text('' + file);
					this.disable();
				},
				onComplete: function(file, response){
					 // alert(response);
					//alert($('#realname').text());
				   $('#foodpic').html('选择文件：'+file +' ' + response); // 获取 上传文件名
					 $('#proFoodPic').val($('#realname').text()); // 给input 赋值
					 $('#show_FoodPic').html("<img src='<?php echo base_url()."attachments/product"; ?>/"+$('#realname').text()+"' />");
				}
       		});
			// delet Pic
			$("#del_FoodPic").click(function(){
				ymPrompt.confirmInfo('信息确认框功能测试',null,null,null,handler);
				function handler(tp){
					if(tp=='ok'){
						$('#show_FoodPic').html("");
						$('#proFoodPic').val("");
						$('#del_FoodPic').text("");
					}
				}
			});
			// upload Logo
			new AjaxUpload('buttonlogo', {
            action:  '<?php echo site_url('admin/product/uploadLogoLink') ?>',
            name: 'userfile',
            responseType:false,
				onSubmit : function(file , ext){
					//alert(ext);
					if (!(ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
						Alert('未允许上传的文件格式!');
						// cancel upload
						return false;
					}
					$('#buttonlogo').text('' + file);
					this.disable();
				},
				onComplete: function(file, response){
					//  alert(response);
					//alert($(response.'#realname').html());
				   $('#buttonlogo').html('选择文件：'+file +' ' + response); // 获取 上传文件名
					 $('#proLogo').val($('#realnameLogo').text()); // 给input 赋值
					
					 $('#show_Logo').html("<img src='<?php echo base_url()."attachments/product"; ?>/"+$('#realnameLogo').text()+"' />");
				}
       		});
			// delet Pic
			$("#del_Logo").click(function(){
				ymPrompt.confirmInfo('信息确认框功能测试',null,null,null,handler);
				function handler(tp){
					if(tp=='ok'){
						$('#show_Logo').html("");
						$('#proLogo').val("");
						$('#del_Logo').text("");
					}
				}
			});
			
			// uploadPdf
			new AjaxUpload('buttonpdf', {
            action:  '<?php echo site_url('admin/product/uploadPdfLink') ?>',
            name: 'userfile',
            responseType:false,
				onSubmit : function(file , ext){
					//alert(ext);
					if (!(ext && /^(pdf|doc)$/.test(ext))){
						Alert('未允许上传的文件格式!');
						// cancel upload
						return false;
					}
					$('#buttonpdf').text('' + file);
					this.disable();
				},
				onComplete: function(file, response){
					//  alert(response);
					//alert($(response.'#realname').html());
				   $('#buttonpdf').html('选择文件：'+file +' ' + response); // 获取 上传文件名
					 $('#proPdf').val($('#realname').text()); // 给input 赋值
					
				}
       		});
			// delet Pic
			$("#del_Pdf").click(function(){
				ymPrompt.confirmInfo('信息确认框功能测试',null,null,null,handler);
				function handler(tp){
					if(tp=='ok'){ 
						$('#proPdf').val("");
						$('#del_Pdf').text("");
					}
				}
			});
        
			<?php endif;?>
        
		//upload Pic and PDF end
		
        });
        
		
	 
    	 
        
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
   <!-- <tr>
      <td>属性/Type</td>
      <td><select id="proType" name="proType" >
        <option value=""> 请选择属性/Type</option>
         
        <option value="1">红酒 / Vin Rouge </option>
         <option value="2">白酒 / Vin Blanc</option>
          <option value="3">粉酒 / vin Rosé </option>
          <option value="4">烈酒 / Spiritueux</option>
          <option value="6">起泡酒 /Sparkling Wine</option>
          <option value="5">香槟 /Champagne</option>
      </select></td>
    </tr>-->
    <tr>
      <td width="184">产品标题/Title</td><td><input name="proName" type="text" value="" size="50" /></td></tr>
      <tr>
      <td>产品Logo/Logo</td>
      <td><a href="javascript:;" id="buttonlogo">选择产品Logo/ View Logo</a> <a id="del_Logo"></a>
        <input type="hidden" name="proLogo" id="proLogo" value="" />
        (Stlye：PNG)</td>
    </tr>
    <tr>
      <td>产品图片/Photo</td>
      <td> 
     <div style=" margin-left:700px;position:absolute;text-align:right;">
     <div id="show_Logo" style=" "></div>
     <div id="show_Pic" style=" "></div>
     <div id="show_FoodPic" style=" "></div>
     </div>
      <a href="javascript:;" id="buttonpic">选择产品图片/ View photo</a> <a id="del_Pic"></a>
                <input type="hidden" name="proPic" id="proPic" value="" />(Stlye：PNG)</td>
    </tr>
    
    
     <tr>
      <td>PDF介绍/PDF File</td>
      <td><a  href="javascript:;" id="buttonpdf">选择PDF格式文件 / Select PDF file</a> <a id="del_Pdf"></a>
                <input type="hidden" name="proPdf" id="proPdf" value="" /></td>
    </tr>
    <tr>
      <td>酒庄源链接/Link</td>
      <td>http://<input type="text" name="proUrl" value="" /></td>
    </tr>
    
    
      
    <tr>
      <td>产品内容/Infomation</td><td>
      <textarea  name="proContent" id="proContent"  rows="15" cols="80" ></textarea>
    </td></tr>
    
    <tr>
    <tr>
      <td>产品详细内容/More Info</td>
      <td><textarea  name="proContentMore" cols="80" rows="15" id="proContentMore"></textarea></td>
    </tr>
    <tr>
      <td>图库链接/Galley URL</td>
      <td>http://        <input name="galleryUrl" type="text" id="galleryUrl" value="" size="60" /></td>
    </tr>
    <tr>
      <td>产品排序/Sort By</td>
      <td><input name="isSort" type="text" id="isSort" value="1" /></td>
    </tr>
    <tr>
      <td>产品关键字/Keyword</td><td><input type="text" name="seo_keyword" value="" />(SEO)</td></tr>
    <tr>
    <tr>
      <td valign="top">产品简介/description</td><td><textarea name="seo_description" cols="50" rows="4"></textarea>
        (SEO)</td></tr>
        <tr>
          <td>配餐图片</td>
          <td><a href="javascript:;" id="foodpic">选择配餐图片/ View photo</a> <a id="del_FoodPic"></a>
                <input type="hidden" name="proFoodPic" id="proFoodPic" value="" />(Stlye：PNG)</td></td>
        </tr>
        <tr>
          <td>是否新产品</td>
          <td><input name="is_best" type="radio" id="is_best" value="0" checked="checked" />
            否 
            <input type="radio" name="is_best" id="is_best" value="1" />
            是</td>
        </tr>
        <td>上传日期/Update</td><td><input type="text" name="post_time" value="<?php echo date("Y-m-d")?>" onFocus="calendar(event)" />
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
<?php foreach ($products as $row):?>
<div style="padding:10px">
<form id="functionProduct" action="" method="post">
<table  class="treeTable">
	<thead><tr><th colspan="2">编辑产品信息 / Modify Product</th></tr></thead>
     <tr>
      <td>产品类别/Product Category</td>
      <td>
      <select id="classId" name="classId" >
      <option value="">请选择新闻类别</option>
       <?php foreach ($category as $rown): ?> 
       <option value="<?php echo $rown->class_id ?>" <?php if($rown->class_id == $row->classId) {?> selected="selected" <?php } ?> >
        <?php for($i=0;$i<$rown->deep;$i++):?>
            		<?php echo "&nbsp"?>
            	<?php endfor;?>
	   <?php if ($rown->parent_id): ?>  - <?php endif; ?><?php echo $rown->class_name ?>
       
       </option>
       <?php endforeach; ?>
       </select>
      </td>
    </tr>
   <!-- <tr>
      <td>属性/Type</td>
      <td><select id="proType" name="proType" >
        <option value=""> 请选择属性/Type</option>
         
        <option value="1"  <?php if($row->proType == 1) {?> selected="selected" <?php } ?> >红酒 / Vin Rouge </option>
         <option value="2" <?php if($row->proType == 2) {?> selected="selected" <?php } ?>>白酒 / Vin Blanc </option>
          <option value="3" <?php if($row->proType == 3) {?> selected="selected" <?php } ?>>粉酒  / vin Rosé </option>
          <option value="4" <?php if($row->proType == 4) {?> selected="selected" <?php } ?>>烈酒  / Spiritueux </option>
            <option value="6" <?php if($row->proType == 6) {?> selected="selected" <?php } ?>>起泡酒 /Sparkling Wine</option>
           <option value="5" <?php if($row->proType == 5) {?> selected="selected" <?php } ?>>香槟 /Champagne</option>
      </select></td>
    </tr>-->
    <tr>
      <td width="184">产品标题/Title</td><td><input name="proName" type="text" value="<?php echo $row->proName;?>" size="50" /></td></tr>
      <tr>
      
      <td>产品Logo/Logo</td>
      <td> 
      <div style=" margin-left:700px;position:absolute;text-align:right;">
     
     </div>
      <a href="javascript:;"  id="buttonlogo">更换图片/ View photo</a>&nbsp;&nbsp; <a href="javascript:;"  id="del_Logo"> -- 删除Logo / Delet Logo</a>
                <input type="text" name="proLogo" id="proLogo" value="<?php echo $row->proLogo;?>" />(Stlye：PNG)</td>
    </tr>
     <tr>
      <td>产品图片/Photo</td>
      <td> 
      <div style=" margin-left:700px;position:absolute;text-align:right;">
      <div id="show_Logo" style=" ">
     <?php
     	if($row->proLogo != ""):
	 ?>
     <img src='<?php echo base_url()."attachments/product/" ?>/<?php echo $row->proLogo;?>' />
     <?php
     endif
	 ?>
     </div>  
     <div id="show_Pic" style=" ">
      
     <?php
     	if($row->proPic != ""):
	 ?>
     <img src='<?php echo base_url()."attachments/product/" ?>/<?php echo $row->proPic;?>' />
     <?php
     endif
	 ?>
     </div> 
      <div id="show_FoodPic" style=" ">
      
     <?php
     	if($row->proFoodPic != ""):
	 ?>
     <img src='<?php echo base_url()."attachments/product/" ?>/<?php echo $row->proFoodPic;?>' />
     <?php
     endif
	 ?>
     </div> 
     </div>
      <a href="javascript:;"  id="buttonpic">更换图片/ View photo</a>&nbsp;&nbsp; <a href="javascript:;"  id="del_Pic"> -- 删除图片 / Delet Photo </a>
                <input type="text" name="proPic" id="proPic" value="<?php echo $row->proPic;?>" />(Stlye：PNG)</td>
    </tr>
     <tr>
      <td>PDF介绍/PDF File</td>
      <td><a href="javascript:;"  id="buttonpdf">选择PDF格式文件 / Select PDF file</a>&nbsp;&nbsp; <a  href="javascript:;" id="del_Pdf"> --删除PDF / Delect PDF file</a>
      <?php
     	if($row->proPdf != ""):
	 ?>
      &nbsp;&nbsp;<a href="<?php echo base_url()."attachments/productPdf/"; ?>/<?php echo $row->proPdf;?>" target="_blank"> -- 浏览PDF/View PDF</a>  
        <?php
     endif
	 ?>
                <input type="hidden" name="proPdf" id="proPdf" value="" /></td>
    </tr>
    <tr>
      <td>酒庄源链接/Link</td>
      <td>http://<input type="text" name="proUrl" value="<?php echo $row->proUrl;?>" /></td>
    </tr>
     
    <tr>
      <td>产品内容/Infomation</td><td>
      <textarea  name="proContent" id="proContent"  rows="15" cols="80" ><?php echo $row->proContent;?></textarea>
    </td></tr>
    
    <tr>
    <tr>
      <td>产品详细内容/More Info</td>
      <td><textarea  name="proContentMore" id="proContentMore"  rows="15" cols="80" ><?php echo $row->proContentMore;?></textarea></td>
    </tr>
     <tr>
      <td>图库链接/Galley URL</td>
      <td>http://        <input name="galleryUrl" type="text" id="galleryUrl" value="<?php echo $row->galleryUrl;?>" size="60" /></td>
    </tr>
    <tr>
      <td>产品排序/Sort By</td>
      <td><input name="isSort" type="text" id="isSort" value="<?php echo $row->isSort;?>" /></td>
    </tr>
    <tr>
      <td>产品关键字/Keyword</td><td><input type="text" name="seo_keyword" value="<?php echo $row->seo_keyword;?>" />(SEO)</td></tr>
    <tr>
    <tr>
      <td valign="top">产品简介/description</td><td><textarea name="seo_description" cols="50" rows="4"><?php echo $row->seo_description;?></textarea>
        (SEO)</td></tr>
        <tr>
          <td>配餐图片</td>
          <td><a href="javascript:;" id="foodpic">选择配餐图片/ View photo</a> <a id="del_FoodPic"></a>
                <input type="hidden" name="proFoodPic" id="proFoodPic"    value="<?php echo $row->proFoodPic;?>"   />(Stlye：PNG)</td></td>
        </tr>
         <tr>
          <td>是否新产品</td>
          <td><input name="is_best" type="radio" id="is_best" value="0" <?php if($row->is_best == 0) {?> checked="checked" <?php } ?>  />
            否 
            <input type="radio" name="is_best" id="is_best" value="1"  <?php if($row->is_best == 1) {?> checked="checked" <?php } ?> />
            是</td>
        </tr>
        <td>上传日期/Update</td><td><? //=$row->update_time?><input type="text" name="update_time" value="<?php echo date('Y-m-d',strtotime($row->post_time));?>" onFocus="calendar(event)" />
         </td></tr>
    <tr>
      <td>产品作者</td><td><input type="text" name="author" readonly="readonly" value="<?php echo $row->author;?>" /></td></tr>
  
    <tr><td>产品编辑</td><td><input type="text" readonly="readonly" name="edit_author" value="<?php echo $this->session->userdata('admin') ;?>" /></td></tr>
   
    <tr><td colspan="2"><input type="submit" name="submit" value=" 编辑产品/Submit "  class="buttom" /><input type="hidden" name="proId" value="<?php echo $row->proId;?>" />   <input type="reset" name="btn_cancel" id="btn_cancel" value=" 重新填写/Rewrite "  class="buttom" /> <input type="button" name="btn_back" id="btn_back" value=" 放弃编辑/Cancel "  class="buttom" onclick="javascript:history.go(-1);" /></td></tr>
</table>
</form>
</div>
<?php endforeach;?>
<?php endif;?>

<?php if($action=="view"):?>
<div style="padding:10px" >
 <div style="padding:10px">
 <a href="<?php echo site_url("admin/product/add_product") ?>" ><span class="buttom"> 添加产品 / Add Product </span></a>
 </div>
<form action="<?php echo site_url('admin/product/multi_del')?>?q=<?php echo $q; ?>&v=<?php echo $v; ?>&mode=<?php echo $mode; ?>" method="post">
	<table  id="treeTable" class="treeTable">
	<thead><tr><th width="40"><input id="all_check" type="checkbox"/></th>
	  <th>产品图片(Logo)</th>
	  <th>产品名称/Product Name</th>
	  <th>所属类别</th><th>操作</th></tr></thead>
      <tbody>
	<?php foreach($products as $row):?>
    
	<tr id="<?php echo $row->proId;?>">
		<td><input class="all_check" type="checkbox" name="proId_<?php echo $row->proId;?>" value="<?php echo $row->proId;?>"/></td>
		<td> <img src='<?php echo base_url()."attachments/product" ?>/<?php echo $row->proLogo;?>' /></td>
		<td valign="top"><?php echo $row->proName;?></td>
		<td valign="top">
		<?php 
		//echo $row->classId;
			$className = $this->product_category_model->get_byid($row->classId);
			echo $className->class_name;
		?>
        </td>
		<td valign="top">
		<?php if($mode=="normal"):?>
		<button class="edit" name="edit" type="button"
			value="<?php echo $row->proId ; ?>"></button>
		<button class="delete" name="del" type="button"
			value="<?php echo $row->proId ; ?>"></button>
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
            <option value="" selected="selected">选择新闻分类</option>
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
		<td colspan="4"><div align="center"><?php echo $links;?></div></td>
	</tr>
    </tbody>
	</table>
	</form>	
</div>
<?php endif;?>
<?php include("foot.php")?>