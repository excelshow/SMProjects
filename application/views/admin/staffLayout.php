<?php include("header.php")?>
 
  <script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/uploadify/ajaxupload.js"></script>
 <script language="JavaScript" src="<?php echo base_url()?>assets/calendar.js"></script>
 <script type="text/javascript" src="<?php echo base_url()?>assets/xheditor-1.1.6/xheditor-1.1.6-zh-cn.min.js"></script>
<script type="text/javascript">
	$(pageInit);
	function pageInit()
	{
		$('#content').xheditor({upImgUrl:"<?php echo site_url('admin/product/uploadHtmlPic') ?>",upImgExt:"jpg,jpeg,gif,png",tools:'full'});
		 
	}
</script>

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

            
            	$('button[name="edit"]').click(function(){
						window.location = "<?php echo site_url('admin/staff/edit_staff') ?>/" + $(this).val();
            	});
            	$('button[name="del"]').click(function(){
                	$this = $(this).val();
					 ymPrompt.confirmInfo('信息确认框功能测试',null,null,null,handler);
					 function handler(tp){
						 if(tp=='ok'){
							$.ajax({
							   type: "POST",
							   url: "<?php echo site_url('admin/staff/physical_del')?>",
							   data: "staff_id="+$this,
							   success: function(msg){
								   //alert(msg);
								   if(msg=="ok"){
									  // $("tr#"+n).remove();
									   ymPrompt.succeedInfo({message:'操作成功！请稍候, 正在刷新页面....'});
               							 setInterval(function(){window.location.reload();},1000);
										//window.location = "<?php echo site_url('admin/staff/') ?>";
									
								   }else{
										//alert(msg);
								   }
							   }
							   
							}); 

							return false;
						
						 }
					 }
            	});
             
			
            
 
			
          });
    //]]>
</script>
 
<div style="padding:10px" >
 <div >
 <a href="<?php echo site_url("admin/staff/add_staff") ?>" ><span class="addStaff"> 新加员工 </span></a>
 </div>
<form action="<?php echo site_url('admin/staff/multi_del')?>" method="post">
	<table  class="treeTable" id="treeTable">
	<thead><tr><th width="40"><input id="all_check" type="checkbox"/></th><th>姓名</th>
	  <th>IT帐号</th><th>部门</th> <th>IP</th> <th>AD域状态</th><th>操作</th></tr></thead>
      <tbody>
	<?php foreach($staffs as $row):
	 
	?>
	<tr id="<?php echo $row->id;?>">
		<td><input class="all_check" type="checkbox" name="staff_id_<?php echo $row->id;?>" value="<?php echo $row->id;?>"/></td>
		<td><?php echo $row->cname;?></td>
		<td><?php echo $row->itname;?></td>
		<td><?php echo $row->dept?></td>
		 
		<td><?php echo $row->ip1;?>.<?php echo $row->ip2;?>.<?php echo $row->ip3;?>.<?php echo $row->ip4;?></td>
        <td><?php echo $row->UserAccountControl?></td>
		<td>
		 
		<button class="edit" name="edit" type="button"
			value="<?php echo $row->id ; ?>"></button>
		<button class="delete" name="del" type="button"
			value="<?php echo $row->id ; ?>"></button>
		 
			</td>
	</tr>
	<?php endforeach;?>
	<tr>
		<td>
			<input type="submit" value="   submit" name="submit"  class="delete"/>
			 
		</td>
		
	 
		<td colspan="5"><div align="center"><?php echo $links;?></div></td>
	</tr>
    </tbody>
	</table>
	</form>	
</div>
 
<?php include("foot.php")?>