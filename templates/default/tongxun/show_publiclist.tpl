<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" />
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" media="screen,projection" type="text/css" href="{%$base_url%}templates/{%$web_template%}/css/main.css" />
    <!-- MAIN STYLE SHEET -->
    <link rel="stylesheet" media="screen,projection" type="text/css" href="{%$base_url%}templates/{%$web_template%}/css/style.css" />
    <link rel="stylesheet" media="screen,projection" type="text/css" href="{%$base_url%}assets/javascript/jquery-ui.css" />
    <!--[if lte IE 6]><link rel="stylesheet" media="screen,projection" type="text/css" href="{ base_url() }assets/css/main-ie6.css" /><![endif]--><!-- MSIE6 -->
    <link rel="stylesheet" href="{%$base_url%}templates/{%$web_template%}/tongxun/style.css" type="text/css" />
    <link rel="stylesheet" media="screen,projection" type="text/css" href="{%$base_url%}templates/{%$web_template%}/css/superfish.css" />
    <link rel="stylesheet" media="screen,projection" type="text/css" href="{%$base_url%}templates/{%$web_template%}/css/superfish-navbar.css" />
    <link rel="stylesheet" href="{%$base_url%}templates/{%$web_template%}/css/jquery.treeTable.css" type="text/css" />
    <!-- GRAPHIC THEME -->
    <script type="text/javascript" src="{%$base_url%}assets/javascript/jquery-1.8.js"></script>
    <script type="text/javascript" src="{%$base_url%}assets/javascript/jquery.ui.js"></script>
    <script type="text/javascript" src="{%$base_url%}assets/javascript/jquery.treeTable.min.js"></script>
    <script type="text/javascript" src="{%$base_url%}assets/javascript/switcher.js"></script>
    <script type="text/javascript" src="{%$base_url%}assets/javascript/superfish.js"></script>
    <script type="text/javascript" src="{%$base_url%}assets/javascript/supersubs.js"></script>
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
		 
			
        });

    </script>
    <title>通讯录 - 森马</title>
    </head>
    <body>
<div id="main">
<div id="passshow" style="display:none;" > </div>
<!-- Tray -->
<div id="tray" class="box">
      <p class="f-left box">
       <span style="float:left;" ><img src="{%$base_url%}templates/{%$web_template%}/images/logo.png" height="25" /></span>
      <span style="font-size:20px; margin:0; display:inline-block;">&nbsp;&nbsp;&#8226;&nbsp;&nbsp;通讯录</span>
      </p>
      <p class="f-right"> {%if (isset($smarty.session.userLogin))%}
    当前用户:<strong>{%$smarty.session.cname%} / {%$smarty.session.itname%}</strong>
    <!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="{%site_url('tongxun/show/myinfo')%}"   >我的信息</a> &nbsp;&nbsp; <strong><a href="#" id="logout" class="logout">安全退出</a></strong> 
    <script type="text/javascript">
   
    //<![CDATA[
     
    $(document).ready(function(){
		// Add
		 
	// del
   $('.logout').click(function(){
				 
				hiConfirm('确认退出系统？',null,function(tp){

					if(tp){
						$.ajax({
							type: "POST",
							url: "{%site_url('tongxun/show/logout')%}",
							 
							success: function(msg){
								//alert(msg);
								if(msg=="ok"){
									// $("tr#"+n).remove();
									jSuccess("操作成功! 正在刷新页面...",{
										VerticalPosition : 'center',
										HorizontalPosition : 'center',
										TimeShown : 1000,
									});
							        setInterval(function(){window.location.reload();},1000);
									 
								}else{
									hiAlert(msg);
								}
							}
								   
						});
						return false;
							
					}
				});
			});
	  
       
    });
    //]]>
</script> -->
    {%else%} <a id="logout" href="{%site_url('tongxun/show/show_my')%}">用户登录</a> {%/if%} </p>
    </div>
<!--  /tray --> 

<!-- Menu -->
<div  id="menu" >
      <ul id="sample-menu" class="sf-menu  " >
    <li  class="Current"><a href="{%site_url('tongxun/show/publiclist')%}">公共通讯</a></li>
    <li><a href="{%site_url('tongxun/show/show_my')%}">我的部门</a></li>
    <li><a href="{%site_url('tongxun/show/show_sreach')%}">搜索</a></li>
    <li><a href="{%site_url('tongxun/show/myinfo')%}"   >修改我的信息</a></li>
  </ul>
    </div>

<!--<div class="menuChildDiv" >
<ul class="menuChild">
 
</ul>
</div>--> 

<!-- /header -->
<div class="clearb" ></div>
<script src="{%base_url()%}assets/jstree/jquery.jstree.js" type="text/javascript"></script>
<div id="showLayout" style="display:none;"></div>
<div class=""  style=" ">
      <div class="">
    <form id="deptform" method="post" action="{%site_url('tongxun/show/show_sreach')%}" name="deptform">
          <div id="ouShow" class="pageTitle"  style=" padding:10px;" > 搜索：
        <select name="type" class="searchTopinput  " >
              <option value="1">姓名</option>
              <option value="2">部门名称</option>
               <option value="3"  >号码</option>
            </select>
        &nbsp;
        <input name="searchText"  id="searchText" class="searchTopinput  " type="text"/>
        <input name="searchBut" type="submit" class="searchTopbuttom  " value=""  />
      </div>
        </form>
    <div class="h10"></div>
    <div id="staffshow" class=""> {%if ($data)%}
          {%counter start=1 assign="cnt" print=false%}
          {%foreach from=$data item=row key%}
          {%if $cnt is div by 2%}
          <div style="float:right; width:49%; border:2px solid #666666;"> {%else%}
        <div style="float:left; width:49%; border:2px solid #666666;"> {%/if%}
              <div class="showDeptName" style="font-size:18px; font-weight:normal;">{%$row->sap_name%}</div>
              <div class="pad10" >{%$row->sap_info%}</div>
            </div>
        {%if $cnt is div by 2%}
        <div class="clearb h10"></div>
        {%/if%} 
        {%counter assign="cnt" print=false%}
        {%/foreach%}
        {%/if%}
        <div class="clearb h5"></div>
      </div>
        </div>
  </div>
      <div class="clearb h5"></div>
      <!-- Footer -->
      <div id="footer" class="box">
    <p class="f-left">&copy; {%date('Y')%} <a href="{%$web_copyrighturl%}" target="_blank">{%$web_copyright%}</a>, All Rights Reserved &reg;</p>
    <p class="f-right">推荐使用IE7+浏览器以获得最佳效果<br />
          Power by 森马IT服务科</p>
  </div>
      <!-- footer --> 
      
    </div>
<!-- /main -->

</body>
</html>