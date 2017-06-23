<?php
session_start();
include (dirname(__FILE__) . "/../src/adLDAP.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>adLDAP authentication</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>

<p>If you called authenticate.php and you are redirected to this page, you successfully authenticated against Active Directory with your credentials.</p>

User Details for <?php echo $_SESSION['username']; ?><br />
<pre>
<?php
//print_r($_SESSION['userinfo']);
$adldap =new adLDAP();
if($adldap)
{
    echo "登录成功<br>";
	$result = $adldap->user()->groups($_SESSION['username']);
	print_r($result);
	foreach($result as $val)
	{
	  echo $val."<br>";
	}
	
	echo "///////////////////////////<br>";
	 // $result=$adldap->folder()->listing(array('Semir'), adLDAP::ADLDAP_FOLDER, false);
     //var_dump ($result);   
	 echo "user ifno1<br>";
	 $collection = $adldap->user()->infoCollection("fengxiaoning");
		//print_r( $collection);
	 echo "user info2<br>";
	//	print_r($collection);
	 print_r($collection->displayName);
		
	
	$result = $adldap->user()->info("lizhendong",array("pwdlastset", "useraccountcontrol"));
	print_r($result[0]['useraccountcontrol'][0]);
	
	 
echo "<br>////////////user info3<br>";
	$result=$adldap->folder()->listing(array('Semir')); ///,adLDAP::ADLDAP_FOLDER, false
    //print_r ($result);
	if ($result) {
			foreach ($result as $index => $entry) {
				$child_dn = $entry['dn'];
				 echo $child_dn."<br>";
			}
		}
	 
	$b = "OU=Semir";
	$c = '';
	foreach($result as $val)
	{
	
	 $a = explode(",",$val['dn']);
	   print_r($a); 
	// echo $a[0];
	$aa = explode("=",$a[0]);
	if ($aa[0] == "CN"){
	}else{
	 if( in_array($b,$a)){
    	$c .= " --// ";
		$b = $a[0];
	 }else{
		 $b = $a[0];
		 $c .= '';
		 }
	 echo $c;
	 echo $b;
	 //echo $val['dn'];
	 echo "-------11111111111111111<br>";
	}
	}
	// $result=$adldap->folder()->listing(array('森马集团','Semir'), adLDAP::ADLDAP_FOLDER, false);
   // var_dump ($result);
	// $result=$adldap->folder()->listing(array('浙江森马服饰股份有限公司','森马集团','Semir'), adLDAP::ADLDAP_FOLDER, false);
   // var_dump ($result);  
		//print_r($collection->description);
			
	 
	//var_dump($result);
	//print_r($result);
	   
}
else
{
    echo "登录失败";
}

function list_to_tree($list, $pk='id',$pid = 'pid',$child = '_child',$root="a")
{
    // 创建Tree
    $tree = array();
    if(is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] =& $list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId = $data[$pid];
            if ($root == $parentId) {
                $tree[] =& $list[$key];
            }else{
                if (isset($refer[$parentId])) {
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }
        }
    }
    return $tree;
}

$arr = array(
1 => array('id'=>"aa",'pid'=>"a"),
2 => array('id'=>"bb",'pid'=>"bb",'pid'=>"aa"),
3 => array('id'=>"cc",'pid'=>"cc",'pid'=>"bb",'pid'=>"aa"),
4 => array('id'=>"dd",'pid'=>"dd",'pid'=>"cc",'pid'=>"bb",'pid'=>"aa")
);
$tree = list_to_tree($arr); 
print_r($tree);
 echo "<b>All users</b><br>";

 
?>
</pre>

</body>
</html>