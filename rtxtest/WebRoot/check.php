<?php

 include("Getlanguage.php"); 

 $bRet = IsChLanguage();
 
 if($bRet)
 {
	$strTitle = "查看审核结果";
	$strResultOK = "已审核通过,您可以在RTX客户端进行登录";
	$strResultUnOK = "尚未审核,如果有需要请与管理员联系";
	$strResultFail = "管理员拒绝您的申请,如果有需要请与管理员联系";
	$strPwdErr = "您输入的帐号或密码不正确";
	$strPwdNullErr = "密码不能为空，请重新输入";
	$strUserName = "用户名：";
	$strPwd = "&nbsp;&nbsp;&nbsp;密码：";
	$strCheck = "查询";	
 }
 else
 {
 	$strTitle = "Check the verification status";
 	$strResultOK = "Verified, you can login from RTX Client now. ";
	$strResultUnOK = "Not verified yet, please contact the administrator if necessary.";
	$strResultFail = "Rejected, please contact the administrator if necessary.";
	$strPwdErr = "The user ID or password you entered is incorrect.";
	$strNameNullErr = "Please enter the user id. ";
	$strPwdNullErr = "Please enter the password. ";
	$strUserName = "&nbsp;&nbsp;User ID:";
	$strPwd = "Password:";
	$strCheck = "query";

 }
 


$user = $_POST["user"];
$pwd = $_POST["pwd"];

if($user !="" || $pwd != "")
{
	global $strResultOK;
	
	$hasAlert = false;

//判断用户是否已经在RTX服务器
	try {

		$RootObj= new COM("RTXSAPIRootObj.RTXSAPIRootObj");

		$RootObj -> ServerIP= "127.0.0.1";
		$RootObj -> ServerPort= 8006;
		
		$result =  $RootObj -> Login($user,$pwd);
		if($result ==0)
		{
			$hasAlert = true;

			verifyresult($strResultOK);
			//exit();
		}

	
	} 
	catch (Exception $e) {

		$errstr = $e->getMessage();
		$splitstr = explode(':', $errstr, -1);
		$errstrlast = $splitstr[count($splitstr)-1];


	}

//判断是否在未审核的文件里面
	if(false == $hasAlert)
	{

		$fp=fopen("user.data",'r');
		while(!feof($fp))
		{
			$buffer=fgets($fp,4096);
			if( strLen($buffer) == 0 ) break;

			list($nick, $name, $dept, $encode_pwd) = explode ('|', $buffer,4);
			if($nick == $user && base64_decode($encode_pwd) == $pwd) 
			{
				$hasAlert = true;
				verifyresult($strResultUnOK);
				break;

			}

		}

		fclose($fp);
	}

// 判断在删除的文件里面有没有

	if(false == $hasAlert)
	{
		$fp=fopen("deleteduser.data",'r');
		while(!feof($fp))
		{
			$buffer=fgets($fp,4096);
			if( strLen($buffer) == 0 ) break;

			list($nick, $name, $dept, $encode_pwd) = explode ('|', $buffer,4);
			if($nick == $user && base64_decode($encode_pwd) == $pwd) 
			{
				$hasAlert = true;
				verifyresult($strResultFail);
				break;

			}

		}

		fclose($fp);
	}
	
	if(	$hasAlert == false )
	{
		verifyresult($strPwdErr);
	}

}

function verifyresult($result)
{

	echo "<script language=\"JavaScript\"> alert(\"$result\"); </script>";
	//echo "<script language='javascript'>window.opener=null;window.close();</script>";

}



?>

 <html>
 <head>
<script language="JavaScript">
function OnClickOK()
{

	if (form1.user.value.length == 0)
	{
		alert("<?php echo $strNameNullErr; ?>");
		form1.user.focus();
		form1.user.select();
		return;
	}
	
	if (form1.pwd.value.length == 0)
	{
		alert("<?php echo $strPwdNullErr; ?>");
		form1.pwd.focus();
		form1.pwd.select();
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
<title><?php echo $strTitle; ?></title>
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
          <td colspan="2">&nbsp;		</td>
        </tr>
		
        <tr>
          <td width="435">            <p><span class="style3">  </span> 
            <span class="style3">
			<form name="form1" method="POST" action="check.php" style="margin:0; padding:0">

&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $strUserName; ?>
<input name="user" type="text" >
		 	<p>&nbsp;&nbsp;&nbsp;<?php echo $strPwd; ?><input name="pwd" type="password" size="21">
            </p>
			</form>  
		    </span>
            </p></td>
        </tr>
        <tr>
          <td align="center"></td>
        </tr>
        <tr>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input  name="button1" type=button id=button12 value="<?php echo $strCheck; ?>" onclick="OnClickOK()">            &nbsp;&nbsp;&nbsp;
		  </td>
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