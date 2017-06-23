<select class="inputText" name="ip1" id="ip1">
<option value="">不分配</option>
 {%foreach from=$ipList item=item key=key%}
	 <option value="{%$item%}">{%$item%}</option>
 {%/foreach%}
</select>