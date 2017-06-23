<?php /* Smarty version Smarty-3.1.11, created on 2015-05-12 10:06:56
         compiled from "templates\admin\log_view.tpl" */ ?>
<?php /*%%SmartyHeaderCode:319885551ad5d4fdf08-56916563%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '60cd49303e158bd80835258afa9c09919bd34a07' => 
    array (
      0 => 'templates\\admin\\log_view.tpl',
      1 => 1431417338,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '319885551ad5d4fdf08-56916563',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_5551ad5d587680_14970703',
  'variables' => 
  array (
    'links' => 0,
    'data' => 0,
    'row' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5551ad5d587680_14970703')) {function content_5551ad5d587680_14970703($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("./header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="container-full "   >
  <div class="row">
    <div class="col-md-6 col-sm-12">
      <h5>评估列表</h5>
    </div>
    
  </div>
</div>
<div class="row" role="complementary"> 
  <!-- /header -->
  <div class="col-xs-12 " role="main" >
    <div  class='pagination pagination-info pagination-sm' ><?php echo $_smarty_tpl->tpl_vars['links']->value;?>
</div>
    <form action="" method="">
      <table  id="tbalemenu" class="table table-striped table-bordered table-hover Small Font">
        <thead>
          <tr>
            <th>访问人</th>
            <th>IP</th>
            <th>访问时间</th>
          </tr>
        </thead>
        <?php if ($_smarty_tpl->tpl_vars['data']->value['list']){?>
        <?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
        <tr  >
          <td><?php echo $_smarty_tpl->tpl_vars['row']->value->itname;?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['row']->value->ipaddress;?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['row']->value->logtime;?>
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