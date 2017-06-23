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
		// �ļ������ڣ�˵������Աû��Ϊ�ͻ������� Tab���򷵻�Ĭ�ϵİ汾��
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
		// NOTE: �� $_SERVER['HTTP_HOST']�������� $_SERVER['SERVER_NAME']
		// ǰ���ܵõ� server �� IP:PORT��������ֻ�ܵõ� server �� IP
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
	header("http/1.1 404 ��������");
}

?>