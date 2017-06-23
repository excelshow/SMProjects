<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>数据导入</title>

	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal '微软雅黑',Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}
	.fred{
		color:#C00;
	}
	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body{
		margin: 0 15px 0 15px;
	}
	
	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	
	#container{
		margin: 10px;
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
	}
	body,td,th {
	font-family: "微软雅黑", Helvetica, Arial, sans-serif;
}
    </style>
  <script type="text/javascript" src="{%$base_url%}assets/javascript/jquery-1.8.js"></script>
 
</head>
<body>

<div id="container">
	<h1>Temp: <span class="fred">导入数据专用，非管理员请勿使用。</span></h1>

	<div id="body">
		<p>离职用户获取 </p>
       
      <code><p> /index.php/temp/tempstaff/enabled
	    </p>
	 
        </code>

	  <p>地点导入</p>
	  
     
      
	  <code>
       /index.php/temp/tempstaff/updateLoction     </code> 
  <p> 用户信息to AD(工作地、手机) 
		 </p> 
      <code>
      /index.php/temp/tempstaff/uptoad
      
        </code>

	  <p>用户PW to AD：</p>
	  <code>/index.php/temp/tempstaff/pwtoad
	  <form name="form1" method="post" action="{%site_url('temp/tempstaff/pwtoad')%}">
<textarea name="key" cols="100" rows="6" id="key"></textarea>
<br>
<input type="submit" value="导入密码》">
      </form><br>
All user to AD:/index.php/temp/tempstaff/pwtoadAll
      </code>
	</div>

	
</div>
 
</body>
</html>