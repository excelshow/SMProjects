{%include file="../header.tpl"%}
<br />
<table class="treeTable" width="57%">
<thead><tr>
    <th width="31%">工具名称</th>
    <th width="69%">操作</th></tr></thead>
<tr>
  <td>用户账号导出(Itname/Cname/station/jobnumber/Moblie/Location/DeptOu)</td>
  <td><a href="{%site_url('mtools/doStaffMain')%}">导出（格式EXCEL）</a></td></tr>
<tr>
  <td>资产/IT账号导出(Itname/Cname/SmsNumber/Location/DeptOu)</td>
  <td><a href="{%site_url('mtools/doStaffSms')%}">导出（格式EXCEL）</a>
  </td>
</tr>
<tr>
  <td>用户权限导出(Itname/Cname/System)</td>
  <td><a href="{%site_url('mtools/doStaffSystem')%}">导出（格式EXCEL）</a>
  </td>
 </tr>
<tr>
  <td>部门用户账号导出(Itname)，加部门ID号</td>
  <td><a href="{%site_url('mtools/searchByDeptId')%}">导出（格式EXCEL）</a> /mtools/searchByDeptId/num</td>
</tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td> <td>&nbsp;</td></tr>
</table>
{%include file="../foot.tpl"%}