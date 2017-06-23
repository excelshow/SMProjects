<?php
header("Location: selectdept.php"); 
//header("Location: reginfo.php"); 
 /*$myroot = strtolower(getcwd());
 $ipos = strpos($myroot,"\\webroot");

 $iroot = sprintf("%s\\usermgr.cfg", $myroot);
 
 if($ipos > 0)
 {
   $iroot =  sprintf("%s\\usermgr.cfg", substr($myroot, 0, $ipos));
 }
 $ini_array = @parse_ini_file($iroot);
 print_r($ini_array);
 exit();
 $refuse_reg_user= 1;
 $allow_user_select_dept= 1;
 
 if(array_key_exists("refuse_reg_user", $ini_array))
 {
   $refuse_reg_user = $ini_array["refuse_reg_user"];
 }
 if($refuse_reg_user != 0)
{
  header("Location: refuse.php"); 
  return;
}

 if(array_key_exists("allow_user_select_dept", $ini_array))
 {
   $allow_user_select_dept = $ini_array["allow_user_select_dept"];
 }

 function PrintFileContent($filename)
{
$handle = fopen ($filename, "rb");
$contents = fread ($handle, filesize ($filename));
echo $contents;
fclose ($handle); 
}

if($allow_user_select_dept != 0)
{
  header("Location: reginfo.php"); 
}
else
{
  header("Location: selectdept.php"); 

}
*/
?>