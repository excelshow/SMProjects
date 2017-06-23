<?php
 include("Getlanguage.php"); 

 $bRet = IsChLanguage();

 
 if($bRet)
 {
	$test1_r1_c1 = "test1_r1_c1.jpg";
	$selectDept_r4_c61 = "selectDept_r4_c6%20(3).jpg";
	$test1_r2_c7 = "test1_r2_c7.jpg";
	$test1_r3_c2 = "test1_r3_c2.jpg";
	$test1_r4_c2 = "test1_r4_c2.jpg";
	$selectDept_r4_c6 = "selectDept_r4_c6.jpg";
	$test1_r5_c3 = "test1_r5_c3.jpg";
	$test1_r6_c3 = "test1_r6_c3.jpg";
	$test1_r6_c5 = "test1_r6_c5.jpg";
	$test1_r7_c4 = "test1_r7_c4.jpg";
	$test1_r6_c4 = "test1_r6_c4.jpg";
	
	$strClientDeploy = "客户端部署";

 }
 else
 {
	$test1_r1_c1 = "test1_r1_c1_EN.jpg";
	$selectDept_r4_c61 = "selectDept_r4_c6%20(3)_EN.jpg";
	$test1_r2_c7 = "test1_r2_c7.jpg";
	$test1_r3_c2 = "test1_r3_c2.jpg";
	$test1_r4_c2 = "test1_r4_c2_EN.jpg";
	$selectDept_r4_c6 = "selectDept_r4_c6.jpg";
	$test1_r5_c3 = "test1_r5_c3.jpg";
	$test1_r6_c3 = "test1_r6_c3.jpg";
	$test1_r6_c5 = "test1_r6_c5.jpg";
	$test1_r7_c4 = "test1_r7_c4.jpg";
	$test1_r6_c4 = "test1_r6_c4_EN.jpg";
	
	$strClientDeploy = "Client Deployment";
 }

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title><?php echo $strClientDeploy; ?></title>
<style type="text/css">
td img {display: block;}
</style>
</head>
<script language="JavaScript">
function OnClickOK()
{
	form1.deptpath.disabled = false;
	form1.submit();
}
</script>

<body background="images_qk/bg_001.jpg">
<table width="570" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td> <br />
        <table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table border="0" cellpadding="0" cellspacing="0" width="785">
              <!-- fwtable fwsrc="未命名" fwbase="test1.jpg" fwstyle="Dreamweaver" fwdocid = "1197029050" fwnested="0" -->
              <tr>
                <td><img src="spacer.gif" width="316" height="1" border="0" alt="" /></td>
                <td><img src="spacer.gif" width="55" height="1" border="0" alt="" /></td>
                <td><img src="spacer.gif" width="86" height="1" border="0" alt="" /></td>
                <td><img src="spacer.gif" width="98" height="1" border="0" alt="" /></td>
                <td><img src="spacer.gif" width="77" height="1" border="0" alt="" /></td>
                <td><img src="spacer.gif" width="8" height="1" border="0" alt="" /></td>
                <td><img src="spacer.gif" width="145" height="1" border="0" alt="" /></td>
                <td><img src="spacer.gif" width="1" height="1" border="0" alt="" /></td>
              </tr>
              <tr>
                <td colspan="7"><img name="test1_r1_c1" src="images_qk/<?php echo $test1_r1_c1;?>" width="785" height="110" border="0" id="test1_r1_c1" alt="" /></td>
                <td><img src="spacer.gif" width="1" height="110" border="0" alt="" /></td>
              </tr>
              <tr>
                <td rowspan="6"><img name="test1_r2_c1" src="images_qk/<?php echo $selectDept_r4_c61; ?>" width="316" height="342" border="0" id="test1_r2_c1" alt="" /></td>
                <td colspan="5">
                  <iframe src="group.php" width="324", height="191"></iframe></td>
                <td rowspan="6"><img name="test1_r2_c7" src="images_qk/<?php echo $test1_r2_c7; ?>" width="145" height="342" border="0" id="test1_r2_c7" alt="" /></td>
                <td><img src="spacer.gif" width="1" height="191" border="0" alt="" /></td>
              </tr>
              <tr>
                <td colspan="5"><img name="test1_r3_c2" src="images_qk/<?php echo $test1_r3_c2; ?>" width="324" height="14" border="0" id="test1_r3_c2" alt="" /></td>
                <td><img src="spacer.gif" width="1" height="14" border="0" alt="" /></td>
              </tr>
              <tr>
                <td rowspan="4"><img name="test1_r4_c2" src="images_qk/<?php echo $test1_r4_c2; ?>" width="55" height="137" border="0" id="test1_r4_c2" alt="" /></td>
                <td colspan="3">
                  <form action="reginfo.php" method="post" name="form1" id="form1"  style="margin:0; padding:0">
                    <input name="deptpath" style="height:17px; width:261px" type="text" id="deptpath"   maxlength="250" disabled  />                
                    </form></td>
                <td rowspan="4"><img name="test1_r4_c6" src="images_qk/<?php echo $selectDept_r4_c6; ?>" width="8" height="137" border="0" id="test1_r4_c6" alt="" /></td>
                <td><img src="spacer.gif" width="1" height="19" border="0" alt="" /></td>
              </tr>
              <tr>
                <td colspan="3"><img name="test1_r5_c3" src="images_qk/<?php echo $test1_r5_c3; ?>" width="261" height="18" border="0" id="test1_r5_c3" alt="" /></td>
                <td><img src="spacer.gif" width="1" height="18" border="0" alt="" /></td>
              </tr>
              <tr>
                <td rowspan="2"><img name="test1_r6_c3" src="images_qk/<?php echo $test1_r6_c3; ?>" width="86" height="100" border="0" id="test1_r6_c3" alt="" /></td>
                <td><img src="images_qk/<?php echo $test1_r6_c4; ?>" alt="" name="test1_r6_c4" width="98" height="29" border="0" usemap="#test1_r6_c4Map" id="test1_r6_c4" onclick="OnClickOK()" /></td>
                <td rowspan="2"><img name="test1_r6_c5" src="images_qk/<?php echo $test1_r6_c5; ?>" width="77" height="100" border="0" id="test1_r6_c5" alt="" /></td>
                <td><img src="spacer.gif" width="1" height="29" border="0" alt="" /></td>
              </tr>
              <tr>
                <td><img name="test1_r7_c4" src="images_qk/<?php echo $test1_r7_c4; ?>" width="98" height="71" border="0" id="test1_r7_c4" alt="" /></td>
                <td><img src="spacer.gif" width="1" height="71" border="0" alt="" /></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td></td>
          </tr>
      </table></td>
  </tr>
</table>
<map name="test1_r6_c4Map">
  <area shape="rect" coords="1,0,93,27" href="#">
  <area shape="rect" coords="49,13,50,17" href="#">
</map>
</body>
</html>