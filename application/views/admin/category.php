<?php
	include("header.php")
?>
 <script type="text/javascript" src="<?php echo base_url()?>assets/javascript/jquery.ui.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>assets/javascript/jquery.treeTable.min.js"></script>
 
<script type="text/javascript">
	//<![CDATA[
		$(document).ready(function(){
			$("#category").treeTable({
				expandable:false
			});
			$("tr:odd").addClass('even');
			$("tr").hover(
  					function () {
						$(this).addClass("hover");
  					},
  					function () {
						$(this).removeClass("hover");
  					}
			); 
			// Configure draggable nodes
			$("#category .file, #category .folder").draggable({
			  helper: "clone",
			  opacity: .75,
			  refreshPositions: true, // Performance?
			  revert: "invalid",
			  revertDuration: 300,
			  scroll: true
			});

			$("#category .folder,#category .file,#category .root").each(function() {
			  $(this).parents("tr").droppable({
			    accept: ".file, .folder",
			    drop: function(e, ui) { 
				  var canMove = true;
			      target = $($(ui.draggable).parents("tr"));
				  if(target[0]==$(this)[0]||(target.attr('class').match('child-of-'+$(this).attr('id')))!=null){
						canMove = false;
				  }else{
				  	var flag = $(this);
				  	while(flag.attr('id')!='node-root'){
					  	flag = $('#' + flag.attr('class').match(/child-of-node-.*/)[0].split(" ")[0].replace(/child-of-/g,''));
					  	if(target[0]==flag[0]){
								canMove = false; 
								break;
					  	}
				  	}
				  }
				  if(canMove){
			      	target.appendBranchTo(this);
			      	uri = target.attr('id')+'/'+$(this).attr('id');
			      	uri = uri.replace(/node-/g,"");
				  	uri = uri.replace(/root/g,"0");
			      	$.get('<?php echo site_url('admin/category/move'); ?>' + "/"+uri,function(){
				  			window.location = "<?php echo site_url("admin/category/") ?>";
				  	});
					}
			    },
			    hoverClass: "accept",
			    over: function(e, ui) {
			      if(this.id != $(ui.draggable.parents("tr")[0]).id && !$(this).is(".expanded")) {
			        $(this).expand();
			      }
			    }
			  });
			});

			$("table#category tbody tr").mousedown(function() {
			  $("tr.selected").removeClass("selected"); 
			  $(this).addClass("selected");
			});

			$("table#category tbody tr span").mousedown(function() {
			  $($(this).parents("tr")[0]).trigger("mousedown");
			});
			
			$("button[name='new']").click(function(){
				hiBox('#editbox','新建类别','300');
				$("input[name='edit_name']").val("未命名类别");
				$('#editbox').data('edit_name',"未命名类别");
				$("input[name='edit_sequence']").val("0");
				$('#editbox').data('edit_sequence',"0");
				$("input[name='edit_optional']").val("");
				$('#editbox').data('edit_optional',"");
				$("input[name='edit_parent']").val($(this).val()) ;
				$("button[name='edit_cmd']").click(function(){
					checkform('/create');
				}) ;
			});
			
			$("button[name='edit']").click(function(){
				hiBox('#editbox','编辑类别','300');
				$this = $('#node-'+$(this).val()).find('span');
				$("input[name='edit_name']").val($($this[0]).html());
				$('#editbox').data('edit_name',$($this[0]).html());
				$("input[name='edit_sequence']").val($($this[1]).html());
				$('#editbox').data('edit_sequence',$($this[1]).html());
				$("input[name='edit_optional']").val($($this[2]).html());
				$('#editbox').data('edit_optional',$($this[2]).html());
				$("input[name='edit_parent']").val($(this).val()) ;
				$("button[name='edit_cmd']").click(function(){
					checkform('/edit');
				}) ;
			});
			
			$("button[name='del']").click(function(){
				$.post("<?php echo site_url("admin/category/del") ?>", 
					{ 
						class_id: $(this).val()
					},
					function(){
						window.location = "<?php echo site_url("admin/category/") ?>";
				 }); 
			});
		});
		
		function checkform(type){
				if($("input[name='edit_name']").data('edit_name')==""){
					$("input[name='edit_name']").focus();
					return false;
				}
				if($("input[name='edit_sequence']").data('edit_sequence')==""){
					$("input[name='edit_sequence']").focus();
					return false;
				}
				$.post("<?php echo site_url("admin/category/") ?>"+type, 
					{ 
						class_name: $('#editbox').data('edit_name'), 
						class_parent: $("input[name='edit_parent']").val(),
						class_sequence:$('#editbox').data('edit_sequence'),
						class_optional:$('#editbox').data('edit_optional') 
					},
					function(){
						window.location = "<?php echo site_url("admin/category/") ?>";
				 }); 
			}
	//]]>
</script>

<table id="category">
<thead><tr><th></th><th>显示顺序</th><th>附加属性</th><th>操作选项</th></tr></thead>
<tr id="node-root">
	<td><span class="root">类别根目录</span></td>
	<td colspan="2"></td>
	<td>
		<button class="add" name="new" type="button" value="0"></button>
	</td>
</tr>
<?php foreach($category as $row):?>
<tr id="node-<?php echo $row->class_id ?>"	<?php if($row->parent_id):?>	class="child-of-node-<?php echo $row->parent_id ?>"    <?php else :?>    class="child-of-node-root"	<?php endif;?>	>
	<td>
		<span class="<?php echo $row->children ? "folder":"file"; ?>"><?php echo $row->class_name; ?></span>
	</td>
	<td>
		<span class="sequence" id="optional_<?php echo $row->class_id ?>"><?php echo $row->class_sequence ?></span>
	</td>
	<td>
		<span class="optional" id="optional_<?php echo $row->class_id ?>"><?php echo $row->class_optional ?></span>
	</td>
	<td>
		<button class="add" name="new" type="button" value="<?php echo $row->class_id ; ?>"></button>
		<button class="action edit" name="edit" type="button" value="<?php echo $row->class_id ; ?>"></button>
		<?php if(!$row->children) : ?>
		<button class="action delete" name="del" type="button" value="<?php echo $row->class_id ; ?>"></button>
		<?php endif; ?>
	</td>
</tr>
<?php endforeach;?>
</table>
<div style="display:none">
	<div id="editbox">
	<input type="hidden" name="edit_parent" value=""/>
	<div>类别名称：<input type="text" name="edit_name" value="" onchange="$('#editbox').data('edit_name',this.value)"  /></div>
	<div>类别序号：<input type="text" name="edit_sequence" value="" onchange="$('#editbox').data('edit_sequence',this.value)" /></div>
	<div>类别属性：<input type="text" name="edit_optional" value="" onchange="$('#editbox').data('edit_optional',this.value)" /></div>
	<div><button type="button" name='edit_cmd' >确定提交</button></div>
	</div>
</div>
<?php
	include("foot.php")
?>