<?PHP

$user = $_GET["user"];
$sign = $_GET["sign"];

try
{

	$RootObj= new COM("RTXSAPIRootObj.RTXSAPIRootObj");
	$UserAuth = $RootObj->UserAuthObj;
	
	$bisSuccess = $UserAuth->SignatureAuth($user, $sign); //��֤ǩ��
	
	if($bisSuccess)
	{
		echo "success!";
	}
	else
	{
		echo "failed!";
	}

}
catch (Exception $e) {

		//���κ������쳣����ô����reg_err.php
		$errstr = $e->getMessage();
		$splitstr = explode(':', $errstr, -1);
		$errstrlast = $splitstr[count($splitstr)-1];

		echo $errstrlast;
	
		return;
	}


?>