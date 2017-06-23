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

           
            	 
            	$('button[name="del"]').click(function(){
                	$this = $(this).val();
					 ymPrompt.confirmInfo('确认删除此条信息？',null,null,null,handler);
					 function handler(tp){
						 if(tp=='ok'){
							$.ajax({
							   type: "POST",
							   url: "<?php echo site_url('admin/messageboard/del')?>",
							   data: "id="+$this,
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
            
			
             
			// function articels end
			
		 
        });
    	 
        
    //]]>
</script>
 
<div style="padding:10px" >
 <div style="padding:10px">
  
 </div>
<form action="<?php echo site_url('admin/info/multi_del')?>?q=<?php echo $q; ?>&v=<?php echo $v; ?>&mode=<?php echo $mode; ?>" method="post">
	<table  class="treeTable" id="treeTable">
	<thead><tr><!--<th width="40"><input id="all_check" type="checkbox"/></th>--><th>Name</th>
	  <th>Tel</th><th>E-mail</th> <th>Message</th>
	  <th>Update Time</th>
	  <th>操作</th><!----></tr></thead>
	<?php foreach($mblist as $row):?>
	<tr id="<?php echo $row->id;?>">
		<!--<td><input class="all_check" type="checkbox" name="info_id_<?php echo $row->id;?>" value="<?php echo $row->id;?>"/></td>-->
		<td><?php echo $row->name;?></td>
		<td><?php echo $row->tel;?></td>
		<td><?php echo $row->email?></td>
		 
		<td><?php echo $row->message;?></td>
		<td><?php echo $row->datetime;?></td>
		<td>
		 
		<button class="delete" name="del" type="button"
			value="<?php echo $row->id ; ?>"></button>
		 
			</td><!---->
	</tr>
	<?php endforeach;?>
	<tr>
		<td>
		<!--	<input type="submit" value="   submit" name="submit"  class="delete"/>
			<?php if($mode=="recycle"):?>
				&nbsp;<input type="submit" value="   submit" name="recover" id="recover" class="edit"/>
			<?php endif;?>-->&nbsp;
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
		<td colspan="6"><div align="center"><?php echo $links;?></div></td>
	</tr>
	</table>
	</form>	
</div>
 
<?php include("foot.php")?>