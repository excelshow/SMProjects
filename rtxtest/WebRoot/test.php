<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
sdfdf
 士大夫
<?
 
 echo "/444/中//";
$RootObj= new COM("RTXSAPIRootObj.RTXSAPIRootObj");
				
				$RootObj -> ServerIP= "192.168.0.100";
			  
				 $RootObj -> ServerPort= "8006";
				   echo "55";
				//print_r($RootObj);
 				//$DeptManagerObj = $RootObj->DeptManager;
				// echo urlencode(iconv('utf-8', 'gb2312', '中文部门1')); 
				  echo iconv("UTF-8","GBK//IGNORE",'中文部门1');
					 echo mb_convert_encoding('中文部门1', "GBK", "UTF-8"); 
				// $DeptManagerObj->AddUserToDept('liceshi', 'RTX 4', 'RTX测试', false);
      			// $DeptManagerObj->AddDept($fromuser,""); // 修改部门/* */
				 // echo $bb;
				  echo "1111//";
			 
				$RootObj= new COM("RTXSAPIRootObj.RTXSAPIRootObj");
				
				$RootObj -> ServerIP= "192.168.0.100";
			    echo "55";
				print_r($RootObj);
				 $RootObj -> ServerPort= "8006";
			    echo "66";
				 $UserManagerObj=  $RootObj -> UserManager;
				 
				 echo $UserManagerObj->GetUserBasicInfo('sss');
				 echo $a;
				 echo $b;
				echo "77";
				//print_r($UserManagerObj);
				echo "88";/**/
				 
			 
					
					//$strline = $my_file->get_line_by_id($splitres[$i]);
					//list($nick, $name, $dept, $pwd) = array("333,333,市场部门,ssss");
					//list($nick, $name, $dept, $pwd) =explode (',', "555,444,市场部门,000",4);
//					 print_r($UserManagerObj);
//					$UserManagerObj -> AddUser("dfdf",0);   //添加用户
//					echo "99";
					/*	$decode_pwd = base64_decode($pwd);
					$UserManagerObj -> SetUserPwd($nick,$decode_pwd); //设置用户密码
					$UserManagerObj -> SetUserBasicInfo($nick, $name, 0, "","","", 0);
					print_r($UserManagerObj);
					
					/*if ($dept != "")
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
					
					
					exit();*/
			 
 
?>
</body>
</html>