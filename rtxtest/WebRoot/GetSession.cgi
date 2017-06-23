<?PHP

require_once "IPLimit.php";

$receiver = $_GET["receiver"];

if (strlen($receiver) == 0)
{
	$receiver = $_POST["receiver"];
}

//取该用户状态以及图像face

$ObjApi= new COM("Rtxserver.rtxobj");
$objProp= new COM("Rtxserver.collection");
$Name = "SYSTOOLS";
$ObjApi->Name = $Name;

$objProp->Add("Username", $receiver);

$Result = @$ObjApi->Call2(0x2000, $objProp);

$errstr = $php_errormsg;

if(strcmp($nullstr, $errstr) == 0)
{
	header("Ret Code: 0");
	header("Ret String: 操作成功");
	header("SessionKey: ".strVal($Result));
	echo "$Result";

}
else
{
	header("Ret Code: -1");
	header("Ret String: ".$errstr);
	echo $errstr;
	

}

?>