<?php /* Smarty version Smarty-3.1.11, created on 2015-03-25 04:09:28
         compiled from "templates\admin\getsoc.tpl" */ ?>
<?php /*%%SmartyHeaderCode:22681551226e87c8ed4-03890206%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bdbb46099204b657425be9a3ed8394f9f244c6c4' => 
    array (
      0 => 'templates\\admin\\getsoc.tpl',
      1 => 1426650693,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '22681551226e87c8ed4-03890206',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'links' => 0,
    'data' => 0,
    'row' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_551226e8835036_81482131',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_551226e8835036_81482131')) {function content_551226e8835036_81482131($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("./header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
 
 <script type="text/javascript">
   $(document).ready(function(){
	   
	   $("button[name=mtest]").click(function(){
		      ////
			   var dialogInstance1 = new BootstrapDialog({
           					type:BootstrapDialog.TYPE_WARNING,
							closeByBackdrop: false,
									title: '测试中 ',
									message: '<p>请耐心等候。。。。</p>' 
        });
			 var post_url = "<?php echo site_url();?>
admin/getsoc/testing";
                $.ajax({
                    type: "POST",
                    url: post_url,
                    cache:false,
                    data:"",
					beforeSend:function(msg){
						 dialogInstance1.open()
					},
                    success: function(msg){ 
					dialogInstance1.close()
                            BootstrapDialog.show({
								type:BootstrapDialog.TYPE_SUCCESS,
								closeByBackdrop: false,
								title: '测试结果：',
								message: msg,
								buttons: [{
									label: 'Close',
									action: function(dialogRef) {
										dialogRef.close();
									}
								}]
							}); 
							setInterval(function(){
                             //   window.location.reload();
                            },2000);    
                         
                    },
                    error:function(){
                        BootstrapDialog.show({
								type:"type-danger",
								closeByBackdrop: false,
								title: '系统错误!',
								message: "<p >   Please contact us!!</p>",
								closable: false,
								buttons: [{
									label: 'Close',
									action: function() {
										// You can also use BootstrapDialog.closeAll() to close all dialogs.
										$.each(BootstrapDialog.dialogs, function(id, dialog){
											dialog.close();
										});
									}
								}]
							});
						
                    }
                });
                return false;
			  ///////////
		   });
   });
  </script>
 <div class="container-full "   >
 <button name="mtest" id="mtest"   class="btn btn-sm btn-primary pull-right"  >手动测试</button>
  <h5>异常列表</h5> 
</div>
 
<div class="row" role="complementary">  
<!-- /header -->
 <div class="col-xs-12 " role="main" >
 
   <div  class='pagination pagination-info pagination-sm' ><?php echo $_smarty_tpl->tpl_vars['links']->value;?>
</div>
<form action="" method="">
	<table  id="tbalemenu" class="table  table-hover Small Font">
	<thead><tr> 
	<th>Hosting</th>
	  <th>Type</th>
	  <th>Message</th>
	  <th>Time</th></tr></thead>
	 <?php if ($_smarty_tpl->tpl_vars['data']->value['list']){?>
     <?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
	<tr  <?php if ($_smarty_tpl->tpl_vars['row']->value->type==1){?>
         class="danger"
         <?php }?> >
		 
		<td><?php echo $_smarty_tpl->tpl_vars['row']->value->hosting;?>
</td>
		<td>
		 <?php if ($_smarty_tpl->tpl_vars['row']->value->type==1){?>
         	异常
         <?php }else{ ?>
            正常
         <?php }?>
		  
		  </td>
		<td>
       <?php echo $_smarty_tpl->tpl_vars['row']->value->content;?>

        </td>
		<td>
		 <?php echo $_smarty_tpl->tpl_vars['row']->value->gettime;?>

       
		</td>
	</tr>
	<?php } ?>
    <?php }?>
	 
	</table>
	</form>	
    <div  class='pagination pagination-info pagination-sm' ><?php echo $_smarty_tpl->tpl_vars['links']->value;?>
</div>
 	</div>
 </div>
<?php echo $_smarty_tpl->getSubTemplate ("./foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>