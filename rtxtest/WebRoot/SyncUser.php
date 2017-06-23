<?php 

require_once "IPLimit.php";

$User = $_GET["UserName"];
//print $User;
//print "\n ";
//$conn = new COM("ADODB.Connection");
//$conn->Open("Provider=Microsoft.Jet.OLEDB.4.0;Data Source=Address.MDB;Persist Security Info=False");
$conn = odbc_pconnect( 'Driver={Microsoft Access Driver (*.mdb)};DBQ=Address.mdb' , '' , '');
if( ! $conn ) {
    Error_handler( "在 odbc_connect 有错误发生" , $cnx );
 }

$objAPI = new COM("Rtxserver.rtxobj");
$objProp = new COM("Rtxserver.collection");
$Name = "DEPTMANAGER";
$objAPI->Name = $Name;
$PDeptID = 0;

$UserCount = GetDeptList($conn, $objAPI, $objProp, $PDeptID, $UserCount);
echo "操作成功,总共同步了 $UserCount 个人员\n";



function Error_Handler( $msg, $cnx )
{
    //echo "$msg \n";
    odbc_close( $cnx);
    exit();
}

function GetDeptList($conn, $objAPI, $objProp, $PDeptID)
{
	$cmd = 0x0104;
	$nullstr = "";
	$errstr = "";
	$objProp->Add("PDEPTID", $PDeptID);
	$objProp->Add("SUBDEPTUSERS" ,1);
	$aryDept = @$objAPI->Call2($cmd, $objProp);
	$errstr = $php_errormsg;
	if(strcmp($nullstr, $errstr) != 0)
	{
		//print $errstr;
		return 0;
	}
	$count = $aryDept->Count();
	$DeptCount = $DeptCount + $count;
	$step = 0;
	//print $count;
	//print "-----\n";
	$UserCount = 0;
	while($step < $count)
	{
		$i = intVal($step);
		$deptid = $aryDept->Item($i);
		//print $deptid;
		$objProp->Add("DEPTID", $deptid);
		$cmd = 0x107;
		$dept = $objAPI->Call2($cmd, $objProp);
		$UserCount = $UserCount + GetDeptUser($conn, $objAPI, $objProp, $deptid);
	 	$step = $step + 1; 
	}
	return $UserCount;
}

function GetDeptUser($conn, $objAPI, $objProp, $DeptID)
{
	$objProp->Add("DEPTID", $DeptID);
	$cmd = 0x105;
    $aryUser = $objAPI->Call2($cmd, $objProp);
    $step = 0;
	//print $aryUser->Count();
	$UserCount = $aryUser->Count();
    while($step < $aryUser->Count())
	{
		$i = intVal($step);
		$userid  = $aryUser->Item($i);
        GetUserInfo($conn, $objAPI, $objProp, $userid);
		$step = $step + 1;
    } 
	return $UserCount;
}
function GetUserInfo($conn, $objAPI, $objProp, $UserID)
{
	//通过用户ID，获取拥护资料
    $objProp->Add("UIN", $UserID);
	$cmd = 0x4;
	$User = $objAPI->Call2($cmd, $objProp);
	SetUserToDB($conn, $User);
}

function SetUserToDB($conn, $User)
{
    $Name = $User->Item("NAME");
	$Nick = $User->Item("Nick");
	$Gender = $User->Item("Gender");
	$Company = "";//$User->Item("Company");
	$Department = $User->Item("DEPTNAME");
	$Job = $User->Item("POSITION");
	$Mobile = $User->Item("Mobile"); 
	$Email = $User->Item("Email");
	$Address = $User->Item("Address");
	$RTXNO = $User->Item("UIN");
	$Type = "0"; //$User->Item("Type");

	$sql = sprintf('insert into UserInfo(Name, Nick, Gender, Company, Department, Job, Mobile, Email, Address, RTXNO, Type) values(\'%s\', \'%s\', \'%s\', \'%s\', \'%s\', \'%s\', \'%s\', \'%s\', \'%s\', \'%s\', \'%s\')', 
		$Name, $Nick, $Gender, $Company, $Department, $Job, $Mobile, $Email, $Address, $RTXNO, $Type);
//	print $sql;
//	print "\n";
	$errstr = "";
	@odbc_exec( $conn, $sql );
	$errstr = $php_errormsg;
	if(strcmp($nullstr, $errstr) != 0)
	{
	//	print $errstr;
		return 0;
	}
}



function ReadUserFromDBADO($conn)
{
	$record = $conn->Execute("Select* from UserInfo");
	$record->MoveFirst();
	$fields = $record->Fields;
	print "UserCount:";
	print "\n ";
	while(!$record->EOF)
	{
		$field = $fields->Item("Name");
		print "Name:";
		print $field->Value;
		print ",";
		$record->MoveNext();
	}
}


?>


