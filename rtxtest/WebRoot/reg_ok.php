<?php

 include("Getlanguage.php"); 

 $bRet = IsChLanguage();

 
 if($bRet)
 {
	$Apply_OK_left = "Apply_OK_left.jpg";
	$Apply_OK_top = "Apply_OK_top.jpg";
	$Apply_OK_top_1 = "Apply_OK_top.jpg";
	$Apply_OK_right = "Apply_OK_right.jpg";
	$Apply_OK_right_1 = "Apply_OK_right.jpg";	
	$Apply_OK_mid = "Apply_OK_mid.jpg";
	$Apply_OK_mid1 = "Apply_OK_mid1.jpg";
	$Apply_OK_mid1_1 = "Apply_OK_mid1_1.jpg";
	$Apply_OK_mid2 = "Apply_OK_mid2.jpg";
	$Apply_OK_bottom = "Apply_OK_bottom.jpg";
	
	$strClientDeploy = "客户端部署";
	$strUsername = "用户名：";
	$strChsname = "姓　名：";
 }
 else
 {
	$Apply_OK_left = "Apply_OK_left_EN.jpg";
	$Apply_OK_top = "Apply_OK_top_EN.jpg";
	$Apply_OK_top_1 = "Apply_OK_top_1_EN.jpg";
	$Apply_OK_right = "Apply_OK_right_EN.jpg";
	$Apply_OK_right_1 = "Apply_OK_right_1_EN.jpg";	
	$Apply_OK_mid = "Apply_OK_mid_EN.jpg";
	$Apply_OK_mid1 = "Apply_OK_mid1_EN.jpg";
	$Apply_OK_mid1_1 = "Apply_OK_mid1_1_EN.jpg";
	$Apply_OK_mid2 = "Apply_OK_mid2_EN.jpg";
	$Apply_OK_bottom = "Apply_OK_bottom.jpg";
	
	$strClientDeploy = "Client Deployment"; 
	$strUsername = "User ID:";
	$strChsname =  "&nbsp;&nbsp;&nbsp;Name:";
 }
 

$nickname = $_POST["nickname"];
$username = $_POST["username"];
$result = $_POST["result"];

 $myroot = strtolower(getcwd());
 $ipos = strpos($myroot,"\\webroot");
 $iroot = sprintf("%s\\usermgr.cfg", $myroot);
 if($ipos > 0)
 {
   $iroot =  sprintf("%s\\usermgr.cfg", substr($myroot, 0, $ipos));
 }
 $ini_array = @parse_ini_file($iroot);
 //print_r($ini_array);
 $refuse_reg_user= 0;
 if(array_key_exists("refuse_reg_user", $ini_array))
 {
   $refuse_reg_user = $ini_array["refuse_reg_user"];
 }
if($refuse_reg_user == 0)
{
echo" <html>";
echo"<head>";
echo"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">";
echo"<title>".$strClientDeploy."</title>";
echo"<style type=\"text/css\">";
echo"<!--";
echo".style1 {color: #66FF00;font-size: 12px;}";
echo"-->";
echo"</style>";
echo"</head>";
echo"<body background=\"images_qk/bg_001.jpg\">";
echo"<table width=\"419\" border=\"0\" align=\"center\" cellpadding=\"2\" cellspacing=\"2\" style=\"WIDTH: 419px; HEIGHT: 492px\">";
echo"<tr>";
echo"<td width=\"60%\" align=\"center\" valign=\"top\"><table width=\"570\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" >";
echo"<tr>";
echo"<td> <br>";
echo"<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
echo"<tr>";
echo"<td rowspan=\"5\"><img src=\"images_qk/".$Apply_OK_left."\" width=\"385\" height=\"456\"></td>";

if($result =="")
{
    echo"<td><img src=\"images_qk/".$Apply_OK_top_1."\" width=\"289\" height=\"159\"></td>";	//??????
	echo"<td rowspan=\"5\"><img src=\"images_qk/".$Apply_OK_right."\" width=\"116\" height=\"456\"></td>"; //??????
}
else
{
	echo"<td><img src=\"images_qk/".$Apply_OK_top."\" width=\"289\" height=\"159\"></td>"; //?????
	echo"<td rowspan=\"5\"><img src=\"images_qk/".$Apply_OK_right_1."\" width=\"116\" height=\"456\"></td>";  //?????

}

echo"</tr>";
echo"<tr>";

echo"<td height=\"81\" align=\"center\" background=\"images_qk/".$Apply_OK_mid."\"><span class=\"style1\">".$strUsername.$nickname."<br>";

echo $strChsname.$username."</span></td>";
echo"</tr>";
echo"<tr>";
if($result =="")
{
	echo"<td><img src=\"images_qk/".$Apply_OK_mid1."\" width=\"289\" height=\"34\"></td>";	//??????
}
else
{
	echo"<td><img src=\"images_qk/".$Apply_OK_mid1_1."\" width=\"289\" height=\"34\"></td>"; //?????
}
echo"</tr>";
echo"<tr>";
echo"<td><a href=\"rtxcsetup.exe\"><img src=\"images_qk/".$Apply_OK_mid2."\" width=\"289\" height=\"68\" style=\"border-top-style:none ; border-right-style:none; border-left-style:none; border-bottom-style:none\"></a></td>";
echo"</tr>";
echo"<tr>";
echo"<td><img src=\"images_qk/".$Apply_OK_bottom."\" width=\"289\" height=\"114\"></td>";
echo"</tr>";
echo"</table></td>";
echo"</tr>";
echo"</table>";
echo"<table width=\"570\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">";
echo"<tr>";
echo"</tr>";
echo"</table>";
echo"</body>";
echo"</html>";

}

else
{
	header("Location: selDept.php"); 
	//PrintFileContent("refuse.php");

}

 function PrintFileContent($filename)
{
$handle = fopen ($filename, "rb");
$contents = fread ($handle, filesize ($filename));
echo $contents;
fclose ($handle); 
}


?>