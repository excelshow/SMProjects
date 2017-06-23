<?PHP

require_once "IPLimit.php";

$receiver = $_GET["username"];

//取该用户状态
$state = 12;
$ObjApi= new COM("Rtxserver.rtxobj");
$objProp= new COM("Rtxserver.collection");
$objProp->Add("Username", $receiver);
$Result = @$ObjApi->Call2(0x2001, $objProp);
$errstr = $php_errormsg;
if(strcmp($nullstr, $errstr) == 0)
{
  $state = intVal($Result);
}
echo $state;

?>