<?php include("header.php")?>

<script type="text/javascript" src="<?php echo base_url()?>assets/javascript/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/javascript/uploadify/jquery.uploadify.v2.1.0.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/javascript/uploadify/swfobject.js"></script>
 <script language="JavaScript" src="<?php echo base_url()?>assets/calendar.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>assets/javascript/uploadify/uploadify.css" type="text/css" />

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
						window.location = "<?php echo site_url('admin/article/edit_article') ?>/" + $(this).val();
            	});
            	$('button[name="del"]').click(function(){
                	$this = $(this).val();
					 ymPrompt.confirmInfo('信息确认框功能测试',null,null,null,handler);
					 function handler(tp){
						 if(tp=='ok'){
							$.ajax({
							   type: "POST",
							   url: "<?php echo site_url('admin/article/physical_del')?>",
							   data: "article_id="+$this,
							   success: function(msg){
								   alert(msg);
								   if(msg=="ok"){
									  
									   $("tr#"+n).remove();
									   ymPrompt.succeedInfo({message:'操作成功！请稍候, 正在刷新页面....'});
               							 setInterval(function(){window.location.reload();},1000);
										//window.location = "<?php echo site_url('admin/article/') ?>";
									
								   }else{
										//alert(msg);
								   }
							   }
							   
							}); 
						
							
							//window.location = "<?php echo site_url('admin/article/view') ?>";
							//hiAlert("删除成功");
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
							if(!confirm('确定要删除这些新闻吗？'))
								return false;
							else
								$("form").attr('action','<?php echo site_url('admin/article/physical_del') ?>?q=<?php echo $q; ?>&v=<?php echo $v; ?>&mode=<?php echo $mode; ?>');
						<?php // endif;?>
            	});

				            	
            	$("select[name='class_id']").change(function(){
							window.location = "<?php echo site_url('admin/article/view') ?>?q="+$(this).val()+"&v="+$("select[name='is_verified']").val()+"&mode=<?php echo $mode ?>";
            	});
            	$("select[name='is_verified']").change(function(){
					window.location = "<?php echo site_url('admin/article/view') ?>?q="+$("select[name='class_id']").val()+"&v="+$(this).val()+"&mode=<?php echo $mode ?>";
    			});
            <?php endif;?>
			
            
            // function articels start
			 var validation1 = {
            rules: {
                title: {required: true,minlength: 2},
                content:{required:true,minlength:10}
            },
            messages: {
                title: {required: " 请输入新闻标题",minlength: " 新闻标题至少2个字符"},
                content: {required:" 请输入新闻内容",minlength:" 新闻内容不能少于10个字符"}
            },
            submitHandler:function(){
                var post_data = $("#functionArtice").serializeArray();
                var post_url;
				var action = <?php echo $action;?>;
                if(action == "add"){
                    post_url = "<?php echo site_url('admin/article/add')?>";
                }else{
                    post_url = "<?php echo site_url("admin/menu/edit") ?>";
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
                                window.location.reload();
                            },1000);
                            //  Alert(msg);
                        }else{
                            Alert(msg);
                        }
                    },
                    error:function(){
                        ymPrompt.errorInfo({message:"出错啦，刷新试试，如果一直出现，可以联系开发人员解决"});
                    }
                });


                return false;
            }
        };

			$('#functionArtice').validate(validation1);
            
			// function articels end
        });
        
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
<form id="functionArtice" action="" method="post">
<table  class="treeTable">
	<thead><tr><th colspan="2">添加新闻</th></tr></thead>
    <tr><td width="100">新闻标题</td><td><input type="text" name="title" value="" /></td></tr>
    <tr><td>新闻简介</td><td><input type="text" name="description" value="" /></td></tr>
      
    <tr><td>新闻内容</td><td>
      <textarea  name="content" style="width:600px;height:400px;visibility:hidden;"></textarea>
    </td></tr>
    
    <tr>
    <tr><td>新闻关键字</td><td><input type="text" name="keyword" value="" /></td></tr>
    <tr>
      <td>显示周期</td><td><input type="text" name="start_time" value="<?php echo date("Y-m-d")?>" onFocus="calendar(event)" />
         </td></tr>
    <tr><td>新闻作者</td><td><input type="text" name="author" readonly="readonly" value="<?php echo $this->session->userdata('admin') ;?>" /></td></tr>
   <!-- <tr><td>新闻来源</td><td><select name="article_from">
            <option value="本站原创" selected="selected">本站原创</option>
            <option value="转载">转载</option> 
    </select></td></tr>-->
    <tr><td>新闻编辑</td><td><input type="text" readonly="readonly" name="edit_author" value="<?php echo $this->session->userdata('admin') ;?>" /></td></tr>
    <!--<tr><td>是否推荐</td><td><select name="is_best">
            <option value="0" selected="selected">否</option>
            <option value="1">是</option> 
    </select></td></tr>-->
    <tr><td colspan="2"><input type="submit" name="btn_add" id="btn_add" value=" 添加新闻 "  class="buttom" /></td></tr>
</table>
</form>
</div>
<?php endif;?>

<?php if($action=="edit") : ?>
<?php foreach ($article as $row):?>
<div style="padding:10px">
<form action="<?php echo site_url('admin/article/edit')?>" method="post">
<table  class="treeTable">
	<thead><tr><th colspan="2">编辑新闻</th></tr></thead>
    <tr><td width="100">新闻标题</td><td><input type="text" name="title" value="<?php echo $row->title;?>" /></td></tr>
    <tr><td>新闻简介</td><td><input type="text" name="description" value="<?php echo $row->description;?>" /></td></tr>
     <tr>
      <td>下载周期</td><td><input type="text" name="start_time" value="<?php echo date("Y-m-d",strtotime($row->start_time))?>" onFocus="calendar(event)" />
        至
        <input type="text" name="end_time" value="<?php echo date("Y-m-d",strtotime($row->end_time))?>" onFocus="calendar(event)" /></td></tr>
    <tr><td>新闻内容</td><td>
      <textarea  name="content" style="width:600px;height:300px;visibility:hidden;"><?php echo $row->content;?></textarea>
    </td></tr>
    <tr><td>新闻关键字</td><td><input type="text" name="keyword" value="<?php echo $row->keyword;?>" /></td></tr>
    <tr><td>新闻作者</td><td><input type="text" name="author" value="<?php echo $row->author;?>"  readonly="readonly"/></td></tr>
    <!--<tr><td>新闻来源</td><td><select name="article_from">
            <option value="本站原创" <?php echo $row->article_from=="本站原创" ? ' selected="selected" ' : '';?>>本站原创</option>
            <option value="转载" <?php echo $row->article_from=="转载" ? ' selected="selected" ' : '';?>>转载</option> 
    </select></td></tr>-->
    <tr><td>新闻编辑</td><td><input type="text" readonly="readonly" name="edit_author" value="<?php echo $this->session->userdata('admin') ;?>" /></td></tr>
   <!-- <tr><td>是否推荐</td><td><select name="is_best">
            <option value="0" <?php echo $row->is_best==0 ? ' selected="selected" ' : '';?>>否</option>
            <option value="1" <?php echo $row->is_best==1 ? ' selected="selected" ' : '';?>>是</option> 
    </select></td></tr>-->
   <!-- <?php if($verify):?>
    <tr><td>是否通过审核</td><td><select name="is_verified">
            <option value="0" <?php echo $row->is_verified==0 ? ' selected="selected" ' : '';?>>否</option>
            <option value="1" <?php echo $row->is_verified==1 ? ' selected="selected" ' : '';?>>是</option> 
    </select><input type="hidden" name="verify" value="true" /></td></tr>
    <?php endif;?>-->
    <tr><td colspan="2"><input type="submit" name="submit" value=" 编辑新闻 "  class="buttom" /><input type="hidden" name="article_id" value="<?php echo $row->article_id;?>" /></td></tr>
</table>
</form>
</div>
<?php endforeach;?>
<?php endif;?>

<?php if($action=="view"):?>
<div style="padding:10px" >
 
<form action="<?php echo site_url('admin/article/multi_del')?>?q=<?php echo $q; ?>&v=<?php echo $v; ?>&mode=<?php echo $mode; ?>" method="post">
	<table  class="treeTable" id="treeTable">
	<thead><tr><th width="40"><input id="all_check" type="checkbox"/></th><th>新闻标题</th>
	  <th>简介</th><th>作者</th> <th>显示周期</th><th>操作</th></tr></thead>
	<?php foreach($articles as $row):?>
	<tr id="<?php echo $row->article_id;?>">
		<td><input class="all_check" type="checkbox" name="article_id_<?php echo $row->article_id;?>" value="<?php echo $row->article_id;?>"/></td>
		<td><?php echo $row->title;?></td>
		<td><?php echo $row->description;?></td>
		<td><?php echo $row->author?></td>
		 
		<td><?php echo date("Y-m-d",strtotime($row->start_time));?> - <?php echo date("Y-m-d",strtotime($row->end_time));?></td>
		<td>
		<?php if($mode=="normal"):?>
		<button class="edit" name="edit" type="button"
			value="<?php echo $row->article_id ; ?>"></button>
		<button class="delete" name="del" type="button"
			value="<?php echo $row->article_id ; ?>"></button>
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
		<td colspan="5"><div align="center"><?php echo $links;?></div></td>
	</tr>
	</table>
	</form>	
</div>
<?php endif;?>
<?php include("foot.php")?>