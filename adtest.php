<h1>LDAP��֤����</h1>
<?php
header("Content-type:text/html;charset=utf-8");
error_reporting(0);
if(!$_POST){
?>
<form action="" method="post">
    name��<input name='name' type='text' /><br />
    password��<input name='password' type='password' type='text' /><br />
    <input type='submit' value='submit'/>
</form>
<?php
} else {
    // connect to AD server
    $ldapconn = ldap_connect("10.90.18.1") or die("Could not connect to AD server.");        //����ad����
    $set = ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);    //���ò��������Ŀǰ�����˽⡣

    $ldap_bd = ldap_bind($ldapconn,"AppSystem","Semir@app");                    //��ldap����ȷ�򷵻�true����½
    var_dump($ldap_bd);
    $name = $_POST["name"] ? $_POST["name"]: "";                       //������Ҫ��֤���û���������
    $password = $_POST["password"] ? $_POST["password"]: "";
   echo $name."/".$password;
    $bd = ldap_bind($ldapconn, $name, $password)  or die ('Username or password error! 123123123');            //��֤�û��������롣

    if($bd){
        //echo "OK";
        $result = ldap_search($ldapconn,"OU=$str,dc=explame,dc=com","(|(CN=$name)(UserPrincipalName=$name))") or die ("Error in query");    //���������������������������Ҫ�鿴ad�����Ƿ��и��ֶΡ�����һ���൱��or������
        $info = ldap_get_entries($ldapconn, $result); //��ȡ��֤�û�����Ϣ
        echo "���������Ϣ��".$info[0]["distinguishedname"][0];
    } else {
        echo "Username or password error!";
    }
    ldap_close($ldapconn);//�ر�
}
?>