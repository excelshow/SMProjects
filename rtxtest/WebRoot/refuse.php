<?php
 include("Getlanguage.php"); 

 $bRet = IsChLanguage();


 if($bRet)
 {
	$Apply_refuse_top = "Apply_refuse_top.jpg";
	$Apply_refuse_mid = "Apply_refuse_mid.jpg";
	$Apply_refuse_bottom = "Apply_refuse_bottom.jpg";
	
	$strClientDeploy = "客户端部署";
 
 }
 else
 {
 	$Apply_refuse_top = "Apply_refuse_top_EN.jpg";
	$Apply_refuse_mid = "Apply_refuse_mid_EN.jpg";
	$Apply_refuse_bottom = "Apply_refuse_bottom_EN.jpg";
	
	$strClientDeploy = "Client Deployment";
 }



?>

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo  $strClientDeploy; ?></title>
</head>

<body background="images_qk/bg_001.jpg">
		<table width="419" border="0" align="center" cellpadding="2" cellspacing="2" style="WIDTH: 419px; HEIGHT: 492px">
			<tr>
			  <td width="60%" align="center" valign="top"><table width="570" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
					  <td> <br>
					    <table border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td><img src="images_qk/<?php echo $Apply_refuse_top; ?>" width="790" height="178"></td>
                          </tr>
                          <tr>
                            <td><img src="images_qk/<?php echo $Apply_refuse_mid; ?>" width="790" height="168"></td>
                          </tr>
                          <tr>
                            <td><img src="images_qk/<?php echo $Apply_refuse_bottom; ?>" width="790" height="110"></td>
                          </tr>
                        </table></td>
					</tr>
		</table>
					<table width="570" border="0" align="center" cellpadding="0" cellspacing="0">
						<tr>

						</tr>
					</table>
</body>



</html>