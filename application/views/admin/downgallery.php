<?php include("header.php")?>
<?php if($action=="add"||$action =="edit"):?>
<script type="text/javascript" src="<?php echo base_url()?>assets/javascript/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/javascript/uploadify/jquery.uploadify.v2.1.0.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/javascript/uploadify/swfobject.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/select_move.js"></script>
 <script language="JavaScript" src="<?php echo base_url()?>assets/calendar.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>assets/javascript/uploadify/uploadify.css" type="text/css" />
<?php endif;?>
<script type="text/javascript">
    //<![CDATA[
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
						window.location = "<?php echo site_url('admin/downgallery/edit_downgallery') ?>/" + $(this).val();
            	});
            	$('button[name="del"]').click(function(){
                	$this = $(this).val();
					 if(!confirm('确定要删除此条信息吗？'))
							return false;
						else{
							$.ajax({
							   type: "POST",
							   url: "<?php echo site_url('admin/downgallery/physical_del')?>",
							   data: "down_id="+$(this).val(),
							   success: function(msg){
								   if(msg=="ok"){
									  
									   $("tr#"+n).remove();
									   //Alert("删除成功");
										//window.location = "<?php echo site_url('admin/downgallery/') ?>";
									
								   }else{
										//alert(msg);
								   }
							   }
							   
							}); 
							
							
							window.location = "<?php echo site_url('admin/downgallery/view') ?>";
							//hiAlert("删除成功");
							return false;
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
								$("form").attr('action','<?php echo site_url('admin/downgallery/physical_del') ?>?q=<?php echo $q; ?>&v=<?php echo $v; ?>&mode=<?php echo $mode; ?>');
						<?php // endif;?>
            	});

				<?php if($mode=="recycle"): ?>
					$("#recover").click(function(){
						if(!$(".all_check:checked").length){
							return false;
						}
						if(!confirm('确定要恢复吗？'))
							return false;
						else{
							$("form").attr('action','<?php echo site_url('admin/downgallery/recover') ?>?q=<?php echo $q; ?>&v=<?php echo $v; ?>&mode=<?php echo $mode; ?>');
						}
					});
				<?php endif;?>
            	
            	
            	
            <?php endif;?>
			
            <?php if($action=="add"||$action=="edit"):?>
			
            $("form").submit(function(){
									 
									  
				// load mid start
					 	var mid = ""
						  $("select[name='selectmid'] option").each(function(){
						   mid += $(this).val()+',';
						  });
						$("input[name='mid']")[0].value = mid; 
						//$(”#columns”)[0].value
			 		//alert(mid);
			 	//load mid end
				// load mid start
					 	var gid = ""
						  $("select[name='selectgallery_id'] option").each(function(){
						   gid += $(this).val()+',';
						  });
						$("input[name='gallery_id']")[0].value = gid; 
						//$(”#columns”)[0].value
			 		//alert(mid);
			 	//load mid end				  
				if($("input[name='down_name']").val()==""){
					hiAlert('标题不能为空');
					return false;	
					}
					if($("input[name='start_time']").val()==""||$("input[name='end_time']").val()==""){
					hiAlert('下载周期不能为空');
					return false;	
					}
					if($("select[name='selectmid'] option").length==0){
					hiAlert('必须选择工厂！');
					return false;	
					}
					if($("select[name='selectgallery_id'] option").length==0){
					hiAlert('必须选择需要下载的图片！');
					return false;	
					}
					if($("input[name='down_optional']").val()==""){
					hiAlert('标题和内容不能为空');
					return false;	
					}
					
				
					
    			}
			);
				// show gallery start
             	$("select[name='class_id']").change(function(){
														 // alert($("select[name='class_id']").val())
						$("select[name='selectgallery']").empty();// 清空下拉框
						
						
						<?php
						  foreach ($gallerys as $row):?>
						<?php //print_r($row)?>
						 if ($("select[name='class_id']").val() ==<?php echo $row->class_id;?>)
						 {
						$("select[name='selectgallery']").append("<option value='<?php echo $row->gallery_id;?>'><?php echo $row->title;?></option>"); 
						 }
						<?php endforeach?>
						
            	});
			 // show gallery end 
			
            <?php endif;?>
        });
        <?php if($action=="add"||$action=="edit"):?>
        function remove_attachment(id){
        	$.ajax({
        		   type: "POST",
        		   url: "<?php echo site_url('admin/attachment/del')?>",
        		   data: "id="+id,
        		   success: function(msg){
            		   if(msg=="ok"){
                		   $("#attach_"+id).remove();
            		   }else{
        		     		alert(msg);
            		   }
        		   }
        		}); 
    		return false;
        }
		
		
        function make_cover(id,value){
        	$.ajax({
     		   type: "POST",
     		   url: "<?php echo site_url('admin/attachment/cover')?>",
     		   data: "id="+id+"&value=1",
     		   success: function(msg){
      		   			if(msg=="ok"){
          		   			$("#make_cover_"+id).toggle();
          		   			$("#cancel_cover_"+id).toggle();
      		   			}else{
  		     				alert(msg);
      		   			}
  		   			} 
     		}); 
 		return false;
        }

        function cancel_cover(id){
        	$.ajax({
     		   type: "POST",
     		   url: "<?php echo site_url('admin/attachment/cover')?>",
     		   data: "id="+id+"&value=0",
     		   success: function(msg){
         		   if(msg=="ok"){
         			  	$("#make_cover_"+id).toggle();
    		   			$("#cancel_cover_"+id).toggle();
         		   }else{
     		     		alert(msg);
         		   }
     		   }
     		}); 
 		return false;
        }

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
    	<?php endif;?>
        
    //]]>
</script>
<div style="padding-top:10px;" > 
<?php if($action=="add") : ?>
<form action="<?php echo site_url('admin/downgallery/add')?>" method="post">
<table  class="treeTable">
	<thead><tr>
	  <th colspan="2">下载添加</th></tr></thead>
    <tr>
      <td width="100">下载标题</td><td><input type="text" name="down_name" value="" /></td></tr>
    
    <tr>
      <td>下载周期</td><td><input type="text" name="start_time" value="<?php echo date("Y-m-d")?>" onFocus="calendar(event)" />
        至
        <input type="text" name="end_time" value="" onFocus="calendar(event)" /></td></tr>
    <tr>
      <td valign="top">选择工厂</td>
      <td>
        
        <div style="width:200px; float:left;" >
          <select name="selectmill" multiple="multiple" id="selectmill" style=" width:200px;height:200px;" ondblclick="addItem(selectmill,selectmid)" >
            <?php foreach ($mill as $row):?>
            <?php //print_r($row)?>
            <option value="<?php echo $row->mid;?>"><?php echo $row->mid;?>/ <?php echo $row->mill_name;?></option>
            <?php endforeach?>
            </select> 
          
          </div>
        <div style=" float:left; width:30px; padding-left:10px;  text-align:center;" ><br />
<br />

          <input type="button" id="btn1" value="-&gt; " onclick="addItem(selectmill,selectmid)" class="buttom1"/>
          <input type="button" id="btn2" value="-&gt;&gt;" onclick="allAddItem(selectmill,selectmid)" class="buttom1"/> 
          
          <input type="button" id="btn3" value="&lt;&lt;-" onclick="allAddItem(selectmid,selectmill)" class="buttom1"/>
          <input type="button" id="btn4" value="&lt;- " onclick="addItem(selectmid,selectmill)" class="buttom1"/>
          
          </div>
        <div style=" padding-left: 250px;">
          <select name="selectmid" multiple="multiple" id="selectmid" style="height:200px; width:200px"  ondblclick="addItem(selectmid,selectmill)">
            </select>
          <input name="mid" type="hidden" id="mid" />
        </div> </td>
      </tr>
    <tr>
      <td valign="top">选择图库</td>
      <td>
      <div style="width:200px; float:left;" >
      <select name="class_id">
            <option value="" selected="selected">选择设计图分类</option>
            <?php foreach($category as $row):?>
            <option value="<?php echo $row->class_id;?>" >
            	<?php for($i=0;$i<$row->deep;$i++):?>
            		<?php echo "&nbsp"?>
            	<?php endfor;?>
            	<?php echo $row->class_name;?>
            </option>
            <?php endforeach;?>
    </select>
      <select name="selectgallery" multiple="multiple" id="selectgallery" style=" width:200px;height:200px;" ondblclick="addItem(selectgallery,selectgallery_id)" >
         <?php foreach ($gallerys as $row):?>
        <?php //print_r($row)?>
          <option value="<?php echo $row->gallery_id;?>"> <?php echo $row->title;?></option>
        <?php endforeach?>
      </select> 
      
      </div>
     <div style=" float:left; width:30px;   padding-left:10px; text-align:center;" >
		<br /><br />
        <input type="button" id="btn1" value="-&gt;&nbsp; " onclick="addItem(selectgallery,selectgallery_id)" class="buttom1"/>

        <input type="button" id="btn2" value="-&gt;&gt;" onclick="allAddItem(selectgallery,selectgallery_id)" class="buttom1" /> 
           
           <input type="button" id="btn3" value="&lt;&lt;-" onclick="allAddItem(selectgallery_id,selectgallery)" class="buttom1"/>
           <input type="button" id="btn4" value="&lt;- " onclick="addItem(selectgallery_id,selectgallery)" class="buttom1"/>
           
         </div>
          <div style=" padding-left: 250px;">
      	<select name="selectgallery_id" multiple="multiple" id="selectgallery_id" style="height:220px; width:200px"  ondblclick="addItem(selectgallery_id,selectgallery)" >
        </select>
      	<input name="gallery_id" type="hidden" id="gallery_id" />
          </div>
      </td>
    </tr>
    <tr><td valign="top">下载说明</td><td>
      <textarea  name="down_optional" id="down_optional" style="width:400px;height:100px;visibility:hidden;"></textarea>
    </td></tr>
    <tr>
      <td>建立人</td><td><input type="text" name="author" value="<?php echo $this->session->userdata('admin') ;?>" readonly="readonly" /></td></tr>
    <tr>
      <td>最后编辑人：</td><td><input readonly="readonly" type="text" name="edit_author" value="<?php echo $this->session->userdata('admin') ;?>" /></td></tr>
    <!--<tr><td>是否推荐</td><td><select name="is_best">
            <option value="0" selected="selected">否</option>
            <option value="1">是</option> 
    </select></td></tr>-->
    <tr><td colspan="2"><input type="submit" name="submit" value="添加下载" class="buttom" />
     </td></tr>
</table>
</form>
<?php endif;?>

<?php if($action=="edit") : ?>
<?php foreach ($downgallery as $row):?>

<form action="<?php echo site_url('admin/downgallery/edit')?>" method="post">
<table  class="treeTable">
	<thead><tr><th colspan="2">编辑新闻</th></tr></thead>
    <tr><td width="100">下载标题</td><td><input type="text" name="down_name" value="<?php echo $row->down_name;?>" /></td></tr>
    
    <tr>
      <td>下载周期</td><td><input type="text" name="start_time" value="<?php echo date("Y-m-d",strtotime($row->start_time))?>" onFocus="calendar(event)" />
        至
        <input type="text" name="end_time" value="<?php echo date("Y-m-d",strtotime($row->end_time))?>" onFocus="calendar(event)" /></td></tr>
    <tr>
      <td valign="top">选择工厂</td>
      <td>
        
        <div style="width:200px; float:left;" >
          <select name="selectmill" multiple="multiple" id="selectmill" style=" width:200px;height:200px;" ondblclick="addItem(selectmill,selectmid)" >
            <?php foreach ($mill as $rowmill):?>
            <?php //print_r($row)?>
            <option value="<?php echo $rowmill->mid;?>"><?php echo $rowmill->mid;?>/ <?php echo $rowmill->mill_name;?></option>
            <?php endforeach?>
            </select> 
          
          </div>
        <div style=" float:left; width:30px;   padding-left:10px; text-align:center;" ><br />
<br />

          <input type="button" id="btn1" value="-&gt;" onclick="addItem(selectmill,selectmid)" class="buttom1"/>
          <input type="button" id="btn2" value="-&gt;&gt;" onclick="allAddItem(selectmill,selectmid)" class="buttom1"/> 
          
          <input type="button" id="btn3" value="&lt;&lt;-" onclick="allAddItem(selectmid,selectmill)" class="buttom1"/>
          <input type="button" id="btn4" value="&lt;- " onclick="addItem(selectmid,selectmill)" class="buttom1"/>
          
          </div>
        <div style=" padding-left: 250px;">
          <select name="selectmid" multiple="multiple" id="selectmid" style="height:200px; width:200px"  ondblclick="addItem(selectmid,selectmill)">
          <?php
          		//$mid = $row->mid;
				$res=explode(",",$row->mid);
				 for($a=0;$a<count($res);$a++){
				if ($aa = $this->mill_model->get_mill_byid($res[$a]))
						{
					//  print_r($aa);
			?>
            <option value="<?php echo $aa->mid;?>"><?php echo $aa->mill_name;?></option>
            <?php
						
						  echo "<br>";
						} 
				  }
		  ?>
            </select>
          <input name="mid" type="hidden" id="mid" value="<?php echo $row->mid;?>" />
        </div> </td>
      </tr>
    <tr>
      <td valign="top">选择图库</td>
      <td>
      <div style="width:200px; float:left;" >
      <select name="class_id">
            <option value="" selected="selected">选择设计图分类</option>
            <?php foreach($category as $rowcate):?>
            <option value="<?php echo $rowcate->class_id;?>" >
            	<?php for($i=0;$i<$rowcate->deep;$i++):?>
            		<?php echo "&nbsp"?>
            	<?php endfor;?>
            	<?php echo $rowcate->class_name;?>
            </option>
            <?php endforeach;?>
    </select>
      <select name="selectgallery" multiple="multiple" id="selectgallery" style=" width:200px;height:200px;" ondblclick="addItem(selectgallery,selectgallery_id)" >
         <?php foreach ($gallerys as $rowg):?>
        <?php //print_r($row)?>
          <option value="<?php echo $rowg->gallery_id;?>"> <?php echo $rowg->title;?></option>
        <?php endforeach?>
      </select> 
      
      </div>
     <div style=" float:left; width:30px;   padding-left:10px; text-align:center;" ><br />
<br />

        <input type="button" id="btn1" value="-&gt; " onclick="addItem(selectgallery,selectgallery_id)" class="buttom1"/>
        <input type="button" id="btn2" value="-&gt;&gt;" onclick="allAddItem(selectgallery,selectgallery_id)" class="buttom1"/> 
           
           <input type="button" id="btn3" value="&lt;&lt;-" onclick="allAddItem(selectgallery_id,selectgallery)" class="buttom1"/>
           <input type="button" id="btn4" value="&lt;- " onclick="addItem(selectgallery_id,selectgallery)" class="buttom1"/>
           
         </div>
          <div style=" padding-left: 250px;">
      	<select name="selectgallery_id" multiple="multiple" id="selectgallery_id" style="height:220px; width:200px"  ondblclick="addItem(selectgallery_id,selectgallery)" >
        <?php
                   // echo $row->mid;
                        $res=explode(",",$row->gallery_id);
                    for($i=0;$i<count($res);$i++){
                       if($aa = $this->gallery_model->get_gallery_byid($res[$i]))
                               {
                               echo $aa->title;
                  ?>
            <option value="<?php echo $aa->gallery_id;?>"><?php echo $aa->title;?></option>
            <?php

                               }
                      
                         
                          }
                        ?>
        </select>
      	<input name="gallery_id" type="hidden" id="gallery_id" value="<?php echo $row->gallery_id;?>"/>
          </div>
      </td>
    </tr>
    <tr><td valign="top">下载说明</td><td><textarea  name="down_optional" id="down_optional" style="width:400px;height:100px;visibility:hidden;"><?php echo $row->down_optional?></textarea></td></tr>
    <tr>
      <td>建立人</td><td><input type="text" name="author" value="<?php echo $row->author;?>" readonly="readonly" /></td></tr>
    <tr>
      <td>最后编辑人：</td><td><input readonly="readonly" type="text" name="edit_author" value="<?php echo $this->session->userdata('admin') ;?>" /></td></tr>
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
    <tr><td colspan="2"><input type="submit" name="submit" value="编辑新闻" class="buttom" />
            <input type="hidden" name="downgallery_id" value="<?php echo $row->downgallery_id; ?>" /></td></tr>
</table>
</form>
<?php endforeach;?>
<?php endif;?>

<?php if($action=="view"):?>
<div >

</div>
<form action="<?php echo site_url('admin/downgallery/multi_del')?>?q=<?php echo $q; ?>&v=<?php echo $v; ?>&mode=<?php echo $mode; ?>" method="post">
	<table  class="treeTable">
	<thead><tr><th width="40"><input id="all_check" type="checkbox"/></th><th>下载标题</th>
	  <th>下载周期(开始-结束)</th><th>工厂</th> <th>下载图库</th><th>上传/编辑者</th><th>操作</th></tr></thead>
	<?php foreach($downgallerys as $row):?>
	<tr id="<?php echo $row->downgallery_id;?>">
		<td><input class="all_check" type="checkbox" name="downgallery_id_<?php echo $row->downgallery_id;?>" value="<?php echo $row->downgallery_id;?>"/></td>
		<td><?php echo $row->down_name;?></td>
		<td><?php echo date("Y-m-d",strtotime($row->start_time));?> - <?php echo date("Y-m-d",strtotime($row->end_time));?></td>
		<td>
                <?php
                   // echo $row->mid;
                        $res=explode(",",$row->mid);
                         for($a=0;$a<count($res);$a++){
                        if ($aa = $this->mill_model->get_mill_byid($res[$a]))
                                {
                            //  print_r($aa);
                                echo $aa->mill_name;
                                  echo "<br>";
                                } 
                          }
                        ?>

                </td>
		 <td><?php //echo $row->gallery_id?>
                  <?php
                   // echo $row->mid;
                        $res=explode(",",$row->gallery_id);
                    for($i=0;$i<count($res);$i++){
                       if($aa = $this->gallery_model->get_gallery_byid($res[$i]))
                               {
                               echo $aa->title;
                               echo "<br>";

                               }
                      
                         
                          }
                        ?>
                 </td>
		<td>
                         <?php echo date("Y-m-d",strtotime($row->post_time))?><br>
                         <?php echo $row->author?> / <?php echo $row->edit_author?>
                </td>
		<td>
		<?php if($mode=="normal"):?>
		<button class="edit" name="edit" type="button"
			value="<?php echo $row->downgallery_id ; ?>"></button>
		<button class="delete" name="del" type="button"
			value="<?php echo $row->downgallery_id ; ?>"></button>
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
		<td colspan="6"><div align="center"><?php echo $links;?></div></td>
	</tr>
	</table>
	</form>	
 </div>
<?php endif;?>
 
<?php include("foot.php")?>