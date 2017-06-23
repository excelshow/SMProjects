<script type="text/javascript" src="{%$base_url%}public/js/bootstrap-validator/bootstrapValidator.js"></script>
<script type="text/javascript" src="{%$base_url%}public/js/jquery.form.js"></script><!-- up file blug -->
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
            email: {
                validators: {
                    emailAddress: {}
                }
            },
            userpass: {
                validators: {
                    notEmpty: {},
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
                    notEmpty: {},
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
                 
                    post_url = "{%site_url('admin/system/user_add_do')%}";//"{%site_url('admin/homepage/add')%}";
                
                  //  post_url = "{%site_url('admin/homepage/edit')%}";
				 
                 
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
								title: 'Add user Success! ',
								message: 'current page is being refreshed!!' 
							});     
                             
                            setInterval(function(){
                                window.location.reload();
                            },1000);
                            //  Alert(msg);
                        }else{
                            BootstrapDialog.show({
								type:"type-danger",
								title: 'Add User  Error!',
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
                   <input type="text" class="form-control" name="username"  id="username" placeholder="Login name" value="">
                 
                </div>  
         	</div>
            
             <div class="form-group form-group-sm">
                <label class="col-sm-3 control-label" for="nickname">Nick Name</label>
                 <div class="col-sm-8"> 
                    <input type="text" class="form-control" name="nickname"  id="nickname" placeholder="nick name" value="">
                </div>  
         	</div>
            
          <div class="form-group form-group-sm">
                <label class="col-sm-3 control-label" for="iphone">Phone Number</label>
                 <div class="col-sm-8"> 
                    <input type="text" class="form-control" name="iphone"  id="iphone" placeholder="Phone Number" value="">
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
                    <input type="text" class="form-control" name="email"  id="email" placeholder="Contact E-mail" value="">
                 
                </div>  
         	</div>
               <div class="form-group form-group-sm">
                <label class="col-sm-3 control-label" for="user_group">Group</label>
                 <div class="col-sm-8"> 
                   <select name="user_group" id="user_group" data-toggle="select" class="form-control ">
          			 {%foreach from=$groups item=row%}
                  	<option value="{%$row->group_id%}">{%$row->group_name%}</option> 
                  {%/foreach%}
                  </select>
                </div>  
         	</div> 
           
      
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
  </form>