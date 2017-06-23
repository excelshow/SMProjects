<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title ?></title>
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/jquery.treeTable.css" type="text/css" />
</head>
<body>
<table class="treeTable" width="60%">
<thead><tr><th>服务器变量</th><th>属性值</th></tr></thead>
<tr><td>PHP程式版本：</td><td><?PHP echo PHP_VERSION; ?></td></tr>
<tr><td>ZEND版本：</td><td><?PHP echo zend_version(); ?></td></tr>
<tr><td>MYSQL支持：</td><td><?php echo function_exists('mysql_close')?"是":"否"; ?></td></tr>
<tr><td>MySQL数据库持续连接：</td><td><?php echo @get_cfg_var("mysql.allow_persistent")?"是":"否"; ?></td></tr>
<tr><td>MySQL最大连接数：</td><td><?php echo @get_cfg_var("mysql.max_links")==-1 ? "不限" : @get_cfg_var("mysql.max_links");?></td></tr>
<tr><td>服务器操作系统：</td><td><?PHP echo PHP_OS; ?></td></tr>
<tr><td>服务器端信息：</td><td><?PHP echo $_SERVER['SERVER_SOFTWARE']; ?></td></tr>
<tr><td>最大上传限制：</td><td><?PHP echo get_cfg_var("upload_max_filesize")?get_cfg_var("upload_max_filesize"):"不允许上传附件"; ?></td></tr>
<tr><td>最大执行时间： </td><td><?PHP echo get_cfg_var("max_execution_time")."秒"; ?></td></tr>
<tr><td>脚本运行占用最大内存：</td> <td><?PHP echo get_cfg_var("memory_limit")?get_cfg_var("memory_limit"):"无" ?></td></tr>
</table>
</body>
</html>