<h1>LDAP验证测试</h1>
<?php
header("Content-type:text/html;charset=utf-8");
error_reporting(0);
if(!$_POST){
?>
<form action="" method="post">
    name：<input name='name' type='text' /><br />
    password：<input name='password' type='password' type='text' /><br />
    <input type='submit' value='submit'/>
</form>
<?php
} else {
    // connect to AD server
    $ldapconn = ldap_connect("10.90.18.1") or die("Could not connect to AD server.");        //连接ad服务
    $set = ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);    //设置参数，这个目前还不了解。

    $ldap_bd = ldap_bind($ldapconn,"AppSystem","Semir@app");                    //打开ldap，正确则返回true。登陆
    var_dump($ldap_bd);
    $name = $_POST["name"] ? $_POST["name"]: "";                       //接受需要认证的用户名和密码
    $password = $_POST["password"] ? $_POST["password"]: "";
   echo $name."/".$password;
    $bd = ldap_bind($ldapconn, $name, $password)  or die ('Username or password error! 123123123');            //验证用户名和密码。

    if($bd){
        //echo "OK";
        $result = ldap_search($ldapconn,"OU=$str,dc=explame,dc=com","(|(CN=$name)(UserPrincipalName=$name))") or die ("Error in query");    //根据条件搜索，我这边搜索的是要查看ad域中是否有改字段。这是一个相当于or的搜索
        $info = ldap_get_entries($ldapconn, $result); //获取认证用户的信息
        echo "您的相关信息：".$info[0]["distinguishedname"][0];
    } else {
        echo "Username or password error!";
    }
    ldap_close($ldapconn);//关闭
}
?>