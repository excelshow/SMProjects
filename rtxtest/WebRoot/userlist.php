<?php 

//require_once "IPLimit.php";
$connstr = "Driver={Microsoft access Driver (*.mdb)};DBQ=../db/rtxdb.mdb";

$conn = @new COM("ADODB.Connection") or die ("ADO连接失败!");
$conn->Open($connstr);
$rs = @new COM("ADODB.RecordSet");
$sql ="select ID,UserName from Sys_user where AccountState<>1 or AccountState is null order by ID";
$rs->Open($sql,$conn,1,3);

$rs->MoveFirst();

$result = array();  

while(!$rs->EOF)
{
  $idField = $rs->Fields(0);
  $id = $idField->value;
  $nameField = $rs->Fields(1);
  $name = $nameField->value;
  array_push($result, array('id'=>$id,'name'=>$name));
	$rs->MoveNext();
}


$rs->close(); 

//print_r($result);

echo json_encode($result);



?>


