<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>adLDAP authentication</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
 
 <pre>
<?php
//header("Content-Type:  text/html; charset=utf-8");
include (dirname(__FILE__) . "/adldap/src/adLDAP.php");
echo dirname(__FILE__);
 ?>
 
 ////
<?php
/*$config = array(
"digest_alg" => "lzd",
"private_key_bits" => 1024,
"private_key_type" => OPENSSL_KEYTYPE_RSA,
"encrypt_key" => false
);*/

//$privkey = openssl_pkey_new($config);
//openssl_pkey_export($privkey, $keydata);
//echo $keydata;
 
$adldap =new adLDAP();
 
       // $parameters = $request->output_parameters();

      //  $where = "itname =  '" . $parameters[0] . "'";
      /*  $this->load->library('adldaplibrary');
        $adldap = new adLDAP();
        $loginTrue = $adldap->user()->authenticate("lizhendong", "lizd11");
        if ($loginTrue){
		 echo '1212122';
        }else{
           echo 'sdfsdf';
        }
         
 exit();*/
if($adldap)
{
	// print_r($adldap->user()->info("Administrator"));
			
	if ($adldap->authenticate("Administrator", "a")){
		echo "Login success!";
			//establish your session and redirect
			$attributes=array(
					"username"=>"lizd3",
					"logon_name"=>"lizd3@lzd.com",
					"firstname"=>"lizd3",
					"surname"=>"Smith",
					"company"=>"My Company",
					"department"=>"My Department",
					"email"=>"lizd3@lzd.com",
					"container"=>array("Semir","森马集团"),
					"enabled"=>1,
					"password"=>"Passw@rd",
				);
				
				 try {
				//	$result = $adldap->user()->create($attributes);
				//	var_dump($result);
				}
				catch (adLDAPException $e) {
					echo $e;
					exit();   
				} /**/
			 
           
 
    }
	
 ?>
 
 ////
<?php

 	$aaaa = $adldap->user()->find(false,'CN','Users');
	//print_r($aaaa);
	// 查询 Folder 所属分类
	$result=$adldap->folder()->listing(array("Semir"),adLDAP::ADLDAP_FOLDER, false); ///,adLDAP::ADLDAP_FOLDER, false
      print_r ($result);
	$b = "OU=Semir";
 	 $bbc = array();
	 // print_r($result); 
	foreach($result as $val) //as $val
	{
	// print_r($val['dn']);
	 if ($val['dn']){
	  
	 $a = explode(",",$val['dn']);
	  
	 
 	 $bbc[]= array('id'=>$a[0],'pid'=>$a[1],'data'=>$a[0]);
	  }
 	}
	print_r($bbc);

//$treea = list_to_tree($bbc,"id","pid","children","OU=Semir"); 
//print_r($treea);
//echo json_encode($treea);
function list_to_tree($list, $pk='id',$pid = 'pid',$child = 'children',$root="OU=Semir")
{
    // 创建Tree
    $tree = array();
    if(is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
			 
            $refer[$data[$pk]] = & $list[$key];// array($pk=>$list[$key][$pk],$pid =>$list[$key][$pid]);
			 //print_r($refer);
        }

        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId = $data[$pid];
            if ($root == $parentId) {
                $tree[] = & $list[$key]; //array($pk=>$list[$key][$pk],$pid =>$list[$key][$pid]); 
				 
            }else{
				 
                if (isset($refer[$parentId])) {
					 
                    $parent = & $refer[$parentId];
					//print_r($refer[$parentId]);
                    $parent[$child][] = & $list[$key]; //array('id'=>$list[$key]['id'],'data' =>$list[$key]['pid']);
                }
            }
        }
    }
	//print_r($tree);
    return $tree;
	//return "sdfsdf";
}

$arr = array(
0 => array('id'=>"OU=信息部（上海）",'pid'=>'aa'),
1 => array('id'=>"bb",'pid'=>"OU=信息部（上海）"),
/*2 => array('id'=> "OU=浙江森马服饰股份有限公司",'pid' => 'aa'),
4 => array('id'=> "OU=人力资源中心",'pid' => "OU=浙江森马服饰股份有限公司"),
5 => array('id'=> "OU=人力资源规划部",'pid' => "OU=人力资源中心"),
6 => array('id'=>"cc",'pid'=>"bb"),
7 => array('id'=>"dd",'pid'=>"cc")*/
);
//print_r($arr);
$tree = list_to_tree($arr,"id","pid","children","aa"); 
print_r($tree);
 foreach ($tree as $key => $data) {
			  print_r($data);
        }
	// $result=$adldap->folder()->listing(array('森马集团','Semir'), adLDAP::ADLDAP_FOLDER, false);
   // var_dump ($result);
	// $result=$adldap->folder()->listing(array('浙江森马服饰股份有限公司','森马集团','Semir'), adLDAP::ADLDAP_FOLDER, false);
   // var_dump ($result);  
		//print_r($collection->description);
			
	 
	//var_dump($result);
	//print_r($result);
	//echo "</root>";
	   
}
 

 
?>
 </pre>

</body>
</html>