<?php include("header.php")?>
 <script src="<?php echo base_url() ?>assets/treeweb/jquery.easing.1.3.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/treeweb/jquery.adubytree.js" type="text/javascript"></script>
<link rel="StyleSheet" href="<?php echo base_url() ?>assets/treeweb/themes/adubytree.css" type="text/css" />
<script type="text/javascript">
   
	//<![CDATA[
	var Alert=ymPrompt.alert;
        $(document).ready(function(){
			 
       $.ajax({
		 type: "GET",
		 url: "<?php echo site_url("admin/admanager/outree") ?>",
		 data: "",
		 dataType:'json',
			 success: function(msg){
				 //data = eval(msg);
				  postdn();
				 outree = {id : "node-0" , data: "Semir", linkurl:"OU=Semir,DC=Semir,DC=cn",children:  msg};
			  //alert(msg); 			  
					$("#localJson").AdubyTree({
					data:outree,
					dataType:"json",
					themes	:	"OrgUser",
					treeType:"extend",
					onSelected  : getopenid,
					checkboxes:false
					});	// $("tr#"+n).remove();
							  
					function getopenid(node){
					postdn(node.linkurl);
					}
									 
			}
	    });
		
		function postdn(val=''){
			 $.ajax({
                        type: "POST",
                        url: '<?php echo site_url("admin/admanager/oulistshow") ?>',
                        cache:false,
                        data: 'dn='+val,
                        success: function(msg){
                           $("#ouShow").html(msg); 
                               // alert(val);
                            
                        },
                        error:function(){
                            alert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
                        }
                    });
			} 
	  
       
   });
    //]]>
</script>
 
<div >
<div class="fleft pad5">
	<div class="ouTreeTitle" >组织结构</div>
    <div class="ouTree pad5"> 
   		<div id="localJson"><img src="/assets/images/loading.gif" width="16" height="16" />Loading...</div>
    </div>
</div>
<div class="  pad5" style=" margin-left:20%;"> 
 
<?php if($action=="add") : ?>
<div style="padding:10px;">
<form id="functionArtice" action="" method="post">
<table  class="treeTable">
	<thead><tr><th colspan="2">添加新闻</th></tr></thead>
    <tr>
      <td>新闻类别</td>
      <td>
      <select id="classId" name="classId" >
      <option value=""> 请选择新闻类别</option>
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
    <tr><td width="100">新闻标题</td><td><input type="text" name="title" value="" /></td></tr>
    <tr><td>新闻简介</td><td><input name="description" type="text" value="" size="50" /></td></tr>
        <tr>
      <td>新闻图片/Photo</td>
      <td> 
     <div style=" margin-left:700px;position:absolute;text-align:right;">
     <div id="show_Logo" style=" "></div>
      <div id="show_Pic" style=" "></div>
     </div>
      <a href="javascript:;" id="buttonpic">选择新闻图片/ View photo</a> <a id="del_Pic"></a>
                <input type="hidden" name="staff_pic" id="staff_pic" value="" />(Stlye:350*539PX,JPG/PNG/BMP)</td>
    </tr>
    <tr><td>新闻内容</td><td>
      <textarea  name="content" id="content"  rows="20" cols="80" ></textarea>
    </td></tr>
    
    <tr>
    <tr><td>新闻关键字</td><td><input type="text" name="keyword" value="" /></td></tr>
    <tr>
      <td>上传日期</td><td><input type="text" name="post_time" value="<?php echo date("Y-m-d")?>" onFocus="calendar(event)" />
         </td></tr>
    <tr><td>新闻作者</td><td><input type="text" name="author" readonly="readonly" value="<?php echo $this->session->userdata('admin') ;?>" /></td></tr>
  
    <tr><td>新闻编辑</td><td><input type="text" readonly="readonly" name="edit_author" value="<?php echo $this->session->userdata('admin') ;?>" /></td></tr>
  
    <tr><td colspan="2"><input type="submit" name="btn_add" id="btn_add" value=" 添加新闻 "  class="buttom" />
      <input type="reset" name="btn_cancel" id="btn_cancel" value=" 重新填写 "  class="buttom" /> <input type="button" name="btn_back" id="btn_back" value=" 放弃添加 "  class="buttom" onclick="javascript:history.go(-1);" /></td></tr>
</table>
</form>
</div>
<?php endif;?>

<?php if($action=="edit") : ?>
<?php foreach ($staff as $row):?>
<div style="padding:10px">
<form id="functionArtice" action="" method="post">
<table  class="treeTable">
	<thead><tr><th colspan="2">编辑新闻</th></tr></thead>
     <tr>
      <td>新闻类别</td>
      <td>
      <select id="classId" name="classId" >
      <option value="">请选择新闻类别</option>
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
    <tr><td width="100">新闻标题</td><td><input type="text" name="title" value="<?php echo $row->title;?>" /></td></tr>
    <tr><td>新闻简介</td><td><input name="description" type="text" value="<?php echo $row->description;?>" size="50" /></td></tr>
     <tr>
      <td>新闻图片/Photo</td>
      <td> 
      <div style=" margin-left:700px;position:absolute;text-align:right;">
     
       
     <div id="show_Pic" style=" ">
      
     <?php
     	if($row->staff_pic != ""):
	 ?>
     <img src='<?php echo base_url()."attachments/staff/" ?>/<?php echo $row->staff_pic;?>' />
     <?php
     endif
	 ?>
     </div>  
     </div>
      <a href="javascript:;"  id="buttonpic">更换图片/ View photo</a>&nbsp;&nbsp; <a href="javascript:;"  id="del_Pic"> -- 删除图片 / Delet Photo </a>
                <input type="hidden" name="staff_pic" id="staff_pic" value="<?php echo $row->staff_pic;?>" />                (Stlye:350*539PX,JPG/PNG/BMP)</td>
    </tr>
    <tr><td>新闻内容</td><td>
      <textarea  name="content"  id="content"  rows="20" cols="80"><?php echo $row->content;?></textarea>
    </td></tr>
    <tr><td>新闻关键字</td><td><input type="text" name="keyword" value="<?php echo $row->keyword;?>" /></td></tr>
    <tr>
      <td>上传日期</td><td><input type="text" name="post_time" value="<?php echo date("Y-m-d",strtotime($row->post_time))?>" onFocus="calendar(event)" />
        </td></tr>
    <tr><td>新闻作者</td><td><input type="text" name="author" value="<?php echo $row->author;?>"  readonly="readonly"/></td></tr>
    
    <tr><td>新闻编辑</td><td><input type="text" readonly="readonly" name="edit_author" value="<?php echo $this->session->userdata('admin') ;?>" /></td></tr>
   
    <tr><td colspan="2"><input type="submit" name="submit" value=" 编辑新闻 "  class="buttom" /><input type="hidden" name="staff_id" value="<?php echo $row->staff_id;?>" />   <input type="reset" name="btn_cancel" id="btn_cancel" value=" 重新填写 "  class="buttom" /> <input type="button" name="btn_back" id="btn_back" value=" 放弃编辑 "  class="buttom" onclick="javascript:history.go(-1);" /></td></tr>
</table>
</form>
</div>
<?php endforeach;?>
<?php endif;?>

<?php if($action=="view"):?>
<div id="ouShow" style="" >
 Loading.....
</div>
<?php endif;?>

</div>
<div class="clearb"></div>
</div>
<?php include("foot.php")?>