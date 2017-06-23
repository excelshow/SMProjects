<?php
$user_account = $_GET['user_account'];
//echo $user_account;
if ($user_account == NULL)
{
	header("http/1.1 404 user account is not reasonable");
	exit;
}
else
{
	// xml 标志不能以‘数字’开头，
	// 如果用户帐号以数字开头，则在帐号开头加上“;”，“;”可以防止帐号冲突，因帐号中不能有“;”
	//
	if ($user_account[0] >= '0' && $user_account[0] <= '9')
	{
		$user_account = "user----------" . $user_account;
	}
	
	define("PHOTOVER_FILE", "photoVer.xml");
	 
	$encoding = ini_get("default_charset");
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
		$userAccountConv = mb_convert_encoding($user_account, 'UTF-8', $encoding);
		//echo $userAccountConv;
		$arNodes = $dom_root->get_elements_by_tagname($userAccountConv);
		if ($arNodes[0] != NULL)
		{
			echo $arNodes[0]->get_attribute("ver");	
		}
		else
		{
			//
			// 如果用户没有上传过照片则找不到该 dom node，故不能算作失败
			//
			
			//header("http/1.1 404 dom open file TabConfig.xml failed");	
			echo "0";
		}
		
	}
	else
	{
		echo "0";
		//echo "photoVer file not exist";
		/*
		$dom = domxml_new_doc("1.0");
		$this->m_dom_root = $dom->add_root("UserFile");
		*/
	}		
}
?>