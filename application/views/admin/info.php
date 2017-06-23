<?php include("header.php")?>
<script type="text/javascript" src="<?php echo base_url()?>assets/xheditor-1.1.6/xheditor-1.1.6-zh-cn.min.js"></script>
<script type="text/javascript">
	$(pageInit);
	function pageInit()
	{
		$('#info_con').xheditor({upLinkUrl:"upload.php",upLinkExt:"zip,rar,txt",upImgUrl:"<?php echo site_url('admin/product/uploadHtmlPic') ?>",upImgExt:"jpg,jpeg,gif,png",tools:'full'});
		 
			 
	}
</script>
 
<script type="text/javascript" src="<?php echo base_url()?>assets/javascript/uploadify/jquery.uploadify.v2.1.0.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/javascript/uploadify/swfobject.js"></script>
 <script language="JavaScript" src="<?php echo base_url()?>assets/calendar.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>assets/javascript/uploadify/uploadify.css" type="text/css" />
<?php if($action=="edit" || $action=="add"):?>
  <script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/uploadify/ajaxupload.js"></script>
  <?php endif;?>
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
						window.location = "<?php echo site_url('admin/info/edit_info') ?>/" + $(this).val();
            	});
            	$('button[name="del"]').click(function(){
                	$this = $(this).val();
					 ymPrompt.confirmInfo('信息确认框功能测试',null,null,null,handler);
					 function handler(tp){
						 if(tp=='ok'){
							$.ajax({
							   type: "POST",
							   url: "<?php echo site_url('admin/info/physical_del')?>",
							   data: "info_id="+$this,
							   success: function(msg){
								   //alert(msg);
								   if(msg=="ok"){
									  // $("tr#"+n).remove();
									   ymPrompt.succeedInfo({message:'操作成功！请稍候, 正在刷新页面....'});
               							 setInterval(function(){window.location.reload();},1000);
										//window.location = "<?php echo site_url('admin/info/') ?>";
									
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
							if(!confirm('确定要删除这些信息吗？'))
								return false;
							else
								$("form").attr('action','<?php echo site_url('admin/info/physical_del') ?>?q=<?php echo $q; ?>&v=<?php echo $v; ?>&mode=<?php echo $mode; ?>');
						<?php // endif;?>
            	});

				            	
            	$("select[name='class_id']").change(function(){
							window.location = "<?php echo site_url('admin/info/view') ?>?q="+$(this).val()+"&v="+$("select[name='is_verified']").val()+"&mode=<?php echo $mode ?>";
            	});
            	$("select[name='is_verified']").change(function(){
					window.location = "<?php echo site_url('admin/info/view') ?>?q="+$("select[name='class_id']").val()+"&v="+$(this).val()+"&mode=<?php echo $mode ?>";
    			});
            <?php endif;?>
			
            
            // function articels start
			 var validation1 = {
            rules: {
                title: {required: true,minlength: 2},
				classId: {required: true}
            },
            messages: {
                title: {required: " 请输入信息标题",minlength: "信息标题至少2个字符"},
				classId: {required:"请选择信息的类别"}
            },
            submitHandler:function(){
                var post_data = $("#functionInfo").serializeArray();
                var post_url;
				var functionType = "<?php echo $action;?>";
				// alert("dddd");
                if(functionType == "add"){
                    post_url = "<?php echo site_url('admin/info/add')?>";
                }else{
                    post_url = "<?php echo site_url('admin/info/edit')?>";
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
                            ymPrompt.succeedInfo({message:'操作成功！请稍候, 正在刷新页面....'})
                            setInterval(function(){
                            window.location = "<?php echo site_url('admin/info/') ?>";
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

			$('#functionInfo').validate(validation1);
            
			// function articels end
			
			//upload Pic and PDF satart
			<?php if($action=="edit" || $action=="add"):?>
			new AjaxUpload('buttonpic', {
            action:  '<?php echo site_url('admin/info/uploadPicLink') ?>',
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
					//  alert(response);
					//alert($(response.'#realname').html());
				   $('#buttonpic').html('选择文件：'+file +' ' + response); // 获取 上传文件名
					 $('#info_pic').val($('#realname').text()); // 给input 赋值
					
					 $('#show_Pic').html("<img src='<?php echo base_url()."attachments/info/"; ?>/"+$('#realname').text()+"' />");
				}
       		});
			// delet Pic
			$("#del_Pic").click(function(){
				ymPrompt.confirmInfo('信息确认框功能测试',null,null,null,handler);
				function handler(tp){
					if(tp=='ok'){
						$('#show_Pic').html("");
						$('#info_pic').val("");
						$('#del_Pic').text("");
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
<form id="functionInfo" action="" method="post">
<table  class="treeTable">
	<thead><tr><th colspan="2">添加信息</th></tr></thead>
    <tr>
      <td>信息类别</td>
      <td>
      <select id="classId" name="classId" >
      <option value=""> 请选择信息类别</option>
       <?php foreach ($menu as $row): ?> 
       <option value="<?php echo $row->id ?>">
      			 <?php for($i=0;$i<$row->deep;$i++):?>
            		<?php echo "&nbsp"?>
            	<?php endfor;?>
	   <?php if ($row->parent_id): ?>  - <?php endif; ?> <?php echo $row->menuName ?>
       
       </option>
       <?php endforeach; ?>
       </select>
      </td>
    </tr>
    <tr><td width="100">信息标题</td><td><input type="text" name="title" value="" /></td></tr>
    <tr><td>信息简介</td><td><input name="description" type="text" value="" size="50" /></td></tr>
      
 <tr>
      <td>图片/Photo</td>
      <td> 
     <div style=" margin-left:700px;position:absolute;text-align:right;">
     <div id="show_Pic" style=" "></div>  
     </div>
      <a href="javascript:;" id="buttonpic">选择图片/ View photo</a> <a id="del_Pic"></a>
                <input type="hidden" name="proPic" id="proPic" value="" />(Stlye：PNG)</td>
    </tr>
    <tr><td>信息内容</td><td>
      <textarea  name="info_con" cols="100" rows="20" id="info_con" ></textarea>
    </td></tr>
    
    <tr>
    <tr><td>信息关键字</td><td><input type="text" name="keyword" value="" /></td></tr>
    <tr>
      <td>上传日期</td><td><input type="text" name="update_time" value="<?php echo date("Y-m-d")?>" onFocus="calendar(event)" />
         </td></tr>
    <tr><td>信息作者</td><td><input type="text" name="author" readonly="readonly" value="<?php echo $this->session->userdata('admin') ;?>" /></td></tr>
  
    <tr><td>信息编辑</td><td><input type="text" readonly="readonly" name="edit_author" value="<?php echo $this->session->userdata('admin') ;?>" /></td></tr>
  
    <tr><td colspan="2"><input type="submit" name="btn_add" id="btn_add" value=" 添加信息 "  class="buttom" />
      <input type="reset" name="btn_cancel" id="btn_cancel" value=" 重新填写 "  class="buttom" /> <input type="button" name="btn_back" id="btn_back" value=" 放弃添加 "  class="buttom" onclick="javascript:history.go(-1);" /></td></tr>
</table>
</form>
</div>
<?php endif;?>

<?php if($action=="edit") : ?>
<?php foreach ($info as $row):?>
<div style="padding:10px">
<form id="functionInfo" action="" method="post">
<table  class="treeTable">
	<thead><tr><th colspan="2">编辑信息</th></tr></thead>
     <tr>
      <td>信息类别</td>
      <td>
      <select id="classId" name="classId" >
      <option value="">请选择信息类别</option>
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
    <tr><td width="100">信息标题</td><td><input type="text" name="title" value="<?php echo $row->title;?>" /></td></tr>
    <tr><td>信息简介</td><td><input name="description" type="text" value="<?php echo $row->description;?>" size="50" /></td></tr>
      <tr>
      <td>图片/Photo</td>
      <td> 
      <div style=" margin-left:700px;position:absolute;text-align:right;">
     <div id="show_Pic" style=" ">
     <?php
     	if($row->info_pic != ""):
	 ?>
     <img src='<?php echo base_url()."attachments/info/" ?>/<?php echo $row->info_pic;?>' />
     <?php
     endif
	 ?>
     </div>  
     </div>
      <a id="buttonpic">更换图片/ View photo</a>&nbsp;&nbsp; <a id="del_Pic"> -- 删除图片 / Delet Photo </a>
                <input type="hidden" name="info_pic" id="info_pic" value="<?php echo $row->info_pic;?>" />(Stlye：PNG)</td>
    </tr>
    <tr><td>信息内容</td><td>
      <textarea  name="info_con" cols="80" rows="20" id="info_con"  ><?php echo $row->content;?></textarea>
    </td></tr>
    <tr><td>信息关键字</td><td><input type="text" name="keyword" value="<?php echo $row->keyword;?>" /></td></tr>
    <tr>
      <td>上传日期</td><td><input type="text" name="post_time" value="<?php echo date("Y-m-d",strtotime($row->post_time))?>" onFocus="calendar(event)" />
        </td></tr>
    <tr><td>信息作者</td><td><input type="text" name="author" value="<?php echo $row->author;?>"  readonly="readonly"/></td></tr>
    
    <tr><td>信息编辑</td><td><input type="text" readonly="readonly" name="edit_author" value="<?php echo $this->session->userdata('admin') ;?>" /></td></tr>
   
    <tr><td colspan="2"><input type="submit" name="submit" value=" 编辑信息 "  class="buttom" /><input type="hidden" name="infoId" value="<?php echo $row->infoId;?>" />   <input type="reset" name="btn_cancel" id="btn_cancel" value=" 重新填写 "  class="buttom" /> <input type="button" name="btn_back" id="btn_back" value=" 放弃编辑 "  class="buttom" onclick="javascript:history.go(-1);" /></td></tr>
</table>
</form>
</div>
<?php endforeach;?>
<?php endif;?>

<?php if($action=="view"):?>
<div style="padding:10px" >
 <div style="padding:10px">
 <a href="<?php echo site_url("admin/info/add_info") ?>" ><span class="buttom"> 添加信息 </span></a>
 </div>
<form action="<?php echo site_url('admin/info/multi_del')?>?q=<?php echo $q; ?>&v=<?php echo $v; ?>&mode=<?php echo $mode; ?>" method="post">
	<table  class="treeTable" id="treeTable">
	<thead><tr><th width="40"><input id="all_check" type="checkbox"/></th><th>信息标题</th>
	  <th>简介</th><th>作者</th> <th>所属类别</th><th>操作</th></tr></thead>
	<?php foreach($infos as $row):?>
	<tr id="<?php echo $row->infoId;?>">
		<td><input class="all_check" type="checkbox" name="info_id_<?php echo $row->infoId;?>" value="<?php echo $row->infoId;?>"/></td>
		<td><?php echo $row->title;?></td>
		<td><?php echo $row->description;?></td>
		<td><?php echo $row->author?></td>
		 
		<td><?php echo $row->menuName;?></td>
		<td>
		<?php if($mode=="normal"):?>
		<button class="edit" name="edit" type="button"
			value="<?php echo $row->infoId ; ?>"></button>
		<button class="delete" name="del" type="button"
			value="<?php echo $row->infoId ; ?>"></button>
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
            <option value="" selected="selected">选择信息分类</option>
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