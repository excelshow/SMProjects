 <script type="text/javascript">
   
	//<![CDATA[
	var Alert=ymPrompt.alert;
        $(document).ready(function(){
			$("table:first tr").addClass('even');
            $('"table:first tr').hover(
					function () {
							$(this).addClass("hover");
					 },
					 function () {
							$(this).removeClass("hover");
					 }
			);

                        	$('button[name="edit"]').click(function(){
						window.location = "<?php echo site_url("admin/admanager") ?>" + $(this).val();
            	});
		});
</script>
<div  class="pad5">
 <div class="fright pad5"  >
 
 <a href="<?php echo site_url("admin/admanager/add_ou") ?>" ><span class="addOu"> 新加组织 </span></a>
 <a href="<?php echo site_url("admin/staff/add_staff") ?>" ><span class="addStaff"> 新加员工 </span></a>
 </div>
 <div style="line-height:22px;">
 	<span class="ouzhuzhi">组织：<?php echo implode(" &raquo; ", $ouTemp);?></span><br>
	<span class="ouDn">AD DN：<?php echo($ouDnPost);?></span>

</div> 
 <div id="ouShow" style=" " >
<form action="<?php echo site_url('admin/staff/multi_del')?>" method="post">
	<table >
	<thead><tr><th><input id="all_check" type="checkbox"/></th>
	<th>名称</th>
	  <th>类型</th>
	  <th>描述</th> <th>状态</th> <th>操作</th></tr></thead>
	  <tbody>
	<?php 
	if($ouData){
	foreach($ouData as $row):
		
	?>
	<tr id="<?php   echo $row['ouDN'];?>">
		<td>
       <?php // echo $row['dn'];?>
        <input class="all_check" type="checkbox" name="staff_id_<?php  echo $row['ouDN'];?>" value="<?php echo $row['ouDN'];?>"/></td>
		<td>
        
		<?php 
		if($row['ouType'] == 'OU'){
			echo "<div class=fleft ><img src='/assets/treeweb/themes/images/orguser/Leaf.gif' /></div>&nbsp;";
			}else{
			echo "<div class=fleft ><img src='/assets/treeweb/themes/images/orguser/user.gif' /></div>&nbsp;";
			}
		echo $row['ouName'];
		
		?></td>
		<td><?php 
		if($row['ouType'] == 'OU'){
			echo " 组织单位";
			}
		if($row['ouType'] == 'CN'){
			echo " AD用户";
			}
		?></td>
		<td><?php //echo $row->dept?></td>
		 
		<td><?php //echo $row->ip1;?></td>
      
		<td>
		 
		<button class="edit" name="edit" type="button"
			value="<?php echo $row['ouDN']; ?>"></button>
		<button class="delete" name="del" type="button"
			value="<?php echo $row['ouDN']; ?>"></button>
	 
			</td>
	</tr>
    
	<?php 
			endforeach;
		}else{
			echo "<tr><td colspan=6 >暂无信息！</td></tr>";
			}
	?>
	</tbody>
	</table>
	</form>	
    </div>
</div>
 