<?php
$g_rtxpath		 = "C:\\rtx_http\\htdocs\\";
$g_ImgMobile	 = "images/mb_01.gif";
$g_HtmSendSms	 = "PreSendSms.php?Receiver=";


$g_UserListHead  = "UserListHead.txt";
$g_UserListFoot  = "UserListFoot.txt";
$g_PageParamName = "Page";


$g_FindUserSQLFormat  = 'SELECT UserInfo.RTXNO, UserInfo.Nick, UserInfo.Name, UserInfo.Mobile, UserInfo.Email, UserInfo.Gender, UserInfo.Department FROM UserInfo WHERE (   ( (UserInfo.Nick) Like  \'%s\') OR (UserInfo.RTXNO Like \'%s\') OR (UserInfo.Name Like \'%s\') OR (UserInfo.Mobile like \'%s\')) AND ((UserInfo.Type)=0) ';
$g_FindUserHeader = 'SELECT UserInfo.RTXNO, UserInfo.Nick, UserInfo.Name, UserInfo.Mobile, UserInfo.Email, UserInfo.Gender, UserInfo.Department, UserInfo.Job  FROM UserInfo WHERE ((UserInfo.Type)=0)  AND ';
$g_FindUserWhere = '(( (UserInfo.Nick) Like  \'%s\') OR (UserInfo.RTXNO Like \'%s\') OR (UserInfo.Name Like \'%s\') OR (UserInfo.Mobile like \'%s\') )';
$g_FindUserOrder = ' Order by Department, Nick';

$g_ViewUserList =  'SELECT RTXNO, Nick, Name, Mobile, Email, Gender, Department FROM UserInfo WHERE Type =  0 Order by Department';

$g_ViewUserListEmpty =  'SELECT RTXNO, Nick, Name, Mobile, Email, Gender, Department FROM UserInfo WHERE Type =  134 Order by Department';


//$g_ODBCConnString   =  'Driver={Microsoft Access Driver (*.mdb)};DBQ=Address.mdb';
$g_ODBCConnString   =  'Driver={SQL Server};Server=192.168.0.100;Database=rtxdb';
$g_ODBCUserName     =  'sa';
$g_ODBCUserPassword =  'P@ssw0rd';

$g_PageNum		 = 15;
?>
