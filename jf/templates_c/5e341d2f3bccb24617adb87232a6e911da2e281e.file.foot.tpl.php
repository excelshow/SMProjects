<?php /* Smarty version Smarty-3.1.11, created on 2015-05-07 08:16:45
         compiled from "E:\project\daikuanjifen\httpdocs\templates\default5v1\foot.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17892554b034d7de3b7-44335083%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5e341d2f3bccb24617adb87232a6e911da2e281e' => 
    array (
      0 => 'E:\\project\\daikuanjifen\\httpdocs\\templates\\default5v1\\foot.tpl',
      1 => 1423474297,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17892554b034d7de3b7-44335083',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'web_copyrighturl' => 0,
    'web_copyright' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_554b034d8367f3_44563977',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_554b034d8367f3_44563977')) {function content_554b034d8367f3_44563977($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'E:\\project\\daikuanjifen\\httpdocs\\application\\libraries\\Smarty\\plugins\\modifier.date_format.php';
?> 
 
<footer >
 <div class="container">
  <div class="row"> 
    <!-- main  -->
    <div class="col-xs-12 col-sm-8"> 
   
	<p class="small">
     
    &copy; <?php echo smarty_modifier_date_format(time(),'%Y');?>
 <a href="<?php echo $_smarty_tpl->tpl_vars['web_copyrighturl']->value;?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['web_copyright']->value;?>
</a>. All Rights Reserved.  <br />
 	</p>
    
    </div>
    
    </div>
 </div>
</footer>
<!-- footer -->
</div>
 
</body></html><?php }} ?>