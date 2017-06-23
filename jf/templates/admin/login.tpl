<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" />
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="icon" href="/favicon.ico" mce_href="/favicon.ico" type="image/x-icon">
  <link rel="shortcut icon" href="/favicon.ico" mce_href="/favicon.ico" type="image/x-icon">
  <link rel="icon" type="image/gif" href="/favicon.jpg">
  <!-- Loading Bootstrap -->
  <link href="{%$base_url%}public/css/vendor/bootstrap.css" rel="stylesheet">
  <link href="{%$base_url%}public/js/bootstrap-dialog/css/bootstrap-dialog.css" rel="stylesheet">
  <!-- Loading Flat UI -->
  <link href="{%$base_url%}public/css/flat-ui.css" rel="stylesheet">
  <link rel="stylesheet" media="screen,projection" type="text/css" href="{%$base_url%}templates/admin/css/main.css" />
  <!-- GRAPHIC THEME -->
  
  <script type="text/javascript" src="{%$base_url%}public/jquery-1.11.2.js"></script>
  <script type="text/javascript" src="{%$base_url%}public/js/flat-ui.min.js"></script>
  <script type="text/javascript" src="{%$base_url%}public/js/bootstrap-dialog/bootstrap-dialog.js"></script>
  <script type="text/javascript" src="{%$base_url%}public/js/application.js"></script>
  
  <!-- GRAPHIC THEME -->
  <script type="text/javascript" src="{%$base_url%}public/js/bootstrap-validator/bootstrapValidator.js"></script>
<script type="text/javascript" src="{%$base_url%}public/js/jquery.form.js"></script><!-- up file blug -->
<script type="text/javascript">
$(document).ready(function() {
	//
   $('#form1').bootstrapValidator({
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
                        message: 'The login name can\'t be empty'
                    },
					stringLength: {
                        min: 2,
                        max: 30,
                        message: 'The login name can\'t be empty'
                    }
                }
            },
			 userpass: {
                message: 'The Pass word is not valid',
                validators: {
                    notEmpty: {
                        message: 'The  Pass word    can\'t be empty'
                    }
                }
            } 
		}
    }).on('success.form.bv', function(e) {
		  
	});

    
	
});
</script>
 
  <title>Login - {%$web_title%}</title>
  </head>
  <body>
  <div class="container">
    <div class="row" >
      <div  class=" ">
        <div class="col-xs-12 col-sm-8" >
        	<p>
            	<h3>积分评估工具</h3>
                <small>Please Login</small>
            </p>
        </div>
        <div class="col-xs-12 col-sm-4">
          <div class="panel panel-warning">
            <div class="panel-heading">
              <h4 class="panel-title">Admin Login</h4>
            </div>
            <div class="panel-body">
              <form id="form1" name="form1" class="backLogin"  method="post" action="{%site_url('admin/log/login')%}" role="form">
                <div class="form-group  form-group-sm">
                  <label for="username">Username</label>
                  <input name="username" type="text" class="form-control" id="username"  maxlength="10"  />
                </div>
                <div class="form-group form-group-sm">
                  <label for="userpass">Password:</label>
                  <input type="password" name="userpass" id="userpass" class="form-control"   />
                </div>
                
                <div class="form-group form-group-sm">
                  <input type="submit" name="button" id="button" value="管理员登陆 &gt;&gt;" class="btn btn-block btn-sm btn-inverse" />
                </div>
             
              </form>
            </div>
            <div class="panel-footer"><a href="mailto:lizd11@163.com">@163.com</a></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- --> 
  
  <!-- Footer -->
  
  <div style="  font-size:12px; padding-bottom:10px; text-align:center; " > &copy; {%date('Y')%} <a href="{%$web_copyrighturl%}" target="_blank">{%$web_copyright%}</a>, All Rights Reserved <br />
  </div>
  
  <!-- /footer -->
  
  </body>
  </html>