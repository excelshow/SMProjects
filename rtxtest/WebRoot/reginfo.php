<?php
 include("Getlanguage.php"); 

 $bRet = IsChLanguage();

 
 if($bRet)
 {
	$Write_info_top = "Write_info_top.jpg";
	$Write_info_left = "Write_info_left.jpg";
	$Write_info_mid4 = "Write_info_mid4.jpg";
	$Write_info_mid4 = "Write_info_mid4.jpg";
	$Write_info_OK = "Write_info_OK.jpg";
	$Write_info_Clr = "Write_info_Clr.jpg";
	$Write_info_right = "Write_info_right.jpg";
	$Write_info_bottom = "Write_info_bottom.jpg";
	
	$strClientDeploy = "客户端部署";
	$strAccountErr = "帐号有误。帐号不能为空";
	$strNameErr = "用户姓名不能为空";
	$strPwdErr = "密码不能为空";
	$strConfirmPwdErr = "密码确认不正确";
	$strAccountCharErr = "帐号不能包含下列任何字符之一:";
	$strNameCharErr = "姓名不能包含下列任何字符之一：";
		
 }
 else
 {
 	$Write_info_top = "Write_info_top_EN.jpg";
	$Write_info_left = "Write_info_left_EN.jpg";
	$Write_info_mid4 = "Write_info_mid4.jpg";
	$Write_info_mid4 = "Write_info_mid4.jpg";
	$Write_info_OK = "Write_info_OK_EN.jpg";
	$Write_info_Clr = "Write_info_Clr_EN.jpg";
	$Write_info_right = "Write_info_right.jpg";
	$Write_info_bottom = "Write_info_bottom.jpg";
	
 	$strClientDeploy = "Client Deployment";
	$strAccountErr = "Please enter the ID.";
	$strNameErr = "Please enter your name.";
	$strPwdErr = "Please enter the password.";
	$strConfirmPwdErr = "The passwords do not match. ";
	$strAccountCharErr = "The ID can not contain any of the following characters:";
	$strNameCharErr = "The name can not contain any of the following characters:";
	

 }

?>

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title><?php echo $strClientDeploy; ?></title>

<style type="text/css">
td img {display: block;}
</style>
<style>
form {
padding:0; margin:0;
}
</style>


<!-- 脚本函数 -->
<script language="JavaScript">
function OnClickOK()
{

	if (form1.nickname.value.length == 0)
	{
		alert("<?php echo  $strAccountErr; ?>");
		
		form1.nickname.focus();
		form1.nickname.select();
		return;
	}
	
	if (form1.username.value.length == 0)
	{
		alert("<?php echo $strNameErr; ?>");
		form1.username.focus();
		form1.username.select();
		return;
	}

	if (form1.pwd.value.length == 0)
	{
		alert("<?php echo $strPwdErr; ?>");
		form1.pwd.focus();
		form1.pwd.select();		
		return;
	}

	if (form1.pwd.value != form1.pwd_confirm.value)
	{
		alert("<?php echo $strConfirmPwdErr; ?>");
		form1.pwd_confirm.focus();
		form1.pwd_confirm.select();
		return;
	}
	
	var index = form1.nickname.value.indexOf('(');
    if (index >= 0)
  	{
  		alert("<?php echo $strAccountCharErr; ?> \n( ) [ ] { } \\ / \' \" ； ; % : * < > | ? &");
		form1.nickname.focus();
		form1.nickname.select();
		return;	
  	}
	
	var index = form1.nickname.value.indexOf(')');
    if (index >= 0)
  	{
  		alert("<?php echo $strAccountCharErr; ?>\n( ) [ ] { } \\ / \' \" ； ; % : * < > | ? &");
		form1.nickname.focus();
		form1.nickname.select();
		return;	
  	}
	var index = form1.nickname.value.indexOf('[');
    if (index >= 0)
  	{
  		alert("<?php echo $strAccountCharErr; ?>\n( ) [ ] { } \\ / \' \" ； ; % : * < > | ? &");
		form1.nickname.focus();
		form1.nickname.select();
		return;	
  	}

	
	var index = form1.nickname.value.indexOf(']');
    if (index >= 0)
  	{
  		alert("<?php echo $strAccountCharErr; ?>\n( ) [ ] { } \\ / \' \" ； ; % : * < > | ? &");
		form1.nickname.focus();
		form1.nickname.select();		
		return;	
  	}
	var index = form1.nickname.value.indexOf('{');
    if (index >= 0)
  	{
  		alert("<?php echo $strAccountCharErr; ?>\n( ) [ ] { } \\ / \' \" ； ; % : * < > | ? &");
		form1.nickname.focus();
		form1.nickname.select();		
		return;	
  	}
	var index = form1.nickname.value.indexOf('}');
    if (index >= 0)
  	{
  		alert("<?php echo $strAccountCharErr; ?>\n( ) [ ] { } \\ / \' \" ； ; % : * < > | ? &");
		form1.nickname.focus();
		form1.nickname.select();		
		return;	
  	}
	var index = form1.nickname.value.indexOf('\\');
    if (index >= 0)
  	{
  		alert("<?php echo $strAccountCharErr; ?>\n( ) [ ] { } \\ / \' \" ； ; % : * < > | ? &");
		form1.nickname.focus();
		form1.nickname.select();		
		return;	
  	}
	var index = form1.nickname.value.indexOf('/');
    if (index >= 0)
  	{
  		alert("<?php echo $strAccountCharErr; ?>\n( ) [ ] { } \\ / \' \" ； ; % : * < > | ? &");
		form1.nickname.focus();
		form1.nickname.select();		
		return;	
  	}
  	var index = form1.nickname.value.indexOf('\'');
    if (index >= 0)
  	{
  		alert("<?php echo $strAccountCharErr; ?>\n( ) [ ] { } \\ / \' \" ； ; % : * < > | ? &");
		form1.nickname.focus();
		form1.nickname.select();		
		return;	
  	}
	var index = form1.nickname.value.indexOf('"');
    if (index >= 0)
  	{
  		alert("<?php echo $strAccountCharErr; ?>\n( ) [ ] { } \\ / \' \" ； ; % : * < > | ? &");
		form1.nickname.focus();
		form1.nickname.select();		
		return;	
  	}
	var index = form1.nickname.value.indexOf('；');
    if (index >= 0)
  	{
  		alert("<?php echo $strAccountCharErr; ?>\n( ) [ ] { } \\ / \' \" ； ; % : * < > | ? &");
		form1.nickname.focus();
		form1.nickname.select();		
		return;	
  	}
	var index = form1.nickname.value.indexOf(';');
    if (index >= 0)
  	{
  		alert("<?php echo $strAccountCharErr; ?>\n( ) [ ] { } \\ / \' \" ； ; % : * < > | ? &");
		form1.nickname.focus();
		form1.nickname.select();		
		return;	
  	}
	var index = form1.nickname.value.indexOf('%');
    if (index >= 0)
  	{
  		alert("<?php echo $strAccountCharErr; ?>\n( ) [ ] { } \\ / \' \" ； ; % : * < > | ? &");
		form1.nickname.focus();
		form1.nickname.select();		
		return;	
  	}
	var index = form1.nickname.value.indexOf(':');
    if (index >= 0)
  	{
  		alert("<?php echo $strAccountCharErr; ?>\n( ) [ ] { } \\ / \' \" ； ; % : * < > | ? &");
		form1.nickname.focus();
		form1.nickname.select();		
		return;	
  	}
	var index = form1.nickname.value.indexOf('*');
    if (index >= 0)
  	{
  		alert("<?php echo $strAccountCharErr; ?>\n( ) [ ] { } \\ / \' \" ； ; % : * < > | ? &");
		form1.nickname.focus();
		form1.nickname.select();		
		return;	
  	}
	var index = form1.nickname.value.indexOf('<');
    if (index >= 0)
  	{
  		alert("<?php echo $strAccountCharErr; ?>\n( ) [ ] { } \\ / \' \" ； ; % : * < > | ? &");
		form1.nickname.focus();
		form1.nickname.select();		
		return;	
  	}
	var index = form1.nickname.value.indexOf('>');
    if (index >= 0)
  	{
  		alert("<?php echo $strAccountCharErr; ?>\n( ) [ ] { } \\ / \' \" ； ; % : * < > | ? &");
		form1.nickname.focus();
		form1.nickname.select();		
		return;	
  	}
	var index = form1.nickname.value.indexOf('|');
    if (index >= 0)
  	{
  		alert("<?php echo $strAccountCharErr; ?>\n( ) [ ] { } \\ / \' \" ； ; % : * < > | ? &");
		form1.nickname.focus();
		form1.nickname.select();		
		return;	
  	}
	var index = form1.nickname.value.indexOf('?');
    if (index >= 0)
  	{
  		alert("<?php echo $strAccountCharErr; ?>\n( ) [ ] { } \\ / \' \" ； ; % : * < > | ? &");
		form1.nickname.focus();
		form1.nickname.select();		
		return;	
  	}
	var index = form1.nickname.value.indexOf('&');
    if (index >= 0)
  	{
  		alert("<?php echo $strAccountCharErr; ?>\n( ) [ ] { } \\ / \' \" ； ; % : * < > | ? &");
		form1.nickname.focus();
		form1.nickname.select();
		return;	
		
  	}
	
	
	// 真实姓名过滤
  	index = form1.username.value.indexOf('(');
    if (index >= 0)
  	{
  		alert(" <?php echo  $strNameCharErr; ?>\n( ) [ ] { } \\ / \' \" ； ; % &");
		form1.username.focus();
		form1.username.select();		
		return;	
  	}
  	index = form1.username.value.indexOf(')');
    if (index >= 0)
  	{
  		alert("<?php echo  $strNameCharErr; ?>\n( ) [ ] { } \\ / \' \" ； ; % &");
		form1.username.focus();
		form1.username.select();		
		return;	
  	}
  	index = form1.username.value.indexOf('[');
    if (index >= 0)
  	{
  		alert("<?php echo  $strNameCharErr; ?>\n( ) [ ] { } \\ / \' \" ； ; % &");
		form1.username.focus();
		form1.username.select();				
		return;	
  	}
  	index = form1.username.value.indexOf(']');
    if (index >= 0)
  	{
  		alert("<?php echo  $strNameCharErr; ?>\n( ) [ ] { } \\ / \' \" ； ; % &");
		form1.username.focus();
		form1.username.select();				
		return;	
  	}
  	index = form1.username.value.indexOf('{');
    if (index >= 0)
  	{
  		alert("<?php echo  $strNameCharErr; ?>\n( ) [ ] { } \\ / \' \" ； ; % &");
		form1.username.focus();
		form1.username.select();				
		return;	
  	}
  	index = form1.username.value.indexOf('}');
    if (index >= 0)
  	{
  		alert("<?php echo  $strNameCharErr; ?>\n( ) [ ] { } \\ / \' \" ； ; % &");
		form1.username.focus();
		form1.username.select();				
		return;	
  	}
  	index = form1.username.value.indexOf('\\');
    if (index >= 0)
  	{
  		alert("<?php echo  $strNameCharErr; ?>\n( ) [ ] { } \\ / \' \" ； ; % &");
		form1.username.focus();
		form1.username.select();				
		return;	
  	}
  	index = form1.username.value.indexOf('/');
    if (index >= 0)
  	{
  		alert("<?php echo  $strNameCharErr; ?>\n( ) [ ] { } \\ / \' \" ； ; % &");
		form1.username.focus();
		form1.username.select();				
		return;	
  	}
  	index = form1.username.value.indexOf('\'');
    if (index >= 0)
  	{
  		alert("<?php echo  $strNameCharErr; ?>\n( ) [ ] { } \\ / \' \" ； ; % &");
		form1.username.focus();
		form1.username.select();				
		return;	
  	}
  	index = form1.username.value.indexOf('\"');
    if (index >= 0)
  	{
  		alert("<?php echo  $strNameCharErr; ?>\n( ) [ ] { } \\ / \' \" ； ; % &");
		form1.username.focus();
		form1.username.select();				
		return;	
  	}
  	index = form1.username.value.indexOf('；');
    if (index >= 0)
  	{
  		alert("<?php echo  $strNameCharErr; ?>\n( ) [ ] { } \\ / \' \" ； ; % &");
		form1.username.focus();
		form1.username.select();		
		return;	
		
  	}
  	index = form1.username.value.indexOf(';');
    if (index >= 0)
  	{
  		alert("<?php echo  $strNameCharErr; ?>\n( ) [ ] { } \\ / \' \" ； ; % &");
		form1.username.focus();
		form1.username.select();				
		return;	
  	}
  	index = form1.username.value.indexOf('%');
    if (index >= 0)
  	{
  		alert("<?php echo  $strNameCharErr; ?>\n( ) [ ] { } \\ / \' \" ； ; % &");
		form1.username.focus();
		form1.username.select();				
		return;	
  	}
	
	index = form1.username.value.indexOf('&');
    if (index >= 0)
  	{
  		alert("<?php echo  $strNameCharErr; ?>\n( ) [ ] { } \\ / \' \" ； ; % &");
		form1.username.focus();
		form1.username.select();				
		return;	
  	}
	
	form1.submit();
		
}//end func

function OnClickClr()
{
	form1.username.value = "";
	form1.nickname.value = "";
	form1.pwd.value = "";
	form1.pwd_confirm.value = "";
}

</script>

</head>

<body background="images_qk/bg_001.jpg" onload="form1.nickname.focus()">
		<table width="419" border="0" align="center" cellpadding="2" cellspacing="2" style="WIDTH: 419px; HEIGHT: 492px">
			<tr>
			  <td width="60%" align="center" valign="top"><table width="570" border="0" align="center" cellpadding="0" cellspacing="0" background="images_qk/top_conerbg.gif">
					<tr>
					  <td> <br>
					    <table border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td colspan="3"><img src="images_qk/<?php echo $Write_info_top; ?>" width="790" height="165"></td>
                          </tr>
                          <tr>
                            <td width="435" rowspan="2"><img src="images_qk/<?php echo $Write_info_left; ?>" width="435" height="291"></td>
                            <td width="354"><form name="form1" method="POST" action="adduser.php" style="margin:0; padding:0">
                              <table border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td colspan="2"><table border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td><input type="text" maxlength="31" name="nickname" style="HEIGHT: 20px; width:205px"  ></td>
                                    </tr>
                                    <tr>
                                      <td></td>
                                    </tr>
                                    <tr>
                                      <td><img src="images_qk/<?php echo $Write_info_mid4; ?>" width="205" height="8"></td>
                                    </tr>
                                    <tr>
                                      <td><input type="text" maxlength="15" name="username" style="HEIGHT: 20px; width:205px"  ></td>
                                    </tr>
                                    <tr>
                                      <td><img src="images_qk/<?php echo $Write_info_mid4; ?>" width="205" height="8"></td>
                                    </tr>
                                    <tr>
                                      <td><input type="password" maxlength="15" name="pwd" style="HEIGHT: 20px; width:205px"  ></td>
                                    </tr>
                                    <tr>
                                      <td><img src="images_qk/<?php echo $Write_info_mid4; ?>" width="205" height="9"></td>
                                    </tr>
                                    <tr>
                                      <td><input type="password" maxlength="15" name="pwd_confirm" style="HEIGHT: 20px; width:205px" ></td>
                                    </tr>

                                     <input name="deptpath" type="hidden" value="<?php echo $_POST["deptpath"]; ?>" />

                                  </table></td>
                                </tr>
                                <tr>
                                  <td><img src="images_qk/<?php echo $Write_info_OK; ?>" width="101" height="45" border="0" usemap="#Map" onclick="OnClickOK()"></td>
                                  <td><img src="images_qk/<?php echo $Write_info_Clr; ?>" width="104" height="45" border="0" usemap="#Map2" onclick="OnClickClr()"></td>
                                </tr>
                              </table>
                            </form></td>
                            <td width="150"><img src="images_qk/<?php echo $Write_info_right; ?>" width="150" height="159"></td>
                          </tr>
                          <tr>
                            <td colspan="2"><img src="images_qk/<?php echo $Write_info_bottom; ?>" width="355" height="132"></td>
                          </tr>
                        </table></td>
					</tr>
		</table>
					<table width="570" border="0" align="center" cellpadding="0" cellspacing="0">
						<tr>

						</tr>
					</table>

            <map name="Map">
              <area shape="rect" coords="1,1,103,41" href="#">
            </map>
            <map name="Map2">
              <area shape="rect" coords="1,1,100,43" href="#">
</map>
</body>



</html>