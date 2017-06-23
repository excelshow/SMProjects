<?php /* Smarty version Smarty-3.1.11, created on 2015-03-26 06:32:12
         compiled from "templates\admin\user.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4462551399dc6b3f49-31220315%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ca8ac755288bd2317a063c48474167ee8a6aa1c7' => 
    array (
      0 => 'templates\\admin\\user.tpl',
      1 => 1425980344,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4462551399dc6b3f49-31220315',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'users' => 0,
    'row' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_551399dc714de0_03917556',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_551399dc714de0_03917556')) {function content_551399dc714de0_03917556($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("../admin/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
 
<script type="text/javascript">
   $(document).ready(function(){
	    
        $("#addadmin").click(function(){
			BootstrapDialog.show({
				title: 'Add Supervisor ',
				closeByBackdrop: false,
				message: $('<div></div>').load("<?php echo site_url('admin/system/user_add/');?>
") 
       		});
 
        });
 
        $("button[name='edit']").click(function(){
			 var uid= $(this).val();
			BootstrapDialog.show({
				title: 'Modify Supervisor ',
				closeByBackdrop: false,
				message: $('<div></div>').load("<?php echo site_url('admin/system/user_edit/');?>
/"+$(this).val()) 
       		});
          
        });

        
        // edit password end

        $("button[name='del']").click(function(){

             	var uid = $(this).val();
			BootstrapDialog.confirm('Delete this User, are you sure?', function(result){
            if(result) {

                    $.ajax({

                        type: "POST",

                        url: "<?php echo site_url('admin/system/user_del');?>
",

                        cache:false,

                        data: 'uid='+uid,

                        success: function(msg){
 							BootstrapDialog.show({
								type:BootstrapDialog.TYPE_SUCCESS,
								title: 'Delected Success! ',
								message: 'current page is being refreshed!!' 
							});     
                             
                            setInterval(function(){
                                window.location.reload();
                            },1000);

                        },

                        error:function(){

                           alert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");

                        }

                    });

                }

            });

        });

  
    });

    //]]>

</script>
 
<div class="">
  <button class="btn btn-sm btn-primary pull-right" type="button"  name="addadmin" id="addadmin"  >Add new Supervisor</button>
  <h5>Supervisor Management</h5>
</div>
 

    <div >

       <table id=" " class="table table-bordered table-hover Small Font">

        <thead>

          <tr>

            <th>用户名</th>
            <th>姓名</th>
            <th>手机</th>

            <th>用户邮箱</th>
            <th>类型</th>

            <th>操作</th>

          </tr>

        </thead>

        <?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['users']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>

        <tr id="<?php echo $_smarty_tpl->tpl_vars['row']->value->uid;?>
">

          <td><?php echo $_smarty_tpl->tpl_vars['row']->value->username;?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['row']->value->nickname;?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['row']->value->phone;?>
</td>

          <td><?php echo $_smarty_tpl->tpl_vars['row']->value->email;?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['row']->value->group_name;?>
</td>

          <td><button  name="edit" type="button" class="btn btn-primary btn-xs" value="<?php echo $_smarty_tpl->tpl_vars['row']->value->uid;?>
"   title="Modify"  ><span class="fui-new"></span> M</button>
 
            <button   name="del" type="button" class="btn btn-default btn-xs" value="<?php echo $_smarty_tpl->tpl_vars['row']->value->uid;?>
"  title="Del"  ><span class="fui-cross"></span> D</button></td>

        </tr>

        <?php } ?>

      </table>

    </div>
 

<?php echo $_smarty_tpl->getSubTemplate ("../admin/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
 <?php }} ?>