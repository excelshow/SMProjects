<?PHP


$receiver = $_GET["receiver"];

if (strlen($receiver) == 0)
{
	$receiver = $_POST["receiver"];
}



$ObjApi= new COM("Rtxserver.rtxobj");
$objProp= new COM("Rtxserver.collection");
$Name = "USERMANAGER";
$ObjApi->Name = $Name;
$vName="";
$vValue="";
$objProp->Add("USERNAME", $receiver);

$Result = @$ObjApi->Call2(0x6, $objProp);

if(strcmp($nullstr, $errstr) == 0)
{

	$Result->GetKeyValue(5, $vName, $vValue);

	header("Ret Code: 0");
	header("Ret String: ╡ывВЁи╧╕");
	header("Mobile: ".strVal($vValue));
	echo $vValue;

}
else
{
	header("Ret Code: -1");
	header("Ret String: ".$errstr);
	echo $errstr;
	

}




?>