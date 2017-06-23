<?PHP

require_once "IPLimit.php";

$receiver = $_GET["receiver"];
$msg = $_GET["msg"];
$title = $_GET["title"];
$delaytime = $_GET["delaytime"];
$okurl = $_GET["okurl"];
$errurl = $_GET["errurl"];

if ((strlen($receiver) == 0) 
	&& (strlen($msg) == 0) 
	&& (strlen($title) == 0)
	&& (strlen($delaytime) == 0)
	&& (strlen($okurl) == 0) 
	&& (strlen($errurl) == 0))
{
	$receiver = $_POST["receiver"];
	$msg = $_POST["msg"];
	$title = $_POST["title"];
	$delaytime = $_POST["delaytime"];
	$okurl = $_POST["okurl"];
	$errurl = $_POST["errurl"];
}

if (strlen($receiver) == 0)
{
	$receiver = "";
}
if(strlen($msg) == 0) 
{
	$msg = "";
}
if(strlen($title) == 0)
{
	$title = "";
}
if(strlen($delaytime) == 0)
{
	$delaytime = 0;
}
if(strlen($okurl) == 0) 
{
	$okurl = "";
}
if(strlen($errurl) == 0)
{
	$errurl = "";
}


$php_errormsg = NULL;

$ObjApi= new COM("Rtxserver.rtxobj");
$objProp= new COM("Rtxserver.collection");
$Name = "ExtTools";
$ObjApi->Name = $Name;

$objProp->Add("msgInfo", $msg);
$objProp->Add("MsgID", "1");
$objProp->Add("Type", "0");
$objProp->Add("AssType", "0");
if (strlen($title) == 0)
{
	$objProp->Add("Title", "通知");
}
else
{
	$objProp->Add("Title", $title);
}
$objProp->Add("DelayTime", $delaytime);
if (strtolower($receiver) == "all")
{
	$objProp->Add("Username", $receiver);
	$objProp->Add("SendMode", "1");
}
else
{
	$objProp->Add("Username", $receiver);
}


$Result = @$ObjApi->Call2(0x2100, $objProp);

$errstr = $php_errormsg;
if(strcmp($nullstr, $errstr) == 0)
{
	if (strlen($okurl) > 0)
	{
		header("Location: ".$okurl);
	}
	else
	{
		echo "<script language=\"JavaScript\">\r\n";
		echo "alert(\"操作成功\")";
		echo "</script>\r\n";
		
	}
}
else
{
	//send err
	if (strlen($errurl) > 0)
	{
		header("Location: ".$errurl);
	}
	else
	{
		echo $errstr."<br>";
		
	}
}




?>