<?php


	 include("Getlanguage.php"); 
	
	  $bRet = IsChLanguage();
	 if($bRet)
	 {

		 $strAccessErr = "您无权访问";
		 $strWebTitle = "网页申请帐号管理";
		 $strTitle = "&nbsp; &nbsp;  &nbsp;网页申请帐号管理";
		 $strMemo = "帐号信息: ";
		 $strSelAll = "全 选";
		 $strUndoSel = "取消全选";
		 $strOK = "审核通过";
		 $strFail = "拒绝并删除";
		 $strResult = "操作结果:";
		 $strSetPwd = "设置管理员密码";	
		 
		 $strPwdErr = "密码错误，请重新输入";

	 }
	 else
	 {
		 $strAccessErr = "Access is denied. ";
		 $strWebTitle = "ID Application Management";
		 $strTitle = "ID Application Management";
		 $strMemo = "ID Information: ";
		 $strSelAll = "Select All";
		 $strUndoSel = "Deselect All";
		 $strOK = "Approve";
		 $strFail = "Deny and Delete";
		 $strResult = "Operation Result:";
		 $strSetPwd = "Set Administrator Password";	 
		 
		 $strPwdErr = "Password incorrect,please enter again.  ";	 

	 }
	 
	 
	$pwd = $_POST["pwd"];
	$pwd_md5 = md5($pwd);
	
	$file_pwd_md5 = "";
	$fp=fopen("adminpwd.data",'r');
	while(!feof($fp))
	{
		$buffer=fgets($fp,4096);
		if( strLen($buffer) == 0 ) break;

		$file_pwd_md5 = $buffer;
		break;
	}

	fclose($fp);
	
	if($pwd_md5 == $file_pwd_md5 )
	{

		$lifeTime = 60 * 5; //24 * 3600; 
		session_set_cookie_params($lifeTime); 

		session_start(); 
		$_SESSION["admin"] = true; 
		
	}
	else
	{
		echo "<script>alert(\"".$strPwdErr."\");</script>"; 
		echo "<script>window.location =\"admin.php\";</script>";
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
	die($strAccessErr);
}

?>

<script language="JavaScript">
	function OnClickPassedVerify()
	{
        eval("window.g = new Object();window.g = \"\";")
		window.g = "1|"
		for(var i = 1; i <= document.frames(0).myList.ListItems.Count; i++)
		{
			if(document.frames(0).myList.ListItems(i).Checked)
			{
				window.g = window.g + i + "|";

			}
		}

		document.frames(0).form1.str_array.value = window.g
		document.frames(0).form1.submit();
	}

	function OnClickDenyAndDelete()
	{
        eval("window.g = new Object();window.g = \"\";")
		window.g = "0|"
		for(var i = 1; i <= document.frames(0).myList.ListItems.Count; i++)
		{
			if(document.frames(0).myList.ListItems(i).Checked)
			{
				window.g = window.g + i + "|";
				
			}
		}
		
		document.frames(0).form1.str_array.value = window.g
		document.frames(0).form1.submit();
	}

	function OnClickSelAll()
	{
			for(var i = 1; i <= document.frames(0).myList.ListItems.Count; i++)
			{
				document.frames(0).myList.ListItems(i).Checked = true
			}
	}
	
	function OnClickUnSelAll()
	{
			for(var i = 1; i <= document.frames(0).myList.ListItems.Count; i++)
			{
				document.frames(0).myList.ListItems(i).Checked = false
			}
	}

</script>


 <style type="text/css">
<!--
.style3 {font-size: 12px}
.style4 {font-size: x-large}
-->
 </style>
 <title><?php echo $strWebTitle ; ?></title>
 <body background="images_qk/bg_001.jpg">
 <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" background="images_qk/top_conerbg.gif">
   <tr>
     <td colspan="3"><span class="style4">      </span><span class="style4">&nbsp; &nbsp;<?php echo $strTitle; ?> </span><br>       </td>
   </tr>
   <tr>
     <td colspan="3" align="center"><span class="style4">     </span></td>
   </tr>
   <tr>
     <td align="center"><table border="0" cellspacing="0" cellpadding="0">
       <tr>
         <td colspan="2" class="style3"><?php echo $strMemo; ?></td>
       </tr>
       <tr>
         <td colspan="2"><iframe  src="if.php"  width="500" height="300" ></iframe></td>
       </tr>
       <tr>
         <td width="435">
           <p>&nbsp; </p></td>
       </tr>
       <tr>
         <td align="center"><input  name="button12" type=button id=button122 style="width:90" onclick="OnClickSelAll()" value="<?php echo $strSelAll; ?>" >
             <input  name="button1" type=button id=button1 style="width:90" onclick="OnClickUnSelAll()" value="<?php echo $strUndoSel; ?>" >
             <input name="button2" type=button id=button2 onclick="OnClickPassedVerify()" value="<?php echo $strOK; ?>">
             <input name="button3" type=button id=button3  onclick="OnClickDenyAndDelete()" value="<?php echo $strFail; ?>"></td>
       </tr>
       <tr>
         <td align="center"></td>
       </tr>
       <tr>
         <td align="center"></td>
       </tr>
       <tr>
         <td align="center"></td>
       </tr>
       <tr>
         <td align="left" class="style3"><?php echo $strResult; ?></td>
       </tr>
       <tr>
         <td align="left"><textarea name="textfield2" id="textfield2" style="width:500" ></textarea></td>
       </tr>
     </table></td>
     <td align="left"><p class="style3"></p></td>
     <td align="left" valign="top"><p class="style3"><br>
       <br>
       <a href="modifypwd.php" target="_blank"><?php echo $strSetPwd; ?></a><br>
       <br>
     </p>
     </td>
   </tr>
   <tr>
     <td colspan="3"></td>
   </tr>
   <tr>
     <td></td>
     <td colspan="2"><span class="style3">
      </span></td>
   </tr>
 </table>
<p></p>
</body>