<?php


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
echo"<title>客户端部署</title>";
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
echo"<td rowspan=\"5\"><img src=\"images_qk/Apply_OK_left.jpg\" width=\"385\" height=\"456\"></td>";
echo"<td><img src=\"images_qk/Apply_OK_top.jpg\" width=\"289\" height=\"159\"></td>";
echo"<td rowspan=\"5\"><img src=\"images_qk/Apply_OK_right.jpg\" width=\"116\" height=\"456\"></td>";
echo"</tr>";
echo"<tr>";
echo"<td height=\"81\" align=\"center\" background=\"images_qk/Apply_OK_mid.jpg\"><span class=\"style1\">用户名：".$nickname."<br>";
echo"姓　名：".$username."</span></td>";
echo"</tr>";
echo"<tr>";
if($result =="")
{
	echo"<td><img src=\"images_qk/Apply_OK_mid1.jpg\" width=\"289\" height=\"34\"></td>";
}
else
{
	echo"<td><img src=\"images_qk/Apply_OK_mid1_1.jpg\" width=\"289\" height=\"34\"></td>";
}
echo"</tr>";
echo"<tr>";
echo"<td><a href=\"rtxcsetup.exe\"><img src=\"images_qk/Apply_OK_mid2.jpg\" width=\"289\" height=\"68\" style=\"border-top-style:none ; border-right-style:none; border-left-style:none; border-bottom-style:none\"></a></td>";
echo"</tr>";
echo"<tr>";
echo"<td><img src=\"images_qk/Apply_OK_bottom.jpg\" width=\"289\" height=\"114\"></td>";
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
	
	PrintFileContent("refuse.php");

}

 function PrintFileContent($filename)
{
$handle = fopen ($filename, "rb");
$contents = fread ($handle, filesize ($filename));
echo $contents;
fclose ($handle); 
}


?>