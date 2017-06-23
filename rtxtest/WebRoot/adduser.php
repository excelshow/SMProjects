<?php

include("Getlanguage.php");

$bRet = IsChLanguage();
if ($bRet) {
    $strUserExistErr = "用户已经存在,请换个用户名重新申请";
    $strNickNameErr = "用户名不合法";
    $strApplyOK = "待管理员审核通过才能登录";
} else {
    $strUserExistErr = "This ID already exists. Please try another one. ";
    $strNickNameErr = "The user ID is illegal";
    $strApplyOK = "Your application has been submitted. You can sign in when your application is approved by the administrator. ";
}


$nickname = substr($_POST["nickname"], 0, 32);

if ($nickname == "") {
    global $strNickNameErr;

    echo "<HTML>";
    echo "<HEAD>";
    echo "<TITLE>";
    echo "</TITLE>";
    echo "</HEAD>";
    echo "<BODY>";
    echo "<form method=\"POST\" action=\"reg_err.php\" id=\"form1\" name=\"form1\">";
    echo "<input type=\"text\" id=\"errstr\" name=\"errstr\" value=\"$strNickNameErr\">";
    echo "</form>";
    echo "</BODY>";
    echo "<script language=\"JavaScript\">";
    echo "form1.submit();";
    echo "</script>";
    echo "</HTML>";
}

$AppSvrIP = "192.168.0.100";
$AppSvrPort = "8006";

function InitAppSvrIpPort() {
    $file_dir = "..\WebApply.ini";
    $fp = fopen($file_dir, 'r');
    while (!feof($fp)) {
        $buffer = fgets($fp, 4096);

        list($name, $value) = split('=', $buffer);

        if ($name == "APPSvrIP" && $value != null) {
            global $AppSvrIP;
            $AppSvrIP = $value;
            continue;
        }

        if ($name == "APPSvrPort" && $value != null) {
            global $APPSvrPort;
            $APPSvrPort = $value;


            continue;
        }
    }

    fclose($fp);
}

InitAppSvrIpPort();

function IsUserExistOnFile($user) {
    $IsExist = false;
    ;

    $fp = fopen("user.data", 'r');
    while (!feof($fp)) {
        $buffer = fgets($fp, 4096);
        if (strLen($buffer) == 0)
            break;

        list($nick, $name, $dept, $pwd) = explode('|', $buffer, 4);
        if ($nick == $user) {
            $IsExist = true;
            break;
        }
    }

    fclose($fp);
    return $IsExist;
}

function AppendUserToFile($line) {

    $outFile = fopen("user.data", 'a+b');
    fwrite($outFile, $line);
    fwrite($outFile, "\r\n");

    fclose($outFile);
}

if (ord($_POST["nickname"]) > 0x7C) {
    $nickname = substr($_POST["nickname"], 0, 31);
}


$username = substr($_POST["username"], 0, 15);
if (ord($_POST["username"]) > 0x7C) {
    $username = substr($_POST["username"], 0, 14);
}


$pwd = $_POST["pwd"];
$dept = $_POST["deptpath"];

$myroot = strtolower(getcwd());
$ipos = strpos($myroot, "\\webroot");
$iroot = sprintf("%s\\usermgr.cfg", $myroot);
if ($ipos > 0) {
    $iroot = sprintf("%s\\usermgr.cfg", substr($myroot, 0, $ipos));
}
$ini_array = @parse_ini_file($iroot);


$refuse_reg_user = 1;
$allow_user_apply_account_direct = 1;
if (array_key_exists("refuse_reg_user", $ini_array)) {
    $refuse_reg_user = $ini_array["refuse_reg_user"];
    $allow_user_apply_account_direct = $ini_array["allow_user_apply_account_direct"];
}

$refuse_reg_user =0;
if ($refuse_reg_user == 0) {  //
    if ($allow_user_apply_account_direct == 0) {
        try {

            $RootObj = new COM("RTXSAPIRootObj.RTXSAPIRootObj");


            $RootObj->ServerIP = $AppSvrIP;
            $RootObj->ServerPort = $APPSvrPort;


            $UserManagerObj = $RootObj->UserManager;
            $UserManagerObj->AddUser($nickname, 0);   //添加用户

            $UserManagerObj->SetUserPwd($nickname, $pwd); //设置用户密码
            //$UserManagerObj -> SetUserBasicInfo($nickname, $username, 0, "","","", 0);
            $i = 0;
            $str = "";
            $UserManagerObj->SetUserBasicInfo($nickname, $username, $i, $str, $str, $str, $i);

            if ($dept != "") {
                $DeptManagerObj = $RootObj->DeptManager;
                $DeptManagerObj->AddUserToDept("$nickname", "", "$dept", false);
            }

            echo "<html>\r\n";

            echo "<head>\r\n";
            echo "</head>\r\n";
            echo "<title></title>\r\n";
            echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n";
            echo "<link href=\"style.css\" rel=\"stylesheet\" type=\"text/css\">\r\n";
            echo "<body>\r\n";
            echo "<form id=\"form1\" method=\"POST\" action=\"reg_ok.php\">\r\n";
            echo "<input type=\"hidden\" id=\"nickname\" name=\"nickname\" value=\"$nickname\" >\r\n";
            echo "<input type=\"hidden\" id=\"username\" name=\"username\" value=\"$username\" >\r\n";
            echo "</form>\r\n";
            echo "<script>\r\n";
            echo "form1.submit();\r\n";
            echo "</script>\r\n";
            echo "</body>\r\n";
            echo "</html>\r\n";

            return;
        } catch (Exception $e) {

            //有任何其他异常，那么返回reg_err.php
            $errstr = $e->getMessage();

            $splitstr = explode(':', $errstr, -1);
            $errstrlast = $splitstr[count($splitstr) - 1];

            $strUserExist = "用户已经存在";
            $strDeptExist = "部门不存在";
            global $bRet;
            if (!$bRet) {

                if (strstr($errstrlast, $strUserExist)) {
                    $errstrlast = "The user id has existed";
                } elseif (strstr($errstrlast, $strUserExist)) {
                    $errstrlast = "The dept was not exist";
                }
            }
            //$errstrlast = $strUserExist;

            echo "<HTML>";
            echo "<HEAD>";
            echo "<TITLE>";
            echo "</TITLE>";
            echo "</HEAD>";
            echo "<BODY>";
            echo "<form method=\"POST\" action=\"reg_err.php\" id=\"form1\" name=\"form1\">";
            echo "<input type=\"text\" id=\"errstr\" name=\"errstr\" value=\"$errstrlast\">";
            echo "<input type=\"text\" id=\"dept\" name=\"dept\" value=\"$dept\">";
            echo "</form>";
            echo "</BODY>";
            echo "<script language=\"JavaScript\">";
            echo "form1.submit();";
            echo "</script>";
            echo "</HTML>";

            return;
        }
    } else {

        //判断用户在RTX服务器是否存在
        try {

            $RootObj = new COM("RTXSAPIRootObj.RTXSAPIRootObj");

            $RootObj->ServerIP = $AppSvrIP;
            $RootObj->ServerPort = $APPSvrPort;

            $state = $RootObj->QueryUserState($nickname);   //判断用户是否存在

            global $strUserExistErr;
            $errstrlast = $strUserExistErr;
            echo "<HTML>";
            echo "<HEAD>";
            echo "<TITLE>";
            echo "</TITLE>";
            echo "</HEAD>";
            echo "<BODY>";
            echo "<form method=\"POST\" action=\"reg_err.php\" id=\"form1\" name=\"form1\">";
            echo "<input type=\"text\" id=\"errstr\" name=\"errstr\" value=\"$errstrlast\">";
            echo "<input type=\"text\" id=\"dept\" name=\"dept\" value=\"$dept\">";
            echo "</form>";
            echo "</BODY>";
            echo "<script language=\"JavaScript\">";
            echo "form1.submit();";
            echo "</script>";
            echo "</HTML>";

            return;
        } catch (Exception $e) {

            //有任何其他异常，那么返回reg_err.php
            $errstr = $e->getMessage();
            $splitstr = explode(':', $errstr, -1);
            $errstrlast = $splitstr[count($splitstr) - 1];
        }


        //判断用户是否在文件存在
        $bExist = true;
        $bExist = IsUserExistOnFile($nickname);

        if ($bExist == true) {
            global $strUserExistErr;
            $errstrlast = $strUserExistErr;

            echo "<HTML>";
            echo "<HEAD>";
            echo "<TITLE>";
            echo "</TITLE>";
            echo "</HEAD>";
            echo "<BODY>";
            echo "<form method=\"POST\" action=\"reg_err.php\" id=\"form1\" name=\"form1\">";
            echo "<input type=\"text\" id=\"errstr\" name=\"errstr\" value=\"$errstrlast\">";
            echo "</form>";
            echo "</BODY>";
            echo "<script language=\"JavaScript\">";
            echo "form1.submit();";
            echo "</script>";
            echo "</HTML>";

            return;
        } else {
            $encode_pwd = base64_encode($pwd);
            $line = $nickname . "|" . $username . "|" . $dept . "|" . $encode_pwd . "|";
            AppendUserToFile($line); //写到文件

            global $strApplyOK;

            $result = $strApplyOK;

            echo "<html>\r\n";

            echo "<head>\r\n";
            echo "</head>\r\n";
            echo "<title></title>\r\n";
            echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n";
            echo "<link href=\"style.css\" rel=\"stylesheet\" type=\"text/css\">\r\n";
            echo "<body>\r\n";
            echo "<form id=\"form1\" method=\"POST\" action=\"reg_ok.php\">\r\n";
            echo "<input type=\"hidden\" id=\"nickname\" name=\"nickname\" value=\"$nickname\" >\r\n";
            echo "<input type=\"hidden\" id=\"username\" name=\"username\" value=\"$username\" >\r\n";
            echo "<input type=\"hidden\" id=\"result\" name=\"result\" value=\"$result\" >\r\n";
            echo "</form>\r\n";
            echo "<script>\r\n";
            echo "form1.submit();\r\n";
            echo "</script>\r\n";
            echo "</body>\r\n";
            echo "</html>\r\n";

            return;
        }
    }
} else {
    header("Location: refuse.php");
}

function PrintFileContent($filename) {
    $handle = fopen($filename, "rb");
    $contents = fread($handle, filesize($filename));
    echo $contents;
    fclose($handle);
}
?>





