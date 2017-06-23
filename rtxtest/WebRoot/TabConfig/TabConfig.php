<?php
// cmd == 1 : Get Version
// cmd == 2 : Get Config File
$cmd = $_GET['cmd'];

$file_name = "TabConfig.xml";
//$file_dir = "TabConfig\\";
$file_dir = "";
$file_path = $file_dir . $file_name;

define("DEFAULT_VERSION", "0");
define("DEFAULT_CONTENT", "<?xml version=\"1.0\" encoding=\"GB2312\"?><Tabs Ver=\"0\"></Tabs>");

if( $cmd == 1 )
{	
	$dom = domxml_open_file( $file_name );
	if( $dom == null )
	{
		// 文件不存在，说明管理员没有为客户端配置 Tab，则返回默认的版本号
		// 
		//header("http/1.1 404 dom open file TabConfig.xml failed");
		echo DEFAULT_VERSION;
		exit;
	}
	
	$root = $dom->document_element();
	if( $root == null )
	{
		header("http/1.1 404 TabConfig.xml file content error!");
		exit;
	}
	
	$version = $root->get_attribute("Ver");
	echo $version;
}
else if( $cmd == 2 )
{
	if (file_exists($file_name))
	{
		//
		// NOTE: 用 $_SERVER['HTTP_HOST']，而不用 $_SERVER['SERVER_NAME']
		// 前者能得到 server 的 IP:PORT，而后者只能得到 server 的 IP
		//
		Header("Location: http://" . $_SERVER['HTTP_HOST'] . "/TabConfig/TabConfig.xml");
	}
	else
	{
		echo DEFAULT_CONTENT;
	}
}
else
{
	header("http/1.1 404 参数错误！");
}

?>