 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>adLDAP authentication</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
<pre>
            <?php //phpinfo(); ?>
            <?php
			//   ldaps SSL test
            $con = @ldap_connect('ldaps://192.168.0.100', 636);
            ldap_set_option($con, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($con, LDAP_OPT_REFERRALS, 0);
            var_dump(@ldap_bind($con, 'administrator@lzd.com', 'a')); /*/**/ 
// die();
            ?>
 
            <?php
//header("Content-Type:  text/html; charset=utf-8");
            include (dirname(__FILE__) . "/adldap/src/adLDAP.php");//  /adldap/src//application/libraries/adldap/src
            echo dirname(__FILE__);
            ?>
 
 ////
            <?php
            $adldap = new adLDAP();
			
            if ($adldap) {
				
				$result = $adldap->folder()->delete("OU=55222,OU=Semir,DC=Semir,DC=cn");
				var_dump($result);
				// modify user
				/* $attributes=array( 
					"logon_name"=>"freds",
					"firstname"=>"Fred",
					"surname"=>"Smith",
					"company"=>"My Company",
					"department"=>"My Department",
					"email"=>"freds@mydomain.local",
					"container"=>array("Semir","Balabala"),
					"enabled"=>1,
					"password"=>"Password123",
				);
                                
                               
				$result = $adldap->user()->modify("a3",$attributes);
						var_dump($result);
                                 * 
                                 */
					// 添加组织结构  begin
						/*$aa = explode(",","Semir,森马集团");
						print_r($aa);
						$attributes = array(
							"ou_name" => "ouTestsdfd123123",
							"container"=>$aa,
						);
						$result = $adldap->folder()->create($attributes);
						var_dump($result);
						print_r($attributes);*/
					// 添加组织结构  end
					// del组织结构  begin
					/* $resultdel = $adldap->folder()->delete("OU=3333,OU=Semir,DC=lzd,DC=com");
                    var_dump($resultdel);*/
					// modify 组织结构  begin
					/*$dn = 'OU=Balabala,OU=Semir,DC=lzd,DC=com';
					 
					$newRdn = 'OU=Balabala2';
					// $newparent IS the full DN to the NEW parent DN that you want to move/rename to
					$newParent = 'OU=Semir,DC=lzd,DC=com';
					$result = @ldap_rename($adldap->getLdapConnection(), $dn, $newRdn, $newParent, true);
					var_dump($result);
                                         * 
                                         * */
                if ($adldap->authenticate("appsystem", "Semir@app")) {
                    echo "Login success!";

                   
                }

//$result=$adldap->folder()->listing(array('Semir'), adLDAP::ADLDAP_FOLDER, false);
//print_r($result);

                //$aaaa = $adldap->user()->info('lizhendong');
                //print_r($aaaa);
                // 查询 Folder 所属分类
                //$result=$adldap->folder()->listing(array("森马集团","Semir"),adLDAP::ADLDAP_FOLDER, false); ///,adLDAP::ADLDAP_FOLDER, false
                //  print_r ($result);
                //  print_r($adldap->user()->info("lizhendong"));
                //establish your session and redirect
               /* 	$attributes=array(
					  "username"=>"testing3",
					  "logon_name"=>"testing3@lzd.com",
					  "firstname"=>"李3",
					  "surname"=>"测试3",
					  "company"=>"My Company",
					  "department"=>"My Department",
					  "description"=>"说明，测试中文",
					  "email"=>"email@lzd.com",
					  "container"=>array("Semir","Server Account"),
					  "enabled"=>1,
					  "password"=>"12345678",
					  );

                  try {
                  $result = $adldap->user()->create($attributes);
                  var_dump($result);
                  }
                  catch (adLDAPException $e) {
                  echo $e;
                  //exit();
                  }  /* */
            }
            ?>
 
 ////
 
        </pre>
</body>
</html>