<?PHP

require_once "IPLimit.php";


$pwd = "";

$sender = $_GET["sender"];
$pwd = $_GET["pwd"];
$receivers = $_GET["receivers"];
$msg = $_GET["msg"];
$sessionid = $_GET["sessionid"];


if ((strlen($sender) == 0) 
	&& (strlen($pwd) == 0) 
	&& (strlen($receiver) == 0) 
	&& (strlen($msg) == 0) 
	&& (strlen($sessionid) == 0))
{
	$sender = $_POST["sender"];
	$pwd = $_POST["pwd"];
	$receivers = $_POST["receivers"];
	$msg = $_POST["msg"];
	$sessionid = $_POST["sessionid"];

}


try
{

	$RootObj= new COM("RTXSAPIRootObj.RTXSAPIRootObj");
	$RootObj->SendIM($sender, $pwd, $receivers,$msg, $sessionid);

	echo "<script language=\"JavaScript\">\r\n";
	echo "alert(\"操作成功\")";
	echo "</script>\r\n";

}

catch (Exception $e) {

		//有任何其他异常，那么返回reg_err.php
		$errstr = $e->getMessage();
		$splitstr = explode(':', $errstr, -1);
		$errstrlast = $splitstr[count($splitstr)-1];

		echo $errstrlast;
	
		return;
	}

?>