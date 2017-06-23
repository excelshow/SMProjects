<?php

//
// 校验用户身份
//

// {{{ 首先更新照片版本号
//

$user_account 	= $_POST['user_account'];
$file_name 	= $_POST["file_name"];
$file_data 	= $_POST["file_data"];

if ($user_account == NULL || $file_name == NULL || $file_data == NULL)
{
	header("http/1.1 404 parameters are not reasonable");
	exit;
}

// xml 标志不能以‘数字’开头，
// 如果用户帐号以数字开头，则在帐号开头加上“;”，“;”可以防止帐号冲突，因帐号中不能有“;”
//
if ($user_account[0] >= '0' && $user_account[0] <= '9')
{
	$user_account = "user----------" . $user_account;
}

define("PHOTOVER_FILE", "photoVer.xml");
$encoding = ini_get("default_charset");
$dom = NULL;
$dom_root = NULL;
$userAccountConv = mb_convert_encoding($user_account, 'UTF-8', $encoding);
$bNodeExist = FALSE;

if (file_exists(PHOTOVER_FILE))
{
	$dom = domxml_open_file(PHOTOVER_FILE);
	if ($dom == null)
	{
		header("http/1.1 404 domxml_open_file failed!");
		exit;
	}
	$dom_root = $dom->document_element();
	//$arNodes = $dom_root->get_elements_by_tagname($user_account);
	//echo $userAccountConv;
	$arNodes = $dom_root->get_elements_by_tagname($userAccountConv);
	if ($arNodes[0] != NULL)
	{
		$ver_old = $arNodes[0]->get_attribute("ver");
		if ($ver_old < 0)
		{
			$ver_old = 0;
		}
		$arNodes[0]->set_attribute("ver", $ver_old + 1);
		
		$bNodeExist = TRUE;		
	}	
}
else
{
	$dom = domxml_new_doc("1.0");
	$dom_root = $dom->add_root("PhotoVer");
}

if ($bNodeExist == FALSE)
{
	$new_node = $dom_root->new_child($userAccountConv);
	$new_node->set_attribute("ver", 1);
}

$xml_string = $dom->dump_mem(true, $encoding);
$fHdl = fopen(PHOTOVER_FILE, 'w');
if ($fHdl == false)
{
	header("http/1.1 404 open file failed");
	exit;
}
$res = fwrite($fHdl, $xml_string);
$res = fclose($fHdl);
if ($res == false)
{
	header("http/1.1 404 fwrite or fclose failed");
	exit;
}

// }}} 更新照片版本号
	
$file_save_dir = dirname(__FILE__);
//$file_save_dir = dirname($file_save_dir);

$file_save_dir = $file_save_dir . "\\PhotoFiles\\";
if (!file_exists($file_save_dir))
{
	mkdir($file_save_dir);
}
$file_save_dir .= $file_name;

if( !$fh = fopen($file_save_dir, 'w') )
{
	header("http/1.1 404 can't open save-to file");
	exit;
}
fwrite($fh, base64_decode($file_data));
fclose($fh);

?>