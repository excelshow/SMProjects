<?PHP

require_once "IPLimit.php";

$receiver = $_GET["receiver"];

//取该用户状态以及图像face

$state = -1;
$ObjApi= new COM("Rtxserver.rtxobj");
$objProp= new COM("Rtxserver.collection");
$Name = "SysTools";
$ObjApi->Name = $Name;

$objProp->Add("Username", $receiver);

$Result = @$ObjApi->Call2(0x2001, $objProp);

$errstr = $php_errormsg;

if(strcmp($nullstr, $errstr) != 0)
{
	return;
}
else
{
	$state = intVal($Result);
}

//取用户face
$face = -1;
$Name = "UserManager";
$ObjApi->Name = $Name;

$objProp->Add("Username", $receiver);

$Result = @$ObjApi->Call2(0x0006, $objProp);

$face = $Result->Item("face");
//$filaname = "../../face/".strVal($face+1);
$filename = "images/".strVal($face+1);

switch($state) 
{
case 0://离线
	{
		$filename = $filename."-2.bmp";
		break;
	}
		
case 1://在线
	{
		$filename = $filename."-1.bmp";
		break;
	}
case 2://离开
	{
		$filename = $filename."-3.bmp";
		break;
	}
default://其他任何情况，比如getstatus异常，用户不存在等等，均给出127-2.bmp
	{
		$filename = $filename."-2.bmp";
		break;
	}
}//

//读取文件，返回
//$stream = fopen($filaname, "rb");
//$contents = fread ($handle, filesize ($filaname));
//header("Content-type: image/gif");
//echo $contents;
//fclose ($handle);
header("Location: ".$filename);


?>