 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
<div >用户数：{%$staffNumber%}</div>
  <form name=""  method="post">
    <table  class="treeTable" id="treeTable" bgcolor="#CCCCCC">
      <thead>
        <tr>
        
          <th bgcolor="#999999">姓名</th> 
          <th bgcolor="#999999">登录帐号</th>
           <th bgcolor="#999999">岗位</th>
          <th bgcolor="#999999">部门</th>
         
          <th bgcolor="#999999">用户状态</th>
          <th bgcolor="#999999">E-mail</th>
        </tr>
      </thead>
      <tbody>
      
      {%if ($data)%}
     
      {%foreach from=$data item=row%}
      <tr id="{%$row->id%}">
       <!-- <td><input class="all_check" type="checkbox" name="staff_id" value="{%$row->id%}"/></td>-->
        <td bgcolor="#FFFFFF">{%$row->cname%}</td>
         <td bgcolor="#FFFFFF">{%$row->itname%}</td>
 <td bgcolor="#FFFFFF">{%$row->station%} 
          </td>
        <td bgcolor="#FFFFFF"><span title="{%$row->deptOu%}">{%$row->deptname%}</span> 
        </td>
         
        <td bgcolor="#FFFFFF"> {%if $row->enabled == 1 %}
          在职
          
          {%/if%}
          {%if $row->enabled == 0 %}
          离职
          
        {%/if%} </td>
        <td bgcolor="#FFFFFF">{%$row->email%}</td>
      </tr>
      {%/foreach%}
      
      {%else%}
      <tr>
        <td colspan="6" bgcolor="#FFFFFF">暂无记录！</td>
      </tr>
      {%/if%}
        </tbody>
      
    </table>
  </form>
 </body>
</html>
   