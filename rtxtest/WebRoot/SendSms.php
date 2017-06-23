<?php 

require_once "IPLimit.php";

$Sender = "901";
$Receiver = $_POST["txtReceiver"];
$Sms= $_POST["txtSms"];

$cmd = 0x1001;


$ObjApi= new COM("Rtxserver.rtxobj");
$objProp= new COM("Rtxserver.collection");
$Name = "SMSObject";
$ObjApi->Name = $Name;


$objProp->Add("SENDER", $Sender);
$objProp->Add("RECEIVER", $Receiver);
$objProp->Add("SMS", $Sms);
$Result = @$ObjApi->Call2($cmd, $objProp);

$errstr = $php_errormsg;
if(strcmp($nullstr, $errstr) != 0)
{
	print $errstr;
	return 0;
}

echo "²Ù×÷³É¹¦";
?>

