
<div style="padding:5px;" >共有记录： {%count($data)%} 条</div>
<table  class="treeTable" id="treeTable">
  <thead>
    <tr>
      <th>姓名</th>
      <th>登录帐号</th>
      <th>部门</th>
      <th>用户状态</th>
    </tr>
  </thead>
  <tbody>
  
  {%if ($data)%}
  {%foreach from=$data item=row%}
  {%if ($row->id ==0)%}
   <tr>
    <td colspan="6">无此用户信息</td>
  </tr>
  {%else%}
  <tr id=" ">
    <td>{%$row->cname%}</td>
    <td>{%$row->itname%}</td>
    <td> {%if $row->deptOu%}
      {%implode(" &raquo; ", $row->deptOu)%}
      {%else%}
      暂无部门
      {%/if%} </td>
    <td> {%if $row->enabled == 1 %}
      活跃
      
      {%/if%}
      {%if $row->enabled == 0 %}
      禁用
      
      {%/if%} </td>
  </tr>
  {%/if%}
  {%/foreach%}
  
  {%else%}
  <tr>
    <td colspan="6">无查询结果</td>
  </tr>
  {%/if%}
    </tbody>
  
</table>
