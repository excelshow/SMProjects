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
	// xml ��־�����ԡ����֡���ͷ��
	// ����û��ʺ������ֿ�ͷ�������ʺſ�ͷ���ϡ�;������;�����Է�ֹ�ʺų�ͻ�����ʺ��в����С�;��
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
			// ����û�û���ϴ�����Ƭ���Ҳ����� dom node���ʲ�������ʧ��
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