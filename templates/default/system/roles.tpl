{%include file="../header.tpl"%}
<script type="text/javascript">
    //<![CDATA[
    function act_on_tr(){
        $('#treeTable tr:even').addClass('even');
        $('#treeTable tr').hover(
			function () {
				$(this).addClass("hover");
			},
			function () {
				$(this).removeClass("hover");
			}
    	).click(function(){
            $('#treeTable tr').removeClass('selected');
            $(this).addClass('selected');
        });
	};
</script>
<div class=""  style=" ">
  <div class="pad10">
    <div class="pageTitleTop">角色管理</div>
    <div class="h10"></div>
    <form action="{%site_url('system/system/roles')%}" method="post" accept-charset="utf-8">
      <fieldset>
          <legend><strong>添加一个新的用户</strong></legend>
      <label for="role_parent_label">父角色：</label>
      <select name="role_parent" class="inputText">
        <option value="0">选择角色</option>
        
    
    {%foreach from=$data item=row %} 
        <option value="{%$row->id%}">{%$row->name%}</option>
  
    {%/foreach%} 
      </select>
      <label for="role_name_label">角色名称</label>
      <input type="text" name="role_name" value="" class="inputText"  />
      <input type="submit" name="add" value="添加角色" class="buttom"  />
    
      </fieldset>
      <div class="h10"></div>
     <div >
      <table id="treeTable" class="treeTable">
        <thead>
          <tr>
            <th></th>
            <th>ID</th>
            <th>Name</th>
            <th>Parent ID</th>
            <th>权限</th>
          </tr>
        </thead>
       
        {%foreach from=$data item=row %}
        <tr id="{%$row->id%}">
          <td><input type="checkbox" name="checkbox_{%$row->id%}" value="{%$row->id%}"  /></td>
          <td>{%$row->id%}</td>
          <td>{%$row->name%}</td>
          <td>{%$row->parent_id%}</td>
          <td>
            {%foreach  from=$row->allowed_uris item=rowp key %} 
        		 {%$rowp%}<br />
    		{%/foreach%}
          </td>
        </tr>
        {%/foreach%}
        
      </table>
      </div>
    </form>
     <div class="h10"></div>
      <input type="submit" name="delete" value="删除所选"  class="buttom"  />
  </div>
</div>
{%include file="../foot.tpl"%} 