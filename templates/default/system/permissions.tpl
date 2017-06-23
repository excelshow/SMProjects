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
    <div class="pageTitleTop">角色权限</div>
    <div class="h10"></div>
    <form action="{%site_url('system/system/permissions')%}" method="post" accept-charset="utf-8">
      <label for="role_name_label">Role</label>
      <select name="role">
       {%foreach from=$data['roles'] item=row %} 
        <option value="{%$row->id%}"  {%if ($roleId == $row->id)%} selected="selected" {%/if%} >{%$row->name%}</option>
  		 {%/foreach%} 
      </select>
      <input type="submit" name="show" value="Show URI permissions"  />
      <label for="uri_label"></label>
      <hr/>
      
      {%foreach from=$data['conResult'] item=rowc%}
       <div style="padding-bottom:10px;">
      <input name="conTrue[]" type="checkbox" value="/{%$rowc->scUri%}/" {%if ($rowc->uriTrue == 1)%} checked="checked" {%/if%} />{%$rowc->scName%}<br />
		<div style="padding-left:20px; padding-top:5px;" >
        {%foreach from=$rowc->scPerArra item=rows%}
         <input name="{%$rows->scpValue%}" type="checkbox" value="1" {%if ($rows->scTrue == 1)%} checked="checked" {%/if%} />{%$rows->scpName%}
        {%/foreach%}
        </div>
       </div>
      {%/foreach%}
     
    <!--  <textarea name="allowed_uris"   cols="40" rows="4">{%foreach  from=$data['allowed_uris'] item=rowp key %}{%$rowp%}{%/foreach%}</textarea>-->
      <br/>
      <input type="submit" name="save" value="Save URI Permissions"  />
    </form>
  </div>
</div>
{%include file="../foot.tpl"%} 