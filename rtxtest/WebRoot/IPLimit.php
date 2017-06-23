<?php
if (PHP_VERSION>='5')
 require_once('domxml-php4-to-php5.php');

$visitorIP = $_SERVER['REMOTE_ADDR'];
$visitorIP = trim($visitorIP);
//$visitorDns = $_SERVER['REMOTE_HOST'];

define("LOCAL_IP_PREFIX", 			"127.0.0.");
define("IPLIMIT_CONFIGFILE_NAME", 	"SDKProperty.xml");
define("ELEM_SDKHTTP", 				"SDKHttp");
define("ELEM_IPLIMIT", 				"IPLimit");
define("ATTR_LIMITENABLED", 		"Enabled");
define("ELEM_IP", 					"IP");

function GetIPLimitConfigFilePath()
{
	$path = dirname(__FILE__); // webroot
	$path = dirname($path); // RTXServer
	$path .= "\\";
	$path .= IPLIMIT_CONFIGFILE_NAME;
	
	return $path;
}

function IsVisitorLimited($visitorIP)
{
	if (strpos($visitorIP, LOCAL_IP_PREFIX) !== false)
	{
		return false;
	}
	
	$iplimitConfigFilePath = GetIPLimitConfigFilePath();
	if (!file_exists($iplimitConfigFilePath))
	{
		return false;
	}
	
	$isLimitEnabled = "0";
	$arPermittedIP = array();
	GetIPLimitInfo($iplimitConfigFilePath, $isLimitEnabled, $arPermittedIP);
	
	if ($isLimitEnabled == "0")
	{
		return false;
	}
	
	if (in_array($visitorIP, $arPermittedIP, false))
	{
		return false;
	}
	
	return true;
}

function GetIPLimitInfo($iplimitConfigFilePath, &$isLimitEnabled, &$arPermittedIP)
{
	$isLimitEnabled = "0";
	
	$dom = domxml_open_file($iplimitConfigFilePath);
	if ($dom == null)
	{
		header("http/1.1 404 domxml_open_file failed!");
		exit;
	}
	
	$dom_root = $dom->document_element();
	if ($dom_root == NULL)
	{
		header("http/1.1 404 ip limit config file invalid!");
		exit;		
	}
	
	$sdkhttpNode = NULL;
	$arPropertyChildNodes = $dom_root->child_nodes();
	for ($i = 0; $i < count($arPropertyChildNodes); $i++)
	{
		if (strcasecmp($arPropertyChildNodes[$i]->node_name(), ELEM_SDKHTTP) == 0)
		{
			$sdkhttpNode = $arPropertyChildNodes[$i];
			break;
		}
	}
	
	if ($sdkhttpNode != NULL)
	{
		 $arSDKCgiChildNodes = $sdkhttpNode->child_nodes();
		 foreach ($arSDKCgiChildNodes as $sdkcgiChildNode)
		 {
		 	if (strcasecmp($sdkcgiChildNode->node_name(), ELEM_IPLIMIT) == 0)
		 	{
		 		$arAttr = $sdkcgiChildNode->attributes();
		 		for ($i = 0; $i < count($arAttr); $i++)
		 		{
		 			if (strcasecmp($arAttr[$i]->name, ATTR_LIMITENABLED) == 0)
		 			{
		 				$isLimitEnabled = $arAttr[$i]->value();
		 			}
		 		}
		 		
		 		if ($isLimitEnabled == "1")
		 		{			 	
				 	$arChildNodesIP = $sdkcgiChildNode->child_nodes();
				 	foreach ($arChildNodesIP as $childNodeIP)
				 	{
				 		if (strcasecmp($childNodeIP->node_name(), ELEM_IP) == 0)
				 		{
				 			array_push($arPermittedIP, trim($childNodeIP->get_content()));
				 		}
				 	}
				}
			 	
			 	break;
		 	}
		}
	}	
}

if (IsVisitorLimited($visitorIP))
{
	echo "IP 受限，请联系管理员开放您的 IP";
	//header("http/1.1 404 IP limited!");
	exit;
}

?>