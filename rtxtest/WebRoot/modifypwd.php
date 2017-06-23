<?php 

	 include("Getlanguage.php"); 
	
	 $bRet = IsChLanguage();

	
	 if($bRet)
	 {
		 $strDeny = "您无权访问";
		 $OldPwdErr = "旧密码有误，请重新输入";
		 $strSetOK = "修改成功";
		 $strTitle = "修改管理员密码";
		 $strPwdNullErr = "旧密码有误，旧密码不能为空";
		 $strNewPwdNullErr = "新密码有误，新密码不能为空";
		 $strConfirmPwdNullErr = "重复新密码有误，重复新密码不能为空";
		 $strConfirmPwdErr = "密码确认不正确";
		 $strOldPwd = "旧密码：";
		 $strNewPwd = "新密码：";
		 $strConfirmPwd  = "重复新密码：";
		 $strSubmit = "提交";
	 }
	 else
	 {
		 $strDeny = "You are not authorized for the operation.";
		 $OldPwdErr = "Invalid old password. Please enter again. ";
		 $strSetOK = "Your password has been changed.";
		 $strTitle = "Set Administrator Password";
		 $strPwdNullErr = "Please enter the old password. ";
		 $strNewPwdNullErr = "Please enter the new password. ";
		 $strConfirmPwdNullErr = "Please confirm the new password. ";
		 $strConfirmPwdErr = "The passwords do not match. ";
		 $strOldPwd = "&nbsp;&nbsp;&nbsp;&nbsp;Old Password:";
		 $strNewPwd = "&nbsp;&nbsp;New Password:";
		 $strConfirmPwd  = "Confirm Password:";
		 $strSubmit = "Submit";	 
	 }
	 
	 
// 防止全局变量造成安全隐患 
$admin = false; 
session_start(); 
if (isset($_SESSION["admin"]) && $_SESSION["admin"] == true)
{ 
}
else
{
	$_SESSION["admin"] = false; 
	die($strDeny);
} 



	function  read_file_pwd(){
			
		$file_pwd = "";
		$fp=fopen("adminpwd.data",'r');
		while(!feof($fp))
		{
			$buffer=fgets($fp,4096);
			if( strLen($buffer) == 0 ) break;
	
			$file_pwd = $buffer;
			break;
		}
	
		fclose($fp);
			
		return $file_pwd;
	}
		
	function  wirte_file_pwd($new_pwd){
	
		$fp=fopen("adminpwd.data",'w');
		fprintf($fp,"%s",$new_pwd);

		fclose($fp);
	}


$old_pwd = $_POST["old_pwd"];
$new_pwd = $_POST["new_pwd"];

//echo "$old_pwd";
//echo "$new_pwd";

if($old_pwd != "" && $new_pwd != "")
{
	$old_pwd_md5 = md5($old_pwd); 
	$old_pwd_file = read_file_pwd();
	
	if($old_pwd_md5 != $old_pwd_file && $old_pwd_file != "")
	{
		//echo "$old_pwd_md5\n";
		//echo "$old_pwd_file";
		echo "<script language=\"JavaScript\"> alert(\"".$OldPwdErr."\"); </script>";
	}
	else
	{
		$new_pwd_md5 = md5($new_pwd);
		wirte_file_pwd($new_pwd_md5);
		echo "<script language=\"JavaScript\"> alert(\"".$strSetOK."\"); </script>";
		echo "<script language='javascript'>window.opener=null;window.close();</script>";
	
	}
}

?>

 <html>
 <head>
<script language="JavaScript">
function OnClickOK()
{

	if (form1.old_pwd.value.length == 0)
	{
		alert("<?php echo $strPwdNullErr; ?>");
		form1.old_pwd.focus();
		form1.old_pwd.select();
		return;
	}
	
	if (form1.new_pwd.value.length == 0)
	{
		alert("<?php echo $strNewPwdNullErr; ?>");
		form1.new_pwd.focus();
		form1.new_pwd.select();
		return;
	}
	
	if (new_pwd_confirm.value.length == 0)
	{
		alert("<?php echo $strConfirmPwdNullErr ; ?>");
		new_pwd_confirm.focus();
		new_pwd_confirm.select();
		return;
	}

	if (form1.new_pwd.value != new_pwd_confirm.value)
	{
		alert("<?php echo $strConfirmPwdErr; ?>");
		new_pwd_confirm.focus();
		new_pwd_confirm.select();
		return;
	}
		
		//alert(form1.old_pwd.value);
		//alert(form1.new_pwd.value);
		//alert(form1.new_pwd_confirm.value);
	
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
<title><?php echo $strTitle; ?> </title>
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
	<form name="form1" method="POST" action="modifypwd.php" style="margin:0; padding:0">
        <tr>
          <td colspan="2" class="style3">&nbsp;&nbsp;&nbsp; <?php echo $strOldPwd; ?> 
            <input type="password" name="old_pwd"></td>
        </tr>
        <tr>
          <td colspan="2"><span class="style3">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $strNewPwd; ?></span>
		    <input type="password" name="new_pwd">  
		</td>
        </tr>
		</form>  
        <tr>
          <td width="435">
            <p><span class="style3"><?php echo $strConfirmPwd; ?></span> <span class="style3">
              <input type="password" name="new_pwd_confirm">
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