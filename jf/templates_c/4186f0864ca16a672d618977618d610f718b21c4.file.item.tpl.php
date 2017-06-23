<?php /* Smarty version Smarty-3.1.11, created on 2015-05-12 10:06:49
         compiled from "templates\admin\item.tpl" */ ?>
<?php /*%%SmartyHeaderCode:227955122b5954a717-47120856%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4186f0864ca16a672d618977618d610f718b21c4' => 
    array (
      0 => 'templates\\admin\\item.tpl',
      1 => 1431417338,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '227955122b5954a717-47120856',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_55122b595b76d5_63417267',
  'variables' => 
  array (
    'key' => 0,
    'links' => 0,
    'data' => 0,
    'row' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55122b595b76d5_63417267')) {function content_55122b595b76d5_63417267($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("./header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="container-full "   >
  <div class="row">
    <div class="col-md-6 col-sm-12">
      <h5>评估列表</h5>
    </div>
    <form name="subForm" id="subForm"  class=" "  method="get"   action="" role="form">
      <div class="col-md-6 col-sm-12">
        <div class=" " style="padding-top:5px; display:none;">
          <div class="input-group ">
            <input name="keyword" type="text" class="form-control" id="keyword" placeholder="请输入查询关键字" value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" >
            <span class="input-group-btn">
            
            <button class="btn btn-default" type="submit">查询!</button>
            </span> </div>
        </div>
      </div>
    </form>
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
            <th>测试</th>
            <th>年度</th>
            <th>职等</th>
            <th>阿米巴/专家</th>
            <th>入职日期</th>
            <th>工作地</th>
            <th>房产</th>
            <th>绩效C/D</th>
            <th>季度S</th>
            <th>半年S</th>
            <th>年度S</th>
            <th>评分</th>
            <th>提交时间</th>
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
<?php echo $_smarty_tpl->tpl_vars['row']->value->ipaddress;?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['row']->value->ndDate;?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['row']->value->zd;?>
 </td>
          <td>
          <?php if (($_smarty_tpl->tpl_vars['row']->value->amb==1)){?>
          是
          <?php }else{ ?>
          否
          <?php }?>
          </td>
          <td><?php echo $_smarty_tpl->tpl_vars['row']->value->rzrq;?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['row']->value->gzd;?>
</td>
          <td> <?php echo $_smarty_tpl->tpl_vars['row']->value->fcs;?>
 </td>
          <td>
           <?php if (($_smarty_tpl->tpl_vars['row']->value->cd==0)){?>
          是
          <?php }else{ ?>
          否
          <?php }?>
          </td>
          <td><?php echo $_smarty_tpl->tpl_vars['row']->value->jds;?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['row']->value->bns;?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['row']->value->nds;?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['row']->value->total;?>
</td>
          <td><?php echo $_smarty_tpl->tpl_vars['row']->value->subtime;?>
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