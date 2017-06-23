<?PHP

require_once "IPLimit.php";

$receiver = $_GET["receiver"];
$receiveruin = $_GET["receiveruin"];
$msg = $_GET["msg"];
$sender = $_GET["sender"];
$okurl = $_GET["okurl"];
$errurl = $_GET["errurl"];

if ((strlen($receiver) == 0) 
	&& (strlen($receiveruin) == 0) 
	&& (strlen($msg) == 0) 
	&& (strlen($sender) == 0) 
	&& (strlen($okurl) == 0) 
	&& (strlen($errurl) == 0))
{
	$receiver = $_POST["receiver"];
	$receiveruin = $_POST["receiveruin"];
	$msg = $_POST["msg"];
	$sender = $_POST["sender"];
	$okurl = $_POST["okurl"];
	$errurl = $_POST["errurl"];
}

$php_errormsg = NULL;

//==========================

$ObjApi= new COM("Rtxserver.rtxobj");
$objProp= new COM("Rtxserver.collection");
$Name = "SMSObject";
$ObjApi->Name = $Name;


$objProp->Add("Sender", $sender);

if (strlen($receiver) > 0)
{
	$objProp->Add("Receiver", $receiver);
}
else if (strlen($receiveruin) > 0)
{
	$objProp->Add("ReceiverUin", $receiveruin);
}

$objProp->Add("Sms", $msg);

$Result = @$ObjApi->Call2(0x1001, $objProp);

//==========================

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
		echo "alert(\"²Ù×÷³É¹¦\")";
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