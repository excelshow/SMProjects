<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<?php

 $myroot = strtolower(getcwd());
 $ipos = strpos($myroot,"\\webroot");
 $iroot = sprintf("%s\\usermgr.cfg", $myroot);
 if($ipos > 0)
 {
   $iroot =  sprintf("%s\\usermgr.cfg", substr($myroot, 0, $ipos));
 }
 $ini_array = @parse_ini_file($iroot);
 //print_r($ini_array);
 $refuse_reg_user= 0;
 if(array_key_exists("refuse_reg_user", $ini_array))
 {
   $refuse_reg_user = $ini_array["refuse_reg_user"];
 }


 function PrintFileContent($filename)
{
$handle = fopen ($filename, "rb");
$contents = fread ($handle, filesize ($filename));
echo $contents;
fclose ($handle); 
}
if($refuse_reg_user> 0)
{
 PrintFileContent("refuse.php");
}
else
{
  PrintFileContent("reg.xml");
  
}
?>
