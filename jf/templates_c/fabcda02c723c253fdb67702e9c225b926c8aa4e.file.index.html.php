<?php /* Smarty version Smarty-3.1.11, created on 2015-05-13 04:24:27
         compiled from "templates\default5v1\index.html" */ ?>
<?php /*%%SmartyHeaderCode:27213554b0372b6c195-41196218%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fabcda02c723c253fdb67702e9c225b926c8aa4e' => 
    array (
      0 => 'templates\\default5v1\\index.html',
      1 => 1431483854,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '27213554b0372b6c195-41196218',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_554b0372b9d9d0_57606432',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_554b0372b9d9d0_57606432')) {function content_554b0372b9d9d0_57606432($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("./header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script type="text/javascript" src="<?php echo base_url();?>
public/js/bootstrap-validator/bootstrapValidator.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>
public/js/jquery.form.js"></script><!-- up file blug -->
<script type="text/javascript" src="<?php echo base_url();?>
public/js/bootstrap-datetimepicker/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>
public/js/bootstrap-datetimepicker/bootstrap-datetimepicker.zh-CN.js"></script>
<link rel="stylesheet" media="screen,projection"  type="text/css" href="<?php echo base_url();?>
public/js/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" />
<div class="h10"></div>
<div class="container"> 
    <!-- contents 1 --->
    <div class="row">
        <div class="col-xs-12">
            <div  class="page-header">
                <h5>积分评估</h5>
            </div>
            <!-- form -->
            <form name="subForm" id="subForm"  class="form-horizontal"  method="post"     action="" role="form">
                <div class="my-form form-horizontal">
                    <!-- modal body start -->
                    <div class="col-sm-12">
                        <div  class="col-sm-3">
                            <legend>&nbsp;</legend>
                        </div>
                        <div  class="col-sm-9">
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="ndDate">申请年度</label>
                                <div class="col-sm-4">
                                 <select data-toggle="select" id="ndDate" name="ndDate" class="form-control select select-info select-sm">
                                        <option value="2015">2015年度</option>
                                        <option value="2016">2016年度</option>
                                        <option value="2017">2017年度</option>
                                        <option value="2018">2018年度</option>
                                        <option value="2019">2019年度</option> 
                                        <option value="2019">2020年度</option>                                 
                                    </select> 
                                </div>  
                            </div>
                        </div>

                    </div>

                    <!-- 个人基本信息 -->
                    <div class="col-sm-12">
                        <div  class="col-sm-3">
                            <legend>个人基本信息</legend>
                        </div>
                        <div  class="col-sm-9">



                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="zd">职等</label>
                                <div class="col-sm-4"> 
                                    <select data-toggle="select" id="zd" name="zd" class="form-control select select-default select-sm" > 
                                        <option value="">&nbsp;</option>
                                        <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['name'] = 'loop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'] = is_array($_loop=11) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total']);
?>  
                                        <option value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']+1;?>
"><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['loop']['index']+1;?>
 </option>
                                        <?php endfor; endif; ?>  

                                    </select>
                                    <span   class=" popover-show" 
       data-container="body" 
      data-toggle="popover" 
      data-content="抱歉通知您：您未达到申请人基本要求，职等必须在5级(包含5级)以上才能申请！">
       
   </span>
                                </div>  
                            </div>


                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="amb">是否阿米巴长/专家</label>
                                <div class="col-sm-4"> 
                                    <select data-toggle="select" id="amb" name="amb" class="form-control select select-default select-sm"> 
                                        <option value=""></option>
                                        <option value="0">否</option>
                                        <option value="1">是</option>                                  
                                    </select>
                                </div>  
                            </div>

                            <div class="form-group ">
                                <label class="col-sm-3 control-label" for="rzrq">入职日期</label>
                                <div class="col-sm-4"> 
                                <input type="text" class="form-control input-sm " name="rzrq"  id="rzrq" placeholder="入职日期"/>
                                 <span class="rzrq-show" style="float:right;" data-placement="right"
                                   		 data-container="body" 
                                         data-toggle="popover" data-content="抱歉通知您：您未达到申请人基本要求，入职期限为三年以上！">
                                 </span>
                                </div>    
                            </div>

                            <div class="form-group ">
                                <label class="col-sm-3 control-label" for="gzd">工作地</label>
                                <div class="col-sm-4">
                                    <select data-toggle="select" id="gzd" name="gzd" class="form-control select select-default select-sm"> 
                                        <option value=""></option>
                                        <option value="上海">上海</option>
                                        <option value="温州">温州</option>   
                                        <option value="北京">北京</option>
                                        <option value="天津">天津</option>
                                        <option value="广州">广州</option>
                                        <option value="中山">中山</option>   
                                        <option value="武汉">武汉</option>
                                        <option value="长春">长春</option>
                                        <option value="沈阳">沈阳</option>
                                        <option value="深圳">深圳</option>                              
                                    </select>
                                </div>  
                            </div> 
                            <div class="form-group  ">
                                <label class="col-sm-3 control-label" for="fcs">家庭成员工作地房产数量</label>
                                <div class="col-sm-4">
                                    
                                     <select data-toggle="select" id="fcs" name="fcs" class="form-control select select-default select-sm" > 
                                        <option value="">&nbsp;</option>
                                        <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['name'] = 'loop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'] = is_array($_loop=3) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total']);
?>  
                                        <option value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['loop']['index'];?>
"><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['loop']['index'];?>
 </option>
                                        <?php endfor; endif; ?>  
										<option value="3">2套以上</option>
                                    </select>
                                    <span   class=" fcs-show" 
       data-container="body" 
      data-toggle="popover" 
      data-content="抱歉通知您：您未达到申请人基本要求，家庭成员工作地房产数量必须在1套以内(包含1套)！">
       
   </span>
                                </div>  
                            </div>

                        </div>
                    </div>
                    <!-- 个人基本信息 -->
                    <!-- 前两年绩效信息 -->
                    <div class="col-sm-12">
                        <div  class="col-sm-3">
                            <legend>前两年绩效信息</legend>
                        </div>
                        <div  class="col-sm-9">

                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="cd">是否有C/D</label>
                                <div class="col-sm-4"> 
                                    <select data-toggle="select" id="cd" name="cd" class="form-control select select-default select-sm"> 
                                        <option value=""></option>
                                        <option value="0">是</option>
                                        <option value="1">否</option>                                  
                                    </select>
                                    <span   class=" cd-show" 
                                       data-container="body" 
                                      data-toggle="popover" 
                                      data-content="抱歉通知您：您未达到申请人基本要求，绩效有C的目前不予申请！">
                                       
                                   </span>
                                </div>  
                            </div>


                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="jds">季度考核S次数</label>
                                <div class="col-sm-4"> 
                                    <select data-toggle="select" id="jds" name="jds" class="form-control select select-default select-sm"> 
                                        <option value=""></option>
                                        <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['name'] = 'loop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'] = is_array($_loop=9) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total']);
?>  
                                        <option value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['loop']['index'];?>
"><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['loop']['index'];?>
 </option>
                                        <?php endfor; endif; ?>                                
                                    </select>
                                      
                                </div>  
                            </div>

                            <div class="form-group ">
                                <label class="col-sm-3 control-label" for="bns">半年度考核S次数</label>
                                <div class="col-sm-4"> 
                                    <select data-toggle="select" id="bns" name="bns" class="form-control select select-default select-sm"> 
                                        <option value=""></option>
                                         <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['name'] = 'loop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'] = is_array($_loop=5) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total']);
?>  
                                        <option value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['loop']['index'];?>
"><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['loop']['index'];?>
 </option>
                                        <?php endfor; endif; ?>                                 
                                    </select>
                                </div>  
                            </div>

                            <div class="form-group ">
                                <label class="col-sm-3 control-label" for="nds">年度考核S次数</label>
                                <div class="col-sm-4">
                                    <select data-toggle="select" id="nds" name="nds" class="form-control select select-default select-sm"> 
                                        <option value=""></option>
                                        <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['name'] = 'loop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'] = is_array($_loop=3) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total']);
?>  
                                        <option value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['loop']['index'];?>
"><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['loop']['index'];?>
 </option>
                                        <?php endfor; endif; ?>                                  
                                    </select>
                                </div>  
                            </div> 

                        </div>
                    </div>
                    <!-- 前两年绩效信息 -->

                </div>
                <div class="col-sm-12" style="text-align:center;">
                    <p class="small" style=""><span class="text-danger">释义：</span> 家庭成员：已婚人士家庭成员含夫妻双方和子女，未婚人士家庭成员含自己和父母。</p>
                </div>
                <div class="col-sm-12">
                    <div class="form-group ">
                        <div class="col-sm-5"> 
                        </div>
                        <div class="col-sm-6"> 
                            &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;  <button type="submit" class="btn btn-primary btn-lg" name="signup" value="Sign up">提交计算</button>&nbsp;&nbsp; 
                            <button type="button" class="btn btn-default" id="resetBtn">重置表单</button>
                            
                           
                        </div>
                    </div>
                </div>
            </form>
            <!--FORM END  -->
        </div>
    </div>
    <!-- contents 1 ---> 
</div>
<script type="text/javascript">
 function DateDiff(d1,d2){
    var day = 24 * 60 * 60 *1000*365;
	try{    
			var dateArr = d1.split("-");
	   var checkDate = new Date();
			checkDate.setFullYear(dateArr[0], dateArr[1]-1, dateArr[2]);
	   var checkTime = checkDate.getTime();
	  
	   var dateArr2 = d2.split("-");
	   var checkDate2 = new Date();
			checkDate2.setFullYear(dateArr2[0], dateArr2[1]-1, dateArr2[2]);
	   var checkTime2 = checkDate2.getTime();
		
	   var cha = (checkTime - checkTime2)/day;  
			return cha;
		}catch(e){
	   return false;
	}
 };

  $(document).ready(function(){
	 
	  
	  ////
	   var myDate = new Date(); 
    $('#rzrq').datetimepicker({
   			minView: "month", //选择日期后，不会再跳转去选择时分秒 
            format: "yyyy-mm-dd", //选择日期后，文本框显示的日期格式 
            language: 'zh-CN', //汉化 
            autoclose:true, //选择日期后自动关闭
            startDate: "1996-12-18",
            endDate: myDate.toLocaleDateString(),
    });
	
	
   $('#subForm').bootstrapValidator({
   			message: '所有基本信息必填',
            live: 'disabled',
            feedbackIcons: {
            valid: 'glyphicon glyphicon-ok fui-check',
                    invalid: 'glyphicon glyphicon-remove fui-cross',
                    validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
				// /////
              ndDate: { validators: {
						notEmpty: { message: '所有基本信息必填'},
						 
						} },
            //
			zd: { message: '所有基本信息必填', validators: {
						notEmpty: {},
						between: {
                        min: 5,
                        max: 11,
                        message: '您未达到申请人基本要求'
                    }
				} },
            //
			amb: { message: '所有基本信息必填', validators: {notEmpty: {}} },
            //
            rzrq: { validators: {
					notEmpty: {message: '所有基本信息必填'}, 
					date: {
                        format: 'YYYY-MM-DD',
                        message: '请输入日期格式'
                    },
					callback: {
                        message: '您未达到申请人基本要求',
                        callback: function(value, validator) {
                            // Determine the numbers which are generated in captchaOperation
							var ndDate = $("#ndDate").val();
						//	alert(ndDate);
							 var dayNum = DateDiff(ndDate+"-01-01",value);
	  							if (dayNum >= 3) { 
									return true;
								}else{
									return false;
								}
							 
                            
                        }
                    }
				
				} },
			//
            gzd: {message: '所有基本信息必填',validators: {notEmpty: {}}},
            //
			fcs: {message: '所有基本信息必填',validators: {
				 notEmpty: {},
				 between: {
                        min: 0,
                        max: 1,
                        message: '您未达到申请人基本要求'
                    }
				 }},
            //
			 cd: {message: '所有基本信息必填',validators: {
				 notEmpty: {},
					callback: {
                        message: '您未达到申请人基本要求',
                        callback: function(value, validator) {
	  							if (value == 1) { 
									return true;
								}else{
									return false;
								} 
                        }
                    }
				 
				 }},
            //
			 jds: {message: '所有基本信息必填',validators: {notEmpty: {}}},
            //
			 bns: {message: '所有基本信息必填',validators: {notEmpty: {}}},
            //
			 nds: {message: '所有基本信息必填',validators: {notEmpty: {}}},
            //
            }
    }).on('success.form.bv', function(e) {
		
    var post_data = $("#subForm").serializeArray();
            var post_url;
            //alert($("input[name=id]").val());

            post_url = "<?php echo site_url('index/getResult');?>
"; //"<?php echo site_url('admin/homepage/add');?>
";

            //  post_url = "<?php echo site_url('admin/homepage/edit');?>
";


            $.ajax({
            type: "POST",
                    url: post_url,
                    cache:false,
                    data: post_data,
                    success: function(msg){
							BootstrapDialog.show({
									type:BootstrapDialog.TYPE_SUCCESS,
									closable: false,
									title: '计算结果',
									 
									message: msg,
									buttons: [{
									label: '关闭',
									cssClass: 'btn-info',
									action: function(dialogRef) {
											dialogRef.close();
										}
									}]
							});
                    
                    },
                    error:function(){
                    BootstrapDialog.show({
                    type:"type-danger",
                            title: '服务器错误!',
                            message: "Please contact us!!",
                            closable: false,
                            buttons: [{
                           			 label: 'Close',
									  cssClass: 'btn-info',
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
    });
    //////////////////////////////////
	  
	$("#zd").change(function(){
  	 // alert($('#zd').val())
		 if ($(this).val() < 5 ){ 
		 	//alert($('#zd option:first').val());
		 	$('#zd').val("0"); 
		  	$('.popover-show').popover("show");
		 }else{
			 $('.popover-show').popover("hide");
		 }
	});
	//////////////////////////////////
	  
	$("#cd").change(function(){
  	 // alert($('#zd').val())
		 if ($(this).val() == 0 ){ 
		 	//alert($('#zd option:first').val()); 
		  	$('.cd-show').popover("show");
		 }else{
			 $('.cd-show').popover("hide");
		 }
	});
	/////////////////////
	$("#rzrq").change(function(){
  	 var ndDate = $("#ndDate").val();
	 var value  = $(this).val();
	 var dayNum = DateDiff(ndDate+"-01-01",value);
	 //  alert(dayNum);
	  	 if (dayNum >= 3) { 
		 	$('.rzrq-show').popover("hide");
		 }else{
			 $('.rzrq-show').popover("show");
			// $('#rzrq').val(""); 
		 }
		  
	});
	/////////////////////
	  
	$("#fcs").change(function(){
  	 // alert($('#zd').val())
		 if ($(this).val() > 1 ){ 
		 	//alert($('#zd option:first').val());
		  
		  	$('.fcs-show').popover("show");
		 }else{
			 $('.fcs-show').popover("hide");
		 }
	});
	/////////////////////
    $('#resetBtn').click(function() {
 		$('#subForm').data('bootstrapValidator').resetForm(true);
		 window.location.reload();
    });
///
});
</script>
<?php echo $_smarty_tpl->getSubTemplate ("./foot.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>