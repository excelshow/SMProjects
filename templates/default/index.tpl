{%include file="./header.tpl"%}
<br />
<table class="treeTable" width="60%">
<thead><tr><th>服务器变量</th><th>属性值</th></tr></thead>
<tr><td>PHP程式版本：</td><td>{%*print_r($phpInfo)*%}{%$smarty.const.PHP_VERSION%}</td></tr>
<tr><td>ZEND版本：</td><td> {%$phpInfo['z_v']%}</td></tr>
<tr><td>MYSQL支持：</td><td>{%$phpInfo['mysqlC']%}</td></tr>
<tr><td>MySQL数据库持续连接：</td><td>{%$phpInfo['mysqlG']%}</td></tr>
<tr><td>MySQL最大连接数：</td><td>{%$phpInfo['mysqlB']%}</td></tr>
<tr><td>服务器操作系统：</td><td>{%$smarty.const.PHP_OS%}</td></tr>
<tr><td>服务器端信息：</td><td>{%$smarty.server.SERVER_SOFTWARE%}</td></tr>
<tr><td>最大上传限制：</td><td>{%$phpInfo['uploadB']%}</td></tr>
<tr><td>最大执行时间： </td><td>{%$phpInfo['exTime']%}</td></tr>
<tr><td>脚本运行占用最大内存：</td> <td>{%$phpInfo['memoryLi']%}</td></tr>
</table>
{%include file="./foot.tpl"%}