<?php /* Smarty version Smarty-3.1.11, created on 2015-03-26 06:32:14
         compiled from "templates\admin\user_modify.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8207551399de6b6c11-47593901%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ba3a359f3f2cd5454da1846c049857e99d8e6cf1' => 
    array (
      0 => 'templates\\admin\\user_modify.tpl',
      1 => 1425979957,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8207551399de6b6c11-47593901',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'base_url' => 0,
    'user' => 0,
    'groups' => 0,
    'row' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_551399de71b845_42723675',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_551399de71b845_42723675')) {function content_551399de71b845_42723675($_smarty_tpl) {?><script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
public/js/bootstrap-validator/bootstrapValidator.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
public/js/jquery.form.js"></script><!-- up file blug -->
<script type="text/javascript">
    $(document).ready(function(){
     $('#subForm').bootstrapValidator({
        message: 'This value is not valid',
       live: 'disabled',
         feedbackIcons: {
           valid: 'glyphicon glyphicon-ok fui-check',
            invalid: 'glyphicon glyphicon-remove fui-cross',
            validating: 'glyphicon glyphicon-refresh'
        }, 
        fields: {
            username: {
                message: 'The login name is not valid',
                validators: {
                    notEmpty: {
                        message: 'The login name is required and can\'t be empty'
                    },
					stringLength: {
                        min: 2,
                        max: 30,
                        message: 'The login name must be more than 2 and less than 30 characters long'
                    }
                }
            },
			  nickname: {
                message: 'The nick name is not valid',
                validators: {
                    notEmpty: {
                        message: 'The nick name is required and can\'t be empty'
                    },
					stringLength: {
                        min: 2,
                        max: 30,
                        message: 'The nick name must be more than 2 and less than 30 characters long'
                    }
                }
            },
			  iphone: {
               validators: {
                    notEmpty: {
                        message: 'The input is not a valid   phone number'
                    }
                }
            },
            email: {
                validators: {
                    emailAddress: {}
                }
            },
            userpass: {
                validators: {
                    identical: {
                        field: 'confirm_userpass',
                        message: 'The password and its confirm are not the same'
                    },
                    different: {
                        field: 'username',
                        message: 'The password cannot be the same as username'
                    }
                }
            },
            confirm_userpass: {
                validators: {
                    identical: {
                        field: 'userpass'
                    },
                    different: {
                        field: 'username',
                        message: 'The password cannot be the same as username'
                    }
                }
            }
		}
    }).on('success.form.bv', function(e) {
		 var post_data = $("#subForm").serializeArray();
		 		var post_url;
				//alert($("input[name=id]").val());
                 
                    post_url = "<?php echo site_url('admin/system/user_edit_do');?>
";//"<?php echo site_url('admin/homepage/add');?>
";
                
                  //  post_url = "<?php echo site_url('admin/homepage/edit');?>
";
				 
                 
                $.ajax({
                    type: "POST",
                    url: post_url,
                    cache:false,
                    data: post_data,
                    success: function(msg){
 
                        if(msg=="ok"){
                            // $("#editbox").html("");
							BootstrapDialog.show({
								type:BootstrapDialog.TYPE_SUCCESS,
								title: 'Add AD banner Success! ',
								message: 'current page is being refreshed!!' 
							});     
                             
                            setInterval(function(){
                                window.location.reload();
                            },1000);
                            //  Alert(msg);
                        }else{
                            BootstrapDialog.show({
								type:"type-danger",
								title: 'Add AD banner  Error!',
								message: msg,
								buttons: [{
									label: 'Close',
									action: function(dialogRef) {
										dialogRef.close();
									}
								}]
							});     
                        }
                    },
                    error:function(){
                        BootstrapDialog.show({
								type:"type-danger",
								title: 'Add nav Error!',
								message: "Please contact us!!",
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
	});
	  //////////////////////////////////
});
</script>
<form name="subForm" id="subForm"  class="form-horizontal"  method="post"   enctype='multipart/form-data' action="" role="form">
  <div class="my-form form-horizontal">
<!-- modal body start -->
        <div class="form-group form-group-sm">
                <label class="col-sm-3 control-label" for="username">Login Name</label>
                 <div class="col-sm-8">
                   <input type="text" class="form-control" name="username"  id="username" placeholder="Login name" value="<?php echo $_smarty_tpl->tpl_vars['user']->value->username;?>
">
                  <input type="hidden"  name="uid"  id="uid"   value="<?php echo $_smarty_tpl->tpl_vars['user']->value->uid;?>
">
                </div>  
         	</div>
          
             <div class="form-group form-group-sm">
                <label class="col-sm-3 control-label" for="nickname">Nick Name</label>
                 <div class="col-sm-8"> 
                    <input type="text" class="form-control" name="nickname"  id="nickname" placeholder="nick name" value="<?php echo $_smarty_tpl->tpl_vars['user']->value->nickname;?>
">
                </div>  
         	</div>
          <div class="form-group form-group-sm">
                <label class="col-sm-3 control-label" for="iphone">Phone Number</label>
                 <div class="col-sm-8"> 
                    <input type="text" class="form-control" name="iphone"  id="iphone" placeholder="Phone Number" value="<?php echo $_smarty_tpl->tpl_vars['user']->value->phone;?>
">
                </div>  
         	</div>
        <div class="form-group form-group-sm">
          <label class="col-sm-3 control-label" for="userpass">Pass word</label>
                 <div class="col-sm-8">
                 <input type="password" class="form-control" name="userpass"  id="userpass" placeholder="Pass word" value="">
                </div>  
    </div>
          <div class="form-group form-group-sm">
            <label class="col-sm-3 control-label" for="confirm_userpass">Confirm PW </label>
                 <div class="col-sm-8">
                    <input type="password" class="form-control" name="confirm_userpass"  id="confirm_userpass" placeholder="Confirm pass word" value="">
                 
                </div>  
   	</div>
         
          <div class="form-group form-group-sm">
                <label class="col-sm-3 control-label" for="email">E-mail</label>
                 <div class="col-sm-8">
                    <input type="text" class="form-control" name="email"  id="email" placeholder="Contact E-mail" value="<?php echo $_smarty_tpl->tpl_vars['user']->value->email;?>
">
                 
                </div>  
         	</div>
              
             <div class="form-group form-group-sm">
                <label class="col-sm-3 control-label" for="user_group">Group</label>
                 <div class="col-sm-8"> 
                   <select name="user_group" id="user_group" data-toggle="select" class="form-control ">
          			 <?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['groups']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
                  	<option value="<?php echo $_smarty_tpl->tpl_vars['row']->value->group_id;?>
"  <?php if (($_smarty_tpl->tpl_vars['user']->value->group_id==$_smarty_tpl->tpl_vars['row']->value->group_id)){?> selected="selected" <?php }?>><?php echo $_smarty_tpl->tpl_vars['row']->value->group_name;?>
</option> 
                  <?php } ?>
                  </select>
                </div>  
         	</div>
            
          
       
      
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
  </form><?php }} ?>