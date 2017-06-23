<?php
 include("Getlanguage.php"); 

 $bRet = IsChLanguage();


 if($bRet)
 {
	$Apply_err_top = "Apply_err_top.jpg";
	$Apply_err_mid = "Apply_err_mid.jpg";
	$Apply_err_left = "Apply_err_left.jpg";
	$Apply_err_right = "Apply_err_right.jpg";
	$Apply_err_bottom_left = "Apply_err_bottom_left.jpg";
	$Apply_err_bottom_turnback = "Apply_err_bottom_turnback.jpg";
	$Apply_err_bottom_right = "Apply_err_bottom_right.jpg";
	$Apply_err_bottom = "Apply_err_bottom.jpg";
	
	$strClientDeploy = "客户端部署";
	$strLeftErr = "操作失败，原因可能是[";
	$strRightErr = "]，请联系管理人员";
 
 }
 else
 {
	$Apply_err_top = "Apply_err_top_EN.jpg";
	$Apply_err_mid = "Apply_err_mid_EN.jpg";
	$Apply_err_left = "Apply_err_left.jpg";
	$Apply_err_right = "Apply_err_right.jpg";
	$Apply_err_bottom_left = "Apply_err_bottom_left.jpg";
	$Apply_err_bottom_turnback = "Apply_err_bottom_turnback_EN.jpg";
	$Apply_err_bottom_right = "Apply_err_bottom_right.jpg";
	$Apply_err_bottom = "Apply_err_bottom_EN.jpg";
	
	$strClientDeploy = "Client Deployment";
	$strLeftErr = "Operation failed: The reason may be that [";
	$strRightErr = "]. Please contact the administrator.";
 }
 

$errstr = $_POST["errstr"];
$dept = $_POST["dept"];

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
echo "<html>";
echo "<head>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">";
echo "<title>".$strClientDeploy."</title>";
echo "<style>";
echo "form {padding:0; margin:0;}";
echo ".style2 {font-size: 12px;color: #66FF00;}";
echo "</style>";
echo "</head>";
echo "<script language=\"JavaScript\">";
echo "function OnClickBack()";
echo "{form1.submit();}";
echo "</script>";
echo "<body background=\"images_qk/bg_001.jpg\">";
echo "<table width=\"419\" border=\"0\" align=\"center\" cellpadding=\"2\" cellspacing=\"2\" style=\"WIDTH: 419px; HEIGHT: 492px\">";
echo "<tr>";
echo "<td width=\"60%\" align=\"center\" valign=\"top\"><table width=\"570\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" >";
echo "<tr>";
echo "<td> <br>";
echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
echo "<tr>";
echo "<td colspan=\"3\"><img src=\"images_qk/".$Apply_err_top."\" width=\"790\" height=\"196\"></td>";
echo "</tr>";
echo "<tr>";
echo "<td colspan=\"3\"><table width=\"0\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
echo "<tr>";
echo "<td><img src=\"images_qk/".$Apply_err_left."\" width=\"413\" height=\"66\"></td>";
echo "<td width=\"217\" align=\"center\" background=\"images_qk/".$Apply_err_mid."\"><span class=\"style2\">".$strLeftErr.$errstr.$strRightErr;
echo "</span>";
echo "</td>";
echo "<td><img src=\"images_qk/".$Apply_err_right."\" width=\"160\" height=\"66\"></td>";
echo "</tr>";
echo "</table></td>";
echo "</tr>";
echo "<tr>";
echo "<td><img src=\"images_qk/".$Apply_err_bottom_left."\" width=\"485\" height=\"21\"></td>";
echo "<td><a href=\"javascript:OnClickBack()\"><img src=\"images_qk/".$Apply_err_bottom_turnback."\" width=\"77\" height=\"21\" class=\"hand\" style=\"BORDER-TOP-STYLE: none; BORDER-RIGHT-STYLE: none; BORDER-LEFT-STYLE: none; BORDER-BOTTOM-STYLE: none\"></a></td>";
echo "<td><img src=\"images_qk/".$Apply_err_bottom_right."\" width=\"228\" height=\"21\"></td>";
echo "</tr>";
echo "<tr>";
echo "<td colspan=\"3\"><img src=\"images_qk/".$Apply_err_bottom."\" width=\"790\" height=\"173\"></td>";
echo "</tr>";
echo "</table></td>";
echo "</tr>";
echo "</table>";
echo "<table width=\"570\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">";
echo "<tr>";
echo "</tr>";
echo "</table>";
echo "<form id=\"form1\" method=\"POST\" action=\"reginfo.php\">";
echo "<input type=\"hidden\" id=\"deptpath\" name=\"deptpath\" value=\"$dept\" >";
echo "</form>";
echo "</body>";
echo "</html>";
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