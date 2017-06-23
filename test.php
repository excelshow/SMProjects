<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>
<!-- GRAPHIC THEME -->
    <script type="text/javascript" src="https://10.80.63.9/assets/javascript/jquery-1.5.js"></script> 
     
	<script type="text/javascript" src="/assets/jstree/jquery.jstree.js"></script>
	
<body>
 
   <div id="demo2" class="demo" style="height:100px;">
	<ul>
		<li id="rhtml_1" class="jstree-open">
			<a href="#">Root node 1</a>
			<ul>
				<li id="rhtml_2">
					<a href="#">Child node 1</a>
				</li>
				<li id="rhtml_3">
					<a href="#">Child node 2</a>
				</li>
			</ul>
		</li>
		<li id="rhtml_4">
			<a href="#">Root node 2</a>
		</li>
	</ul>
</div>
<script type="text/javascript" class="source below">
// Note method 2) and 3) use `one`, this is because if `refresh` is called those events are triggered
$(function () {
	$("#demo2")
		.jstree({ "plugins" : ["themes","html_data","ui"] })
		// 1) the loaded event fires as soon as data is parsed and inserted
		.bind("loaded.jstree", function (event, data) { })
		// 2) but if you are using the cookie plugin or the core `initially_open` option:
		.one("reopen.jstree", function (event, data) { })
		// 3) but if you are using the cookie plugin or the UI `initially_select` option:
		.one("reselect.jstree", function (event, data) { });
});
</script>
 


</body>
</html>