<?php include("header.php")?>
 
<script type="text/javascript" src="<?php echo base_url()?>assets/javascript/jquery.treeTable.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/jquery.treeTable.css" type="text/css" />
<script type="text/javascript">
	//<![CDATA[
		$(document).ready(function(){
				$("tr:odd").addClass('even');
				$('tr').hover(
						function () {
								$(this).addClass("hover");
						 },
						 function () {
								$(this).removeClass("hover");
						 }
				);
				$("#files").treeTable({
					expandable:false
				});

				$("#files tr").dblclick(function(){
						if(!$(this).find('input[name="path"]').val()==""){
							$(this).find('form')
								   .attr('method','post')
								   .attr('action','<?php echo site_url('admin/attachment/list_files')?>')
								   .submit();
						}
				});

				$('.delete').click(function(){
					tr = $(this).parents('tr');
					var post_data = "path=" + $(this).val();
					alert(post_data);
					$.ajax({
						type: "POST",
						url: "<?php echo site_url('admin/attachment/file_del');?>",
						cache:false,
						data: post_data,
						success: function(msg){
							flag = (msg=="ok");
							if(flag){
								tr.remove();
							}else{
								alert(msg);
							}
						},
						error:function(){
							alert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
						}
					}); 
					return false;
				});
				
		});
	//]]>
</script>

<table class="treeTable" id="files">
<thead><tr><th>文件名</th><th>类型</th><th>大小</th><th>操作选项</th></tr></thead>
<tr id="node-root">
<td colspan="4"><span class="root">返回上一级</span>
	<form ><input type="hidden" name="path" value="<?php echo $root; ?>" /></form>
</td>
</tr>
<?php foreach($files as $row):?>
<tr class="child-of-node-root">
	<td><span class="<?php echo $row['folder']==1 ? "folder":"file"; ?>"><?php echo $row['property']['realname'];?></span></td>
	<td><?php echo $row['folder']==1?"文件夹":array_pop(split('\.',$row['property']['realname']))."文件";?></td>
	<td><?php echo $row['folder']==1?"":round(($row['property']['size']/1024),1)."KB";?></td>
	<td>
		<form>
		<input type="hidden" name="path" value="<?php echo $row['folder']==1 ? $row['property']['server_path']:""; ?>" />
		</form>
		<?php if($row['folder']==0):?>
			<?php if($row['database']['exists']): ?>
			<a target="_blank" href="<?php echo site_url('attachments').$row['database']['info']->path."/".$row['property']['realname'];?>">查看</a>
			<?php endif;?> 
		<?php endif;?>
		&nbsp;<button class="delete" value="<?php echo $row['property']['server_path'];?>" />
	</td>
</tr>
<?php endforeach;?>
</table>
<?php include("foot.php")?>