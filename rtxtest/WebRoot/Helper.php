<?php

require_once "IPLimit.php";

include 'config.php';

function PrintFileContent($filename)
{
$handle = fopen ($filename, "rb");
$contents = fread ($handle, filesize ($filename));
echo $contents;
fclose ($handle); 
}

function Error_Handler( $msg, $cnx )
{
    echo "$msg \n";
    odbc_close( $cnx);
    exit();
}

function OpenDB()
{
   include 'config.php';
	$conn = odbc_pconnect($g_ODBCConnString, $g_ODBCUserName, $g_ODBCUserPassword);
	if( ! $conn ) {
      Error_handler( "在 odbc_connect 有错误发生" , $cnx );
    }
    return $conn;
}

function ExecSQL($sql)
{ 
	$conn = OpenDB();
	$cur= odbc_exec($conn, $sql);
	if( ! $cur )
	{
        Error_handler( "在 odbc_exec 有错误发生( 没有指标传回 ) " , $cnx );
    }
    return $cur;
}


function WriteTdString($str)
{
  echo "<td bgcolor=\"FFFEEF\" noWrap>";
  echo "<FONT face=\"宋体\" size=\"2\">";
  echo $str;
  echo "</FONT></td>\n";
}


function WriteTdStringImg($str)
{
  echo "<td bgcolor=\"FFFEEF\" noWrap>";
  echo "<img align=absbottom width=16 height=16 src=\"images/blank.gif\" onload=\"RAP('$str');\" showOffline>";
  echo "<FONT face=\"宋体\" size=\"2\">";
  echo "$str</FONT></td>\n";
}

function WriteTdNormalImg($str, $imgFile, $lnk)
{
  echo "<td bgcolor=\"FFFEEF\" noWrap>";
  echo "<img align=absbottom src=\"$imgFile\" style=\"CURSOR: hand\">";
  echo "<FONT face=\"宋体\" size=\"2\">";
  echo "<a href=\"$lnk\" target=_black>";
  echo "$str</a></FONT></td>\n";
}

function WriteHideData($key, $value)
{
	echo "<INPUT id=\"$key\" style=\"VISIBILITY: hidden\" readOnly type=\"text\" name=\"$key\" value = \"$value\">";
}



function WriteUserTableHeader()
{
  include 'config.php';
  PrintFileContent($g_UserListHead);
}

function WriteUserTableFoot()
{
	include 'config.php';
	PrintFileContent($g_UserListFoot);
}

function WriteUserTable($Name, $Nick, $Gender, $Company, $Department, $Job, $Mobile, $Email, $Address, $RTXPhone)
{
	include 'config.php';

	if($Gender == 0)
	{
		$szGender = "男";
	}
	else
	{
		$szGender = "女";
	}
   echo "            <tr align=\"left\">\n";

  WriteTdStringImg($Nick);
  WriteTdString($Name);
  WriteTdString($szGender);
  
  $format = "%s%s";
  $lnk = sprintf($format, $g_HtmSendSms, $Nick);
 
   WriteTdNormalImg($Mobile, $g_ImgMobile, $lnk );
  //WriteTdString($Company);
  WriteTdString($Department);
  WriteTdString($Job);

  WriteTdString($Email);
 // WriteTdString($Address);
 // WriteTdString($RTXPhone);
 

 echo "            </tr>\n";
}




function ReadUserInfo($conn, $sql)
{
	include "config.php";
	$cur= odbc_exec($conn, $sql);
    if( ! $cur ) {
        Error_handler( "在 odbc_exec 有错误发生( 没有指标传回 ) " , $cnx );
    }

	$page = intVal($_POST["$g_PageParamName"]);
	
	//echo "page:$page\n";
	
	if(strlen($page) < 1 )
	{
		$page = 0;
	}

    WriteUserTableHeader();


	PrintUserTable($cur, $page, $g_PageNum);		
    
    WriteUserTableFoot();
    WriteHideData($g_PageParamName, $page);

   echo "</form>\n";
   echo "</BODY>\n";
   echo "</HTML>";

}

function PrintUserTable($cur, $Page, $NumPerPage)
{
   $num_row=0;
   $i = 0 ;
   while( odbc_fetch_row( $cur ) )
   {

      $num_row++;
	  if($num_row < ($Page * $NumPerPage) )
      {
		  continue;
	  }
	  $i++;
	  
	  $RTXPhone = odbc_result( $cur, 1);
	  $Nick = odbc_result( $cur, 2 );
  	  $Name = odbc_result( $cur, 3 );
	  $Mobile = odbc_result( $cur, 4);
	  $Email = 	odbc_result( $cur, 5 );
	  $Gender = odbc_result( $cur, 6 );
	  $Department = odbc_result( $cur, 7 );
	  $Company = "";
	  $Job = odbc_result( $cur, 8 );
	  $Address = "";
	 
	  WriteUserTable($Name, $Nick, $Gender, $Company, $Department, $Job, $Mobile, $Email, $Address, $RTXPhone);

     if($num_row > ($Page + 1) * $NumPerPage)
     {
  	    break;
	 }
   }
   
   if( $i < $NumPerPage) return 1;
   return 0;
}
    

?>
