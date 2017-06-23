<?php
	 include("Getlanguage.php"); 
	 
	 $bRet = IsChLanguage();
	 if($bRet)
	 {
		 $strAddOK = "添加用户成功";
		 $strDeleteOK = "删除用户成功";
		 $strAddFailed = "当前服务器已关闭快速部署功能，您必须先打开快速部署功能才能进行审核";
		 $strClientDeploy = "客户端部署";
		 $strAccount = "用户名";
		 $strName = "姓名";
		 $strDept = "所在部门";	
	 }
	 else
	 {
		 $strAddOK = "Add user success";
		 $strDeleteOK = "Delete user success";
		 $strAddFailed = "Quick deployment has been disabled in the current server. Please enable it first and approve the applications. ";
		 $strClientDeploy = "Client Deployment";
		 $strAccount = "User ID";
		 $strName = "Name";
		 $strDept = "Department";	
	}	 
	 
	 

	//用于操作后台文件
	class C_file{

            var $fileLines = array();

            function  read_file(){

            $fp=fopen("user.data",'r');
            
            $i = 1;
			while(!feof($fp))
			{
				$buffer=fgets($fp,4096);
			        if( strLen($buffer) == 0 ) break;

				list($nick, $name, $dept, $pwd) = explode ('|', $buffer,4);
				$oneLine = array('id' => $i,'key'=>$nick, 'content' =>$buffer);
				$i = $i + 1;
				array_push ($this->fileLines, $oneLine);


			}

			fclose($fp);
                }

            function  get_line($key){

                        foreach( $this->fileLines as $line)
		        {
                        	if( $key ==  $line['key'])
                                	return $line['content'];
		        }

             }

            function  get_line_by_id($id){

                        foreach( $this->fileLines as $line)
		        {
                        	if( $id ==  $line['id'])
                                	return $line['content'];
		        }

             }
             
             function add_delete_line($key){

             		$nLen = Count($this->fileLines);
                        for($i =  0; $i < $nLen; $i++)
                        {
                        		$line =  $this->fileLines[$i];
                                if( $line['key'] == $key)
                                {
									
				     				array_splice($this->fileLines,$i,1);
									
                                }
                        }

             }
 
              function add_delete_line_by_id($id){

             		$nLen = Count($this->fileLines);
                        for($i =  0; $i < $nLen; $i++)
                        {
                        		$line =  $this->fileLines[$i];
                                if( $line['id'] == $id)
                                {
									
				     				array_splice($this->fileLines,$i,1);
									
                                }
                        }

             }
             
			 
			function del_delete_line($key){

             		$nLen = Count($this->fileLines);
                        for($i =  0; $i < $nLen; $i++)
                        {
                        		$line =  $this->fileLines[$i];
                                if( $line['key'] == $key)
                                {
									
				     				array_splice($this->fileLines,$i,1);
									AppendUserToDeletedUserFile($line['content']); 
									
                                }
                        }

             }
             
			function del_delete_line_by_id($id){

             		$nLen = Count($this->fileLines);
                        for($i =  0; $i < $nLen; $i++)
                        {
                        		$line =  $this->fileLines[$i];
                                if( $line['id'] == $id)
                                {
									
				     				array_splice($this->fileLines,$i,1);
									AppendUserToDeletedUserFile($line['content']); 
									
                                }
                        }

             }

             function write_file(){

                $outFile = fopen("Temp.data", 'w');

                foreach( $this->fileLines as $line)
		        {
		        	fprintf($outFile,"%s",$line['content']);
		        }

                        fclose($outFile);
                        unlink("user.data");
                        rename("Temp.data", "user.data");

                        //fclose($outFile);
             }


        }

//用户IE返回按钮不出错
/*header('Expires: '.date('D,d M Y H:i:s',mktime(0,0,0,1,1,2000)).' GMT');
header('Last-Modified:'.gmdate('D,d M Y H:i:s').' GMT');
header('Cache-control: private, no-cache,must-revalidate');
header('Pragma: no-cache');*/


$str_array = "333,333,市场部门";

$AppSvrIP= "192.168.0.100" ;
$AppSvrPort = "8006";

$fileLine = array();

//获取AppServer的地址和端口
function InitAppSvrIpPort()
{
	$file_dir="..\WebApply.ini"; 
	$fp=fopen($file_dir,'r');
	while(!feof($fp))
	{
		$buffer=fgets($fp,4096);
		print_r($buffer);
		list($name, $value) = explode('=', $buffer);
		
		if ($name=="APPSvrIP" && $value != null)
		{
			global $AppSvrIP;
			$AppSvrIP = $value;
			continue;
		}
  
		if ($name=="APPSvrPort" && $value != null)
		{
			global $APPSvrPort ;
			$APPSvrPort = $value;
			
			
			continue;
		}
  
	}
	
	fclose($fp);/**/

}

//把用户添加到deleteduser.data
function AppendUserToDeletedUserFile($line)
{

	$outFile = fopen("deleteduser.data", 'a+b');
	fwrite($outFile,$line);
	fclose($outFile);

}
//从后台文件中获取用户信息
function GetUsersFromFile($path)
{
	$file_dir = $path; 
	$fp=fopen($file_dir,'r');
	while(!feof($fp))
	{
		$buffer=fgets($fp,4096);
		if( strLen($buffer) == 0 ) break;
		
		list($nick, $name, $dept, $pwd) = explode ('|', $buffer,4);
		
		$fileLine['key'] = $nick;
  
	}
	
	fclose($fp);

}

InitAppSvrIpPort();

//判断是否允许添加用户
$myroot = strtolower(getcwd());
$ipos = strpos($myroot,"\\webroot");
$iroot = sprintf("%s\\usermgr.cfg", $myroot);
if($ipos > 0)
{
   $iroot =  sprintf("%s\\usermgr.cfg", substr($myroot, 0, $ipos));
}
$ini_array = @parse_ini_file($iroot);

$refuse_reg_user= 1;
 

echo "22";
//如果允许添加用户
$refuse_reg_user = 0;
if($refuse_reg_user==0)
{
	echo "33";
	$splitres = explode(",", $str_array);
	$op = $splitres[0];
	//echo $str_array; //0|11
	 
	
	//前台提交"审核通过"的用户列表
	$op = 1;
	if($op == 1)
	{
		try{
		
				 
				echo "/444///";
				
				$RootObj= new COM("RTXSAPIRootObj.RTXSAPIRootObj");
				
				$RootObj -> ServerIP= "192.168.0.100";
			    echo "55";
				print_r($RootObj);
				 $RootObj -> ServerPort= "8006";
			    echo "66";
				 $UserManagerObj=  $RootObj -> UserManager;
				echo "77";
				//print_r($UserManagerObj);
				echo "88";
				$splitres = explode(",", "333,333,市场部门");
				 
				for($i=1;$i<3-1;$i++)
				{
					
					//$strline = $my_file->get_line_by_id($splitres[$i]);
					//list($nick, $name, $dept, $pwd) = array("333,333,市场部门,ssss");
					list($nick, $name, $dept, $pwd) =explode (',', "444,444,市场部门,000",4);
					 print_r($UserManagerObj);
					$UserManagerObj -> AddUser($nick,0);   //添加用户
					echo "99";
					$decode_pwd = base64_decode($pwd);
					$UserManagerObj -> SetUserPwd($nick,$decode_pwd); //设置用户密码
					$UserManagerObj -> SetUserBasicInfo($nick, $name, 0, "","","", 0);
					print_r($UserManagerObj);
					
					if ($dept != "")
					{
						$DeptManagerObj = $RootObj ->DeptManager;
						$DeptManagerObj -> AddUserToDept("$nick","","$dept", false);
					}
					echo $nick;
					echo "88=";
					print_r($nick);
					exit();
					$my_file->add_delete_line($nick);
					$my_file->write_file();
					
					
					exit();
				}
			}
			catch(Exception $e)
			{
						$errstr = $e->getMessage();
						
						$errstr = str_replace("<b>", "", $errstr); 
						$errstr = str_replace("</b>", "", $errstr); 
						$errstr = str_replace("<br/>", "    ", $errstr); 
						
						
						$strUserExist = "用户已经存在";
		
					global $bRet;
					if(!$bRet)
					{
						if (strstr($errstr, $strUserExist))
						{
							$errstr = "The user id has existed";
							
						}


					}
				
						echo "<script language = 'javascript'> parent.textfield2.value = \"$errstr\"; </script>";

			}

	}
	elseif($op == 0) //前台提交上来的"拒绝并删除"的用户列表
	{
		$my_file =  new C_file;
        $my_file->read_file();
		
		for($i=1;$i< count($splitres)-1;$i++)
		{

			$my_file->del_delete_line_by_id($splitres[$i]);
			
			$my_file->write_file();
			
			echo "<script language = 'javascript'> parent.textfield2.value = \"".$strDeleteOK ."\"; </script>";
		}
		
		
	}

}
else
{

	echo "<script language = 'javascript'> parent.textfield2.value = \"".$strAddFailed."\"; </script>";

	//如果服务器拒绝Web申请帐号
	//PrintFileContent("refuse.php");

}

function PrintFileContent($filename)
{
	$handle = fopen ($filename, "rb");
	$contents = fread ($handle, filesize ($filename));
	echo $contents;
	fclose ($handle); 
}

?>



<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $strClientDeploy ; ?></title>

<style>
<!--
body     { font-size: 12px }
table    { font-size: 12px }
-->
</style>

<script language = 'javascript'>
function InitList(theList, theTable, iEnd, iId, checkIt)
{
	colWidth = 0
	
	with(theList)
	{
		View = 3
		BorderStyle = 0
		GridLines = true
		Checkboxes = checkIt
		FullRowSelect = true
		Checkboxes = true;
		LabelEdit = 1

		for(var i = 0; i < iEnd; i ++)
		{
			if ( i < 2) 
			{
				colWidth = 100;
			}
			else
			{
				colWidth = (document.body.clientWidth ) -205;
			}
			
			ColumnHeaders.Add(i + 1, 'Col' + i, theTable.rows[0].cells[i].innerText, colWidth) 
		}
		
		for(var i = 1; i < theTable.rows.length; i ++)
		{
			myList.ListItems.Add( i, 'Key' + theTable.rows[i].cells[0].innerText, theTable.rows[i].cells[0].innerText)
		
			for(var j = 1; j < iEnd; j ++)
			{
			    ListItems(i).SubItems(j) = theTable.rows[i].cells[j].innerText
			}
		}
		
		Sorted = false
	}
}

</script>

<script language = 'javascript' for = 'myList' event = 'ColumnClick(ColumnHeader)'>
	if(ColumnHeader.SubItemIndex == myList.SortKey)
	{
	    if(myList.SortOrder == 0) myList.SortOrder = 1
	    else myList.SortOrder = 0
	}
	else
	{
	    myList.SortKey = ColumnHeader.SubItemIndex
	    if(myList.SortOrder == 0) myList.SortOrder = 1
		else myList.SortOrder == 0
	}
</script>

<script language = 'javascript' for = 'myList' event = 'ItemClick(Item)'>
	Item.Checked = true
</script>
 

</HEAD>

<body background="images_qk/bg_001.jpg" scroll = 'no' topmargin='0' leftmargin='0'>

<table id=myTale  border=1>
  <tr id=tablehead>
   <td id=mytd><?php echo $strAccount; ?></td>
   <td id=mytd><?php echo $strName; ?> </td>
   <td id=mytd><?php echo $strDept; ?> </td>
  </tr>
  
<?php

	$file_dir="user.data"; 
	$fp=fopen($file_dir,'r');
	while(!feof($fp))
	{
		$buffer=fgets($fp,4096);
		if( strLen($buffer) < 3 ) break;

		list($nick, $name, $dept, $pwd) = explode ('|', $buffer,4);
		echo "<tr id=mytr>\r\n";
		echo "<td id=mytd>$nick</td>\r\n";
		echo "<td id=mytd>$name</td>\r\n";
		echo "<td id=mytd>$dept</td>\r\n";
		echo "</tr>\r\n";
  
	}
	
	fclose($fp);

?>

</table>

            	
<script language = 'javascript'>
		document.write( "<object classid='clsid:BDD1F04B-858B-11D1-B16A-00C0F0283628' style = 'width:" + 500 + ";height:" + 300 + "' id='myList'></object> ")
		InitList(myList, myTale, 3, 3, false)
</script>

<form name="form1" method="POST" action="if.php" style="margin:0; padding:0">
	<input name="str_array" value="" type="hidden" />
</form>




</body></HTML>
