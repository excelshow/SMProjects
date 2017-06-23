<?php
 include("Getlanguage.php"); 

 $bRet = IsChLanguage();


 
 if($bRet)
 {
	$index_top1 = "index_top1.jpg";
	$index_mid = "index_mid.jpg";
	$index_bottom_download = "index_bottom_download.jpg";
	$index_bottom_applyaccount = "index_bottom_applyaccount.jpg";
	$index_bottom_right = "index_bottom_right.jpg";
	$index_bottom_top = "index_bottom_top.jpg";
	$index_bottom_bottom = "index_bottom_bottom.jpg";
	$index_bottom_left = "index_bottom_left.jpg";
	$strClientDeploy = "¿Í»§¶Ë²¿Êð"; 
 }
 else
 {
	$index_top1 = "index_top1_EN.jpg";
	$index_mid = "index_mid_EN.jpg";
	$index_bottom_download = "index_bottom_download_EN.jpg";
	$index_bottom_applyaccount = "index_bottom_applyaccount_EN.jpg";
	$index_bottom_right = "index_bottom_right_EN.jpg";
	$index_bottom_top = "index_bottom_top_EN.jpg";
	$index_bottom_bottom = "index_bottom_bottom_EN.jpg";
	$index_bottom_left = "index_bottom_left.jpg";
	$strClientDeploy = "Client Deployment";
 }



?>



<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">

<title><?php echo $strClientDeploy; ?></title>
</head>

<body background="images_qk/bg_001.jpg">
		<table width="419" border="0" align="center" cellpadding="2" cellspacing="2" style="WIDTH: 419px; HEIGHT: 492px">
			<tr>
			  <td width="60%" align="center" valign="top"><table width="570" border="0" align="center" cellpadding="0" cellspacing="0" >
					<tr>
					  <td> <br>
					    <table border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td colspan="4"><img src="images_qk/<?php echo $index_top1;?>" width="790" height="157"></td>
                          </tr>
                          <tr>
                            <td colspan="4"><img src="images_qk/<?php echo $index_mid;?>" width="790" height="150"></td>
                          </tr>
                          <tr>
                            <td colspan="4"><img src="images_qk/<?php echo $index_bottom_top; ?>" width="790" height="16"></td>
                          </tr>
                          <tr>
                            <td><img src="images_qk/<?php echo $index_bottom_left; ?>" width="36" height="60"></td>
                            <td><a href="rtxcsetup.exe"><img src="images_qk/<?php echo $index_bottom_download;?>" width="221" height="60" class="hand" style="BORDER-TOP-STYLE: none; BORDER-RIGHT-STYLE: none; BORDER-LEFT-STYLE: none; BORDER-BOTTOM-STYLE: none"></a></td>
                            <td><a href="redirect.php"><img src="images_qk/<?php echo $index_bottom_applyaccount;?>" width="180" height="60" border="0" class="hand" onclick="javascript:window.location = 'l.php'"></a></td>
                            <td><img src="images_qk/<?php echo $index_bottom_right;?>" width="353" height="60" border="0" usemap="#Map2"></td>
                          </tr>
                          <tr>
                            <td colspan="4"><img src="images_qk/<?php echo $index_bottom_bottom; ?>" width="790" height="73"></td>
                          </tr>
                        </table></td>
					</tr>
		</table>
					<table width="570" border="0" align="center" cellpadding="0" cellspacing="0">
						<tr>

						</tr>
					</table>



            <map name="Map2">
              <area shape="rect" coords="-7,-1,161,59" href="check.php">
</map>
</body>



</html>