<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" />
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" media="screen,projection" type="text/css" href="{%$base_url%}templates/{%$web_template%}/css/main.css" />
    <link rel="stylesheet" media="screen,projection" type="text/css" href="{%$base_url%}templates/{%$web_template%}/css/2015.css" />
    <!-- MAIN STYLE SHEET -->
    <link rel="stylesheet" media="screen,projection" type="text/css" href="{%$base_url%}templates/{%$web_template%}/css/style.css" />
    <link rel="stylesheet" media="screen,projection" type="text/css" href="{%$base_url%}assets/javascript/jquery-ui.css" />
    <!--[if lte IE 6]><link rel="stylesheet" media="screen,projection" type="text/css" href="{ base_url() }assets/css/main-ie6.css" /><![endif]--><!-- MSIE6 -->

    <link rel="stylesheet" media="screen,projection" type="text/css" href="{%$base_url%}templates/{%$web_template%}/css/superfish.css" />
    <link rel="stylesheet" media="screen,projection" type="text/css" href="{%$base_url%}templates/{%$web_template%}/css/superfish-navbar.css" />
    <link rel="stylesheet" href="{%$base_url%}templates/{%$web_template%}/css/jquery.treeTable.css" type="text/css" />

    <!-- GRAPHIC THEME -->
    <script type="text/javascript" src="{%$base_url%}assets/javascript/jquery-1.8.js"></script>
    <script type="text/javascript" src="{%$base_url%}assets/javascript/jquery.ui.js"></script>
    <script type="text/javascript" src="{%$base_url%}assets/javascript/jquery.treeTable.min.js"></script>
    <script type="text/javascript" src="{%$base_url%}assets/javascript/switcher.js"></script>
    <script type="text/javascript" src="{%$base_url%}assets/javascript/jquery.validate.pack.js"></script>
    <script type="text/javascript" src="{%$base_url%}assets/javascript/superfish.js"></script>
    <script type="text/javascript" src="{%$base_url%}assets/javascript/supersubs.js"></script>
    <script type="text/javascript" src="{%$base_url%}assets/javascript/jquery.inputDefault.js"></script>
    <!-- loading hiAlert  -->
    <script type="text/javascript" src="{%$base_url%}assets/hialert/jquery.hiAlerts-min.js"></script>
    <link rel="stylesheet" href="{%$base_url%}assets/hialert/jquery.hiAlerts.css" type="text/css" />
    <script type="text/javascript" src="{%$base_url%}assets/jnotify/jNotify.jquery.js"></script>
    <link rel="stylesheet" href="{%$base_url%}assets/jnotify/jNotify.jquery.css" type="text/css" />
    <script type="text/javascript">

        $(document).ready(function(){
           $('#sample-menu').superfish({
				pathClass: 'current'
			});	
            // not display:none when measuring. Call before initialising
            // containing tabs for same reason.
				 // function adddept start
		var adfd = {
            rules: {
                opass: {required: true,minlength: 5},
				npass: {required: true,minlength: 5},
                cpass: {required: true}
            },
            messages: {
                opass: {required: "请输入旧密码",minlength: "至少5个字符"},
				npass: {required: "密码需要填写",minlength: "密码至少需要5个字符"},
                cpass: {required: "确认密码需要填写"}
            },
            submitHandler:function(){
               var post_data = $("#hiAlertform").serializeArray();
               var subType = $("#action").val();
			   
			  // return false;
                $.ajax({
                    type: "POST",
                    url: "{%site_url('log/changepw_save')%}",
                    cache:false,
                    data: post_data,
                    success: function(msg){
 							 hiClose();
						if(msg == 1){	 
							jSuccess("操作成功! 正在刷新页面...",{
									VerticalPosition : 'center',
									HorizontalPosition : 'center',
									TimeShown : 500
								});
                               // setInterval(function(){window.location.reload();},1000);	
                            postdnAjax($("#rootid").val());
						};
					 
								if(msg==2){
									hiAlert("写数据库成功,AD域操作失败！");
								}
								if(msg==0){
									hiAlert("操作失败");
								}
 
                     /* if(msg == 3){
							}else{
                            hiAlert(msg);
                        }*/
                    },
                    error:function(){
                        hiAlert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
                    }
                });
				//deptname = $("#ou_name").val();
				//checkDeptname(deptname);  // check dept name
				//alert(checkdeptname);
				return false;
                
            }
        };

		 
			$("#changepw").click(function(){
				$.ajax({
						type: "POST",
						url: '{%site_url("log/changepw")%}',
						cache:false,
						data: "",
						success: function(msg){
					   //  $("#ouShow").html(msg);
							// alert(val); 
							$("#passshow").html(msg);  
							hiBox('#passshow','修改密码',450,'','','.a_close'); 
							$('#hiAlertform').bind("invalid-form.validate").validate(adfd); 
							//$("#adddept").show();   
							
						},
						error:function(){
							hiAlert("出错啦，刷新试试，如果一直出现，可以联系开发人员解决");
						}
					});
				
				 			
			});
			
        });

    </script>
    <title>
    {%$pageTitle%} 
    
    {%$web_title%}</title>
    </head>
    <body>
<div id="main">
<div id="passshow" style="display:none;" >
</div>
<!-- Tray -->
<div id="tray" class="box">
      <p class="f-left box"><img src="{%$base_url%}templates/{%$web_template%}/images/adminLogo.png" /></p>
      <p class="f-right">
      当前用户:<strong>{%$smarty.session.DX_username%} / {%$smarty.session.DX_role_name%}</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <a href="javascript:;"  id="changepw"  >修改密码</a> &nbsp;&nbsp;|&nbsp;&nbsp;
      <strong><a href="{%site_url('log/logout')%}" id="logout">安全退出</a></strong>
      
      </p>
    </div>
<!--  /tray --> 

<!-- Menu -->
<div  id="menu" >
    <ul id="sample-menu" class="sf-menu  " >
    <li><a href="/">管理首页</a></li>
      {%foreach from=$mainmenu item=row%}
      {%$row->menuInfo%}
      {%/foreach%}
  </ul>
</div>

<div class="menuChildDiv" >
<ul class="menuChild">
 {%$menuController%}
</ul>
</div>

<!-- /header -->
<div class="clearb" ></div>
