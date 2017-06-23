<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{%$web_title%}</title>
    <meta name="Generator" content="PHP CI">  
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

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="{%$base_url%}public/js/vendor/html5shiv.js"></script>
      <script src="{%$base_url%}public/js/vendor/respond.min.js"></script>
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
			 var post_url = "{%site_url()%}admin/item/setitem";
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
      <div class="logo"> <img src="{%$base_url%}templates/admin/images/logo.png" class="img-responsive" alt="{%$web_title%}" /> </div>
   </div>
    <div class="collapse navbar-collapse">
          <ul id="navbar-collapse-1"  class="nav navbar-nav navbar-right ">
        
        <li {%if ($type eq '0')%} class="active" {%/if%}><a href="{%site_url("admin/item")%}" >评估记录</a></li>
        <li {%if ($type eq '1')%} class="active" {%/if%}><a href="{%site_url("admin/item/log_view")%}" >访问记录</a></li> 
         {%if ($smarty.session.admin=='admin')%}
        {%/if%}
         
        <li>
              <p class="navbar-text">|</p>
            </li>
        <li  {%if ($navAction=='system')%} class="dropdown active" {%else%}class="dropdown" {%/if%}> <a class="dropdown-toggle" data-toggle="dropdown" href="#" >{%$smarty.session.admin%} 系统设置<span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
             <li><a href="{%site_url("admin/system/userlist")%}" >人员管理</a></li> 
             <li class="divider"></li>
            <!--<li><a href="{%site_url("admin/system/userlist")%}" >Change Password</a></li>-->
            <li><a href="{%site_url('admin/log/logout')%}" id="logout">安全退出</a></li>
          </ul>
            </li>
        <li></li>
      </ul>
        </div>
  </div> 
</header> 
<!-- header --> 
<div class="container"> 