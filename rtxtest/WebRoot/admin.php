
<?php
//session_start(); 
//$_SESSION["admin"] = null;

 include("Getlanguage.php"); 

 $bRet = IsChLanguage();
 if($bRet)
 {

	$strAdmin = "&nbsp;&nbsp;&nbsp;管理员：";
	$strPwd = "密码：";
	$strSubmit = "提交";
	$strPwdErr = "密码不能为空，请重新输入";
 }
 else
 {
	$strAdmin = "Administrator:";
	$strPwd = "&nbsp;&nbsp;Password:";
	$strSubmit = "Submit";
	$strPwdErr = "Please enter the password.";
  }
 
?>

 <html>
 <head>
<script language="JavaScript">
function OnClickOK()
{

	if (form1.pwd.value.length == 0)
	{
		alert("<?php echo $strPwdErr; ?>");
		form1.old_pwd.focus();
		form1.old_pwd.select();
		return;
	}
	
	form1.submit();
}
</script>
 <style type="text/css">
<!--
.style3 {font-size: 12px}
.style4 {font-size: x-large}
-->
 </style>
</head>
<body background="images_qk/bg_001.jpg">
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0" background="images_qk/top_conerbg.gif">
  <tr>
    <td colspan="3"><span class="style4"> </span><span class="style4"> &nbsp; </span>    </td>
  </tr>
  <tr>
    <td colspan="3" align="center"><span class="style4"> </span></td>
  </tr>
  <tr>
    <td align="center"><table border="0" cellspacing="0" cellpadding="0">
	
        <tr>
          <td colspan="2" class="style3"></td>
        </tr>
        <tr>
          <td colspan="2"><span class="style3">&nbsp;<?php echo $strAdmin;?></span>
            <span class="style3">
            <input name="new_pwd" type="text" value="admin" disabled = "true">
          </span>		</td>
        </tr>
		
        <tr>
          <td width="435">            <p><span class="style3">  </span> 
            <span class="style3">
			<form name="form1" method="POST" action="webadmin.php" style="margin:0; padding:0">
		 	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $strPwd; ?> <input name="pwd" type="password" size="22">
          </form>  
		  </span></p></td>
        </tr>
        <tr>
          <td align="center"></td>
        </tr>
        <tr>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  <input  name="button1" type=button id=button1 value="<?php echo $strSubmit; ?>" onclick="OnClickOK()"></td>
        </tr>
        <tr>
          <td align="center"></td>
        </tr>
        <tr>
          <td align="center"></td>
        </tr>
        <tr>
          <td align="left" class="style3"></td>
        </tr>
        <tr>
          <td align="left"></td>
        </tr>
    </table></td>
    <td align="left"><p class="style3">&nbsp; </p></td>
    <td align="left" valign="top"><p class="style3"><br>
        <br>
      </p>
    </td>
  </tr>
  <tr>
    <td colspan="3"></td>
  </tr>
  <tr>
    <td></td>
    <td colspan="2"><span class="style3"> </span></td>
  </tr>
</table>
 
</body>
</html>