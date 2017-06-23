<?php
require_once "IPLimit.php";

$Receiver = $_GET["Receiver"];
?>


<html>
<head>
<title>地址本演示-短信发送</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<style type="text/css">
<!--
td {
	font-size: 12px;
}
-->
</style>
</head>


<script id="clientEventHandlersVBS" language="vbscript">
<!--

Sub SendSMS_onclick
 form1.submit()
End Sub

</script>

<body background="images/bg_01.gif" leftmargin="0" topmargin="0">
<form id="form1" action="SendSMS.php"  method="post">

<br>
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" background="images/coner_bg.gif">
  <tr> 
    <td width="65"><img src="images/coner_01.gif" width="65" height="20"></td>
    <td width="702">&nbsp;</td>
    <td width="13" align="right"><img src="images/coner_02.gif" width="15" height="20"></td>
  </tr>
</table>
<table width="500" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="F2F2F2">
 <tr>
    <td><table width="100%" border="0" cellpadding="1" cellspacing="0" bgcolor="#FFFFFF">
        <tr>
          <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="8" cellspacing="1">
				<tr> 
                <td width="32%" height="30" align="center" bgcolor="F2F2F2">短信接收者：</td>
                <td width="68%" align="center" bgcolor="F2F2F2">
                <input id="txtReceiver" name="txtReceiver" type="text" size="25" value = <?= $Receiver?>></td>
              </tr>
              <tr> 
                <td height="30" align="center" bgcolor="F2F2F2">发送短信的内容：</td>
                <td height="30" align="center" bgcolor="F2F2F2">
                <textarea id="txtSms" name="txtSms" cols="23" rows="5"></textarea></td>
              </tr>
              </form>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
</form>
<br>
<table width="500" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr> 
    <td align="center"><table width="160" border="0" cellspacing="0" cellpadding="1">
        <tr align="center"> 
          <td><img src="images/send.gif" width="150" height="21" style="CURSOR: hand" id="SendSMS" ></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
