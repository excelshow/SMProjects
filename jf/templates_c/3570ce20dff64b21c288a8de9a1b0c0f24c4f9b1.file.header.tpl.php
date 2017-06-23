<?php /* Smarty version Smarty-3.1.11, created on 2015-05-12 09:29:46
         compiled from "E:\project\daikuanjifen\httpdocs\templates\admin\header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1872554b0f037cd897-48940859%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3570ce20dff64b21c288a8de9a1b0c0f24c4f9b1' => 
    array (
      0 => 'E:\\project\\daikuanjifen\\httpdocs\\templates\\admin\\header.tpl',
      1 => 1431415766,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1872554b0f037cd897-48940859',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_554b0f03853444_89584689',
  'variables' => 
  array (
    'web_title' => 0,
    'base_url' => 0,
    'type' => 0,
    'navAction' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_554b0f03853444_89584689')) {function content_554b0f03853444_89584689($_smarty_tpl) {?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?php echo $_smarty_tpl->tpl_vars['web_title']->value;?>
</title>
    <meta name="Generator" content="PHP CI">
    <link rel="icon" href="/favicon.ico" mce_href="/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/favicon.ico" mce_href="/favicon.ico" type="image/x-icon">
    <link rel="icon" type="image/gif" href="/favicon.jpg">
    <!-- Loading Bootstrap -->
    <link href="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
public/css/vendor/bootstrap.css" rel="stylesheet">
    <link href="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
public/js/bootstrap-dialog/css/bootstrap-dialog.css" rel="stylesheet"> 
    <!-- Loading Flat UI -->
    <link href="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
public/css/flat-ui.css" rel="stylesheet">
    <link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
templates/admin/css/main.css" />
    
	 
    <!-- GRAPHIC THEME -->

    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
public/jquery-1.11.2.js"></script>   
    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
public/js/flat-ui.min.js"></script> 
    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
public/js/bootstrap-dialog/bootstrap-dialog.js"></script>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
public/js/application.js"></script>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
public/dist/js/vendor/html5shiv.js"></script>
      <script src="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
public/dist/js/vendor/respond.min.js"></script>
    <![endif]-->
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
admin/item/setitem";
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
    </head>

    <body>
<!-- header --> 
<header class="navbar navbar-inverse navbar-static-top navbar-fixed-top" role="navigation">
   <div class="container">
    <div class="navbar-header">
    <button class="navbar-toggle" data-target=".navbar-collapse" data-toggle="collapse" type="button">
    <span class="sr-only">Toggle navigation</span>
    </button>
      <div class="logo"> <img src="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
templates/admin/images/logo.png" class="img-responsive" alt="<?php echo $_smarty_tpl->tpl_vars['web_title']->value;?>
" /> </div>
   </div>
    <div class="collapse navbar-collapse">
          <ul id="navbar-collapse-1"  class="nav navbar-nav navbar-right ">
        
        <li <?php if (($_smarty_tpl->tpl_vars['type']->value=='0')){?> class="active" <?php }?>><a href="<?php echo site_url("admin/item");?>
" >评估记录</a></li>
        <li <?php if (($_smarty_tpl->tpl_vars['type']->value=='1')){?> class="active" <?php }?>><a href="<?php echo site_url("admin/item/log_view");?>
" >访问记录</a></li> 
         <?php if (($_SESSION['admin']=='admin')){?>
        <?php }?>
         
        <li>
              <p class="navbar-text">|</p>
            </li>
        <li  <?php if (($_smarty_tpl->tpl_vars['navAction']->value=='system')){?> class="dropdown active" <?php }else{ ?>class="dropdown" <?php }?>> <a class="dropdown-toggle" data-toggle="dropdown" href="#" ><?php echo $_SESSION['admin'];?>
 系统设置<span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
             <li><a href="<?php echo site_url("admin/system/userlist");?>
" >人员管理</a></li> 
             <li class="divider"></li>
            <!--<li><a href="<?php echo site_url("admin/system/userlist");?>
" >Change Password</a></li>-->
            <li><a href="<?php echo site_url('admin/log/logout');?>
" id="logout">安全退出</a></li>
          </ul>
            </li>
        <li></li>
      </ul>
        </div>
  </div> 
</header> 
<!-- header --> 
<div class="container"> <?php }} ?>